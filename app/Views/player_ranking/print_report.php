<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Ranking Global</title>
    <link href="<?= base_url('assets/vendor/css/core.css') ?>" rel="stylesheet" />
    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            margin: 40px;
            background-color: #f8f9fc;
            color: #333;
        }

        .report-container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 900px;
            margin: auto;
        }

        .report-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .report-header h2 {
            color: #007bff;
            margin-bottom: 10px;
        }

        .report-header p {
            color: #666;
            font-size: 14px;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
        }

        .report-table th {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            text-align: center;
            font-weight: 600;
            font-size: 14px;
        }

        .report-table td {
            border: 1px solid #ddd;
            padding: 10px;
            font-size: 14px;
        }

        .report-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .report-table tr:hover {
            background-color: #eef5ff;
        }

        .text-center {
            text-align: center;
        }

        .button-group {
            text-align: center;
            margin-top: 25px;
        }

        .btn {
            display: inline-block;
            margin: 5px;
            padding: 10px 18px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #545b62;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background-color: #a71d2a;
        }

        /* Sembunyikan tombol saat mencetak */
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: #fff;
                margin: 0;
            }

            .report-container {
                box-shadow: none;
                border: none;
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>

<body>

    <div class="report-container">
        <div class="report-header">
            <h2>Laporan Ranking Poin Global PB PRABU</h2>
            <p>Tanggal Cetak: <?= date('d M Y H:i:s') ?></p>
        </div>

        <table class="report-table">
            <thead>
                <tr>
                    <th>RANK</th>
                    <th>PEMAIN</th>
                    <th>LEVEL</th>
                    <th>TOTAL POIN</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($ranking)): ?>
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data poin ranking.</td>
                    </tr>
                <?php else: ?>
                    <?php $rank = 1; ?>
                    <?php foreach ($ranking as $playerRank):
                        $detail = $playerDetails[$playerRank['player_id']] ?? null;
                    ?>
                        <tr>
                            <td class="text-center"><?= $rank++ ?></td>
                            <td><strong><?= esc($playerRank['player_name']) ?></strong></td>
                            <td class="text-center"><?= esc($detail['level'] ?? '-') ?></td>
                            <td class="text-center"><?= number_format(esc($playerRank['total_points']), 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="button-group no-print">
            <button onclick="window.print()" class="btn btn-primary">🖨 Cetak Ulang</button>
            <a href="<?= site_url('admin/ranking') ?>" class="btn btn-secondary">⬅ Kembali</a>
        </div>
    </div>

    <script>
        // Otomatis buka dialog print saat halaman selesai dimuat
        window.onload = function() {
            setTimeout(() => {
                window.print();
            }, 500);
        };
    </script>
</body>

</html>