<?php

namespace App\Models;

use CodeIgniter\Model;

class MatchPlayerModel extends Model
{
    protected $table = 'match_players';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'match_id',
        'player_id',
        'team'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getPlayersByMatch($match_id)
    {
        return $this->select('match_players.*, players.player_name')
            ->join('players', 'players.id = match_players.player_id')
            ->where('match_players.match_id', $match_id)
            ->findAll();
    }
}
