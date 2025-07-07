{{-- ROLE SPECIFIC MENU -- ADMIN ONLY --}}
@if (auth()->user()->hasRole('ROLE_ADMIN'))
    {{-- EXAMPLE MENU HEADER FOR GROUPING --}}
    @include('admin.components.sidebar.menu-header', ['textMenuHeader' => 'Admin Menu'])

    {{-- ADMIN ONLY MENU --}}
    {{-- @include('admin.components.sidebar.item', [
    'menuId' => 'menu-user-pages',
    'menuText' => 'Admin Pages',
    'menuUrl' => route('admin-page'),
    'menuIcon' => 'bx bx-food-menu',
    'subMenuData' => null,
]) --}}

    @include('admin.components.sidebar.item', [
        'menuId' => 'menu-operator-pages',
        'menuText' => 'User Management',
        'menuUrl' => route('admin.user.index'),
        'menuIcon' => 'bx bx-group',
        'subMenuData' => null,
    ])

    @include('admin.components.sidebar.menu-header', ['textMenuHeader' => 'Master Data'])
    {{-- EXAMPLE MENU WITH SUB MENU --}}
    @include('admin.components.sidebar.item', [
        'menuId' => 'master-lokasi',
        'menuText' => 'Master Lokasi',
        'menuUrl' => '#',
        'menuIcon' => 'bx bx-food-menu', //check here for the icons https://boxicons.com/cheatsheet
        'subMenuData' => [
            [
                'subMenuText' => 'Master Provinsi',
                'subMenuUrl' => route('admin.master-provinsi.index'),
            ],
            [
                'subMenuText' => 'Master Kabupaten',
                'subMenuUrl' => route('user.profile.index'),
            ],
        ],
    ])


    @include('admin.components.sidebar.item', [
        'menuId' => 'master-bahan-pangan-segar',
        'menuText' => 'Master Bahan',
        'menuUrl' => '#',
        'menuIcon' => 'bx bx-food-menu', //check here for the icons https://boxicons.com/cheatsheet
        'subMenuData' => [
            [
                'subMenuText' => 'Kelompok Pangan',
                'subMenuUrl' => route('admin.master-kelompok-pangan.index'),
            ],
            [
                'subMenuText' => 'Jenis Pangan',
                'subMenuUrl' => route('admin.master-jenis-pangan-segar.index'),
            ],
            [
                'subMenuText' => 'Bahan Pangan',
                'subMenuUrl' => route('admin.master-bahan-pangan-segar.index'),
            ],
        ],
    ])

    @include('admin.components.sidebar.item', [
        'menuId' => 'master-cemaran',
        'menuText' => 'Master Cemaran',
        'menuUrl' => '#',
        'menuIcon' => 'bx bx-food-menu', //check here for the icons https://boxicons.com/cheatsheet
        'subMenuData' => [
            [
                'subMenuText' => 'Mikroba',
                'subMenuUrl' => route('admin.master-cemaran-mikroba.index'),
            ],
            [
                'subMenuText' => 'Logam Berat',
                'subMenuUrl' => route('admin.master-cemaran-logam-berat.index'),
            ],
            [
                'subMenuText' => 'Mikrotoksin',
                'subMenuUrl' => route('admin.master-cemaran-mikrotoksin.index'),
            ],
        ],
    ])


@endif
