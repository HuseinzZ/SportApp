<?php

namespace App\Controllers;

use App\Models\PlayerRankPointModel;
use App\Models\PlayersModel;
use App\Models\MatchPlayerModel;
use App\Models\GalleryModel;
use App\Models\MatchModel;
use App\Models\SchedulesModel;
use App\Models\MatchScoreModel;

class Home extends BaseController
{
    protected $playerRankPointModel;
    protected $playersModel;
    protected $matchPlayerModel;
    protected $galleryModel;
    protected $matchModel;
    protected $schedulesModel;
    protected $matchScoreModel;

    public function __construct()
    {
        $this->playerRankPointModel = new PlayerRankPointModel();
        $this->playersModel = new PlayersModel();
        $this->matchPlayerModel = new MatchPlayerModel();
        $this->galleryModel = new GalleryModel();
        $this->matchModel = new MatchModel();
        $this->schedulesModel = new SchedulesModel();
        $this->matchScoreModel = new MatchScoreModel();
    }

    public function index()
    {
        $selectedLevel = $this->request->getGet('level');
        $search = $this->request->getGet('search');
        $ranking = $this->playerRankPointModel->getGlobalRanking($selectedLevel, $search);
        $playerIds = array_column($ranking, 'player_id');
        if (!empty($playerIds)) {
            $playerDetails = array_column($this->playersModel->whereIn('id', $playerIds)->findAll(), null, 'id');
        } else {
            $playerDetails = [];
        }

        $playerStats = [];

        foreach ($ranking as $key => $rankItem) {
            $playerId = $rankItem['player_id'];
            $stats = $this->matchPlayerModel->getPlayerMatchStats($playerId);

            $totalMatch = $stats['Total_Match'] ?? 0;
            $totalMenang = $stats['Total_Menang'] ?? 0;

            if ($totalMatch > 0) {
                $winRate = round(($totalMenang / $totalMatch) * 100);
            } else {
                $winRate = 0;
            }

            $playerStats[$playerId] = [
                'win_rate' => $winRate,
                'total_match' => $totalMatch,
            ];

            $ranking[$key]['win_rate'] = $winRate;
        }

        $data = [
            'title'         => 'Daftar Peringkat',
            'ranking'       => $ranking,
            'playerDetails' => $playerDetails,
            'selectedLevel' => $selectedLevel,
            'search'        => $search,
        ];

        echo view('templates/header', $data);
        echo view('templates/public_sidebar');
        echo view('templates/public_topbar');
        echo view('public_site/leaderboard', $data);
        echo view('templates/footer');
    }

    public function matchHistory($playerId = null)
    {
        $player = $this->playersModel->find($playerId);

        if (!$player) {
            session()->setFlashdata('error', 'Pemain tidak ditemukan.');
            return redirect()->to(site_url('/'));
        }
        $matchStats = $this->matchPlayerModel->getPlayerMatchStats($playerId);
        $history = $this->matchPlayerModel->getRecentMatchHistory($playerId);
        $totalPointsResult = $this->playerRankPointModel->getPlayerTotalPoints($playerId);
        $totalPoints = $totalPointsResult['total_points'] ?? 0;
        $rankingGlobal = $this->playerRankPointModel->getGlobalRanking();

        $totalMatch = $matchStats['Total_Match'] ?? 0;
        $totalMenang = $matchStats['Total_Menang'] ?? 0;
        $totalKalah = $matchStats['Total_Kalah'] ?? 0;

        $winRate = ($totalMatch > 0) ? round(($totalMenang / $totalMatch) * 100) : 0;

        $rank = array_search($playerId, array_column($rankingGlobal, 'player_id'));
        $rankingDisplay = ($rank !== false) ? $rank + 1 : null;

        $playerStats = [
            'ranking'       => $rankingDisplay,
            'poin'          => $totalPoints,
            'win_rate'      => $winRate,
            'total_match'   => $totalMatch,
            'menang'        => $totalMenang,
            'kalah'         => $totalKalah,
        ];

        $data = [
            'title'         => 'Statistik Pemain: ' . $player['player_name'],
            'player'        => $player,
            'playerStats'   => $playerStats,
            'history'       => $history,
        ];

        echo view('templates/header', $data);
        echo view('templates/public_sidebar');
        echo view('templates/public_topbar');
        echo view('public_site/statistic_player', $data);
        echo view('templates/footer');
    }

    public function gallery()
    {
        $selectedTitle = $this->request->getGet('title');
        $galleryModel = $this->galleryModel;

        $data = [
            'title' => 'Galeri Kegiatan',
            'selectedTitle' => $selectedTitle,
        ];

        if ($selectedTitle) {
            // --- MODE DETAIL ALBUM (Title Ditetapkan) ---

            // Ambil SEMUA foto yang cocok dengan title
            $photos = $galleryModel->where('title', $selectedTitle)->findAll();

            if (empty($photos)) {
                session()->setFlashdata('error', 'Album atau foto tidak ditemukan.');
                return redirect()->to(site_url('gallery'));
            }

            $data['title'] = 'Album: ' . esc($selectedTitle);
            $data['photos'] = $photos;

            // Gunakan view yang menampilkan foto tunggal (gallery_detail.php)
            echo view('templates/header', $data);
            echo view('templates/public_sidebar');
            echo view('templates/public_topbar');
            echo view('public_site/gallery_detail', $data); // <-- Gunakan view terpisah untuk detail
            echo view('templates/footer');
        } else {
            // --- MODE DAFTAR ALBUM (Title Kosong) ---

            $galleryData = $galleryModel->getGallery(); // Mengambil semua foto

            // Mengelompokkan foto berdasarkan 'title' untuk menampilkan daftar folder
            $groupedGallery = [];
            foreach ($galleryData as $item) {
                $title = $item['title'];
                if (!isset($groupedGallery[$title])) {
                    $groupedGallery[$title] = [
                        'title' => $title,
                        'event_date' => $item['event_date'],
                        'photos_count' => 0,
                        'cover_photo' => $item['photo'] // Gunakan foto pertama sebagai cover
                    ];
                }
                $groupedGallery[$title]['photos_count']++;
            }

            $data['grouped_gallery'] = $groupedGallery;

            // Gunakan view utama (gallery.php) yang menampilkan daftar folder
            echo view('templates/header', $data);
            echo view('templates/public_sidebar');
            echo view('templates/public_topbar');
            echo view('public_site/gallery', $data);
            echo view('templates/footer');
        }
    }

    public function about()
    {
        $data = [
            'title' => 'Tentang PB Prabu',
        ];

        echo view('templates/header', $data);
        echo view('templates/public_sidebar');
        echo view('templates/public_topbar');
        echo view('public_site/about', $data);
        echo view('templates/footer');
    }

    public function landingPage()
    {
        $data = [
            'title' => 'Halaman utama PB Prabu',
        ];

        echo view('templates/header', $data);
        echo view('templates/public_sidebar');
        echo view('templates/public_topbar');
        echo view('public_site/home', $data);
        echo view('templates/footer');
    }

    public function schedule()
    {
        $schedules = $this->schedulesModel->getSchedulesWithDetails();

        foreach ($schedules as &$s) {
            $s['has_match'] = $this->matchModel
                ->where('schedule_id', $s['id'])
                ->first() ? true : false;
        }

        $data = [
            'title'     => 'Jadwal Pertandingan',
            'schedules' => $schedules,
        ];

        echo view('templates/header', $data);
        echo view('templates/public_sidebar');
        echo view('templates/public_topbar');
        echo view('public_site/schedules', $data);
        echo view('templates/footer');
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

    public function match($scheduleId = null)
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

        echo view('templates/header', $data);
        echo view('templates/public_sidebar');
        echo view('templates/public_topbar');
        echo view('public_site/match', $data);
        echo view('templates/footer');
    }

    public function player()
    {
        // Ambil filter dari URL
        $selectedLevel = $this->request->getGet('level');
        $search = $this->request->getGet('search');

        // Inisialisasi query builder
        $query = $this->playersModel;

        // Filter berdasarkan level jika dipilih
        if (!empty($selectedLevel) && in_array($selectedLevel, ['Pratama', 'Utama'])) {
            $query = $query->where('level', $selectedLevel);
        }

        // Filter berdasarkan nama pemain jika pencarian diisi
        if (!empty($search)) {
            $query = $query->like('player_name', $search);
        }

        // Ambil data pemain terurut berdasarkan nama
        $players = $query->orderBy('player_name', 'ASC')->findAll();

        $data = [
            'title'         => 'Data Pemain',
            'players'       => $players,
            'selectedLevel' => $selectedLevel,
            'search'        => $search, // penting dikirim agar form tetap isiannya
        ];

        echo view('templates/header', $data);
        echo view('templates/public_sidebar');
        echo view('templates/public_topbar');
        echo view('public_site/players', $data);
        echo view('templates/footer');
    }
}
