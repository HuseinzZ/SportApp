<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        <?php if ($is_empty): ?>
            <div class="alert alert-warning p-4 text-center">
                <i class="bx bx-info-circle fs-4 d-block mb-2"></i>
                Belum ada pertandingan yang dicatat untuk jadwal ini.
            </div>
        <?php else: ?>

            <?php
            // --- LOGIKA PHP LENGKAP UNTUK PERHITUNGAN PERINGKAT ---

            $finalMatch = null;
            $eliminatedTeams = [];

            // Menetapkan urutan ranking babak (skor lebih tinggi = babak lebih lanjut)
            $rankScoreMap = [
                'FINAL' => 5,
                'SF'    => 4,
                'QF'    => 3,
                'R16'   => 2,
                'R32'   => 1,
                'R2'    => 1
            ];

            foreach ($all_matches as $data) {
                $match      = $data['match'];
                $players    = $data['match_players'];
                $roundName  = strtoupper(esc($match['round']));

                $teamA_name = implode(' & ', $players['A']);
                $teamB_name = implode(' & ', $players['B']);

                $winner = ($match['winner_team'] == 'A') ? $teamA_name : $teamB_name;
                $loser  = ($match['winner_team'] == 'A') ? $teamB_name : $teamA_name;

                if (isset($rankScoreMap[$roundName])) {
                    $currentScore   = $rankScoreMap[$roundName];
                    $existingScore  = $eliminatedTeams[$loser]['score'] ?? 0;

                    if ($currentScore > $existingScore) {
                        $eliminatedTeams[$loser] = [
                            'round' => $roundName,
                            'score' => $currentScore
                        ];
                    }
                }

                if ($roundName === 'FINAL') {
                    $finalMatch = $data;
                }
            }

            $winner = 'N/A';
            $runnerUp = 'N/A';
            $finalRanking = [];

            if ($finalMatch) {
                $playersFinal = $finalMatch['match_players'];
                $winnerTeam   = $finalMatch['match']['winner_team'];

                if ($winnerTeam == 'A') {
                    $winner   = implode(' & ', $playersFinal['A']);
                    $runnerUp = implode(' & ', $playersFinal['B']);
                } elseif ($winnerTeam == 'B') {
                    $winner   = implode(' & ', $playersFinal['B']);
                    $runnerUp = implode(' & ', $playersFinal['A']);
                }
            }

            if ($winner !== 'N/A') {
                $finalRanking[$winner] = ['rank' => 1, 'round' => 'FINAL', 'rank_score' => 99];
                unset($eliminatedTeams[$winner]);
            }
            if ($runnerUp !== 'N/A') {
                $finalRanking[$runnerUp] = ['rank' => 2, 'round' => 'FINAL', 'rank_score' => 98];
                unset($eliminatedTeams[$runnerUp]);
            }

            foreach ($eliminatedTeams as $team => $data) {
                $finalRanking[$team] = [
                    'rank_score' => $data['score'],
                    'round'      => $data['round'],
                    'team'       => $team
                ];
            }

            uasort($finalRanking, function ($a, $b) {
                if (($a['rank'] ?? 0) === 1) return -1;
                if (($b['rank'] ?? 0) === 1) return 1;
                if (($a['rank'] ?? 0) === 2) return -1;
                if (($b['rank'] ?? 0) === 2) return 1;

                $scoreA = $a['rank_score'] ?? 0;
                $scoreB = $b['rank_score'] ?? 0;

                if ($scoreA == $scoreB) return 0;
                return ($scoreA > $scoreB) ? -1 : 1;
            });

            $currentRank = 3;
            foreach ($finalRanking as $teamName => &$data) {
                if (!isset($data['rank'])) {
                    $data['rank'] = $currentRank++;
                }
            }
            unset($data);
            // --- AKHIR LOGIKA PHP ---
            ?>
            <div class="card shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bx bx-list-ol me-2"></i> Peringkat Akhir Seri Pertandingan
                    </h5>
                    <a href="<?= site_url('schedule') ?>" class="btn btn-sm btn-secondary">
                        <i class="bx bx-arrow-back me-1"></i> Kembali ke Jadwal
                    </a>
                </div>

                <?php if (empty($finalRanking)): ?>
                    <div class="p-4 text-center text-muted">
                        Tidak ada data peringkat yang dapat dihitung.
                    </div>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($finalRanking as $teamName => $data): ?>
                            <?php
                            $isTop3 = in_array($data['rank'], [1, 2, 3]);
                            $rankBg = match ($data['rank']) {
                                1 => 'bg-primary',
                                2 => 'bg-secondary',
                                3 => 'bg-info',
                                default => 'bg-label-dark'
                            };

                            $eliminationText = match ($data['rank']) {
                                1       => 'Juara',
                                2       => 'Runner Up',
                                default => 'Tereliminasi di Babak ' . $data['round']
                            };
                            ?>
                            <div class="list-group-item p-3 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <span class="badge <?= $rankBg ?> fs-5 me-3 py-2 px-3">
                                        <?= $data['rank'] ?>
                                    </span>
                                    <div>
                                        <h6 class="mb-0 fw-bold <?= $isTop3 ? 'text-primary' : '' ?>">
                                            <?= esc($teamName) ?>
                                        </h6>
                                        <small class="text-muted"><?= $eliminationText ?></small>
                                    </div>
                                </div>
                                <span class="badge bg-label-secondary"><?= $data['round'] ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>