<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class User extends BaseController
{
    public function index()
    {
        return view('admin/login1');
    }

    public function login()
    {
        $usernya      = $this->request->getPost('txtUser');
        $passwordnya  = md5($this->request->getPost('txtPass'));

        // array untuk menentukan syarat siapa yang login
        $syarat=[
            'username'=>$usernya,
            'password'=>$passwordnya 
        ];
        
        $queryUser    = $this->user->where($syarat)->find();
        

        // membuktikan apakah user ada atau tidak
        //var_dump($queryUser);
        if(count($queryUser)==1){
            // membuat session
            $dataSession=[
                'user' =>$queryUser[0]['username'],
                'nama' =>$queryUser[0]['namauser'],
                'level' =>$queryUser[0]['leveluser'],
                'sudahkahLogin'=>true
            ];
            session()->set($dataSession);
            // jika sudah login akan mengarahkan ke dashboard
            return redirect()->to(site_url('/dashboard'));

        } else {
            //mengembalikan ke halaman login
            return redirect()->to(site_url('/login'))->with('info','<div style="color:red;font-size:16px">Gagal login</div>');
        }
    }
     
    public function logout(){
        // menghapus session
        session()->destroy();
        // mengarahkan ke halaman login
        return redirect()->to(site_url('/login'));
    }
}
