<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $siswa = [
            [
                'nis' => '0012345678',
                'nama' => 'Andi Pratama',
                'kelas' => 'XI RPL 1',
            ],
            [
                'nis' => '0012345679',
                'nama' => 'Bunga Lestari',
                'kelas' => 'XI RPL 1',
            ],
            [
                'nis' => '0012345680',
                'nama' => 'Citra Dewi',
                'kelas' => 'XI RPL 2',
            ],
        ];

        return view('siswa', ['siswa' => $siswa]);
    }
}
