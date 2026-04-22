@extends('layouts.admin')

@section('title', 'Antrian Pasien')

@section('content')
<div class="flex flex-col gap-6">
  <!-- Status Jadwal Aktif -->
  <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 dark:bg-neutral-800 dark:border-neutral-700">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-xl font-bold text-gray-800 dark:text-neutral-200">
          Jadwal Aktif Saat Ini
        </h2>
        @if($activeSchedule)
          <p class="text-sm text-gray-600 dark:text-neutral-400">
            {{ $activeSchedule->shift->hari }}, {{ $activeSchedule->shift->jam_masuk }} - {{ $activeSchedule->shift->jam_keluar }}
            | Ruang: {{ $activeSchedule->ruang->nama }}
          </p>
        @else
          <p class="text-sm text-red-600 font-medium">
            Anda tidak memiliki jadwal praktek yang aktif saat ini.
          </p>
        @endif
      </div>
      @if($activeSchedule)
        <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-green-100 text-green-800">
          <span class="size-1.5 inline-block rounded-full bg-green-800"></span>
          Sesi Aktif
        </span>
      @endif
    </div>
  </div>

  <!-- Daftar Antrian -->
  <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-neutral-800 dark:border-neutral-700">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-neutral-700 flex justify-between items-center">
      <h2 class="text-xl font-bold text-gray-800 dark:text-neutral-200">
        Pasien Mengantri
      </h2>
      <span class="text-sm text-gray-600 dark:text-neutral-400">
        Total: {{ count($antrian) }} Pasien
      </span>
    </div>
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
        <thead class="bg-gray-50 dark:bg-neutral-700">
          <tr>
            <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">No Antrian</th>
            <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Nama Pasien</th>
            <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Keluhan</th>
            <th class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
          @forelse($antrian as $a)
          <tr>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-600">
              <span class="size-8 inline-flex items-center justify-center rounded-full bg-blue-100 text-blue-800">
                {{ $a->no_antrian }}
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">
              {{ $a->pasien->nama }}
              @if($a->status_periksa === 'sedang_periksa')
                <span class="ms-2 inline-flex items-center gap-x-1.5 py-0.5 px-2 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                  Sedang Diperiksa
                </span>
              @endif
            </td>
            <td class="px-6 py-4 text-sm text-gray-800 dark:text-neutral-200 max-w-xs truncate">{{ $a->keluhan }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                @if($a->status_periksa === 'antri')
                    <form action="{{ route('doctor.queue.start', $a->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                          class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                          Mulai Periksa
                        </button>
                    </form>
                @else
                    <a href="{{ route('doctor.queue.examine', $a->id) }}" 
                      class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-orange-500 text-white hover:bg-orange-600">
                      Lanjutkan
                    </a>
                @endif
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="4" class="px-6 py-10 text-center text-sm text-gray-500 italic">
              Tidak ada pasien dalam antrian saat ini.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
