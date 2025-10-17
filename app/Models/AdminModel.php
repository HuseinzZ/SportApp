<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'update_at';

    /**
     * Mencari admin berdasarkan username.
     * @param string $username
     * @return array|object|null
     */
    public function findByUsername(string $username)
    {
        return $this->where('username', $username)->first();
    }

    public function findById(int $adminId)
    {
        return $this->find($adminId);
    }
}
