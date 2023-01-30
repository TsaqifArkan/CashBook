<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\JurnalModel;
use App\Models\SatuanModel;

class Barang extends BaseController
{
    protected $barangModel, $db, $builder, $satuanModel, $jurnalModel;

    public function __construct()
    {
        $this->barangModel = new BarangModel();
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('barang');
        $this->satuanModel = new SatuanModel();
        $this->jurnalModel = new JurnalModel();
    }

    public function index()
    {
        $data['title'] = 'Barang';
        return view('barang/index', $data);
    }

    public function getData()
    {
        if ($this->request->isAJAX()) {
            $dataBrg = $this->barangModel->findAll();
            // Get Data Satuan from DB
            foreach ($dataBrg as $i => $data) {
                $idSatuan = $data['fk_idsatuan'];
                $namaSatuan = $this->satuanModel->builder()->select('nama')->where('idsatuan', $idSatuan)->get()->getResultArray()[0]['nama'];
                $dataBrg[$i]['namaSatuan'] = $namaSatuan;
            }
            $data['datas'] = $dataBrg;
            $msg['data'] = view('barang/tablebarang', $data);
            echo json_encode($msg);
        }
    }

    public function formTambah()
    {
        if ($this->request->isAJAX()) {
            // Get Data Satuan from DB
            $data['satuan'] = $this->satuanModel->findAll();
            $msg['data'] = view('barang/modaltambah', $data);
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
                ],
                'stok' => [
                    'label' => 'Stok Barang',
                    'rules' => 'required|is_natural_no_zero',
                    'errors' => [
                        'required' => 'Jumlah {field} tidak boleh kosong!',
                        'is_natural_no_zero' => '{field} minimal berjumlah 1!'
                    ]
                ],
                'satuan' => [
                    'label' => 'Satuan Barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Pilih salah satu {field}!'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama' => $this->validation->getError('nama'),
                        'stok' => $this->validation->getError('stok'),
                        'satuan' => $this->validation->getError('satuan')
                    ]
                ];
            } else {
                // Insert ke DB
                $inputData = [
                    'nama' => $this->request->getPost('nama'),
                    'stok' => $this->request->getPost('stok'),
                    'fk_idsatuan' => $this->request->getPost('satuan')
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
            // Get Data Satuan from DB
            $data['satuan'] = $this->satuanModel->findAll();
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
                ],
                'stok' => [
                    'label' => 'Stok Barang',
                    'rules' => 'required|is_natural_no_zero',
                    'errors' => [
                        'required' => 'Jumlah {field} tidak boleh kosong!',
                        'is_natural_no_zero' => '{field} minimal berjumlah 1!'
                    ]
                ],
                'satuan' => [
                    'label' => 'Satuan Barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Pilih salah satu {field}!'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama' => $this->validation->getError('nama'),
                        'stok' => $this->validation->getError('stok'),
                        'satuan' => $this->validation->getError('satuan')
                    ]
                ];
            } else {
                $updatedData = [
                    'nama' => $this->request->getPost('nama'),
                    'stok' => $this->request->getPost('stok'),
                    'fk_idsatuan' => $this->request->getPost('satuan')
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

    public function detail($id = 0)
    {
        $data['title'] = 'Detail Barang';
        $detail = $this->jurnalModel->builder()->select('*')->where('fk_idbrg', $id)->get()->getResultArray();
        $saldo = 0;
        foreach ($detail as $i => $d) {
            $idBrg = $d['fk_idbrg'];
            $query = $this->barangModel->builder()->select('*')->where('idbrg', $idBrg)->get()->getResultArray()[0];
            $idSat = $query['fk_idsatuan'];
            $query2 = $this->satuanModel->builder()->select('*')->where('idsatuan', $idSat)->get()->getResultArray()[0];
            // Count Saldo
            $total = $d['jumlah'] * $d['harga'];
            $pemasukan = ($d['dk'] == 'D') ? $total : '';
            $pengeluaran = ($d['dk'] == 'K') ? $total : '';
            $saldo += $total * ($d['dk'] == 'D' ? 1 : -1);
            // Forming Array
            $detail[$i]['namaBrg'] = $query['nama'];
            $detail[$i]['satBrg'] = $query2['nama'];
            $detail[$i]['pemasukan'] = $pemasukan;
            $detail[$i]['pengeluaran'] = $pengeluaran;
            $detail[$i]['saldo'] = $saldo;
        }
        $data['data'] = $detail;
        return view('barang/detail', $data);
    }
}