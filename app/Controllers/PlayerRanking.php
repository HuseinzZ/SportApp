<?php

namespace App\Controllers;

use App\Models\PlayerRankPointModel;
use App\Models\PlayersModel;

class PlayerRanking extends BaseController
{
    protected $playerRankPointModel;
    protected $playersModel;

    public function __construct()
    {
        $this->playerRankPointModel = new PlayerRankPointModel();
        $this->playersModel = new PlayersModel();
    }

    public function index()
    {
        // === 1. Ambil Filter dari URL ===
        $selectedLevel = $this->request->getGet('level');
        $search = $this->request->getGet('search');

        // === 2. Panggil Model dengan Filter ===
        // Asumsi PlayerRankPointModel memiliki method yang bisa menerima filter
        $ranking = $this->playerRankPointModel->getGlobalRanking($selectedLevel, $search);

        // Ambil detail pemain yang terfilter saja (opsional, untuk efisiensi)
        $playerIds = array_column($ranking, 'player_id');
        if (!empty($playerIds)) {
            $playerDetails = array_column($this->playersModel->whereIn('id', $playerIds)->findAll(), null, 'id');
        } else {
            $playerDetails = [];
        }

        $data = [
            'title'         => 'Daftar Peringkat',
            'ranking'       => $ranking,
            'playerDetails' => $playerDetails,
            // === 3. Kirim Filter ke View ===
            'selectedLevel' => $selectedLevel,
            'search'        => $search,
        ];

        echo view('templates/table_header', $data);
        echo view('templates/sidebar');
        echo view('templates/topbar');
        echo view('player_ranking/index', $data);
        echo view('templates/table_footer');
    }

    // ======================================
    // METHOD BARU: EKSPOR DATA CSV
    // ======================================
    public function exportCsv()
    {
        $ranking = $this->playerRankPointModel->getGlobalRanking();

        // 1. Tentukan header untuk mengunduh file CSV
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="ranking_global_' . date('Ymd_His') . '.csv"');

        $output = fopen('php://output', 'w');

        // 2. Tulis baris header
        fputcsv($output, ['RANK', 'ID PEMAIN', 'NAMA PEMAIN', 'TOTAL POIN']);

        // 3. Tulis data baris
        $rank = 1;
        foreach ($ranking as $row) {
            fputcsv($output, [
                $rank++,
                $row['player_id'],
                $row['player_name'],
                $row['total_points']
            ]);
        }

        fclose($output);
        exit;
    }

    // ======================================
    // METHOD BARU: TAMPILAN CETAK (PRINT)
    // ======================================
    public function printReport()
    {
        $ranking = $this->playerRankPointModel->getGlobalRanking();
        $playerDetails = array_column($this->playersModel->findAll(), null, 'id');

        $data = [
            'title'   => 'Laporan Daftar Peringkat',
            'ranking' => $ranking,
            'playerDetails' => $playerDetails,
        ];

        // Memuat View Khusus Tanpa Header/Sidebar
        echo view('player_ranking/print_report', $data);
        // Tidak memuat templates/table_header, templates/sidebar, dll.
    }

    // ======================================
    // METHOD BARU: EKSPOR DATA EXCEL
    // ======================================

    public function exportExcel()
    {
        $ranking = $this->playerRankPointModel->getGlobalRanking();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="daftar_peringkat_' . date('Ymd_His') . '.xls"');

        $output = fopen('php://output', 'w');

        // Header kolom
        fputcsv($output, ['RANK', 'ID PEMAIN', 'NAMA PEMAIN', 'TOTAL POIN'], "\t");

        $rank = 1;
        foreach ($ranking as $row) {
            fputcsv($output, [
                $rank++,
                $row['player_id'],
                $row['player_name'],
                $row['total_points']
            ], "\t"); // gunakan tab sebagai pemisah agar Excel lebih rapi
        }

        fclose($output);
        exit;
    }
}
