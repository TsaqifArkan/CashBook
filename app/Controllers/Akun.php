<?php

namespace App\Controllers;

use App\Models\AkunModel;
use App\Models\JurnalModel;

class Akun extends BaseController
{
    protected $akunModel, $db, $builder, $jurnalModel;

    public function __construct()
    {
        $this->akunModel = new AkunModel();
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('akun');
        $this->jurnalModel = new JurnalModel();
    }

    public function index()
    {
        $data['title'] = 'Daftar Akun';
        return view('akun/index', $data);
    }

    public function getData()
    {
        if ($this->request->isAJAX()) {
            $dataAkun = $this->akunModel->findAll();
            // Count Saldo Sekarang
            foreach ($dataAkun as $i => $a) {
                $idakun = $a['idakun'];
                $saldoNow = $a['saldoawal'];
                $dataJurnal = $this->jurnalModel->builder()->select('debit, kredit')->where('fk_idakun', $idakun)->get()->getResultArray();
                foreach ($dataJurnal as $b) {
                    $saldoNow += ($b['debit'] != 0) ? $b['debit'] : $b['kredit'] * -1;
                }
                $dataAkun[$i]['saldonow'] = $saldoNow;
            }
            $data['datas'] = $dataAkun;
            $msg['data'] = view('akun/tableakun', $data);
            echo json_encode($msg);
        }
    }

    public function formTambah()
    {
        if ($this->request->isAJAX()) {
            $msg['data'] = view('akun/modaltambah');
            echo json_encode($msg);
        }
    }

    public function tambah()
    {
        if ($this->request->isAJAX()) {
            $valid = $this->validate([
                'nama' => [
                    'label' => 'Nama Akun',
                    'rules' => 'required|is_unique[akun.nama]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                        'is_unique' => '{field} sudah terdaftar! {field} tidak boleh sama dengan yang sudah terdaftar'
                    ]
                ],
                'kode' => [
                    'label' => 'Kode Akun',
                    'rules' => 'required|is_unique[akun.kode]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                        'is_unique' => '{field} sudah terdaftar! {field} tidak boleh sama dengan yang sudah terdaftar'
                    ]
                ],
                'posisi' => [
                    'label' => 'Posisi',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!'
                    ]
                ],
                'saldoNormal' => [
                    'label' => 'Saldo Normal',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama' => $this->validation->getError('nama'),
                        'kode' => $this->validation->getError('kode'),
                        'posisi' => $this->validation->getError('posisi'),
                        'saldoNormal' => $this->validation->getError('saldoNormal')
                    ]
                ];
            } else {
                // Insert ke DB
                $inputData = [
                    'nama' => $this->request->getPost('nama'),
                    'kode' => $this->request->getPost('kode'),
                    'posisi' => $this->request->getPost('posisi'),
                    'saldonormal' => $this->request->getPost('saldoNormal'),
                    'saldoawal' => $this->request->getPost('saldoAwal'),
                ];
                $this->akunModel->insert($inputData);
                $msg['flashData'] = 'Data akun berhasil ditambahkan.';
            }
            echo json_encode($msg);
        }
    }

    public function formEdit()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $data['akun'] = $this->akunModel->find($id);
            $msg['data'] = view('akun/modaledit', $data);
            echo json_encode($msg);
        }
    }

    public function edit()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            // Get data from DB
            $dataDB = $this->akunModel->builder()->select('nama, kode')->where('idakun', $id)->get()->getResultArray()[0];
            // Get data from POST via FORM
            $postNama = $this->request->getPost('nama');
            $postKode = $this->request->getPost('kode');
            // Conditional Rule
            $rule_nama = ($postNama == $dataDB['nama']) ? 'required' : 'required|is_unique[akun.nama]';
            $rule_kode = ($postKode == $dataDB['kode']) ? 'required' : 'required|is_unique[akun.kode]';
            // Checking Validity
            $valid = $this->validate([
                'nama' => [
                    'label' => 'Nama Akun',
                    'rules' => $rule_nama,
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                        'is_unique' => '{field} sudah terdaftar! {field} tidak boleh sama dengan yang sudah terdaftar'
                    ]
                ],
                'kode' => [
                    'label' => 'Kode Akun',
                    'rules' => $rule_kode,
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                        'is_unique' => '{field} sudah terdaftar! {field} tidak boleh sama dengan yang sudah terdaftar'
                    ]
                ],
                'posisi' => [
                    'label' => 'Posisi',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!'
                    ]
                ],
                'saldoNormal' => [
                    'label' => 'Saldo Normal',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama' => $this->validation->getError('nama'),
                        'kode' => $this->validation->getError('kode'),
                        'posisi' => $this->validation->getError('posisi'),
                        'saldoNormal' => $this->validation->getError('saldoNormal')
                    ]
                ];
            } else {
                $updatedData = [
                    'nama' => $postNama,
                    'kode' => $postKode,
                    'posisi' => $this->request->getPost('posisi'),
                    'saldonormal' => $this->request->getPost('saldoNormal'),
                    'saldoawal' => $this->request->getPost('saldoAwal'),
                ];
                $this->akunModel->update($id, $updatedData);
                $msg['flashData'] = 'Data akun berhasil diupdate.';
            }
            echo json_encode($msg);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            // Delete 1 row data
            $this->akunModel->delete($id);
            $msg['flashData'] = 'Data akun berhasil dihapus.';
            echo json_encode($msg);
        }
    }

    public function detail($id = 0)
    {
        $data['title'] = 'Detail Akun';
        $data['data'] = $this->jurnalModel->builder()->select('*')->where('fk_idakun', $id)->get()->getResultArray();
        $data['init'] = $this->akunModel->builder()->select('saldonormal, saldoawal')->where('idakun', $id)->get()->getResultArray()[0];
        // Count Saldo
        $saldo = $data['init']['saldoawal'];
        foreach ($data['data'] as $i => $d) {
            $saldo += ($d['debit'] != 0) ? $d['debit'] : $d['kredit'] * -1;
            $data['data'][$i]['saldo'] = $saldo;
        }
        return view('akun/detail', $data);
    }
}