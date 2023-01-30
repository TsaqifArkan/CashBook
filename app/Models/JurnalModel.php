<?php

namespace App\Models;

use CodeIgniter\Model;

class JurnalModel extends Model
{
    protected $table = 'jurnal';
    protected $primaryKey = 'idjurnal';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['tanggal', 'keterangan', 'dk', 'jumlah', 'harga', 'notrans', 'fk_idbrg'];
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

    public function getJurnal($tglawal, $tglakhir)
    {
        // $currencyfmt = numfmt_create('ID_id', NumberFormatter::CURRENCY);
        $db = \Config\Database::connect();

        $q = $db->query("CALL get_jurnal(DATE('$tglawal'), DATE('$tglakhir'))");
        $res = $q->getResultArray();
        // foreach ($res as $i => $d) {
        //     $deb = $res[$i]['debit'];
        //     $kre = $res[$i]['kredit'];

        //     $res[$i]['debit'] = $deb == null ? '-' : numfmt_format($currencyfmt, $deb);
        //     $res[$i]['kredit'] = $kre == null ? '-' : numfmt_format($currencyfmt, $kre);
        //     $res[$i]['saldo'] = numfmt_format($currencyfmt, $res[$i]['saldo']);
        // }

        return $res;
    }
}