@extends('layouts.admin')

@section('title', 'Riwayat Pasien')

@section('content')
<div class="flex flex-col gap-6">
  <!-- Header & Filters -->
  <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 dark:bg-neutral-800 dark:border-neutral-700">
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
      <div>
        <h2 class="text-xl font-bold text-gray-800 dark:text-neutral-200">
          Riwayat Pemeriksaan Pasien
        </h2>
        <p class="text-sm text-gray-600 dark:text-neutral-400">
          Kelola dan lihat riwayat pemeriksaan yang telah Anda tangani.
        </p>
      </div>

      <!-- Filters -->
      <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
        <div class="w-full md:w-48">
          <select id="filter-shift" onchange="refreshTable()"
            class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
            <option value="">Semua Shift</option>
            @foreach($shifts as $s)
              <option value="{{ $s->id }}">{{ $s->nama }} ({{ $s->hari }})</option>
            @endforeach
          </select>
        </div>
        <div class="w-full md:w-48">
          <input type="date" id="filter-date" onchange="refreshTable()"
            class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
        </div>
        <button type="button" onclick="resetFilters()"
          class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800">
          Reset
        </button>
      </div>
    </div>
  </div>

  <!-- Table Section -->
  <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-neutral-800 dark:border-neutral-700">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
        <thead class="bg-gray-50 dark:bg-neutral-700">
          <tr>
            <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Nama Pasien</th>
            <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Tanggal</th>
            <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">No Antrian</th>
            <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Diagnosis</th>
            <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Status</th>
            <th class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">Aksi</th>
          </tr>
        </thead>
        <tbody id="history-table-body" class="divide-y divide-gray-200 dark:divide-neutral-700">
          @include('doctor.history.table', ['riwayat' => $riwayat])
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Detail Modal -->
<div id="detail-modal" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none">
  <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
    <div class="flex flex-col bg-white border shadow-sm rounded-xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70">
      <div class="flex justify-between items-center py-3 px-4 border-b dark:border-neutral-700">
        <h3 class="font-bold text-gray-800 dark:text-white">
          Detail Pemeriksaan
        </h3>
        <button type="button" class="flex justify-center items-center size-7 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700" data-hs-overlay="#detail-modal">
          <span class="sr-only">Close</span>
          <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
      </div>
      <div class="p-4 overflow-y-auto" id="modal-content">
        <!-- Content will be loaded via AJAX -->
        <div class="animate-pulse flex space-x-4">
          <div class="flex-1 space-y-6 py-1">
            <div class="h-2 bg-slate-200 rounded"></div>
            <div class="space-y-3">
              <div class="grid grid-cols-3 gap-4">
                <div class="h-2 bg-slate-200 rounded col-span-2"></div>
                <div class="h-2 bg-slate-200 rounded col-span-1"></div>
              </div>
              <div class="h-2 bg-slate-200 rounded"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t dark:border-neutral-700">
        <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800" data-hs-overlay="#detail-modal">
          Tutup
        </button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  async function refreshTable() {
    const shift = document.getElementById('filter-shift').value;
    const date = document.getElementById('filter-date').value;
    const tbody = document.getElementById('history-table-body');
    
    tbody.innerHTML = '<tr><td colspan="6" class="px-6 py-10 text-center"><div class="animate-spin inline-block size-6 border-[3px] border-current border-t-transparent text-blue-600 rounded-full" role="status" aria-label="loading"><span class="sr-only">Loading...</span></div></td></tr>';

    try {
      const response = await fetch(`{{ route('doctor.riwayat') }}?id_shift=${shift}&date=${date}`, {
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      });
      const data = await response.json();
      if (data.success) {
        tbody.innerHTML = data.html;
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
    HSOverlay.open('#detail-modal');
    
    modalContent.innerHTML = '<div class="text-center py-10"><div class="animate-spin inline-block size-6 border-[3px] border-current border-t-transparent text-blue-600 rounded-full"></div></div>';

    try {
      const response = await fetch(`{{ url('/doctor/riwayat') }}/${id}`);
      const result = await response.json();
      
      if (result.success) {
        const d = result.data;
        let obatList = '<ul class="list-disc ps-5 space-y-1">';
        if (d.detail_periksa_obat && d.detail_periksa_obat.length > 0) {
          d.detail_periksa_obat.forEach(item => {
            obatList += `<li>${item.obat.nama_obat} (${item.jumlah})</li>`;
          });
        } else {
          obatList += '<li class="text-gray-500 italic">Tidak ada obat</li>';
        }
        obatList += '</ul>';

        modalContent.innerHTML = `
          <div class="space-y-4">
            <div>
              <h4 class="text-xs font-semibold text-gray-400 uppercase">Nama Pasien</h4>
              <p class="text-sm font-medium text-gray-800 dark:text-neutral-200">${d.pasien.nama}</p>
            </div>
            <div>
              <h4 class="text-xs font-semibold text-gray-400 uppercase">Keluhan</h4>
              <p class="text-sm text-gray-800 dark:text-neutral-200">${d.keluhan || '-'}</p>
            </div>
            <div>
              <h4 class="text-xs font-semibold text-gray-400 uppercase">Catatan</h4>
              <p class="text-sm text-gray-800 dark:text-neutral-200">${d.catatan || '-'}</p>
            </div>
            <div>
              <h4 class="text-xs font-semibold text-gray-400 uppercase">Daftar Obat</h4>
              <div class="mt-2 p-3 bg-gray-50 rounded-lg dark:bg-neutral-900/50">
                ${obatList}
              </div>
            </div>
          </div>
        `;
      }
    } catch (error) {
      console.error('Error:', error);
      modalContent.innerHTML = '<p class="text-red-500 text-center">Gagal memuat detail.</p>';
    }
  }
</script>
@endpush
