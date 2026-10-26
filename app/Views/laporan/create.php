<?php
$errors        = session()->getFlashdata('errors') ?? [];
$jenisLama     = old('jenis_kerusakan', 'sedang');
$kategoriLama  = old('kategori_laporan') ?? ($kategoriAktif ?? 'sarpras');
$kendaraanLama = old('kendaraan_id');
?>
<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>

<!-- Modul Stylesheet & Script Scoped -->
<link rel="stylesheet" href="<?= base_url('css/laporan-kerusakan.css') ?>">
<script src="<?= base_url('js/laporan-kerusakan.js') ?>" defer></script>

<div class="lk-module-wrapper max-w-4xl mx-auto">

    <!-- Tombol Navigasi Kembali -->
    <div class="mb-4">
        <a href="<?= site_url('laporan') ?>" class="lk-btn lk-btn-secondary lk-btn-sm inline-flex items-center gap-2">
            <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar Laporan
        </a>
    </div>

    <!-- Header Formulir -->
    <header class="lk-page-header">
        <div>
            <div class="lk-breadcrumb">
                <span>Modul Pelaporan Kerusakan</span>
                <span class="text-slate-300">/</span>
                <span>Balai Teknik Sabo</span>
            </div>
            <h1 class="lk-page-title">Buat Laporan Kerusakan Baru</h1>
            <p class="lk-page-desc">
                Sampaikan kendala teknis pada fasilitas sarana-prasarana atau armada kendaraan dinas operasional untuk ditindaklanjuti oleh petugas pengelola.
            </p>
        </div>
    </header>

    <!-- Ringkasan Error Validasi Sistem -->
    <?php if (! empty($errors)): ?>
        <div role="alert" aria-live="assertive" class="mb-5 rounded border border-red-300 bg-red-50 p-4 text-xs sm:text-sm text-red-900 shadow-xs">
            <div class="flex items-center gap-2 font-semibold text-red-800">
                <svg class="w-4 h-4 shrink-0 text-red-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>Mohon periksa kembali isian formulir:</span>
            </div>
            <ul class="mt-2 list-disc pl-5 space-y-1 text-red-800 text-xs">
                <?php foreach ($errors as $err): ?>
                    <li><?= esc($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Formulir Utama Laporan -->
    <form id="form-buat-laporan" action="<?= site_url('laporan/simpan') ?>" method="post" enctype="multipart/form-data" data-loading-submit class="lk-card">
        <?= csrf_field() ?>

        <div class="lk-card-body">

            <!-- 1. Pilihan Kategori Objek -->
            <fieldset class="mb-6 pb-6 border-b border-slate-200">
                <legend class="lk-label mb-1 text-sm font-semibold">
                    1. Pilih Kategori Objek Kerusakan <span class="lk-required" aria-hidden="true">*</span>
                </legend>
                <p class="lk-help-text mb-3">
                    Pilih jenis objek fisik yang mengalami gangguan kerusakan atau membutuhkan perbaikan teknis.
                </p>

                <div class="lk-category-grid">
                    <!-- Opsi Sarana Prasarana Gedung/Lab -->
                    <label id="lk-card-sarpras" class="lk-category-card <?= $kategoriLama === 'sarpras' ? 'is-active' : '' ?>">
                        <input type="radio" name="kategori_laporan" value="sarpras" required <?= $kategoriLama === 'sarpras' ? 'checked' : '' ?>>
                        <div>
                            <div class="lk-category-card-title">
                                <svg class="w-4 h-4 text-blue-800 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <span>Fasilitas Sarana &amp; Prasarana</span>
                            </div>
                            <p class="lk-category-card-desc">
                                Ruang rapat, instalasi AC, pipa uji laboratorium hidraulika Sabo, mekanika tanah, fasilitas gedung kantor, atau toilet.
                            </p>
                        </div>
                    </label>

                    <!-- Opsi Kendaraan Dinas Lapangan -->
                    <label id="lk-card-kendaraan" class="lk-category-card <?= $kategoriLama === 'kendaraan' ? 'is-active' : '' ?>">
                        <input type="radio" name="kategori_laporan" value="kendaraan" required <?= $kategoriLama === 'kendaraan' ? 'checked' : '' ?>>
                        <div>
                            <div class="lk-category-card-title">
                                <svg class="w-4 h-4 text-indigo-800 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                                </svg>
                                <span>Armada Kendaraan Dinas</span>
                            </div>
                            <p class="lk-category-card-desc">
                                Truk survei lapangan, SUV kedinasan inspeksi sabo dam, mobil operasional laboratorium, rem, kemudi, atau AC kabin.
                            </p>
                        </div>
                    </label>
                </div>
            </fieldset>

            <!-- 2A. Field Khusus Sarana & Prasarana -->
            <div id="lk-section-sarpras" class="mb-6 pb-6 border-b border-slate-200">
                <div class="lk-form-group">
                    <label for="lokasi_id" class="lk-label">
                        Lokasi / Ruangan Fasilitas Sarpras <span class="lk-required" aria-hidden="true">*</span>
                    </label>
                    <select id="lokasi_id" name="lokasi_id" class="lk-select" data-required-toggle>
                        <option value="">-- Pilih Lokasi Fasilitas Sabo --</option>
                        <?php foreach ($lokasi as $lok): ?>
                            <option value="<?= (int) $lok['id'] ?>" <?= (int) old('lokasi_id') === (int) $lok['id'] ? 'selected' : '' ?>>
                                <?= esc($lok['nama_lokasi']) ?> (<?= esc($lok['kategori']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <p class="lk-help-text">Pilih ruangan atau area spesifik di mana kerusakan fisik terjadi.</p>
                </div>
            </div>

            <!-- 2B. Field Khusus Kendaraan Dinas -->
            <div id="lk-section-kendaraan" class="mb-6 pb-6 border-b border-slate-200" style="display: none;">
                <div class="grid gap-4 sm:grid-cols-2 mb-4">
                    <!-- Pilihan Armada Terdaftar -->
                    <div class="lk-form-group sm:col-span-2">
                        <label for="lk-select-kendaraan" class="lk-label">
                            Pilih Armada Kendaraan Dinas Terdaftar
                        </label>
                        <select id="lk-select-kendaraan" name="kendaraan_id" class="lk-select">
                            <option value="">-- Pilih Armada Sabo (Atau ketik manual di bawah) --</option>
                            <?php foreach ($kendaraan as $k): ?>
                                <option value="<?= (int) $k['id'] ?>"
                                        data-nopol="<?= esc($k['nopol']) ?>"
                                        data-nama="<?= esc($k['nama']) ?>"
                                        <?= (int) $kendaraanLama === (int) $k['id'] ? 'selected' : '' ?>>
                                    <?= esc($k['nama']) ?> — Plat: <?= esc($k['nopol']) ?> (<?= esc($k['tipe']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <p class="lk-help-text">Memilih armada akan otomatis mengisi nama kendaraan dan nomor polisi.</p>
                    </div>

                    <!-- Nama Kendaraan -->
                    <div class="lk-form-group">
                        <label for="lk-input-nama-kendaraan" class="lk-label">
                            Nama / Jenis Kendaraan <span class="lk-required" aria-hidden="true">*</span>
                        </label>
                        <input type="text" id="lk-input-nama-kendaraan" name="nama_kendaraan"
                               value="<?= esc(old('nama_kendaraan')) ?>"
                               placeholder="Contoh: Toyota Hilux Double Cabin 4x4"
                               maxlength="150" class="lk-input" data-required-toggle>
                    </div>

                    <!-- Nomor Polisi (TNKB) -->
                    <div class="lk-form-group">
                        <label for="lk-input-nopol" class="lk-label">
                            Nomor Polisi (TNKB) <span class="lk-required" aria-hidden="true">*</span>
                        </label>
                        <input type="text" id="lk-input-nopol" name="nomor_polisi"
                               value="<?= esc(old('nomor_polisi')) ?>"
                               placeholder="Contoh: AB 1042 BS"
                               maxlength="20" class="lk-input font-mono uppercase" data-required-toggle>
                    </div>

                    <!-- Komponen yang Bermasalah -->
                    <div class="lk-form-group">
                        <label for="bagian_kendaraan" class="lk-label">
                            Komponen / Bagian yang Rusak <span class="lk-required" aria-hidden="true">*</span>
                        </label>
                        <select id="bagian_kendaraan" name="bagian_kendaraan" class="lk-select" data-required-toggle>
                            <option value="">-- Pilih Bagian / Komponen --</option>
                            <?php foreach ($komponenKendaraan as $komp): ?>
                                <option value="<?= esc($komp) ?>" <?= old('bagian_kendaraan') === $komp ? 'selected' : '' ?>>
                                    <?= esc($komp) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Odometer / Jarak Tempuh -->
                    <div class="lk-form-group">
                        <label for="odometer" class="lk-label">
                            Jarak Tempuh / Odometer (Opsional)
                        </label>
                        <input type="text" id="odometer" name="odometer"
                               value="<?= esc(old('odometer')) ?>"
                               placeholder="Contoh: 68.450 km"
                               maxlength="30" class="lk-input font-mono">
                    </div>

                    <!-- Lokasi Kejadian / Posisi Terakhir Kendaraan -->
                    <div class="lk-form-group sm:col-span-2">
                        <label for="lokasi_kejadian" class="lk-label">
                            Lokasi Kendaraan Saat Ini / Tempat Terjadinya Kendala (Opsional)
                        </label>
                        <input type="text" id="lokasi_kejadian" name="lokasi_kejadian"
                               value="<?= esc(old('lokasi_kejadian')) ?>"
                               placeholder="Contoh: Garasi Balai Sabo / Jalur Akses Dam Kali Krasak KM 12"
                               maxlength="200" class="lk-input">
                    </div>
                </div>
            </div>

            <!-- 3. Tingkat Urgensi / Keparahan Kerusakan -->
            <fieldset class="mb-6 pb-6 border-b border-slate-200">
                <legend class="lk-label mb-1 text-sm font-semibold">
                    2. Tingkat Keparahan Kerusakan <span class="lk-required" aria-hidden="true">*</span>
                </legend>
                <p class="lk-help-text mb-3">Taksiran dampak terhadap kelancaran operasional kerja kedinasan.</p>

                <div class="lk-severity-grid">
                    <!-- Ringan -->
                    <label class="lk-severity-chip <?= $jenisLama === 'ringan' ? 'is-active' : '' ?>">
                        <input type="radio" name="jenis_kerusakan" value="ringan" required <?= $jenisLama === 'ringan' ? 'checked' : '' ?>>
                        <div>
                            <span class="lk-severity-label">Kerusakan Ringan</span>
                            <span class="lk-severity-desc block text-[11px] text-slate-500">Masih dapat beroperasi parsial.</span>
                        </div>
                    </label>

                    <!-- Sedang -->
                    <label class="lk-severity-chip <?= $jenisLama === 'sedang' ? 'is-active' : '' ?>">
                        <input type="radio" name="jenis_kerusakan" value="sedang" required <?= $jenisLama === 'sedang' ? 'checked' : '' ?>>
                        <div>
                            <span class="lk-severity-label">Kerusakan Sedang</span>
                            <span class="lk-severity-desc block text-[11px] text-slate-500">Mengganggu fungsi operasional.</span>
                        </div>
                    </label>

                    <!-- Berat -->
                    <label class="lk-severity-chip <?= $jenisLama === 'berat' ? 'is-active' : '' ?>">
                        <input type="radio" name="jenis_kerusakan" value="berat" required <?= $jenisLama === 'berat' ? 'checked' : '' ?>>
                        <div>
                            <span class="lk-severity-label">Kerusakan Berat</span>
                            <span class="lk-severity-desc block text-[11px] text-slate-500">Tidak berfungsi sama sekali / darurat.</span>
                        </div>
                    </label>
                </div>
            </fieldset>

            <!-- 4. Uraian Masalah / Deskripsi -->
            <div class="lk-form-group">
                <div class="flex items-center justify-between mb-1">
                    <label for="deskripsi" class="lk-label mb-0">
                        3. Deskripsi Rinci Kerusakan <span class="lk-required" aria-hidden="true">*</span>
                    </label>
                    <span id="deskripsi-counter" class="text-[11px] text-slate-500 font-mono">0 / 2000 karakter</span>
                </div>
                <textarea id="deskripsi" name="deskripsi" rows="4" required minlength="10" maxlength="2000"
                          data-counter-target="deskripsi-counter" data-min-chars="10"
                          placeholder="Jelaskan secara spesifik gejala kerusakan, waktu awal kejadian, serta kronologinya. Contoh: Saat AC dinyalakan terdengar getaran kencang dari kompresor dan hembusan udara tidak dingin..."
                          class="lk-textarea"><?= esc(old('deskripsi')) ?></textarea>
                <p class="lk-help-text">Minimal 10 karakter, maksimal 2.000 karakter.</p>
            </div>

            <!-- 5. Upload Foto Dokumentasi Fisik -->
            <div class="lk-form-group">
                <label for="foto" class="lk-label mb-1">
                    4. Foto Dokumentasi Kerusakan Fisik (Maksimal 5 Foto)
                </label>
                <p class="lk-help-text mb-2">
                    Lampirkan foto fisik kondisi yang rusak untuk mempercepat verifikasi lapangan oleh teknisi/admin.
                </p>

                <div class="lk-upload-zone" onclick="document.getElementById('foto').click()">
                    <svg class="lk-upload-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <div class="lk-upload-prompt">Klik untuk memilih foto atau seret file gambar ke sini</div>
                    <div class="lk-upload-meta">Format JPG, PNG, atau WEBP. Maksimal 5MB per berkas.</div>
                    <input type="file" id="foto" name="foto[]" multiple accept="image/jpeg,image/png,image/webp"
                           class="lk-file-input sr-only" data-preview-target="preview-foto-awal">
                </div>

                <!-- Container Preview Foto -->
                <div id="preview-foto-awal" class="lk-preview-grid" aria-live="polite"></div>
            </div>

        </div>

        <!-- Tombol Aksi Form -->
        <div class="lk-card-footer">
            <a href="<?= site_url('laporan') ?>" class="lk-btn lk-btn-secondary">
                Batal
            </a>
            <button type="submit" class="lk-btn lk-btn-primary">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
                <span>Kirim Laporan Kerusakan</span>
            </button>
        </div>

    </form>

</div>

<?= $this->endSection() ?>
