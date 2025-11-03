<?php

namespace App\Controllers;

use App\Models\PlayerRankPointModel;
use App\Models\PlayersModel;
use App\Models\MatchPlayerModel;
use App\Models\GalleryModel;
use App\Models\MatchModel;
use App\Models\SchedulesModel;

class Home extends BaseController
{
    protected $playerRankPointModel;
    protected $playersModel;
    protected $matchPlayerModel;
    protected $galleryModel;
    protected $matchModel;
    protected $schedulesModel;

    public function __construct()
    {
        $this->playerRankPointModel = new PlayerRankPointModel();
        $this->playersModel = new PlayersModel();
        $this->matchPlayerModel = new MatchPlayerModel();
        $this->galleryModel = new GalleryModel();
        $this->matchModel = new MatchModel();
        $this->schedulesModel = new SchedulesModel();
    }

    public function index()
    {
        $ranking = $this->playerRankPointModel->getGlobalRanking();
        $playerDetails = array_column($this->playersModel->findAll(), null, 'id');
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
            'title'   => 'Daftar Peringkat',
            'ranking' => $ranking,
            'playerDetails' => $playerDetails,
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
        $galleryData = $this->galleryModel->getGallery();

        $data = [
            'title'   => 'Galeri Kegiatan',
            'gallery' => $galleryData,
        ];

        echo view('templates/header', $data);
        echo view('templates/public_sidebar');
        echo view('templates/public_topbar');
        echo view('public_site/gallery', $data);
        echo view('templates/footer');
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

    public function match()
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
}
