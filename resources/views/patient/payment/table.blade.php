@forelse($pembayaran as $p)
<tr class="hover:bg-gray-50 dark:hover:bg-neutral-900/30 transition-colors">
  <td class="px-6 py-4 whitespace-nowrap">
    <div class="text-sm font-semibold text-gray-800 dark:text-neutral-200">
      {{ \Carbon\Carbon::parse($p->created_at)->format('d M Y') }}
    </div>
    <div class="text-[10px] text-gray-400 uppercase">
      {{ \Carbon\Carbon::parse($p->created_at)->format('H:i') }} WIB
    </div>
  </td>
  <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-bold text-gray-800 dark:text-neutral-200">
    Rp {{ number_format($p->total_bayar, 0, ',', '.') }}
  </td>
  <td class="px-6 py-4 whitespace-nowrap text-center">
    @php
      $statusClasses = [
        'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
        'lunas' => 'bg-green-100 text-green-800 border-green-200',
      ];
      $class = $statusClasses[$p->status_pembayaran] ?? 'bg-gray-100';
    @endphp
    <span class="inline-flex items-center gap-x-1.5 py-1 px-3 rounded-full text-[10px] font-bold border {{ $class }} uppercase tracking-wider">
      {{ $p->status_pembayaran }}
    </span>
  </td>
  <td class="px-6 py-4 whitespace-nowrap text-end">
    @if($p->bukti_pembayaran)
      <button type="button" onclick="showImage('{{ asset('storage/' . $p->bukti_pembayaran) }}')" data-hs-overlay="#image-modal"
        class="size-8 inline-flex items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50 shadow-sm dark:bg-neutral-900 dark:border-neutral-700 dark:text-white">
        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
      </button>
    @else
      <span class="text-xs text-gray-400 italic">No File</span>
    @endif
  </td>
</tr>
@empty
<tr>
  <td colspan="4" class="px-6 py-12 text-center text-gray-500 italic">Belum ada transaksi.</td>
</tr>
@endforelse
