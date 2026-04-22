@forelse($riwayat as $item)
  <tr class="hover:bg-gray-50 dark:hover:bg-neutral-900/30 transition-colors">
    <td class="px-6 py-4 whitespace-nowrap">
      <div class="flex items-center gap-3">
        <div class="size-8 rounded-full bg-gradient-to-tr from-blue-500 to-indigo-600 flex items-center justify-center text-white text-xs font-bold shadow-sm">
          {{ strtoupper(substr($item->pasien->nama, 0, 1)) }}
        </div>
        <span class="text-sm font-semibold text-gray-800 dark:text-neutral-200">{{ $item->pasien->nama }}</span>
      </div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
      <div class="text-sm text-gray-800 dark:text-neutral-200 font-medium">
        {{ \Carbon\Carbon::parse($item->tgl_periksa)->format('d M Y') }}
      </div>
      <div class="text-[10px] text-gray-400 uppercase tracking-tighter">
        {{ \Carbon\Carbon::parse($item->tgl_periksa)->format('H:i') }} WIB
      </div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-center">
      <span class="inline-flex items-center justify-center size-9 rounded-xl bg-blue-50 text-blue-700 font-black border border-blue-100 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800">
        {{ $item->no_antrian }}
      </span>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
      <div class="max-w-[150px] truncate text-sm text-gray-600 dark:text-neutral-400 italic">
        {{ $item->nama_penyakit ?? 'Belum ada diagnosis' }}
      </div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
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
      <span class="inline-flex items-center gap-x-1.5 py-1 px-3 rounded-lg text-xs font-bold border {{ $class }}">
        <span class="size-1.5 rounded-full bg-current"></span>
        {{ ucwords(str_replace('_', ' ', $item->status_periksa)) }}
      </span>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
      <button type="button" 
        class="group inline-flex items-center gap-x-2 py-2 px-4 rounded-xl bg-gray-50 border border-gray-200 text-gray-800 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all duration-200 dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-blue-500"
        onclick="showDetail({{ $item->id }})">
        <svg class="size-4 group-hover:scale-110 transition-transform" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
        Detail
      </button>
    </td>
  </tr>
@empty
  <!-- DataTables will handle the empty state, but we keep this for initial load if no data -->
@endforelse
