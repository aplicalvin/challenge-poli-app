@extends('layouts.admin')

@section('title', 'Periksa Pasien')

@section('content')
<div class="max-w-4xl mx-auto flex flex-col gap-6">
  <!-- Info Pasien -->
  <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 dark:bg-neutral-800 dark:border-neutral-700">
    <div class="grid grid-cols-2 gap-4">
      <div>
        <h3 class="text-sm font-medium text-gray-500 uppercase">Nama Pasien</h3>
        <p class="text-lg font-bold text-gray-800 dark:text-neutral-200">{{ $periksa->pasien->nama }}</p>
      </div>
      <div>
        <h3 class="text-sm font-medium text-gray-500 uppercase">Keluhan</h3>
        <p class="text-gray-800 dark:text-neutral-200">{{ $periksa->keluhan }}</p>
      </div>
    </div>
  </div>

  <!-- Form Periksa -->
  <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 dark:bg-neutral-800 dark:border-neutral-700">
    <form id="examine-form" class="space-y-6">
      @csrf
      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium mb-2 dark:text-white">Diagnosis / Nama Penyakit</label>
          <input type="text" name="nama_penyakit" 
            class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
            required>
        </div>
        <div>
          <label class="block text-sm font-medium mb-2 dark:text-white">Catatan Medis</label>
          <textarea name="catatan" 
            class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
            rows="3" placeholder="Saran atau catatan tambahan..." required></textarea>
        </div>
      </div>

      <hr class="border-gray-200 dark:border-neutral-700">

      <!-- Resep Obat -->
      <div>
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-bold text-gray-800 dark:text-neutral-200">Resep Obat</h3>
          <button type="button" 
            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800"
            onclick="addObatRow()">
            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            Tambah Obat
          </button>
        </div>

        <div id="obat-list" class="space-y-3">
          <!-- Rows added via JS -->
        </div>

        <div class="mt-6 p-4 bg-gray-50 rounded-lg dark:bg-neutral-700">
          <div class="flex justify-between items-center text-lg font-bold">
            <span class="text-gray-800 dark:text-neutral-200">Total Biaya Obat:</span>
            <span id="total-cost" class="text-blue-600">Rp 0</span>
          </div>
        </div>
      </div>

      <div class="flex justify-end gap-x-3">
        <a href="{{ route('dokter.antrian') }}" 
          class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800">
          Batal
        </a>
        <button type="button" 
          class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-green-600 text-white hover:bg-green-700 disabled:opacity-50 disabled:pointer-events-none"
          onclick="finishExamination()">
          Selesai Periksa
        </button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
  let obatCounter = 0;
  const allObat = @json($obats);

  function addObatRow() {
    const container = document.getElementById('obat-list');
    const rowId = `obat-row-${obatCounter}`;
    
    let options = '<option value="">Pilih Obat</option>';
    allObat.forEach(o => {
      options += `<option value="${o.id}" data-price="${o.harga}">${o.nama_obat} - Rp ${o.harga.toLocaleString('id-ID')}</option>`;
    });

    const html = `
      <div id="${rowId}" class="grid grid-cols-12 gap-3 items-center bg-gray-50 p-3 rounded-lg dark:bg-neutral-900/50">
        <div class="col-span-12 md:col-span-7">
          <select name="obats[${obatCounter}][id]" onchange="updateRowTotal('${rowId}')" class="obat-select py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
            ${options}
          </select>
        </div>
        <div class="col-span-6 md:col-span-3">
          <input type="number" name="obats[${obatCounter}][jumlah]" value="1" min="1" oninput="updateRowTotal('${rowId}')" placeholder="Qty" class="py-2 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
        </div>
        <div class="col-span-6 md:col-span-2 flex justify-end">
          <button type="button" class="text-red-600 hover:text-red-800 p-2" onclick="removeObatRow('${rowId}')">
            <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
          </button>
        </div>
      </div>
    `;
    
    container.insertAdjacentHTML('beforeend', html);
    obatCounter++;
  }

  function removeObatRow(id) {
    document.getElementById(id).remove();
    calculateTotal();
  }

  function updateRowTotal() {
    calculateTotal();
  }

  function calculateTotal() {
    let total = 0;
    const rows = document.querySelectorAll('#obat-list > div');
    
    rows.forEach(row => {
      const select = row.querySelector('select');
      const qty = row.querySelector('input[type="number"]');
      const selectedOption = select.options[select.selectedIndex];
      
      if (selectedOption && selectedOption.dataset.price) {
        total += parseInt(selectedOption.dataset.price) * parseInt(qty.value || 0);
      }
    });

    document.getElementById('total-cost').textContent = `Rp ${total.toLocaleString('id-ID')}`;
  }

  async function finishExamination() {
    const form = document.getElementById('examine-form');
    const formData = new FormData(form);
    
    // Check if at least one obat added
    if (document.querySelectorAll('#obat-list > div').length === 0) {
        Swal.fire('Perhatian', 'Harap tambahkan minimal satu obat.', 'warning');
        return;
    }

    try {
        const response = await fetch(`{{ route('doctor.queue.finish', $periksa->id) }}`, {
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
                title: 'Selesai!',
                text: result.message,
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = "{{ route('dokter.antrian') }}";
            });
        } else {
            Swal.fire('Gagal', result.message, 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire('Gagal', 'Terjadi kesalahan pada server.', 'error');
    }
  }

  // Add initial row
  document.addEventListener('DOMContentLoaded', addObatRow);
</script>
@endpush
