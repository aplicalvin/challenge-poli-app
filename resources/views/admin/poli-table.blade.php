<div class="overflow-x-auto">
  <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
    <thead class="bg-gray-50 dark:bg-neutral-800">
      <tr>
        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">No</th>
        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Nama Poli</th>
        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Keterangan</th>
        <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Aksi</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
      @forelse($polis as $index => $poli)
        <tr>
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">{{ $polis->firstItem() + $index }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">{{ $poli->nama_poli }}</td>
          <td class="px-6 py-4 text-sm text-gray-800 dark:text-neutral-200">{{ $poli->keterangan ?? '-' }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
            <button type="button" 
                    class="py-1.5 px-2 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400"
                    onclick="CrudHandler.openModal('hs-edit-poli-modal-{{ $poli->id }}')">
              Edit
            </button>
            <button type="button" 
                    class="py-1.5 px-2 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent text-red-600 hover:text-red-800 focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none dark:text-red-500 dark:hover:text-red-400"
                    onclick="CrudHandler.confirmDelete('{{ route('poli.destroy', $poli->id) }}', 'table-container')">
              Delete
            </button>

            <!-- Edit Modal -->
            <x-popupmodal id="hs-edit-poli-modal-{{ $poli->id }}" title="Edit Poli">
              <form id="edit-poli-form-{{ $poli->id }}" action="{{ route('poli.update', $poli->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                  <div>
                    <label for="nama_poli_{{ $poli->id }}" class="block text-sm font-medium mb-2 dark:text-white">Nama Poli</label>
                    <input type="text" id="nama_poli_{{ $poli->id }}" name="nama_poli" value="{{ $poli->nama_poli }}" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" required>
                  </div>
                  <div>
                    <label for="keterangan_{{ $poli->id }}" class="block text-sm font-medium mb-2 dark:text-white">Keterangan</label>
                    <textarea id="keterangan_{{ $poli->id }}" name="keterangan" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" rows="3">{{ $poli->keterangan }}</textarea>
                  </div>
                </div>
              </form>
              @slot('footer')
                <button type="button" 
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                        onclick="CrudHandler.submitForm('edit-poli-form-{{ $poli->id }}', 'hs-edit-poli-modal-{{ $poli->id }}', 'table-container')">
                  Update
                </button>
              @endslot
            </x-popupmodal>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500 dark:text-neutral-500">Data tidak ditemukan.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
<div class="mt-4 px-6">
  {{ $polis->links() }}
</div>
