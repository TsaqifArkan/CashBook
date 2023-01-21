<?php

namespace App\Controllers;

use App\Models\BarangModel;

class Barang extends BaseController
{
    protected $barangModel, $db, $builder;

    public function __construct()
    {
        $this->barangModel = new BarangModel();
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('barang');
    }

    public function index()
    {
        $data['title'] = 'Barang';
        return view('barang/index', $data);
    }

    public function getData()
    {
        if ($this->request->isAJAX()) {
            $data['datas'] = $this->barangModel->findAll();
            $msg['data'] = view('barang/tablebarang', $data);
            echo json_encode($msg);
        }
    }

    public function formTambah()
    {
        if ($this->request->isAJAX()) {
            $msg['data'] = view('barang/modaltambah');
            echo json_encode($msg);
        }
    }

    public function tambah()
    {
        if ($this->request->isAJAX()) {
            $valid = $this->validate([
                'nama' => [
                    'label' => 'Nama Barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!'
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
                $this->barangModel->insert($inputData);
                $msg['flashData'] = 'Data barang berhasil ditambahkan.';
            }
            echo json_encode($msg);
        }
    }

    public function formEdit()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $data['barang'] = $this->barangModel->find($id);
            $msg['data'] = view('barang/modaledit', $data);
            echo json_encode($msg);
        }
    }

    public function edit()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $valid = $this->validate([
                'nama' => [
                    'label' => 'Nama Barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!'
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
                    'nama' => $this->request->getPost('nama')
                ];
                $this->barangModel->update($id, $updatedData);
                $msg['flashData'] = 'Data barang berhasil diupdate.';
            }
            echo json_encode($msg);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            // Delete 1 row data
            $this->barangModel->delete($id);
            $msg['flashData'] = 'Data barang berhasil dihapus.';
            echo json_encode($msg);
        }
    }
}