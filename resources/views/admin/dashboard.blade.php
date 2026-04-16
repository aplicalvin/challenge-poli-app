@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
  <div class="flex flex-col">
    <div class="-m-1.5 overflow-x-auto">
      <div class="p-1.5 min-w-full inline-block align-middle">
        <div
          class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-neutral-800 dark:border-neutral-700">
          <!-- Header -->
          <div
            class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-neutral-700">
            <div>
              <h1 class="text-3xl font-bold text-gray-800 dark:text-neutral-200">
                Welcome, {{ auth()->user()->username ?? 'Admin' }}
              </h1>
              <br>
              <h3 class="text-xl font-semibold text-gray-600 dark:text-neutral-400">
                ({{ auth()->user()->role ?? 'admin' }})
              </h3>
            </div>

            <div>
              <div class="inline-flex gap-x-2">
                <button type="button"
                  class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                  data-hs-overlay="#hs-basic-modal">
                  <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M5 12h14" />
                    <path d="M12 5v14" />
                  </svg>
                  Add User
                </button>
              </div>
            </div>
          </div>
          <!-- End Header -->

          <div class="p-6 h-48 flex justify-center items-center">
            <p class="text-gray-500 dark:text-neutral-500">Dashboard content goes here...</p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('modals')
  <x-popupmodal id="hs-basic-modal" title="Add New User">
    <div class="space-y-3">
      <p class="text-gray-800 dark:text-neutral-400">
        This is a placeholder for adding a new user form.
      </p>
    </div>
    @slot('footer')
    <button type="button"
      class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
      Save changes
    </button>
    @endslot
  </x-popupmodal>
@endsection