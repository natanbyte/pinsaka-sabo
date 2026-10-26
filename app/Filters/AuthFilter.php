<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Pemakaian di route:
 *   'filter' => 'auth'          -> harus login
 *   'filter' => 'auth:admin'    -> harus login DAN role admin
 */
class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        if (! $session->get('logged_in')) {
            // Ingat halaman tujuan (hanya untuk GET) supaya setelah login langsung ke sana.
            if (strtolower($request->getMethod()) === 'get') {
                $session->set('intended', (string) current_url());
            }

            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if (! empty($arguments) && ! in_array($session->get('role'), $arguments, true)) {
            return redirect()->to('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman itu.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
