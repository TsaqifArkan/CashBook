<?php

namespace App\Controllers;

use App\Models\AdminModel;

class Admin extends BaseController
{
    protected $adminModel, $db, $builder;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('admin');
    }

    public function index()
    {
        // Fetch data from session and database
        $id = session('admin_session.id');
        // $uname = session('admin_session.uname');
        $datadb = $this->adminModel->find($id);
        $hour = date('H');
        $dayterm = ($hour > 17) ? "Malam" : (($hour > 11) ? "Siang" : "Pagi");
        $data = [
            'title' => 'Profil Admin',
            'admindata' => $datadb,
            'greet' => $dayterm
        ];
        return view('admin/index', $data);
    }

    public function formEdit()
    {
        if ($this->request->isAJAX()) {
            // Fetch data from session and database
            $id = session('admin_session.id');
            $data['admin'] = $this->adminModel->find($id);
            $msg['data'] = view('admin/modaledit', $data);
            echo json_encode($msg);
        }
    }

    public function edit()
    {
        if ($this->request->isAJAX()) {
            // Fetch data from session
            $id = session('admin_session.id');
            $uname = session('admin_session.uname');
            // Fetch data from URL POST
            $unamePost = $this->request->getPost('username');
            // Cek Username sebelumnya
            $ruleUname = ($uname == $unamePost) ? 'required' : 'required|is_unique[admin.username]';
            $valid = $this->validate([
                'username' => [
                    'label' => 'Username',
                    'rules' => $ruleUname,
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                        'is_unique' => '{field} sudah terdaftar! {field} tidak boleh sama dengan yang sudah terdaftar'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg['errorUsername'] = $this->validation->getError('username');
            } else {
                $updatedData = [
                    'username' => $unamePost,
                    'namalengkap' => $this->request->getPost('namaLengkap'),
                    'email' => $this->request->getPost('email')
                ];
                $this->adminModel->update($id, $updatedData);
                // Update Session
                session()->setTempdata('admin_session.uname', $unamePost, 1800);
                $msg['flashData'] = 'Data admin berhasil diupdate.';
            }
            echo json_encode($msg);
        }
    }

    public function formPass()
    {
        if ($this->request->isAJAX()) {
            $msg['data'] = view('admin/modalpass');
            echo json_encode($msg);
        }
    }

    public function pass()
    {
        if ($this->request->isAJAX()) {
            // Fetch data from session and database
            $id = session('admin_session.id');
            $passDB = $this->adminModel->select('password')->where('idadmin', $id)->get()->getResultArray()[0]['password'];
            // Fetch data from URL POST
            $oldPass = $this->request->getPost('oldPass');
            $newPass = $this->request->getPost('newPass');

            // Check whether inputted oldpass is matches hashed pass
            if (!password_verify($oldPass, $passDB)) {
                $msg = [
                    'error' => [
                        'oldPass' => 'Password salah!'
                    ]
                ];
            } else {
                // Check Validity
                $valid = $this->validate([
                    'newPass' => [
                        'label' => 'Password Baru',
                        'rules' => 'required|min_length[3]',
                        'errors' => [
                            'required' => '{field} tidak boleh kosong!',
                            'min_length' => '{field} minimal 3 karakter!'
                        ]
                    ],
                    'konfPass' => [
                        'label' => 'Konfirmasi Password Baru',
                        'rules' => 'required|matches[newPass]',
                        'errors' => [
                            'required' => '{field} tidak boleh kosong!',
                            'matches' => '{field} tidak sesuai dengan Password Baru!'
                        ]
                    ]
                ]);
                if (!$valid) {
                    $msg = [
                        'error' => [
                            'newPass' => $this->validation->getError('newPass'),
                            'konfPass' => $this->validation->getError('konfPass')
                        ]
                    ];
                } else {
                    // Update to DB
                    $this->adminModel->update($id, ['password' => password_hash($newPass, PASSWORD_DEFAULT)]);
                    $msg['flashData'] = 'Password admin berhasil diupdate.';
                }
            }
            echo json_encode($msg);
        }
    }
}