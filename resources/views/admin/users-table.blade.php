<div class="overflow-x-auto">
  <table id="table-users" class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
    <thead class="bg-gray-50 dark:bg-neutral-800">
      <tr>
        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">No</th>
        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Nama</th>
        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Username</th>
        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Role</th>
        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Email</th>
        <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Aksi</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
      @forelse($users as $index => $u)
        <tr>
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">{{ $users->firstItem() + $index }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">{{ $u->nama }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200 font-bold">{{ $u->username }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm">
            @php
              $badgeClasses = [
                'admin' => 'bg-red-100 text-red-800 dark:bg-red-800/30 dark:text-red-500',
                'dokter' => 'bg-blue-100 text-blue-800 dark:bg-blue-800/30 dark:text-blue-500',
                'pasien' => 'bg-teal-100 text-teal-800 dark:bg-teal-800/30 dark:text-teal-500',
                'apoteker' => 'bg-purple-100 text-purple-800 dark:bg-purple-800/30 dark:text-purple-500',
                'kasir' => 'bg-orange-100 text-orange-800 dark:bg-orange-800/30 dark:text-orange-500',
              ];
              $roleClass = $badgeClasses[$u->role] ?? 'bg-gray-100 text-gray-800';
            @endphp
            <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium {{ $roleClass }}">
                {{ ucfirst($u->role) }}
            </span>
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-neutral-400 font-medium">{{ $u->email }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
            <button type="button" 
                    class="py-1.5 px-2 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400"
                    onclick="CrudHandler.openEditUserModal('{{ $u->id }}', '{{ $u->username }}', '{{ $u->email }}', '{{ $u->role }}', '{{ addslashes($u->nama) }}')">
              Edit
            </button>
            <button type="button" 
                    class="py-1.5 px-2 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent text-red-600 hover:text-red-800 focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none dark:text-red-500 dark:hover:text-red-400"
                    onclick="CrudHandler.confirmDelete('{{ route('users.destroy', $u->id) }}', 'table-container')"
                    @if($u->id === auth()->id()) disabled title="Anda tidak dapat menghapus akun Anda sendiri" @endif>
              Delete
            </button>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500 dark:text-neutral-500">Pengguna tidak ditemukan.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
<div class="mt-4 px-6">
  {{ $users->links() }}
</div>
