@extends('layouts.admin')

@section('title', 'Monitor Antrian Real-time')

@section('content')
<div id="queue-monitor-container" class="p-4 sm:p-6 space-y-6 bg-gray-50 dark:bg-neutral-900 transition-all duration-300">
  <!-- Header -->
  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-black text-gray-800 dark:text-neutral-200 uppercase tracking-tight">Monitor Antrian Real-time</h1>
      <p class="text-sm text-gray-500 dark:text-neutral-400">Pembaruan otomatis setiap 3 detik.</p>
    </div>
    <div class="flex gap-3">
      <button type="button" onclick="toggleFullScreen()" id="fullscreen-btn"
        class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-xl border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white">
        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3H5a2 2 0 0 0-2 2v3"/><path d="M21 8V5a2 2 0 0 0-2-2h-3"/><path d="M3 16v3a2 2 0 0 0 2 2h3"/><path d="M16 21h3a2 2 0 0 0 2-2v-3"/></svg>
        <span>Fullscreen</span>
      </button>
    </div>
  </div>

  <!-- Grid Layout -->
  <div id="queue-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Loading State -->
    <div class="col-span-full py-20 text-center">
      <div class="animate-spin inline-block size-10 border-[3px] border-current border-t-transparent text-blue-600 rounded-full" role="status" aria-label="loading"></div>
      <p class="mt-4 text-gray-500 font-medium">Menghubungkan ke sistem antrian...</p>
    </div>
  </div>
</div>

<style>
  #queue-monitor-container:fullscreen {
    padding: 2rem;
    overflow-y: auto;
    background-color: #f9fafb;
  }
  .dark #queue-monitor-container:fullscreen {
    background-color: #171717;
  }
</style>

@endsection

@push('scripts')
<script>
  const grid = document.getElementById('queue-grid');

  async function fetchQueues() {
    try {
      const response = await fetch('{{ route("admin.antrian.data") }}');
      const result = await response.json();
      
      if (result.success) {
        renderQueues(result.data);
      }
    } catch (e) {
      console.error('Fetch error:', e);
    }
  }

  function renderQueues(data) {
    if (data.length === 0) {
      grid.innerHTML = `
        <div class="col-span-full py-20 text-center bg-white border border-dashed border-gray-300 rounded-3xl dark:bg-neutral-800 dark:border-neutral-700">
          <p class="text-gray-500 italic">Tidak ada poli aktif hari ini.</p>
        </div>
      `;
      return;
    }

    grid.innerHTML = data.map(poli => `
      <div class="group flex flex-col bg-white border border-gray-200 shadow-sm rounded-3xl p-6 dark:bg-neutral-800 dark:border-neutral-700 transition-all hover:shadow-xl hover:-translate-y-1">
        <div class="flex items-center justify-between mb-4">
          <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-bold bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400 uppercase">
            <span class="size-1.5 rounded-full bg-blue-600 animate-pulse"></span>
            AKTIF
          </span>
          <h2 class="text-lg font-black text-gray-800 dark:text-white uppercase tracking-tight">${poli.poli_name}</h2>
        </div>
        
        <div class="space-y-4">
          <div>
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Dokter Bertugas</p>
            <p class="text-sm font-semibold text-gray-700 dark:text-neutral-300">${poli.doctor_name}</p>
          </div>
          
          <div class="pt-4 border-t border-gray-100 dark:border-neutral-700 text-center">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Sedang Melayani</p>
            <div class="text-7xl font-black text-blue-600 dark:text-blue-400 drop-shadow-sm">
              ${poli.current_number.toString().padStart(2, '0')}
            </div>
          </div>
        </div>
      </div>
    `).join('');
  }

  function toggleFullScreen() {
    const elem = document.getElementById('queue-monitor-container');
    const btn = document.getElementById('fullscreen-btn');
    
    if (!document.fullscreenElement) {
      elem.requestFullscreen().catch(err => {
        alert(`Error attempting to enable full-screen mode: ${err.message} (${err.name})`);
      });
      btn.querySelector('span').textContent = 'Exit Fullscreen';
    } else {
      document.exitFullscreen();
      btn.querySelector('span').textContent = 'Fullscreen';
    }
  }

  // Initial fetch
  fetchQueues();

  // Polling every 3 seconds
  setInterval(fetchQueues, 3000);
</script>
@endpush
