{{-- ROLE SPECIFIC MENU -- USER --}}
@if (auth()->user()->hasAnyRole(['ROLE_LEADER', 'ROLE_OPERATOR', 'ROLE_SUPERVISOR']))
    @include('admin.components.sidebar.item', [
            'menuId' => 'pengawasan',
            'menuText' => 'Pengawasan',
            'menuUrl' => '#',
            'menuIcon' => 'bx bx-cctv', //check here for the icons https://boxicons.com/cheatsheet
            'subMenuData' => [
                [
                    'subMenuText' => 'Data Pengawasan',
                    'subMenuUrl' => route('pengawasan.index'),
                ],
                // [
                //     'subMenuText' => 'Rekap Pengawasan',
                //     'subMenuUrl' => route('admin.laporan-pengaduan.index'),
                // ],
                // [
                //     'subMenuText' => 'Tindak Lanjut',
                //     'subMenuUrl' => route('admin.laporan-pengaduan.index'),
                // ],
            ],
        ])
@endif
