<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\BarangModel;
use App\Models\BukukasModel;
use App\Models\JurnalModel;
use App\Models\SatuanModel;


class Bukukas extends BaseController
{
    protected $jurnalModel, $db, $builder, $barangModel, $satuanModel, $bukukasModel, $adminModel;

    public function __construct()
    {
        $this->bukukasModel = new BukukasModel();
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('bukukas');
        $this->jurnalModel = new JurnalModel();
        $this->barangModel = new BarangModel();
        $this->satuanModel = new SatuanModel();
        $this->adminModel = new AdminModel();
    }

    public function index()
    {
        $data['title'] = 'Buku Kas';
        $now = date('Y-m-d');
        // Fetch data from session
        $id = session('admin_session.id');
        $data['data'] = $this->jurnalModel->getBukuKas($id, $now, $now);
        // dd($data);
        $data['now'] = $now;
        return view('bukukas/index', $data);
    }

    public function getData()
    {
        if ($this->request->isAJAX()) {
            // Try to implement DateRange
            $awal = $this->request->getPost('awal');
            $akhir = $this->request->getPost('akhir');
            // Fetch data from session
            $id = session('admin_session.id');
            $data = $this->jurnalModel->getBukuKas($id, $awal, $akhir);
            // $data['data'] = $data;
            $msg['data'] = view('bukukas/tablebukukas', $data);
            echo json_encode($msg);
        }
    }
}