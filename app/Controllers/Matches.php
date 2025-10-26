<?php

namespace App\Controllers;

use App\Models\MatchModel;
use App\Models\MatchPlayerModel;
use App\Models\MatchScoreModel;
use App\Models\SchedulesModel;
use App\Models\PlayersModel;
use App\Models\PlayerRankPointModel;

class Matches extends BaseController
{
    protected $matchModel;
    protected $matchPlayerModel;
    protected $matchScoreModel;
    protected $schedulesModel;
    protected $playersModel;
    protected $playerRankPointModel;

    public function __construct()
    {
        $this->matchModel = new MatchModel();
        $this->matchPlayerModel = new MatchPlayerModel();
        $this->matchScoreModel = new MatchScoreModel();
        $this->schedulesModel = new SchedulesModel();
        $this->playersModel = new PlayersModel();
        $this->playerRankPointModel = new PlayerRankPointModel();
    }

    private function getMatchPlayersData($matchId)
    {
        $players = $this->matchPlayerModel->getPlayersByMatch($matchId);
        $teams = ['A' => [], 'B' => []];
        foreach ($players as $p) {
            $teams[$p['team']][] = $p['player_name'];
        }
        return $teams;
    }

    // ==================================================
    // LOGIKA SINKRONISASI POIN OTOMATIS
    // ==================================================
    private function syncPlayerRankPoints($scheduleId, $matchId, $roundReached)
    {
        $scheduleData = $this->schedulesModel->getScheduleWithPoints($scheduleId);
        $matchPlayers = $this->matchPlayerModel->where('match_id', $matchId)->findAll();
        $match = $this->matchModel->find($matchId);
        $winnerTeam = $match['winner_team'];

        // Map Poin Master
        $pointsMap = [
            'R1'    => 'points_r1',
            'R2'    => 'points_r2',
            'QF'    => 'points_qf',
            'SF'    => 'points_sf',
            'Final' => 'points_runnerup',
        ];

        $dataRank = [];
        foreach ($matchPlayers as $player) {

            $isChampion = ($roundReached === 'Final' && $player['team'] === $winnerTeam);

            // Tentukan Poin Akhir yang Diperoleh
            if ($isChampion) {
                $pointsEarned = $scheduleData['points_champion'] ?? 0;
                $stageText = 'CHAMPION';
            } else {
                // Untuk Finalis (Runner-up) dan babak lainnya
                $stageKey = $pointsMap[$roundReached] ?? 'points_r1';
                $pointsEarned = $scheduleData[$stageKey] ?? 0;
                $stageText = $roundReached;
            }

            // --- Hapus Entri Lama (Untuk Kunci Unik schedule_id dan player_id) ---
            $this->playerRankPointModel
                ->where('schedule_id', $scheduleId)
                ->where('player_id', $player['player_id'])
                ->delete();

            // --- Simpan Poin Baru ---
            $dataRank[] = [
                'schedule_id'   => $scheduleId,
                'player_id'     => $player['player_id'],
                'stage_reached' => $stageText,
                'points_earned' => $pointsEarned,
            ];
        }

        if (!empty($dataRank)) {
            $this->playerRankPointModel->insertBatch($dataRank);
        }
    }

    // ==================================================
    // READ: TAMPILKAN SEMUA PERTANDINGAN (PER JADWAL)
    // ==================================================
    public function index($scheduleId = null)
    {
        $schedule = $this->schedulesModel->find($scheduleId);

        if (!$schedule || !$scheduleId) {
            session()->setFlashdata('error', 'Jadwal pertandingan tidak valid atau tidak ditemukan.');
            return redirect()->to(site_url('admin/schedules'));
        }

        $allMatches = $this->matchModel->where('schedule_id', $scheduleId)->findAll();

        $matchesData = [];
        foreach ($allMatches as $match) {
            $matchId = $match['id'];
            $matchesData[] = [
                'match'         => $match,
                'match_players' => $this->getMatchPlayersData($matchId),
                'match_scores'  => $this->matchScoreModel->where('match_id', $matchId)->findAll(),
            ];
        }

        $data = [
            'title'       => 'Daftar Pertandingan & Hasil',
            'schedule_id' => $scheduleId,
            'schedule'    => $schedule,
            'all_matches' => $matchesData,
            'is_empty'    => empty($allMatches),
        ];

        echo view('templates/table_header', $data);
        echo view('templates/sidebar');
        echo view('templates/topbar');
        echo view('matches/index', $data);
        echo view('templates/table_footer');
    }

    // ==================================================
    // CREATE: FORM TAMBAH PERTANDINGAN BARU (a_match)
    // ==================================================
    public function a_match($scheduleId)
    {
        if (!$this->schedulesModel->find($scheduleId)) {
            session()->setFlashdata('error', 'Jadwal pertandingan tidak ditemukan.');
            return redirect()->to(site_url('admin/schedules'));
        }

        $data = [
            'title'       => 'Input Pertandingan Baru (Ganda)',
            'schedule_id' => $scheduleId,
            'players'     => $this->playersModel->findAll(),
            'validation'  => \Config\Services::validation(),
            'rounds'      => ['R1', 'R2', 'QF', 'SF', 'Final'],
        ];

        echo view('templates/table_header', $data);
        echo view('templates/sidebar');
        echo view('templates/topbar');
        echo view('matches/a_match', $data);
        echo view('templates/table_footer');
    }

    // ==================================================
    // CREATE: SIMPAN DATA (Transaksi ke 3 Tabel)
    // ==================================================
    public function store()
    {
        $scheduleId = $this->request->getPost('schedule_id');
        $playerA = $this->request->getPost('player_A');
        $playerB = $this->request->getPost('player_B');
        $scoreA = $this->request->getPost('score_A');
        $scoreB = $this->request->getPost('score_B');
        $round = $this->request->getPost('round');

        $playerIds = array_merge($playerA, $playerB);

        // --- Validasi Data ---
        if (count($playerIds) !== count(array_unique($playerIds))) {
            session()->setFlashdata('error', 'Setiap pemain harus unik (tidak ada duplikasi di dalam 4 pemain).');
            return redirect()->back()->withInput();
        }

        // Perbaikan: Hanya cek array score sudah terisi
        if (empty($scoreA[0]) || empty($scoreB[0])) {
            session()->setFlashdata('error', 'Harap isi Games Won Tim A dan Tim B.');
            return redirect()->back()->withInput();
        }

        // Tentukan Pemenang Keseluruhan (Berdasarkan Games Won yang diinput)
        $winnerTeam = $scoreA[0] > $scoreB[0] ? 'A' : ($scoreB[0] > $scoreA[0] ? 'B' : null);
        if ($winnerTeam === null) {
            session()->setFlashdata('error', 'Skor total tidak boleh seri (Draw).');
            return redirect()->back()->withInput();
        }

        // --- Mulai Transaksi ---
        $this->matchModel->db->transStart();

        // 1. Simpan ke matches (Induk)
        $this->matchModel->save([
            'schedule_id' => $scheduleId,
            'round'       => $round,
            'status'      => 'Completed',
            'winner_team' => $winnerTeam,
        ]);
        $matchId = $this->matchModel->getInsertID();

        // Update status jadwal menjadi Completed
        $this->schedulesModel->update($scheduleId, ['status' => 'Completed']);

        // 2. Simpan ke match_players (4 Pemain)
        $dataPlayers = [];
        foreach (['A' => $playerA, 'B' => $playerB] as $teamSide => $players) {
            foreach ($players as $playerId) {
                $dataPlayers[] = [
                    'match_id'  => $matchId,
                    'player_id' => $playerId,
                    'team'      => $teamSide,
                ];
            }
        }
        $this->matchPlayerModel->insertBatch($dataPlayers);

        // 3. Simpan ke match_scores (Skor Games Won)
        $dataScores = [
            [
                'match_id'     => $matchId,
                'game_number'  => 1, // Menyimpan Games Won
                'team_a_score' => (int)$scoreA[0],
                'team_b_score' => (int)$scoreB[0],
            ]
        ];
        $this->matchScoreModel->insertBatch($dataScores);

        // --- Selesaikan Transaksi ---
        $this->matchModel->db->transComplete();

        if ($this->matchModel->db->transStatus() === false) {
            session()->setFlashdata('error', 'Gagal menyimpan hasil pertandingan secara keseluruhan.');
            return redirect()->back();
        }

        $this->syncPlayerRankPoints($scheduleId, $matchId, $round);

        session()->setFlashdata('success', 'Hasil pertandingan berhasil disimpan dan ranking poin disinkronkan!');
        return redirect()->to(site_url('admin/matches/' . $scheduleId));
    }

    // ==================================================
    // UPDATE: FORM EDIT PERTANDINGAN (e_match)
    // ==================================================
    public function e_match($matchId = null)
    {
        $match = $this->matchModel->find($matchId);

        if (!$match) {
            session()->setFlashdata('error', 'Data pertandingan tidak ditemukan.');
            return redirect()->back();
        }

        // --- Mengambil Data Anak ---
        // Perbaikan: Gunakan getPlayersByMatch dari Model
        $matchPlayersData = $this->matchPlayerModel->getPlayersByMatch($matchId);

        $matchScoresData = $this->matchScoreModel->where('match_id', $matchId)->findAll();
        $allPlayers = $this->playersModel->findAll();

        // Mengatur ulang data pemain agar mudah diakses di view
        $playersA = array_filter($matchPlayersData, fn($p) => $p['team'] === 'A');
        $playersB = array_filter($matchPlayersData, fn($p) => $p['team'] === 'B');

        $data = [
            'title'             => 'Edit Hasil Pertandingan Ganda',
            'match'             => $match,
            'schedule_id'       => $match['schedule_id'],
            'validation'        => \Config\Services::validation(),
            'rounds'            => ['R1', 'R2', 'QF', 'SF', 'Final'],
            'players'           => $allPlayers,
            'match_players_A'   => array_values($playersA),
            'match_players_B'   => array_values($playersB),
            'match_scores'      => $matchScoresData,
            'statuses'          => ['Not Started', 'In Progress', 'Completed'],
            'teams'             => ['A', 'B'],
        ];

        echo view('templates/table_header', $data);
        echo view('templates/sidebar');
        echo view('templates/topbar');
        echo view('matches/e_match', $data);
        echo view('templates/table_footer');
    }

    // ==================================================
    // UPDATE: SIMPAN PERUBAHAN PERTANDINGAN (LOGIKA 3 TABEL)
    // ==================================================
    public function update($matchId = null)
    {
        $match = $this->matchModel->find($matchId);

        if (!$match) {
            session()->setFlashdata('error', 'Data pertandingan tidak ditemukan.');
            return redirect()->back();
        }

        $scheduleId = $match['schedule_id'];

        $playerA = $this->request->getPost('player_A');
        $playerB = $this->request->getPost('player_B');
        $scoreA = $this->request->getPost('score_A');
        $scoreB = $this->request->getPost('score_B');
        $round = $this->request->getPost('round');
        $status = $this->request->getPost('status');

        $playerIds = array_merge($playerA, $playerB);

        // [VALIDASI DASAR & LOGIKA]
        if (count($playerIds) !== count(array_unique($playerIds))) {
            session()->setFlashdata('error', 'Setiap pemain harus unik.');
            return redirect()->back()->withInput();
        }

        // Tentukan Pemenang
        $winnerTeam = $scoreA[0] > $scoreB[0] ? 'A' : ($scoreB[0] > $scoreA[0] ? 'B' : null);
        if ($winnerTeam === null) {
            session()->setFlashdata('error', 'Skor total tidak boleh seri (Draw).');
            return redirect()->back()->withInput();
        }

        // --- Mulai Transaksi Update ---
        $this->matchModel->db->transStart();

        // 1. UPDATE matches (Induk)
        $this->matchModel->update($matchId, [
            'round'       => $round,
            'status'      => $status,
            'winner_team' => $winnerTeam,
        ]);

        // Update status jadwal (jika match completed)
        if ($status === 'Completed') {
            $this->schedulesModel->update($scheduleId, ['status' => 'Completed']);
        } else {
            $this->schedulesModel->update($scheduleId, ['status' => $status]);
        }


        // 2. UPDATE match_players (Hapus lama, Tambah baru)
        $this->matchPlayerModel->where('match_id', $matchId)->delete();

        $dataPlayers = [];
        foreach (['A' => $playerA, 'B' => $playerB] as $teamSide => $players) {
            foreach ($players as $playerId) {
                $dataPlayers[] = [
                    'match_id'  => $matchId,
                    'player_id' => $playerId,
                    'team'      => $teamSide,
                ];
            }
        }
        $this->matchPlayerModel->insertBatch($dataPlayers);

        // 3. UPDATE match_scores (Hapus lama, Tambah baru Games Won)
        $this->matchScoreModel->where('match_id', $matchId)->delete();

        $dataScores = [
            [
                'match_id'     => $matchId,
                'game_number'  => 1,
                'team_a_score' => (int)($scoreA[0] ?? 0),
                'team_b_score' => (int)($scoreB[0] ?? 0),
            ]
        ];
        $this->matchScoreModel->insertBatch($dataScores);

        // --- Selesaikan Transaksi ---
        $this->matchModel->db->transComplete();

        if ($this->matchModel->db->transStatus() === false) {
            session()->setFlashdata('error', 'Gagal memperbarui hasil pertandingan secara keseluruhan.');
            return redirect()->back();
        }

        $this->syncPlayerRankPoints($scheduleId, $matchId, $round);

        session()->setFlashdata('success', 'Hasil pertandingan berhasil diperbarui dan ranking poin disinkronkan!');
        return redirect()->to(site_url('admin/matches/' . $scheduleId));
    }


    // ==================================================
    // DELETE: HAPUS PERTANDINGAN
    // = =================================================
    public function d_match($matchId = null)
    {
        $match = $this->matchModel->find($matchId);

        if (!$match) {
            session()->setFlashdata('error', 'Pertandingan tidak ditemukan.');
            return redirect()->back();
        }

        $scheduleId = $match['schedule_id'];

        // 1. Hapus Poin Ranking terkait DULU
        $matchPlayers = $this->matchPlayerModel->where('match_id', $matchId)->findAll();
        foreach ($matchPlayers as $player) {
            $this->playerRankPointModel
                ->where('schedule_id', $scheduleId)
                ->where('player_id', $player['player_id'])
                ->delete();
        }

        // 2. Hapus Match (akan cascade menghapus match_players & match_scores)
        $deleted = $this->matchModel->delete($matchId);

        if ($deleted) {
            // Update status jadwal kembali ke Scheduled
            $this->schedulesModel->update($scheduleId, ['status' => 'Scheduled']);
            session()->setFlashdata('success', 'Entitas pertandingan berhasil dihapus!');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus entitas pertandingan.');
        }

        return redirect()->to(site_url('admin/matches/' . $scheduleId));
    }
}
