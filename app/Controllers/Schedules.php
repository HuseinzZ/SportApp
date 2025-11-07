<?php

namespace App\Controllers;

use App\Models\SchedulesModel;
use App\Models\GorsModel;
use App\Models\TournamentPointsModel;
use App\Models\MatchModel;

class Schedules extends BaseController
{
    protected $schedulesModel;
    protected $gorsModel;
    protected $tournamentPointsModel;
    protected $matchModel;

    public function __construct()
    {
        $this->schedulesModel = new SchedulesModel();
        $this->gorsModel = new GorsModel();
        $this->tournamentPointsModel = new TournamentPointsModel();
        $this->matchModel = new MatchModel();
    }

    // ======================================
    // TAMPILKAN DAFTAR JADWAL (READ)
    // ======================================
    public function index()
    {
        $schedules = $this->schedulesModel->getSchedulesWithDetails();

        foreach ($schedules as &$s) {
            $s['has_match'] = $this->matchModel
                ->where('schedule_id', $s['id'])
                ->first() ? true : false;
        }

        $data = [
            'title'     => 'Master Jadwal Pertandingan',
            'schedules' => $schedules,
        ];

        echo view('templates/table_header', $data);
        echo view('templates/sidebar');
        echo view('templates/topbar');
        echo view('schedules/index', $data);
        echo view('templates/table_footer');
    }

    // ======================================
    // FORM TAMBAH JADWAL (CREATE VIEW)
    // ======================================
    public function a_schedules()
    {
        $data = [
            'title'             => 'Tambah Jadwal Pertandingan',
            'validation'        => \Config\Services::validation(),
            'gors'              => $this->gorsModel->findAll(),
            'tournament_points' => $this->tournamentPointsModel->findAll(),
        ];

        echo view('templates/table_header', $data);
        echo view('templates/sidebar');
        echo view('templates/topbar');
        echo view('schedules/a_schedules', $data);
        echo view('templates/table_footer');
    }

    // ======================================
    // SIMPAN DATA JADWAL (CREATE LOGIC)
    // ======================================
    public function store()
    {
        $validationRules = [
            'gors_id' => [
                'rules'  => 'required|integer',
                'errors' => ['required' => 'GOR harus dipilih.'],
            ],
            'tournament_points_id' => [
                'rules'  => 'required|integer',
                'errors' => ['required' => 'Level pertandingan harus dipilih.'],
            ],
            'match_date' => [
                'rules'  => 'required|valid_date',
                'errors' => [
                    'required'   => 'Tanggal dan waktu pertandingan harus diisi.',
                    'valid_date' => 'Format tanggal/waktu tidak valid.',
                ],
            ],
            'match_type' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Jenis pertandingan harus diisi.',
                ],
            ],
            'status' => [
                'rules'  => 'required|in_list[Scheduled,In-Progress,Completed,Cancelled]',
                'errors' => [
                    'required' => 'Status pertandingan harus diisi.',
                    'in_list'  => 'Status tidak valid.',
                ],
            ],
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $this->schedulesModel->save([
            'gors_id'              => $this->request->getPost('gors_id'),
            'tournament_points_id' => $this->request->getPost('tournament_points_id'),
            'match_date'           => $this->request->getPost('match_date'),
            'match_type'           => $this->request->getPost('match_type'),
            'status'               => $this->request->getPost('status'),
        ]);

        session()->setFlashdata('success', 'Jadwal pertandingan berhasil ditambahkan!');
        return redirect()->to(site_url('admin/schedules'));
    }

    // ======================================
    // FORM EDIT JADWAL (UPDATE VIEW)
    // ======================================
    public function e_schedules($id = null)
    {
        $schedule = $this->schedulesModel->find($id);

        if (!$schedule) {
            session()->setFlashdata('error', 'Jadwal pertandingan tidak ditemukan.');
            return redirect()->to(site_url('admin/schedules'));
        }

        $data = [
            'title'             => 'Edit Jadwal Pertandingan',
            'validation'        => \Config\Services::validation(),
            'schedule'          => $schedule,
            'gors'              => $this->gorsModel->findAll(),
            'tournament_points' => $this->tournamentPointsModel->findAll(),
        ];

        echo view('templates/table_header', $data);
        echo view('templates/sidebar');
        echo view('templates/topbar');
        echo view('schedules/e_schedules', $data);
        echo view('templates/table_footer');
    }

    // ======================================
    // SIMPAN PERUBAHAN JADWAL (UPDATE LOGIC)
    // ======================================
    public function update($id = null)
    {
        $schedule = $this->schedulesModel->find($id);

        if (!$schedule) {
            session()->setFlashdata('error', 'Jadwal pertandingan tidak ditemukan.');
            return redirect()->to(site_url('admin/schedules'));
        }

        $validationRules = [
            'gors_id' => [
                'rules'  => 'required|integer',
                'errors' => ['required' => 'GOR harus dipilih.'],
            ],
            'tournament_points_id' => [
                'rules'  => 'required|integer',
                'errors' => ['required' => 'Level pertandingan harus dipilih.'],
            ],
            'match_date' => [
                'rules'  => 'required|valid_date',
                'errors' => [
                    'required'   => 'Tanggal dan waktu pertandingan harus diisi.',
                    'valid_date' => 'Format tanggal/waktu tidak valid.',
                ],
            ],
            'match_type' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Jenis pertandingan harus diisi.',
                ],
            ],
            'status' => [
                'rules'  => 'required|in_list[Scheduled,In-Progress,Completed,Cancelled]',
                'errors' => [
                    'required' => 'Status pertandingan harus diisi.',
                    'in_list'  => 'Status tidak valid.',
                ],
            ],
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $this->schedulesModel->update($id, [
            'gors_id'              => $this->request->getPost('gors_id'),
            'tournament_points_id' => $this->request->getPost('tournament_points_id'),
            'match_date'           => $this->request->getPost('match_date'),
            'match_type'           => $this->request->getPost('match_type'),
            'status'               => $this->request->getPost('status'),
        ]);

        session()->setFlashdata('success', 'Jadwal pertandingan berhasil diperbarui!');
        return redirect()->to(site_url('admin/schedules'));
    }

    // ======================================
    // HAPUS JADWAL (DELETE)
    // ======================================
    public function d_schedules($id = null)
    {
        if (!$id) {
            session()->setFlashdata('error', 'ID jadwal tidak ditemukan.');
            return redirect()->to(site_url('admin/schedules'));
        }

        $deleted = $this->schedulesModel->delete($id);

        if ($deleted) {
            session()->setFlashdata('success', 'Jadwal pertandingan berhasil dihapus!');
        } else {
            session()->setFlashdata('error', 'Jadwal pertandingan tidak ditemukan atau gagal dihapus.');
        }

        return redirect()->to(site_url('admin/schedules'));
    }
}
