<div class="overflow-x-auto">
  <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
    <thead class="bg-gray-50 dark:bg-neutral-800">
      <tr>
        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">No</th>
        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Nama Shift</th>
        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Hari</th>
        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Jam Kerja</th>
        <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Aksi</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
      @forelse($shifts as $index => $s)
        <tr>
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">{{ $shifts->firstItem() + $index }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200 font-bold">{{ $s->nama }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">{{ $s->hari }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
            {{ \Carbon\Carbon::parse($s->jam_masuk)->format('H:i') }} - {{ \Carbon\Carbon::parse($s->jam_keluar)->format('H:i') }}
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
            <button type="button" 
                    class="py-1.5 px-2 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400"
                    onclick="CrudHandler.openEditShiftModal('{{ $s->id }}', '{{ $s->nama }}', '{{ $s->jam_masuk }}', '{{ $s->jam_keluar }}', '{{ $s->hari }}')">
              Edit
            </button>
            <button type="button" 
                    class="py-1.5 px-2 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent text-red-600 hover:text-red-800 focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none dark:text-red-500 dark:hover:text-red-400"
                    onclick="CrudHandler.confirmDelete('{{ route('shift.destroy', $s->id) }}', 'table-container')">
              Delete
            </button>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500 dark:text-neutral-500">Data tidak ditemukan.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
<div class="mt-4 px-6">
  {{ $shifts->links() }}
</div>
