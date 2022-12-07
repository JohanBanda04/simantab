<?php
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

$sekarang = date('Y-m-d');
$tgl_satu_bulan_lalu = date("Y-m-d", strtotime("-1 month"));
if (isset($_GET['aksi']) && isset($_GET['tgl'])) {
    $tgl = $_GET['tgl'];
    echo $tgl;
    if ($_GET['aksi'] == 'detil') {
        header("location:?p=detil&tgl=$tgl");
    }
}

$query_group_by_tgl = mysqli_query($koneksi, "select tgl_permintaan, count(*) as jumlah_permintaan from sementara 
where unit='$_SESSION[username]' and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]' 
and status_acc in ('Permintaan Baru','Pengajuan Kasub','setuju') 
group by tgl_permintaan desc");


if (isset($_POST['tampilkan'])) {
    $tanggala = $_POST['tanggala'];
    $tanggalb = $_POST['tanggalb'];

    $_SESSION['tanggala'] = $tanggala;
    $_SESSION['tanggalb'] = $tanggalb;

//    echo "passaatpencet tampilkan lalu dilakukan set tanggala dan tanggalb";

    echo $tanggala . "::";
    echo $tanggalb . "::";

    $query_group_by_tgl_bk_1 = mysqli_query($koneksi, "select tgl_permintaan, count(*) as jumlah_permintaan from sementara 
where unit='$_SESSION[username]' and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]' 
and status_acc in ('Permintaan Baru','Pengajuan Kasub','setuju') 
group by tgl_permintaan desc");

    $query_group_by_tgl = mysqli_query($koneksi, "select tgl_permintaan, count(*) as jumlah_permintaan from sementara 
where unit='$_SESSION[username]' and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]' and 
tgl_permintaan between '$tanggala' and '$tanggalb'
and status_acc in ('Permintaan Baru','Pengajuan Kasub','setuju') 
group by tgl_permintaan desc");

} else {
    if (isset($_SESSION['tanggala']) && isset($_SESSION['tanggalb'])) {
//        echo "tanpapencet tampilkan tapi sudah set tanggala dan tanggalb";

        $query_group_by_tgl_bk_2 = mysqli_query($koneksi, "select tgl_permintaan, count(*) as jumlah_permintaan from sementara 
where unit='$_SESSION[username]' and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]' 
and status_acc in ('Permintaan Baru','Pengajuan Kasub','setuju') 
group by tgl_permintaan desc");

        $query_group_by_tgl = mysqli_query($koneksi, "select tgl_permintaan, count(*) as jumlah_permintaan from sementara 
where unit='$_SESSION[username]' and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]' and 
tgl_permintaan between '$_SESSION[tanggala]' and '$_SESSION[tanggalb]'
and status_acc in ('Permintaan Baru','Pengajuan Kasub','setuju') 
group by tgl_permintaan desc");

    } else {
//        echo "belumpencet tampilkan";
        $query_group_by_tgl_bk_3 = mysqli_query($koneksi, "select tgl_permintaan, count(*) as jumlah_permintaan from sementara 
where unit='$_SESSION[username]' and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]' 
and status_acc in ('Permintaan Baru','Pengajuan Kasub','setuju') 
group by tgl_permintaan desc");

        $query_group_by_tgl = mysqli_query($koneksi, "select tgl_permintaan, count(*) as jumlah_permintaan from sementara 
where unit='$_SESSION[username]' and user_id='$_SESSION[user_id]' and id_subbidang='$_SESSION[subbidang_id]' and 
tgl_permintaan between '$tgl_satu_bulan_lalu' and '$sekarang'
and status_acc in ('Permintaan Baru','Pengajuan Kasub','setuju') 
group by tgl_permintaan desc");
    }
}

?>
<!--Isi Utama dari menu Data Permintaan Barang (Side Instansi)-->
<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-center">Dataa Permintaan Barang </h3>
                </div>

                <!--metode menambah filter tanggal-->
                <center>
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
                            &emsp;


                            <div class="form-group">&emsp;
                                <input type='submit' name="tampilkan" value="Lihat" class='btn btn-success'>
                            </div>
                        </div>

                    </form>
                </center>
                <div class="box-body">
                    <a href="index.php?p=formpesan_table" style="margin:10px 15px; background-color: #486055"
                       class="btn btn-success">
                        <i class='fa fa-plus' style="color: white; font-weight: bold">
                            Form Permintaan Barang
                        </i>
                    </a>
                    <div class="table-responsive">
                        <table class="table text-center" id="datapesanan_table">
                            <thead style="background-color: #b6eee0">
                            <tr>
                                <th style="color: black">No</th>
                                <th style="color: black">Tanggal Permintaan</th>
                                <th style="color: black">Jumlah Permintaan</th>
                                <th style="color: black">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!--                            <tr>-->
                            <?php
                            $no = 1;
                            if (mysqli_num_rows($query_group_by_tgl)) {
                                while ($row = mysqli_fetch_assoc($query_group_by_tgl)):
                                    ?>
                                    <tr>
                                        <td> <?= $no; ?> </td>
                                        <td> <?= tanggal_indo($row['tgl_permintaan']); ?> </td>
                                        <td> <?= $row['jumlah_permintaan']; ?> </td>
                                        <td>
                                            <!--error disini, saat klik detail permintaan, tidak di redirect-->
                                            <!--                                    <a href="?p=datapesanan&aksi=detil&tgl=-->
                                            <?//= $row['tgl_permintaan'];
                                            ?><!--">-->
                                            <a href="?p=detil_table&tgl=<?= $row['tgl_permintaan']; ?>">
                                                <span style="font-weight: bold" data-placement='top'
                                                      data-toggle='tooltip' title='Detail Permintaan'>
                                                    <button class="btn btn-info" style="font-weight: bold">Detail Permintaan</button>
                                                </span>
                                            </a>


                                        </td>
                                    </tr>

                                    <?php $no++;
                                endwhile;
                            } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


</section>

<script>

    $(function () {
        $("#datapesanan_table").DataTable({
            "language": {
                "url": "http://cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json",
                "sEmptyTable": "Tidak ada data di database"
            }
        });
    });
</script>

