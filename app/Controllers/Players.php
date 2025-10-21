<?php

namespace App\Controllers;

use App\Models\PlayersModel;

class Players extends BaseController
{
    protected $playersModel;

    public function __construct()
    {
        $this->playersModel = new PlayersModel();
    }

    // ==============================
    // TAMPILKAN DAFTAR PEMAIN (READ)
    // ==============================
    public function index()
    {
        $data = [
            'title'   => 'Master Data Pemain',
            'players' => $this->playersModel->findAll(),
        ];

        echo view('templates/table_header', $data);
        echo view('templates/sidebar');
        echo view('templates/topbar');
        echo view('players/index', $data);
        echo view('templates/table_footer');
    }

    // ==============================
    // FORM TAMBAH PEMAIN (CREATE VIEW)
    // ==============================
    public function a_players()
    {
        $data = [
            'title'      => 'Tambah Pemain',
            'validation' => \Config\Services::validation(),
        ];

        echo view('templates/table_header', $data);
        echo view('templates/sidebar');
        echo view('templates/topbar');
        echo view('players/a_players', $data);
        echo view('templates/table_footer');
    }

    // ==============================
    // SIMPAN DATA PEMAIN (CREATE LOGIC)
    // ==============================
    public function store()
    {
        $validationRules = [
            'player_name' => [
                'rules'  => 'required|min_length[3]',
                'errors' => [
                    'required'   => 'Nama pemain harus diisi.',
                    'min_length' => 'Nama pemain minimal 3 karakter.',
                ],
            ],
            'level' => [
                'rules'  => 'required|in_list[Pratama,Utama]',
                'errors' => [
                    'required' => 'Level pemain harus diisi.',
                    'in_list'  => 'Level pemain tidak valid.',
                ],
            ],

            'gender' => [
                'rules'  => 'required|in_list[M,F]',
                'errors' => [
                    'required' => 'Jenis kelamin harus diisi.',
                    'in_list'  => 'Jenis kelamin tidak valid.',
                ],
            ],
            'photo' => [
                'rules'  => 'if_exist|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'is_image' => 'File harus berupa gambar.',
                    'mime_in'  => 'Format gambar tidak didukung (hanya JPG, JPEG, PNG).',
                ],
            ],
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Upload foto (jika ada)
        $filePhoto = $this->request->getFile('photo');
        $namaPhoto = null;

        if ($filePhoto && $filePhoto->isValid() && !$filePhoto->hasMoved()) {
            $namaPhoto = $filePhoto->getRandomName();
            $filePhoto->move(FCPATH . 'assets/img/players', $namaPhoto);
        }

        // Simpan ke database
        $this->playersModel->save([
            'player_name' => $this->request->getPost('player_name'),
            'level'       => $this->request->getPost('level'),
            'gender'      => $this->request->getPost('gender'),
            'photo'       => $namaPhoto,
            'is_active'   => 1,
        ]);

        session()->setFlashdata('success', 'Data pemain berhasil ditambahkan!');
        return redirect()->to(site_url('admin/players'));
    }

    // ==============================
    // FORM EDIT PEMAIN (UPDATE VIEW)
    // ==============================
    public function e_players($id = null)
    {
        $pemain = $this->playersModel->find($id);

        if (!$pemain) {
            session()->setFlashdata('error', 'Data pemain tidak ditemukan.');
            return redirect()->to(site_url('admin/players'));
        }

        $data = [
            'title'      => 'Edit Pemain',
            'validation' => \Config\Services::validation(),
            'player'     => $pemain,
        ];

        echo view('templates/table_header', $data);
        echo view('templates/sidebar');
        echo view('templates/topbar');
        echo view('players/e_players', $data);
        echo view('templates/table_footer');
    }

    // ==============================
    // SIMPAN PERUBAHAN (UPDATE LOGIC)
    // ==============================
    public function update($id = null)
    {
        $pemain = $this->playersModel->find($id);

        if (!$pemain) {
            session()->setFlashdata('error', 'Data pemain tidak ditemukan.');
            return redirect()->to(site_url('admin/players'));
        }

        $validationRules = [
            'player_name' => [
                'rules'  => 'required|min_length[3]',
                'errors' => [
                    'required'   => 'Nama pemain harus diisi.',
                    'min_length' => 'Nama pemain minimal 3 karakter.',
                ],
            ],
            'level' => [
                'rules'  => 'required|in_list[Pratama,Utama]',
                'errors' => [
                    'required' => 'Level pemain harus diisi.',
                    'in_list'  => 'Level pemain tidak valid.',
                ],
            ],

            'gender' => [
                'rules'  => 'required|in_list[M,F]',
                'errors' => [
                    'required' => 'Jenis kelamin harus diisi.',
                    'in_list'  => 'Jenis kelamin tidak valid.',
                ],
            ],
            'photo' => [
                'rules'  => 'if_exist|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'is_image' => 'File harus berupa gambar.',
                    'mime_in'  => 'Format gambar tidak didukung (hanya JPG, JPEG, PNG).',
                ],
            ],
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Cek jika ada foto baru
        $filePhoto = $this->request->getFile('photo');
        $namaPhoto = $pemain['photo']; // default pakai foto lama

        if ($filePhoto && $filePhoto->isValid() && !$filePhoto->hasMoved()) {
            // Hapus foto lama
            if (!empty($pemain['photo'])) {
                $oldPath = FCPATH . 'assets/img/players/' . $pemain['photo'];
                if (is_file($oldPath)) {
                    unlink($oldPath);
                }
            }

            // Upload foto baru
            $namaPhoto = $filePhoto->getRandomName();
            $filePhoto->move(FCPATH . 'assets/img/players', $namaPhoto);
        }

        // Update ke database
        $this->playersModel->update($id, [
            'player_name' => $this->request->getPost('player_name'),
            'level'       => $this->request->getPost('level'),
            'gender'      => $this->request->getPost('gender'),
            'photo'       => $namaPhoto,
            'is_active'   => $this->request->getPost('is_active'),
        ]);

        session()->setFlashdata('success', 'Data pemain berhasil diperbarui!');
        return redirect()->to(site_url('admin/players'));
    }

    // ==============================
    // HAPUS PEMAIN (DELETE)
    // ==============================
    public function d_players($id = null)
    {
        if (!$id) {
            session()->setFlashdata('error', 'ID pemain tidak ditemukan.');
            return redirect()->to(site_url('admin/players'));
        }

        $pemain = $this->playersModel->find($id);

        if ($pemain) {
            if (!empty($pemain['photo'])) {
                $filePath = FCPATH . 'assets/img/players/' . $pemain['photo'];
                if (is_file($filePath)) {
                    unlink($filePath);
                }
            }

            $this->playersModel->delete($id);
            session()->setFlashdata('success', 'Data pemain berhasil dihapus!');
        } else {
            session()->setFlashdata('error', 'Data pemain tidak ditemukan.');
        }

        return redirect()->to(site_url('admin/players'));
    }
}
