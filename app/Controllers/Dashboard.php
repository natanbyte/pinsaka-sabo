<?php

namespace App\Controllers;

use App\Models\LaporanKerusakanModel;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $laporanModel = new LaporanKerusakanModel();

        $role    = session()->get('role');
        $isAdmin = $role === 'admin';
        $userId  = $isAdmin ? null : (int) session()->get('user_id');

        return view('dashboard/index', [
            'title'          => 'Dashboard',
            'nama'           => session()->get('nama'),
            'isAdmin'        => $isAdmin,
            // Admin: ringkasan semua laporan. Pegawai: ringkasan laporan miliknya.
            'hitung'         => $laporanModel->hitungPerStatus($userId),
            'hitungKategori' => $laporanModel->hitungPerKategori($userId),
            'terbaru'        => $isAdmin ? array_slice($laporanModel->daftar(), 0, 5) : [],
        ]);
    }
}

