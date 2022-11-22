<?php  

include "../fungsi/koneksi.php";

if(isset($_POST['simpan'])) {

	$kode_brg = $_POST['kode_brg'];
	$id_jenis = $_POST['id_jenis'];
	$nama_brg = $_POST['nama_brg'];
	$hargabarang = preg_replace('/[Rp.]/', '', $_POST['hargabarang']);
	$satuan = $_POST['satuan'];	

		//die($stok);

	$query = "INSERT into stokbarang (kode_brg, id_jenis, nama_brg, hargabarang, satuan) VALUES 
	('$kode_brg', '$id_jenis', '$nama_brg','$hargabarang', '$satuan');

	";
	$hasil = mysqli_query($koneksi, $query);
	if ($hasil) {
		echo '<script language="javascript">alert("Data Berhasil Disimpan !!!"); document.location="index.php?p=tambahmaterial-m3";</script>';
	} else {
		die("ada kesalahan : " . mysqli_error($koneksi));
	}

}