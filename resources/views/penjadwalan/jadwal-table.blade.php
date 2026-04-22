<div class="overflow-x-auto">
  <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
    <thead class="bg-gray-50 dark:bg-neutral-800">
      <tr>
        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">
          No</th>
        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">
          Shift</th>
        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">
          Dokter</th>
        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">
          Ruang & Poli</th>
        <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">
          Aksi</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
      @forelse($jadwals as $index => $j)
        <tr>
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">
            {{ $jadwals->firstItem() + $index }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
            <span class="font-bold text-blue-600 dark:text-blue-500">{{ $j->shift->nama ?? '-' }}</span>
            <div class="text-xs text-gray-500">{{ $j->shift->hari ?? '' }} ({{ $j->shift->jam_masuk ?? '' }} -
              {{ $j->shift->jam_keluar ?? '' }})</div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
            {{ $j->dokter->nama ?? '-' }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
            <span
              class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-teal-100 text-teal-800 dark:bg-teal-800/30 dark:text-teal-500">
              {{ $j->ruang->nama ?? '-' }} ({{ $j->ruang->poli->nama_poli ?? '-' }})
            </span>
          </td>
          @if(auth()->user()->role === 'admin')
            <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
              <button type="button"
                class="py-1.5 px-2 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400"
                onclick="CrudHandler.openEditJadwalModal('{{ $j->id }}', '{{ $j->id_shift }}', '{{ $j->id_dokter }}', '{{ $j->id_ruang }}')">
                Edit
              </button>
              <button type="button"
                class="py-1.5 px-2 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent text-red-600 hover:text-red-800 focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none dark:text-red-500 dark:hover:text-red-400"
                onclick="CrudHandler.confirmDelete('{{ route('penjadwalan.jadwal.destroy', $j->id) }}', 'table-container')">
                Delete
              </button>
            </td>
          @else
            <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
              <span class="text-gray-400 italic">Read-only</span>
            </td>
          @endif
        </tr>
      @empty
        <tr>
          <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500 dark:text-neutral-500">
            Jadwal tidak ditemukan.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
<div class="mt-4 px-6">
  {{ $jadwals->links() }}
</div>