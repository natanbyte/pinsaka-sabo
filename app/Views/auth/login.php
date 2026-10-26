<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Sistem - Pinsaka Balai Teknik Sabo</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }
        @media (prefers-reduced-motion: reduce) {
            * { transition: none !important; animation: none !important; }
        }
        a:focus-visible, button:focus-visible, input:focus-visible {
            outline: 2px solid #1e40af !important;
            outline-offset: 2px !important;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-100 text-slate-800 antialiased flex flex-col justify-between relative overflow-hidden px-4 py-8">

    <!-- Subtle Topographic Contour SVG Background Motif (Field Inspection / Sabo Sediment Basin) -->
    <div class="pointer-events-none absolute inset-0 opacity-[0.06] select-none overflow-hidden" aria-hidden="true">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000" preserveAspectRatio="none">
            <path d="M-100,200 C300,100 500,400 1100,150" fill="none" stroke="#0f172a" stroke-width="2" />
            <path d="M-100,350 C250,250 600,550 1100,300" fill="none" stroke="#0f172a" stroke-width="2" />
            <path d="M-100,500 C400,350 450,700 1100,450" fill="none" stroke="#0f172a" stroke-width="2" />
            <path d="M-100,650 C200,600 700,800 1100,600" fill="none" stroke="#0f172a" stroke-width="2" />
            <path d="M-100,800 C350,750 550,950 1100,750" fill="none" stroke="#0f172a" stroke-width="2" />
        </svg>
    </div>

    <!-- Top back link -->
    <div class="max-w-md w-full mx-auto relative z-10">
        <a href="<?= site_url('/') ?>" class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-500 hover:text-blue-800 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Beranda Utama
        </a>
    </div>

    <!-- Login Container -->
    <div class="w-full max-w-md mx-auto my-auto relative z-10">
        <!-- Institution Header -->
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-11 h-11 rounded bg-blue-800 text-white font-bold text-sm tracking-widest mb-3">
                SABO
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">PINSAKA</h1>
            <p class="text-xs text-slate-500 font-medium mt-1">
                Balai Teknik Sabo · Ditjen SDA, Kementerian PUPR
            </p>
            <p class="text-xs text-slate-600 mt-2">
                Sistem Pelayanan Internal Sarana dan Prasarana
            </p>
        </div>

        <!-- Login Card -->
        <div class="bg-white border border-slate-300 rounded-lg shadow-sm p-6 sm:p-8">
            <div class="border-b border-slate-100 pb-4 mb-4">
                <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200 mb-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                    Terkoneksi Database MySQL (Aktif)
                </div>
                <h2 class="text-base font-semibold text-slate-900">Akses Pengujian Sistem</h2>
                <p class="text-xs text-slate-500 mt-0.5">Pilih salah satu peran di bawah untuk langsung mencoba aplikasi:</p>
            </div>

            <!-- Tombol 1-Klik Masuk Cepat Demo -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 mb-5">
                <form action="<?= site_url('login') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="demo_role" value="pegawai">
                    <button type="submit"
                            class="w-full text-left p-3 rounded border border-blue-200 bg-blue-50/70 hover:bg-blue-100/80 hover:border-blue-300 transition-colors">
                        <div class="font-semibold text-xs text-blue-900 flex items-center justify-between">
                            <span>Akun Pegawai</span>
                            <span class="text-[10px] bg-blue-200/80 text-blue-800 px-1.5 py-0.2 rounded font-mono">Pelapor</span>
                        </div>
                        <div class="text-[11px] text-blue-700 mt-1">Buat & pantau laporan kerusakan</div>
                    </button>
                </form>

                <form action="<?= site_url('login') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="demo_role" value="admin">
                    <button type="submit"
                            class="w-full text-left p-3 rounded border border-purple-200 bg-purple-50/70 hover:bg-purple-100/80 hover:border-purple-300 transition-colors">
                        <div class="font-semibold text-xs text-purple-900 flex items-center justify-between">
                            <span>Akun Administrator</span>
                            <span class="text-[10px] bg-purple-200/80 text-purple-800 px-1.5 py-0.2 rounded font-mono">Pengelola</span>
                        </div>
                        <div class="text-[11px] text-purple-700 mt-1">Kelola & perbarui status laporan</div>
                    </button>
                </form>
            </div>

            <div class="relative flex items-center justify-center my-4">
                <div class="border-t border-slate-200 w-full"></div>
                <span class="bg-white px-2.5 text-[11px] text-slate-400 uppercase tracking-wider font-semibold">atau ketik manual</span>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div role="alert" class="mb-4 flex items-start gap-2.5 rounded border border-red-200 bg-red-50 p-2.5 text-xs text-red-900">
                    <span class="font-medium"><?= esc(session()->getFlashdata('error')) ?></span>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('login') ?>" method="post" class="space-y-3.5">
                <?= csrf_field() ?>

                <div>
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-1">
                        Alamat Email
                    </label>
                    <input type="email" id="email" name="email" value="<?= esc(old('email', 'pegawai@pinsaka.test')) ?>" required
                           placeholder="nama@pinsaka.test"
                           class="w-full rounded border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-700 focus:outline-none transition-colors">
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-1">
                        Kata Sandi
                    </label>
                    <input type="password" id="password" name="password" value="123456" required
                           placeholder="Bebas diisi"
                           class="w-full rounded border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-700 focus:outline-none transition-colors">
                </div>

                <div class="pt-1">
                    <button type="submit"
                            class="w-full bg-slate-800 hover:bg-slate-900 text-white font-medium py-2 px-4 rounded text-sm transition-colors shadow-sm">
                        Masuk Menggunakan Email
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer Note -->
    <div class="text-center text-xs text-slate-400 mt-6 relative z-10">
        Khusus pegawai dan pengelola fasilitas Balai Teknik Sabo.
    </div>

</body>
</html>
