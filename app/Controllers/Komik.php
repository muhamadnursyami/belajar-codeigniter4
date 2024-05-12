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
        // ambil session yang dikirim method save, pada validation
        // komentar session di baris ini, karena kita sudah menaruh di BaseControler.php
        // dan udah bisa dipakai di semua kontroler dan udah ada  jadi nggak perlu
        //pangiil lagi
        // session();

        $data = [
            'title' => 'Form Tambah Data Komik',
            'validation' => session()->getFlashdata('validation') ?? \Config\Services::validation(),
        ];

        return view('komik/create', $data);
    }

    public function save()
    {
        // Validasi input,valiasi berdasarkan name dari inputanya
        if (!$this->validate([
            // pada input judul, judul harus di isi
            // dan judul tidak boleh sama, karena unique
            // jadi ada attribute bernama is_uniqeu
            // yang itu adalah array, dimana kita menetapkan bawah
            // pada tabel komik.judul, bahwa di table komik dan di field
            // judul akan ditetapkan mejadi unique dan tidak boleh sama.
            'judul' => 'required|is_unique[komik.judul]',
            //! kedepannya lebih baik di tulis seperti penulis, jangan seperti judul, supaya lebih jelas
            'penulis' => [
                'rules' => 'required|is_unique[komik.penulis]',
                'errors' => [
                    'required' => '{field} komik harus diisi',
                    'is_unique' => '{field} komik sudah ada'
                ]
            ]
        ])) {
            // Mengambil pesan error dar srevices validation
            // $validation = \Config\Services::validation();
            // dd($validation); untuk melihat& mengecek isi error 

            // yang data  tersebut yaitu withInput
            // akan dikirim ke halaman /komik/create
            // jadi kita perlu menangkap session validation di halaman tersebut.
            session()->setFlashdata('validation', \Config\Services::validation());
            return redirect()->to('/komik/create')->withInput();
        }



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
