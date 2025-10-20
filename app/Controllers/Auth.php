<?php

namespace App\Controllers;

use App\Models\AdminModel;
use CodeIgniter\Controller;

class Auth extends BaseController
{
    protected $adminModel;

    public function __construct()
    {
        $this->adminModel = model(AdminModel::class);
    }

    public function index()
    {
        $validation = service('validation');

        $data = [
            'title'      => 'Login Admin',
            'validation' => $validation,
        ];

        if (session()->get('logged_in')) {
            return redirect()->to(site_url('admin/dashboard'));
        }

        $rules = [
            'username' => 'required|trim',
            'password' => [
                'rules' => 'required|trim|min_length[6]',
                'errors' => [
                    'required' => 'Password wajib diisi.',
                    'min_length' => 'Password minimal 6 karakter.'
                ]
            ],
        ];

        if ($this->request->is('post')) {
            if ($this->validate($rules)) {
                return $this->_login();
            }
        }

        echo view('templates/auth_header', $data);
        echo view('auth/index', $data);
        echo view('templates/auth_footer');
    }

    private function _login()
    {

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $admin = $this->adminModel->findByUsername($username);

        if ($admin) {
            if (password_verify($password, $admin['password'])) {
                session()->set([
                    'id_admin'  => $admin['id'],
                    'username'  => $admin['username'],
                    'logged_in' => true,
                ]);
                return redirect()->to(site_url('admin/dashboard'));
            }

            session()->setFlashdata('error', 'Password salah!');
            return redirect()->to(site_url('admin'))->withInput();
        }

        session()->setFlashdata('error', 'Username tidak ditemukan!');
        return redirect()->to(site_url('admin'))->withInput();
    }

    public function logout()
    {
        session()->destroy();
        session()->setFlashdata('success', 'Anda berhasil logout.');
        return redirect()->to(site_url('admin'));
    }

    public function blocked()
    {
        return view('auth/blocked', ['title' => 'Access Blocked']);
    }

    public function changePassword()
    {
        $validation = service('validation');
        $adminId = session()->get('id_admin');

        $data = [
            'title'      => 'Ganti Sandi Akun',
            'validation' => $validation,
        ];

        $rules = [
            'current_password' => [
                'rules' => 'required',
                'errors' => ['required' => 'Sandi lama wajib diisi.']
            ],
            'new_password' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Sandi baru wajib diisi.',
                    'min_length' => 'Sandi baru minimal 6 karakter.'
                ]
            ],
            'confirm_password' => [
                'rules' => 'required|matches[new_password]',
                'errors' => [
                    'required' => 'Konfirmasi sandi wajib diisi.',
                    'matches' => 'Konfirmasi sandi tidak cocok.'
                ]
            ],
        ];

        if ($this->request->is('post')) {
            if ($this->validate($rules)) {

                $currentPassword = $this->request->getPost('current_password');
                $newPassword = $this->request->getPost('new_password');

                $admin = $this->adminModel->find($adminId);

                if (!password_verify($currentPassword, $admin['password'])) {
                    session()->setFlashdata('error', 'Sandi lama salah!');
                    return redirect()->back()->withInput();
                }

                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                if (password_verify($newPassword, $admin['password'])) {
                    session()->setFlashdata('error', 'Sandi baru tidak boleh sama dengan sandi lama!');
                    return redirect()->back()->withInput();
                }

                $this->adminModel->update($adminId, ['password' => $hashedPassword]);

                session()->setFlashdata('success', 'Sandi berhasil diubah! Silakan login ulang.');
                session()->destroy();
                return redirect()->to(site_url('admin'));
            }
        }

        echo view('auth/change_password', $data);
    }
}
