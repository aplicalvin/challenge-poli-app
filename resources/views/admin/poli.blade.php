@extends('layouts.admin')

@section('title', 'Manajemen Poli')

@section('content')
<div class="flex flex-col">
  <div class="-m-1.5 overflow-x-auto">
    <div class="p-1.5 min-w-full inline-block align-middle">
      <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-neutral-800 dark:border-neutral-700">
        <!-- Header -->
        <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-neutral-700">
          <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
              Manajemen Poli
            </h2>
            <p class="text-sm text-gray-600 dark:text-neutral-400">
              Tambah, edit, atau hapus data poliklinik.
            </p>
          </div>

          <div>
            <div class="inline-flex gap-x-2">
              <button type="button" 
                      class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" 
                      onclick="CrudHandler.openModal('hs-create-poli-modal')">
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                Tambah Poli
              </button>
            </div>
          </div>
        </div>
        <!-- End Header -->

        <!-- Table -->
        <div id="table-container">
          @include('admin.poli-table')
        </div>
        <!-- End Table -->

        <!-- Footer -->
        <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-t border-gray-200 dark:border-neutral-700">
          <div>
            <p class="text-sm text-gray-600 dark:text-neutral-400">
              Menampilkan <span class="font-semibold text-gray-800 dark:text-neutral-200">{{ $polis->count() }}</span> data.
            </p>
          </div>
        </div>
        <!-- End Footer -->
      </div>
    </div>
  </div>
</div>

<!-- Create Modal -->
<x-popupmodal id="hs-create-poli-modal" title="Tambah Poli Baru">
  <form id="create-poli-form" action="{{ route('poli.store') }}" method="POST">
    @csrf
    <div class="space-y-4">
      <div>
        <label for="nama_poli" class="block text-sm font-medium mb-2 dark:text-white">Nama Poli</label>
        <input type="text" id="nama_poli" name="nama_poli" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Contoh: Poli Umum" required>
      </div>
      <div>
        <label for="keterangan" class="block text-sm font-medium mb-2 dark:text-white">Keterangan</label>
        <textarea id="keterangan" name="keterangan" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" rows="3" placeholder="Deskripsi singkat poli..."></textarea>
      </div>
    </div>
  </form>
  @slot('footer')
    <button type="button" 
            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
            onclick="CrudHandler.submitForm('create-poli-form', 'hs-create-poli-modal', 'table-container')">
      Simpan
    </button>
  @endslot
</x-popupmodal>
@endsection
