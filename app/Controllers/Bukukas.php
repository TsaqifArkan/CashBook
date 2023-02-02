<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\BukukasModel;
use App\Models\JurnalModel;
use App\Models\SatuanModel;


class Bukukas extends BaseController
{
    protected $jurnalModel, $db, $builder, $barangModel, $satuanModel, $bukukasModel;

    public function __construct()
    {
        $this->bukukasModel = new BukukasModel();
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('bukukas');
        $this->jurnalModel = new JurnalModel();
        $this->barangModel = new BarangModel();
        $this->satuanModel = new SatuanModel();
    }

    public function index()
    {
        $data['title'] = 'Buku Kas';
        // $data['now'] = date('Y-m');
        return view('bukukas/index', $data);
    }

    public function getData()
    {
        if ($this->request->isAJAX()) {
            $kasData = $this->bukukasModel->findAll();
            // $dataBrg = $this->barangModel->findAll();
            // Get Data Satuan from DB
            // foreach ($dataBrg as $i => $data) {
            //     $idSatuan = $data['fk_idsatuan'];
            //     $namaSatuan = $this->satuanModel->builder()->select('nama')->where('idsatuan', $idSatuan)->get()->getResultArray()[0]['nama'];
            //     $dataBrg[$i]['namaSatuan'] = $namaSatuan;
            // }
            $data['datas'] = $kasData;
            $msg['data'] = view('bukukas/tablebukukas', $data);
            echo json_encode($msg);
        }
    }
}