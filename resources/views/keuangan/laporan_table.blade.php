@forelse($laporan as $item)
<tr class="hover:bg-gray-50 dark:hover:bg-neutral-900/30 transition-colors">
  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-neutral-400">
    {{ \Carbon\Carbon::parse($item->tgl_bayar)->format('d/m/Y H:i') }}
  </td>
  <td class="px-6 py-4 whitespace-nowrap">
    <div class="text-sm font-semibold text-gray-800 dark:text-neutral-200">{{ $item->periksa->pasien->nama }}</div>
    <div class="text-[10px] text-gray-400 uppercase tracking-widest">{{ $item->periksa->pasien->no_rm }}</div>
  </td>
  <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-bold text-gray-800 dark:text-neutral-200">
    Rp {{ number_format($item->total_bayar, 0, ',', '.') }}
  </td>
  <td class="px-6 py-4 whitespace-nowrap text-end text-sm text-gray-500 dark:text-neutral-400">
    {{ $item->verifier->username ?? '-' }}
  </td>
</tr>
@empty
<tr>
  <td colspan="4" class="px-6 py-12 text-center text-gray-500 italic">Tidak ada laporan ditemukan.</td>
</tr>
@endforelse
