<?php

namespace App\Models;

use CodeIgniter\Model;

class MatchScoreModel extends Model
{
    protected $table = 'match_scores';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'match_id',
        'game_number',
        'team_a_score',
        'team_b_score'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getScoresByMatch($match_id)
    {
        return $this->where('match_id', $match_id)
            ->orderBy('game_number', 'ASC')
            ->findAll();
    }
}
