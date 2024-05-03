<?php

namespace App\Controllers;

class Pages extends BaseController
{



    public function index()
    {
        $data = [
            'title' => 'Home | Muhamad Nur Syami'
        ];

        return view('pages/home', $data);
    }

    public function about()
    {
        $data = [
            'title' => 'About Me'
        ];

        return view('pages/about', $data);
    }

    public function contact()
    {
        $data = [
            'title' => 'Contact Us',
            'alamat' => [
                [
                    'tipe' => 'Rumah',
                    'alamat' => 'Jl abc No 123',
                    'kota' => 'Tanjungpinang'
                ],
                [
                    'tipe' => 'Kantor Tokopedia',
                    'alamat' => 'Kebun Jeruk',
                    'kota' => 'SeiJang'
                ]
            ]
        ];

        return view('pages/contact', $data);
    }
}
