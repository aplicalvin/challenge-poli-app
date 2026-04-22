@extends('layouts.auth')

@section('title', 'Sign Up - Pasien Baru')

@section('content')
  <div class="bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-neutral-900 dark:border-neutral-700">
    <div class="p-4 sm:p-7">
      <div class="text-center">
        <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">Daftar Pasien Baru</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-neutral-400">
          Sudah punya akun?
          <a class="text-blue-600 decoration-2 hover:underline font-medium dark:text-blue-500"
            href="{{ route('login') }}">
            Masuk di sini
          </a>
        </p>
      </div>

      <div class="mt-8">
        <!-- Form -->
        <form action="{{ route('signup') }}" method="POST">
          @csrf
          <div class="grid gap-y-4">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <!-- Username -->
              <div>
                <label for="username" class="block text-sm font-semibold mb-2 dark:text-white">Username</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}" 
                  class="py-3 px-4 block w-full border border-gray-300 rounded-xl text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" 
                  placeholder="Username untuk login" required>
                @error('username')
                  <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                @enderror
              </div>

              <!-- Email -->
              <div>
                <label for="email" class="block text-sm font-semibold mb-2 dark:text-white">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" 
                  class="py-3 px-4 block w-full border border-gray-300 rounded-xl text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" 
                  placeholder="nama@email.com" required>
                @error('email')
                  <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                @enderror
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <!-- Password -->
              <div>
                <label for="password" class="block text-sm font-semibold mb-2 dark:text-white">Password</label>
                <input type="password" id="password" name="password" 
                  class="py-3 px-4 block w-full border border-gray-300 rounded-xl text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" 
                  placeholder="Min. 6 karakter" required>
                @error('password')
                  <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                @enderror
              </div>

              <!-- Confirm Password -->
              <div>
                <label for="password_confirmation" class="block text-sm font-semibold mb-2 dark:text-white">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" 
                  class="py-3 px-4 block w-full border border-gray-300 rounded-xl text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" 
                  placeholder="Ulangi password" required>
              </div>
            </div>

            <hr class="my-2 border-gray-200 dark:border-neutral-700">
            <h3 class="text-sm font-bold text-gray-800 dark:text-white uppercase tracking-wider">Data Diri Pasien</h3>

            <!-- Nama Lengkap -->
            <div>
              <label for="nama" class="block text-sm font-semibold mb-2 dark:text-white">Nama Lengkap (Sesuai KTP)</label>
              <input type="text" id="nama" name="nama" value="{{ old('nama') }}" 
                class="py-3 px-4 block w-full border border-gray-300 rounded-xl text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" 
                placeholder="Masukkan nama lengkap Anda" required>
              @error('nama')
                <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
              @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <!-- No KTP -->
              <div>
                <label for="no_ktp" class="block text-sm font-semibold mb-2 dark:text-white">Nomor KTP (NIK)</label>
                <input type="text" id="no_ktp" name="no_ktp" value="{{ old('no_ktp') }}" 
                  class="py-3 px-4 block w-full border border-gray-300 rounded-xl text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" 
                  placeholder="16 digit NIK" required>
                @error('no_ktp')
                  <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                @enderror
              </div>

              <!-- No HP -->
              <div>
                <label for="no_hp" class="block text-sm font-semibold mb-2 dark:text-white">Nomor HP / WhatsApp</label>
                <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" 
                  class="py-3 px-4 block w-full border border-gray-300 rounded-xl text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" 
                  placeholder="Contoh: 08123456789" required>
                @error('no_hp')
                  <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                @enderror
              </div>
            </div>

            <!-- Alamat -->
            <div>
              <label for="alamat" class="block text-sm font-semibold mb-2 dark:text-white">Alamat Lengkap</label>
              <textarea id="alamat" name="alamat" rows="3"
                class="py-3 px-4 block w-full border border-gray-300 rounded-xl text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" 
                placeholder="Alamat domisili saat ini (Opsional)">{{ old('alamat') }}</textarea>
              @error('alamat')
                <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
              @enderror
            </div>

            <button type="submit"
              class="mt-4 w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-bold rounded-xl border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none shadow-md">
              Daftar Sekarang
            </button>
          </div>
        </form>
        <!-- End Form -->
      </div>
    </div>
  </div>
@endsection