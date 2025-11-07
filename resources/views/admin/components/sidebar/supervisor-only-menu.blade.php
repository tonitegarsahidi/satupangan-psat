{{-- ROLE SPECIFIC MENU -- SUPERVISOR --}}
@if (auth()->user()->hasRole('ROLE_SUPERVISOR'))
    {{-- EXAMPLE MENU HEADER FOR GROUPING --}}
    {{-- @include('admin.components.sidebar.menu-header', ['textMenuHeader' => 'Supervisor Menu']) --}}
    {{-- OPERATOR ONLY MENU --}}
    {{-- @include('admin.components.sidebar.item', [
        'menuId' => 'menu-operator-pages',
        'menuText' => 'Supervisor',
        'menuUrl' => route('supervisor-page'),
        'menuIcon' => 'bx bx-briefcase-alt',
        'subMenuData' => null,
    ]) --}}
    {{-- PETUGAS PROFILE MENU --}}
    {{-- @include('admin.components.sidebar.item', [
        'menuId' => 'menu-petugas-profile',
        'menuText' => 'Data Saya',
        'menuUrl' => route('petugas.profile.index'),
        'menuIcon' => 'bx bx-id-card',
        'subMenuData' => null,
    ]) --}}
    {{-- PENGAWASAN MENU --}}
    @include('admin.components.sidebar.item', [
        'menuId' => 'menu-pengawasan',
        'menuText' => 'Pengawasan',
        'menuUrl' => '#',
        'menuIcon' => 'bx bx-file',
        'subMenuData' => [
            [
                'subMenuText' => 'Data Pengawasan',
                'subMenuUrl' => route('pengawasan.index'),
            ],
            [
                'subMenuText' => 'Rekap Pengawasan',
                'subMenuUrl' => route('rekap-pengawasan.index'),
            ],
        ],
    ])
    @endif
