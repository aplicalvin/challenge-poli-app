@extends('layouts.admin')

@section('title', 'Manajemen Profil')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
  <!-- Header -->
  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-bold text-gray-800 dark:text-neutral-200">Pengaturan Profil</h1>
      <p class="text-sm text-gray-600 dark:text-neutral-400">Kelola informasi akun dan biodata Anda.</p>
    </div>
  </div>

  <div id="profile-details-container">
    @include('profile.partials.details')
  </div>
</div>
@endsection

@section('modals')
<x-popupmodal id="hs-confirm-profile-modal" title="Konfirmasi Perubahan">
  <div class="p-4">
    <p class="text-gray-800 dark:text-neutral-400">
      Apakah Anda yakin ingin menyimpan perubahan pada profil Anda? Beberapa perubahan mungkin memerlukan Anda untuk login kembali.
    </p>
  </div>
  @slot('footer')
  <button type="button" 
    class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800" 
    data-hs-overlay="#hs-confirm-profile-modal">
    Batal
  </button>
  <button type="button" 
    class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
    onclick="CrudHandler.submitForm('profile-form', 'hs-confirm-profile-modal', 'profile-details-container')">
    Ya, Simpan
  </button>
  @endslot
</x-popupmodal>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('profile-details-container');
    if (container) {
      container.addEventListener('input', function(e) {
        if (e.target && e.target.name === 'username') {
          const original = e.target.value;
          const transformed = original.toLowerCase().replace(/\s/g, '_');
          if (original !== transformed) {
            e.target.value = transformed;
          }
        }
      });
    }
  });
</script>
@endsection
