@extends('layouts.admin')

@section('title', 'Layanan Farmasi')

@section('content')
<div class="p-4 sm:p-6 space-y-6">
  <!-- Header -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-gray-800 dark:text-neutral-200">Antrian Farmasi Hari Ini</h1>
      <p class="text-sm text-gray-500 dark:text-neutral-400">
        Siapkan obat untuk pasien yang telah menyelesaikan pembayaran.
      </p>
    </div>
    <div class="inline-flex items-center gap-x-2 py-2 px-3 bg-blue-50 text-blue-600 rounded-xl text-sm font-medium dark:bg-blue-900/30 dark:text-blue-400">
      <span class="relative flex h-2 w-2">
        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
        <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
      </span>
      {{ count($antrian) }} Pasien Menunggu
    </div>
  </div>

  <!-- Table Card -->
  <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden dark:bg-neutral-800 dark:border-neutral-700">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
        <thead class="bg-gray-50 dark:bg-neutral-700">
          <tr>
            <th class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider">No</th>
            <th class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Pasien</th>
            <th class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Waktu Periksa</th>
            <th class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Status</th>
            <th class="px-6 py-4 text-end text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
          @forelse($antrian as $index => $a)
          <tr class="hover:bg-gray-50 dark:hover:bg-neutral-900/30 transition-colors">
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm font-semibold text-gray-800 dark:text-neutral-200">{{ $a->pasien->nama }}</div>
              <div class="text-[10px] text-gray-400 uppercase">{{ $a->pasien->no_rm }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600 dark:text-neutral-400">
              {{ \Carbon\Carbon::parse($a->created_at)->format('H:i') }} WIB
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-center">
              <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-400">
                <span class="size-1.5 rounded-full bg-blue-600 animate-pulse"></span>
                Siapkan Obat
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-end">
              <button type="button" onclick="showPharmacyDetail({{ $a->id }})"
                class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-xl bg-white border border-gray-200 text-gray-800 hover:bg-blue-600 hover:text-white hover:border-blue-600 shadow-sm transition-all dark:bg-neutral-900 dark:border-neutral-700 dark:text-white">
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                Detail
              </button>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="px-6 py-12 text-center text-gray-500 italic">Antrian farmasi kosong.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Pharmacy Detail Modal -->
<div id="pharmacy-modal" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none">
  <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
    <div class="flex flex-col bg-white border border-gray-200 shadow-xl rounded-3xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700">
      <div class="flex justify-between items-center py-4 px-6 border-b dark:border-neutral-700 bg-gray-50/50 rounded-t-3xl dark:bg-neutral-800">
        <div>
          <h3 class="font-bold text-gray-800 dark:text-white">Persiapan Obat</h3>
          <p class="text-xs text-gray-500" id="pharmacy-modal-subtitle">Memuat...</p>
        </div>
        <button type="button" class="flex justify-center items-center size-8 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 dark:text-white dark:hover:bg-neutral-700" data-hs-overlay="#pharmacy-modal">
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
      </div>
      <div class="p-6 space-y-6">
        <div class="space-y-3" id="medicines-list">
          <!-- Medicines will be loaded here -->
        </div>

        <div class="p-4 bg-yellow-50 border border-yellow-100 rounded-2xl dark:bg-yellow-900/10 dark:border-yellow-900/20">
          <div class="flex gap-3">
            <svg class="shrink-0 size-4 text-yellow-600 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
            <p class="text-xs text-yellow-800 dark:text-yellow-400 font-medium">
              Pastikan jumlah obat yang disiapkan sudah sesuai dengan resep dokter di atas. Stok akan berkurang otomatis setelah diklik "Selesai".
            </p>
          </div>
        </div>
      </div>
      <div class="flex justify-end items-center gap-x-2 py-4 px-6 border-t dark:border-neutral-700">
        <button type="button" class="py-2.5 px-4 text-sm font-semibold rounded-xl border border-gray-200 bg-white text-gray-800 hover:bg-gray-50 dark:bg-neutral-900 dark:border-neutral-700 dark:text-white" data-hs-overlay="#pharmacy-modal">Batal</button>
        <button type="button" id="btn-complete-pharmacy" onclick="completePharmacyAction()" class="py-2.5 px-4 text-sm font-semibold rounded-xl bg-blue-600 text-white hover:bg-blue-700 shadow-sm transition-all disabled:opacity-50">
          Selesai & Serahkan Obat
        </button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
  let currentPeriksaId = null;

  async function showPharmacyDetail(id) {
    currentPeriksaId = id;
    const list = document.getElementById('medicines-list');
    const subtitle = document.getElementById('pharmacy-modal-subtitle');
    
    HSOverlay.open('#pharmacy-modal');
    list.innerHTML = '<div class="text-center py-8"><div class="animate-spin inline-block size-6 border-[3px] border-current border-t-transparent text-blue-600 rounded-full"></div></div>';

    try {
      const response = await fetch(`{{ url('/obat/layanan') }}/${id}`);
      const result = await response.json();
      
      if (result.success) {
        const d = result.data;
        subtitle.textContent = `Pasien: ${d.pasien.nama} | ${d.pasien.no_rm}`;
        
        if (d.detail_periksa_obat.length > 0) {
          list.innerHTML = d.detail_periksa_obat.map(item => `
            <div class="flex items-center justify-between p-4 bg-gray-50 border border-gray-100 rounded-2xl dark:bg-neutral-900 dark:border-neutral-700">
              <div class="flex items-center gap-4">
                <div class="size-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-blue-600 dark:bg-neutral-800 dark:border-neutral-700">
                  <svg class="size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m10.5 20.5 10-10a4.95 4.95 0 1 0-7-7l-10 10a4.95 4.95 0 1 0 7 7Z"/><path d="m8.5 8.5 7 7"/></svg>
                </div>
                <div>
                  <p class="text-sm font-bold text-gray-800 dark:text-neutral-200">${item.obat.nama_obat}</p>
                  <p class="text-xs text-gray-500 italic">Stok Saat Ini: ${item.obat.stok}</p>
                </div>
              </div>
              <div class="text-right">
                <p class="text-lg font-black text-blue-600 dark:text-blue-400">x ${item.jumlah}</p>
              </div>
            </div>
          `).join('');
        } else {
          list.innerHTML = '<p class="text-center text-gray-500 italic py-8">Tidak ada obat yang diresepkan.</p>';
        }
      }
    } catch (e) {
      list.innerHTML = '<p class="text-center text-red-500 py-8">Gagal memuat data.</p>';
    }
  }

  async function completePharmacyAction() {
    const btn = document.getElementById('btn-complete-pharmacy');
    const result = await Swal.fire({
      title: 'Selesaikan Layanan?',
      text: "Pastikan semua obat sudah disiapkan sesuai jumlah.",
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya, Selesai!',
      cancelButtonText: 'Batal'
    });

    if (result.isConfirmed) {
      btn.disabled = true;
      btn.innerHTML = '<div class="animate-spin inline-block size-4 border-[2px] border-current border-t-transparent text-white rounded-full"></div> Memproses...';

      try {
        const response = await fetch(`{{ url('/obat/layanan') }}/${currentPeriksaId}/complete`, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
          }
        });
        const data = await response.json();
        
        if (data.success) {
          HSOverlay.close('#pharmacy-modal');
          Swal.fire('Berhasil!', data.message, 'success').then(() => location.reload());
        } else {
          // Toast or Alert for stock error
          Swal.fire({
            title: 'Gagal!',
            text: data.message,
            icon: 'error',
            confirmButtonColor: '#3b82f6'
          });
        }
      } catch (e) {
        Swal.fire('Error!', 'Gagal memproses antrian.', 'error');
      } finally {
        btn.disabled = false;
        btn.innerText = 'Selesai & Serahkan Obat';
      }
    }
  }
</script>
@endpush
