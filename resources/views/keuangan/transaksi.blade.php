@extends('layouts.admin')

@section('title', 'Manajemen Transaksi Keuangan')

@section('content')
<div class="p-4 sm:p-6 space-y-6">
  <!-- Header -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-gray-800 dark:text-neutral-200">Manajemen Transaksi</h1>
      <p class="text-sm text-gray-500 dark:text-neutral-400">
        Verifikasi bukti pembayaran pasien dan teruskan antrian ke bagian obat.
      </p>
    </div>
    <div>
      <button type="button" onclick="exportToExcel('table-transaksi', 'Data_Transaksi')"
              class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-xl border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800">
        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
        Export Excel
      </button>
    </div>
  </div>

  <!-- Stats Grid (Optional Premium Feel) -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="p-5 bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700">
      <div class="flex items-center gap-4">
        <div class="size-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 dark:bg-blue-900/30">
          <svg class="size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M19 8v6"/><path d="M16 11h6"/></svg>
        </div>
        <div>
          <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Menunggu Pembayaran</p>
          <p class="text-xl font-black text-gray-800 dark:text-white">{{ $transaksi->count() }} Pasien</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Table Card -->
  <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden dark:bg-neutral-800 dark:border-neutral-700">
    <div class="overflow-x-auto">
      <table id="table-transaksi" class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
        <thead class="bg-gray-50 dark:bg-neutral-700">
          <tr>
            <th class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider">Pasien</th>
            <th class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Tanggal Periksa</th>
            <th class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider text-end">Total Tagihan</th>
            <th class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Bukti Bayar</th>
            <th class="px-6 py-4 text-end text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
          @forelse($transaksi as $t)
          <tr class="hover:bg-gray-50 dark:hover:bg-neutral-900/30 transition-colors">
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="flex items-center gap-3">
                <div class="size-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-xs font-bold">
                  {{ strtoupper(substr($t->pasien->nama, 0, 1)) }}
                </div>
                <span class="text-sm font-semibold text-gray-800 dark:text-neutral-200">{{ $t->pasien->nama }}</span>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600 dark:text-neutral-400">
              {{ \Carbon\Carbon::parse($t->tgl_periksa)->format('d/m/Y') }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-bold text-gray-800 dark:text-neutral-200">
              Rp {{ number_format($t->total_biaya, 0, ',', '.') }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-center">
              @if($t->pembayaran && $t->pembayaran->bukti_pembayaran)
                <button type="button" class="text-blue-600 hover:underline text-sm font-medium" 
                  data-hs-overlay="#image-modal" onclick="showImage('{{ asset('storage/' . $t->pembayaran->bukti_pembayaran) }}')">
                  Lihat Bukti
                </button>
              @else
                <span class="text-xs text-gray-400 italic">Belum diunggah</span>
              @endif
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-end">
              <div class="flex justify-end gap-2">
                <button type="button" onclick="confirmPayment({{ $t->id }})"
                  class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-xl bg-green-600 text-white hover:bg-green-700 shadow-sm transition-all disabled:opacity-50">
                  Confirm
                </button>
                <button type="button" onclick="rejectPayment({{ $t->id }})"
                  class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-xl bg-red-500 text-white hover:bg-red-600 shadow-sm transition-all disabled:opacity-50">
                  Reject
                </button>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="px-6 py-12 text-center text-gray-500 italic">Tidak ada antrian pembayaran.</td>
          </tr>
          @endforelse
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
        <img id="payment-image-preview" src="" alt="Proof" class="w-full rounded-2xl shadow-sm">
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
  function showImage(url) {
    document.getElementById('payment-image-preview').src = url;
  }

  async function confirmPayment(id) {
    const result = await Swal.fire({
      title: 'Konfirmasi Pembayaran?',
      text: "Pastikan bukti pembayaran sudah sesuai.",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#10b981',
      confirmButtonText: 'Ya, Konfirmasi!',
      cancelButtonText: 'Batal'
    });

    if (result.isConfirmed) {
      handlePaymentAction(id, 'confirm');
    }
  }

  async function rejectPayment(id) {
    const result = await Swal.fire({
      title: 'Tolak Pembayaran?',
      text: "Pembayaran yang ditolak akan meminta pasien untuk upload ulang.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#ef4444',
      confirmButtonText: 'Ya, Tolak!',
      cancelButtonText: 'Batal'
    });

    if (result.isConfirmed) {
      handlePaymentAction(id, 'reject');
    }
  }

  async function handlePaymentAction(id, action) {
    try {
      const response = await fetch(`{{ url('/keuangan/transaksi') }}/${id}/${action}`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Content-Type': 'application/json'
        }
      });
      const data = await response.json();
      if (data.success) {
        Swal.fire('Berhasil!', data.message, 'success').then(() => location.reload());
      } else {
        Swal.fire('Gagal!', data.message || 'Terjadi kesalahan.', 'error');
      }
    } catch (e) {
      Swal.fire('Error!', 'Gagal memproses transaksi.', 'error');
    }
  }
</script>
@endpush
