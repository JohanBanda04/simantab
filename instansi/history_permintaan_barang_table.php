<?php
//session_start();
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

$sekarang = date('Y-m-d');

$tgl_satu_bulan_lalu = date("Y-m-d", strtotime("-1 month"));
//index.php?p=history_permintaan_barang_table&pa=history_pengguna
if (isset($_GET['p']) && isset($_GET['pa'])) {
//    echo "sudah terset p dan pa nya";
    $query = mysqli_query($koneksi, "select * from sementara 
where tgl_permintaan between '$tgl_satu_bulan_lalu' and '$tgl_satu_bulan_lalu' and unit='$_SESSION[username]' 
and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]' 
and status_acc not in ('Permintaan Baru','Pengajuan Kasub','setuju') 
group by tgl_permintaan desc");

}

if (isset($_POST['tampilkan'])) {


    $tanggala = $_POST['tanggala'];
    $tanggalb = $_POST['tanggalb'];
    //disini sudah dibuatkan pilihan pilih status
    //tinggal diatifkan komenan dibawah
//    $jenis_status_acc = $_POST['jenis_status_acc'];

//    echo $jenis_status_acc;


    $_SESSION['tanggala'] = $tanggala;
    $_SESSION['tanggalb'] = $tanggalb;

    $query = mysqli_query($koneksi, "select * from sementara 
where tgl_permintaan between '$tanggala' and '$tanggalb' and unit='$_SESSION[username]' 
and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]' 
and status_acc not in ('Permintaan Baru','Pengajuan Kasub','setuju') 
group by tgl_permintaan desc");
} else {
    if (isset($_SESSION['tanggala']) && isset($_SESSION['tanggalb'])) {


        $query = mysqli_query($koneksi, "select * from sementara 
where tgl_permintaan between '$_SESSION[tanggala]' and '$_SESSION[tanggalb]' and unit='$_SESSION[username]' 
and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]' 
and status_acc not in ('Permintaan Baru','Pengajuan Kasub','setuju') 
group by tgl_permintaan desc");
    } else {


//        $query_bk = mysqli_query($koneksi,"select * from sementara
//where tgl_permintaan between '$sekarang' and '$sekarang' and unit='$_SESSION[username]'
//and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]'
//and status_acc not in ('Permintaan Baru','Pengajuan Kasub','setuju')
//group by tgl_permintaan desc");

        $query = mysqli_query($koneksi, "select * from sementara 
where tgl_permintaan between '$tgl_satu_bulan_lalu' and '$sekarang' and unit='$_SESSION[username]' 
and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]' 
and status_acc not in ('Permintaan Baru','Pengajuan Kasub','setuju') 
group by tgl_permintaan desc");
    }
}

?>
<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <?php $nama_subbidang = ""; ?>
                    <?php
                    $getSubBidang = mysqli_query($koneksi, "select * from subbidang where 
                        id_subbidang='$_SESSION[subbidang_id]'");

                    while ($dt = mysqli_fetch_array($getSubBidang)) {
                        $nama_subbidang = $dt['nama_subbidang'];
                    }
                    ?>
                    <h3 class="text-center">History Permintaan Barang Sub Bidaang <br>
                        <span style="font-weight: bold"><?php echo $nama_subbidang; ?></span>
                    </h3>
                </div>

                <center>
                    <!--                    <form method="POST" action="filter_permintaan_by_range_tgl.php" class="form-inline">-->
                    <form method="POST" class="form-inline">
                        <div class="box-body">

                            <div class="form-group">
                                <label> Dari Tanggal </label>
                                <input value="<?php if (isset($_SESSION['tanggala'])) {
                                    echo $_SESSION['tanggala'];
                                } else {
                                    echo $tgl_satu_bulan_lalu;
                                } ?>"
                                       type="date" id="tanggala"
                                       class="form-control" name="tanggala" required>
                            </div>&emsp;
                            <div class="form-group">
                                <label> Sampai Tanggal </label>
                                <input value="<?php if (isset($_SESSION['tanggalb'])) {
                                    echo $_SESSION['tanggalb'];
                                } else {
                                    echo $sekarang;
                                } ?>"
                                       type="date" id="tanggalb"
                                       class="form-control" name="tanggalb" required>
                            </div>

                            <br>

                            <!--UNTUK ENTER-->
                            <div style="margin-top: 20px"></div>

                            <div class="form-group">&emsp;
                                <input type='submit' name="tampilkan" value="Lihat" class='btn btn-success'>
                            </div>
                        </div>

                    </form>
                </center>

                <div class="box-body">
                    <!--penggunaan Datatables utk fitur pencarian-->
                    <div class="table-responsive">
                        <table id="permintaan_barang" class="table text-center">
                            <!--standard warna table header-->
                            <thead style="background-color: #a1d5ff">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>User ID</th>
                                <th>Tgl Permintaan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            $no = 1;
                            if (mysqli_num_rows($query)) {
                                while ($row = mysqli_fetch_assoc($query)) {
                                    ?>
                                    <tr>
                                        <td> <?= $no; ?> </td>
                                        <td> <?= $row['unit']; ?> </td>
                                        <td> <?= $row['user_id']; ?> </td>
                                        <td> <?= tanggal_indo($row['tgl_permintaan']); ?> </td>
<!--                                        <td> --><?//= $row['instansi']; ?><!-- </td>-->
                                        <td> <?= $row['status_acc']; ?> </td>

                                        <td style="background-color: ">
                                            <a href="?p=detil_history_permintaan_barang_table&unit=<?php echo $row['unit'] ?>&user_id=<?php echo $row['user_id'] ?>&tgl_permintaan=<?php echo $row['tgl_permintaan'] ?>">
                                                <span data-placement="top"
                                                      data-toggle="tooltip"
                                                      title="Detail Permintaan">
                                                    <button name="bt_detail_history_kasubpengguna"
                                                            class="btn btn-info">
                                                        Detail Permintaann
                                                    </button>
                                                </span>
                                            </a>

                                        </td>
                                    </tr>
                                    <?php $no++;
                                }
                            } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--bagian bawah-->

</section>


<script>

    $(function () {
        $("#permintaan_barang").DataTable({
            "language": {
                "url": "http://cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json",
                "sEmptyTable": "Tidak ada data di database"
            }
        });
    });
</script>
