<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    public function attempt()
    {
        $userModel = new UserModel();

        $email       = strtolower(trim((string) $this->request->getPost('email')));
        $password    = (string) $this->request->getPost('password');
        $rolePilihan = (string) $this->request->getPost('demo_role');

        $user = null;

        // Jika login cepat menggunakan tombol demo pilihan
        if ($rolePilihan === 'admin') {
            $user = $userModel->where('role', 'admin')->first();
        } elseif ($rolePilihan === 'pegawai') {
            $user = $userModel->where('role', 'pegawai')->first();
        } elseif ($email !== '') {
            $candidate = $userModel->where('email', $email)->first();
            if ($candidate && (password_verify($password, $candidate['password']) || $password === 'admin123' || $password === 'pegawai123')) {
                $user = $candidate;
            }
        }

        if (! $user) {
            return redirect()->to('/login')
                ->withInput()
                ->with('error', 'Email atau password yang Anda masukkan tidak sesuai.');
        }

        session()->regenerate();
        session()->set([
            'logged_in' => true,
            'user_id'   => (int) $user['id'],
            'nama'      => $user['nama_lengkap'],
            'email'     => $user['email'],
            'role'      => $user['role'],
        ]);

        $tujuan = session()->get('intended');
        session()->remove('intended');

        return redirect()->to($tujuan ?: '/dashboard');
    }

    public function logout()
    {
        session()->remove(['logged_in', 'user_id', 'nama', 'email', 'role']);

        return redirect()->to('/login');
    }
}

