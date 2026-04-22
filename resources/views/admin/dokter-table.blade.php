<div class="overflow-x-auto">
  <table id="table-dokter" class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
    <thead class="bg-gray-50 dark:bg-neutral-800">
      <tr>
        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">No</th>
        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Nama Dokter</th>
        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Spesialis (Poli)</th>
        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Username</th>
        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">No HP</th>
        <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Aksi</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
      @forelse($dokters as $index => $d)
        @php
            $u = $d->user;
        @endphp
        <tr>
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">{{ $dokters->firstItem() + $index }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">{{ $d->nama }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
            <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800/30 dark:text-blue-500">
                {{ $d->poli->nama_poli ?? '-' }}
            </span>
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">{{ $u->username ?? '-' }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">{{ $d->no_hp ?? '-' }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
            <button type="button" 
                    class="py-1.5 px-2 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400"
                    onclick="CrudHandler.openModal('hs-edit-dokter-modal-{{ $d->id }}')">
              Edit
            </button>
            <button type="button" 
                    class="py-1.5 px-2 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent text-red-600 hover:text-red-800 focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none dark:text-red-500 dark:hover:text-red-400"
                    onclick="CrudHandler.confirmDelete('{{ route('dokter.destroy', $d->id) }}', 'table-container')">
              Delete
            </button>

            <!-- Edit Modal -->
            <x-popupmodal id="hs-edit-dokter-modal-{{ $d->id }}" title="Edit Dokter">
              <form id="edit-dokter-form-{{ $d->id }}" action="{{ route('dokter.update', $d->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4 text-start">
                  <div>
                    <label class="block text-sm font-medium mb-2 dark:text-white">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ $d->nama }}" class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" required>
                  </div>
                  <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2 dark:text-white">Username</label>
                        <input type="text" name="username" value="{{ $u->username ?? '' }}" class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2 dark:text-white">Poliklinik</label>
                        <select name="id_poli" class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                            @foreach($polis as $p)
                                <option value="{{ $p->id }}" {{ $d->id_poli == $p->id ? 'selected' : '' }}>{{ $p->nama_poli }}</option>
                            @endforeach
                        </select>
                    </div>
                  </div>
                  <div>
                    <label class="block text-sm font-medium mb-2 dark:text-white">Password (Biarkan kosong jika tetap)</label>
                    <input type="password" name="password" class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                  </div>
                  <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2 dark:text-white">No HP</label>
                        <input type="text" name="no_hp" value="{{ $d->no_hp }}" class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2 dark:text-white">No KTP</label>
                        <input type="text" name="no_ktp" value="{{ $d->no_ktp }}" class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                    </div>
                  </div>
                  <div>
                    <label class="block text-sm font-medium mb-2 dark:text-white">Alamat</label>
                    <textarea name="alamat" class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" rows="2">{{ $d->alamat }}</textarea>
                  </div>
                </div>
              </form>
              @slot('footer')
                <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden"
                        onclick="CrudHandler.submitForm('edit-dokter-form-{{ $d->id }}', 'hs-edit-dokter-modal-{{ $d->id }}', 'table-container')">
                  Update
                </button>
              @endslot
            </x-popupmodal>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500 dark:text-neutral-500">Data tidak ditemukan.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
<div class="mt-4 px-6">
  {{ $dokters->links() }}
</div>
