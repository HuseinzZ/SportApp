<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Master / Edit /</span> Hasil Pertandingan #<?= esc($match['id']) ?>
    </h4>

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Edit Hasil, Pemain, dan Skor Pertandingan</h5>
        </div>

        <div class="card-body">
            <form action="<?= site_url('admin/matches/update/' . $match['id']) ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">

                <h5 class="mb-3 text-muted">Metadata Pertandingan</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="round" class="form-label">Babak</label>
                        <select name="round" id="round" class="form-select">
                            <?php foreach ($rounds as $r): ?>
                                <option value="<?= $r ?>" <?= old('round', $match['round']) == $r ? 'selected' : '' ?>><?= $r ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <?php foreach ($statuses as $s): ?>
                                <option value="<?= $s ?>" <?= old('status', $match['status']) == $s ? 'selected' : '' ?>><?= $s ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <hr>

                <h5 class="mb-3 text-primary">Pemain Tim A</h5>
                <div class="row">
                    <?php for ($i = 0; $i < 2; $i++):
                        // Ambil ID pemain lama dari data DB atau old input
                        $oldPlayerId = $match_players_A[$i]['player_id'] ?? old('player_A')[$i] ?? '';
                    ?>
                        <div class="col-md-6 mb-3">
                            <label for="player_A_<?= $i ?>" class="form-label">Pemain <?= $i + 1 ?> (A)</label>
                            <select name="player_A[]" id="player_A_<?= $i ?>" class="form-select" required>
                                <option value="">-- Pilih Pemain --</option>
                                <?php foreach ($players as $player): ?>
                                    <option value="<?= $player['id'] ?>" <?= $oldPlayerId == $player['id'] ? 'selected' : '' ?>>
                                        <?= esc($player['player_name']) ?> (<?= esc($player['level']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endfor; ?>
                </div>

                <h5 class="mt-4 mb-3 text-info">Pemain Tim B</h5>
                <div class="row">
                    <?php for ($i = 0; $i < 2; $i++):
                        $oldPlayerId = $match_players_B[$i]['player_id'] ?? old('player_B')[$i] ?? '';
                    ?>
                        <div class="col-md-6 mb-3">
                            <label for="player_B_<?= $i ?>" class="form-label">Pemain <?= $i + 1 ?> (B)</label>
                            <select name="player_B[]" id="player_B_<?= $i ?>" class="form-select" required>
                                <option value="">-- Pilih Pemain --</option>
                                <?php foreach ($players as $player): ?>
                                    <option value="<?= $player['id'] ?>" <?= $oldPlayerId == $player['id'] ? 'selected' : '' ?>>
                                        <?= esc($player['player_name']) ?> (<?= esc($player['level']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endfor; ?>
                </div>

                <h5 class="mt-4 mb-3">Input Skor</h5>
                <div class="row">
                    <?php
                    // Tampilkan input untuk 3 Game, mengisi data lama jika ada
                    for ($game = 1; $game <= 1; $game++):

                        // Cari data skor untuk game ini
                        $scoreData = array_values(array_filter($match_scores, fn($s) => $s['game_number'] == $game))[0] ?? null;

                        // Tentukan nilai lama (prioritas: OLD POST > Data DB > Kosong)
                        $scoreA_val = old('score_A')[$game - 1] ?? ($scoreData['team_a_score'] ?? '');
                        $scoreB_val = old('score_B')[$game - 1] ?? ($scoreData['team_b_score'] ?? '');

                        // Game 1 Wajib, Game 2 & 3 Opsional
                        $isRequired = ($game === 1) ? 'required' : '';
                    ?>
                        <div class="col-md-12 border-top pt-3 mt-3">
                            <h6 class="mb-3">Game</h6>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Skor Tim A</label>
                            <input type="number" name="score_A[]" class="form-control"
                                value="<?= esc($scoreA_val) ?>" min="0" <?= $isRequired ?>>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Skor Tim B</label>
                            <input type="number" name="score_B[]" class="form-control"
                                value="<?= esc($scoreB_val) ?>" min="0" <?= $isRequired ?>>
                        </div>
                    <?php endfor; ?>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary me-2"><i class="bx bx-save"></i> Update Hasil</button>
                    <a href="<?= site_url('admin/matches/' . $schedule_id) ?>" class="btn btn-outline-secondary"><i class="bx bx-arrow-back"></i> Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>