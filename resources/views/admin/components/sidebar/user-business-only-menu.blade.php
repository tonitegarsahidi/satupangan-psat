{{-- ROLE SPECIFIC MENU -- USER --}}
@if (auth()->user()->hasRole('ROLE_USER_BUSINESS'))
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


@endif
