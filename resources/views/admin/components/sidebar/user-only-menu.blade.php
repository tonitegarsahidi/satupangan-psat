{{-- ROLE SPECIFIC MENU -- USER --}}
@if (auth()->user()->hasRole('ROLE_USER') &&
        !auth()->user()->hasAnyRole(['ROLE_USER_BUSINESS']))
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

    @if (!auth()->user()->hasAnyRole(['ROLE_OPERATOR', 'ROLE_SUPERVISOR', 'ROLE_LEADER']))
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
    @else
        @include('admin.components.sidebar.item', [
            'menuId' => 'master-pengaduan',
            'menuText' => 'Laporan Pengaduan',
            'menuUrl' => '#',
            'menuIcon' => 'bx bx-message-square-detail', //check here for the icons https://boxicons.com/cheatsheet
            'subMenuData' => [
                [
                    'subMenuText' => 'List Laporan User',
                    'subMenuUrl' => route('admin.laporan-pengaduan.index'),
                ],
            ],
        ])
    @endif



@endif
