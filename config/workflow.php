<?php

return [
    'types' => [
        'LAPORAN',
        'REGISTRASI',
        'PERMINTAAN',
    ],
    'statuses' => [
        'DIBUAT',
        'DALAM REVIEW',
        'PROSES',
        'MENUNGGU JAWABAN USER',
        'MENUNGGU TANGGAPAN DINAS',
        'SELESAI',
        'DITOLAK',
    ],
    'categories' => [
        'Teknis',
        'Administrasi',
        'Perizinan',
        'Lainnya',
    ],
    'action_types' => [
        'INIT',
        'REVIEW',
        'DISPOSISI',
        'REPLY',
        'CLOSE',
        'REOPEN',
    ],
    'attachment_types' => [
        'image',
        'document',
        'video',
        'link',
        'others',
    ],
];
