@extends('layouts.admin')

@section('title', 'Laporan Keuangan')

@section('content')
<div class="p-4 sm:p-6 space-y-6">
  <!-- Header -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-gray-800 dark:text-neutral-200">Laporan Keuangan</h1>
      <p class="text-sm text-gray-500 dark:text-neutral-400">
        Ringkasan pendapatan dan riwayat transaksi yang telah diverifikasi.
      </p>
    </div>
    <div class="flex gap-2">
      <button type="button" onclick="exportToExcel('table-laporan', 'Laporan_Keuangan')"
        class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-xl bg-blue-600 text-white hover:bg-blue-700 shadow-sm transition-all">
        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
        Ekspor Excel
      </button>
    </div>
  </div>

  <!-- Stats Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-6">
    <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-2xl p-5 dark:bg-neutral-800 dark:border-neutral-700">
      <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Pendapatan Hari Ini</p>
      <h3 class="text-2xl font-black text-gray-800 dark:text-neutral-200">Rp {{ number_format($stats['today'], 0, ',', '.') }}</h3>
    </div>
    <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-2xl p-5 dark:bg-neutral-800 dark:border-neutral-700">
      <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Minggu Ini</p>
      <h3 class="text-2xl font-black text-blue-600 dark:text-blue-400">Rp {{ number_format($stats['week'], 0, ',', '.') }}</h3>
    </div>
    <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-2xl p-5 dark:bg-neutral-800 dark:border-neutral-700">
      <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Bulan Ini</p>
      <h3 class="text-2xl font-black text-green-600 dark:text-green-400">Rp {{ number_format($stats['month'], 0, ',', '.') }}</h3>
    </div>
  </div>

  <!-- Filter Card -->
  <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 dark:bg-neutral-800 dark:border-neutral-700">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
      <div>
        <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-neutral-300">Dari Tanggal</label>
        <input type="date" id="start_date" onchange="refreshTable()"
          class="py-2.5 px-4 block w-full border border-gray-300 rounded-xl text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
      </div>
      <div>
        <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-neutral-300">Sampai Tanggal</label>
        <input type="date" id="end_date" onchange="refreshTable()"
          class="py-2.5 px-4 block w-full border border-gray-300 rounded-xl text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
      </div>
      <button type="button" onclick="resetFilters()"
        class="py-2.5 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-xl border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 dark:bg-neutral-900 dark:border-neutral-700 dark:text-white">
        Reset Filter
      </button>
    </div>
  </div>

  <!-- Table -->
  <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden dark:bg-neutral-800 dark:border-neutral-700">
    <div class="overflow-x-auto">
      <table id="table-laporan" class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
        <thead class="bg-gray-50 dark:bg-neutral-700">
          <tr>
            <th class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal Bayar</th>
            <th class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider">Pasien</th>
            <th class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider text-end">Total Pembayaran</th>
            <th class="px-6 py-4 text-end text-xs font-bold text-gray-500 uppercase tracking-wider">Kasir</th>
          </tr>
        </thead>
        <tbody id="laporan-table-body" class="divide-y divide-gray-200 dark:divide-neutral-700">
          @include('keuangan.laporan_table', ['laporan' => $laporan])
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  async function refreshTable() {
    const start = document.getElementById('start_date').value;
    const end = document.getElementById('end_date').value;
    const tbody = document.getElementById('laporan-table-body');
    
    tbody.innerHTML = '<tr><td colspan="4" class="px-6 py-10 text-center"><div class="animate-spin inline-block size-6 border-[3px] border-current border-t-transparent text-blue-600 rounded-full"></div></td></tr>';

    try {
      const response = await fetch(`{{ route('keuangan.laporan') }}?start_date=${start}&end_date=${end}`, {
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
    refreshTable();
  }

</script>
@endpush
