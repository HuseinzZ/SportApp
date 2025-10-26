<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Master / Input /</span> Hasil Pertandingan Ganda
    </h4>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Input Hasil untuk Jadwal #<?= esc($schedule_id) ?></h5>
            <small class="text-muted float-end">Input 4 pemain dan skor</small>
        </div>
        <div class="card-body">
            <form action="<?= site_url('admin/matches/store') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="schedule_id" value="<?= esc($schedule_id) ?>">

                <div class="mb-3">
                    <label for="round" class="form-label">Babak Pertandingan</label>
                    <select name="round" id="round" class="form-select <?= (session('validation') && session('validation')->hasError('round')) ? 'is-invalid' : '' ?>">
                        <option value="">-- Pilih Babak --</option>
                        <?php foreach ($rounds as $r): ?>
                            <option value="<?= $r ?>" <?= old('round') == $r ? 'selected' : '' ?>><?= $r ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback"><?= session('validation') ? session('validation')->getError('round') : '' ?></div>
                </div>

                <h5 class="mb-3 text-primary">Tim A (Pasangan 1)</h5>
                <div class="row">
                    <?php for ($i = 0; $i < 2; $i++): ?>
                        <div class="col-md-6 mb-3">
                            <label for="player_A_<?= $i ?>" class="form-label">Pemain <?= $i + 1 ?> (A)</label>
                            <select name="player_A[]" id="player_A_<?= $i ?>" class="form-select" required>
                                <option value="">-- Pilih Pemain --</option>
                                <?php foreach ($players as $player): ?>
                                    <option value="<?= $player['id'] ?>" <?= (old('player_A')[$i] ?? '') == $player['id'] ? 'selected' : '' ?>>
                                        <?= esc($player['player_name']) ?> (<?= esc($player['level']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endfor; ?>
                </div>

                <h5 class="mt-4 mb-3 text-info">Tim B (Pasangan 2)</h5>
                <div class="row">
                    <?php for ($i = 0; $i < 2; $i++): ?>
                        <div class="col-md-6 mb-3">
                            <label for="player_B_<?= $i ?>" class="form-label">Pemain <?= $i + 1 ?> (B)</label>
                            <select name="player_B[]" id="player_B_<?= $i ?>" class="form-select" required>
                                <option value="">-- Pilih Pemain --</option>
                                <?php foreach ($players as $player): ?>
                                    <option value="<?= $player['id'] ?>" <?= (old('player_B')[$i] ?? '') == $player['id'] ? 'selected' : '' ?>>
                                        <?= esc($player['player_name']) ?> (<?= esc($player['level']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endfor; ?>
                </div>

                <h5 class="mt-4 mb-3">Input Skor</h5>
                <?php for ($game = 1; $game <= 1; $game++): ?>
                    <div class="row border-top pt-3 mt-3 game-input-group" data-game="<?= $game ?>">
                        <h6 class="col-12 mb-3">Game</h6>

                        <?php $isRequired = ($game === 1) ? 'required' : ''; // Hanya Game 1 yang wajib 
                        ?>

                        <!-- (Game <?= $game ?>) -->

                        <div class="col-md-6 mb-3">
                            <label for="score_A_<?= $game ?>" class="form-label">Skor Tim A </label>
                            <input type="number" name="score_A[]" id="score_A_<?= $game ?>" class="form-control"
                                value="<?= old('score_A')[$game - 1] ?? '' ?>" min="0" <?= $isRequired ?>>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="score_B_<?= $game ?>" class="form-label">Skor Tim B</label>
                            <input type="number" name="score_B[]" id="score_B_<?= $game ?>" class="form-control"
                                value="<?= old('score_B')[$game - 1] ?? '' ?>" min="0" <?= $isRequired ?>>
                        </div>
                    </div>
                <?php endfor; ?>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary me-2"><i class="bx bx-save"></i> Simpan Hasil Pertandingan</button>
                    <a href="<?= site_url('admin/matches/' . $schedule_id) ?>" class="btn btn-outline-secondary"><i class="bx bx-arrow-back"></i> Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>