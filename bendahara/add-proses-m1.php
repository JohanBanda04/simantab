<?php  

include "../fungsi/koneksi.php";

if(isset($_POST['simpan'])) {

    //lanjut disini
	$kode_brg = $_POST['kode_brg'];
	$id_jenis = $_POST['id_jenis'];
	$nama_brg = $_POST['nama_brg'];
	$hargabarang = preg_replace('/[Rp.]/', '', $_POST['hargabarang']);
	$satuan = $_POST['satuan'];

		//die($stok);

//    echo $kode_brg."::";
//    echo $id_jenis."::";
//    echo $nama_brg."::";
//    echo $hargabarang."::";
//    echo $satuan."::";

    $query_cek_bk_1 = mysqli_query($koneksi,"select * from stokbarang where kode_brg='$kode_brg'");
    $query_cek = mysqli_query($koneksi,"select * from stokbarang where kode_brg='$kode_brg' or nama_brg='$nama_brg'");
    if(mysqli_num_rows($query_cek) > 0){
//        echo "Kode Barang Sudah Ada";
//        index.php?p=material-m1&id_jenis=1&pas=atk
        echo "<script>window.alert('Maaf Kode Barang Sudah Ada')
		window.location='index.php?p=material-m1&&id_jenis=1&pas=atk'</script>";
    } else if(mysqli_num_rows($query_cek)<=0){
        $query_insert_kode_brg = mysqli_query($koneksi,"INSERT into stokbarang 
(kode_brg, id_jenis, nama_brg, hargabarang, satuan) 
VALUES 	('$kode_brg', '$id_jenis', '$nama_brg','$hargabarang','$satuan')");
//        echo "Kode Barang Belum Ada";
        if($query_insert_kode_brg){
            echo "<script>window.alert('Kode Barang Berhasil Disimpan')
		window.location='index.php?p=material-m1&&id_jenis=1&pas=atk'</script>";
        } else {
            echo "gagal euy cuy" . mysqli_error($koneksi);
        }
    }

//	$query = "INSERT into stokbarang (kode_brg, id_jenis, nama_brg, hargabarang, satuan) VALUES
//	('$kode_brg', '$id_jenis', '$nama_brg','$hargabarang', '$satuan');
//
//	";
//	$hasil = mysqli_query($koneksi, $query);
//	if ($hasil) {
//		echo '<script language="javascript">alert("Data Berhasil Disimpan !!!"); document.location="index.php?p=tambahmaterial-m1";</script>';
//	} else {
//		die("ada kesalahan : " . mysqli_error($koneksi));
//	}

}