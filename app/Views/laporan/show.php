<?php
$isKendaraan = ($laporan['kategori_laporan'] ?? 'sarpras') === 'kendaraan';

$tahapan = [
    'baru'     => 1,
    'diproses' => 2,
    'selesai'  => 3,
];
$tahapSekarang = $tahapan[$laporan['status']] ?? 1;

$statusClass = match ($laporan['status']) {
    'diproses' => 'lk-badge-diproses',
    'selesai'  => 'lk-badge-selesai',
    default    => 'lk-badge-baru',
};

$tingkatClass = match ($laporan['jenis_kerusakan']) {
    'berat'  => 'lk-badge-berat',
    'sedang' => 'lk-badge-sedang',
    default  => 'lk-badge-ringan',
};
?>
<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>

<!-- Modul Stylesheet & Script Scoped -->
<link rel="stylesheet" href="<?= base_url('css/laporan-kerusakan.css') ?>">
<script src="<?= base_url('js/laporan-kerusakan.js') ?>" defer></script>

<div class="lk-module-wrapper">

    <!-- Tombol Navigasi Kembali -->
    <div class="mb-4">
        <a href="<?= site_url('laporan') ?>" class="lk-btn lk-btn-secondary lk-btn-sm inline-flex items-center gap-2">
            <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar Laporan
        </a>
    </div>

    <!-- Header Dokumen Berkas Laporan -->
    <header class="lk-page-header">
        <div>
            <div class="lk-breadcrumb">
                <span>Berkas Rekam Fisik</span>
                <span class="text-slate-300">/</span>
                <span>Balai Teknik Sabo</span>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <h1 class="lk-page-title font-mono">
                    #<?= esc($laporan['kode_laporan']) ?>
                </h1>

                <?php if ($isKendaraan): ?>
                    <span class="lk-badge lk-badge-category">🚗 Kendaraan Dinas</span>
                <?php else: ?>
                    <span class="lk-badge lk-badge-category">🏢 Sarana &amp; Prasarana</span>
                <?php endif; ?>

                <span class="lk-badge <?= $statusClass ?>">
                    Status: <?= esc($laporan['status']) ?>
                </span>
            </div>
            <p class="lk-page-desc text-xs text-slate-500 mt-1">
                Dicatat dalam sistem pada <time datetime="<?= esc($laporan['created_at']) ?>"><?= esc(date('d F Y, H:i', strtotime($laporan['created_at']))) ?> WIB</time>
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a href="<?= site_url('laporan/buat') ?>" class="lk-btn lk-btn-secondary lk-btn-sm">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Buat Laporan Lain</span>
            </a>
        </div>
    </header>

    <!-- Visualisasi Alur Status Berurutan (Workflow Tracker 1-2-3) -->
    <section aria-label="Alur Penanganan" class="lk-card p-4 sm:p-5 mb-6">
        <h2 class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-3">
            Tahapan Penanganan Laporan
        </h2>

        <div class="lk-workflow">
            <!-- Tahap 1: Baru Masuk -->
            <div class="lk-workflow-step <?= $tahapSekarang >= 1 ? ($tahapSekarang === 1 ? 'is-active' : 'is-done') : '' ?>">
                <div class="lk-workflow-number">
                    <?= $tahapSekarang > 1 ? '✓' : '1' ?>
                </div>
                <div>
                    <div class="lk-workflow-title">1. Baru Masuk</div>
                    <div class="lk-workflow-desc">
                        Laporan terdaftar, menunggu verifikasi teknis pengelola sarpras.
                    </div>
                </div>
            </div>

            <!-- Tahap 2: Sedang Diproses -->
            <div class="lk-workflow-step <?= $tahapSekarang >= 2 ? ($tahapSekarang === 2 ? 'is-active' : 'is-done') : '' ?>">
                <div class="lk-workflow-number">
                    <?= $tahapSekarang > 2 ? '✓' : '2' ?>
                </div>
                <div>
                    <div class="lk-workflow-title">2. Sedang Diproses</div>
                    <div class="lk-workflow-desc">
                        <?= $isKendaraan
                            ? 'Pemeriksaan teknis armada & penanganan di bengkel resmi rekanan.'
                            : 'Pemeriksaan lapangan & perbaikan fisik oleh tim teknisi Balai Sabo.' ?>
                    </div>
                </div>
            </div>

            <!-- Tahap 3: Selesai -->
            <div class="lk-workflow-step <?= $tahapSekarang >= 3 ? 'is-done' : '' ?>">
                <div class="lk-workflow-number">
                    <?= $tahapSekarang >= 3 ? '✓' : '3' ?>
                </div>
                <div>
                    <div class="lk-workflow-title">3. Penanganan Selesai</div>
                    <div class="lk-workflow-desc">
                        Perbaikan tuntas, sarpras atau kendaraan telah siap digunakan kembali.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Layout Dua Kolom: Rincian Teknis & Data Pelapor -->
    <div class="grid gap-6 lg:grid-cols-3">

        <!-- Kolom Kiri (2 Kolom): Detail Masalah, Foto Awal, Bukti Perbaikan, Form Admin -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Panel Rincian Kerusakan Fisik -->
            <section class="lk-card" aria-labelledby="judul-rincian">
                <div class="lk-card-header">
                    <h2 id="judul-rincian" class="lk-card-title">
                        <?= $isKendaraan ? 'Spesifikasi Kerusakan Kendaraan Dinas' : 'Rincian Kerusakan Fasilitas Sarpras' ?>
                    </h2>
                    <span class="lk-badge <?= $tingkatClass ?>">
                        Tingkat: <?= esc($laporan['jenis_kerusakan']) ?>
                    </span>
                </div>

                <div class="lk-card-body">
                    <?php if ($isKendaraan): ?>
                        <!-- Spesifikasi Kendaraan -->
                        <div class="bg-slate-50 border border-slate-200 rounded-lg p-4 mb-4">
                            <dl class="grid gap-4 sm:grid-cols-2">
                                <div>
                                    <dt class="lk-dt">Armada Kendaraan Dinas</dt>
                                    <dd class="text-sm font-bold text-slate-900">
                                        <?= esc($laporan['nama_kendaraan'] ?? $laporan['nama_lokasi']) ?>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="lk-dt">Nomor Polisi (TNKB)</dt>
                                    <dd class="mt-1">
                                        <span class="inline-block px-2.5 py-0.5 bg-slate-900 text-white font-mono font-bold text-xs rounded border border-slate-700">
                                            <?= esc($laporan['nomor_polisi'] ?? '-') ?>
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="lk-dt">Komponen Rusak</dt>
                                    <dd class="text-xs sm:text-sm font-medium text-indigo-900">
                                        <?= esc($laporan['bagian_kendaraan'] ?? 'Komponen Umum') ?>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="lk-dt">Odometer / Jarak Tempuh</dt>
                                    <dd class="text-xs sm:text-sm font-mono text-slate-700">
                                        <?= esc($laporan['odometer'] ?? 'Tidak dicantumkan') ?>
                                    </dd>
                                </div>
                                <?php if (! empty($laporan['lokasi_kejadian'])): ?>
                                    <div class="sm:col-span-2 pt-2 border-t border-slate-200">
                                        <dt class="lk-dt">Posisi / Tempat Terjadinya Kendala</dt>
                                        <dd class="text-xs sm:text-sm text-slate-800">
                                            📍 <?= esc($laporan['lokasi_kejadian']) ?>
                                        </dd>
                                    </div>
                                <?php endif; ?>
                            </dl>
                        </div>
                    <?php endif; ?>

                    <dl class="lk-dl">
                        <?php if (! $isKendaraan): ?>
                            <div>
                                <dt class="lk-dt">Lokasi Fasilitas Sarpras</dt>
                                <dd class="lk-dd text-sm font-semibold text-slate-900">
                                    <?= esc($laporan['nama_lokasi']) ?>
                                </dd>
                            </div>
                        <?php endif; ?>

                        <div>
                            <dt class="lk-dt">Klasifikasi Tingkat Dampak</dt>
                            <dd class="lk-dd capitalize">
                                <?= esc($laporan['jenis_kerusakan']) ?>
                            </dd>
                        </div>

                        <div class="lk-dl-full pt-3 border-t border-slate-100">
                            <dt class="lk-dt">Deskripsi Kronologi &amp; Gejala Kerusakan</dt>
                            <dd class="mt-1 text-xs sm:text-sm text-slate-800 leading-relaxed whitespace-pre-line bg-slate-50/70 p-3.5 rounded border border-slate-200">
                                <?= esc($laporan['deskripsi']) ?>
                            </dd>
                        </div>
                    </dl>
                </div>
            </section>

            <!-- Panel Catatan Perkembangan dari Admin (Jika ada) -->
            <?php if (! empty($laporan['catatan_admin'])): ?>
                <div class="rounded-lg border border-blue-200 bg-blue-50/70 p-5 shadow-xs">
                    <div class="flex items-center gap-2 mb-2 text-xs font-semibold text-blue-900 uppercase tracking-wider">
                        <svg class="w-4 h-4 text-blue-800 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                        <span>Catatan Tindak Lanjut dari Petugas Pengelola Sarpras</span>
                    </div>
                    <p class="whitespace-pre-line text-xs sm:text-sm text-blue-950 leading-relaxed font-medium">
                        <?= esc($laporan['catatan_admin']) ?>
                    </p>
                </div>
            <?php endif; ?>

            <!-- Panel Galeri Foto Kerusakan Awal (Pelapor) -->
            <section class="lk-card" aria-labelledby="judul-foto-awal">
                <div class="lk-card-header">
                    <h2 id="judul-foto-awal" class="lk-card-title">
                        <svg class="w-4 h-4 text-blue-800 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Dokumentasi Foto Kerusakan Awal (Pelapor)</span>
                    </h2>
                    <span class="text-xs font-mono text-slate-500 font-semibold"><?= count($foto) ?> berkas</span>
                </div>

                <div class="lk-card-body">
                    <?php if (empty($foto)): ?>
                        <p class="text-xs sm:text-sm text-slate-500 italic">Tidak ada foto dokumentasi awal yang dilampirkan.</p>
                    <?php else: ?>
                        <div class="lk-gallery">
                            <?php foreach ($foto as $f): ?>
                                <a href="<?= site_url('laporan/foto/' . $f['id']) ?>" target="_blank" rel="noopener" class="lk-gallery-item">
                                    <img src="<?= site_url('laporan/foto/' . $f['id']) ?>" alt="Foto bukti fisik awal kerusakan" class="lk-gallery-thumb">
                                    <div class="lk-gallery-overlay">
                                        <span>Bukti Awal</span>
                                        <span>Buka Foto ↗</span>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Panel Bukti Dokumentasi Hasil Perbaikan / Servis (Dari Admin -> Pelapor) -->
            <section class="lk-card <?= ! empty($fotoPerbaikan) ? 'border-emerald-300 ring-1 ring-emerald-100' : '' ?>" aria-labelledby="judul-foto-perbaikan">
                <div class="lk-card-header">
                    <div>
                        <h2 id="judul-foto-perbaikan" class="lk-card-title text-emerald-900">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Bukti Foto Hasil Perbaikan / Servis (Dari Admin)</span>
                        </h2>
                        <p class="lk-card-subtitle">
                            Dokumentasi visual hasil perbaikan fisik atau servis yang dikirimkan oleh admin kepada pelapor.
                        </p>
                    </div>
                    <span class="text-xs font-semibold font-mono <?= ! empty($fotoPerbaikan) ? 'text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200' : 'text-slate-400' ?>">
                        <?= count($fotoPerbaikan ?? []) ?> berkas
                    </span>
                </div>

                <div class="lk-card-body">
                    <?php if (empty($fotoPerbaikan)): ?>
                        <div class="rounded border border-dashed border-slate-200 bg-slate-50/60 p-4 text-center">
                            <p class="text-xs sm:text-sm text-slate-600 font-medium">Belum ada bukti foto perbaikan yang dilampirkan oleh petugas.</p>
                            <?php if (session()->get('role') === 'admin'): ?>
                                <p class="text-[11px] text-blue-700 mt-1">
                                    Gunakan formulir tindak lanjut di bawah untuk mengunggah bukti foto perbaikan fisik bagi pelapor.
                                </p>
                            <?php else: ?>
                                <p class="text-[11px] text-slate-400 mt-0.5">
                                    Foto dokumentasi penyelesaian akan muncul di sini setelah pekerjaan perbaikan didokumentasikan oleh petugas.
                                </p>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="lk-gallery">
                            <?php foreach ($fotoPerbaikan as $fp): ?>
                                <a href="<?= site_url('laporan/foto/' . $fp['id']) ?>" target="_blank" rel="noopener" class="lk-gallery-item">
                                    <img src="<?= site_url('laporan/foto/' . $fp['id']) ?>" alt="Bukti foto hasil perbaikan fisik" class="lk-gallery-thumb">
                                    <div class="lk-gallery-overlay bg-emerald-950/80">
                                        <span class="text-emerald-300 font-semibold">✓ Hasil Perbaikan</span>
                                        <span>Buka Foto ↗</span>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Panel Tindak Lanjut Khusus Hak Akses Admin -->
            <?php if (session()->get('role') === 'admin'): ?>
                <section class="lk-card border-slate-300" aria-labelledby="judul-admin-form">
                    <form action="<?= site_url('laporan/' . $laporan['id'] . '/status') ?>" method="post" enctype="multipart/form-data" data-loading-submit>
                        <?= csrf_field() ?>

                        <div class="lk-card-header bg-slate-50">
                            <div>
                                <h2 id="judul-admin-form" class="lk-card-title text-sm">
                                    <span class="w-2 h-2 rounded-full bg-blue-700 inline-block"></span>
                                    Tindak Lanjut &amp; Pengiriman Bukti (Petugas Admin)
                                </h2>
                                <p class="lk-card-subtitle">
                                    Perbarui status pengerjaan, beri instruksi/catatan, dan lampirkan bukti foto perbaikan untuk pelapor.
                                </p>
                            </div>
                        </div>

                        <div class="lk-card-body space-y-4">
                            <!-- Status Penanganan -->
                            <div class="lk-form-group">
                                <label for="status" class="lk-label">
                                    Status Penanganan Laporan <span class="lk-required" aria-hidden="true">*</span>
                                </label>
                                <select id="status" name="status" required class="lk-select sm:w-64">
                                    <?php foreach (['baru' => 'Baru Masuk', 'diproses' => 'Sedang Diproses', 'selesai' => 'Telah Selesai'] as $nilai => $label): ?>
                                        <option value="<?= $nilai ?>" <?= $laporan['status'] === $nilai ? 'selected' : '' ?>>
                                            <?= $label ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Catatan Tindak Lanjut -->
                            <div class="lk-form-group">
                                <label for="catatan_admin" class="lk-label">
                                    Catatan Perkembangan / Tindak Lanjut untuk Pelapor
                                </label>
                                <textarea id="catatan_admin" name="catatan_admin" rows="3" maxlength="1000"
                                          placeholder="Contoh: Pekerjaan perbaikan kompresor AC telah selesai dilaksanakan dan diuji coba dengan normal..."
                                          class="lk-textarea"><?= esc($laporan['catatan_admin'] ?? '') ?></textarea>
                                <p class="lk-help-text">Maksimal 1.000 karakter. Catatan ini dapat dibaca oleh pegawai pelapor.</p>
                            </div>

                            <!-- Unggah Bukti Foto Perbaikan -->
                            <div class="lk-form-group pt-2 border-t border-slate-100">
                                <label for="foto_perbaikan" class="lk-label">
                                    Unggah Bukti Foto Perbaikan / Servis (Bisa Lebih Dari 1 Foto)
                                </label>
                                <div class="mt-1">
                                    <input type="file" id="foto_perbaikan" name="foto_perbaikan[]" multiple accept="image/jpeg,image/png,image/webp"
                                           class="lk-file-input block w-full text-xs text-slate-700 file:mr-3 file:py-2 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-800 hover:file:bg-emerald-100 border border-slate-300 rounded bg-slate-50/50 p-1.5 focus:outline-none focus:border-blue-700 transition-colors"
                                           data-preview-target="preview-foto-perbaikan">
                                </div>
                                <p class="lk-help-text">
                                    Format JPG, PNG, atau WEBP, maks 5MB per berkas. Foto ini akan otomatis masuk ke panel bukti hasil perbaikan pelapor.
                                </p>
                                <div id="preview-foto-perbaikan" class="lk-preview-grid"></div>
                            </div>
                        </div>

                        <div class="lk-card-footer">
                            <button type="submit" class="lk-btn lk-btn-primary">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Simpan &amp; Kirim Bukti ke Pelapor</span>
                            </button>
                        </div>
                    </form>
                </section>
            <?php endif; ?>

        </div>

        <!-- Kolom Kanan (1 Kolom): Data Identitas Pelapor & Pedoman -->
        <aside aria-label="Identitas Pelapor" class="space-y-6">
            <section class="lk-card">
                <div class="lk-card-header">
                    <h2 class="lk-card-title text-xs uppercase tracking-wider text-slate-600">
                        Data Pegawai Pelapor
                    </h2>
                </div>

                <div class="lk-card-body">
                    <dl class="space-y-3.5 text-xs">
                        <div>
                            <dt class="lk-dt">Nama Lengkap</dt>
                            <dd class="text-sm font-semibold text-slate-900"><?= esc($laporan['nama_lengkap']) ?></dd>
                        </div>
                        <div>
                            <dt class="lk-dt">Nomor Induk Pegawai (NIP)</dt>
                            <dd class="font-mono text-slate-800 font-medium"><?= esc($laporan['nip']) ?></dd>
                        </div>
                        <div>
                            <dt class="lk-dt">Unit Kerja / Seksi</dt>
                            <dd class="text-slate-800 font-medium"><?= esc($laporan['nama_bagian'] ?? '-') ?></dd>
                        </div>
                        <div>
                            <dt class="lk-dt">Nomor Kontak (WhatsApp / HP)</dt>
                            <dd class="font-mono text-slate-800 font-medium"><?= esc($laporan['no_hp'] ?? '-') ?></dd>
                        </div>
                        <div>
                            <dt class="lk-dt">Surat Elektronik (Email)</dt>
                            <dd class="text-slate-800 font-mono break-all"><?= esc($laporan['email']) ?></dd>
                        </div>
                    </dl>
                </div>
            </section>

            <!-- Petunjuk & Prosedur -->
            <div class="rounded-lg border border-slate-200 bg-slate-50/80 p-4 text-xs text-slate-600 leading-relaxed">
                <span class="font-bold text-slate-800 block mb-1">
                    <?= $isKendaraan ? 'Pedoman Armada Kendaraan Dinas:' : 'Pedoman Sarana Prasarana:' ?>
                </span>
                <?php if ($isKendaraan): ?>
                    Untuk armada kendaraan yang mengalami kendala teknis berisiko tinggi saat survei di jalur sabo dam (mis. sistem rem atau as roda), laporkan segera ke pengelola kendaraan dinas Balai Sabo sebelum melanjutkan perjalanan.
                <?php else: ?>
                    Setiap laporan kerusakan sarana kerja diverifikasi dalam waktu maksimal 1x24 jam kerja. Untuk penanganan darurat fasilitas bernilai kritis, hubungi langsung penanggung jawab sarana prasarana Balai Sabo.
                <?php endif; ?>
            </div>
        </aside>

    </div>

</div>

<?= $this->endSection() ?>
