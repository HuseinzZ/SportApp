<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'id';
    // PERBAIKAN: Mengubah 'update_at' menjadi 'updated_at'
    protected $allowedFields = ['username', 'password', 'created_at', 'updated_at'];

    // Menambahkan konfigurasi timestamp agar otomatis diurus oleh CI4
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    // Jika Anda menggunakan soft delete:
    // protected $useSoftDeletes = false; 
}
