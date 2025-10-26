<?php

namespace App\Controllers;

use App\Models\TournamentPointsModel;

class TournamentPoints extends BaseController
{
    protected $tournamentPointsModel;

    public function __construct()
    {
        $this->tournamentPointsModel = new TournamentPointsModel();
    }

    // ======================================
    // TAMPILKAN DAFTAR POIN TURNAMEN (READ)
    // ======================================
    public function index()
    {
        $data = [
            'title'   => 'Master Poin Pertandingan',
            'points'  => $this->tournamentPointsModel->findAll(),
        ];

        echo view('templates/table_header', $data);
        echo view('templates/sidebar');
        echo view('templates/topbar');
        echo view('tournament_points/index', $data);
        echo view('templates/table_footer');
    }

    // ======================================
    // FORM TAMBAH POIN (CREATE VIEW)
    // ======================================
    public function a_points()
    {
        $data = [
            'title'      => 'Tambah Poin Pertandingan',
            'validation' => \Config\Services::validation(),
        ];

        echo view('templates/table_header', $data);
        echo view('templates/sidebar');
        echo view('templates/topbar');
        echo view('tournament_points/a_tournament_points', $data);
        echo view('templates/table_footer');
    }

    // ======================================
    // SIMPAN DATA POIN (CREATE LOGIC)
    // ======================================
    public function store()
    {
        $validationRules = [
            'series_level' => [
                'rules'  => 'required|is_unique[tournament_points.series_level]',
                'errors' => [
                    'required'   => 'Level seri harus diisi.',
                    'is_unique'  => 'Level seri ini sudah ada.',
                ],
            ],
            'points_champion' => 'required|integer',
            'points_runnerup' => 'required|integer',
            'points_sf'       => 'required|integer',
            'points_qf'       => 'required|integer',
            'points_r2'       => 'required|integer',
            'points_r1'       => 'required|integer',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Simpan ke database
        $this->tournamentPointsModel->save([
            'series_level'    => $this->request->getPost('series_level'),
            'points_champion' => $this->request->getPost('points_champion'),
            'points_runnerup' => $this->request->getPost('points_runnerup'),
            'points_sf'       => $this->request->getPost('points_sf'),
            'points_qf'       => $this->request->getPost('points_qf'),
            'points_r2'       => $this->request->getPost('points_r2'),
            'points_r1'       => $this->request->getPost('points_r1'),
        ]);

        session()->setFlashdata('success', 'Data poin pertandingan berhasil ditambahkan!');
        return redirect()->to(site_url('admin/tournament-points'));
    }

    // ======================================
    // FORM EDIT POIN (UPDATE VIEW)
    // ======================================
    public function e_points($id = null)
    {
        $pointsData = $this->tournamentPointsModel->find($id);

        if (!$pointsData) {
            session()->setFlashdata('error', 'Data poin pertandingan tidak ditemukan.');
            return redirect()->to(site_url('admin/tournament-points'));
        }

        $data = [
            'title'      => 'Edit Poin Pertandingan',
            'validation' => \Config\Services::validation(),
            'points'     => $pointsData,
        ];

        echo view('templates/table_header', $data);
        echo view('templates/sidebar');
        echo view('templates/topbar');
        echo view('tournament_points/e_tournament_points', $data);
        echo view('templates/table_footer');
    }

    // ======================================
    // SIMPAN PERUBAHAN POIN (UPDATE LOGIC)
    // ======================================
    public function update($id = null)
    {
        $pointsData = $this->tournamentPointsModel->find($id);

        if (!$pointsData) {
            session()->setFlashdata('error', 'Data poin pertandingan tidak ditemukan.');
            return redirect()->to(site_url('admin/tournament-points'));
        }

        // Cek jika series_level diubah
        $isUniqueSeries = $pointsData['series_level'] !== $this->request->getPost('series_level')
            ? 'required|is_unique[tournament_points.series_level,id,' . $id . ']'
            : 'required';

        $validationRules = [
            'series_level' => [
                'rules'  => $isUniqueSeries,
                'errors' => [
                    'required'   => 'Level seri harus diisi.',
                    'is_unique'  => 'Level seri ini sudah ada.',
                ],
            ],
            'points_champion' => 'required|integer',
            'points_runnerup' => 'required|integer',
            'points_sf'       => 'required|integer',
            'points_qf'       => 'required|integer',
            'points_r2'       => 'required|integer',
            'points_r1'       => 'required|integer',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Update ke database
        $this->tournamentPointsModel->update($id, [
            'series_level'    => $this->request->getPost('series_level'),
            'points_champion' => $this->request->getPost('points_champion'),
            'points_runnerup' => $this->request->getPost('points_runnerup'),
            'points_sf'       => $this->request->getPost('points_sf'),
            'points_qf'       => $this->request->getPost('points_qf'),
            'points_r2'       => $this->request->getPost('points_r2'),
            'points_r1'       => $this->request->getPost('points_r1'),
        ]);

        session()->setFlashdata('success', 'Data poin pertandingan berhasil diperbarui!');
        return redirect()->to(site_url('admin/tournament-points'));
    }

    // ======================================
    // HAPUS POIN TURNAMEN (DELETE)
    // ======================================
    public function d_points($id = null)
    {
        if (!$id) {
            session()->setFlashdata('error', 'ID poin pertandingan tidak ditemukan.');
            return redirect()->to(site_url('admin/tournament-points'));
        }

        $deleted = $this->tournamentPointsModel->delete($id);

        if ($deleted) {
            session()->setFlashdata('success', 'Data poin pertandingan berhasil dihapus!');
        } else {
            session()->setFlashdata('error', 'Data poin pertandingan tidak ditemukan atau gagal dihapus.');
        }

        return redirect()->to(site_url('admin/tournament-points'));
    }
}
