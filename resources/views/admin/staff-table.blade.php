<div class="overflow-x-auto">
  <table id="table-staff" class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
    <thead class="bg-gray-50 dark:bg-neutral-800">
      <tr>
        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">No</th>
        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Nama</th>
        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Username</th>
        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Role</th>
        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">No HP</th>
        <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Aksi</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
      @forelse($staffs as $index => $s)
        @php
            $u = $s->user;
        @endphp
        <tr>
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">{{ $staffs->firstItem() + $index }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">{{ $s->nama }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">{{ $u->username ?? '-' }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
              <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium {{ ($u->role ?? '') === 'apoteker' ? 'bg-teal-100 text-teal-800 dark:bg-teal-800/30 dark:text-teal-500' : 'bg-blue-100 text-blue-800 dark:bg-blue-800/30 dark:text-blue-500' }}">
                {{ ucfirst($u->role ?? '-') }}
              </span>
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">{{ $s->no_hp ?? '-' }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
            <button type="button" 
                    class="py-1.5 px-2 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400"
                    onclick="CrudHandler.openModal('hs-edit-staff-modal-{{ $s->id }}')">
              Edit
            </button>
            <button type="button" 
                    class="py-1.5 px-2 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent text-red-600 hover:text-red-800 focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none dark:text-red-500 dark:hover:text-red-400"
                    onclick="CrudHandler.confirmDelete('{{ route('staff.destroy', $s->id) }}', 'table-container')">
              Delete
            </button>

            <!-- Edit Modal -->
            <x-popupmodal id="hs-edit-staff-modal-{{ $s->id }}" title="Edit Staff">
              <form id="edit-staff-form-{{ $s->id }}" action="{{ route('staff.update', $s->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4 text-start">
                  <div>
                    <label class="block text-sm font-medium mb-2 dark:text-white">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ $s->nama }}" class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" required>
                  </div>
                  <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2 dark:text-white">Username</label>
                        <input type="text" name="username" value="{{ $u->username ?? '' }}" class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2 dark:text-white">Role</label>
                        <select name="role" class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                            <option value="kasir" {{ ($u->role ?? '') === 'kasir' ? 'selected' : '' }}>Kasir</option>
                            <option value="apoteker" {{ ($u->role ?? '') === 'apoteker' ? 'selected' : '' }}>Apoteker</option>
                        </select>
                    </div>
                  </div>
                  <div>
                    <label class="block text-sm font-medium mb-2 dark:text-white">Password (Biar kosong jika tidak ganti)</label>
                    <input type="password" name="password" class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                  </div>
                  <div>
                    <label class="block text-sm font-medium mb-2 dark:text-white">No HP</label>
                    <input type="text" name="no_hp" value="{{ $s->no_hp }}" class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                  </div>
                  <div>
                    <label class="block text-sm font-medium mb-2 dark:text-white">Alamat</label>
                    <textarea name="alamat" class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" rows="2">{{ $s->alamat }}</textarea>
                  </div>
                </div>
              </form>
              @slot('footer')
                <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden"
                        onclick="CrudHandler.submitForm('edit-staff-form-{{ $s->id }}', 'hs-edit-staff-modal-{{ $s->id }}', 'table-container')">
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
  {{ $staffs->links() }}
</div>
