<?php

namespace App\Controllers;

use App\Models\KomikModel;

class Komik extends BaseController
{
    protected $komikModel;
    public function __construct()
    {
        $this->komikModel = new KomikModel();
    }

    public function index()
    {

        // tidak perlu pakai ini karena kita udah membuat method sendiri di KomikModel.php
        // $komik = $this->komikModel->findAll();
        // $data = [
        //     'title' => "Daftar Komik",
        //     'komik' => $komik
        // ];

        // Pakai method Sendiri di Komik Model
        $data = [
            'title' => "Daftar Komik",
            'komik' => $this->komikModel->getKomik()
        ];





        return view('komik/index', $data);
    }

    public function detail($slug)
    {


        $data = [
            'title' => 'Detail Komik',
            'komik' => $this->komikModel->getKomik($slug)

        ];

        // jika  komik tidak ada di tabel
        if (empty($data['komik'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul komik ' . $slug . ' tidak ditemukan.');
        }

        return view('komik/detail', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Form Tambah Data Komik',
        ];

        return view('komik/create', $data);
    }

    public function save()
    {
        // membuat slug 
        // di ci 4 ada nama fungsi untuk membuat slug yaitu url_title
        // value adalah isi nya
        // separator adalah jika ada spasi kita ingin ganti apa. defaultnya adalah -
        // true/false maksudnya pakah semua karakter nya akan di ganti menjadi huruf kecil
        // jika true diganti semua menjadi huruf kecil.
        // dimana paramater nya dalah (valuenya, separator, true/false);
        $slug = url_title($this->request->getVar('judul'), '-', true);

        // Untuk meninssert data kedalam table lagi menggunakan save

        $this->komikModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $this->request->getVar('sampul')
        ]);

        // Menemahkan setFlashData 
        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');

        return redirect()->to('/komik');
    }
}
