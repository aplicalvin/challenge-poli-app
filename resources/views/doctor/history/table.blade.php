@forelse($riwayat as $item)
  <tr>
    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">
      {{ $item->pasien->nama }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
      {{ \Carbon\Carbon::parse($item->tgl_periksa)->format('d M Y') }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
      <span class="inline-flex items-center justify-center size-8 rounded-full bg-blue-100 text-blue-800 font-bold">
        {{ $item->no_antrian }}
      </span>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
      {{ $item->nama_penyakit ?? '-' }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm">
      @php
        $statusClasses = [
          'antri' => 'bg-blue-100 text-blue-800',
          'sedang_periksa' => 'bg-yellow-100 text-yellow-800',
          'menunggu_pembayaran' => 'bg-orange-100 text-orange-800',
          'selesai' => 'bg-green-100 text-green-800',
          'batal' => 'bg-red-100 text-red-800',
        ];
        $class = $statusClasses[$item->status_periksa] ?? 'bg-gray-100 text-gray-800';
      @endphp
      <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium {{ $class }}">
        {{ ucwords(str_replace('_', ' ', $item->status_periksa)) }}
      </span>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
      <button type="button" 
        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
        onclick="showDetail({{ $item->id }})">
        Detail
      </button>
    </td>
  </tr>
@empty
  <tr>
    <td colspan="6" class="px-6 py-10 text-center text-sm text-gray-500 italic">
      Tidak ada riwayat pemeriksaan ditemukan.
    </td>
  </tr>
@endforelse
