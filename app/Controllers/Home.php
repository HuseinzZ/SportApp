<?php

namespace App\Controllers;

use App\Models\PlayerRankPointModel;
use App\Models\PlayersModel;

class Home extends BaseController
{
    protected $playerRankPointModel;
    protected $playersModel;

    public function __construct()
    {
        $this->playerRankPointModel = new PlayerRankPointModel();
        $this->playersModel = new PlayersModel();
    }

    public function index() {}
}
