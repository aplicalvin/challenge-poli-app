@extends('layouts.admin')

@section('title', 'Riwayat Pemeriksaan Pasien')

@section('content')
<div class="p-4 sm:p-6 space-y-6">
  <!-- Header Section -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-gray-800 dark:text-neutral-200">Riwayat Pemeriksaan Anda</h1>
      <p class="text-sm text-gray-500 dark:text-neutral-400">
        Lihat kembali seluruh catatan medis, diagnosis, dan rincian biaya pemeriksaan Anda.
      </p>
    </div>
  </div>

  <!-- Filter Card -->
  <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 dark:bg-neutral-800 dark:border-neutral-700">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
      <div>
        <label for="start_date" class="block text-sm font-medium mb-2 text-gray-700 dark:text-neutral-300">Dari Tanggal</label>
        <input type="date" id="start_date" onchange="refreshTable()"
          class="py-2.5 px-4 block w-full border border-gray-300 rounded-xl text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
      </div>

      <div>
        <label for="end_date" class="block text-sm font-medium mb-2 text-gray-700 dark:text-neutral-300">Sampai Tanggal</label>
        <input type="date" id="end_date" onchange="refreshTable()"
          class="py-2.5 px-4 block w-full border border-gray-300 rounded-xl text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
      </div>

      <div class="flex gap-2">
        <button type="button" onclick="resetFilters()"
          class="flex-1 py-2.5 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-xl border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800">
          Reset Filter
        </button>
      </div>
    </div>
  </div>

  <!-- Table Card -->
  <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden dark:bg-neutral-800 dark:border-neutral-700">
    <div class="p-6">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
          <thead class="bg-gray-50 dark:bg-neutral-700">
            <tr>
              <th class="px-6 py-4 text-start text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
              <th class="px-6 py-4 text-start text-xs font-semibold text-gray-500 uppercase tracking-wider">Dokter</th>
              <th class="px-6 py-4 text-start text-xs font-semibold text-gray-500 uppercase tracking-wider">Poli</th>
              <th class="px-6 py-4 text-start text-xs font-semibold text-gray-500 uppercase tracking-wider">Diagnosis</th>
              <th class="px-6 py-4 text-start text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Status</th>
              <th class="px-6 py-4 text-start text-xs font-semibold text-gray-500 uppercase tracking-wider text-end">Total Biaya</th>
              <th class="px-6 py-4 text-end text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
          </thead>
          <tbody id="history-table-body" class="divide-y divide-gray-200 dark:divide-neutral-700">
            @include('patient.history.table', ['riwayat' => $riwayat])
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
            Detail Hasil Pemeriksaan
          </h3>
          <p class="text-xs text-gray-500 dark:text-neutral-400" id="modal-date">Memuat...</p>
        </div>
        <button type="button" class="flex justify-center items-center size-8 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 dark:text-white dark:hover:bg-neutral-700" data-hs-overlay="#detail-modal">
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
        <button type="button" class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-xl border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800" data-hs-overlay="#detail-modal">
          Tutup
        </button>
      </div>
    </div>
  </div>
</div>
<!-- Detail Modal (Keep existing) -->
<!-- ... existing code ... -->

<!-- Payment Modal -->
<div id="payment-modal" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none">
  <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
    <div class="flex flex-col bg-white border border-gray-200 shadow-xl rounded-3xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700">
      <div class="flex justify-between items-center py-4 px-6 border-b dark:border-neutral-700 bg-blue-50/50 rounded-t-3xl dark:bg-neutral-900/20">
        <div>
          <h3 class="font-bold text-gray-800 dark:text-white">Pembayaran Pemeriksaan</h3>
          <p class="text-xs text-gray-500" id="payment-modal-date"></p>
        </div>
        <button type="button" class="flex justify-center items-center size-8 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 dark:text-white dark:hover:bg-neutral-700" data-hs-overlay="#payment-modal">
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
      </div>
      <form id="payment-form" onsubmit="submitPayment(event)">
        @csrf
        <input type="hidden" id="payment-id" name="id">
        <div class="p-6 space-y-6">
          <div class="p-4 bg-blue-50 rounded-2xl dark:bg-blue-900/20 border border-blue-100 dark:border-blue-900/30">
            <h4 class="text-[10px] font-bold text-blue-600 uppercase mb-1">Total yang harus dibayar</h4>
            <p class="text-2xl font-black text-blue-800 dark:text-blue-300" id="payment-modal-amount">Rp 0</p>
          </div>

          <div class="space-y-2">
            <label class="block text-sm font-bold text-gray-800 dark:text-white">Upload Bukti Pembayaran</label>
            <div class="mt-2">
              <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" required
                class="block w-full border border-gray-300 shadow-sm rounded-xl text-sm focus:z-10 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 file:bg-gray-50 file:border-0 file:me-4 file:py-3 file:px-4 dark:file:bg-neutral-700 dark:file:text-neutral-400">
              <p class="mt-2 text-xs text-gray-500">Format: JPG, PNG. Max 2MB.</p>
            </div>
          </div>
        </div>
        <div class="flex justify-end items-center gap-x-2 py-4 px-6 border-t dark:border-neutral-700">
          <button type="button" class="py-2.5 px-4 text-sm font-semibold rounded-xl border border-gray-200 bg-white text-gray-800 hover:bg-gray-50 dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800" data-hs-overlay="#payment-modal">Batal</button>
          <button type="submit" id="btn-submit-payment" class="py-2.5 px-4 text-sm font-semibold rounded-xl bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50">
            Kirim Pembayaran
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Image Preview Modal -->
<div id="image-preview-modal" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none">
  <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
    <div class="flex flex-col bg-white border shadow-sm rounded-3xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700">
      <div class="flex justify-between items-center py-3 px-4 border-b dark:border-neutral-700 bg-gray-50/50 rounded-t-3xl dark:bg-neutral-800">
        <h3 class="font-bold text-gray-800 dark:text-white">Preview Bukti Pembayaran</h3>
        <button type="button" class="size-8 flex justify-center items-center text-gray-800 hover:bg-gray-100 rounded-full dark:text-white dark:hover:bg-neutral-700" data-hs-overlay="#image-preview-modal">
          <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
      </div>
      <div class="p-4 text-center">
        <img id="preview-image" src="" alt="Proof" class="w-full rounded-2xl shadow-sm inline-block">
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  function showImage(url) {
    document.getElementById('preview-image').src = url;
  }
  async function refreshTable() {
    const start = document.getElementById('start_date').value;
    const end = document.getElementById('end_date').value;
    const tbody = document.getElementById('history-table-body');
    
    tbody.innerHTML = '<tr><td colspan="7" class="px-6 py-10 text-center"><div class="animate-spin inline-block size-6 border-[3px] border-current border-t-transparent text-blue-600 rounded-full"></div></td></tr>';

    try {
      const response = await fetch(`{{ route('patient.history') }}?start_date=${start}&end_date=${end}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      });
      const data = await response.json();
      if (data.success) {
        tbody.innerHTML = data.html;
      }
    } catch (error) {
      console.error('Error:', error);
      tbody.innerHTML = '<tr><td colspan="7" class="px-6 py-10 text-center text-red-500">Gagal memuat data.</td></tr>';
    }
  }

  function resetFilters() {
    document.getElementById('start_date').value = '';
    document.getElementById('end_date').value = '';
    refreshTable();
  }

  async function openPaymentModal(id, amount, date) {
    document.getElementById('payment-id').value = id;
    document.getElementById('payment-modal-amount').textContent = amount;
    document.getElementById('payment-modal-date').textContent = date;
    HSOverlay.open('#payment-modal');
  }

  async function submitPayment(e) {
    e.preventDefault();
    const id = document.getElementById('payment-id').value;
    const formData = new FormData(e.target);
    const btn = document.getElementById('btn-submit-payment');
    
    btn.disabled = true;
    btn.innerHTML = '<div class="animate-spin inline-block size-4 border-[2px] border-current border-t-transparent text-white rounded-full"></div> Mengirim...';

    try {
      const response = await fetch(`{{ url('/patient/history') }}/${id}/pay`, {
        method: 'POST',
        body: formData,
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
      });
      const result = await response.json();
      if (result.success) {
        HSOverlay.close('#payment-modal');
        Swal.fire('Berhasil!', result.message, 'success');
        refreshTable();
      } else {
        Swal.fire('Gagal!', 'Terjadi kesalahan.', 'error');
      }
    } catch (error) {
      console.error(error);
      Swal.fire('Gagal!', 'Koneksi bermasalah.', 'error');
    } finally {
      btn.disabled = false;
      btn.innerText = 'Kirim Pembayaran';
    }
  }

  async function showDetail(id) {
    const modalContent = document.getElementById('modal-content');
    const modalDate = document.getElementById('modal-date');
    
    HSOverlay.open('#detail-modal');
    
    modalDate.textContent = 'Memuat...';
    modalContent.innerHTML = '<div class="text-center py-12"><div class="animate-spin inline-block size-8 border-[3px] border-current border-t-transparent text-blue-600 rounded-full"></div></div>';

    try {
      const response = await fetch(`{{ url('/patient/history') }}/${id}`);
      const result = await response.json();
      
      if (result.success) {
        const d = result.data;
        const formattedDate = new Date(d.tgl_periksa).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'});
        modalDate.textContent = `${formattedDate} | Oleh: ${d.jadwal_jaga.dokter.nama}`;
        
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
                  <p class="text-[10px] text-gray-500">${item.jumlah} x Rp ${new Intl.NumberFormat('id-ID').format(item.harga_saat_ini)}</p>
                </div>
              </div>
              <span class="text-sm font-bold text-gray-800 dark:text-neutral-200">Rp ${new Intl.NumberFormat('id-ID').format(item.jumlah * item.harga_saat_ini)}</span>
            </div>
          `).join('');
        } else {
          obatListHtml = '<p class="text-sm text-gray-400 italic text-center py-4">Tidak ada obat.</p>';
        }

        modalContent.innerHTML = `
          <div class="space-y-6">
            <div class="grid grid-cols-2 gap-4">
              <div class="p-4 bg-gray-50 rounded-2xl dark:bg-neutral-900/50">
                <h4 class="text-[10px] font-bold text-gray-400 uppercase mb-1">Poliklinik</h4>
                <p class="text-sm font-semibold text-gray-800 dark:text-neutral-200">${d.jadwal_jaga.dokter.poli.nama_poli}</p>
              </div>
              <div class="p-4 bg-gray-50 rounded-2xl dark:bg-neutral-900/50">
                <h4 class="text-[10px] font-bold text-gray-400 uppercase mb-1">Status</h4>
                <p class="text-sm font-semibold text-blue-600 dark:text-blue-400 capitalize">${d.status_periksa.replace('_', ' ')}</p>
              </div>
            </div>

            <div class="space-y-2">
              <h4 class="text-xs font-bold text-gray-800 dark:text-white flex items-center gap-2">Keluhan</h4>
              <div class="p-4 bg-orange-50 border border-orange-100 rounded-2xl dark:bg-orange-900/10 dark:border-orange-900/20 text-sm text-orange-800 dark:text-orange-300">
                ${d.keluhan || '-'}
              </div>
            </div>

            <div class="space-y-2">
              <h4 class="text-xs font-bold text-gray-800 dark:text-white flex items-center gap-2">Catatan Dokter & Diagnosis</h4>
              <div class="p-4 bg-green-50 border border-green-100 rounded-2xl dark:bg-green-900/10 dark:border-green-900/20">
                <p class="text-sm font-bold text-green-900 dark:text-green-300 mb-1">${d.nama_penyakit || 'Umum'}</p>
                <p class="text-sm text-green-800 dark:text-green-400 italic">"${d.catatan || '-'}"</p>
              </div>
            </div>

            <div class="space-y-3">
              <h4 class="text-xs font-bold text-gray-800 dark:text-white flex items-center gap-2">Rincian Obat</h4>
              <div class="space-y-2">${obatListHtml}</div>
            </div>

            <div class="pt-4 border-t dark:border-neutral-700">
              <div class="flex justify-between items-center px-2">
                <span class="text-base font-bold text-gray-800 dark:text-white">Total Pembayaran</span>
                <span class="text-lg font-black text-blue-600 dark:text-blue-400">Rp ${new Intl.NumberFormat('id-ID').format(d.total_biaya)}</span>
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
