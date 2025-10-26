<?php

namespace App\Controllers;

use App\Models\PlayerRankPointModel;
use App\Models\PlayersModel;

class PlayerRanking extends BaseController
{
    protected $playerRankPointModel;
    protected $playersModel;

    public function __construct()
    {
        $this->playerRankPointModel = new PlayerRankPointModel();
        $this->playersModel = new PlayersModel();
    }

    public function index()
    {
        $ranking = $this->playerRankPointModel->getGlobalRanking();
        $playerDetails = array_column($this->playersModel->findAll(), null, 'id');

        $data = [
            'title'   => 'Ranking Poin Global',
            'ranking' => $ranking,
            'playerDetails' => $playerDetails,
        ];

        echo view('templates/table_header', $data);
        echo view('templates/sidebar');
        echo view('templates/topbar');
        echo view('player_ranking/index', $data);
        echo view('templates/table_footer');
    }
}
