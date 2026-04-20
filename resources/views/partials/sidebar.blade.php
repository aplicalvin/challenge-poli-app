@php
  $userRole = auth()->user()->role ?? 'admin';

  $menu = [
    [
      'label' => 'Dashboard',
      'icon' => '<path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>',
      'route' => 'admin.dashboard',
      'roles' => ['admin', 'dokter', 'pasien', 'apoteker', 'kasir'],
    ],
    [
      'label' => 'Layanan Dokter',
      'icon' => '<path d="M4.8 2.3A.3.3 0 1 0 5 2H4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h1a.3.3 0 1 0 .2-.3L4 10.5V4l.8-1.7ZM19.2 2.3A.3.3 0 1 1 19 2h1a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-1a.3.3 0 1 1-.2-.3l1.2-.2V4l-.8-1.7ZM12 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM18 19v-1a4 4 0 0 0-4-4h-4a4 4 0 0 0-4 4v1"/>',
      'roles' => ['dokter'],
      'children' => [
        ['label' => 'Antrian Pasien', 'route' => 'dokter.antrian'],
      ]
    ],
    [
      'label' => 'Master Data',
      'icon' => '<ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5V19A9 3 0 0 0 21 19V5"/><path d="M3 12A9 3 0 0 0 21 12"/>',
      'roles' => ['admin'],
      'children' => [
        ['label' => 'Manajemen Poli', 'route' => 'admin.poli'],
        ['label' => 'Manajemen Dokter', 'route' => 'admin.dokter'],
        ['label' => 'Manajemen Staff', 'route' => 'admin.staff'],
        ['label' => 'Manajemen Pasien', 'route' => 'admin.pasien'],
      ]
    ],
    [
      'label' => 'Penjadwalan',
      'icon' => '<rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/>',
      'roles' => ['admin', 'dokter'],
      'children' => [
        ['label' => 'Manajemen Shift', 'route' => 'penjadwalan.shift', 'roles' => ['admin']],
        ['label' => 'Manajemen Ruang', 'route' => 'penjadwalan.ruang', 'roles' => ['admin']],
        ['label' => 'Manajemen Jadwal', 'route' => 'penjadwalan.jadwal', 'roles' => ['admin', 'dokter', 'pasien']],
      ]
    ],
    [
      'label' => 'Obat',
      'icon' => '<path d="m10.5 20.5 10-10a4.95 4.95 0 1 0-7-7l-10 10a4.95 4.95 0 1 0 7 7Z"/><path d="m8.5 8.5 7 7"/>',
      'roles' => ['admin', 'apoteker'],
      'children' => [
        ['label' => 'Manajemen Obat', 'route' => 'obat.list'],
        ['label' => 'Manajemen Stok Obat', 'route' => 'obat.stok'],
      ]
    ],
    [
      'label' => 'Keuangan',
      'icon' => '<path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/><path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/><path d="M18 12a2 2 0 0 0 0 4h4v-4Z"/>',
      'roles' => ['admin', 'kasir'],
      'children' => [
        ['label' => 'Manajemen Transaksi', 'route' => 'keuangan.transaksi'],
        ['label' => 'Laporan Keuangan', 'route' => 'keuangan.laporan'],
      ]
    ],
    [
      'label' => 'Riwayat',
      'icon' => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
      'roles' => ['dokter', 'pasien'],
      'children' => [
        ['label' => 'Riwayat Periksa', 'route' => 'riwayat.periksa', 'roles' => ['dokter', 'pasien']],
        ['label' => 'Riwayat Pembayaran', 'route' => 'riwayat.pembayaran', 'roles' => ['pasien']],
      ]
    ],
    [
      'label' => 'Akun',
      'icon' => '<path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',
      'route' => 'admin.users',
      'roles' => ['admin', 'dokter', 'pasien', 'apoteker', 'kasir'],
    ],
  ];
@endphp

<!-- Sidebar -->
<div id="application-sidebar"
  class="hs-overlay [--auto-close:lg] hs-overlay-open:translate-x-0 -translate-x-full transition-all duration-300 transform hidden fixed top-0 start-0 bottom-0 z-[60] w-64 bg-white border-e border-gray-200 pt-7 pb-10 overflow-y-auto lg:block lg:translate-x-0 lg:end-auto lg:bottom-0 dark:bg-neutral-800 dark:border-neutral-700">
  <div class="px-6">
    <a class="flex-none text-xl font-semibold dark:text-white" href="/" aria-label="Brand">Poliklinik</a>
  </div>

  <nav class="hs-accordion-group p-6 w-full flex flex-col flex-wrap" data-hs-accordion-always-open>
    <ul class="space-y-1.5">
      @foreach($menu as $item)
        @php
          if (!in_array($userRole, $item['roles']))
            continue;

          $hasChildren = isset($item['children']);
          $id = str($item['label'])->slug() . '-accordion';
          $isActive = !$hasChildren && $item['route'] !== '#' && Route::has($item['route']) && Route::is($item['route']);
          $href = ($item['route'] ?? '#') === '#' ? '#' : (Route::has($item['route']) ? route($item['route']) : '#');
        @endphp

        @if(!$hasChildren)
          <li>
            <a class="flex items-center gap-x-3.5 py-2 px-2.5 {{ $isActive ? 'bg-gray-100 dark:bg-neutral-700 text-blue-600 dark:text-white' : 'text-gray-700 hover:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300' }} text-sm rounded-lg"
              href="{{ $href }}">
              <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                {!! $item['icon'] !!}
              </svg>
              {{ $item['label'] }}
            </a>
          </li>
        @else
          <li class="hs-accordion" id="{{ $id }}">
            <button type="button"
              class="hs-accordion-toggle hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-700 rounded-lg hover:bg-gray-100 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:text-neutral-400 dark:hover:text-neutral-300 dark:hs-accordion-active:text-white">
              <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                {!! $item['icon'] !!}
              </svg>
              {{ $item['label'] }}

              <svg class="hs-accordion-active:block ms-auto hidden size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="m18 15-6-6-6 6" />
              </svg>
              <svg class="hs-accordion-active:hidden ms-auto block size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="m6 9 6 6 6-6" />
              </svg>
            </button>

            <div id="{{ $id }}-child"
              class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden">
              <ul class="pt-2 ps-2">
                @foreach($item['children'] as $child)
                  @php
                    if (isset($child['roles']) && !in_array($userRole, $child['roles']))
                      continue;
                    $childHref = ($child['route'] ?? '#') === '#' ? '#' : (Route::has($child['route']) ? route($child['route']) : '#');
                  @endphp
                  <li>
                    <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-700 rounded-lg hover:bg-gray-100 dark:bg-neutral-800 dark:text-neutral-400 dark:hover:text-neutral-300"
                      href="{{ $childHref }}">
                      {{ $child['label'] }}
                    </a>
                  </li>
                @endforeach
              </ul>
            </div>
          </li>
        @endif
      @endforeach

      <li>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
          @csrf
        </form>
        <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-red-600 rounded-lg hover:bg-red-50 dark:text-red-500 dark:hover:bg-red-900/20"
          href="{{ route('logout') }}"
          onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
            <polyline points="16 17 21 12 16 7" />
            <line x1="21" x2="9" y1="12" y2="12" />
          </svg>
          Logout
        </a>
      </li>
    </ul>
  </nav>
</div>
<!-- End Sidebar -->