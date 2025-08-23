  {{-- ROLE SPECIFIC MENU -- PETUGAS --}}
  @if (auth()->user()->hasAnyRole(['ROLE_OPERATOR','ROLE_SUPERVISOR', 'ROLE_LEADER', 'ROLE_ADMIN']))
  {{-- EXAMPLE MENU HEADER FOR GROUPING --}}
  @include('admin.components.sidebar.menu-header', ['textMenuHeader' => 'Petugas Menu'])
  {{-- PETUGAS ONLY MENU --}}
  {{-- @include('admin.components.sidebar.item', [
      'menuId' => 'menu-petugas-pages',
      'menuText' => 'Petugas',
      'menuUrl' => route('petugas-page'),
      'menuIcon' => 'bx bx-user',
      'subMenuData' => null,
  ]) --}}
  {{-- PETUGAS PROFILE MENU --}}
  @include('admin.components.sidebar.item', [
      'menuId' => 'menu-petugas-profile',
      'menuText' => 'Data Saya',
      'menuUrl' => route('petugas.profile.index'),
      'menuIcon' => 'bx bx-id-card',
      'subMenuData' => null,
  ])

{{-- PENGAWASAN MENU --}}
@include('admin.components.sidebar.item', [
    'menuId' => 'menu-peringatan-dini',
    'menuText' => 'Peringatan Dini',
    'menuUrl' => route('early-warning.index'),
    'menuIcon' => 'bx bx-meteor',
    'subMenuData' => null,
])

@include('admin.components.sidebar.menu-header', ['textMenuHeader' => 'Pengawasan'])
{{-- PENGAWASAN MENU --}}
@include('admin.components.sidebar.item', [
    'menuId' => 'menu-pengawasan',
    'menuText' => 'Data Pengawasan',
    'menuUrl' => route('pengawasan.index'),
    'menuIcon' => 'bx bx-cctv',
    'subMenuData' => null,
])
{{-- PENGAWASAN REKAP MENU --}}
@include('admin.components.sidebar.item', [
    'menuId' => 'menu-pengawasan-rekap',
    'menuText' => 'Rekap Pengawasan',
    'menuUrl' => route('pengawasan-rekap.index'),
    'menuIcon' => 'bx bx-bar-chart-square',
    'subMenuData' => null,
])
{{-- PENGAWASAN TINDAKAN MENU --}}
@include('admin.components.sidebar.item', [
    'menuId' => 'menu-pengawasan-tindakan',
    'menuText' => 'Tindakan Pengawasan',
    'menuUrl' => route('pengawasan-tindakan.index'),
    'menuIcon' => 'bx bx-run',
    'subMenuData' => null,
])
@endif
