<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Fasilitashotel extends BaseController
{
    public function index()
    {
        // membuat data dengan index JudulHalaman dan mengirim ke views
        $data['JudulHalaman']='Fasilitas Hotel';

        //  membuat data dengan index introText JudulHalaman dan mengirim ke views
        $data['introText']='<p>Berikut ini adalah daftar fasilitas hotel, 
        silahkan lakukan pengelolaan fasilitas hotel</p>';
        // 3. Mengambil data fasilitas dari mysql	
         $data['listFasilitas']=$this->fasilitashotel->find();

        // 4. Me-load view tampil-fasilitas-hotel dan mengirim

        // memanggil file tampil-fasilitas-hotel.php di folder app\views\admin
        return view('admin/tampil-fasilitas-hotel', $data);
        
    }

    public function tambah(){
        // membuat data
        $data['JudulHalaman']='Penambahan Fasilitas Hotel'; 
        $data['introText']='<p>Silahkan masukkan data fasilitas hotel pada form dibawah ini!</p>';

        // load helper form 
        helper(['form']);
        // buat aturan form
        $aturanform=[
              'txtNamaFasilitas'=>'required',
              'txtDeskripsiFasilitas'=>'required'
        ];
         // mengecek apakah tombol simpan diklik
        if($this->validate($aturanform)){

            // proses upload
          $foto=$this->request->getFile('txtFotoFasilitas');
          $foto->move('uploads');


            // menyiapkan data yang akan disimpan ke mysql
            $data=[
                'nama_fasilitas'=> $this->request->getPost('txtNamaFasilitas'),
                'deskripsi_fasilitas'=> $this->request->getPost('txtDeskripsiFasilitas'),
                'foto_fasilitas'=>$foto->getClientName()
            ];
            // menyimpan ke mysql tabel tbl_fasilitas_hotel
            $this->fasilitashotel->save($data);
            // mengarahkan ke halaman /fasilitas-hotel dengan membawa pesan sukses 
            return redirect()->to(site_url('/fasilitas-hotel'))->with('info',
            '<div class="alert alert-success">Data berhasil disimpan</div>');

            

        }
        // menampilkan form tambah fasilitas hotel
        return view('admin/tambah-fasilitas-hotel', $data);
    }
    
    public function hapus($id_fasilitas_hotel){
        // 1. Menenetukan primary key dari data yang akan dihapus
        $syarat=[
        'id_fasilitas_hotel'=>$id_fasilitas_hotel
        ];
        
        // 2. Ambil detail untuk mengambil nama file yang akan dihapus
               $fileInfo=$this->fasilitashotel->where($syarat)->find()[0];
        
        if(file_exists('uploads/'.$fileInfo['foto_fasilitas']))
        {
        // 3. Menghapus file foto
        unlink('uploads/'.$fileInfo['foto_fasilitas']);
        
        // 4. Menghapus data fasiltias di mysql
        $this->fasilitashotel->where($syarat)->delete();
        
        // 5. Kembali ke tampil fasilitas       	 
        return redirect()->to(site_url('/fasilitas-hotel'))->with('info','<div class="alert alert-success">Data berhasil dihapus</div>');
        }
    }
        
    public function edit($id_fasilitas_hotel=null){
   	 
        // 1. Menyiapakan judulHalaman dan intro text
        
        $data['JudulHalaman']='Perubahan Fasilitas Hotel';
        $data['introText']='<p>Untuk merubah data fasilitas hotel silahkan lakukan perubahan pada form dibawah ini</p>';
        
        // 2. hanya dijalankan ketika memilih tombol edit
        if($id_fasilitas_hotel!=null){
        
        // mencari data fasilitas berdasarkan primary key
        $syarat=[
        'id_fasilitas_hotel' => $id_fasilitas_hotel
        ];
                    $data['detailFasilitasHotel']=$this->fasilitashotel->where($syarat)->find()[0];
        }
        
        // 3. loading helper form
        helper(['form']);
                
        // 4. mengatur form
        $aturanForm=[
                    'txtNamaFasilitas'=>'required',
                    'txtDeskripsiFasilitas'=>'required'
        ];
        
        // 5. dijalankan saat tombol update ditekan 
        //    dan semua kolom diisi
        
        if($this->validate($aturanForm)){
        
        $foto=$this->request->getFile('txtFotoFasilitas');
        // jika foto di ganti
        if($foto->isValid()){
        $foto->move('uploads');
        $data=[
        'nama_fasilitas'=> $this->request->getPost('txtNamaFasilitas'),
        'deskripsi_fasilitas' => $this->request->getPost('txtDeskripsiFasilitas'),
        'foto_fasilitas'=> $foto->getClientName()
        ];
                        unlink('uploads/'.$this->request->getPost('txtFotoFasilitas'));
        } else {
        // jika foto tidak diganti
        $data=[
        'nama_fasilitas'=> $this->request->getPost('txtNamaFasilitas'),
        'deskripsi_fasilitas' => $this->request->getPost('txtDeskripsiFasilitas')
        ];
        }
                    
        // update fasilitas hotel        	
        
        $this->fasilitashotel->update($this->request->getPost('txtIdFasilitasHotel'),$data);
        
        // redirect ke fasilitas-hotel 
        return 
        redirect()->to(site_url('/fasilitas-hotel'))->with('info','<div class="alert alert-success">Data berhasil diupdate</div>');
        }
                
        return view('admin/edit-fasilitas-hotel',$data);
                
    }

    public function tampilDiHome(){
    	$data['JudulHalaman']='Fasilitas Hotel';
    	$data['listFasilitas']=$this->fasilitashotel->find();
    	$data['introText']='<p>Berikut ini adalah fasilitas hotel yang tersedia untuk para tamu hotel</p>';

    	return view('home-fasilitas-hotel',$data);
    }

        
}
