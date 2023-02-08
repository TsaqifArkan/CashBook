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
                $dataBrg[$i]['hpp'] = numfmt_format($this->currencyfmt, $data['hpp']);
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
                'stokAwal' => [
                    'label' => 'Stok Awal Barang',
                    'rules' => 'required|decimal',
                    'errors' => [
                        'required' => 'Jumlah {field} tidak boleh kosong!',
                        'decimal' => '{field} minimal berjumlah 0!'
                    ]
                ],
                'satuan' => [
                    'label' => 'Satuan Barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Pilih salah satu {field}!'
                    ]
                ],
                'hpp' => [
                    'label' => 'HPP',
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
                        'stokAwal' => $this->validation->getError('stokAwal'),
                        'satuan' => $this->validation->getError('satuan'),
                        'hpp' => $this->validation->getError('hpp')
                    ]
                ];
            } else {
                // Insert ke DB
                $inputData = [
                    'nama' => $this->request->getPost('nama'),
                    'stokawal' => $this->request->getPost('stokAwal'),
                    'stok' => $this->request->getPost('stokAwal'),
                    'hpp' => $this->request->getPost('hpp'),
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
            $initStokPost = $this->request->getPost('stokAwal');
            $stokDB = $this->barangModel->builder()->select('stokawal, stok')->where('idbrg', $id)->get()->getResultArray()[0];

            if ($initStokPost != '' || $initStokPost != 0) {
                if ($initStokPost != $stokDB['stokawal']) {
                    $stokNow = $stokDB['stok'] - $stokDB['stokawal'] + $initStokPost;
                } else {
                    $stokNow = $stokDB['stok'];
                }
            }

            $valid = $this->validate([
                'nama' => [
                    'label' => 'Nama Barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!'
                    ]
                ],
                'stokAwal' => [
                    'label' => 'Stok Awal Barang',
                    'rules' => 'required|decimal',
                    'errors' => [
                        'required' => 'Jumlah {field} tidak boleh kosong!',
                        'decimal' => '{field} minimal berjumlah 0!'
                    ]
                ],
                'satuan' => [
                    'label' => 'Satuan Barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Pilih salah satu {field}!'
                    ]
                ],
                'hpp' => [
                    'label' => 'HPP',
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
                        'stokAwal' => $this->validation->getError('stokAwal'),
                        'satuan' => $this->validation->getError('satuan'),
                        'hpp' => $this->validation->getError('hpp')
                    ]
                ];
            } else {
                $updatedData = [
                    'nama' => $this->request->getPost('nama'),
                    'stokawal' => $this->request->getPost('stokAwal'),
                    'stok' => $stokNow,
                    'hpp' => $this->request->getPost('hpp'),
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
            // Set Stok to Null on Jurnal Table
            // $brgOnJur = $this->jurnalModel->builder()->select('idjurnal')->where('fk_idbrg', $id)->get()->getResultArray();
            // foreach ($brgOnJur as $b) {
            //     $upd = ['jumlah' => null];
            //     $this->jurnalModel->update($b['idjurnal'], $upd);
            // }
            // Delete 1 row data
            $this->barangModel->delete($id);
            $msg['flashData'] = 'Data barang berhasil dihapus.';
            echo json_encode($msg);
        }
    }

    public function detail($id = 0)
    {
        $data['title'] = 'Detail Barang';
        $dataBarang = $this->barangModel->builder()->select('nama, stokawal, hpp, fk_idsatuan')->where('idbrg', $id)->get()->getResultArray()[0];
        // Get Each Data
        $data['namaBarang'] = $dataBarang['nama'];
        $stokAwal = $dataBarang['stokawal'];
        $data['stokawalBrg'] = $stokAwal;
        $data['hppBrg'] = numfmt_format($this->currencyfmt, $dataBarang['hpp']);
        $data['namaSat'] = $this->satuanModel->builder()->select('nama')->where('idsatuan', $dataBarang['fk_idsatuan'])->get()->getResultArray()[0]['nama'];
        $detail = $this->jurnalModel->builder()->select('*')->where('fk_idbrg', $id)->get()->getResultArray();
        $saldo = 0;
        foreach ($detail as $i => $d) {
            $idBrg = $d['fk_idbrg'];
            $query = $this->barangModel->builder()->select('*')->where('idbrg', $idBrg)->get()->getResultArray()[0];
            $idSat = $query['fk_idsatuan'];
            $query2 = $this->satuanModel->builder()->select('*')->where('idsatuan', $idSat)->get()->getResultArray()[0];
            // Count StokNow
            $stok = $stokAwal + ($d['jumlah'] * ($d['dk'] == 'D' ? -1 : 1));
            $stokAwal = $stok;
            // Count Saldo
            $total = $d['jumlah'] * $d['harga'];
            $pemasukan = ($d['dk'] == 'D') ? $total : '';
            $pengeluaran = ($d['dk'] == 'K') ? $total : '';
            $saldo += $total * ($d['dk'] == 'D' ? 1 : -1);
            // Forming Array
            $detail[$i]['tanggal'] = date_format(date_create($d['tanggal']), 'd-M-Y');
            $detail[$i]['harga'] = numfmt_format($this->currencyfmt, $d['harga']);
            $detail[$i]['stokNow'] = $stok;
            $detail[$i]['namaBrg'] = $query['nama'];
            $detail[$i]['satBrg'] = $query2['nama'];
            $detail[$i]['pemasukan'] = $pemasukan;
            $detail[$i]['pengeluaran'] = $pengeluaran;
            $detail[$i]['saldo'] = $saldo;
        }
        $data['now'] = date('Y-m');
        $data['data'] = $detail;
        return view('barang/detail', $data);
    }
}