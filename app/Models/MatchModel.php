<?php

namespace App\Models;

use CodeIgniter\Model;

class MatchModel extends Model
{
    protected $table = 'matches';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'schedule_id',
        'round',
        'status',
        'winner_team',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getMatchesWithDetails()
    {
        return $this->select('matches.*, schedules.match_date, gors.gors_name')
            ->join('schedules', 'schedules.id = matches.schedule_id')
            ->join('gors', 'gors.id = schedules.gors_id', 'left')
            ->orderBy('matches.id', 'DESC')
            ->findAll();
    }
}
