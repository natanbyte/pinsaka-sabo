<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

register_shutdown_function(static function () {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR], true)) {
        echo '<h1>PINSAKA Startup Fatal Error:</h1>';
        echo '<pre>' . print_r($error, true) . '</pre>';
    }
});

try {
    // Di environment Vercel Serverless, pastikan /tmp/writable tersedia
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

    // Forward ke CodeIgniter 4 front controller
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    echo '<h1>PINSAKA Exception Error:</h1>';
    echo '<p><strong>Message:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>';
    echo '<p><strong>File:</strong> ' . htmlspecialchars($e->getFile()) . ' on line ' . $e->getLine() . '</p>';
    echo '<pre>' . htmlspecialchars($e->getTraceAsString()) . '</pre>';
}
