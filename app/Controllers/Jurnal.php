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

        $data['now'] = date('Y-m');
        // $coba = $this->db->query('SELECT * FROM bukukas')->getResultArray();
        // $dataBK = $this->bukukasModel->builder()->
        // dd($coba);
        // if (isset($coba)) {
        // $data['initSaldo'] = 0;
        // } else {

        // }
        // $stillNew = isset($coba);
        // $data['initSaldo'] = 0;
        // $thisyear = $this->yearnow == date('Y');
        // $data['datemin'] = $this->yearnow . '-01';
        // $data['datemax'] = $thisyear ? date('Y-m') : $this->yearnow . '-12';
        // $data['now'] = $thisyear ? date('Y-m') : $data['datemax'];

        // $data['datemin'] = $this->yearnow . '-01-01';
        // $data['datemax'] = $thisyear ? date('Y-m-d') : $this->yearnow . '-12-31';
        // $data['now'] = $thisyear ? date('Y-m-d') : $data['datemax'];
        // $data['data'] = $thisyear ? $this->jurnalModel->getJurnal(date('Y-m-d'), date('Y-m-d')) : $this->jurnalModel->getJurnal($data['datemax'], $data['datemax']);
        // $data['dateawal'] = date_format(date_create("2000-01-01"), 'Y-m-d');

        return view('jurnal/index', $data);
    }

    public function initSaldo()
    {
        if ($this->request->isAJAX()) {
            $initSaldo = $this->request->getPost('initSaldo');
            $valid = $this->validate([
                'initSaldo' => [
                    'label' => 'Saldo Awal',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'initSaldo' => $this->validation->getError('initSaldo')
                    ]
                ];
            } else {
                $inputData = [
                    'nama' => $this->request->getPost('nama'),
                    'stokawal' => $this->request->getPost('stokAwal'),
                    'fk_idsatuan' => $this->request->getPost('satuan')
                ];
                $this->barangModel->insert($inputData);
                $msg['flashData'] = 'Saldo awal berhasil disimpan.';
            }
            echo json_encode($msg);
        }
    }

    public function getData()
    {
        if ($this->request->isAJAX()) {
            // Before implement DateRange
            // $query = $this->jurnalModel->findAll();
            // foreach ($query as $i => $q) {
            //     $query2 = $this->barangModel->builder()->select('nama, fk_idsatuan')->where('idbrg', $q['fk_idbrg'])->get()->getResultArray()[0];
            //     $query3 = $this->satuanModel->builder()->select('nama')->where('idsatuan', $query2['fk_idsatuan'])->get()->getResultArray()[0];
            //     $query[$i]['namaBrg'] = $query2['nama'];
            //     $query[$i]['namaSat'] = $query3['nama'];
            // }
            // $data['data'] = $query;
            // UNTIL THIS LINE

            // Try to implement DateRange
            $bulan = $this->request->getPost('bulan');
            $bulan = $bulan . '-' . date('d');
            // $bulan = '2023-01-01';
            // dd($bulan);
            // $bulan = "2023-01-01";
            // dd($bulan);
            // $awal = $this->request->getPost('awal');
            // $akhir = $this->request->getPost('akhir');

            // Update the table on 02/02/2023
            // Changelog : add total on Jurnal table
            // $data['data'] = $this->jurnalModel->getJurnal($bulan);
            $dataJurnal = $this->jurnalModel->getJurnal($bulan);
            $total = 0;
            foreach ($dataJurnal as $i => $d) {
                $total = $d['jumlah'] * $d['harga'];
                $dataJurnal[$i]['total'] = $total;
            }
            $data['data'] = $dataJurnal;
            // dd($data['data']);

            // Configure Rowspan 
            $data['cRow'] = $this->jurnalModel->builder()->selectCount('created_at', 'countRow')->groupBy('created_at')->get()->getResultArray();
            // dd($data['cRow']);
            // Configure Rowspan by NoTrans
            $data['nRow'] = $this->jurnalModel->builder()->selectCount('notrans', 'noRow')->groupBy('notrans')->get()->getResultArray();
            // dd($data);
            $msg['data'] = view('jurnal/tablejurnal', $data);
            echo json_encode($msg);
        }
    }

    // public function search()
    // {
    //     if ($this->request->isAJAX()) {
    //         $output = '';
    //         $keyword = '';
    //         $keyword = $this->request->getPost('query');
    //         $data = $this->jurnalModel->search_jurnal($keyword);
    //         if (count($data) > 0){
    //             foreach($data as $i => $d){
    //                 '<tr>
    //                     <td>'.$i++.'</td>
    //                     <td>'.$d['tanggal'].'</td>
    //                     <td>'.$d['keterangan'].'</td>
    //                     <td>'.$d[''].'</td>
    //                     '
    //             }
    //         }
    //     }
    // }

    public function transaksi()
    {
        $data['title'] = 'Transaksi Jual/Beli';
        // $data['validation'] = $this->validation;
        // Get data Barang from DB
        $dataBrg = $this->barangModel->builder()->select('idbrg, nama, stok, fk_idsatuan')->get()->getResultArray();
        foreach ($dataBrg as $i => $b) {
            $dataSat = $this->satuanModel->builder()->select('nama')->where('idsatuan', $b['fk_idsatuan'])->get()->getResultArray()[0];
            $dataBrg[$i]['namaSat'] = $dataSat['nama'];
        }
        $data['barang'] = $dataBrg;
        return view('jurnal/transaksi', $data);
    }

    public function other()
    {
        $data['title'] = 'Transaksi Lainnya';
        // $data['validation'] = $this->validation;
        // Get data Barang from DB
        $dataBrg = $this->barangModel->builder()->select('idbrg, nama, stok, fk_idsatuan')->get()->getResultArray();
        foreach ($dataBrg as $i => $b) {
            $dataSat = $this->satuanModel->builder()->select('nama')->where('idsatuan', $b['fk_idsatuan'])->get()->getResultArray()[0];
            $dataBrg[$i]['namaSat'] = $dataSat['nama'];
        }
        $data['barang'] = $dataBrg;
        return view('jurnal/transaksi', $data);
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
                'rules' => 'required_without[mutasi]|greater_than[0]' . $ruleJml,
                'errors' => [
                    'required_without' => 'Pilih salah satu Jenis Transaksi terlebih dahulu!',
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
        // Check whether there's a data in Jurnal Table
        $maxNum = $this->jurnalModel->builder()->selectMax('notrans', 'maxNo')->get()->getResultArray()[0]['maxNo'];
        // $numData = $this->jurnalModel->builder()->selectCount("idjurnal", 'jmlDat')->get()->getResultArray()[0]['jmlDat'];
        if ($maxNum == '' || $maxNum == null || !isset($maxNum)) {
            $noTrans = 1;
        } else {
            $noTrans = $maxNum + 1;
        }
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
                'notrans' => $noTrans,
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

    public function edit($notra = 0)
    {
        $data['title'] = 'Edit Transaksi';
        $query = $this->jurnalModel->builder()->select('*')->where('notrans', $notra)->get()->getResultArray();

        foreach ($query as $i => $q) {
            $idbrg = $q['fk_idbrg'];
            // Get data Barang from DB
            $dataBrg = $this->barangModel->builder()->select('nama, fk_idsatuan')->where('idbrg', $idbrg)->get()->getResultArray()[0];
            $dataSat = $this->satuanModel->builder()->select('nama')->where('idsatuan', $dataBrg['fk_idsatuan'])->get()->getResultArray()[0];
            $query[$i]['namaBar'] = $dataBrg['nama'];
            $query[$i]['namaSat'] = $dataSat['nama'];
        }
        $data['data'] = $query;
        return view('jurnal/indexedit', $data);
    }

    public function formEdit()
    {
        if ($this->request->isAJAX()) {
            // One row of data jurnal
            $id = $this->request->getPost('id');
            // Get Data Jurnal from DB
            $data['trans'] = $this->jurnalModel->find($id);
            // Get Data Barang from DB
            $dataBar = $this->barangModel->findAll();
            foreach ($dataBar as $i => $d) {
                $idsat = $d['fk_idsatuan'];
                $dataSat = $this->satuanModel->builder()->select('nama')->where('idsatuan', $idsat)->get()->getResultArray()[0]['nama'];
                $dataBar[$i]['allNamaSat'] = $dataSat;
            }
            $data['barang'] = $dataBar;
            $data['satuan'] = $this->satuanModel->findAll();
            // Data Transaksi selected one barang
            $data['idBar'] = $data['trans']['fk_idbrg'];
            // Get 1 data only
            $data['oneData'] = $this->barangModel->find($data['idBar']);
            $data['stok'] = $data['oneData']['stok'];
            $data['namaSat'] = $this->satuanModel->builder()->select('nama')->where('idsatuan', $data['oneData']['fk_idsatuan'])->get()->getResultArray()[0]['nama'];
            // dd($data);
            $msg['data'] = view('jurnal/modaledit', $data);
            echo json_encode($msg);
        }
    }

    public function saveEdit()
    {
        if ($this->request->isAJAX()) {
            // dd($_POST);
            // Fetch POST Data
            $idJurnalPost = $this->request->getPost('idjurnal');
            $tglPost = $this->request->getPost('tanggal');
            $idbrgPost = $this->request->getPost('barang');
            $stokPost = $this->request->getPost('stok');
            $mutPost = $this->request->getPost('mutasi');
            $jmlPost = $this->request->getPost('jumlah');
            $hargaPost = $this->request->getPost('harga');
            $ketPost = $this->request->getPost('keterangan');

            // Get Mutasi and Jumlah Before Update
            $dataDB = $this->jurnalModel->builder()->select('dk, jumlah')->where('idjurnal', $idJurnalPost)->get()->getResultArray()[0];
            $mutDB = $dataDB['dk'];
            $jmlDB = $dataDB['jumlah'];

            // Configure Stok Barang
            // Misal mutDB = D, mutPost = K, jmlDB = 8, jmlPost = 10
            // ex2 : mutDB = K, mutPost = K, jmlDB = 8, jmlPost = 5
            $ruleJml = '';
            if ($mutDB != $mutPost || $jmlDB != $jmlPost) {
                // $stokBrg = $stokPost + $jmlPost * (($mutPost == 'D') ? 1 : -1);
                if ($mutDB != $mutPost) {
                    if ($mutPost == 'D') {
                        $stokBrg = $stokPost - $jmlDB;
                        $ruleJml .= "|less_than_equal_to[$stokBrg]";
                        $stokNow = $stokPost - $jmlDB - $jmlPost;
                    } else { // Mutasi = 'K'
                        $stokBrg = 0;
                        $stokNow = $stokPost + $jmlDB + $jmlPost;
                    }
                } else { // $jmlDB != $jmlPost
                    if ($mutPost == 'D') {
                        $stokBrg = $stokPost + $jmlDB;
                        $ruleJml .= "|less_than_equal_to[$stokBrg]";
                        $stokNow = $stokPost + $jmlDB - $jmlPost;
                    } else { // Mutasi = 'K'
                        $stokBrg = 0;
                        $stokNow = $stokPost - $jmlDB + $jmlPost;
                    }
                }
            } else {
                $stokNow = $stokPost;
                $stokBrg = $stokPost;
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
                    'rules' => 'required',
                    'errors' => [
                        // 'required_without' => 'Pilih salah satu {field} atau isi Keterangan!'
                        'required_without' => 'Pilih salah satu {field}!'
                    ]
                ],
                'jumlah' => [
                    'label' => 'Barang',
                    'rules' => 'greater_than[0]|required_with[keterangan]' . $ruleJml,
                    'errors' => [
                        'greater_than' => '{field} tidak boleh berjumlah 0!',
                        'less_than_equal_to' => 'Jumlah {field} tidak boleh melebihi stok! (Stok = ' . $stokBrg . ')'
                    ]
                ],
                // 'keterangan' => [
                //     'label' => 'Keterangan',
                //     'rules' => 'required_without[barang]',
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
                $this->barangModel->update($idbrgPost, ['stok' => $stokNow]);
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
            $stokBrg = $this->barangModel->builder()->select('stok')->where('idbrg', $idBrg)->get()->getResultArray()[0]['stok'];
            $stokNow = $stokBrg + ($jmlJur * ($mutJur == 'D' ? 1 : -1));
            // Update data stok Barang di DB
            $this->barangModel->update($idBrg, ['stok' => $stokNow]);
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