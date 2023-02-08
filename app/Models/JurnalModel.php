<?php

namespace App\Models;

use CodeIgniter\Model;
use NumberFormatter;

class JurnalModel extends Model
{
    protected $table = 'jurnal';
    protected $primaryKey = 'idjurnal';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['tanggal', 'keterangan', 'dk', 'jumlah', 'harga', 'fk_idbrg'];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = '';

    public function search_jurnal($query)
    {
        $db = \Config\Database::connect();

        // $query = $this->jurnalModel->findAll();
        //     // dd($query);
        //     foreach ($query as $i => $q) {
        //         $query2 = $this->akunModel->builder()->select('kode, nama')->where('idakun', $q['fk_idakun'])->get()->getResultArray()[0];
        //         $query[$i]['kode'] = $query2['kode'];
        //         $query[$i]['nama'] = $query2['nama'];
        //     }
        //     $data['data'] = $query;

        $search = $db->table('jurnal')->select('*');
        if ($query != '') {
            $search->like('keterangan', $query, 'both', null, true);
            $search->orLike('debit', $query);
            $search->orLike('kredit', $query);
        }
        $search->orderBy('idjurnal', 'ASC');
        return $search->get()->getResultArray();
    }

    public function getJurnal($awal, $akhir)
    {
        $currencyfmt = numfmt_create('ID_id', NumberFormatter::CURRENCY);
        $db = \Config\Database::connect();

        $q = $db->query("CALL get_jurnal(DATE('$awal'), DATE('$akhir'))");
        $res = $q->getResultArray();
        foreach ($res as $i => $d) {
            // $jumlah = (is_null($d['fk_idbrg'])) ? 1 : $d['jumlah'];
            // Non-Ternary Form
            // if (is_null($d['fk_idbrg'])) {
            //     if (is_null($d['jumlah'])) {
            //         $jumlah = 1;
            //     } else {
            //         $jumlah = $d['jumlah'];
            //     }
            // } else {
            //     $jumlah = $d['jumlah'];
            // }
            // Ternary Form - Same as above
            $jumlah = (is_null($d['fk_idbrg']) ? (is_null($d['jumlah']) ? 1 : $d['jumlah']) : $d['jumlah']);
            $total = $jumlah * $d['harga'];
            $res[$i]['tanggal'] = date_format(date_create($d['tanggal']), "d-M-Y");
            $res[$i]['total'] = numfmt_format($currencyfmt, $total);
            $res[$i]['harga'] = numfmt_format($currencyfmt, $d['harga']);
        }
        return $res;
    }

    public function getBukuKas($id = 0, $awal, $akhir)
    {
        $adminModel = new AdminModel();
        $brgModel = new BarangModel();
        $currencyfmt = numfmt_create('ID_id', NumberFormatter::CURRENCY);

        // Initial Step
        $saldo = $adminModel->builder()->select('saldoawal')->where('idadmin', $id)->get()->getResultArray()[0]['saldoawal'];
        // Hanya untuk menghitung Saldo Sebelumnya saja! | First Step
        $query = $this->builder()->select('dk, jumlah, harga, fk_idbrg')->where('tanggal <', $awal)->orderBy('tanggal ASC, idjurnal ASC')->get()->getResultArray();
        foreach ($query as $i => $q) {
            // $jumlah = (is_null($q['fk_idbrg'])) ? 1 : $q['jumlah'];
            $jumlah = (is_null($q['fk_idbrg']) ? (is_null($q['jumlah']) ? 1 : $q['jumlah']) : $q['jumlah']);
            // $total = $jumlah * $q['harga'] * (($q['dk'] == 'D') ? 1 : -1);
            $total = $jumlah * $q['harga'];
            // $saldoNow = $saldo + $total;
            $saldoNow = (($q['dk'] == 'D') ? ($saldo + $total) : ($saldo - $total));
            $saldo = $saldoNow;
            $query[$i]['total1'] = $total;
            $query[$i]['saldo1'] = $saldoNow;
        }
        $res['saldoA'] = numfmt_format($currencyfmt, $saldo);

        // Saldo Date Range | Second Step
        $query2 = $this->builder()->select('tanggal, keterangan, dk, jumlah, harga, fk_idbrg')->where("tanggal BETWEEN '$awal' AND '$akhir'")->orderBy('tanggal ASC, idjurnal ASC')->get()->getResultArray();
        $sumAllDeb = 0;
        $sumAllKre = 0;
        foreach ($query2 as $i => $q) {
            // $jumlah = (is_null($q['fk_idbrg'])) ? 1 : $q['jumlah'];
            $jumlah = (is_null($q['fk_idbrg']) ? (is_null($q['jumlah']) ? 1 : $q['jumlah']) : $q['jumlah']);
            // $total = $jumlah * $q['harga'] * (($q['dk'] == 'D') ? 1 : -1);
            $total = $jumlah * $q['harga'];
            if ($q['dk'] == 'D') {
                $sumAllDeb += $total;
            } else {
                $sumAllKre += $total;
            }
            // $saldoNow = $saldo + $total;
            $saldoNow = (($q['dk'] == 'D') ? ($saldo + $total) : ($saldo - $total));
            $saldo = $saldoNow;

            // Configure Keterangan
            if (is_null($q['fk_idbrg'])) {
                $ket = $q['keterangan'];
            } else {
                $idbar = $q['fk_idbrg'];
                $nmbar = $brgModel->builder()->select('nama')->where('idbrg', $idbar)->get()->getResultArray()[0]['nama'];
                $ket = $nmbar;
            }
            $query2[$i]['tanggal'] = date_format(date_create($q['tanggal']), "d-M-Y");
            $query2[$i]['ket'] = $ket;
            $query2[$i]['total2'] = numfmt_format($currencyfmt, $total);
            $query2[$i]['saldo2'] = numfmt_format($currencyfmt, $saldoNow);
        }
        $res['totDeb'] = $sumAllDeb;
        $res['totKre'] = $sumAllKre;
        $res['saldoN'] = $saldo;
        $res['data'] = $query2;
        return $res;
    }
}