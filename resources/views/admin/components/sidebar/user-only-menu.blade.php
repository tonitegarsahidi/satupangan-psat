{{-- ROLE SPECIFIC MENU -- USER --}}
@if (auth()->user()->hasRole('ROLE_USER'))
    {{-- EXAMPLE MENU HEADER FOR GROUPING --}}
    {{-- @include('admin.components.sidebar.menu-header', ['textMenuHeader' => 'User Only Menu']) --}}
    {{-- USER ONLY MENU --}}
    {{-- @include('admin.components.sidebar.item', [
        'menuId' => 'menu-user-pages',
        'menuText' => 'User',
        'menuUrl' => route('user-page'),
        'menuIcon' => 'bx bx-user',
        'subMenuData' => null,
    ]) --}}

@include('admin.components.sidebar.menu-header', ['textMenuHeader' => 'Laporan Pengaduan'])

@include('admin.components.sidebar.item', [
        'menuId' => 'master-pengaduan',
        'menuText' => 'Laporan Pengaduan',
        'menuUrl' => '#',
        'menuIcon' => 'bx bx-message-square-detail', //check here for the icons https://boxicons.com/cheatsheet
        'subMenuData' => [
            [
                'subMenuText' => 'Lapor Pengaduan',
                'subMenuUrl' => route('admin.laporan-pengaduan.add'),
            ],
            [
                'subMenuText' => 'Histori Laporan Saya',
                'subMenuUrl' => route('admin.laporan-pengaduan.index'),
            ],
        ],
    ])

@endif
