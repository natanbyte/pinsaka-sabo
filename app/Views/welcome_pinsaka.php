<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pinsaka - Pengajuan Peminjaman dan Pelaporan</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Inter Font & FontAwesome for icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-blue-500 selection:text-white">

    <!-- Header Navigation -->
    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-slate-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Brand Logo -->
                <div class="flex items-center space-x-3">
                    <div class="bg-blue-600 text-white p-2.5 rounded-xl shadow-md shadow-blue-500/20">
                        <i class="fa-solid fa-industry text-xl"></i>
                    </div>
                    <span class="text-xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">PINSAKA</span>
                </div>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="text-slate-600 hover:text-blue-600 font-medium transition-colors">Home</a>
                    <a href="#service" class="text-slate-600 hover:text-blue-600 font-medium transition-colors">Service</a>
                    <a href="#help" class="text-slate-600 hover:text-blue-600 font-medium transition-colors">Help</a>
                </nav>

                <!-- Action CTA -->
                <div class="hidden md:flex items-center">
                    <a href="<?= site_url('login') ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium shadow-lg shadow-blue-600/20 transition-all transform hover:-translate-y-0.5">
                        Login
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn" class="text-slate-600 hover:text-slate-900 focus:outline-none p-2">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-b border-slate-200 px-4 pt-2 pb-4 space-y-2">
            <a href="#home" class="block px-3 py-2 rounded-lg text-slate-600 hover:bg-blue-50 hover:text-blue-600 font-medium">Home</a>
            <a href="#service" class="block px-3 py-2 rounded-lg text-slate-600 hover:bg-blue-50 hover:text-blue-600 font-medium">Service</a>
            <a href="#help" class="block px-3 py-2 rounded-lg text-slate-600 hover:bg-blue-50 hover:text-blue-600 font-medium">Help</a>
        </div>
    </header>

    <!-- Section 1: Slideshow / Carousel -->
    <section id="home" class="relative overflow-hidden bg-slate-900 py-12 lg:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative rounded-2xl overflow-hidden shadow-2xl bg-slate-800 min-h-[480px] lg:min-h-[560px] flex items-center">
                
                <!-- Slide Items Container -->
                <div id="slides-container" class="absolute inset-0 w-full h-full">
                    <!-- Slide 1 -->
                    <div class="slide absolute inset-0 transition-opacity duration-1000 opacity-100 flex items-end justify-center pb-16 sm:pb-20">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/95 via-slate-950/50 to-slate-950/20 z-10"></div>
                        <img src="<?= base_url('assets/img/merapi_001.jpg') ?>" alt="Alat Berat Konstruksi" class="absolute inset-0 w-full h-full object-cover">
                        <div class="relative z-20 max-w-3xl px-6 sm:px-12 text-center text-white space-y-4 flex flex-col items-center">
                            <span class="bg-blue-500/20 text-blue-400 border border-blue-500/30 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider">Ruang Unggulan</span>
                            <h1 class="text-3xl sm:text-5xl font-bold tracking-tight leading-tight">Ruang Rapat Merapi</h1>
                            
                            <div class="pt-2 flex flex-wrap justify-center gap-4">
                                <a href="#service" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-xl shadow-lg transition-all">Lihat Layanan</a>
                                <a href="#help" class="bg-slate-800/80 hover:bg-slate-700 border border-slate-600 text-white font-medium px-6 py-3 rounded-xl transition-all">Pusat Bantuan</a>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="slide absolute inset-0 transition-opacity duration-1000 opacity-0 flex items-end justify-center pb-16 sm:pb-20">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/95 via-slate-950/50 to-slate-950/20 z-10"></div>
                        <img src="<?= base_url('assets/img/matsu_001.jpg') ?>" alt="Alat Laboratorium" class="absolute inset-0 w-full h-full object-cover">
                        <div class="relative z-20 max-w-3xl px-6 sm:px-12 text-center text-white space-y-4 flex flex-col items-center">
                            <span class="bg-indigo-500/20 text-indigo-400 border border-indigo-500/30 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider">Teknologi Modern</span>
                            <h1 class="text-3xl sm:text-5xl font-bold tracking-tight leading-tight">Hall Matsushita</h1>
                            
                            <div class="pt-2 flex flex-wrap justify-center gap-4">
                                <a href="#service" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-xl shadow-lg transition-all">Lihat Layanan</a>
                                <a href="#help" class="bg-slate-800/80 hover:bg-slate-700 border border-slate-600 text-white font-medium px-6 py-3 rounded-xl transition-all">Pusat Bantuan</a>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="slide absolute inset-0 transition-opacity duration-1000 opacity-0 flex items-end justify-center pb-16 sm:pb-20">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/95 via-slate-950/50 to-slate-950/20 z-10"></div>
                        <img src="<?= base_url('assets/img/image_004.jpg') ?>" alt="Alat Manufaktur" class="absolute inset-0 w-full h-full object-cover">
                        <div class="relative z-20 max-w-3xl px-6 sm:px-12 text-center text-white space-y-4 flex flex-col items-center">
                            <span class="bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider">Kendaraan Operasional</span>
                            <h1 class="text-3xl sm:text-5xl font-bold tracking-tight leading-tight">Kendaraan Dinas Lapangan</h1>
                            
                            <div class="pt-2 flex flex-wrap justify-center gap-4">
                                <a href="#service" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-xl shadow-lg transition-all">Lihat Layanan</a>
                                <a href="#help" class="bg-slate-800/80 hover:bg-slate-700 border border-slate-600 text-white font-medium px-6 py-3 rounded-xl transition-all">Pusat Bantuan</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Carousel Controls -->
                <button id="prev-slide" class="absolute left-4 z-30 bg-black/40 hover:bg-black/70 text-white w-12 h-12 rounded-full flex items-center justify-center backdrop-blur-sm transition-all focus:outline-none">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <button id="next-slide" class="absolute right-4 z-30 bg-black/40 hover:bg-black/70 text-white w-12 h-12 rounded-full flex items-center justify-center backdrop-blur-sm transition-all focus:outline-none">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>

                <!-- Dots Indicator -->
                <div class="absolute bottom-6 left-0 right-0 z-30 flex justify-center space-x-2">
                    <button class="slide-dot w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-all" data-index="0"></button>
                    <button class="slide-dot w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-all" data-index="1"></button>
                    <button class="slide-dot w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-all" data-index="2"></button>
                </div>

            </div>
        </div>
    </section>

    <!-- Section 2: Layanan yang Tersedia (Services) -->
    <section id="service" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-4">
                <span class="text-blue-600 font-semibold tracking-wider uppercase text-sm">Layanan Kami</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-slate-900">Solusi & Layanan Profesional</h2>
                <p class="text-slate-600 text-base sm:text-lg">Kami menyediakan berbagai macam layanan dukungan kegiatan kantor dan rapat untuk menunjang layanan prima.</p>
            </div>

            <!-- Service Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- Service Card 1 -->
                <a href="service-rental.html" class="block text-center bg-slate-50 border border-slate-200/80 rounded-3xl p-8 hover:shadow-xl hover:-translate-y-1.5 transition-all group cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-2xl mb-6 mx-auto group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <i class="fa-solid fa-house"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-blue-600 transition-colors">Peminjaman Ruangan</h3>
                    <p class="text-slate-600 mb-6 leading-relaxed">Pelayanan peminjaman ruang rapat di Balai Teknik Sabo untuk keteraturan dan tanggung jawab.</p>
                </a>

                <!-- Service Card 2 -->
                <a href="service-maintenance.html" class="block text-center bg-slate-50 border border-slate-200/80 rounded-3xl p-8 hover:shadow-xl hover:-translate-y-1.5 transition-all group cursor-pointer focus:outline-none focus:ring-2 focus:ring-indigo-500 flex flex-col items-center">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-2xl mb-6 mx-auto group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                        <i class="fa-solid fa-car"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-indigo-600 transition-colors">Peminjaman Kendaraan</h3>
                    <p class="text-slate-600 mb-6 leading-relaxed">Layanan peminjaman atau bon kendaraan untuk keperluan kedinasan</p>
                </a>

                <!-- Service Card 3 -->
                <a href="<?= site_url('laporan/buat') ?>" class="block text-center bg-slate-50 border border-slate-200/80 rounded-3xl p-8 hover:shadow-xl hover:-translate-y-1.5 transition-all group cursor-pointer focus:outline-none focus:ring-2 focus:ring-amber-500">
                    <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-2xl mb-6 mx-auto group-hover:bg-amber-600 group-hover:text-white transition-colors">
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-amber-600 transition-colors">Pelaporan Kerusakan</h3>
                    <p class="text-slate-600 mb-6 leading-relaxed">Layanan pelaporan kerusakan sarana prasarana, laboratorium hidraulika, serta armada kendaraan dinas lapangan untuk perbaikan dan servis berkala.</p>
                </a>

            </div>
        </div>
    </section>

    <!-- Section 3: Photo Gallery with Cursor Frame Popup -->
    <section id="gallery" class="py-20 bg-slate-900 text-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto mb-12 space-y-4">
                <span class="bg-blue-500/20 text-blue-400 border border-blue-500/30 text-xs font-semibold px-3.5 py-1.5 rounded-full uppercase tracking-wider inline-block">Galeri</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-white">Koleksi Ruangan dan Kendaraan</h2>
                <p class="text-slate-400 text-base sm:text-lg">Arahkan kursor (*hover*) ke dalam bingkai foto untuk melihat rincian spesifikasi & pratinjau popup secara langsung.</p>
            </div>

            <!-- Category Filter Buttons -->
            <div class="flex flex-wrap justify-center gap-2 sm:gap-3 mb-12">
                <button class="gallery-filter-btn active bg-blue-600 text-white px-5 py-2 rounded-xl text-sm font-semibold transition-all shadow-lg shadow-blue-600/30" data-filter="all">Semua Foto</button>
                <button class="gallery-filter-btn bg-slate-800 text-slate-300 hover:bg-slate-700 hover:text-white px-5 py-2 rounded-xl text-sm font-semibold transition-all" data-filter="ruang">Ruang Rapat</button>
                <button class="gallery-filter-btn bg-slate-800 text-slate-300 hover:bg-slate-700 hover:text-white px-5 py-2 rounded-xl text-sm font-semibold transition-all" data-filter="berat">Kendaraan</button>
                <button class="gallery-filter-btn bg-slate-800 text-slate-300 hover:bg-slate-700 hover:text-white px-5 py-2 rounded-xl text-sm font-semibold transition-all" data-filter="sarpras">Fasilitas Lain</button>
            </div>

            <!-- Photo Gallery Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="gallery-grid">
                
                <!-- Photo Item 1 -->
                <div class="gallery-item group relative rounded-2xl overflow-hidden bg-slate-800 border border-slate-700/80 shadow-lg cursor-pointer"
                     data-category="berat"
                     data-title="Ekskavator Hydraulik 20 Ton"
                     data-desc="Mesin pengeruk kapasitas besar untuk proyek penggalian berat, fondasi gedung, dan pembersihan lahan."
                     data-spec="Power: 110 kW | Berat: 20.5 Ton | Bucket: 0.9m³"
                     data-status="Tersedia (Ready)"
                     data-img="https://placehold.co/800x600/1e293b/38bdf8?text=Excavator+Pro+CAT-200">
                    <div class="aspect-video w-full overflow-hidden bg-slate-900">
                        <img src="<?= base_url('assets/img/image_003.jpg') ?>" alt="Ekskavator" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-4 bg-slate-800/90 flex justify-between items-center border-t border-slate-700">
                        <div>
                            <span class="text-xs text-blue-400 font-semibold tracking-wide uppercase">Kendaraan</span>
                            <h4 class="text-base font-bold text-white group-hover:text-blue-400 transition-colors">Drone Fixed Wings RGB</h4>
                        </div>
                        <span class="w-9 h-9 rounded-xl bg-slate-700/80 group-hover:bg-blue-600 flex items-center justify-center text-white transition-colors text-sm">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                    </div>
                </div>

                <!-- Photo Item 2 -->
                <div class="gallery-item group relative rounded-2xl overflow-hidden bg-slate-800 border border-slate-700/80 shadow-lg cursor-pointer"
                     data-category="ruang"
                     data-title="Ruang Rapat Merapi"
                     data-desc="Ruang rapat dengan kapasitas besar terletak di komplek Balai Teknik Sabo area timur."
                     data-spec="Ukuran: 10 x 30 m | Kapasitas: 70 orang | Display: Big Screen 100 inch | Audio: Mic Meja & Ruangan"
                     data-status="Tersedia di Lab Pusat"
                     data-img="<?= base_url('assets/img/merapi_001.jpg') ?>">
                    <div class="aspect-video w-full overflow-hidden bg-slate-900">
                        <img src="<?= base_url('assets/img/merapi_001.jpg') ?>" alt="Spektrofotometer" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-4 bg-slate-800/90 flex justify-between items-center border-t border-slate-700">
                        <div>
                            <span class="text-xs text-indigo-400 font-semibold tracking-wide uppercase">Ruang Rapat</span>
                            <h4 class="text-base font-bold text-white group-hover:text-indigo-400 transition-colors">Auditorium / Merapi</h4>
                        </div>
                        <span class="w-9 h-9 rounded-xl bg-slate-700/80 group-hover:bg-indigo-600 flex items-center justify-center text-white transition-colors text-sm">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                    </div>
                </div>

                <!-- Photo Item 3 -->
                <div class="gallery-item group relative rounded-2xl overflow-hidden bg-slate-800 border border-slate-700/80 shadow-lg cursor-pointer"
                     data-category="ruang"
                     data-title="Ruang Rapat Matsushita"
                     data-desc="Ruang rapat dengan teknologi terdepan dan kapaistas paling besar di Balai Teknik Sabo."
                     data-spec="Ukuran: 15 x 40 m | Kapasitas: 120 orang | Display: Videotrone 8 x 4 m | Audio: Mic Wireless & Ruangan"
                     data-status="Unit Demo Siap Uji"
                     data-img="<?= base_url('assets/img/matsu_001.jpg') ?>">
                    <div class="aspect-video w-full overflow-hidden bg-slate-900">
                        <img src="<?= base_url('assets/img/matsu_001.jpg') ?>" alt="Robotik Otomasi" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-4 bg-slate-800/90 flex justify-between items-center border-t border-slate-700">
                        <div>
                            <span class="text-xs text-emerald-400 font-semibold tracking-wide uppercase">Ruang Rapat</span>
                            <h4 class="text-base font-bold text-white group-hover:text-emerald-400 transition-colors">Matsushita Hall</h4>
                        </div>
                        <span class="w-9 h-9 rounded-xl bg-slate-700/80 group-hover:bg-emerald-600 flex items-center justify-center text-white transition-colors text-sm">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                    </div>
                </div>

                <!-- Photo Item 4 -->
                <div class="gallery-item group relative rounded-2xl overflow-hidden bg-slate-800 border border-slate-700/80 shadow-lg cursor-pointer"
                     data-category="armada"
                     data-title="Mobil SUV Inspeksi Kedinasan"
                     data-desc="Kendaraan operasional tangguh untuk survei lapangan, inspeksi teknis lokasi proyek, dan perjalanan dinas."
                     data-spec="Kapasitas: 7 Penumpang | 4x4 AWD | 2800 cc Diesel"
                     data-status="Tersedia untuk Bon"
                     data-img="https://placehold.co/800x600/1e1b4b/a7f3d0?text=SUV+Kedinasan+4x4">
                    <div class="aspect-video w-full overflow-hidden bg-slate-900">
                        <img src="https://placehold.co/800x600/1e1b4b/a7f3d0?text=SUV+Kedinasan+4x4" alt="SUV Kedinasan" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-4 bg-slate-800/90 flex justify-between items-center border-t border-slate-700">
                        <div>
                            <span class="text-xs text-amber-400 font-semibold tracking-wide uppercase">Armada Kedinasan</span>
                            <h4 class="text-base font-bold text-white group-hover:text-amber-400 transition-colors">SUV Inspeksi 4x4</h4>
                        </div>
                        <span class="w-9 h-9 rounded-xl bg-slate-700/80 group-hover:bg-amber-600 flex items-center justify-center text-white transition-colors text-sm">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                    </div>
                </div>

                <!-- Photo Item 5 -->
                <div class="gallery-item group relative rounded-2xl overflow-hidden bg-slate-800 border border-slate-700/80 shadow-lg cursor-pointer"
                     data-category="berat"
                     data-title="Mobile Crane Heavy Lift 50 Ton"
                     data-desc="Derek pemindah beban berat bergerak untuk pengerjaan konstruksi tinggi, jembatan, dan industri balok beton."
                     data-spec="Kapasitas Maks: 50 Ton | Tinggi Boom: 42 Meter"
                     data-status="Tersedia (Sewa Harian/Bulanan)"
                     data-img="https://placehold.co/800x600/312e81/38bdf8?text=Mobile+Crane+50T">
                    <div class="aspect-video w-full overflow-hidden bg-slate-900">
                        <img src="https://placehold.co/800x600/312e81/38bdf8?text=Mobile+Crane+50T" alt="Mobile Crane" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-4 bg-slate-800/90 flex justify-between items-center border-t border-slate-700">
                        <div>
                            <span class="text-xs text-blue-400 font-semibold tracking-wide uppercase">Alat Berat</span>
                            <h4 class="text-base font-bold text-white group-hover:text-blue-400 transition-colors">Mobile Crane 50 Ton</h4>
                        </div>
                        <span class="w-9 h-9 rounded-xl bg-slate-700/80 group-hover:bg-blue-600 flex items-center justify-center text-white transition-colors text-sm">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                    </div>
                </div>

                <!-- Photo Item 6 -->
                <div class="gallery-item group relative rounded-2xl overflow-hidden bg-slate-800 border border-slate-700/80 shadow-lg cursor-pointer"
                     data-category="armada"
                     data-title="Truk Double Cabin Lapangan"
                     data-desc="Kendaraan operasional serbaguna dengan bak belakang untuk mengangkut tim teknisi dan sampel peralatan."
                     data-spec="Kapasitas Angkut: 1.2 Ton | Turbo Intercooler"
                     data-status="Siap Digunakan"
                     data-img="https://placehold.co/800x600/1e293b/f43f5e?text=Truk+Double+Cabin">
                    <div class="aspect-video w-full overflow-hidden bg-slate-900">
                        <img src="https://placehold.co/800x600/1e293b/f43f5e?text=Truk+Double+Cabin" alt="Truk Double Cabin" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-4 bg-slate-800/90 flex justify-between items-center border-t border-slate-700">
                        <div>
                            <span class="text-xs text-rose-400 font-semibold tracking-wide uppercase">Armada Kedinasan</span>
                            <h4 class="text-base font-bold text-white group-hover:text-rose-400 transition-colors">Truk Double Cabin</h4>
                        </div>
                        <span class="w-9 h-9 rounded-xl bg-slate-700/80 group-hover:bg-rose-600 flex items-center justify-center text-white transition-colors text-sm">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                    </div>
                </div>

            </div>
        </div>

        <!-- Dynamic Hover Popup Box (Triggered when cursor enters photo frame) -->
        <div id="hover-popup" class="hover-popup-container fixed hidden z-50 max-w-sm w-full p-4 glass-panel rounded-2xl border border-slate-600/80 text-white shadow-2xl pointer-events-none transition-all duration-200 opacity-0 scale-95">
            <div class="relative overflow-hidden rounded-xl mb-3 aspect-video bg-slate-950 border border-slate-700">
                <img id="popup-img" src="" alt="Pratinjau" class="w-full h-full object-cover">
                <span id="popup-status" class="absolute top-2 right-2 bg-emerald-500/90 text-white text-[10px] font-bold px-2 py-0.5 rounded-full border border-emerald-400/40">Status</span>
            </div>
            <div class="space-y-1.5">
                <h4 id="popup-title" class="text-base font-bold text-white leading-snug">Judul Peralatan</h4>
                <p id="popup-desc" class="text-xs text-slate-300 leading-relaxed line-clamp-2">Deskripsi singkat alat.</p>
                <div class="pt-2 border-t border-slate-700/80 flex items-center justify-between text-[11px] text-blue-300 font-mono">
                    <span id="popup-spec" class="truncate max-w-[220px]">Spesifikasi: -</span>
                    <span class="text-amber-400 font-semibold flex items-center gap-1">
                        <i class="fa-solid fa-hand-pointer text-[10px]"></i> Klik Foto
                    </span>
                </div>
            </div>
        </div>

        <!-- Fullscreen Lightbox Modal -->
        <div id="lightbox-modal" class="fixed inset-0 z-50 bg-black/90 backdrop-blur-md hidden flex items-center justify-center p-4 sm:p-8">
            <button id="close-lightbox" class="absolute top-6 right-6 text-white text-2xl hover:text-blue-400 w-12 h-12 rounded-full bg-slate-800/80 flex items-center justify-center transition-colors">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="max-w-4xl w-full bg-slate-900 border border-slate-700 rounded-3xl overflow-hidden shadow-2xl flex flex-col md:flex-row">
                <div class="md:w-3/5 bg-slate-950 flex items-center justify-center p-2 min-h-[300px]">
                    <img id="lightbox-img" src="" alt="Detail Peralatan" class="max-h-[70vh] w-auto object-contain rounded-xl">
                </div>
                <div class="md:w-2/5 p-6 sm:p-8 flex flex-col justify-between space-y-6">
                    <div class="space-y-4">
                        <span id="lightbox-badge" class="bg-blue-500/20 text-blue-400 border border-blue-500/30 text-xs font-semibold px-3 py-1 rounded-full uppercase inline-block">Kategori</span>
                        <h3 id="lightbox-title" class="text-2xl font-bold text-white leading-tight">Nama Peralatan</h3>
                        <p id="lightbox-desc" class="text-slate-300 text-sm leading-relaxed">Deskripsi lengkap peralatan.</p>
                        <div class="bg-slate-800 p-4 rounded-xl border border-slate-700 space-y-2">
                            <span class="text-xs text-slate-400 uppercase font-semibold block">Spesifikasi Utama</span>
                            <p id="lightbox-spec" class="text-sm font-mono text-blue-300">-</p>
                        </div>
                    </div>
                    <div class="space-y-3 pt-4 border-t border-slate-800">
                        <a href="#help" id="lightbox-cta" class="block text-center w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 rounded-xl transition-all shadow-lg shadow-blue-600/30">
                            Ajukan Pemesanan / Bon
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <!-- Help / Bantuan Section -->
    <section id="help" class="py-20 bg-slate-100 border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto text-center mb-16 space-y-4">
                <span class="text-blue-600 font-semibold tracking-wider uppercase text-sm">Pusat Bantuan</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-slate-900">Ada Pertanyaan? Kami Siap Membantu</h2>
                <p class="text-slate-600 text-base sm:text-lg">Temukan jawaban cepat atau hubungi tim layanan rumah tangga untuk konsultasi langsung.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-200 space-y-4">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center text-xl font-bold">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Hubungi Hotline</h3>
                    <p class="text-slate-600">Layanan telepon langsung untuk pemesanan cepat dan kendala teknis mendesak.</p>
                    <p class="text-blue-600 font-bold text-lg">+62 274 886-350</p>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-200 space-y-4">
                    <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center text-xl font-bold">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Datang Langsung</h3>
                    <p class="text-slate-600">Datang langsung ke bagian Rumah Tangga atau kirim email untuk pemesanan.</p>
                    <p class="text-emerald-600 font-bold text-lg">balteksabo@pu.go.id</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer with Location Map -->
    <footer id="footer" class="bg-slate-950 text-slate-400 pt-16 pb-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 mb-12">
                
                <!-- Company Info -->
                <div class="lg:col-span-4 space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="bg-blue-600 text-white p-2.5 rounded-xl">
                            <i class="fa-solid fa-industry text-xl"></i>
                        </div>
                        <span class="text-xl font-bold text-white">PINSAKA</span>
                    </div>
                    <p class="text-sm leading-relaxed text-slate-400">
                        Pusat layanan peminjaman ruangan, peminjaman kendaraan dan pelaporan kerusakan sarana dan prasarana.
                    </p>
                    <div class="pt-2 flex space-x-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-900 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-colors"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-900 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-colors"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-900 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-colors"><i class="fa-brands fa-linkedin-in"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-900 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-colors"><i class="fa-brands fa-whatsapp"></i></a>
                    </div>
                </div>

                <!-- Navigation Quick Links -->
                <div class="lg:col-span-2 space-y-4">
                    <h4 class="text-white font-semibold uppercase tracking-wider text-sm">Navigasi</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#home" class="hover:text-white transition-colors">Home</a></li>
                        <li><a href="#service" class="hover:text-white transition-colors">Service</a></li>
                        <li><a href="#help" class="hover:text-white transition-colors">Help</a></li>
                    </ul>
                </div>

                <!-- Services Summary Links -->
                <div class="lg:col-span-2 space-y-4">
                    <h4 class="text-white font-semibold uppercase tracking-wider text-sm">Layanan</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#service" class="hover:text-white transition-colors">Ruang Rapat</a></li>
                        <li><a href="#service" class="hover:text-white transition-colors">Kendaraan Dinas</a></li>
                        <li><a href="#service" class="hover:text-white transition-colors">Pelaporan</a></li>
                    </ul>
                </div>

                <!-- Interactive Location Map Container -->
                <div class="lg:col-span-4 space-y-4">
                    <h4 class="text-white font-semibold uppercase tracking-wider text-sm">Peta Lokasi</h4>
                    <div class="rounded-2xl overflow-hidden border border-slate-800 shadow-md h-48 bg-slate-900 relative">
                        <!-- Leaflet Interactive Map Container -->
                        <div id="map" class="w-full h-full z-10"></div>
                    </div>
                    <p class="text-xs text-slate-400">Jl. Sabo 1, Sopalan, Maguwoharjo, Depok, Sleman</p>
                </div>

            </div>

            <!-- Copyright Divider -->
            <div class="border-t border-slate-900 pt-8 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-500">
                <p>&copy; 2026 AlatPro Indonesia. Hak Cipta Dilindungi Undang-Undang.</p>
                <div class="flex space-x-6 mt-4 sm:mt-0">
                    <a href="#" class="hover:text-slate-400">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-slate-400">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript for Slideshow & Mobile Menu -->
    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Slideshow functionality
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.slide-dot');
        const prevBtn = document.getElementById('prev-slide');
        const nextBtn = document.getElementById('next-slide');
        let currentSlide = 0;
        let slideInterval;

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.style.opacity = i === index ? '1' : '0';
            });
            dots.forEach((dot, i) => {
                if (i === index) {
                    dot.classList.remove('bg-white/50');
                    dot.classList.add('bg-white', 'w-6');
                } else {
                    dot.classList.remove('bg-white', 'w-6');
                    dot.classList.add('bg-white/50', 'w-3');
                }
            });
            currentSlide = index;
        }

        function nextSlideFn() {
            let next = (currentSlide + 1) % slides.length;
            showSlide(next);
        }

        function prevSlideFn() {
            let prev = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(prev);
        }

        // Event Listeners for controls
        nextBtn.addEventListener('click', () => {
            nextSlideFn();
            resetTimer();
        });

        prevBtn.addEventListener('click', () => {
            prevSlideFn();
            resetTimer();
        });

        dots.forEach(dot => {
            dot.addEventListener('click', (e) => {
                const index = parseInt(e.target.getAttribute('data-index'));
                showSlide(index);
                resetTimer();
            });
        });

        // Auto play interval
        function startTimer() {
            slideInterval = setInterval(nextSlideFn, 5000);
        }

        function resetTimer() {
            clearInterval(slideInterval);
            startTimer();
        }

        // Initialize slideshow
        showSlide(0);
        startTimer();

        // Leaflet Map Initialization
        const map = L.map('map').setView([-7.760375, 110.428950], 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Add pin marker with popup
        L.marker([-7.760375, 110.428950]).addTo(map)
            .bindPopup('<div class="text-slate-600 font-sans p-1 text-center"><strong>Balai Teknik Sabo</strong></div>')
            .openPopup();

        // --- Photo Gallery Filter & Frame Hover Popup Logic ---
        const filterBtns = document.querySelectorAll('.gallery-filter-btn');
        const galleryItems = document.querySelectorAll('.gallery-item');
        
        // Hover Popup Elements
        const hoverPopup = document.getElementById('hover-popup');
        const popupImg = document.getElementById('popup-img');
        const popupTitle = document.getElementById('popup-title');
        const popupDesc = document.getElementById('popup-desc');
        const popupSpec = document.getElementById('popup-spec');
        const popupStatus = document.getElementById('popup-status');

        // Lightbox Modal Elements
        const lightboxModal = document.getElementById('lightbox-modal');
        const closeLightbox = document.getElementById('close-lightbox');
        const lightboxImg = document.getElementById('lightbox-img');
        const lightboxTitle = document.getElementById('lightbox-title');
        const lightboxDesc = document.getElementById('lightbox-desc');
        const lightboxSpec = document.getElementById('lightbox-spec');
        const lightboxBadge = document.getElementById('lightbox-badge');

        // Filter Logic
        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                filterBtns.forEach(b => {
                    b.classList.remove('active', 'bg-blue-600', 'text-white', 'shadow-lg');
                    b.classList.add('bg-slate-800', 'text-slate-300');
                });
                btn.classList.add('active', 'bg-blue-600', 'text-white', 'shadow-lg');
                btn.classList.remove('bg-slate-800', 'text-slate-300');

                const filter = btn.getAttribute('data-filter');
                galleryItems.forEach(item => {
                    if (filter === 'all' || item.getAttribute('data-category') === filter) {
                        item.classList.remove('hidden');
                    } else {
                        item.classList.add('hidden');
                    }
                });
            });
        });

        // Frame Hover Popup Effect
        galleryItems.forEach(item => {
            item.addEventListener('mouseenter', (e) => {
                // Populate hover popup content from item data
                popupImg.src = item.getAttribute('data-img');
                popupTitle.textContent = item.getAttribute('data-title');
                popupDesc.textContent = item.getAttribute('data-desc');
                popupSpec.textContent = 'Spec: ' + item.getAttribute('data-spec');
                popupStatus.textContent = item.getAttribute('data-status');

                hoverPopup.classList.remove('hidden');
                setTimeout(() => {
                    hoverPopup.classList.remove('opacity-0', 'scale-95');
                    hoverPopup.classList.add('opacity-100', 'scale-100');
                }, 20);
            });

            item.addEventListener('mousemove', (e) => {
                // Position popup relative to viewport cursor with safe offsets
                const popupWidth = 320;
                const popupHeight = 220;
                let left = e.clientX + 20;
                let top = e.clientY + 20;

                // Edge collision handling
                if (left + popupWidth > window.innerWidth) {
                    left = e.clientX - popupWidth - 10;
                }
                if (top + popupHeight > window.innerHeight) {
                    top = e.clientY - popupHeight - 10;
                }

                hoverPopup.style.left = `${left}px`;
                hoverPopup.style.top = `${top}px`;
            });

            item.addEventListener('mouseleave', () => {
                hoverPopup.classList.remove('opacity-100', 'scale-100');
                hoverPopup.classList.add('opacity-0', 'scale-95');
                setTimeout(() => {
                    hoverPopup.classList.add('hidden');
                }, 200);
            });

            // Click for Lightbox Fullscreen
            item.addEventListener('click', () => {
                lightboxImg.src = item.getAttribute('data-img');
                lightboxTitle.textContent = item.getAttribute('data-title');
                lightboxDesc.textContent = item.getAttribute('data-desc');
                lightboxSpec.textContent = item.getAttribute('data-spec');
                lightboxBadge.textContent = item.getAttribute('data-category').toUpperCase();

                lightboxModal.classList.remove('hidden');
            });
        });

        // Close Lightbox
        closeLightbox.addEventListener('click', () => {
            lightboxModal.classList.add('hidden');
        });

        lightboxModal.addEventListener('click', (e) => {
            if (e.target === lightboxModal) {
                lightboxModal.classList.add('hidden');
            }
        });
    </script>

    <!-- Floating Action Button (Ajukan) -->
    <a href="#help" id="btn-ajukan" class="fixed bottom-6 right-6 z-50 flex items-center space-x-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-5 py-3.5 rounded-full shadow-xl shadow-blue-600/30 hover:shadow-2xl hover:shadow-blue-600/50 transition-all transform hover:-translate-y-1 active:translate-y-0 group border border-white/20">
        <span class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-paper-plane text-sm"></i>
        </span>
        <span class="font-semibold text-sm tracking-wide pr-1">Ajukan</span>
    </a>
</body>
</html>