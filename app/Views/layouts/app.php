<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Pinsaka') ?> - Balai Teknik Sabo</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Plus Jakarta Sans for crisp technical documentation -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }
        @media (prefers-reduced-motion: reduce) {
            * { transition: none !important; animation: none !important; }
        }
        /* Accessible visible focus indicator */
        a:focus-visible, button:focus-visible, input:focus-visible, select:focus-visible, textarea:focus-visible {
            outline: 2px solid #2563eb !important;
            outline-offset: 2px !important;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-100 text-slate-800 antialiased flex flex-col">

    <!-- Top Technical Header -->
    <header class="sticky top-0 z-40 bg-white border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between gap-4">
            <!-- Brand & Institution Mark -->
            <a href="<?= site_url('dashboard') ?>" class="flex items-center gap-2.5 focus:outline-none">
                <div class="w-8 h-8 rounded bg-blue-800 text-white flex items-center justify-center font-bold text-xs tracking-wider" aria-hidden="true">
                    SABO
                </div>
                <div class="flex items-baseline">
                    <span class="text-lg font-bold tracking-tight text-slate-900">PINSAKA</span>
                    <span class="hidden md:inline-block text-xs text-slate-500 font-medium ml-2.5 pl-2.5 border-l border-slate-300">
                        Balai Teknik Sabo
                    </span>
                </div>
            </a>

            <!-- Navigation and User Bar -->
            <div class="flex items-center gap-2 sm:gap-4">
                <nav class="flex items-center gap-1 sm:gap-2">
                    <a href="<?= site_url('dashboard') ?>"
                       class="text-xs sm:text-sm font-medium px-2.5 py-1.5 rounded text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors">
                        Dasbor
                    </a>
                    <a href="<?= site_url('laporan') ?>"
                       class="text-xs sm:text-sm font-medium px-2.5 py-1.5 rounded text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors">
                        Laporan
                    </a>
                </nav>

                <div class="h-4 w-px bg-slate-200 hidden sm:block" aria-hidden="true"></div>

                <!-- User identity -->
                <div class="hidden sm:flex items-center gap-2 text-xs">
                    <span class="font-medium text-slate-700"><?= esc(session()->get('nama')) ?></span>
                    <span class="bg-slate-100 text-slate-600 border border-slate-200 px-1.5 py-0.5 rounded font-mono uppercase text-[11px]">
                        <?= esc(session()->get('role')) ?>
                    </span>
                </div>

                <!-- Logout Form -->
                <form action="<?= site_url('logout') ?>" method="post" class="inline">
                    <?= csrf_field() ?>
                    <button type="submit"
                            class="text-xs sm:text-sm font-medium text-slate-500 hover:text-red-700 px-2 py-1.5 rounded hover:bg-red-50 transition-colors">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Workspace Area -->
    <main class="flex-1 max-w-6xl w-full mx-auto px-4 sm:px-6 py-6 sm:py-8">
        <!-- Flash Alert Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div role="alert" class="mb-5 flex items-start gap-3 rounded-md bg-emerald-50 border border-emerald-200 p-3.5 text-sm text-emerald-900">
                <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <p class="font-medium leading-relaxed"><?= esc(session()->getFlashdata('success')) ?></p>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div role="alert" class="mb-5 flex items-start gap-3 rounded-md bg-red-50 border border-red-200 p-3.5 text-sm text-red-900">
                <svg class="w-5 h-5 text-red-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <p class="font-medium leading-relaxed"><?= esc(session()->getFlashdata('error')) ?></p>
            </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </main>

    <!-- Technical Institutional Footer -->
    <footer class="mt-auto border-t border-slate-200 bg-white py-5 text-xs text-slate-500">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 flex flex-col sm:flex-row items-center justify-between gap-2 text-center sm:text-left">
            <div>
                <span class="font-semibold text-slate-700">Balai Teknik Sabo</span> — Direktorat Jenderal Sumber Daya Air, Kementerian PUPR
            </div>
            <div class="text-slate-400">
                Sistem Pengajuan Peminjaman dan Pelaporan Sarana Prasarana
            </div>
        </div>
    </footer>

</body>
</html>
