<?php

namespace App\Controllers;

use App\Models\MatchModel;
use App\Models\MatchPlayerModel;
use App\Models\MatchScoreModel;
use App\Models\SchedulesModel;
use App\Models\PlayersModel;

class Matches extends BaseController
{
    protected $matchModel;
    protected $matchPlayerModel;
    protected $matchScoreModel;
    protected $schedulesModel;
    protected $playersModel;

    public function __construct()
    {
        $this->matchModel = new MatchModel();
        $this->matchPlayerModel = new MatchPlayerModel();
        $this->matchScoreModel = new MatchScoreModel();
        $this->schedulesModel = new SchedulesModel();
        $this->playersModel = new PlayersModel();
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
        if (count($scoreA) !== count($scoreB) || count($scoreA) === 0) {
            session()->setFlashdata('error', 'Skor harus diisi minimal 1 Game, dan jumlah skor Tim A dan B harus sama.');
            return redirect()->back()->withInput();
        }

        // Tentukan Pemenang Keseluruhan
        $winnerTeam = array_sum($scoreA) > array_sum($scoreB) ? 'A' : (array_sum($scoreB) > array_sum($scoreA) ? 'B' : null);
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
            'status'      => 'Completed', // Asumsi setelah input skor, match selesai
            'winner_team' => $winnerTeam,
        ]);
        $matchId = $this->matchModel->getInsertID();

        // Update status jadwal menjadi Completed jika match selesai
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

        // 3. Simpan ke match_scores (Skor per Game)
        $dataScores = [];
        for ($i = 0; $i < count($scoreA); $i++) {
            // Hanya simpan game jika skor diisi untuk kedua tim
            if (!empty($scoreA[$i]) && !empty($scoreB[$i])) {
                $dataScores[] = [
                    'match_id'     => $matchId,
                    'game_number'  => $i + 1,
                    'team_a_score' => $scoreA[$i],
                    'team_b_score' => $scoreB[$i],
                ];
            }
        }
        $this->matchScoreModel->insertBatch($dataScores);

        // --- Selesaikan Transaksi ---
        $this->matchModel->db->transComplete();

        if ($this->matchModel->db->transStatus() === false) {
            session()->setFlashdata('error', 'Gagal menyimpan hasil pertandingan secara keseluruhan.');
            return redirect()->back();
        }

        session()->setFlashdata('success', 'Hasil pertandingan berhasil disimpan (3 tabel diperbarui)!');
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
        $matchPlayersData = $this->matchPlayerModel->where('match_id', $matchId)->findAll();
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

        $winnerTeam = array_sum($scoreA) > array_sum($scoreB) ? 'A' : (array_sum($scoreB) > array_sum($scoreA) ? 'B' : null);
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

        // 3. UPDATE match_scores (Hapus lama, Tambah baru)
        $this->matchScoreModel->where('match_id', $matchId)->delete();

        $dataScores = [];
        for ($i = 0; $i < count($scoreA); $i++) {
            if (!empty($scoreA[$i]) && !empty($scoreB[$i])) {
                $dataScores[] = [
                    'match_id'     => $matchId,
                    'game_number'  => $i + 1,
                    'team_a_score' => $scoreA[$i],
                    'team_b_score' => $scoreB[$i],
                ];
            }
        }
        $this->matchScoreModel->insertBatch($dataScores);

        // --- Selesaikan Transaksi ---
        $this->matchModel->db->transComplete();

        if ($this->matchModel->db->transStatus() === false) {
            session()->setFlashdata('error', 'Gagal memperbarui hasil pertandingan secara keseluruhan.');
            return redirect()->back();
        }

        session()->setFlashdata('success', 'Hasil pertandingan berhasil diperbarui!');
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

        // Menghapus baris matches, yang akan cascade menghapus match_players & match_scores
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
