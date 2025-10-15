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
            return redirect()->to(site_url('dashboard'));
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

        $admin = $this->adminModel->where('username', $username)->first();

        if ($admin) {
            if (password_verify($password, $admin['password'])) {
                session()->set([
                    'id_admin'  => $admin['id'],
                    'username'  => $admin['username'],
                    'logged_in' => true,
                ]);
                return redirect()->to(site_url('dashboard'));
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
}
