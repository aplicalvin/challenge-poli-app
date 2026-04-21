@extends('layouts.admin')

@section('title', 'Manajemen Ruang')

@section('content')
<div class="flex flex-col">
  <div class="-m-1.5 overflow-x-auto">
    <div class="p-1.5 min-w-full inline-block align-middle">
      <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-neutral-800 dark:border-neutral-700">
        <!-- Header -->
        <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-neutral-700">
          <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
              Manajemen Ruang
            </h2>
            <p class="text-sm text-gray-600 dark:text-neutral-400">
              Daftar ruangan poliklinik beserta unit layanannya.
            </p>
          </div>

          <div>
            <div class="inline-flex gap-x-2">
              <button type="button" 
                      class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" 
                      onclick="CrudHandler.openModal('hs-create-ruang-modal')">
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                Tambah Ruang
              </button>
            </div>
          </div>
        </div>
        <!-- End Header -->

        <!-- Table -->
        <div id="table-container">
          @include('penjadwalan.ruang-table')
        </div>
        <!-- End Table -->

        <!-- Footer -->
        <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-t border-gray-200 dark:border-neutral-700">
          <div>
            <p class="text-sm text-gray-600 dark:text-neutral-400">
              Menampilkan <span class="font-semibold text-gray-800 dark:text-neutral-200">{{ $ruangs->count() }}</span> data.
            </p>
          </div>
        </div>
        <!-- End Footer -->
      </div>
    </div>
  </div>
</div>

<!-- Create Modal -->
<x-popupmodal id="hs-create-ruang-modal" title="Tambah Ruang Baru">
  <form id="create-ruang-form" action="{{ route('ruang.store') }}" method="POST">
    @csrf
    <div class="space-y-4">
      <div>
        <label class="block text-sm font-medium mb-2 dark:text-white">Nama Ruang</label>
        <input type="text" name="nama" class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" placeholder="Contoh: Poli Umum 01 / Laboratorium" required>
      </div>
      <div>
        <label class="block text-sm font-medium mb-2 dark:text-white">Poliklinik</label>
        <select name="id_poli" class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
          @foreach($polis as $p)
            <option value="{{ $p->id }}">{{ $p->nama_poli }}</option>
          @endforeach
        </select>
      </div>
    </div>
  </form>
  @slot('footer')
    <button type="button" 
            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden"
            onclick="CrudHandler.submitForm('create-ruang-form', 'hs-create-ruang-modal', 'table-container')">
      Simpan
    </button>
  @endslot
</x-popupmodal>

<!-- Global Edit Modal -->
<x-popupmodal id="hs-edit-ruang-modal" title="Edit Ruang">
  <form id="edit-ruang-form" action="" method="POST">
    @csrf
    @method('PUT')
    <div class="space-y-4">
      <div>
        <label class="block text-sm font-medium mb-2 dark:text-white">Nama Ruang</label>
        <input type="text" id="edit-ruang-nama" name="nama" class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" required>
      </div>
      <div>
        <label class="block text-sm font-medium mb-2 dark:text-white">Poliklinik</label>
        <select id="edit-ruang-poli" name="id_poli" class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
          @foreach($polis as $p)
            <option value="{{ $p->id }}">{{ $p->nama_poli }}</option>
          @endforeach
        </select>
      </div>
    </div>
  </form>
  @slot('footer')
    <button type="button" 
            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden"
            onclick="CrudHandler.submitForm('edit-ruang-form', 'hs-edit-ruang-modal', 'table-container')">
      Update
    </button>
  @endslot
</x-popupmodal>
@endsection
