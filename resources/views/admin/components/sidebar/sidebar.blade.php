<!-- Menu -->

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="/" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{asset('assets/img/logo/logo.png')}}" style="width: 45px">
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2">{{ config('app.name', 'SamLaravel') }}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        {{-- DASHBOARD MENU, everyone should have this right?? --}}
        {{-- EXAMPLE MENU WITHOUT SUBMENU --}}
        @include('admin.components.sidebar.item', [
            'menuId' => 'menu-dashboard',
            'menuText' => 'Dashboard',
            'menuUrl' => route('dashboard'),
            'menuIcon' => 'bx bx-cookie', //check here for the icons https://boxicons.com/cheatsheet
            'subMenuData' => null,
        ])

        {{-- =============================================== --}}
        {{-- SAAS SPECIFIC MENU --}}
        {{-- =============================================== --}}
        @if (config('saas.SAAS_ACTIVATED'))
            @include('admin.components.sidebar.saas.package-menu')
        @endif



        {{-- =============================================== --}}
        {{-- ROLE SPECIFIC MENU --}}
        {{-- =============================================== --}}
        @include('admin.components.sidebar.admin-only-menu')
        @include('admin.components.sidebar.supervisor-only-menu')
        @include('admin.components.sidebar.operator-only-menu')
        @include('admin.components.sidebar.user-only-menu')
        @include('admin.components.sidebar.user-business-only-menu')



        {{-- =============================================== --}}
        {{-- ALL USER HAVE THIS MENU --}}
        {{-- =============================================== --}}

        {{-- EXAMPLE MENU HEADER FOR GROUPING --}}
        @include('admin.components.sidebar.menu-header', ['textMenuHeader' => 'Pengaturan Umum'])

        {{-- EXAMPLE MENU WITH SUB MENU --}}
        @include('admin.components.sidebar.item', [
            'menuId' => 'user-settings',
            'menuText' => 'Settings',
            'menuUrl' => '#',
            'menuIcon' => 'bx bx-cog', //check here for the icons https://boxicons.com/cheatsheet
            'subMenuData' => [
                [
                    'subMenuText' => 'User Configuration',
                    'subMenuUrl' => route('user.setting.index'),
                ],
                [
                    'subMenuText' => 'Profile',
                    'subMenuUrl' => route('user.profile.index'),
                ],

                [
                    'subMenuText' => 'Change Password',
                    'subMenuUrl' => route('user.setting.changePassword'),
                ],
            ],
        ])




        {{-- EXAMPLE MENU WITHOUT SUBMENU --}}
        {{-- @include('admin.components.sidebar.item', [
            'menuId' => 'menu-settings', // or you can use Str::random(10),
            'menuText' => 'Change password',
            'menuUrl' => '#',
            'menuIcon' => 'bx bx-key', //check here for the icons https://boxicons.com/cheatsheet
            'subMenuData' => null,
        ]) --}}



    </ul>
</aside>
<!-- / Menu -->
