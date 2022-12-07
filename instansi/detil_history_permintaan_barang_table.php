<?php
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

if(isset($_GET['unit']) && isset($_GET['user_id']) && isset($_GET['tgl_permintaan'])){
    $unit = $_GET['unit'];
    $user_id = $_GET['user_id'];
    $tgl_permintaan = $_GET['tgl_permintaan'];

    $query_old = mysqli_query($koneksi,"select * from (sementara inner join stokbarang on 
sementara.kode_brg=stokbarang.kode_brg) where unit='$unit' and user_id='$user_id' and 
tgl_permintaan='$tgl_permintaan' and status_acc not IN ('Permintaan Baru','Pengajuan Kasub')");

    $query = mysqli_query($koneksi,"select * from (sementara inner join stokbarang 
on sementara.kode_brg=stokbarang.kode_brg) where unit='$unit' 
and user_id='$user_id' and tgl_permintaan='$tgl_permintaan' and status_acc not in
('Permintaan Baru','Pengajuan Kasub','setuju')");

}


?>


<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-center" >History Permintaan <?php echo $unit; ?></h3><br>
                    <h4 class="text-center" style="font-weight: bold"><?php echo tanggal_indo($tgl_permintaan)?></h4>
                </div>
                <div class="box-body">
                    <!--                    p=history_kasub&pa=history_kasub_pengguna-->
                    <a href="index.php?p=history_permintaan_barang_table&pa=history_pengguna" style="margin:10px;" class="btn btn-success"><i
                            class='fa fa-backward'> Kembali</i></a>
                    <div class="table-responsive">
                        <table class="table text-center" id="detil_history_permintaan">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Pengelola</th>
                                <th>Id Sementara</th>
                                <!--                                <th>Kode Barang</th>-->
                                <th>Nama Barang</th>
                                <th>Satuan</th>
                                <th>Jumlah</th>
                                <th>Note Kasub</th>
                                <th>Note Bendahara</th>
                                <th style="background-color: ">Status</th>

                            </tr>
                            </thead>


                            <tbody>

                                <?php
                                $no = 1;
                                if (mysqli_num_rows($query)) {
                                while ($row = mysqli_fetch_assoc($query)):


                                if($row['status_acc']!=null){?>
                                    <!--jika belum disetujui-->
                                    <tr>
                                    <td> <?= $no; ?> </td>
                                    <?php if($row['bendahara']=="" || $row['bendahara']==null){ ?>
                                        <td> Belum Diproses Pengelola </td>
                                    <?php } else { ?>
                                        <td> <?= $row['bendahara']; ?> </td>

                                    <?php } ?>
                                    <td> <?= $row['id_sementara']; ?> </td>
                                    <!--                                    <td> --><?//= $row['kode_brg']; ?><!-- </td>-->
                                    <td> <?= $row['nama_brg']; ?> </td>
                                    <td> <?= $row['satuan']; ?> </td>
                                    <td> <?= $row['jumlah']; ?> </td>

                                    <?php if($row['note_kasub_pengguna']!=null){ ?>
                                        <td> <?= $row['note_kasub_pengguna']; ?> </td>
                                    <?php } else { ?>
                                        <td> - </td>
                                    <?php } ?>


                                    <?php if($row['note_bendahara']!=null){ ?>
                                        <td> <?= $row['note_bendahara']; ?> </td>
                                    <?php } else { ?>
                                        <td> - </td>
                                    <?php } ?>


                                    <?php if($row['status_acc']=='Penyerahan Barang Ke Pengguna') { ?>
                                        <td>
                                            <!--                                            <form method="post" action="terima_barang_dari_bendahara.php">-->
                                            <!--                                                <input class="hidden" type="text" name="id_sementara" value="--><?php //echo $row['id_sementara']; ?><!--">-->
                                            <!---->
                                            <!--                                                <input onclick="return confirm('Terima Barang Dari Bendahara?')"-->
                                            <!--                                                       type="submit" id="terima_barang_dari_bendahara"-->
                                            <!--                                                       name="terima_barang_dari_bendahara"-->
                                            <!--                                                       style="background-color: #1b860c"-->
                                            <!--                                                       class="btn btn-primary col-sm-offset-3"-->
                                            <!--                                                       value="Terima Barang Dari Bendahara">-->
                                            <!---->
                                            <!--                                            </form>-->
                                            <!--Set tombol ditengah-->
                                            <div  class="col-md-2" style="width: 80%">
                                                <!--                                                <a href="index.php?p=tambahmaterial-m2" class=" btn btn-primary"><i class="fa fa-plus"></i> Tambah Data Stok</a><br>-->
                                                <center>
                                                    <!--                                                    <a href="index.php?p=terima_barang_dari_bendahara_new&id_sementara=--><?php //echo $row['id_sementara'];?><!--"-->
                                                    <!--                                                           class="btn btn-info">-->
                                                    <!--                                                        <i class="fa fa-envelope-open"></i> Terima Barang-->
                                                    <!--                                                    </a>-->

                                                    <!--penggunaan metode post terbaru lagi disini-->
<!--                                                    <form method="post" action="penerimaan_barang_dari_bendahara.php">-->
                                                    <form method="post" action="penerimaan_barang_dari_bendahara_table.php">

                                                        <input class="hidden" type="text" name="unit" value="<?php echo $row['unit']; ?>">
                                                        <input class="hidden" type="text" name="user_id" value="<?php echo $row['user_id']; ?>">
                                                        <input class="hidden" type="text" name="kode_brg" value="<?php echo $row['kode_brg']; ?>">
                                                        <input class="hidden" type="text" name="jumlah" value="<?php echo $row['jumlah']; ?>">
                                                        <input class="hidden" type="text" name="id_sementara" value="<?php echo $row['id_sementara']; ?>">
                                                        <input class="hidden" type="text" name="tgl_permintaan" value="<?php echo $row['tgl_permintaan']; ?>">
                                                        <input class="hidden" type="text" name="bendahara_id" value="<?php echo $row['bendahara_id']; ?>">
                                                        <input onclick="return confirm('Sudah Terima Barang Bro?')"
                                                               type="submit" id="penerimaan_barang_dari_bendahara"
                                                               name="penerimaan_barang_dari_bendahara"
                                                               style=""
                                                               class="btn btn-warning col-sm-offset-3"
                                                               value="Terimaa Barang">
                                                    </form>
                                                </center>

                                            </div>
                                        </td>

                                    <?php } else {
                                        if($row['status_acc']=='Penerimaan Barang Dari Bendahara') { ?>
                                            <td style="color: red; font-weight: bold"> Barang Sudah Diterima </td>
                                        <?php } else { ?>
                                            <td style="color: red; font-weight: bold"> <?php if ($row['status_acc']=="tidak_setuju"){
                                                echo ucwords(str_replace("_"," ",$row['status_acc']));
                                                } else {
                                                 echo $row['status_acc'];
                                                } ?> </td>
                                        <?php }
                                        ?>
                                        <!--                                        <td style="color: red; font-weight: bold"> --><?//=$row['status_acc']?><!-- </td>-->
                                        <?php
                                    } ?>




                                <?php } ?>

                            </tr>

                            <?php $no++;

                            endwhile;
                            } else {
                                echo "<tr><td colspan=9>Tidak ada permintaan material teknik.</td></tr>";
                            } ?>
                            </tbody>
                        </table>

                        <script>
                            $(document).ready(function () {
                                $("#setujui").click(function () {
                                    document.getElementById('setujui').style.visibility = "hidden";
                                });
                            });

                            function showStuff(id, text, btn) {
                                document.getElementById(id).style.display = 'block';
                                // hide the lorem ipsum text
                                document.getElementById(text).style.display = 'none';
                                // hide the link
                                btn.style.display = 'none';
                            }

                            function klikLah(id, btn) {
                                const buttons  = document.getElementById('a_setujui');
                                const sembunyi  = document.getElementById('sembunyi');
                                document.getElementById(id).style.display = 'block';
                                // hide the lorem ipsum text
                                // document.getElementById(text).style.display = 'none';
                                // hide the link
                                // btn.style.display = 'none';
                                buttons.style.display = 'none';
                                sembunyi.style.visibility = "visible";
                            }
                        </script>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" !src="">
        hiddenTidakDisetujui=function(id){
            $(this).css('visibility', 'hidden');
            alert(id);
        };
        kirimNote=function (id) {
            alert(id);
        };
    </script>

    <script>

        $(function () {
            $("#detil_history_permintaan").DataTable({
                "language": {
                    "url": "http://cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json",
                    "sEmptyTable": "Tidak ada data di database"
                }
            });
        });
    </script>

</section>