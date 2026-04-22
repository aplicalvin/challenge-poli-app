@extends('layouts.guest')

@section('title', 'Sistem Informasi Poliklinik - Solusi Manajemen Kesehatan Terpadu')

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden before:absolute before:top-0 before:start-1/2 before:bg-[url('https://preline.co/assets/svg/examples/polygon-bg-element.svg')] before:bg-no-repeat before:bg-top before:bg-cover before:size-full before:-z-[1] before:-translate-x-1/2 dark:before:bg-[url('https://preline.co/assets/svg/examples-dark/polygon-bg-element.svg')]">
  <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-10">
    <!-- Announcement Banner -->
    <div class="flex justify-center">
      <a class="inline-flex items-center gap-x-2 bg-white border border-gray-200 text-sm text-gray-800 p-1 ps-3 rounded-full transition hover:border-gray-300 dark:bg-neutral-800 dark:border-neutral-700 dark:hover:border-neutral-600 dark:text-neutral-200" href="{{ route('signup') }}">
        Daftar Pasien Baru - Cepat & Mudah
        <span class="py-1.5 px-2.5 inline-flex justify-center items-center gap-x-2 rounded-full bg-gray-200 font-semibold text-sm text-gray-600 dark:bg-neutral-700 dark:text-neutral-400">
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        </span>
      </a>
    </div>
    <!-- End Announcement Banner -->

    <!-- Title -->
    <div class="mt-5 max-w-2xl text-center mx-auto">
      <h1 class="block font-black text-gray-800 text-4xl md:text-5xl lg:text-6xl dark:text-neutral-200">
        Transformasi Digital <span class="bg-clip-text bg-gradient-to-tl from-blue-600 to-violet-600 text-transparent">Layanan Kesehatan</span>
      </h1>
    </div>
    <!-- End Title -->

    <div class="mt-5 max-w-3xl text-center mx-auto">
      <p class="text-lg text-gray-600 dark:text-neutral-400">
        Sistem manajemen poliklinik modern yang menghubungkan Pasien, Dokter, dan Tenaga Medis dalam satu platform efisien. Antrian real-time, resep digital, dan manajemen keuangan terintegrasi.
      </p>
    </div>

    <!-- Buttons -->
    <div class="mt-8 gap-3 flex justify-center">
      <a class="py-3 px-6 inline-flex justify-center items-center gap-x-2 text-sm font-bold rounded-xl border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none shadow-xl shadow-blue-200 dark:shadow-none" href="{{ route('login') }}">
        Mulai Sekarang
        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
      </a>
      <a class="py-3 px-6 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-xl border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800" href="#features">
        Pelajari Fitur
      </a>
    </div>
    <!-- End Buttons -->
  </div>
</div>
<!-- End Hero -->

<!-- Features Section -->
<div id="features" class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-24 mx-auto">
  <div class="max-w-2xl mx-auto text-center mb-10 lg:mb-14">
    <h2 class="text-2xl font-bold md:text-4xl md:leading-tight dark:text-white uppercase tracking-tight">Ekosistem Digital Terpadu</h2>
    <p class="mt-1 text-gray-600 dark:text-neutral-400">Satu platform untuk semua peranan di fasilitas kesehatan Anda.</p>
  </div>

  <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Pasien -->
    <div class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-3xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70 transition-all hover:shadow-xl hover:-translate-y-1">
      <div class="h-44 flex flex-col justify-center items-center bg-blue-600 rounded-t-3xl">
        <svg class="size-16 text-white/90" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M19 8v6"/><path d="M16 11h6"/></svg>
      </div>
      <div class="p-6 md:p-8">
        <h3 class="text-xl font-black text-gray-800 dark:text-neutral-200 uppercase tracking-tight">Pasien</h3>
        <p class="mt-3 text-gray-500 dark:text-neutral-500 text-sm leading-relaxed">
          Pendaftaran antrian online tanpa harus menunggu lama di lokasi. Pantau status pemeriksaan dan lakukan pembayaran digital secara instan.
        </p>
      </div>
    </div>

    <!-- Dokter -->
    <div class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-3xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70 transition-all hover:shadow-xl hover:-translate-y-1">
      <div class="h-44 flex flex-col justify-center items-center bg-indigo-600 rounded-t-3xl">
        <svg class="size-16 text-white/90" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49 0 2.87.47 4 1.26V4c0-1.1-.9-2-2-2H3c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h4.63c1.13 0 2.22.45 3.01 1.24L12 21l1.36-1.76c.79-.79 1.88-1.24 3.01-1.24H19v-4Z"/><path d="M12 6v6"/><path d="M8 9h8"/></svg>
      </div>
      <div class="p-6 md:p-8">
        <h3 class="text-xl font-black text-gray-800 dark:text-neutral-200 uppercase tracking-tight">Dokter</h3>
        <p class="mt-3 text-gray-500 dark:text-neutral-500 text-sm leading-relaxed">
          Kelola antrian periksa harian dengan mudah. Input hasil diagnosis dan resep obat secara digital yang terhubung langsung ke bagian farmasi.
        </p>
      </div>
    </div>

    <!-- Farmasi -->
    <div class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-3xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70 transition-all hover:shadow-xl hover:-translate-y-1">
      <div class="h-44 flex flex-col justify-center items-center bg-emerald-600 rounded-t-3xl">
        <svg class="size-16 text-white/90" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m10.5 20.5 10-10a4.95 4.95 0 1 0-7-7l-10 10a4.95 4.95 0 1 0 7 7Z"/><path d="m8.5 8.5 7 7"/></svg>
      </div>
      <div class="p-6 md:p-8">
        <h3 class="text-xl font-black text-gray-800 dark:text-neutral-200 uppercase tracking-tight">Apoteker</h3>
        <p class="mt-3 text-gray-500 dark:text-neutral-500 text-sm leading-relaxed">
          Pemantauan stok obat real-time dan penyiapan resep otomatis. Sistem memvalidasi stok sebelum obat diserahkan kepada pasien.
        </p>
      </div>
    </div>

    <!-- Kasir -->
    <div class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-3xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70 transition-all hover:shadow-xl hover:-translate-y-1">
      <div class="h-44 flex flex-col justify-center items-center bg-amber-500 rounded-t-3xl">
        <svg class="size-16 text-white/90" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="12" cy="12" r="2"/><path d="M6 12h.01M18 12h.01"/></svg>
      </div>
      <div class="p-6 md:p-8">
        <h3 class="text-xl font-black text-gray-800 dark:text-neutral-200 uppercase tracking-tight">Kasir</h3>
        <p class="mt-3 text-gray-500 dark:text-neutral-500 text-sm leading-relaxed">
          Verifikasi bukti pembayaran pasien secara cepat. Kelola transaksi harian dan pastikan aliran pendapatan klinik tercatat dengan akurat.
        </p>
      </div>
    </div>

    <!-- Admin -->
    <div class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-3xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70 transition-all hover:shadow-xl hover:-translate-y-1">
      <div class="h-44 flex flex-col justify-center items-center bg-slate-800 rounded-t-3xl">
        <svg class="size-16 text-white/90" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20a8 8 0 1 0 0-16 8 8 0 0 0 0 16Z"/><path d="M12 14a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/><path d="M12 2v2"/><path d="M12 18v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/></svg>
      </div>
      <div class="p-6 md:p-8">
        <h3 class="text-xl font-black text-gray-800 dark:text-neutral-200 uppercase tracking-tight">Admin</h3>
        <p class="mt-3 text-gray-500 dark:text-neutral-500 text-sm leading-relaxed">
          Kendali penuh atas data master Poli, Dokter, dan Pasien. Pantau kinerja klinik melalui laporan keuangan dan statistik kunjungan yang komprehensif.
        </p>
      </div>
    </div>

    <!-- Stats Card -->
    <div class="group flex flex-col h-full bg-blue-600 border border-transparent shadow-sm rounded-3xl p-8 dark:bg-blue-700 justify-center items-center text-center">
      <h3 class="text-2xl font-black text-white uppercase tracking-tight mb-4">Statistik Real-time</h3>
      <div class="space-y-6 w-full">
        <div class="flex justify-between items-center text-white/90">
          <span class="text-sm font-medium">Pasien Terdaftar</span>
          <span class="text-2xl font-black">2.4k+</span>
        </div>
        <div class="flex justify-between items-center text-white/90 border-t border-white/10 pt-4">
          <span class="text-sm font-medium">Dokter Spesialis</span>
          <span class="text-2xl font-black">45+</span>
        </div>
        <div class="flex justify-between items-center text-white/90 border-t border-white/10 pt-4">
          <span class="text-sm font-medium">Layanan Poliklinik</span>
          <span class="text-2xl font-black">12</span>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Features Section -->

<!-- How It Works -->
<div class="bg-gray-100 dark:bg-neutral-800 rounded-[3rem] mx-4 sm:mx-8 mb-24 overflow-hidden">
  <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-20 mx-auto">
    <div class="max-w-2xl mx-auto text-center mb-10 lg:mb-14">
      <h2 class="text-2xl font-bold md:text-4xl md:leading-tight dark:text-white uppercase tracking-tight">Alur Pelayanan Digital</h2>
      <p class="mt-1 text-gray-600 dark:text-neutral-400">Proses pemeriksaan yang efisien dan transparan bagi pasien.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
      <div class="relative text-center">
        <div class="size-14 bg-white rounded-2xl shadow-sm flex items-center justify-center mx-auto mb-5 dark:bg-neutral-900 border border-gray-100 dark:border-neutral-700">
          <span class="text-xl font-black text-blue-600">01</span>
        </div>
        <h4 class="text-lg font-bold text-gray-800 dark:text-neutral-200">Daftar Online</h4>
        <p class="mt-2 text-sm text-gray-500">Pasien memilih poli dan jadwal dokter secara mandiri.</p>
      </div>

      <div class="relative text-center">
        <div class="size-14 bg-white rounded-2xl shadow-sm flex items-center justify-center mx-auto mb-5 dark:bg-neutral-900 border border-gray-100 dark:border-neutral-700">
          <span class="text-xl font-black text-blue-600">02</span>
        </div>
        <h4 class="text-lg font-bold text-gray-800 dark:text-neutral-200">Pemeriksaan</h4>
        <p class="mt-2 text-sm text-gray-500">Dokter melakukan diagnosa dan input resep obat ke sistem.</p>
      </div>

      <div class="relative text-center">
        <div class="size-14 bg-white rounded-2xl shadow-sm flex items-center justify-center mx-auto mb-5 dark:bg-neutral-900 border border-gray-100 dark:border-neutral-700">
          <span class="text-xl font-black text-blue-600">03</span>
        </div>
        <h4 class="text-lg font-bold text-gray-800 dark:text-neutral-200">Pembayaran</h4>
        <p class="mt-2 text-sm text-gray-500">Pasien membayar via transfer dan divalidasi oleh kasir.</p>
      </div>

      <div class="relative text-center">
        <div class="size-14 bg-white rounded-2xl shadow-sm flex items-center justify-center mx-auto mb-5 dark:bg-neutral-900 border border-gray-100 dark:border-neutral-700">
          <span class="text-xl font-black text-blue-600">04</span>
        </div>
        <h4 class="text-lg font-bold text-gray-800 dark:text-neutral-200">Ambil Obat</h4>
        <p class="mt-2 text-sm text-gray-500">Apoteker menyiapkan obat sesuai resep digital yang lunas.</p>
      </div>
    </div>
  </div>
</div>
<!-- End How It Works -->

<!-- CTA -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto mb-20">
  <div class="relative p-6 md:p-16">
    <div class="relative z-10 lg:grid lg:grid-cols-12 lg:gap-16 lg:items-center">
      <div class="mb-10 lg:mb-0 lg:col-span-7 text-center lg:text-left">
        <h2 class="text-3xl font-black text-gray-800 md:text-4xl lg:text-5xl dark:text-neutral-200 uppercase tracking-tight leading-tight">
          Siap Meningkatkan Kualitas <span class="text-blue-600">Layanan Klinik?</span>
        </h2>
        <p class="mt-4 text-lg text-gray-600 dark:text-neutral-400">
          Bergabunglah dengan ekosistem kesehatan masa depan sekarang juga.
        </p>
        <div class="mt-8 flex flex-col sm:flex-row justify-center lg:justify-start gap-3">
          <a class="py-3 px-8 inline-flex justify-center items-center gap-x-2 text-sm font-bold rounded-xl border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none shadow-lg shadow-blue-200 dark:shadow-none" href="{{ route('signup') }}">
            Daftar Sebagai Pasien
          </a>
          <a class="py-3 px-8 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-xl border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800" href="{{ route('login') }}">
            Login ke Sistem
          </a>
        </div>
      </div>

      <div class="lg:col-span-5">
        <div class="relative">
          <img class="w-full rounded-3xl shadow-2xl" src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Hospital Management">
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End CTA -->


@endsection