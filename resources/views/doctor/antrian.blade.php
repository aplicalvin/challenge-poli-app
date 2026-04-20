@extends('layouts.admin')

@section('title', 'Antrian Pasien')

@section('content')
<div class="flex flex-col">
  <div class="-m-1.5 overflow-x-auto">
    <div class="p-1.5 min-w-full inline-block align-middle">
      <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-neutral-800 dark:border-neutral-700">
        <!-- Header -->
        <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-neutral-700">
          <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
              Antrian Pasien Hari Ini
            </h2>
            <p class="text-sm text-gray-600 dark:text-neutral-400">
              Kelola antrian pasien yang menunggu pemeriksaan Anda.
            </p>
          </div>

          <div>
            <div class="inline-flex gap-x-2">
              <span class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm dark:bg-neutral-900 dark:border-neutral-700 dark:text-white">
                Status Klinik: <span class="text-green-600 font-bold">BUKA</span>
              </span>
            </div>
          </div>
        </div>
        <!-- End Header -->

        <!-- Empty State Placeholder -->
        <div class="min-h-[400px] flex flex-col items-center justify-center p-8 text-center">
          <div class="size-20 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mb-4 dark:bg-blue-900/20 dark:text-blue-500">
            <svg class="shrink-0 size-10" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          </div>
          <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">Belum Ada Antrian</h3>
          <p class="text-sm text-gray-600 dark:text-neutral-400 max-w-sm mx-auto mt-2">
            Pasien akan muncul di sini setelah mereka mendaftar dan memilih jadwal jaga Anda.
          </p>
          <div class="mt-6">
            <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none">
              Refresh Antrian
            </button>
          </div>
        </div>
        <!-- End Empty State -->

        <!-- Footer -->
        <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-t border-gray-200 dark:border-neutral-700">
          <div>
            <p class="text-sm text-gray-600 dark:text-neutral-400">
              Menampilkan antrian untuk Dokter: <span class="font-semibold text-gray-800 dark:text-neutral-200">{{ auth()->user()->username }}</span>
            </p>
          </div>
        </div>
        <!-- End Footer -->
      </div>
    </div>
  </div>
</div>
@endsection
