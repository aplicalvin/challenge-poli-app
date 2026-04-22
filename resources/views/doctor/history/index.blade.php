@extends('layouts.admin')

@section('title', 'Riwayat Pemeriksaan')

@section('content')
<div class="p-4 sm:p-6 space-y-6">
  <!-- Header Section -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-gray-800 dark:text-neutral-200">Riwayat Pemeriksaan</h1>
      <p class="text-sm text-gray-500 dark:text-neutral-400 text-balance max-w-2xl">
        Pantau seluruh riwayat pemeriksaan pasien yang telah Anda tangani dengan fitur filter dan pencarian yang canggih.
      </p>
    </div>
    
    <div class="flex items-center gap-2">
      <span class="relative flex h-3 w-3">
        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
        <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
      </span>
      <span class="text-xs font-medium text-blue-600 dark:text-blue-400 uppercase tracking-wider">Live System</span>
    </div>
  </div>

  <!-- Filter Card -->
  <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 dark:bg-neutral-800 dark:border-neutral-700">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
      <div>
        <label for="filter-shift" class="block text-sm font-medium mb-2 text-gray-700 dark:text-neutral-300">Filter Shift</label>
        <select id="filter-shift" onchange="refreshTable()"
          class="py-2.5 px-4 block w-full border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
          <option value="">Semua Shift Anda</option>
          @foreach($shifts as $s)
            <option value="{{ $s->id }}">{{ $s->nama }} ({{ $s->hari }})</option>
          @endforeach
        </select>
      </div>

      <div>
        <label for="filter-date" class="block text-sm font-medium mb-2 text-gray-700 dark:text-neutral-300">Filter Tanggal</label>
        <input type="date" id="filter-date" onchange="refreshTable()"
          class="py-2.5 px-4 block w-full border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
      </div>

      <div class="flex gap-2">
        <button type="button" onclick="resetFilters()"
          class="flex-1 py-2.5 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-xl border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800">
          <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
          Reset Filter
        </button>
      </div>
    </div>
  </div>

  <!-- Table Card -->
  <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden dark:bg-neutral-800 dark:border-neutral-700">
    <div class="p-6">
      <div id="table-container" class="overflow-x-auto">
        <table id="history-table" class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
          <thead class="bg-gray-50 dark:bg-neutral-700">
            <tr>
              <th class="px-6 py-4 text-start text-xs font-semibold text-gray-500 uppercase tracking-wider dark:text-neutral-400">Nama Pasien</th>
              <th class="px-6 py-4 text-start text-xs font-semibold text-gray-500 uppercase tracking-wider dark:text-neutral-400">Tanggal</th>
              <th class="px-6 py-4 text-start text-xs font-semibold text-gray-500 uppercase tracking-wider dark:text-neutral-400 text-center">No Antrian</th>
              <th class="px-6 py-4 text-start text-xs font-semibold text-gray-500 uppercase tracking-wider dark:text-neutral-400">Diagnosis</th>
              <th class="px-6 py-4 text-start text-xs font-semibold text-gray-500 uppercase tracking-wider dark:text-neutral-400">Status</th>
              <th class="px-6 py-4 text-end text-xs font-semibold text-gray-500 uppercase tracking-wider dark:text-neutral-400">Aksi</th>
            </tr>
          </thead>
          <tbody id="history-table-body" class="divide-y divide-gray-200 dark:divide-neutral-700">
            @include('doctor.history.table', ['riwayat' => $riwayat])
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Detail Modal -->
<div id="detail-modal" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none">
  <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
    <div class="flex flex-col bg-white border border-gray-200 shadow-xl rounded-3xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700">
      <div class="flex justify-between items-center py-4 px-6 border-b dark:border-neutral-700 bg-gray-50/50 rounded-t-3xl dark:bg-neutral-800">
        <div>
          <h3 class="font-bold text-gray-800 dark:text-white">
            Detail Pemeriksaan
          </h3>
          <p class="text-xs text-gray-500 dark:text-neutral-400" id="modal-patient-name">Memuat data...</p>
        </div>
        <button type="button" class="flex justify-center items-center size-8 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700" data-hs-overlay="#detail-modal">
          <span class="sr-only">Close</span>
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
      </div>
      <div class="p-6 space-y-6 overflow-y-auto max-h-[70vh]" id="modal-content">
        <!-- Loader Skeleton -->
        <div class="animate-pulse space-y-4">
          <div class="h-4 bg-gray-200 rounded-full dark:bg-neutral-700 w-3/4"></div>
          <div class="h-32 bg-gray-100 rounded-2xl dark:bg-neutral-700/50"></div>
          <div class="h-4 bg-gray-200 rounded-full dark:bg-neutral-700 w-1/2"></div>
        </div>
      </div>
      <div class="flex justify-end items-center gap-x-2 py-4 px-6 border-t dark:border-neutral-700">
        <button type="button" class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-xl border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800" data-hs-overlay="#detail-modal">
          Tutup
        </button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<style>
  .dataTables_wrapper .dataTables_length select {
    @apply py-1.5 px-3 border-gray-200 rounded-lg text-sm dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400;
    min-width: 60px;
  }
  .dataTables_wrapper .dataTables_filter input {
    @apply py-2 px-4 border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400;
    margin-left: 0.5rem;
  }
  .dataTables_wrapper .dataTables_info {
    @apply text-sm text-gray-500 dark:text-neutral-400 pt-4;
  }
  .dataTables_wrapper .dataTables_paginate {
    @apply pt-4;
  }
  .dataTables_wrapper .dataTables_paginate .paginate_button {
    @apply py-1.5 px-3 text-sm rounded-lg border-transparent !important;
  }
  .dataTables_wrapper .dataTables_paginate .paginate_button.current {
    @apply bg-blue-600 text-white !important;
  }
  .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    @apply bg-gray-100 text-gray-800 !important;
  }
  table.dataTable thead th {
    @apply border-b-0 !important;
  }
  table.dataTable.no-footer {
    @apply border-b-0 !important;
  }
</style>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

<script>
  let dataTable;

  function initDataTable() {
    if ($.fn.DataTable.isDataTable('#history-table')) {
      $('#history-table').DataTable().destroy();
    }
    
    dataTable = $('#history-table').DataTable({
      pageLength: 10,
      language: {
        search: "Cari:",
        lengthMenu: "Tampilkan _MENU_ data",
        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
        paginate: {
          first: "Awal",
          last: "Akhir",
          next: "Next",
          previous: "Prev"
        },
        emptyTable: "Tidak ada data riwayat pemeriksaan."
      },
      columnDefs: [
        { orderable: false, targets: [5] }
      ],
      order: [[1, 'desc']], // Sort by date by default
      dom: '<"flex flex-col md:flex-row justify-between items-center gap-4 mb-4"lf>rt<"flex flex-col md:flex-row justify-between items-center gap-4 mt-4"ip>'
    });
  }

  $(document).ready(function() {
    initDataTable();
  });

  async function refreshTable() {
    const shift = document.getElementById('filter-shift').value;
    const date = document.getElementById('filter-date').value;
    const tbody = document.getElementById('history-table-body');
    
    // Show loading state
    tbody.innerHTML = '<tr><td colspan="6" class="px-6 py-10 text-center"><div class="animate-spin inline-block size-6 border-[3px] border-current border-t-transparent text-blue-600 rounded-full" role="status" aria-label="loading"><span class="sr-only">Loading...</span></div></td></tr>';

    try {
      const response = await fetch(`{{ route('doctor.riwayat') }}?id_shift=${shift}&date=${date}`, {
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      });
      const data = await response.json();
      if (data.success) {
        // Destroy existing DT before replacing HTML
        if (dataTable) dataTable.destroy();
        
        tbody.innerHTML = data.html;
        
        // Re-init DT
        initDataTable();
      }
    } catch (error) {
      console.error('Error:', error);
      tbody.innerHTML = '<tr><td colspan="6" class="px-6 py-10 text-center text-red-500">Gagal memuat data.</td></tr>';
    }
  }

  function resetFilters() {
    document.getElementById('filter-shift').value = '';
    document.getElementById('filter-date').value = '';
    refreshTable();
  }

  async function showDetail(id) {
    const modalContent = document.getElementById('modal-content');
    const modalTitleName = document.getElementById('modal-patient-name');
    
    HSOverlay.open('#detail-modal');
    
    modalTitleName.textContent = 'Memuat data...';
    modalContent.innerHTML = `
      <div class="flex flex-col items-center justify-center py-12 space-y-4">
        <div class="animate-spin inline-block size-8 border-[3px] border-current border-t-transparent text-blue-600 rounded-full"></div>
        <p class="text-sm text-gray-500">Menarik data dari server...</p>
      </div>
    `;

    try {
      const response = await fetch(`{{ url('/doctor/riwayat') }}/${id}`);
      const result = await response.json();
      
      if (result.success) {
        const d = result.data;
        modalTitleName.textContent = d.pasien.nama;
        
        let obatListHtml = '';
        if (d.detail_periksa_obat && d.detail_periksa_obat.length > 0) {
          obatListHtml = d.detail_periksa_obat.map(item => `
            <div class="flex items-center justify-between p-3 bg-white border border-gray-100 rounded-xl dark:bg-neutral-900 dark:border-neutral-700">
              <div class="flex items-center gap-3">
                <div class="size-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
                  <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m10.5 20.5 10-10a4.95 4.95 0 1 0-7-7l-10 10a4.95 4.95 0 1 0 7 7Z"/><path d="m8.5 8.5 7 7"/></svg>
                </div>
                <div>
                  <p class="text-sm font-semibold text-gray-800 dark:text-neutral-200">${item.obat.nama_obat}</p>
                  <p class="text-xs text-gray-500">${item.obat.kemasan}</p>
                </div>
              </div>
              <span class="text-sm font-bold text-blue-600 dark:text-blue-400">${item.jumlah} Unit</span>
            </div>
          `).join('');
        } else {
          obatListHtml = `
            <div class="text-center py-6 border-2 border-dashed border-gray-100 rounded-2xl dark:border-neutral-700">
              <p class="text-sm text-gray-400 italic">Tidak ada obat yang diresepkan.</p>
            </div>
          `;
        }

        modalContent.innerHTML = `
          <div class="space-y-6">
            <!-- Grid Info -->
            <div class="grid grid-cols-2 gap-4">
              <div class="p-4 bg-gray-50 rounded-2xl dark:bg-neutral-900/50">
                <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Tanggal Periksa</h4>
                <p class="text-sm font-semibold text-gray-800 dark:text-neutral-200">${new Date(d.tgl_periksa).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'})}</p>
              </div>
              <div class="p-4 bg-gray-50 rounded-2xl dark:bg-neutral-900/50">
                <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">No. Antrian</h4>
                <p class="text-sm font-semibold text-gray-800 dark:text-neutral-200">#${d.no_antrian}</p>
              </div>
            </div>

            <div class="space-y-2">
              <h4 class="text-xs font-bold text-gray-800 dark:text-white flex items-center gap-2">
                <svg class="size-4 text-blue-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21a9 9 0 0 0 9-9 9 9 0 0 0-9-9 9 9 0 0 0-9 9 9 9 0 0 0 9 9z"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>
                Keluhan Pasien
              </h4>
              <div class="p-4 bg-orange-50 border border-orange-100 rounded-2xl dark:bg-orange-900/10 dark:border-orange-900/20">
                <p class="text-sm text-orange-800 dark:text-orange-300 leading-relaxed">${d.keluhan || 'Tidak ada keluhan tercatat.'}</p>
              </div>
            </div>

            <div class="space-y-2">
              <h4 class="text-xs font-bold text-gray-800 dark:text-white flex items-center gap-2">
                <svg class="size-4 text-green-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Diagnosis & Catatan
              </h4>
              <div class="p-4 bg-green-50 border border-green-100 rounded-2xl dark:bg-green-900/10 dark:border-green-900/20">
                <p class="text-sm font-bold text-green-900 dark:text-green-300 mb-1">${d.nama_penyakit || 'Umum'}</p>
                <p class="text-sm text-green-800 dark:text-green-400 italic">"${d.catatan || '-'}"</p>
              </div>
            </div>

            <div class="space-y-3">
              <h4 class="text-xs font-bold text-gray-800 dark:text-white flex items-center gap-2">
                <svg class="size-4 text-purple-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m10.5 20.5 10-10a4.95 4.95 0 1 0-7-7l-10 10a4.95 4.95 0 1 0 7 7Z"/><path d="m8.5 8.5 7 7"/></svg>
                Resep Obat
              </h4>
              <div class="space-y-2">
                ${obatListHtml}
              </div>
            </div>
          </div>
        `;
      }
    } catch (error) {
      console.error('Error:', error);
      modalContent.innerHTML = `
        <div class="text-center py-12">
          <div class="size-12 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="size-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
          </div>
          <p class="text-sm font-medium text-gray-800 dark:text-white">Gagal Memuat Detail</p>
          <p class="text-xs text-gray-500 mt-1">Silahkan coba beberapa saat lagi atau hubungi IT.</p>
        </div>
      `;
    }
  }
</script>
@endpush
