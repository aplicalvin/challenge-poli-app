@extends('layouts.admin')

@section('title', 'Manajemen Jadwal')

@section('content')
<div class="flex flex-col">
  <div class="-m-1.5 overflow-x-auto">
    <div class="p-1.5 min-w-full inline-block align-middle">
      <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-neutral-800 dark:border-neutral-700">
        <!-- Header -->
        <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-neutral-700">
          <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
              Manajemen Jadwal Jaga
            </h2>
            <p class="text-sm text-gray-600 dark:text-neutral-400">
              Atur jadwal tugas dokter dan penempatan ruang.
            </p>
          </div>

          @if(auth()->user()->role === 'admin')
          <div>
            <div class="inline-flex gap-x-2">
              <button type="button" 
                      class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" 
                      onclick="CrudHandler.openModal('hs-create-jadwal-modal')">
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                Tambah Jadwal
              </button>
            </div>
          </div>
          @endif
        </div>
        <!-- End Header -->

        <!-- Table -->
        <div id="table-container">
          @include('penjadwalan.jadwal-table')
        </div>
        <!-- End Table -->

        <!-- Footer -->
        <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-t border-gray-200 dark:border-neutral-700">
          <div>
            <p class="text-sm text-gray-600 dark:text-neutral-400">
              Menampilkan <span class="font-semibold text-gray-800 dark:text-neutral-200">{{ $jadwals->count() }}</span> data.
            </p>
          </div>
        </div>
        <!-- End Footer -->
      </div>
    </div>
  </div>
</div>

<!-- Create Modal -->
<x-popupmodal id="hs-create-jadwal-modal" title="Tambah Jadwal Jaga">
  <form id="create-jadwal-form" action="{{ route('penjadwalan.jadwal.store') }}" method="POST">
    @csrf
    <div class="space-y-4">
      <div>
        <label class="block text-sm font-medium mb-2 dark:text-white">Shift Kerja</label>
        <select name="id_shift" class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
          @foreach($shifts as $s)
            <option value="{{ $s->id }}">{{ $s->nama }} ({{ $s->hari }}: {{ $s->jam_masuk }} - {{ $s->jam_keluar }})</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium mb-2 dark:text-white">Dokter</label>
        <select name="id_dokter" class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
          @foreach($dokters as $d)
            <option value="{{ $d->id }}">{{ $d->nama }} ({{ $d->poli->nama_poli ?? '-' }})</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium mb-2 dark:text-white">Ruang</label>
        <select name="id_ruang" class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
          @foreach($ruangs as $r)
            <option value="{{ $r->id }}">{{ $r->nama }} ({{ $r->poli->nama_poli ?? '-' }})</option>
          @endforeach
        </select>
      </div>
    </div>
  </form>
  @slot('footer')
    <button type="button" 
            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden"
            onclick="CrudHandler.submitForm('create-jadwal-form', 'hs-create-jadwal-modal', 'table-container')">
      Simpan
    </button>
  @endslot
</x-popupmodal>

<!-- Global Edit Modal -->
<x-popupmodal id="hs-edit-jadwal-modal" title="Edit Jadwal Jaga">
  <form id="edit-jadwal-form" action="" method="POST">
    @csrf
    @method('PUT')
    <div class="space-y-4">
      <div>
        <label class="block text-sm font-medium mb-2 dark:text-white">Shift Kerja</label>
        <select id="edit-jadwal-shift" name="id_shift" class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
          @foreach($shifts as $s)
            <option value="{{ $s->id }}">{{ $s->nama }} ({{ $s->hari }}: {{ $s->jam_masuk }} - {{ $s->jam_keluar }})</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium mb-2 dark:text-white">Dokter</label>
        <select id="edit-jadwal-dokter" name="id_dokter" class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
          @foreach($dokters as $d)
            <option value="{{ $d->id }}">{{ $d->nama }} ({{ $d->poli->nama_poli ?? '-' }})</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium mb-2 dark:text-white">Ruang</label>
        <select id="edit-jadwal-ruang" name="id_ruang" class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
          @foreach($ruangs as $r)
            <option value="{{ $r->id }}">{{ $r->nama }} ({{ $r->poli->nama_poli ?? '-' }})</option>
          @endforeach
        </select>
      </div>
    </div>
  </form>
  @slot('footer')
    <button type="button" 
            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden"
            onclick="CrudHandler.submitForm('edit-jadwal-form', 'hs-edit-jadwal-modal', 'table-container')">
      Update
    </button>
  @endslot
</x-popupmodal>
@endsection
