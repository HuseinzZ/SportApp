<?php

namespace App\Controllers;

use App\Models\GorsModel;

class Gors extends BaseController
{
    protected $gorModel;

    public function __construct()
    {
        $this->gorModel = new GorsModel();
    }

    // ==============================
    // TAMPILKAN DAFTAR GOR (READ)
    // ==============================
    public function index()
    {
        $data = [
            'title'    => 'Master Data GOR',
            'gor_list' => $this->gorModel->orderBy('gors_name', 'ASC')->findAll(),
        ];

        echo view('templates/table_header', $data);
        echo view('templates/sidebar');
        echo view('templates/topbar');
        echo view('gors/index', $data);
        echo view('templates/table_footer');
    }

    // ==============================
    // FORM TAMBAH GOR (CREATE VIEW)
    // ==============================
    public function a_gors()
    {
        $data = [
            'title'      => 'Tambah GOR',
            'validation' => \Config\Services::validation(),
        ];

        echo view('templates/table_header', $data);
        echo view('templates/sidebar');
        echo view('templates/topbar');
        echo view('gors/a_gors', $data);
        echo view('templates/table_footer');
    }

    // ==============================
    // SIMPAN DATA GOR (CREATE LOGIC)
    // ==============================
    public function store()
    {
        $rule_gor_name = 'required|min_length[3]|is_unique[gors.gors_name]|regex_match[/^[A-Z\s]+$/]';
        $validationRules = [
            'gors_name' => [
                'rules'  => $rule_gor_name,
                'errors' => [
                    'required'    => 'Nama GOR harus diisi.',
                    'min_length'  => 'Nama minimal 3 karakter.',
                    'is_unique'   => 'Nama GOR sudah terdaftar.',
                    'regex_match' => 'Nama GOR harus menggunakan huruf kapital semua dan tidak boleh mengandung angka, titik, atau tanda hubung.'
                ],
            ],
            'address'  => 'required',
            'price'    => 'required|numeric|greater_than_equal_to[0]',
            'contact'  => 'permit_empty|max_length[20]',

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
            $filePhoto->move(FCPATH . 'assets/img/gors', $namaPhoto);
        }

        $this->gorModel->save([
            'gors_name'     => $this->request->getPost('gors_name'),
            'address'       => $this->request->getPost('address'),
            'contact'       => $this->request->getPost('contact'),
            'description'   => $this->request->getPost('description'),
            'price'         => $this->request->getPost('price'),
            'photo'         => $namaPhoto,
        ]);

        session()->setFlashdata('success', 'Data GOR berhasil ditambahkan!');
        return redirect()->to(site_url('admin/gors'));
    }

    // ==============================
    // FORM EDIT GOR (UPDATE VIEW)
    // ==============================
    public function e_gors($id = null)
    {
        $gor = $this->gorModel->find($id);

        if (!$gor) {
            session()->setFlashdata('error', 'Data GOR tidak ditemukan.');
            return redirect()->to(site_url('admin/gors'));
        }

        $data = [
            'title'      => 'Edit GOR',
            'validation' => \Config\Services::validation(),
            'gor'        => $gor,
        ];

        echo view('templates/table_header', $data);
        echo view('templates/sidebar');
        echo view('templates/topbar');
        echo view('gors/e_gors', $data);
        echo view('templates/table_footer');
    }

    // ==============================
    // SIMPAN PERUBAHAN GOR (UPDATE LOGIC)
    // ==============================
    public function update($id = null)
    {
        $gor = $this->gorModel->find($id);

        if (!$gor) {
            session()->setFlashdata('error', 'Data GOR tidak ditemukan.');
            return redirect()->to(site_url('admin/gors'));
        }

        $rule_gor_name = 'required|min_length[3]|regex_match[/^[A-Z\s]+$/]';
        $validationRules = [
            'gors_name' => [
                'rules'  => $rule_gor_name,
                'errors' => [
                    'required'    => 'Nama GOR harus diisi.',
                    'min_length'  => 'Nama minimal 3 karakter.',
                    'is_unique'   => 'Nama GOR sudah terdaftar.',
                    'regex_match' => 'Nama GOR harus menggunakan huruf kapital semua dan tidak boleh mengandung angka, titik, atau tanda hubung.'
                ],
            ],
            'address'  => 'required',
            'price'    => 'required|numeric|greater_than_equal_to[0]',
            'contact'  => 'permit_empty|max_length[20]',

            'photo' => [ // Aturan Foto
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

        // 2. Penanganan Foto
        $filePhoto = $this->request->getFile('photo');
        $namaPhoto = $gor['photo']; // Default pakai foto lama

        if ($filePhoto && $filePhoto->isValid() && !$filePhoto->hasMoved()) {
            // Hapus foto lama jika ada
            if (!empty($gor['photo'])) {
                $oldPath = FCPATH . 'assets/img/gors/' . $gor['photo'];
                if (is_file($oldPath)) {
                    unlink($oldPath);
                }
            }

            // Upload foto baru
            $namaPhoto = $filePhoto->getRandomName();
            $filePhoto->move(FCPATH . 'assets/img/gors', $namaPhoto);
        }

        // 3. Update ke Database
        $this->gorModel->update($id, [
            'gors_name'     => $this->request->getPost('gors_name'),
            'address'       => $this->request->getPost('address'),
            'contact'       => $this->request->getPost('contact'),
            'description'   => $this->request->getPost('description'),
            'price'         => $this->request->getPost('price'),
            'photo'         => $namaPhoto,
        ]);

        session()->setFlashdata('success', 'Data GOR berhasil diperbarui!');
        return redirect()->to(site_url('admin/gors'));
    }

    // ==============================
    // HAPUS GOR (DELETE)
    // ==============================
    public function d_gors($id = null)
    {
        if (!$id) {
            session()->setFlashdata('error', 'ID GOR tidak ditemukan.');
            return redirect()->to(site_url('admin/gors'));
        }

        $gor = $this->gorModel->find($id);

        if ($gor) {
            // Hapus file foto terkait jika ada
            if (!empty($gor['photo'])) {
                $filePath = FCPATH . 'assets/img/gors/' . $gor['photo'];
                if (is_file($filePath)) {
                    unlink($filePath);
                }
            }

            $this->gorModel->delete($id);
            session()->setFlashdata('success', 'Data GOR berhasil dihapus!');
        } else {
            session()->setFlashdata('error', 'Data GOR tidak ditemukan.');
        }

        return redirect()->to(site_url('admin/gors'));
    }
}
