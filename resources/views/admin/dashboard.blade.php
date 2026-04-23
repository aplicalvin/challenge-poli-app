@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
  <div class="space-y-10">
    <!-- Title Section -->
    <div>
      <h1 class="text-3xl font-bold text-gray-800 dark:text-neutral-200">
        Selamat Datang, {{ auth()->user()->username ?? 'Admin' }}
      </h1>
      <p class="text-gray-600 dark:text-neutral-400">
        Berikut adalah aktivitas yang terjadi di klinik hari ini.
      </p>
    </div>

    <!-- Stats Grid -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
      <!-- Doctors Card -->
      <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-4 md:p-5 flex gap-x-4">
          <div
            class="shrink-0 flex justify-center items-center size-[46px] bg-blue-100 text-blue-600 rounded-lg dark:bg-blue-900/10 dark:text-blue-500">
            <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
              fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
              <circle cx="9" cy="7" r="4" />
              <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
              <path d="M16 3.13a4 4 0 0 1 0 7.75" />
            </svg>
          </div>

          <div class="grow">
            <div class="flex items-center gap-x-2">
              <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-500">
                Total Dokter
              </p>
            </div>
            <div class="mt-1 flex items-center gap-x-2">
              <h3 class="text-xl font-medium text-gray-800 dark:text-neutral-200">
                {{ $stats['total_dokter'] }}
              </h3>
            </div>
          </div>
        </div>
      </div>
      <!-- End Card -->

      <!-- Pharmacists Card -->
      <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-4 md:p-5 flex gap-x-4">
          <div
            class="shrink-0 flex justify-center items-center size-[46px] bg-teal-100 text-teal-600 rounded-lg dark:bg-teal-900/10 dark:text-teal-500">
            <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
              fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="m10.5 20.5 10-10a4.95 4.95 0 1 0-7-7l-10 10a4.95 4.95 0 1 0 7 7Z" />
              <path d="m8.5 8.5 7 7" />
            </svg>
          </div>

          <div class="grow">
            <div class="flex items-center gap-x-2">
              <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-500">
                Total Apoteker
              </p>
            </div>
            <div class="mt-1 flex items-center gap-x-2">
              <h3 class="text-xl font-medium text-gray-800 dark:text-neutral-200">
                {{ $stats['total_apoteker'] }}
              </h3>
            </div>
          </div>
        </div>
      </div>
      <!-- End Card -->

      <!-- Cashier Card -->
      <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-4 md:p-5 flex gap-x-4">
          <div
            class="shrink-0 flex justify-center items-center size-[46px] bg-orange-100 text-orange-600 rounded-lg dark:bg-orange-900/10 dark:text-orange-500">
            <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
              fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect width="20" height="14" x="2" y="5" rx="2" />
              <line x1="2" x2="22" y1="10" y2="10" />
            </svg>
          </div>

          <div class="grow">
            <div class="flex items-center gap-x-2">
              <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-500">
                Total Kasir
              </p>
            </div>
            <div class="mt-1 flex items-center gap-x-2">
              <h3 class="text-xl font-medium text-gray-800 dark:text-neutral-200">
                {{ $stats['total_kasir'] }}
              </h3>
            </div>
          </div>
        </div>
      </div>
      <!-- End Card -->
    </div>
    <!-- End Stats Grid -->

    <!-- Shortcuts Section -->
    <div class="space-y-4">
      <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">Aksi Cepat</h2>
      <div class="grid sm:grid-cols-3 gap-6">
        <!-- Add Doctor Shortcut -->
        <button type="button" onclick="CrudHandler.openModal('hs-dashboard-add-dokter-modal')"
          class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md focus:outline-hidden transition dark:bg-neutral-800 dark:border-neutral-700">
          <div class="p-4 md:p-5">
            <div class="flex items-center gap-x-2">
              <div
                class="shrink-0 flex justify-center items-center size-[38px] border border-gray-200 text-gray-500 rounded-lg group-hover:bg-blue-600 group-hover:text-white group-hover:border-blue-600 transition dark:border-neutral-700 dark:text-neutral-400 dark:group-hover:bg-blue-500">
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                  fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M5 12h14" />
                  <path d="M12 5v14" />
                </svg>
              </div>
              <div class="grow">
                <p
                  class="text-sm font-semibold text-gray-800 group-hover:text-blue-600 transition dark:text-neutral-200 dark:group-hover:text-white">
                  Add Doctor
                </p>
              </div>
            </div>
          </div>
        </button>

        <!-- Add Shift Shortcut -->
        <button type="button" onclick="CrudHandler.openModal('hs-dashboard-add-shift-modal')"
          class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md focus:outline-hidden transition dark:bg-neutral-800 dark:border-neutral-700">
          <div class="p-4 md:p-5">
            <div class="flex items-center gap-x-2">
              <div
                class="shrink-0 flex justify-center items-center size-[38px] border border-gray-200 text-gray-500 rounded-lg group-hover:bg-teal-600 group-hover:text-white group-hover:border-teal-600 transition dark:border-neutral-700 dark:text-neutral-400 dark:group-hover:bg-teal-500">
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                  fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M5 12h14" />
                  <path d="M12 5v14" />
                </svg>
              </div>
              <div class="grow">
                <p
                  class="text-sm font-semibold text-gray-800 group-hover:text-teal-600 transition dark:text-neutral-200 dark:group-hover:text-white">
                  Add Shift
                </p>
              </div>
            </div>
          </div>
        </button>

        <!-- Add Medicine Shortcut -->
        <button type="button" onclick="CrudHandler.openModal('hs-dashboard-add-obat-modal')"
          class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md focus:outline-hidden transition dark:bg-neutral-800 dark:border-neutral-700">
          <div class="p-4 md:p-5">
            <div class="flex items-center gap-x-2">
              <div
                class="shrink-0 flex justify-center items-center size-[38px] border border-gray-200 text-gray-500 rounded-lg group-hover:bg-orange-600 group-hover:text-white group-hover:border-orange-600 transition dark:border-neutral-700 dark:text-neutral-400 dark:group-hover:bg-orange-500">
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                  fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M5 12h14" />
                  <path d="M12 5v14" />
                </svg>
              </div>
              <div class="grow">
                <p
                  class="text-sm font-semibold text-gray-800 group-hover:text-orange-600 transition dark:text-neutral-200 dark:group-hover:text-white">
                  Add Medicine
                </p>
              </div>
            </div>
          </div>
        </button>
      </div>
    </div>

    <!-- Poli Table Section -->
    <div class="space-y-4">
      <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">Layanan Poliklinik</h2>
      <div
        class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-neutral-800 dark:border-neutral-700">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
            <thead class="bg-gray-50 dark:bg-neutral-800">
              <tr>
                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">No</th>
                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Nama
                  Poli</th>
                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">
                  Keterangan</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
              @forelse($polis as $index => $poli)
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">
                    {{ $index + 1 }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">{{ $poli->nama_poli }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-neutral-400">
                    {{ $poli->keterangan ?? 'Aktif' }}
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-neutral-400">Belum ada data
                    poli.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('modals')
  <!-- Add Doctor Modal -->
  <x-popupmodal id="hs-dashboard-add-dokter-modal" title="Add New Doctor">
    <form id="dashboard-add-dokter-form" action="{{ route('dokter.store') }}" method="POST">
      @csrf
      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium mb-2 dark:text-white">Nama Lengkap</label>
          <input type="text" name="nama"
            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
            required>
        </div>
        <div>
          <label class="block text-sm font-medium mb-2 dark:text-white">Pilih Poli</label>
          <select name="id_poli"
            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
            @foreach($polis as $p)
              <option value="{{ $p->id }}">{{ $p->nama_poli }}</option>
            @endforeach
          </select>
        </div>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium mb-2 dark:text-white">Username</label>
            <input type="text" name="username"
              class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
              required>
          </div>
          <div>
            <label class="block text-sm font-medium mb-2 dark:text-white">Password</label>
            <input type="password" name="password"
              class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
              required>
          </div>
        </div>
      </div>
    </form>
    @slot('footer')
    <button type="button"
      class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700"
      onclick="CrudHandler.submitForm('dashboard-add-dokter-form', 'hs-dashboard-add-dokter-modal', null)">
      Save Doctor
    </button>
    @endslot
  </x-popupmodal>

  <!-- Add Shift Modal -->
  <x-popupmodal id="hs-dashboard-add-shift-modal" title="Add New Shift">
    <form id="dashboard-add-shift-form" action="{{ route('shift.store') }}" method="POST">
      @csrf
      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium mb-2 dark:text-white">Nama Shift (e.g. Pagi)</label>
          <input type="text" name="nama"
            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
            required>
        </div>
        <div>
          <label class="block text-sm font-medium mb-2 dark:text-white">Hari</label>
          <select name="hari"
            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
            <option value="Senin">Senin</option>
            <option value="Selasa">Selasa</option>
            <option value="Rabu">Rabu</option>
            <option value="Kamis">Kamis</option>
            <option value="Jumat">Jumat</option>
            <option value="Sabtu">Sabtu</option>
            <option value="Minggu">Minggu</option>
          </select>
        </div>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium mb-2 dark:text-white">Jam Masuk</label>
            <input type="time" name="jam_masuk"
              class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
              required>
          </div>
          <div>
            <label class="block text-sm font-medium mb-2 dark:text-white">Jam Keluar</label>
            <input type="time" name="jam_keluar"
              class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
              required>
          </div>
        </div>
      </div>
    </form>
    @slot('footer')
    <button type="button"
      class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-teal-600 text-white hover:bg-teal-700"
      onclick="CrudHandler.submitForm('dashboard-add-shift-form', 'hs-dashboard-add-shift-modal', null)">
      Save Shift
    </button>
    @endslot
  </x-popupmodal>

  <!-- Add Medicine Modal -->
  <x-popupmodal id="hs-dashboard-add-obat-modal" title="Add New Medicine">
    <form id="dashboard-add-obat-form" action="{{ route('obat.list.store') }}" method="POST">
      @csrf
      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium mb-2 dark:text-white">Nama Obat</label>
          <input type="text" name="nama_obat"
            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
            required>
        </div>
        <div>
          <label class="block text-sm font-medium mb-2 dark:text-white">Kemasan</label>
          <input type="text" name="kemasan" placeholder="e.g. Strip / Botol"
            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
            required>
        </div>
        <div>
          <label class="block text-sm font-medium mb-2 dark:text-white">Harga (Rp)</label>
          <input type="number" name="harga"
            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
            required>
        </div>
      </div>
    </form>
    @slot('footer')
    <button type="button"
      class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-orange-600 text-white hover:bg-orange-700"
      onclick="CrudHandler.submitForm('dashboard-add-obat-form', 'hs-dashboard-add-obat-modal', null)">
      Save Medicine
    </button>
    @endslot
  </x-popupmodal>
@endsection