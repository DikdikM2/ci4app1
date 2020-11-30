<?php

namespace App\Controllers;

class Pages extends BaseController
{
    //ketika method index dipanggil maka akan menampilkan view welcome_message
    public function index()
    {
        //membuat data tittle untuk halaman home
        $data = [
            'title' => 'Home | Dikdik Maulana'
        ];
        return view('pages/home', $data);
    }
    public function about()
    {
        //membuat data tittle untuk halaman home
        $data = [
            'title' => 'About Me | Dikdik Maulana'
        ];
        return view('pages/about', $data);
    }
    public function contact()
    {
        //membuat data tittle untuk halaman home
        $data = [
            'title' => 'Contact Us | Dikdik Maulana',
            'alamat' => [
                [
                    'tipe' => 'Rumah',
                    'alamat' => 'Jl Cibangkong'
                ],
                [
                    'tipe' => 'Kantor',
                    'alamat' => 'Jl Kawunglarang'
                ]
            ]
        ];
        return view('pages/contact', $data);
    }

    //--------------------------------------------------------------------

}
