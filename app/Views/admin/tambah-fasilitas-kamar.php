<?=$this->extend('admin/dashboard');?>
<?=$this->section('Konten');?>

<h2><?=$JudulHalaman;?></h2>
<?=$introText;?>

<form method="POST" action="<?=site_url('/tambah-fasilitas-kamar');?>" enctype="multipart/form-data">

<div class="form-group">
    <label class="font-weight-bold">Nama Fasilitas</label>
    <input type="text" name="txtNamaFasilitas" class="form-control"/>
</div>

<div class="form-group">
    <label class="font-weight-bold">Deskripsi Fasilitas</label>
    <textarea class="form-control" name="txtDeskripsiFasilitas" rows="5"></textarea>
</div>

<div class="form-group">
    <label class="font-weight-bold">Foto Fasilitas</label>
    <input type="file" name="txtFotoFasilitas" class="form-control"/>
</div>

<div class="form-group">
<!-- <button class="btn btn-warning btn-sm" OnClick="javascipt:history.back()">Batal</button> -->
<a href="javascript:history.back()" class="btn btn-warning btn-sm font-weight-bold">Batal</a>
    <button class="btn btn-primary">Simpan Data</button>
    
</div>

</form>
<?=$this->endSection();?>