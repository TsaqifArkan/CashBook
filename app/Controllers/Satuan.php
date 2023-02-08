<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\SatuanModel;

class Satuan extends BaseController
{
    protected $satuanModel, $db, $builder, $brgModel;

    public function __construct()
    {
        $this->satuanModel = new SatuanModel();
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('satuan');
        $this->brgModel = new BarangModel();
    }

    public function index()
    {
        $data['title'] = 'Satuan';
        return view('satuan/index', $data);
    }

    public function getData()
    {
        if ($this->request->isAJAX()) {
            $data['datas'] = $this->satuanModel->findAll();
            // Configure Delete Button
            $fkidsat = $this->brgModel->builder()->select('fk_idsatuan')->groupBy('fk_idsatuan')->get()->getResultArray();
            $usedSat = [];
            foreach ($fkidsat as $f) {
                $usedSat[$f['fk_idsatuan']] = true;
            }
            $data['usedSat'] = $usedSat;
            // dd($fkidsat, $usedSat, $data);
            $msg['data'] = view('satuan/tablesatuan', $data);
            echo json_encode($msg);
        }
    }

    public function formTambah()
    {
        if ($this->request->isAJAX()) {
            $msg['data'] = view('satuan/modaltambah');
            echo json_encode($msg);
        }
    }

    public function tambah()
    {
        if ($this->request->isAJAX()) {
            $valid = $this->validate([
                'nama' => [
                    'label' => 'Nama Satuan',
                    'rules' => 'required|is_unique[satuan.nama]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                        'is_unique' => '{field} sudah terdaftar! {field} tidak boleh sama dengan yang sudah terdaftar'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama' => $this->validation->getError('nama')
                    ]
                ];
            } else {
                // Insert ke DB
                $inputData = [
                    'nama' => $this->request->getPost('nama')
                ];
                $this->satuanModel->insert($inputData);
                $msg['flashData'] = 'Data satuan berhasil ditambahkan.';
            }
            echo json_encode($msg);
        }
    }

    public function formEdit()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $data['satuan'] = $this->satuanModel->find($id);
            $msg['data'] = view('satuan/modaledit', $data);
            echo json_encode($msg);
        }
    }

    public function edit()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            // Get data from URL POST
            $namaPost = $this->request->getPost('nama');
            // Get data from DB
            $namaDB = $this->satuanModel->builder()->select('nama')->where('idsatuan', $id)->get()->getResultArray()[0]['nama'];
            // Conditional Rule
            $rule_nama = ($namaPost == $namaDB) ? 'required' : 'required|is_unique[satuan.nama]';
            $valid = $this->validate([
                'nama' => [
                    'label' => 'Nama Satuan',
                    'rules' => $rule_nama,
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                        'is_unique' => '{field} sudah terdaftar! {field} tidak boleh sama dengan yang sudah terdaftar'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama' => $this->validation->getError('nama')
                    ]
                ];
            } else {
                $updatedData = [
                    'nama' => $namaPost
                ];
                $this->satuanModel->update($id, $updatedData);
                $msg['flashData'] = 'Data satuan berhasil diupdate.';
            }
            echo json_encode($msg);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            // Delete 1 row data
            $this->satuanModel->delete($id);
            $msg['flashData'] = 'Data satuan berhasil dihapus.';
            echo json_encode($msg);
        }
    }
}