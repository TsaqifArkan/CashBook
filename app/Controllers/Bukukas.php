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
        $data['now'] = $now;
        $data['currfmt'] = $this->currencyfmt;
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
            // dd($data);
            // $data['data'] = $data;
            $data['currfmt'] = $this->currencyfmt;
            $msg['data'] = view('bukukas/tablebukukas', $data);
            // dd($msg);
            echo json_encode($msg);
        }
    }

    public function print($awal, $akhir)
    {
        // Fetch data from session
        $id = session('admin_session.id');

        // Forming Filename
        $filename = date('YmdHis') . '_BukuKas_' . $awal . '-' . $akhir . '.xlsx';
        // Query - Get Data
        $dataKas = $this->jurnalModel->getBukuKas($id, $awal, $akhir);
        // dd($dataKas);
        $dataInti = $dataKas['data'];
        // Configure Saldo Before
        $i = 0;
        $salb4 = [
            [
                '<style border="#000000"><center>' . intval($i) . '</center></style>',
                '<style border="#000000">' . null . '</style>',
                '<style border="#000000">Saldo Sebelumnya</style>',
                '<style border="#000000">' . null . '</style>',
                '<style border="#000000">' . null . '</style>',
                '<style border="#000000"><right>' . $dataKas['saldoA'] . '</right></style>'
            ]
        ];
        // Configure Main Data
        if (!empty($dataInti)) {
            $newArray1 = [];
            foreach ($dataInti as $i => $data) {
                $dataInti[$i]['no'] = '<style border="#000000"><center>' . intval($i + 1) . '</center></style>';
                // Tanggal and Keterangan no changes - just styling
                $dataInti[$i]['tanggal'] = '<style border="#000000"><center>' . $data['tanggal'] . '</center></style>';
                $dataInti[$i]['keterangan'] = '<style border="#000000">' . $data['ket'] . '</style>';
                $dataInti[$i]['pemasukan'] = $data['dk'] == 'D' ? '<style border="#000000"><right>' . $data['total2'] . '</right></style>' : '<style border="#000000">-</style>';
                $dataInti[$i]['pengeluaran'] = $data['dk'] == 'K' ? '<style border="#000000"><right>' . $data['total2'] . '</right></style>' : '<style border="#000000">-</style>';
                // Saldo no changes - just styling
                $dataInti[$i]['saldo2'] = '<style border="#000000"><right>' . $data['saldo2'] . '</right></style>';
                $newArray2 = [];
                array_push($newArray2, $dataInti[$i]['no']);
                array_push($newArray2, $dataInti[$i]['tanggal']);
                array_push($newArray2, $dataInti[$i]['keterangan']);
                array_push($newArray2, $dataInti[$i]['pemasukan']);
                array_push($newArray2, $dataInti[$i]['pengeluaran']);
                array_push($newArray2, $dataInti[$i]['saldo2']);
                array_push($newArray1, $newArray2);
            }
        } else {
            $i = -1;
        }
        $title = [
            ['<style height="30" bgcolor="#DDDDDD"><middle><center><b>BUKU KAS BUMDES TLOGOSARI</b></center></middle></style>', null, null, null, null, null],
            ['<style bgcolor="#DDDDDD"><center><b>PERIODE ' . date_format(date_create($awal), 'd-m-Y') . ' - ' . date_format(date_create($akhir), 'd-m-Y') . '</b></center></style>', null, null, null, null, null],
            [null, null, null, null, null, null]
        ];
        $lenTle = count($title);
        $header = [
            [
                '<style border="#000000" bgcolor="#DDDDDD" height="24"><middle><center><b>No</b></center></middle></style>',
                '<style border="#000000" bgcolor="#DDDDDD" height="24"><middle><center><b>Tanggal</b></center></middle></style>',
                '<style border="#000000" bgcolor="#DDDDDD" height="24"><middle><center><b>Keterangan</b></center></middle></style>',
                '<style border="#000000" bgcolor="#DDDDDD" height="24"><middle><center><b>Pemasukan</b></center></middle></style>',
                '<style border="#000000" bgcolor="#DDDDDD" height="24"><middle><center><b>Pengeluaran</b></center></middle></style>',
                '<style border="#000000" bgcolor="#DDDDDD" height="24"><middle><center><b>Saldo</b></center></middle></style>'
            ]
        ];

        // BG Color on Laba/Rugi Section
        if ($dataKas['totDeb'] < $dataKas['totKre']) {
            $rugi = $dataKas['totKre'] - $dataKas['totDeb'];
            $bgcolred = 'bgcolor="#EB455F"';
            $bgcolgreen = '';
            $laba = 0;
        } elseif ($dataKas['totDeb'] > $dataKas['totKre']) {
            $laba = $dataKas['totDeb'] - $dataKas['totKre'];
            $bgcolgreen = 'bgcolor="#46C2CB"';
            $bgcolred = '';
            $rugi = 0;
        } else {
            $laba = 0;
            $rugi = 0;
            $bgcolred = '';
            $bgcolgreen = '';
        }
        $footer = [
            [
                '<style border="#000000"><center><b>Total</b></center></style>',
                '<style border="#000000">' . null . '</style>',
                '<style border="#000000">' . null . '</style>',
                '<style border="#000000"><right><b>' . numfmt_format($this->currencyfmt, $dataKas['totDeb']) . '</b></right></style>',
                '<style border="#000000"><right><b>' . numfmt_format($this->currencyfmt, $dataKas['totKre']) . '</b></right></style>',
                '<style border="#000000"><right><b>' . numfmt_format($this->currencyfmt, $dataKas['saldoN']) . '</b></right></style>'
            ],
            [
                '<style border="#000000"><center><b>Laba / Rugi</b></center></style>',
                '<style border="#000000">' . null . '</style>',
                '<style border="#000000">' . null . '</style>',
                '<style border="#000000" ' . $bgcolred . '><right><b>' . numfmt_format($this->currencyfmt, $rugi) . '</b></right></style>',
                '<style border="#000000" ' . $bgcolgreen . '><right><b>' . numfmt_format($this->currencyfmt, $laba) . '</b></right></style>',
                '<style border="#000000"></style>',
            ]
        ];
        $merged = array_merge($title, $header, $salb4, (empty($dataInti) ? array() : $newArray1), $footer);
        $cellTle = 'A1:F1';
        $cellPer = 'A2:F2';
        $cellTot = 'A' . intval($i + 4 + $lenTle) . ':C' . intval($i + 4 + $lenTle);
        $cellLR = 'A' . intval($i + 5 + $lenTle) . ':C' . intval($i + 5 + $lenTle);
        // dd($i, $cellTle, $cellPer, $cellTot, $cellLR);
        // dd($merged);
        // Output data into a file
        $xlsx = \Shuchkin\SimpleXLSXGen::fromArray($merged);
        $xlsx->setColWidth(1, 8)->setColWidth(2, 16)->mergeCells($cellTle)->mergeCells($cellPer)->mergeCells($cellTot)->mergeCells($cellLR)->downloadAs($filename);
    }
}