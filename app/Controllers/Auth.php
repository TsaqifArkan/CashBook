<?php

namespace App\Controllers;

use App\Models\AdminModel;

class Auth extends BaseController
{
    public function index()
    {
        if (session('admin_session.id') && session('admin_session.sesskey')) {
            $model = new AdminModel();
            if ($model->cek_session_key(session('admin_session.id'), session('admin_session.sesskey'))) {
                return redirect()->to(base_url('/'));
            }
        }
        return view('auth/index');
    }

    public function attemptLogin()
    {
        // Fetch POST Form Data
        $uname = $this->request->getPost('username');
        $pass = $this->request->getPost('password');
        // Validation Form
        $valid = $this->validate([
            'username' => [
                'label' => 'Username',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong!'
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong!'
                ]
            ]
        ]);
        if (!$valid) {
            return redirect()->to(base_url('auth'))->withInput()->with('errors', $this->validation->getErrors());
        }
        // Fetch data from Database
        $model = new AdminModel();
        $result = $model->builder()->select('idadmin, username, password')->where('username', $uname)->get()->getFirstRow('array');
        // dd($result);
        // Validity DB Check
        if ($result) {
            if (password_verify($pass, $result['password'])) {
                $key = md5(uniqid());
                $hash = password_hash($key, PASSWORD_DEFAULT);
                $model->update($result['idadmin'], [
                    'session_key' => $hash
                ]);
                session()->setTempdata('admin_session', [
                    'id' => $result['idadmin'],
                    'uname' => $result['username'],
                    'sesskey' => $key
                ], 3600);
                session()->set('ann', date('Y'));
                session()->set('monyear', date('Y-m'));
                return redirect()->to(base_url('/'));
            }
        }
        $err['login'] = 'Username atau Password salah!';
        return redirect()->to(base_url('auth'))->withInput()->with('errors', $err);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('auth'));
    }
}