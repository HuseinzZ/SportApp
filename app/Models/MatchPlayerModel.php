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

    public function getRecentMatchHistory(int $playerId, int $limit = 10)
    {
        // Subquery: Ambil 10 match_id terbaru yang melibatkan pemain ini (P1)
        $recentMatchesSubquery = $this->db->table('match_players AS p1')
            ->select('p1.match_id, p1.team AS p1_team, M.winner_team, S.match_date')
            ->join('matches AS M', 'M.id = p1.match_id')
            ->join('schedules AS S', 'S.id = M.schedule_id')
            ->where('p1.player_id', $playerId)
            ->orderBy('S.match_date', 'DESC')
            ->limit($limit)
            ->getCompiledSelect();

        // Query Utama: Menggabungkan detail dari semua pemain dalam 10 match tersebut
        $query = $this->db->table("($recentMatchesSubquery) AS rm")
            ->select([
                'rm.match_id',
                'rm.match_date',
                'rm.p1_team',
                'rm.winner_team',

                // Rekan Setim: Pemain dengan tim yang sama, bukan P1
                'GROUP_CONCAT(
                CASE 
                    WHEN mp.team = rm.p1_team AND mp.player_id != ' . $playerId . ' 
                    THEN P.player_name 
                END
                ORDER BY P.player_name
            ) AS teammate_name',

                // Lawan: Pemain dengan tim yang berbeda
                'GROUP_CONCAT(
                CASE 
                    WHEN mp.team != rm.p1_team 
                    THEN P.player_name 
                END
                ORDER BY P.player_name
            ) AS opponent_names',

                // Skor Tim A dan Tim B (diambil dari match_scores Game 1 / Games Won)
                'MS.team_a_score',
                'MS.team_b_score',
                'G.gors_name'
            ])
            ->join('match_players AS mp', 'mp.match_id = rm.match_id')
            ->join('players AS P', 'P.id = mp.player_id')
            ->join('matches AS M', 'M.id = rm.match_id')
            ->join('schedules AS S', 'S.id = M.schedule_id')
            ->join('gors AS G', 'G.id = S.gors_id')
            // Asumsi Games Won/Skor Total disimpan di Game 1 (game_number = 1)
            ->join('match_scores AS MS', 'MS.match_id = rm.match_id AND MS.game_number = 1', 'left')

            ->groupBy('rm.match_id, rm.match_date, rm.p1_team, rm.winner_team, MS.team_a_score, MS.team_b_score, G.gors_name')
            ->orderBy('rm.match_date', 'DESC')
            ->limit($limit);

        return $query->get()->getResultArray();
    }
}
