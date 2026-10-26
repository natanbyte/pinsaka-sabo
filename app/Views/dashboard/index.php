<?php
$total = array_sum($hitung);
$warnaJenis  = [
    'ringan' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
    'sedang' => 'bg-amber-50 text-amber-800 border-amber-200',
    'berat'  => 'bg-red-50 text-red-800 border-red-200',
];
$warnaStatus = [
    'baru'     => 'bg-blue-50 text-blue-800 border-blue-200',
    'diproses' => 'bg-amber-50 text-amber-800 border-amber-200',
    'selesai'  => 'bg-emerald-50 text-emerald-800 border-emerald-200',
];
$kartu = [
    [
        'label'      => $isAdmin ? 'Semua laporan' : 'Laporan saya',
        'keterangan' => 'Total terdaftar',
        'nilai'      => $total,
        'url'        => site_url('laporan'),
        'angkaWarna' => 'text-slate-900',
    ],
    [
        'label'      => 'Baru masuk',
        'keterangan' => 'Menunggu verifikasi',
        'nilai'      => $hitung['baru'],
        'url'        => site_url('laporan?status=baru'),
        'angkaWarna' => 'text-blue-800',
    ],
    [
        'label'      => 'Sedang diproses',
        'keterangan' => 'Dalam penanganan teknis',
        'nilai'      => $hitung['diproses'],
        'url'        => site_url('laporan?status=diproses'),
        'angkaWarna' => 'text-amber-800',
    ],
    [
        'label'      => 'Selesai',
        'keterangan' => 'Fasilitas pulih',
        'nilai'      => $hitung['selesai'],
        'url'        => site_url('laporan?status=selesai'),
        'angkaWarna' => 'text-emerald-800',
    ],
];
?>
<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>

    <!-- Header Dasbor -->
    <div class="border-b border-slate-200 pb-5 mb-6">
        <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">
            Selamat bertugas, <?= esc($nama) ?>
        </h1>
        <p class="mt-1 text-xs sm:text-sm text-slate-600 max-w-2xl leading-relaxed">
            <?= $isAdmin
                ? 'Panel verifikasi dan tindak lanjut laporan kerusakan sarana-prasarana serta armada kendaraan dinas Balai Teknik Sabo.'
                : 'Portal pelaporan kondisi sarana kerja, fasilitas kantor, laboratorium, dan kendaraan dinas operasional Balai Teknik Sabo.' ?>
        </p>
    </div>

    <!-- Papan Rekapitulasi Status (Matriks Bergaris Terpadu) -->
    <section aria-labelledby="status-rekap-heading" class="mb-6">
        <h2 id="status-rekap-heading" class="sr-only">Rekapitulasi Status Laporan</h2>
        <div class="bg-white border border-slate-200 rounded-lg overflow-hidden grid grid-cols-2 lg:grid-cols-4 divide-y sm:divide-y-0 sm:divide-x divide-slate-200">
            <?php foreach ($kartu as $k): ?>
                <a href="<?= $k['url'] ?>"
                   class="p-4 sm:p-5 hover:bg-slate-50 transition-colors focus:outline-none group">
                    <span class="text-xs font-medium text-slate-600 group-hover:text-blue-800 block transition-colors">
                        <?= esc($k['label']) ?>
                    </span>
                    <span class="text-2xl sm:text-3xl font-bold <?= $k['angkaWarna'] ?> mt-1 block">
                        <?= (int) $k['nilai'] ?>
                    </span>
                    <span class="text-[11px] text-slate-400 mt-1 block">
                        <?= esc($k['keterangan']) ?>
                    </span>
                </a>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Kartu Pembagian Kategori: Sarpras & Kendaraan Dinas -->
    <div class="grid gap-4 sm:grid-cols-2 mb-8">
        <!-- Kotak Sarpras -->
        <div class="bg-white border border-slate-200 rounded-lg p-4 sm:p-5 flex items-center justify-between hover:border-blue-400 transition-colors">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-lg bg-blue-50 text-blue-800 border border-blue-100 flex items-center justify-center shrink-0" aria-hidden="true">
                    <svg class="w-5 h-5 text-blue-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Sarana &amp; Prasarana</h3>
                    <p class="text-xs text-slate-500">Gedung, ruang rapat, laboratorium hidraulika</p>
                    <span class="text-xs font-semibold text-blue-800 mt-1 inline-block">
                        <?= (int) ($hitungKategori['sarpras'] ?? 0) ?> berkas laporan aktif
                    </span>
                </div>
            </div>
            <div class="shrink-0">
                <a href="<?= site_url('laporan?kategori=sarpras') ?>"
                   class="border border-slate-300 bg-white hover:bg-slate-50 hover:border-slate-400 text-slate-800 text-xs sm:text-sm font-semibold px-4 py-2 rounded-md shadow-xs transition-colors inline-flex items-center gap-1.5"
                   aria-label="Lihat rekapitulasi laporan sarana dan prasarana">
                    <span>Lihat Rekap</span>
                    <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Kotak Kendaraan Dinas -->
        <div class="bg-white border border-slate-200 rounded-lg p-4 sm:p-5 flex items-center justify-between hover:border-indigo-400 transition-colors">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-lg bg-indigo-50 text-indigo-800 border border-indigo-100 flex items-center justify-center shrink-0" aria-hidden="true">
                    <svg class="w-5 h-5 text-indigo-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-1.5">
                        <h3 class="text-sm font-bold text-slate-900">Kendaraan Dinas</h3>
                        <span class="bg-indigo-100 text-indigo-800 text-[10px] font-semibold px-1.5 py-0.2 rounded uppercase">
                            Bon / Dinas
                        </span>
                    </div>
                    <p class="text-xs text-slate-500">Truk lapangan 4x4, SUV inspeksi, mobil kantor</p>
                    <span class="text-xs font-semibold text-indigo-800 mt-1 inline-block">
                        <?= (int) ($hitungKategori['kendaraan'] ?? 0) ?> berkas laporan aktif
                    </span>
                </div>
            </div>
            <div class="shrink-0">
                <a href="<?= site_url('laporan?kategori=kendaraan') ?>"
                   class="border border-slate-300 bg-white hover:bg-slate-50 hover:border-slate-400 text-slate-800 text-xs sm:text-sm font-semibold px-4 py-2 rounded-md shadow-xs transition-colors inline-flex items-center gap-1.5"
                   aria-label="Lihat rekapitulasi laporan kendaraan dinas">
                    <span>Lihat Rekap</span>
                    <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Panel Petunjuk dan Akses Cepat Layanan -->
    <div class="bg-white border border-slate-200 rounded-lg p-5 sm:p-6 mb-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="max-w-xl">
                <h2 class="text-base font-semibold text-slate-900">
                    Pelaporan Kerusakan Fasilitas &amp; Armada Lapangan
                </h2>
                <p class="mt-1 text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Sampaikan kendala fisik ruang rapat (Merapi, Semeru), instalasi hidraulika Sabo, maupun kendala rem, mesin, ban, atau AC pada kendaraan dinas operasional untuk ditangani oleh pengelola fasilitas.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2 shrink-0">
                <a href="<?= site_url('laporan/buat') ?>"
                   class="bg-blue-800 hover:bg-blue-900 text-white text-xs sm:text-sm font-semibold px-4 py-2.5 rounded shadow-sm transition-colors inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Buat Laporan Baru</span>
                </a>
                <a href="<?= site_url('laporan') ?>"
                   class="border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 text-xs sm:text-sm font-medium px-4 py-2.5 rounded transition-colors inline-flex items-center gap-1.5">
                    <span><?= $isAdmin ? 'Seluruh Register' : 'Riwayat Laporan' ?></span>
                </a>
            </div>
        </div>
    </div>

    <?php if ($isAdmin): ?>
        <!-- Tabel Register Laporan Masuk Terbaru (Khusus Admin) -->
        <section aria-labelledby="terbaru-heading" class="mt-8">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <h2 id="terbaru-heading" class="text-base font-semibold text-slate-900">
                        Laporan Masuk Terbaru
                    </h2>
                    <p class="text-xs text-slate-500">Lima laporan terakhir yang membutuhkan verifikasi atau pemantauan tindak lanjut.</p>
                </div>
                <a href="<?= site_url('laporan') ?>" class="text-xs font-medium text-blue-800 hover:underline">
                    Buka seluruh register &rarr;
                </a>
            </div>

            <?php if (empty($terbaru)): ?>
                <div class="bg-white border border-dashed border-slate-300 rounded-lg p-8 text-center text-xs sm:text-sm text-slate-500">
                    Belum ada laporan kerusakan yang tercatat dalam sistem.
                </div>
            <?php else: ?>
                <div class="border border-slate-200 bg-white rounded-lg overflow-x-auto shadow-sm">
                    <table class="min-w-full text-xs sm:text-sm text-left">
                        <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold uppercase tracking-wider text-[11px]">
                            <tr>
                                <th scope="col" class="px-4 py-3">Kode Laporan</th>
                                <th scope="col" class="px-4 py-3">Kategori</th>
                                <th scope="col" class="px-4 py-3">Objek / Lokasi Kerusakan</th>
                                <th scope="col" class="px-4 py-3">Pelapor</th>
                                <th scope="col" class="px-4 py-3">Tingkat</th>
                                <th scope="col" class="px-4 py-3">Status</th>
                                <th scope="col" class="px-4 py-3 text-right">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php foreach ($terbaru as $l): ?>
                                <?php $isKendaraan = ($l['kategori_laporan'] ?? 'sarpras') === 'kendaraan'; ?>
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="px-4 py-3 font-mono font-medium text-slate-900 whitespace-nowrap">
                                        <?= esc($l['kode_laporan']) ?>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <?php if ($isKendaraan): ?>
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-semibold bg-indigo-50 text-indigo-800 border border-indigo-200">
                                                🚗 Kendaraan
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-semibold bg-blue-50 text-blue-800 border border-blue-200">
                                                🏢 Sarpras
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="font-medium text-slate-900">
                                            <?= esc($l['nama_kendaraan'] ?? $l['nama_lokasi']) ?>
                                        </div>
                                        <?php if ($isKendaraan && ! empty($l['nomor_polisi'])): ?>
                                            <span class="text-[10px] font-mono font-bold bg-slate-900 text-white px-1.5 py-0.2 rounded">
                                                <?= esc($l['nomor_polisi']) ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 py-3 text-slate-700 whitespace-nowrap">
                                        <?= esc($l['nama_lengkap']) ?>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded border text-[11px] font-medium capitalize <?= $warnaJenis[$l['jenis_kerusakan']] ?? 'border-slate-200 text-slate-700' ?>">
                                            <?= esc($l['jenis_kerusakan']) ?>
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded border text-[11px] font-medium capitalize <?= $warnaStatus[$l['status']] ?? 'border-slate-200 text-slate-700' ?>">
                                            <?= esc($l['status']) ?>
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right whitespace-nowrap">
                                        <a href="<?= site_url('laporan/' . $l['id']) ?>"
                                           class="font-medium text-blue-800 hover:text-blue-950 hover:underline">
                                            Buka berkas &rarr;
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </section>
    <?php endif; ?>

<?= $this->endSection() ?>
