@extends('layouts.admin')

@section('title', 'Daftar Periksa')

@section('content')
<div class="flex flex-col gap-6">
  <!-- Pendaftaran Baru -->
  <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 dark:bg-neutral-800 dark:border-neutral-700">
    <div class="mb-5">
      <h2 class="text-xl font-bold text-gray-800 dark:text-neutral-200">
        Pendaftaran Periksa Baru
      </h2>
      <p class="text-sm text-gray-600 dark:text-neutral-400">
        Pilih tanggal dan jadwal dokter untuk mendaftar antrian.
      </p>
    </div>

    <form id="registration-form" class="space-y-4">
      @csrf
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium mb-2 dark:text-white">Pilih Tanggal</label>
          <input type="date" id="date-picker" name="date" min="{{ date('Y-m-d') }}"
            class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
            required>
        </div>
        <div>
          <label class="block text-sm font-medium mb-2 dark:text-white">Pilih Jadwal & Dokter</label>
          <select id="schedule-select" name="id_jadwal_jaga" disabled
            class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
            required>
            <option value="">Pilih Tanggal Terlebih Dahulu</option>
          </select>
        </div>
      </div>

      <div>
        <label class="block text-sm font-medium mb-2 dark:text-white">Keluhan</label>
        <textarea name="keluhan" 
          class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
          rows="3" placeholder="Tuliskan keluhan Anda..." required></textarea>
      </div>

      <div class="flex justify-end mt-4">
        <button type="button" 
          class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
          onclick="submitRegistration()">
          Daftar Antrian
        </button>
      </div>
    </form>
  </div>

  <!-- Riwayat Pendaftaran -->
  <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-neutral-800 dark:border-neutral-700">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-neutral-700">
      <h2 class="text-xl font-bold text-gray-800 dark:text-neutral-200">
        Riwayat Pendaftaran Anda
      </h2>
    </div>
    <div id="history-table-container" class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
        <thead class="bg-gray-50 dark:bg-neutral-700">
          <tr>
            <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">No Antrian</th>
            <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Tanggal Periksa</th>
            <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Dokter</th>
            <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Poli</th>
            <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Status</th>
            <th class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">Aksi</th>
          </tr>
        </thead>
        <tbody id="history-table-body" class="divide-y divide-gray-200 dark:divide-neutral-700">
          @forelse($daftarPeriksa as $dp)
          <tr>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-600">{{ $dp->no_antrian }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
              {{ \Carbon\Carbon::parse($dp->tgl_periksa)->format('d M Y H:i') }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">{{ $dp->jadwalJaga->dokter->nama }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">{{ $dp->jadwalJaga->ruang->poli->nama_poli ?? '-' }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm">
              @php
                $statusClasses = [
                    'belum_saatnya' => 'bg-gray-100 text-gray-800',
                    'antri' => 'bg-yellow-100 text-yellow-800',
                    'sedang_periksa' => 'bg-blue-100 text-blue-800',
                    'menunggu_pembayaran' => 'bg-orange-100 text-orange-800',
                    'selesai' => 'bg-green-100 text-green-800',
                    'batal' => 'bg-red-100 text-red-800',
                ];
                $class = $statusClasses[$dp->status_periksa] ?? 'bg-gray-100 text-gray-800';
              @endphp
              <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium {{ $class }}">
                {{ str_replace('_', ' ', ucfirst($dp->status_periksa)) }}
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
              @if(in_array($dp->status_periksa, ['belum_saatnya', 'antri']))
                <button type="button" 
                  class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-red-600 hover:text-red-800 disabled:opacity-50 disabled:pointer-events-none dark:text-red-500 dark:hover:text-red-400"
                  onclick="cancelRegistration({{ $dp->id }})">
                  Batalkan
                </button>
              @else
                <span class="text-gray-400 dark:text-neutral-600">Terproses</span>
              @endif
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada riwayat pendaftaran.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  const datePicker = document.getElementById('date-picker');
  const scheduleSelect = document.getElementById('schedule-select');

  datePicker.addEventListener('change', async function() {
    const date = this.value;
    if (!date) return;

    scheduleSelect.disabled = true;
    scheduleSelect.innerHTML = '<option value="">Memuat Jadwal...</option>';

    try {
      const response = await fetch(`{{ route('patient.registration.schedules') }}?date=${date}`, {
        headers: {
          'Accept': 'application/json'
        }
      });
      const schedules = await response.json();

      if (schedules.length > 0) {
        scheduleSelect.innerHTML = '<option value="">Pilih Jadwal</option>';
        schedules.forEach(s => {
          const option = document.createElement('option');
          option.value = s.id;
          option.textContent = `${s.dokter_nama} (${s.poli_nama}) | ${s.jam}`;
          scheduleSelect.appendChild(option);
        });
        scheduleSelect.disabled = false;
      } else {
        scheduleSelect.innerHTML = '<option value="">Tidak ada dokter tersedia di hari tersebut.</option>';
      }
    } catch (error) {
      console.error('Error fetching schedules:', error);
      scheduleSelect.innerHTML = '<option value="">Gagal memuat jadwal.</option>';
    }
  });

  async function refreshTable() {
    try {
      const response = await fetch(window.location.href);
      const text = await response.text();
      const parser = new DOMParser();
      const doc = parser.parseFromString(text, 'text/html');
      const newTable = doc.getElementById('history-table-container').innerHTML;
      document.getElementById('history-table-container').innerHTML = newTable;
    } catch (error) {
      console.error('Error refreshing table:', error);
    }
  }

  async function submitRegistration() {
    const form = document.getElementById('registration-form');
    const formData = new FormData(form);

    try {
      const response = await fetch(`{{ route('patient.registration.store') }}`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json'
        },
        body: formData
      });

      const result = await response.json();

      if (result.success) {
        Swal.fire({
          icon: 'success',
          title: 'Berhasil!',
          text: result.message,
          confirmButtonText: 'OK'
        });
        form.reset();
        refreshTable();
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Gagal',
          text: result.message || 'Terjadi kesalahan saat mendaftar.'
        });
      }
    } catch (error) {
       console.error('Error submitting registration:', error);
       Swal.fire({
          icon: 'error',
          title: 'Gagal',
          text: 'Terjadi kesalahan pada server.'
        });
    }
  }

  async function cancelRegistration(id) {
    const { value: confirmed } = await Swal.fire({
      title: 'Apakah Anda yakin?',
      text: "Pendaftaran ini akan dibatalkan.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Ya, Batalkan!',
      cancelButtonText: 'Kembali'
    });

    if (confirmed) {
      try {
        const response = await fetch(`{{ url('/patient/registration') }}/${id}`, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
          }
        });

        const result = await response.json();

        if (result.success) {
          Swal.fire('Berhasil!', result.message, 'success');
          refreshTable();
        } else {
          Swal.fire('Gagal!', result.message, 'error');
        }
      } catch (error) {
        console.error('Error cancelling registration:', error);
        Swal.fire('Error!', 'Terjadi kesalahan pada server.', 'error');
      }
    }
  }
</script>
@endpush
