<?php

namespace App\Filters;

use App\Models\AdminModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Do something here
        if (session('admin_session.id') && session('admin_session.sesskey')) {
            $model = new AdminModel();
            if ($model->cek_session_key(session('admin_session.id'), session('admin_session.sesskey'))) {
                session()->setTempdata('admin_session', [
                    'id' => session('admin_session.id'),
                    'uname' => session('admin_session.uname'),
                    'sesskey' => session('admin_session.sesskey')
                ], 3600);
                session()->set('ann', date('Y'));
                return;
            }
        }

        return redirect()->to(base_url('auth'));
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}