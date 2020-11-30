<?php

namespace App\Controllers;

use \App\Models\KomikModel;
use Config\Validation;

class Komik extends BaseController
{
    // ! selain di controller inisialisasi model nya jg bisa di BaseController agar bisa di pake d semua Controller
    protected $komikModel;
    public function __construct()
    {
        $this->komikModel = new KomikModel();
    }
    public function index()
    {
        //$komik = $this->komikModel->findAll(); //findall sama seperti select all
        $data = [
            'title' => 'Daftar komik | Dikdik Maulana',
            'komik' => $this->komikModel->getKomik()
        ];

        // ? coba konek db tnpa model
        // $db = \Config\Database::connect();
        // $komik = $db->query("SELECT * FROM komik");
        // foreach ($komik->getResultArray() as $row) {
        //     d($row);
        // }
        // ? konek dgn models
        // ditulis resource nya
        // $KomikModel = new \App\Models\KomikModel();
        // ! atau
        //tapi harus di panggil di semua method(misal punya method tambah harus di inisialisasi lgi)
        // $komikModel = new KomikModel();


        return view('komik/index', $data);
    }
    public function detail($slug)
    {
        $data = [
            'title' => 'Detail Komik | Dikdik Maulana',
            'komik' => $this->komikModel->getKomik($slug)
        ];
        // jika kimuk tidak ada di tabel
        if (empty($data['komik'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('judul komik' . $slug . ' tidak ditemukan.');
        }
        return view('komik/detail', $data);
    }
    public function create()
    {
        //!session ini agar bisa diakses di semua controller disimpan di basecontroller
        // session();
        $data = [
            'title' => 'Form Tambah Data Komik | Dikdik Maulana',
            'validation' => \Config\Services::validation()
        ];
        return view('komik/create', $data);
    }
    public function save()
    {
        //!validation input
        if (!$this->validate([
            'judul' => [
                'rules' => 'required|is_unique[komik.judul]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'is_unique' => '{field} sudah terdaftar'
                ]
            ]

        ])) {
            # code...
            $validation = \Config\Services::validation();
            //mengirimkan semua input dan validation
            return redirect()->to('/Komik/create')->withInput()->with('validation', $validation);
        }

        // ? untuk mengambil data dari method apapun
        // dd($this->request->getVar('judul'));

        //    utk save
        //untuk merubah jadi slug
        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $this->request->getVar('sampul')
        ]);

        session()->setFlashData('pesan', 'Data Berhasil Ditambahkan.');
        return redirect()->to('/Komik');
    }
    public function delete($id)
    {
        $this->komikModel->delete($id);
        session()->setFlashData('pesan', 'Data Berhasil Dihapus.');
        return redirect()->to('/komik');
    }
    public function edit($slug)
    {
        $data = [
            'title' => 'Form Ubah Data Komik | Dikdik Maulana',
            'validation' => \Config\Services::validation(),
            'komik' => $this->komikModel->getKomik($slug)
        ];
        return view('komik/edit', $data);
    }
}
