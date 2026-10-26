<?php

// Tampilkan error jika ada agar terbaca di logs Vercel
ini_set('display_errors', '1');
error_reporting(E_ALL);

// Di environment Vercel Serverless, hanya direktori /tmp yang memiliki hak akses tulis (read-write)
if (getenv('VERCEL') || isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL'])) {
    $writablePath = '/tmp/writable';
    $subDirs = ['cache', 'session', 'logs', 'uploads', 'debugbar'];
    foreach ($subDirs as $sub) {
        $dir = $writablePath . '/' . $sub;
        if (! is_dir($dir)) {
            @mkdir($dir, 0777, true);
        }
    }
}

// Forward Vercel Serverless Function requests to CodeIgniter 4 front controller
require __DIR__ . '/../public/index.php';
