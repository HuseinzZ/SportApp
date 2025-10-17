<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Dashboard extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard Utama Admin',
            // Anda bisa menambahkan data dashboard di sini, contoh:
            // 'total_gor' => $this->gorModel->countAll(),
            // 'recent_bookings' => $this->bookingModel->getRecent(),
        ];

        echo view('templates/header', $data);
        echo view('templates/menu');
        echo view('templates/navbar');
        echo view('dashboard/index', $data);
        echo view('templates/footer');
    }
}
