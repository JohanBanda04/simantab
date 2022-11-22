<section class="content">
  <div class="row">
    <div class="col-sm-12 col-xs-18">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="text-center">Detil Laporaan Permintaan Barang</h3>
        </div>
        <form method="POST"  class="form-inline">
          <div class="box-body">

            <div class="form-group">
              <label>  Dari Tanggal   </label>
              <input value="<?php echo date('Y-m-d');?>" type="date" id="tanggala" class="form-control" name="tanggala" required>
            </div>&emsp;
            <div class="form-group">
              <label>  Sampai Tanggal   </label>
              <input value="<?php echo date('Y-m-d');?>" type="date" id="tanggalb" class="form-control" name="tanggalb" required>
            </div>
            &emsp;
            <div class="form-group">
              <label>  Nama </label>&emsp;&emsp;
              <input type="text" id="unit" class="form-control" name="unit" required>
            </div>

            <div class="form-group">&emsp;
              <input type='submit' name="tampilkan" value="View" class='btn btn-success'>
            </div>
          </div>
        </form>
      </div>
    </div>
    <?php
    include "../fungsi/koneksi.php";
    include "../fungsi/fungsi.php";

    if(isset($_POST["tampilkan"])){
      $tanggala = $_POST["tanggala"];
      $tanggalb = $_POST["tanggalb"];
      $unit = $_POST["unit"];
      ?>

      <div class="col-sm- col-xs-12">
        <div class="box box-info">
          <div class="box-header with-border">
            <div class="form-group">
              <!-- Untuk Cetak -->

                <?php

                $query_get_id_user = mysqli_query($koneksi,"select * from user where username='$unit'");
                while($item = mysqli_fetch_array($query_get_id_user)){
                    $id_user = $item['id_user'];
                }
//                echo $id_user;
                ?>
              <div class="col-md-12">
                <form method="POST" action='cetak_lap_detilpermintaan.php' target="_blank" class="form-inline">
                  <div class="form-group">
                    <label> Perioode</label>
                    <input readonly type="text"  value="<?php echo $id_user; ?>" id="user_id" class="hide form-control" name="user_id" >
                    <input readonly type="text"  value='<?= ($tanggala); ?>' id="tanggala" class="form-control" name="tanggala" required>
                  </div>
                  <div class="form-group">
                    <label> s/d </label>
                    <input readonly type="text"  value='<?= ($tanggalb); ?>' id="tanggalb" class="form-control" name="tanggalb" required>
                  </div>&emsp;
                  <div class="form-group">
                    <label>  Nama </label>
                    <input readonly type="text"  value='<?= ($unit); ?>' id="unit" class="form-control" name="unit" required>
                  </div>
                  <div class="form-group">

                    <input type='submit' name="POST" value="Cetak" class='btn btn-success'>
                    

                  </div>
                </form>
              </div>
            </div>

            <!-- Untuk Cetak -->
          </div>

          <table class="table table-responsive" id="detil_lap_permintaan_operator">
              <thead>
              <tr>
                  <th>No</th>
                  <th>Tanggal Permintaan</th>
                  <th>Nama</th>
                  <th>Kode Barang</th>
                  <th>Nama Barang</th>
                  <th>Satuan</th>
                  <th>Jumlah</th>
              </tr>
              </thead>

            <tbody>   

              <?php


              $query_bk = mysqli_query($koneksi, "SELECT pengeluaran.kode_brg, unit, nama_brg, 
jumlah, satuan, tgl_keluar FROM pengeluaran 
INNER JOIN stokbarang ON pengeluaran.kode_brg = stokbarang.kode_brg 
WHERE unit='$unit' AND tgl_keluar BETWEEN '$tanggala' and '$tanggalb' ");

              $query = mysqli_query($koneksi, "select * from ((pengeluaran inner join stokbarang on 
pengeluaran.kode_brg=stokbarang.kode_brg) 
inner join permintaan on permintaan.id_sementara=pengeluaran.id_sementara) 
where pengeluaran.tgl_keluar between '$tanggala' and '$tanggalb' and permintaan.status='1' 
and permintaan.unit='$unit'");

              $no = 1;    


              echo "
              ";
              if (mysqli_num_rows($query))      {
                while($data=mysqli_fetch_assoc($query)):

                  ?>

                  <tr>
                   <td><?php echo $no;?></td>
<!--                   <td> --><?php //echo date('d/m/Y', strtotime($data['tgl_keluar']));  ?><!--</td>-->
                   <td> <?php echo tanggal_indo($data['tgl_keluar']);  ?></td>
                   <td><?php echo $data['unit'];?></td>
<!--                   <td>--><?php //echo $data['user_id'];?><!--</td>-->
                   <td><?php echo $data['kode_brg'];?></td>
                   <td><?php echo $data['nama_brg'];?></td>
                   <td><?php echo $data['satuan'];?></td>
                   <td><?php echo $data['jumlah'];?></td>
                 </tr>
                 
                 <?php $no++;  ?>

               <?php  endwhile; } else { 




                echo "<script>window.alert('DATA BARANG TIDAK ADA')
                window.location='index.php?p=detil_lap_permintaan'</script>
                ";}



              } ?>
            </tbody>  
          </table>    
        </div>
      </div>
    </div>
  </section>

<script>

    $(function () {
        $("#detil_lap_permintaan_operator").DataTable({
            "language": {
                "url": "http://cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json",
                "sEmptyTable": "Tidak ada data di database"
            }
        });
    });
</script>
