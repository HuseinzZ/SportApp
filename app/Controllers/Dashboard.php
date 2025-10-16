<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Dashboard extends BaseController
{
    public function index()
    {
        // $session = session();
        // if (!$session->get('logged_in')) {
        //     $session->setFlashdata('error', 'Anda harus login untuk mengakses dashboard.');
        //     return redirect()->to(base_url('admin'));
        // }
        // // -----------------------------------------------------------

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
