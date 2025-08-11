{{-- ROLE SPECIFIC MENU -- USER --}}
@if (auth()->user()->hasAnyRole(['ROLE_USER_BUSINESS', 'ROLE_OPERATOR', 'ROLE_SUPERVISOR']))
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

    @include('admin.components.sidebar.menu-header', ['textMenuHeader' => 'Profil Bisnis'])

    {{-- BUSINESS PROFILE MENU --}}
    @include('admin.components.sidebar.item', [
        'menuId' => 'menu-business-profile',
        'menuText' => 'Profil Bisnis',
        'menuUrl' => route('business.profile.index'),
        'menuIcon' => 'bx bx-building',
        'subMenuData' => null,
    ])

    {{-- REGISTRASI & MASTER DATA --}}
    @include('admin.components.sidebar.menu-header', ['textMenuHeader' => 'QR Code Badan Pangan'])
    {{-- REGISTER SPPB MENU --}}
    @include('admin.components.sidebar.item', [
        'menuId' => 'menu-register-sppb',
        'menuText' => 'QR Badan Pangan',
        'menuUrl' => route('qr-badan-pangan.index'),
        'menuIcon' => 'bx bx-qr',
        'subMenuData' => null,
    ])

    {{-- REGISTRASI & MASTER DATA --}}
    @include('admin.components.sidebar.menu-header', ['textMenuHeader' => 'Kelengkapan Dokumen'])

    @if (auth()->user()->business && !auth()->user()->business->is_umkm)
        {{-- REGISTER SPPB MENU --}}
        @include('admin.components.sidebar.item', [
            'menuId' => 'menu-register-sppb',
            'menuText' => 'Register SPPB',
            'menuUrl' => route('register-sppb.index'),
            'menuIcon' => 'bx bx-file',
            'subMenuData' => null,
        ])

        {{-- REGISTER IZIN EDAR PSATPL MENU --}}
        @include('admin.components.sidebar.item', [
            'menuId' => 'menu-register-izinedar-psatpl',
            'menuText' => 'Izin Edar PL',
            'menuUrl' => route('register-izinedar-psatpl.index'),
            'menuIcon' => 'bx bx-file',
            'subMenuData' => null,
        ])

        {{-- REGISTER IZIN EDAR PSATPD MENU --}}
        @include('admin.components.sidebar.item', [
            'menuId' => 'menu-register-izinedar-psatpd',
            'menuText' => 'Izin Edar PD',
            'menuUrl' => route('register-izinedar-psatpd.index'),
            'menuIcon' => 'bx bx-file',
            'subMenuData' => null,
        ])
    @endif

    {{-- REGISTER IZIN EDAR PSATPDUK MENU --}}
    @include('admin.components.sidebar.item', [
        'menuId' => 'menu-register-izinedar-psatpduk',
        'menuText' => 'Izin Edar PDUK',
        'menuUrl' => route('register-izinedar-psatpduk.index'),
        'menuIcon' => 'bx bx-file',
        'subMenuData' => null,
    ])
@endif
