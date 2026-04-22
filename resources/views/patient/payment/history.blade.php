@extends('layouts.admin')

@section('title', 'Riwayat Pembayaran')

@section('content')
<div class="p-4 sm:p-6 space-y-6">
  <!-- Header -->
  <div>
    <h1 class="text-2xl font-bold text-gray-800 dark:text-neutral-200">Riwayat Pembayaran Anda</h1>
    <p class="text-sm text-gray-500 dark:text-neutral-400">
      Pantau status pembayaran dan unduh bukti transaksi Anda di sini.
    </p>
  </div>

  <!-- Filter Card -->
  <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 dark:bg-neutral-800 dark:border-neutral-700">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
      <div>
        <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-neutral-300">Dari Tanggal</label>
        <input type="date" id="start_date" onchange="refreshTable()"
          class="py-2.5 px-4 block w-full border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
      </div>
      <div>
        <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-neutral-300">Sampai Tanggal</label>
        <input type="date" id="end_date" onchange="refreshTable()"
          class="py-2.5 px-4 block w-full border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
      </div>
      <div>
        <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-neutral-300">Status</label>
        <select id="filter_status" onchange="refreshTable()"
          class="py-2.5 px-4 block w-full border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
          <option value="">Semua Status</option>
          <option value="pending">Pending</option>
          <option value="lunas">Lunas</option>
        </select>
      </div>
      <button type="button" onclick="resetFilters()"
        class="py-2.5 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-xl border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800">
        Reset
      </button>
    </div>
  </div>

  <!-- Table Card -->
  <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden dark:bg-neutral-800 dark:border-neutral-700">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
        <thead class="bg-gray-50 dark:bg-neutral-700">
          <tr>
            <th class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider">Waktu Transaksi</th>
            <th class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider text-end">Total Bayar</th>
            <th class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Status</th>
            <th class="px-6 py-4 text-end text-xs font-bold text-gray-500 uppercase tracking-wider">Bukti</th>
          </tr>
        </thead>
        <tbody id="payment-table-body" class="divide-y divide-gray-200 dark:divide-neutral-700">
          @include('patient.payment.table', ['pembayaran' => $pembayaran])
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Image Modal -->
<div id="image-modal" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none">
  <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
    <div class="flex flex-col bg-white border shadow-sm rounded-3xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700">
      <div class="flex justify-between items-center py-3 px-4 border-b dark:border-neutral-700 bg-gray-50/50 rounded-t-3xl dark:bg-neutral-800">
        <h3 class="font-bold text-gray-800 dark:text-white">Bukti Pembayaran</h3>
        <button type="button" class="size-8 flex justify-center items-center text-gray-800 hover:bg-gray-100 rounded-full dark:text-white dark:hover:bg-neutral-700" data-hs-overlay="#image-modal">
          <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
      </div>
      <div class="p-4">
        <img id="preview-img" src="" alt="Proof" class="w-full rounded-2xl">
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
  function showImage(url) {
    document.getElementById('preview-img').src = url;
  }

  async function refreshTable() {
    const start = document.getElementById('start_date').value;
    const end = document.getElementById('end_date').value;
    const status = document.getElementById('filter_status').value;
    const tbody = document.getElementById('payment-table-body');
    
    tbody.innerHTML = '<tr><td colspan="4" class="px-6 py-10 text-center"><div class="animate-spin inline-block size-6 border-[3px] border-current border-t-transparent text-blue-600 rounded-full"></div></td></tr>';

    try {
      const response = await fetch(`{{ route('riwayat.pembayaran') }}?start_date=${start}&end_date=${end}&status=${status}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      });
      const data = await response.json();
      if (data.success) {
        tbody.innerHTML = data.html;
      }
    } catch (e) {
      console.error(e);
    }
  }

  function resetFilters() {
    document.getElementById('start_date').value = '';
    document.getElementById('end_date').value = '';
    document.getElementById('filter_status').value = '';
    refreshTable();
  }
</script>
@endpush
