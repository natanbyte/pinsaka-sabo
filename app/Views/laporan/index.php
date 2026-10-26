<?php
$katAktif = $kategoriAktif ?? null;
$stAktif  = $statusAktif ?? null;

/** Helper untuk membangun URL filter gabungan */
$makeFilterUrl = static function (?string $st, ?string $kat) {
    $params = [];
    if ($st !== null && $st !== '') {
        $params['status'] = $st;
    }
    if ($kat !== null && $kat !== '') {
        $params['kategori'] = $kat;
    }
    return site_url('laporan') . ($params !== [] ? '?' . http_build_query($params) : '');
};
?>
<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>

<!-- Modul Stylesheet & Script Scoped -->
<link rel="stylesheet" href="<?= base_url('css/laporan-kerusakan.css') ?>">
<script src="<?= base_url('js/laporan-kerusakan.js') ?>" defer></script>

<div class="lk-module-wrapper">

    <!-- Header Halaman Register Laporan -->
    <header class="lk-page-header">
        <div>
            <div class="lk-breadcrumb">
                <span>Registrasi &amp; Penanganan Berkas</span>
                <span class="text-slate-300">/</span>
                <span>Balai Teknik Sabo</span>
            </div>
            <h1 class="lk-page-title">Register Laporan Kerusakan</h1>
            <p class="lk-page-desc">
                <?= $isAdmin
                    ? 'Monitoring dan penanganan seluruh berkas laporan kerusakan sarana kerja, instalasi laboratorium, dan armada kendaraan dinas.'
                    : 'Riwayat pengajuan laporan kerusakan sarana prasarana dan armada kendaraan dinas yang Anda ajukan.' ?>
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a href="<?= site_url('laporan/buat') ?>" class="lk-btn lk-btn-primary">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Buat Laporan Baru</span>
            </a>
        </div>
    </header>

    <!-- Toolbar Filter & Pencarian -->
    <div class="lk-toolbar">
        <!-- Filter Kategori & Status Pills -->
        <div class="lk-toolbar-left">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider mr-1">Kategori:</span>
            <div class="lk-pill-group">
                <!-- Semua Objek -->
                <a href="<?= $makeFilterUrl($stAktif, null) ?>" class="lk-pill <?= $katAktif === null ? 'is-active' : '' ?>">
                    Semua
                    <span class="lk-pill-count"><?= (int) ($hitungKategori['semua'] ?? 0) ?></span>
                </a>

                <!-- Sarpras -->
                <a href="<?= $makeFilterUrl($stAktif, 'sarpras') ?>" class="lk-pill <?= $katAktif === 'sarpras' ? 'is-active' : '' ?>">
                    Sarpras
                    <span class="lk-pill-count"><?= (int) ($hitungKategori['sarpras'] ?? 0) ?></span>
                </a>

                <!-- Kendaraan -->
                <a href="<?= $makeFilterUrl($stAktif, 'kendaraan') ?>" class="lk-pill <?= $katAktif === 'kendaraan' ? 'is-active' : '' ?>">
                    Kendaraan Dinas
                    <span class="lk-pill-count"><?= (int) ($hitungKategori['kendaraan'] ?? 0) ?></span>
                </a>
            </div>

            <div class="hidden sm:block h-4 w-px bg-slate-300 mx-1"></div>

            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider mr-1">Status:</span>
            <div class="lk-pill-group">
                <a href="<?= $makeFilterUrl(null, $katAktif) ?>" class="lk-pill <?= $stAktif === null ? 'is-active' : '' ?>">
                    Semua Status
                </a>
                <a href="<?= $makeFilterUrl('baru', $katAktif) ?>" class="lk-pill <?= $stAktif === 'baru' ? 'is-active' : '' ?>">
                    Baru (<?= (int) ($hitungStatus['baru'] ?? 0) ?>)
                </a>
                <a href="<?= $makeFilterUrl('diproses', $katAktif) ?>" class="lk-pill <?= $stAktif === 'diproses' ? 'is-active' : '' ?>">
                    Diproses (<?= (int) ($hitungStatus['diproses'] ?? 0) ?>)
                </a>
                <a href="<?= $makeFilterUrl('selesai', $katAktif) ?>" class="lk-pill <?= $stAktif === 'selesai' ? 'is-active' : '' ?>">
                    Selesai (<?= (int) ($hitungStatus['selesai'] ?? 0) ?>)
                </a>
            </div>
        </div>

        <!-- Kolom Pencarian Instan -->
        <div class="lk-toolbar-right">
            <div class="lk-search-box">
                <svg class="lk-search-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" id="lk-search-input" placeholder="Cari kode, lokasi, atau pelapor..." class="lk-search-input" aria-label="Cari laporan">
            </div>
        </div>
    </div>

    <!-- Empty State: Jika Belum Ada Data di Database -->
    <?php if (empty($laporan)): ?>
        <div class="lk-empty-state">
            <svg class="lk-empty-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h2 class="lk-empty-title">Belum Ada Berkas Laporan</h2>
            <p class="lk-empty-desc">
                Tidak ada laporan kerusakan yang cocok dengan kriteria filter saat ini. Silakan ubah filter atau buat laporan baru.
            </p>
            <a href="<?= site_url('laporan/buat') ?>" class="lk-btn lk-btn-primary">
                Buat Laporan Pertama
            </a>
        </div>
    <?php else: ?>

        <!-- Empty State Khusus Pencarian Instan (Tampil jika filter kata kunci 0 match) -->
        <div id="lk-empty-search" class="lk-empty-state" style="display: none;">
            <svg class="lk-empty-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <h2 class="lk-empty-title">Tidak Ada Laporan yang Cocok</h2>
            <p class="lk-empty-desc">
                Kata kunci pencarian Anda tidak ditemukan pada nomor berkas, nama lokasi, nopol, atau nama pelapor.
            </p>
        </div>

        <!-- 1. Tampilan Desktop: Tabel Terstruktur & Padat Informasi -->
        <div class="lk-table-container">
            <table class="lk-table" aria-label="Tabel daftar laporan kerusakan">
                <thead>
                    <tr>
                        <th scope="col" style="width: 140px;">No. Berkas</th>
                        <th scope="col" style="width: 120px;">Kategori</th>
                        <th scope="col">Objek / Lokasi Fisik</th>
                        <th scope="col" style="width: 110px;">Tingkat</th>
                        <?php if ($isAdmin): ?>
                            <th scope="col" style="width: 160px;">Pelapor</th>
                        <?php endif; ?>
                        <th scope="col" style="width: 110px;">Tanggal</th>
                        <th scope="col" style="width: 110px;">Status</th>
                        <th scope="col" style="width: 100px; text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($laporan as $lap): ?>
                        <?php
                        $isKendaraan = ($lap['kategori_laporan'] ?? 'sarpras') === 'kendaraan';
                        $statusClass = match ($lap['status']) {
                            'diproses' => 'lk-badge-diproses',
                            'selesai'  => 'lk-badge-selesai',
                            default    => 'lk-badge-baru',
                        };
                        $tingkatClass = match ($lap['jenis_kerusakan']) {
                            'berat'  => 'lk-badge-berat',
                            'sedang' => 'lk-badge-sedang',
                            default  => 'lk-badge-ringan',
                        };
                        $lokasiTampil = $isKendaraan
                            ? ($lap['nama_kendaraan'] ?? 'Kendaraan Dinas') . (! empty($lap['nomor_polisi']) ? ' (' . $lap['nomor_polisi'] . ')' : '')
                            : ($lap['nama_lokasi'] ?? 'Lokasi Sarpras');
                        ?>
                        <tr>
                            <!-- No Berkas -->
                            <td>
                                <a href="<?= site_url('laporan/' . $lap['id']) ?>" class="font-mono font-bold text-blue-900 hover:underline">
                                    #<?= esc($lap['kode_laporan']) ?>
                                </a>
                            </td>

                            <!-- Kategori -->
                            <td>
                                <?php if ($isKendaraan): ?>
                                    <span class="lk-badge lk-badge-category" title="Armada Kendaraan Dinas">
                                        🚗 Kendaraan
                                    </span>
                                <?php else: ?>
                                    <span class="lk-badge lk-badge-category" title="Sarana & Prasarana">
                                        🏢 Sarpras
                                    </span>
                                <?php endif; ?>
                            </td>

                            <!-- Objek / Lokasi -->
                            <td>
                                <div class="font-semibold text-slate-900">
                                    <?= esc($lokasiTampil) ?>
                                </div>
                                <div class="text-[11px] text-slate-500 line-clamp-1 max-w-xs mt-0.5">
                                    <?= esc($lap['deskripsi']) ?>
                                </div>
                            </td>

                            <!-- Tingkat Urgensi -->
                            <td>
                                <span class="lk-badge <?= $tingkatClass ?>">
                                    <?= esc($lap['jenis_kerusakan']) ?>
                                </span>
                            </td>

                            <!-- Pelapor (Khusus Admin) -->
                            <?php if ($isAdmin): ?>
                                <td>
                                    <div class="font-medium text-slate-800 text-xs">
                                        <?= esc($lap['nama_lengkap']) ?>
                                    </div>
                                    <div class="text-[11px] font-mono text-slate-500">
                                        <?= esc($lap['nip']) ?>
                                    </div>
                                </td>
                            <?php endif; ?>

                            <!-- Tanggal -->
                            <td>
                                <time datetime="<?= esc($lap['created_at']) ?>" class="text-xs text-slate-600 block">
                                    <?= esc(date('d/m/Y', strtotime($lap['created_at']))) ?>
                                </time>
                                <span class="text-[10px] text-slate-400 font-mono block">
                                    <?= esc(date('H:i', strtotime($lap['created_at']))) ?> WIB
                                </span>
                            </td>

                            <!-- Status -->
                            <td>
                                <span class="lk-badge <?= $statusClass ?>">
                                    <?= esc($lap['status']) ?>
                                </span>
                            </td>

                            <!-- Tombol Aksi -->
                            <td style="text-align: right;">
                                <a href="<?= site_url('laporan/' . $lap['id']) ?>" class="lk-btn lk-btn-secondary lk-btn-sm" aria-label="Buka berkas #<?= esc($lap['kode_laporan']) ?>">
                                    Buka Berkas
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- 2. Tampilan Mobile: Kartu Ringkas Responsif (< 768px) -->
        <div class="lk-mobile-cards" aria-label="Daftar laporan versi mobile">
            <?php foreach ($laporan as $lap): ?>
                <?php
                $isKendaraan = ($lap['kategori_laporan'] ?? 'sarpras') === 'kendaraan';
                $statusClass = match ($lap['status']) {
                    'diproses' => 'lk-badge-diproses',
                    'selesai'  => 'lk-badge-selesai',
                    default    => 'lk-badge-baru',
                };
                $tingkatClass = match ($lap['jenis_kerusakan']) {
                    'berat'  => 'lk-badge-berat',
                    'sedang' => 'lk-badge-sedang',
                    default  => 'lk-badge-ringan',
                };
                $lokasiTampil = $isKendaraan
                    ? ($lap['nama_kendaraan'] ?? 'Kendaraan Dinas') . (! empty($lap['nomor_polisi']) ? ' (' . $lap['nomor_polisi'] . ')' : '')
                    : ($lap['nama_lokasi'] ?? 'Lokasi Sarpras');
                ?>
                <a href="<?= site_url('laporan/' . $lap['id']) ?>" class="lk-card-item">
                    <div class="lk-card-item-top">
                        <span class="font-mono font-bold text-xs text-blue-900">
                            #<?= esc($lap['kode_laporan']) ?>
                        </span>
                        <div class="flex items-center gap-1.5">
                            <span class="lk-badge <?= $tingkatClass ?>">
                                <?= esc($lap['jenis_kerusakan']) ?>
                            </span>
                            <span class="lk-badge <?= $statusClass ?>">
                                <?= esc($lap['status']) ?>
                            </span>
                        </div>
                    </div>

                    <h2 class="lk-card-item-title">
                        <?= esc($lokasiTampil) ?>
                    </h2>

                    <p class="lk-card-item-desc">
                        <?= esc($lap['deskripsi']) ?>
                    </p>

                    <div class="lk-card-item-bottom">
                        <div>
                            <span><?= esc($isKendaraan ? 'Armada Kendaraan' : 'Fasilitas Sarpras') ?></span>
                            <?php if ($isAdmin): ?>
                                <span> • <?= esc($lap['nama_lengkap']) ?></span>
                            <?php endif; ?>
                        </div>
                        <time datetime="<?= esc($lap['created_at']) ?>">
                            <?= esc(date('d/m/Y', strtotime($lap['created_at']))) ?>
                        </time>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

</div>

<?= $this->endSection() ?>
