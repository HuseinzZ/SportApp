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

    public function getPlayerTotalPoints(int $playerId): array
    {
        $result = $this->select('SUM(points_earned) AS total_points')
            ->where('player_id', $playerId)
            ->first();

        return $result ?: ['total_points' => 0];
    }

    /**
     * Mengambil daftar peringkat global dengan opsi filter Level dan Nama Pemain.
     * * @param string|null $level Filter berdasarkan level ('Pratama' atau 'Utama').
     * @param string|null $search Filter berdasarkan nama pemain (LIKE).
     * @return array
     */
    public function getGlobalRanking($level = null, $search = null)
    {
        $this->select('player_id, SUM(points_earned) AS total_points, players.player_name')
            ->join('players', 'players.id = player_rank_points.player_id');

        // --- Terapkan Filter ---

        // 1. Filter berdasarkan Level
        if (!empty($level) && in_array($level, ['Pratama', 'Utama'])) {
            $this->where('players.level', $level);
        }

        // 2. Filter berdasarkan Nama Pemain (Search)
        if (!empty($search)) {
            // Menggunakan 'like' untuk pencarian parsial pada nama pemain
            $this->like('players.player_name', $search);
        }

        // --- Akhir Terapkan Filter ---

        return $this->groupBy('player_id, players.player_name')
            ->orderBy('total_points', 'DESC')
            ->findAll();
    }
}
