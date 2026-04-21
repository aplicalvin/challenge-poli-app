@extends('layouts.auth')

@section('title', 'Login')

@section('content')
  <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-900 dark:border-neutral-700">
    <div class="p-4 sm:p-7">
      <div class="text-center">
        <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">Sign in</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-neutral-400">
          Don't have an account yet?
          <a class="text-blue-600 decoration-2 hover:underline font-medium dark:text-blue-500"
            href="{{ route('signup') }}">
            Sign up here
          </a>
        </p>
      </div>

      <div class="mt-5">
        <!-- Form -->
        <form action="{{ route('login') }}" method="POST">
          @csrf
          <div class="grid gap-y-4">
            <!-- Form Group -->
            <div>
              <label for="username" class="block text-sm mb-2 dark:text-white">Username</label>
              <div class="relative">
                <input type="text" id="username" name="username" value="{{ old('username') }}" 
                class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500" 
                required>
              @error('username')
                <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
              @enderror
            </div>
          </div>
          <!-- End Form Group -->

          <!-- Form Group -->
          <div>
            <div class="flex justify-between items-center">
              <label for="password" class="block text-sm mb-2 dark:text-white">Password</label>
              <a class="text-sm text-blue-600 decoration-2 hover:underline font-medium dark:text-blue-500" href="#">Forgot password?</a>
            </div>
            <div class="relative">
              <input type="password" id="password" name="password" 
                class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500" 
                required>
                @error('password')
                  <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                @enderror
              </div>
            </div>
            <!-- End Form Group -->

            <button type="submit"
              class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">Sign
              in</button>
          </div>
        </form>
        <!-- End Form -->
      </div>
    </div>
  </div>
@endsection