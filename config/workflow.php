<?php

return [
    'types' => [
        'LAPORAN' => 'LAPORAN',
        'REGISTRASI' => 'REGISTRASI',
        'PERMINTAAN' => 'PERMINTAAN',
    ],
    'statuses' => [
        'DIBUAT' => 'DIBUAT',
        'DALAM_REVIEW' => 'DALAM REVIEW',
        'PROSES' => 'PROSES',
        'MENUNGGU_JAWABAN' => 'TANGGAPI PELAPOR',
        'MENUNGGU_TANGGAPAN' => 'TANGGAPI',
        'SELESAI' => 'SELESAI',
        'DITOLAK' => 'DITOLAK',
        'DISETUJUI' => 'DISETUJUI',
        'DITUTUP' => 'DITUTUP',
        'DIBATALKAN' => 'DIBATALKAN',
        'DIBUKA_KEMBALI' => 'DIBUKA KEMBALI',
        'DIPINDAHKAN' => 'DIPINDAHKAN',
        'DIARSIPKAN' => 'DIARSIPKAN',
        'TERBIT' => 'TERBIT',
    ],
    'categories' => [
        'TEKNIS' => 'Teknis / Laporan',
        'ADMINISTRASI' => 'Administrasi',
        'PERIZINAN' => 'Perizinan',
        'LAINNYA' => 'Lainnya',
    ],
    'action_types' => [
        'INIT' => 'INIT',
        'REVIEW' => 'REVIEW',
        'DISPOSISI' => 'DISPOSISI',
        'REPLY' => 'REPLY',
        'CLOSE' => 'CLOSE',
        'REOPEN' => 'REOPEN',
    ],
    'attachment_types' => [
        'image' => 'image',
        'document' => 'document',
        'video' => 'video',
        'link' => 'link',
        'others' => 'others',
    ],
];
