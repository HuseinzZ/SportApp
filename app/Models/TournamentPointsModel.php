<?php

namespace App\Models;

use CodeIgniter\Model;

class TournamentPointsModel extends Model
{
    protected $table          = 'tournament_points';
    protected $primaryKey     = 'id';

    protected $allowedFields = [
        'series_level',
        'points_champion',
        'points_runnerup',
        'points_sf',
        'points_qf',
        'points_r2',
        'points_r1',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps  = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = 'updated_at';
    protected $useSoftDeletes = false;
}
