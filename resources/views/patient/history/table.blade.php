@forelse($riwayat as $item)
  <tr class="hover:bg-gray-50 dark:hover:bg-neutral-900/30 transition-colors">
    <td class="px-6 py-4 whitespace-nowrap">
      <div class="text-sm font-semibold text-gray-800 dark:text-neutral-200">
        {{ \Carbon\Carbon::parse($item->tgl_periksa)->format('d M Y') }}
      </div>
      <div class="text-[10px] text-gray-400 uppercase tracking-tighter">
        {{ \Carbon\Carbon::parse($item->tgl_periksa)->format('H:i') }} WIB
      </div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200 font-medium">
      {{ $item->jadwalJaga->dokter->nama }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-neutral-400">
      {{ $item->jadwalJaga->dokter->poli->nama_poli }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
      <div class="max-w-[150px] truncate text-sm text-gray-500 dark:text-neutral-500 italic">
        {{ $item->nama_penyakit ?? 'Umum' }}
      </div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-center">
      @php
        $statusClasses = [
          'antri' => 'bg-blue-100 text-blue-800 border-blue-200 dark:bg-blue-900/40 dark:text-blue-300 dark:border-blue-800',
          'sedang_periksa' => 'bg-yellow-100 text-yellow-800 border-yellow-200 dark:bg-yellow-900/40 dark:text-yellow-300 dark:border-yellow-800',
          'menunggu_pembayaran' => 'bg-orange-100 text-orange-800 border-orange-200 dark:bg-orange-900/40 dark:text-orange-300 dark:border-orange-800',
          'selesai' => 'bg-green-100 text-green-800 border-green-200 dark:bg-green-900/40 dark:text-green-300 dark:border-green-800',
          'batal' => 'bg-red-100 text-red-800 border-red-200 dark:bg-red-900/40 dark:text-red-300 dark:border-red-800',
        ];
        $class = $statusClasses[$item->status_periksa] ?? 'bg-gray-100 text-gray-800 border-gray-200';
      @endphp
      <span class="inline-flex items-center gap-x-1.5 py-1 px-3 rounded-lg text-[10px] font-bold border {{ $class }} uppercase tracking-wider">
        {{ str_replace('_', ' ', $item->status_periksa) }}
      </span>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-end">
      <span class="text-sm font-bold text-gray-800 dark:text-neutral-200">
        Rp {{ number_format($item->total_biaya, 0, ',', '.') }}
      </span>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
      <div class="flex justify-end gap-2">
        @if($item->status_periksa === 'menunggu_pembayaran')
          @if(!$item->pembayaran || $item->pembayaran->status_pembayaran === 'rejected')
            <button type="button" 
              class="inline-flex items-center gap-x-2 py-2 px-4 rounded-xl bg-blue-600 border border-transparent text-white hover:bg-blue-700 transition-all duration-200 shadow-sm"
              onclick="openPaymentModal({{ $item->id }}, 'Rp {{ number_format($item->total_biaya, 0, ',', '.') }}', '{{ \Carbon\Carbon::parse($item->tgl_periksa)->format('d M Y') }}')">
              <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
              {{ $item->pembayaran && $item->pembayaran->status_pembayaran === 'rejected' ? 'Upload Ulang' : 'Bayar' }}
            </button>
          @elseif($item->pembayaran->status_pembayaran === 'pending')
            <div class="flex items-center gap-2">
              <button type="button" 
                class="inline-flex items-center gap-x-2 py-2 px-3 rounded-xl bg-gray-50 border border-gray-200 text-gray-600 hover:bg-gray-100 transition-all shadow-sm"
                onclick="showImage('{{ asset('storage/' . $item->pembayaran->bukti_pembayaran) }}')" data-hs-overlay="#image-preview-modal">
                <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                Preview
              </button>
              <span class="inline-flex items-center gap-x-1.5 py-2 px-3 rounded-xl text-[10px] font-bold bg-yellow-50 text-yellow-700 border border-yellow-200 uppercase tracking-tight">
                Verifikasi
              </span>
            </div>
          @endif
        @endif

        <button type="button" 
          class="inline-flex items-center gap-x-2 py-2 px-4 rounded-xl bg-gray-50 border border-gray-200 text-gray-800 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all duration-200 dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-blue-500 shadow-sm"
          onclick="showDetail({{ $item->id }})">
          <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
          Detail
        </button>
      </div>
    </td>
  </tr>
@empty
  <tr>
    <td colspan="7" class="px-6 py-12 text-center">
      <div class="flex flex-col items-center gap-2">
        <div class="size-12 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 dark:bg-neutral-900">
          <svg class="size-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><line x1="10" y1="9" x2="8" y2="9"/></svg>
        </div>
        <p class="text-sm text-gray-500 dark:text-neutral-500 italic">Belum ada riwayat pemeriksaan ditemukan.</p>
      </div>
    </td>
  </tr>
@endforelse
