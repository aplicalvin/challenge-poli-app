<form id="profile-form" action="{{ route('profile.update') }}" method="POST">
  @csrf
  @method('PUT')
  
  <div class="grid gap-6">
    <!-- Account Info Card -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 dark:bg-neutral-800 dark:border-neutral-700">
      <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">Informasi Akun</h2>
        <p class="text-sm text-gray-500 dark:text-neutral-500">Detail login dan profil dasar.</p>
      </div>
      <div class="grid sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium mb-2 dark:text-white">Username</label>
          <div class="relative">
            <input type="text" name="username" value="{{ $user->username }}" 
              class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" 
              placeholder="username_anda" required>
          </div>
          <p class="mt-2 text-xs text-gray-500 dark:text-neutral-500">Tanpa spasi, otomatis lowercase (spasi menjadi _).</p>
        </div>
        <div>
          <label class="block text-sm font-medium mb-2 dark:text-white">Email</label>
          <input type="email" name="email" value="{{ $user->email }}" 
            class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" 
            placeholder="nama@example.com" required>
        </div>
        <div class="sm:col-span-2">
          <label class="block text-sm font-medium mb-2 dark:text-white">Password Baru (Kosongkan jika tidak ingin mengubah)</label>
          <input type="password" name="password" 
            class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
        </div>
      </div>
    </div>

    <!-- Personal Info Card (If not Admin) -->
    @if($user->role !== 'admin')
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 dark:bg-neutral-800 dark:border-neutral-700">
      <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">Informasi Pribadi</h2>
        <p class="text-sm text-gray-500 dark:text-neutral-500">Data diri sesuai kartu identitas.</p>
      </div>
      <div class="grid sm:grid-cols-2 gap-4">
        <div class="sm:col-span-2">
          <label class="block text-sm font-medium mb-2 dark:text-white">Nama Lengkap</label>
          <input type="text" name="nama" value="{{ $profile->nama ?? '' }}" 
            class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" required>
        </div>

        @if($user->role === 'pasien')
        <div>
          <label class="block text-sm font-medium mb-2 dark:text-white">Nomor Rekam Medis (Read-only)</label>
          <input type="text" value="{{ $profile->no_rm ?? '' }}" disabled
            class="py-2 px-4 block w-full bg-gray-50 border border-gray-300 rounded-lg text-sm dark:bg-neutral-700 dark:border-neutral-700 dark:text-neutral-500">
        </div>
        @endif

        @if(in_array($user->role, ['dokter', 'pasien']))
        <div>
          <label class="block text-sm font-medium mb-2 dark:text-white">Nomor KTP</label>
          <input type="text" name="no_ktp" value="{{ $profile->no_ktp ?? '' }}" 
            class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
        </div>
        @endif

        <div>
          <label class="block text-sm font-medium mb-2 dark:text-white">Nomor HP</label>
          <input type="text" name="no_hp" value="{{ $profile->no_hp ?? '' }}" 
            class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
        </div>

        <div class="sm:col-span-2">
          <label class="block text-sm font-medium mb-2 dark:text-white">Alamat</label>
          <textarea name="alamat" rows="3" 
            class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">{{ $profile->alamat ?? '' }}</textarea>
        </div>

        @if($user->role === 'pasien')
        <div>
          <label class="block text-sm font-medium mb-2 dark:text-white">Bergabung Sejak</label>
          <input type="text" value="{{ optional($profile->created_at)->format('d M Y H:i') }}" disabled
            class="py-2 px-4 block w-full bg-gray-50 border border-gray-300 rounded-lg text-sm dark:bg-neutral-700 dark:border-neutral-700 dark:text-neutral-500">
        </div>
        <div>
          <label class="block text-sm font-medium mb-2 dark:text-white">Terakhir Diperbarui</label>
          <input type="text" value="{{ optional($profile->updated_at)->format('d M Y H:i') }}" disabled
            class="py-2 px-4 block w-full bg-gray-50 border border-gray-300 rounded-lg text-sm dark:bg-neutral-700 dark:border-neutral-700 dark:text-neutral-500">
        </div>
        @endif
      </div>
    </div>
    @endif

    <!-- Action -->
    <div class="flex justify-end gap-x-2">
      <button type="button" 
        onclick="CrudHandler.openModal('hs-confirm-profile-modal')"
        class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
        Simpan Perubahan
      </button>
    </div>
  </div>
</form>
