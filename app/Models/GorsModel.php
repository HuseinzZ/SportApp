<?php

namespace App\Models;

use CodeIgniter\Model;

class GorsModel extends Model
{
    protected $table          = 'gors';
    protected $primaryKey     = 'id';

    protected $allowedFields = [
        'gors_name',
        'address',
        'contact',
        'description',
        'price',
        'photo',
    ];

    protected $useTimestamps  = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = 'updated_at';
    protected $useSoftDeletes = false;
}
