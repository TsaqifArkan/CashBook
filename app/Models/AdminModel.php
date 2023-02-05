<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'idadmin';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['username', 'password', 'namalengkap', 'email', 'saldoawal', 'session_key'];
    protected $useTimestamps = true;
    protected $dateFormat = 'date';
    protected $createdField = '';
    protected $updatedField = '';

    public function cek_session_key($id, $key)
    {
        $result_sk = $this->builder()->select('session_key')->where('idadmin', $id)->get()->getFirstRow('array')['session_key'];
        return password_verify($key, $result_sk);
    }
}