<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Sistem - PINSAKA Balai Teknik Sabo</title>
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
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased flex flex-col justify-between relative overflow-hidden px-4 py-8">

    <!-- Subtle Topographic Contour SVG Background Motif (Field Inspection / Sabo Sediment Basin) -->
    <div class="pointer-events-none absolute inset-0 opacity-[0.04] select-none overflow-hidden" aria-hidden="true">
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
        <a href="<?= site_url('/') ?>" class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-600 hover:text-blue-700 transition-colors">
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
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-blue-700 text-white font-bold text-sm tracking-widest shadow-md shadow-blue-700/20 mb-3">
                SABO
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">PINSAKA</h1>
            <p class="text-xs text-slate-500 font-medium mt-1">
                Balai Teknik Sabo · Ditjen SDA, Kementerian PUPR
            </p>
            <p class="text-xs text-slate-600 mt-1">
                Sistem Pelayanan Internal Sarana dan Prasarana
            </p>
        </div>

        <!-- Login Card -->
        <div class="bg-white border border-slate-200/90 rounded-2xl shadow-sm p-6 sm:p-8">
            <div class="border-b border-slate-100 pb-4 mb-5">
                <h2 class="text-lg font-semibold text-slate-900">Masuk ke Akun Anda</h2>
                <p class="text-xs text-slate-500 mt-1">Masukkan email dan kata sandi yang telah terdaftar untuk melanjutkan.</p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div role="alert" class="mb-5 flex items-start gap-2.5 rounded-xl border border-red-200 bg-red-50/90 p-3 text-xs text-red-800">
                    <svg class="w-4 h-4 text-red-600 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-medium leading-relaxed"><?= esc(session()->getFlashdata('error')) ?></span>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('login') ?>" method="post" class="space-y-4">
                <?= csrf_field() ?>

                <div>
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-1.5">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                        <input type="email" id="email" name="email" value="<?= esc(old('email')) ?>" required autofocus
                               placeholder="nama@pinsaka.test atau email kedinasan"
                               class="w-full rounded-xl border border-slate-300 bg-white pl-9 pr-3 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-700 focus:ring-1 focus:ring-blue-700 focus:outline-none transition-colors">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-1.5">
                        Kata Sandi
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" id="password" name="password" required
                               placeholder="Masukkan kata sandi Anda"
                               class="w-full rounded-xl border border-slate-300 bg-white pl-9 pr-10 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-700 focus:ring-1 focus:ring-blue-700 focus:outline-none transition-colors">
                        <button type="button" id="toggle-password" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600 focus:outline-none" title="Lihat/Sembunyikan Kata Sandi">
                            <svg id="eye-icon" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 bg-blue-700 hover:bg-blue-800 active:bg-blue-900 text-white font-medium py-2.5 px-4 rounded-xl text-sm transition-all shadow-md shadow-blue-700/20 hover:shadow-lg hover:shadow-blue-700/30">
                        <span>Masuk ke Sistem</span>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- Help Info -->
        <div class="text-center text-xs text-slate-500 mt-6 space-y-1">
            <p>Khusus pegawai dan pengelola fasilitas Balai Teknik Sabo.</p>
            <p class="text-slate-400">Kendala akun? Hubungi Bagian Rumah Tangga Balai Teknik Sabo.</p>
        </div>
    </div>

    <!-- Toggle Password Visibility Script -->
    <script>
        const toggleBtn = document.getElementById('toggle-password');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');

        if (toggleBtn && passwordInput) {
            toggleBtn.addEventListener('click', function () {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                
                if (isPassword) {
                    eyeIcon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                    `;
                } else {
                    eyeIcon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    `;
                }
            });
        }
    </script>

</body>
</html>
