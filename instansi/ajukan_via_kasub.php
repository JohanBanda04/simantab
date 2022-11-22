<?php

include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";
session_start();
$nama_unit = $_GET['unit'];
$tgl_minta = $_GET['tgl_minta'];

$tgl_sekarang = date('Y-m-d');

$query_cek_kode_brg = mysqli_query($koneksi,"select * from sementara where unit='$_SESSION[username]' 
and user_id='$_SESSION[user_id]' and tgl_permintaan='$tgl_sekarang'");

$array_cek_4 = array();
while ($dts = mysqli_fetch_array($query_cek_kode_brg)){
    array_push($array_cek_4,$dts['jumlah']);
}

$array_cek = array();
foreach ($array_cek_4 as $val){
    if($val > 4){
        array_push($array_cek,"tidak memenuhi syarat");
    } else if ($val <=4 ){
        array_push($array_cek,"memenuhi syarat");
    }
}

if(in_array("tidak memenuhi syarat",$array_cek)){
    echo '<script language="javascript">alert("Jumlah Kuantitas per Item ada yang melebihi 4 (satuan)");
document.location="index.php?p=formpesan";</script>';
} else {
    $queryJenis = mysqli_query($koneksi, "UPDATE sementara set status_acc='Pengajuan Kasub' where 
id_subbidang=$_SESSION[subbidang_id] and user_id=$_SESSION[user_id] and status_acc='Permintaan Baru'");


    if ($queryJenis) {
        echo '<script language="javascript">alert("Pemberitahuan Kasub berhasil !!!"); document.location="index.php?p=formpesan";</script>';
    } else {
        echo 'error' . mysqli_error($koneksi);
    }
}

//-----------------------------------------------------

//ini query nya dia ngeblast langsung
//$queryJenis = mysqli_query($koneksi, "UPDATE sementara set status_acc='Pengajuan Kasub' where
//id_subbidang=$_SESSION[subbidang_id] and user_id=$_SESSION[user_id] and status_acc='Permintaan Baru'");
//
//
//            if ($queryJenis) {
//                echo '<script language="javascript">alert("Pemberitahuan Kasub berhasil !!!"); document.location="index.php?p=formpesan";</script>';
//            } else {
//                echo 'error' . mysqli_error($koneksi);
//            }






?>
