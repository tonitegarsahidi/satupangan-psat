{{-- ROLE SPECIFIC MENU -- ADMIN ONLY --}}
@if (auth()->user()->hasRole('ROLE_ADMIN'))
{{-- EXAMPLE MENU HEADER FOR GROUPING --}}
@include('admin.components.sidebar.menu-header', ['textMenuHeader' => 'Admin Menu'])

{{-- ADMIN ONLY MENU --}}
{{-- @include('admin.components.sidebar.item', [
    'menuId' => 'menu-user-pages',
    'menuText' => 'Admin Pages',
    'menuUrl' => route('admin-page'),
    'menuIcon' => 'bx bx-cog',
    'subMenuData' => null,
]) --}}

@include('admin.components.sidebar.item', [
    'menuId' => 'menu-operator-pages',
    'menuText' => 'User Management',
    'menuUrl' => route('admin.user.index'),
    'menuIcon' => 'bx bx-group',
    'subMenuData' => null,
])

@include('admin.components.sidebar.item', [
    'menuId' => 'menu-provinsi-management',
    'menuText' => 'Master Provinsi',
    'menuUrl' => route('admin.master-provinsi.index'),
    'menuIcon' => 'bx bx-map',
    'subMenuData' => null,
])

@include('admin.components.sidebar.item', [
    'menuId' => 'menu-cemaran-mikroba-management',
    'menuText' => 'Master Cemaran Mikroba',
    'menuUrl' => route('admin.master-cemaran-mikroba.index'),
    'menuIcon' => 'bx bx-bug',
    'subMenuData' => null,
])


@include('admin.components.sidebar.item', [
    'menuId' => 'menu-kelompok-pangan-management',
    'menuText' => 'Kelompok Pangan',
    'menuUrl' => route('admin.master-kelompok-pangan.index'),
    'menuIcon' => 'bx bx-food-menu',
    'subMenuData' => null,
])
@include('admin.components.sidebar.item', [
    'menuId' => 'menu-jenis-pangan-segar-management',
    'menuText' => 'Jenis Pangan Segar',
    'menuUrl' => route('admin.master-jenis-pangan-segar.index'),
    'menuIcon' => 'bx bx-food-menu',
    'subMenuData' => null,
])

@include('admin.components.sidebar.item', [
    'menuId' => 'menu-bahan-pangan-segar-management',
    'menuText' => 'Bahan Pangan Segar',
    'menuUrl' => route('admin.master-bahan-pangan-segar.index'),
    'menuIcon' => 'bx bx-food-menu',
    'subMenuData' => null,
])
@endif
