@extends('layouts.admin')

@section('title', 'Manajemen Stok Obat')

@section('content')
<div class="flex flex-col">
  <div class="-m-1.5 overflow-x-auto">
    <div class="p-1.5 min-w-full inline-block align-middle">
      <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-neutral-800 dark:border-neutral-700">
        <!-- Header -->
        <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-neutral-700">
          <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
              Manajemen Stok Obat
            </h2>
            <p class="text-sm text-gray-600 dark:text-neutral-400">
              Pantau dan perbarui jumlah ketersediaan obat secara real-time.
            </p>
          </div>
        </div>
        <!-- End Header -->

        <!-- Table -->
        <div id="stok-table-container">
          @include('obat.stok-table')
        </div>
        <!-- End Table -->

        <!-- Footer -->
        <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-t border-gray-200 dark:border-neutral-700">
          <div>
            <p class="text-sm text-gray-600 dark:text-neutral-400">
              Total <span class="font-semibold text-gray-800 dark:text-neutral-200">{{ $obats->count() }}</span> jenis obat terdaftar.
            </p>
          </div>
        </div>
        <!-- End Footer -->
      </div>
    </div>
  </div>
</div>

<!-- Global Update Stok Modal -->
<x-popupmodal id="hs-update-stok-modal" title="Update Stok Obat">
  <form id="update-stok-form" action="" method="POST">
    @csrf
    @method('PUT')
    <input type="hidden" name="view_type" value="stok">
    <div class="space-y-4">
      <div>
        <label class="block text-sm font-medium mb-1 dark:text-white">Nama Obat</label>
        <div id="stok-obat-nama-display" class="py-2 px-3 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-800 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
          -
        </div>
      </div>
      <div>
        <label class="block text-sm font-medium mb-2 dark:text-white">Jumlah Stok Saat Ini</label>
        <input type="number" id="edit-obat-stok-value" name="stok" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" required>
        <p class="mt-2 text-xs text-gray-500">
          Berapa jumlah total stok fisik yang tersedia sekarang?
        </p>
      </div>
    </div>
  </form>
  @slot('footer')
    <button type="button" 
            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-teal-600 text-white hover:bg-teal-700 focus:outline-hidden"
            onclick="CrudHandler.submitForm('update-stok-form', 'hs-update-stok-modal', 'stok-table-container')">
      Perbarui Stok
    </button>
  @endslot
</x-popupmodal>
@endsection
