<?php

namespace App\Models;

use CodeIgniter\Model;

class BukukasModel extends Model
{
    protected $table = 'bukukas';
    protected $primaryKey = 'idbukukas';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['tanggal', 'keterangan', 'pemasukan', 'pengeluaran', 'saldo'];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = '';
    protected $updatedField = '';
}