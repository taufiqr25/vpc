     </header>
    <section id="main-content">
      <section class="wrapper">
                <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-table"></i> Pesanan</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="<?php echo base_url() ;?>home">Home</a></li>
              <li><i class="fa fa-table"></i>Pesanan</li>
            </ol>
          </div>
        </div>
        
        
        <!-- page start-->
        <style type="text/css">
          #example{
            font-size: 15px;
          }

          div.dataTables_wrapper {
        width: 100%;
        margin: 0 auto;
    }
        </style>
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-12 ">
            <div class="table-responsive">
              <table id="example" style="width: 100%" class="table table-striped table-responsive table-hover table-bordered">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nomor Transaksi</th>
                    <th>Nama Konsumen</th>
                    <th>Alamat Konsumen</th>
                    <th>No Handphone</th>
                    <th>Provinsi </th>
                    <th>Kota/Kabupaten</th>
                    <th>Nama Produk</th>
                    <th>Ukuran</th>
                    <th>Satuan</th>
                    <th>Jumlah yang dibeli</th>
                     <th>Total Harga</th>
                    <th>Username Telegram Kartu Kredit</th>
                    <!-- <th>Nomor Rekening Pembeli</th> -->
                    <th>Nomor Rekening Tujuan</th>
                    <th>Tanggal Masuk</th>   
                    <th>Status</th> 
                    <th>Gambar</th>
                    <th>Status Pemesanan</th>
                    <th>No Resi</th>                
                    <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                   <?php
                   $no = 1; 
                     foreach ($order as $order) {
                    ?>
                  <tr>
                    <td><?php echo $no++ ?></td>
                    <td><?php echo $order->id_order ?></td>
                     <td><?php echo $order->nama_konsumen ?></td>
                     <td><?php echo $order->alamat_konsumen ?></td>
                      <td><?php echo $order->no_hp ?></td>
                     <td><?php echo $order->provinsi ?></td>
                     <td><?php echo $order->kabupaten ?></td>
                    <td><?php echo $order->nama_sub_produk ?></td>
                    <td><?php echo $order->ukuran ?></td>
                    <td><?php echo $order->satuan ?></td>
                     <td><?php echo $order->kuantitas ?></td>
                     <td><?php echo $order->total ?></td>
                     <td><?php echo $order->id_telegram ?></td>
                    <!-- <td><?php echo $order->nomor_rekening_konsumen ?></td> -->
                    <td><?php echo $order->nomor_rekening?></td>
                    <td><?php echo $order->tanggal_orderan ?></td>
                    <td><?php if($order->status==1) echo "<span class='label label-success'>Lunas</span>"; else echo "<a class='label label-danger modalbtn' data-status='$order->id_order' href='#'>Belum Lunas</a>" ?></td>
                    <td><?php if (preg_match('/\bhttp\b/', $order->gambar_bukti) || preg_match('/\bhttps\b/', $order->gambar_bukti)) {?>
                      <img style="width:100px;height:100px" class="gmb" src="<?php echo $order->gambar_bukti ?>" >
                      <?php } else{ ?>
                      <img style="width:100px;height:100px" class="gmb" src="gambar/<?php echo $order->gambar_bukti ?>" >
                      <?php } ?></td>
                      <td><?php echo $order->status_pemesanan ?></td>
                      <td><?php echo $order->no_resi ?></td>
                     <td><a class='btn btn-info' href="<?php echo base_url(); ?>order/edit1/<?php echo $order->id_order?>" >Edit</a> | <button  class='btn btn-danger modaldelete' data-delete='<?php echo $order->id_order ?>' >Delete</button> </td>
                  </tr>
                  <?php
              }
             ?>
                </tbody>
              </table>
            
          </div>
        </div>
        </div>
            </section>
     <!--      </div>
        </div> -->
        <!-- page end-->
      </section>
    <!-- </section> -->

<div class="modal fade" id="modalbtnshow" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">
          <center>Konfirmasi Status Pembayaran ATM</center></h4>
      </div>
      <div class="modal-body">
        <center>
        Apakah konsumen ini benar sudah melunasi orderannya?
      </center>
      </div>
      <div class="modal-footer">
        <center>
          <button type="button" class="btn btn-success" id="statusbenar" data-status="">Ya</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
        
      </center>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
 <div class="modal fade" id="enlargeImageModal" tabindex="-1" role="dialog" aria-labelledby="enlargeImageModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
          <img src="" class="gmb enlargeImageModalSource" style="width: 100%;">
        </div>
      </div>
    </div>
</div>
<div class="modal fade" id="modaldeleteshow" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">
          <center>Konfirmasi Pesanan</center></h4>
      </div>
      <div class="modal-body">
        <center>
        Apakah benar ingin menghapus pesanan?
      </center>
      </div>
      <div class="modal-footer">
        <center>
          <button type="button" class="btn btn-success" id="deleteconf" data-delete="">Ya</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
        
      </center>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>