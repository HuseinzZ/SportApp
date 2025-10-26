<?php

namespace App\Controllers;

use App\Models\GalleryModel;

class Gallery extends BaseController
{
    protected $galleryModel;

    public function __construct()
    {
        $this->galleryModel = new GalleryModel();
    }

    // ==============================
    // TAMPILKAN DAFTAR GALERI (READ)
    // ==============================
    public function index()
    {
        $data = [
            'title'      => 'Master Data Galeri',
            'gallery_list' => $this->galleryModel->orderBy('event_date', 'DESC')->findAll(),
        ];

        echo view('templates/table_header', $data);
        echo view('templates/sidebar');
        echo view('templates/topbar');
        echo view('gallery/index', $data);
        echo view('templates/table_footer');
    }

    // ==============================
    // FORM TAMBAH GALERI (CREATE VIEW)
    // ==============================
    public function a_gallery()
    {
        $data = [
            'title'      => 'Tambah Galeri',
            'validation' => \Config\Services::validation(),
        ];

        echo view('templates/table_header', $data);
        echo view('templates/sidebar');
        echo view('templates/topbar');
        echo view('gallery/a_gallery', $data);
        echo view('templates/table_footer');
    }

    // ==============================
    // SIMPAN DATA GALERI (CREATE LOGIC)
    // ==============================
    public function store()
    {
        // Aturan Validasi (Mirip Players/Gors)
        $validationRules = [
            'title' => [
                'rules'  => 'required|min_length[3]|max_length[255]',
                'errors' => [
                    'required'   => 'Judul event harus diisi.',
                    'min_length' => 'Judul minimal 3 karakter.',
                ],
            ],
            'event_date'  => 'required|valid_date',
            'description' => 'permit_empty',
            'photo' => [ // Aturan Foto
                'rules'  => 'uploaded[photo]|max_size[photo,2048]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Foto event harus diupload.',
                    'max_size' => 'Ukuran foto maksimal 2MB.',
                    'is_image' => 'File harus berupa gambar.',
                    'mime_in'  => 'Format gambar tidak didukung (hanya JPG, JPEG, PNG).',
                ],
            ],
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Upload foto
        $filePhoto = $this->request->getFile('photo');
        $namaPhoto = $filePhoto->getRandomName();
        $filePhoto->move(FCPATH . 'assets/img/gallery', $namaPhoto);

        $this->galleryModel->save([
            'title'         => $this->request->getPost('title'),
            'description'   => $this->request->getPost('description'),
            'event_date'    => $this->request->getPost('event_date'),
            'photo'         => $namaPhoto,
        ]);

        session()->setFlashdata('success', 'Galeri berhasil ditambahkan!');
        return redirect()->to(site_url('admin/gallery'));
    }

    // ==============================
    // FORM EDIT GALERI (UPDATE VIEW)
    // ==============================
    public function e_gallery($id = null)
    {
        $item = $this->galleryModel->find($id);

        if (!$item) {
            session()->setFlashdata('error', 'Data Galeri tidak ditemukan.');
            return redirect()->to(site_url('admin/gallery'));
        }

        $data = [
            'title'      => 'Edit Galeri',
            'validation' => \Config\Services::validation(),
            'item'       => $item,
        ];

        echo view('templates/table_header', $data);
        echo view('templates/sidebar');
        echo view('templates/topbar');
        echo view('gallery/e_gallery', $data);
        echo view('templates/table_footer');
    }

    // ==============================
    // SIMPAN PERUBAHAN GALERI (UPDATE LOGIC)
    // ==============================
    public function update($id = null)
    {
        $item = $this->galleryModel->find($id);

        if (!$item) {
            session()->setFlashdata('error', 'Data Galeri tidak ditemukan.');
            return redirect()->to(site_url('admin/gallery'));
        }

        // 1. Aturan Validasi
        $validationRules = [
            'title' => [
                'rules'  => 'required|min_length[3]|max_length[255]',
                'errors' => [
                    'required'   => 'Judul event harus diisi.',
                    'min_length' => 'Judul minimal 3 karakter.',
                ],
            ],
            'event_date'  => 'required|valid_date',
            'description' => 'permit_empty',
            'photo' => [ // Aturan Foto (optional untuk update)
                'rules'  => 'if_exist|max_size[photo,2048]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran foto maksimal 2MB.',
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
        $namaPhoto = $item['photo']; // Default pakai foto lama

        if ($filePhoto && $filePhoto->isValid() && !$filePhoto->hasMoved()) {
            // Hapus foto lama jika ada
            if (!empty($item['photo'])) {
                $oldPath = FCPATH . 'assets/img/gallery/' . $item['photo'];
                if (is_file($oldPath)) {
                    unlink($oldPath);
                }
            }

            // Upload foto baru
            $namaPhoto = $filePhoto->getRandomName();
            $filePhoto->move(FCPATH . 'assets/img/gallery', $namaPhoto);
        }

        // 3. Update ke Database
        $this->galleryModel->update($id, [
            'title'         => $this->request->getPost('title'),
            'description'   => $this->request->getPost('description'),
            'event_date'    => $this->request->getPost('event_date'),
            'photo'         => $namaPhoto,
        ]);

        session()->setFlashdata('success', 'Galeri berhasil diperbarui! ');
        return redirect()->to(site_url('admin/gallery'));
    }

    // ==============================
    // HAPUS GALERI (DELETE)
    // ==============================
    public function d_gallery($id = null)
    {
        if (!$id) {
            session()->setFlashdata('error', 'ID Galeri tidak ditemukan.');
            return redirect()->to(site_url('admin/gallery'));
        }

        $item = $this->galleryModel->find($id);

        if ($item) {
            // Hapus file foto terkait jika ada
            if (!empty($item['photo'])) {
                $filePath = FCPATH . 'assets/img/gallery/' . $item['photo'];
                if (is_file($filePath)) {
                    unlink($filePath);
                }
            }

            $this->galleryModel->delete($id);
            session()->setFlashdata('success', 'Galeri berhasil dihapus!');
        } else {
            session()->setFlashdata('error', 'Data Galeri tidak ditemukan.');
        }

        return redirect()->to(site_url('admin/gallery'));
    }
}
