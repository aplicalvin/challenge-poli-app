@extends('layouts.admin')

@section('title', 'Manajemen Dokter')

@section('content')
<div class="flex flex-col">
  <div class="-m-1.5 overflow-x-auto">
    <div class="p-1.5 min-w-full inline-block align-middle">
      <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-neutral-800 dark:border-neutral-700">
        <!-- Header -->
        <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-neutral-700">
          <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
              Manajemen Dokter
            </h2>
            <p class="text-sm text-gray-600 dark:text-neutral-400">
              Kelola data Dokter dan akun akses mereka.
            </p>
          </div>

          <div>
            <div class="inline-flex gap-x-2">
              <button type="button" 
                      class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" 
                      onclick="CrudHandler.openModal('hs-create-dokter-modal')">
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
                Tambah Dokter
              </button>
            </div>
          </div>
        </div>
        <!-- End Header -->

        <!-- Table -->
        <div id="table-container">
          @include('admin.dokter-table')
        </div>
        <!-- End Table -->

        <!-- Footer -->
        <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-t border-gray-200 dark:border-neutral-700">
          <div>
            <p class="text-sm text-gray-600 dark:text-neutral-400">
              Menampilkan <span class="font-semibold text-gray-800 dark:text-neutral-200">{{ $dokters->count() }}</span> data.
            </p>
          </div>
        </div>
        <!-- End Footer -->
      </div>
    </div>
  </div>
</div>

<!-- Create Modal -->
<x-popupmodal id="hs-create-dokter-modal" title="Tambah Dokter Baru">
  <form id="create-dokter-form" action="{{ route('dokter.store') }}" method="POST">
    @csrf
    <div class="space-y-4">
      <div>
        <label class="block text-sm font-medium mb-2 dark:text-white">Nama Lengkap</label>
        <input type="text" name="nama" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" placeholder="dr. Ahmad" required>
      </div>
      <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium mb-2 dark:text-white">Username</label>
            <input type="text" name="username" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" required>
        </div>
        <div>
            <label class="block text-sm font-medium mb-2 dark:text-white">Poliklinik</label>
            <select name="id_poli" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                @forelse($polis as $p)
                    <option value="{{ $p->id }}">{{ $p->nama_poli }}</option>
                @empty
                    <option value="">Tambah Poli Terlebih Dahulu</option>
                @endforelse
            </select>
        </div>
      </div>
      <div>
        <label class="block text-sm font-medium mb-2 dark:text-white">Password</label>
        <input type="password" name="password" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" required>
      </div>
      <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium mb-2 dark:text-white">No HP</label>
            <input type="text" name="no_hp" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" placeholder="08...">
        </div>
        <div>
            <label class="block text-sm font-medium mb-2 dark:text-white">No KTP</label>
            <input type="text" name="no_ktp" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
        </div>
      </div>
      <div>
        <label class="block text-sm font-medium mb-2 dark:text-white">Alamat</label>
        <textarea name="alamat" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" rows="2" placeholder="Alamat lengkap..."></textarea>
      </div>
    </div>
  </form>
  @slot('footer')
    <button type="button" 
            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden"
            onclick="CrudHandler.submitForm('create-dokter-form', 'hs-create-dokter-modal', 'table-container')">
      Simpan
    </button>
  @endslot
</x-popupmodal>
@endsection
