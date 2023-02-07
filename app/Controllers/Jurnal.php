<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\BukukasModel;
use App\Models\JurnalModel;
use App\Models\SatuanModel;


class Jurnal extends BaseController
{
    protected $jurnalModel, $db, $builder, $barangModel, $satuanModel, $bukukasModel;

    public function __construct()
    {
        $this->jurnalModel = new JurnalModel();
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('jurnal');
        $this->barangModel = new BarangModel();
        $this->satuanModel = new SatuanModel();
        $this->bukukasModel = new BukukasModel();
    }

    public function index()
    {
        $data['title'] = 'Jurnal';
        // $data['now'] = date('Y-m') . '-01';
        $data['now'] = date('Y-m-d');
        $dataJurnal = $this->jurnalModel->getJurnal($data['now'], $data['now']);
        $data['data'] = $dataJurnal;
        return view('jurnal/index', $data);
    }

    public function getData()
    {
        if ($this->request->isAJAX()) {
            // Try to implement DateRange
            $awal = $this->request->getPost('awal');
            $akhir = $this->request->getPost('akhir');
            $dataJurnal = $this->jurnalModel->getJurnal($awal, $akhir);
            $data['data'] = $dataJurnal;
            $msg['data'] = view('jurnal/tablejurnal', $data);
            echo json_encode($msg);
        }
    }

    public function jualBeli()
    {
        $data['title'] = 'Transaksi Jual Beli';
        // Get data Barang from DB
        $dataBrg = $this->barangModel->builder()->select('idbrg, nama, stok, hpp, fk_idsatuan')->get()->getResultArray();
        foreach ($dataBrg as $i => $b) {
            $dataSat = $this->satuanModel->builder()->select('nama')->where('idsatuan', $b['fk_idsatuan'])->get()->getResultArray()[0];
            $dataBrg[$i]['namaSat'] = $dataSat['nama'];
        }
        $data['barang'] = $dataBrg;
        return view('jurnal/jualbeli', $data);
    }

    public function validatef1()
    {
        // dd($_POST);
        $tglPost = $this->request->getPost('tanggal');
        $idbrgPost = $this->request->getPost('barang');
        $mutPost = $this->request->getPost('mutasi');
        $jmlPost = $this->request->getPost('jumlah');
        $hargaPost = $this->request->getPost('harga');
        $ketPost = $this->request->getPost('keterangan');

        // dd(isset($idbrgPost), empty($idbrgPost));
        $stokBrg = 0;
        if (!empty($idbrgPost)) {
            $stokBrg = $this->barangModel->find($idbrgPost)['stok'];
            // if ($jmlBrg > $stokBrg) {
            //     $val = $jmlBrg - $stokBrg;
            // } else {
            //     $val = $jmlBrg;
            // }
        }

        if (!empty($tglPost) && !empty($mutPost) && !empty($hargaPost) && (!empty($idbrgPost) || (!empty($ketPost))) && (!empty($idbrgPost) ? !empty($jmlPost) : true)) {
            $dataJSON = $this->request->getPost('tempdata');
            $arrayPost = json_decode($dataJSON, true);
            if (isset($arrayPost)) {
                $stokBrg = $arrayPost['stok'];
            }
            // if (!empty($jmlPost)) {
            //     if ($mutPost == 'D') {
            //         $stokBrg -= $jmlPost;
            //     } else {
            //         $stokBrg += $jmlPost;
            //     }
            // }
        }

        // // dd($_POST, $arrayPost);
        // $idBrg = $this->request->getPost('barang');
        // $dkOpt = $this->request->getPost('mutasi');

        // // Checking stok barang
        $ruleJml = '';
        // $jmlBrg = 0;
        // $val = 0;

        if ($mutPost == 'D') {
            $ruleJml .= "|less_than_equal_to[$stokBrg]";
        }

        $valid = $this->validate([
            'tanggal' => [
                'label' => 'Tanggal',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong!'
                ]
            ],
            'barang' => [
                'label' => 'Barang',
                // 'rules' => 'required_without[keterangan]',
                'rules' => 'required',
                'errors' => [
                    // 'required_without' => 'Pilih salah satu {field} atau isi Keterangan!'
                    'required' => 'Pilih salah satu {field}!'
                ]
            ],
            'jumlah' => [
                'label' => 'Barang',
                'rules' => 'required_without[mutasi]|numeric|greater_than[0]' . $ruleJml,
                'errors' => [
                    'required_without' => 'Pilih salah satu Jenis Transaksi terlebih dahulu!',
                    'numeric' => 'Jumlah {field} hanya dapat berisi angka!',
                    'greater_than' => '{field} tidak boleh berjumlah 0!',
                    'less_than_equal_to' => 'Jumlah {field} tidak boleh melebihi stok! (Stok = ' . $stokBrg . ')'
                ]
            ],
            // 'keterangan' => [
            //     'label' => 'Keterangan',
            //     'rules' => 'required_without[barang]|required_without[jumlah]',
            //     'errors' => [
            //         'required_without' => 'Isi {field} atau pilih salah satu Barang!'
            //     ]
            // ],
            'mutasi' => [
                'label' => 'Jenis Transaksi',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pilih salah satu {field}!'
                ]
            ],
            'harga' => [
                'label' => 'Harga',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong!'
                ]
            ]
        ]);
        if (!$valid) {
            $msg = [
                'error' => [
                    'tanggal' => $this->validation->getError('tanggal'),
                    'barang' => $this->validation->getError('barang'),
                    'jumlah' => $this->validation->getError('jumlah'),
                    // 'keterangan' => $this->validation->getError('keterangan'),
                    'mutasi' => $this->validation->getError('mutasi'),
                    'harga' => $this->validation->getError('harga')
                ]
            ];
        } else {
            $msg['flashData'] = 'Data transaksi berhasil ditambah!';
        }
        echo json_encode($msg);
    }

    public function save()
    {
        // Fetch data from POST
        $dataJSON = $this->request->getPost('successdata');
        $arrayPost = json_decode($dataJSON, true);
        // Array for viewing data in main table - DEPRC since now redirect
        // $kodeArr = [];
        // $akunArr = [];

        // Preparing Array to insert into DB
        // Check whether there's a data in Jurnal Table - Deprec since 06/02/2023 12.30
        // $maxNum = $this->jurnalModel->builder()->selectMax('notrans', 'maxNo')->get()->getResultArray()[0]['maxNo'];
        // $numData = $this->jurnalModel->builder()->selectCount("idjurnal", 'jmlDat')->get()->getResultArray()[0]['jmlDat'];
        // if ($maxNum == '' || $maxNum == null || !isset($maxNum)) {
        //     $noTrans = 1;
        // } else {
        //     $noTrans = $maxNum + 1;
        // }
        $insertData = [];
        foreach ($arrayPost as $d) {
            $idBrg = $d['barang'];
            $jmlBrg = $d['jumlah'];
            $opsiDK = $d['mutasi'];
            $stokDB = $this->barangModel->builder()->select('stok')->where('idbrg', $idBrg)->get()->getResultArray()[0]['stok'];
            $updStok = $stokDB + $jmlBrg * (($opsiDK == 'D') ? -1 : 1);
            $this->barangModel->update($idBrg, ['stok' => $updStok]);
            $arr = [
                'tanggal' => $d['tanggal'],
                'keterangan' => $d['keterangan'],
                'dk' => $d['mutasi'],
                'jumlah' => $d['jumlah'],
                'harga' => $d['harga'],
                // 'notrans' => $noTrans,
                'fk_idbrg' => $d['barang']
            ];
            array_push($insertData, $arr);
            // This one is for main table
            // $query = $this->akunModel->builder()->select('kode, nama')->where('idakun', $d['idakun'])->get()->getResultArray()[0];
            // array_push($kodeArr, $query['kode']);
            // array_push($akunArr, $query['nama']);
        }

        // Insert into DB
        $this->jurnalModel->insertBatch($insertData);
        // $data['data'] = $arrayPost;
        // $data['kode'] = $kodeArr;
        // $data['akun'] = $akunArr;
        // return view('jurnal/index', $data);

        // Creating FlashData Data Succesfully Inserted
        session()->setFlashdata('msg', 'Data transaksi berhasil disimpan.');

        return redirect()->to(base_url('jurnal'));
    }

    public function formAddOther()
    {
        if ($this->request->isAJAX()) {
            $msg['data'] = view('jurnal/modaladdother');
            echo json_encode($msg);
        }
    }

    public function addOther()
    {
        if ($this->request->isAJAX()) {
            $valid = $this->validate([
                'tanggal' => [
                    'label' => 'Tanggal',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!'
                    ]
                ],
                'keterangan' => [
                    'label' => 'Keterangan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!'
                    ]
                ],
                'mutasi' => [
                    'label' => 'Jenis Transaksi',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Pilih salah satu {field}!'
                    ]
                ],
                'harga' => [
                    'label' => 'Harga',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'tanggal' => $this->validation->getError('tanggal'),
                        'keterangan' => $this->validation->getError('keterangan'),
                        'mutasi' => $this->validation->getError('mutasi'),
                        'harga' => $this->validation->getError('harga')
                    ]
                ];
            } else {
                $inputData = [
                    'tanggal' => $this->request->getPost('tanggal'),
                    'keterangan' => $this->request->getPost('keterangan'),
                    'dk' => $this->request->getPost('mutasi'),
                    'harga' => $this->request->getPost('harga')
                ];
                $this->jurnalModel->insert($inputData);
                $msg['flashData'] = 'Data transaksi berhasil ditambah!';
            }
            echo json_encode($msg);
        }
    }

    // public function edit($notra = 0)
    // {
    //     $data['title'] = 'Edit Transaksi';
    //     $query = $this->jurnalModel->builder()->select('*')->where('notrans', $notra)->get()->getResultArray();

    //     foreach ($query as $i => $q) {
    //         $idbrg = $q['fk_idbrg'];
    //         // Get data Barang from DB
    //         $dataBrg = $this->barangModel->builder()->select('nama, fk_idsatuan')->where('idbrg', $idbrg)->get()->getResultArray()[0];
    //         $dataSat = $this->satuanModel->builder()->select('nama')->where('idsatuan', $dataBrg['fk_idsatuan'])->get()->getResultArray()[0];
    //         $query[$i]['namaBar'] = $dataBrg['nama'];
    //         $query[$i]['namaSat'] = $dataSat['nama'];
    //     }
    //     $data['data'] = $query;
    //     return view('jurnal/indexedit', $data);
    // }

    public function formEdit()
    {
        if ($this->request->isAJAX()) {
            // One row of data jurnal
            $id = $this->request->getPost('id');
            // Get Data Jurnal from DB
            $data['trans'] = $this->jurnalModel->find($id);
            // Check whether fk_idbrg is empty or not
            // Data Transaksi selected one barang
            $data['idBar'] = $data['trans']['fk_idbrg'];
            // dd($data['idBar']);
            if (!is_null($data['idBar'])) {
                // Get Data Barang from DB
                $dataBar = $this->barangModel->findAll();
                foreach ($dataBar as $i => $d) {
                    $idsat = $d['fk_idsatuan'];
                    $dataSat = $this->satuanModel->builder()->select('nama')->where('idsatuan', $idsat)->get()->getResultArray()[0]['nama'];
                    $dataBar[$i]['allNamaSat'] = $dataSat;
                }
                $data['barang'] = $dataBar;
                $data['satuan'] = $this->satuanModel->findAll();
                // Get 1 data only
                $data['oneData'] = $this->barangModel->find($data['idBar']);
                $data['stok'] = $data['oneData']['stok'];
                $data['namaSat'] = $this->satuanModel->builder()->select('nama')->where('idsatuan', $data['oneData']['fk_idsatuan'])->get()->getResultArray()[0]['nama'];
            }
            $msg['data'] = view('jurnal/modaledit', $data);
            echo json_encode($msg);
        }
    }

    public function saveEdit()
    {
        if ($this->request->isAJAX()) {
            // Fetch POST Data
            $idJurnalPost = $this->request->getPost('idjurnal');
            $tglPost = $this->request->getPost('tanggal');
            $idbrgPost = $this->request->getPost('barang');
            $stokPost = $this->request->getPost('stok');
            $mutPost = $this->request->getPost('mutasi');
            $jmlPost = $this->request->getPost('jumlah');
            $hargaPost = $this->request->getPost('harga');
            $ketPost = $this->request->getPost('keterangan');

            if (!is_null($idbrgPost)) {
                // Get Mutasi and Jumlah Before Update
                $dataDB = $this->jurnalModel->builder()->select('dk, jumlah')->where('idjurnal', $idJurnalPost)->get()->getResultArray()[0];
                $mutDB = $dataDB['dk'];
                $jmlDB = $dataDB['jumlah'];

                // Configure Stok Barang
                // Misal mutDB = D, mutPost = K, jmlDB = 8, jmlPost = 10
                // ex2 : mutDB = K, mutPost = K, jmlDB = 8, jmlPost = 5
                // $ruleJml = '';
                if ($mutDB != $mutPost || $jmlDB != $jmlPost) {
                    // $stokBrg = $stokPost + $jmlPost * (($mutPost == 'D') ? 1 : -1);
                    if ($mutDB != $mutPost) {
                        if ($mutPost == 'D') {
                            $stokBrg = $stokPost - $jmlDB;
                            $ruleJml = "required|greater_than[0]|numeric|less_than_equal_to[$stokBrg]";
                            $stokNow = $stokPost - $jmlDB - $jmlPost;
                        } else { // Mutasi = 'K'
                            $stokBrg = 0;
                            $stokNow = $stokPost + $jmlDB + $jmlPost;
                        }
                    } else { // $jmlDB != $jmlPost
                        if ($mutPost == 'D') {
                            $stokBrg = $stokPost + $jmlDB;
                            $ruleJml = "required|greater_than[0]|numeric|less_than_equal_to[$stokBrg]";
                            $stokNow = $stokPost + $jmlDB - $jmlPost;
                        } else { // Mutasi = 'K'
                            $stokBrg = 0;
                            $stokNow = $stokPost - $jmlDB + $jmlPost;
                        }
                    }
                } else {
                    $ruleJml = 'permit_empty';
                    $stokNow = $stokPost;
                    $stokBrg = $stokPost;
                }
                $ruleBrg = 'required';
                $ruleKet = 'permit_empty';
            } else {
                $ruleBrg = 'permit_empty';
                $ruleKet = 'required';
                $ruleJml = 'permit_empty';
                $stokBrg = 0;
            }

            // dd($stokBrg, $stokNow);
            $valid = $this->validate([
                'tanggal' => [
                    'label' => 'Tanggal',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!'
                    ]
                ],
                'barang' => [
                    'label' => 'Barang',
                    // 'rules' => 'required_without[keterangan]',
                    'rules' => $ruleBrg,
                    'errors' => [
                        // 'required_without' => 'Pilih salah satu {field} atau isi Keterangan!'
                        'required' => 'Pilih salah satu {field}!',
                        'permit_empty' => '{field} opsional'
                    ]
                ],
                'jumlah' => [
                    'label' => 'Barang',
                    'rules' => $ruleJml,
                    'errors' => [
                        'greater_than' => '{field} tidak boleh berjumlah 0!',
                        'numeric' => 'Jumlah {field} hanya dapat berisi angka!',
                        'less_than_equal_to' => 'Jumlah {field} tidak boleh melebihi stok! (Stok = ' . $stokBrg . ')',
                        'permit_empty' => '{field} opsional'
                    ]
                ],
                'keterangan' => [
                    'label' => 'Keterangan',
                    'rules' => $ruleKet,
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                        'permit_empty' => '{field} opsional'
                    ]
                ],
                'mutasi' => [
                    'label' => 'Jenis Transaksi',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Pilih salah satu {field}!'
                    ]
                ],
                'harga' => [
                    'label' => 'Harga',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'tanggal' => $this->validation->getError('tanggal'),
                        'barang' => $this->validation->getError('barang'),
                        'jumlah' => $this->validation->getError('jumlah'),
                        'keterangan' => $this->validation->getError('keterangan'),
                        'mutasi' => $this->validation->getError('mutasi'),
                        'harga' => $this->validation->getError('harga')
                    ]
                ];
            } else {
                $updatedData = [
                    'tanggal' => $tglPost,
                    'keterangan' => $ketPost,
                    'dk' => $mutPost,
                    'jumlah' => $jmlPost,
                    'harga' => $hargaPost,
                    // 'notrans' => $noTrans,
                    'fk_idbrg' => $idbrgPost
                ];
                $this->jurnalModel->update($idJurnalPost, $updatedData);
                // Update Stok Barang on DB
                if (!is_null($idbrgPost)) {
                    $this->barangModel->update($idbrgPost, ['stok' => $stokNow]);
                }
                $msg['flashData'] = 'Data transaksi berhasil diupdate!';
            }
            echo json_encode($msg);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $idjur = $this->request->getPost('id');
            // Update stok barang terlebih dahulu
            $dataDB = $this->jurnalModel->builder()->select('dk, jumlah, fk_idbrg')->where('idjurnal', $idjur)->get()->getResultArray()[0];
            $mutJur = $dataDB['dk'];
            $jmlJur = $dataDB['jumlah'];
            $idBrg = $dataDB['fk_idbrg'];
            if (!is_null($idBrg)) {
                $stokBrg = $this->barangModel->builder()->select('stok')->where('idbrg', $idBrg)->get()->getResultArray()[0]['stok'];
                $stokNow = $stokBrg + ($jmlJur * ($mutJur == 'D' ? 1 : -1));
                // Update data stok Barang di DB
                $this->barangModel->update($idBrg, ['stok' => $stokNow]);
            }
            // Delete 1 row data
            $this->jurnalModel->delete($idjur);
            $msg['flashData'] = 'Data transaksi berhasil dihapus.';
            echo json_encode($msg);
        }
    }

    public function deleteAll()
    {
        if ($this->request->isAJAX()) {
            $notra = $this->request->getPost('notra');
            // Get all barang from transaksi
            $arrBar = $this->jurnalModel->builder()->select('dk,jumlah,fk_idbrg')->where('notrans', $notra)->get()->getResultArray();
            foreach ($arrBar as $i => $d) {
                $idBrg = $d['fk_idbrg'];
                $jmlBrg = $d['jumlah'];
                $mutasi = $d['dk'];
                $stokBrg = $this->barangModel->builder()->select('stok')->where('idbrg', $idBrg)->get()->getResultArray()[0]['stok'];
                $stokNow = $stokBrg + ($jmlBrg * ($mutasi == 'D' ? 1 : -1));
                $this->barangModel->update($idBrg, ['stok' => $stokNow]);
            }
            // Delete 1 or more row data
            $this->db->query("DELETE FROM jurnal WHERE notrans = $notra");
            // $this->jurnalModel->builder()->deleteBatch()
            $msg['flashData'] = 'Data transaksi berhasil dihapus.';
            echo json_encode($msg);
        }
    }
}