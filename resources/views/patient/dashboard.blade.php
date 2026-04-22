@extends('layouts.admin')

@section('title', 'Patient Dashboard')

@section('content')
  <div class="flex flex-col">
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 dark:bg-neutral-800 dark:border-neutral-700">
      <p class="text-xl font-semibold text-gray-600 dark:text-neutral-400">
        Selamat Datang,
      </p>
      <h1 class="text-3xl font-bold text-gray-800 dark:text-neutral-200">
        {{ auth()->user()->nama ?? 'Patient' }}
      </h1>
      <h3 class="text-xl font-semibold text-gray-600 dark:text-neutral-400">
        ({{ auth()->user()->role ?? 'pasien' }})
      </h3>
      <hr class="my-6 border-gray-200 dark:border-neutral-700">
      <p class="text-gray-500 dark:text-neutral-500">
        View your medical history, book appointments, and check your prescriptions.
      </p>
    </div>

    <!-- Antrian Status Section -->
    <div id="active-queue-section"
      class="hidden mt-6 bg-blue-50 border border-blue-200 rounded-xl p-6 dark:bg-blue-900/20 dark:border-blue-800">
      <div class="flex items-center gap-x-4">
        <div class="flex-shrink-0">
          <span
            class="size-12 inline-flex justify-center items-center rounded-full bg-blue-100 text-blue-600 dark:bg-blue-800 dark:text-blue-200 font-bold text-xl"
            id="queue-number">
            -
          </span>
        </div>
        <div>
          <h3 class="text-lg font-bold text-blue-800 dark:text-blue-200">Antrian Anda Sedang Berjalan</h3>
          <p class="text-sm text-blue-600 dark:text-blue-400" id="queue-status-text">Menunggu giliran...</p>
        </div>
      </div>
    </div>
  </div>
@endsection