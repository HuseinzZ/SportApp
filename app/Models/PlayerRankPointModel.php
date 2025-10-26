<?php

namespace App\Models;

use CodeIgniter\Model;

class PlayerRankPointModel extends Model
{
    protected $table = 'player_rank_points';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'schedule_id',
        'player_id',
        'stage_reached',
        'points_earned',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getGlobalRanking()
    {
        return $this->select('player_id, SUM(points_earned) AS total_points, players.player_name')
            ->join('players', 'players.id = player_rank_points.player_id')
            ->groupBy('player_id, players.player_name')
            ->orderBy('total_points', 'DESC')
            ->findAll();
    }
}
