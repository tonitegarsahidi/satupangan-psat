{{-- ROLE SPECIFIC MENU -- LEADER --}}
@if (auth()->user()->hasAnyRole(['ROLE_LEADER']))
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
