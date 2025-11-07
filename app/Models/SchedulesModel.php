<?php

namespace App\Models;

use CodeIgniter\Model;

class SchedulesModel extends Model
{
    protected $table          = 'schedules';
    protected $primaryKey     = 'id';

    protected $allowedFields = [
        'gors_id',
        'tournament_points_id',
        'match_date',
        'match_type',
        'status',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps  = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = 'updated_at';
    protected $useSoftDeletes = false;

    public function getSchedulesWithDetails()
    {
        return $this->select('schedules.*, gors.gors_name, gors.photo, tournament_points.series_level')
            ->join('gors', 'gors.id = schedules.gors_id')
            ->join('tournament_points', 'tournament_points.id = schedules.tournament_points_id')
            ->findAll();
    }

    public function getScheduleWithPoints($scheduleId)
    {
        return $this->select('schedules.*, tp.*')
            ->join('tournament_points AS tp', 'tp.id = schedules.tournament_points_id')
            ->where('schedules.id', $scheduleId)
            ->first();
    }
}
