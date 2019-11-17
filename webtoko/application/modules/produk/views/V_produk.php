     </header>
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-table"></i> Produk</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="<?php echo base_url() ;?>home">Home</a></li>
              <li><i class="fa fa-table"></i>Produk</li>
            </ol>
          </div>
        </div>
        <!-- page start-->
             
      <div class="row">
          <div class="col-sm-12">
            <div class="form-group">
              <div class="table-responsive">
            <div class="col-lg-12">
               <a href = "<?php echo base_url(); ?>produk/add" class= "btn btn-primary pull-right">Tambah Produk</a>
                </div>
              </div>
             </div>

      
    </div>
  </div>

              <table id="example"  style="width: 100%" class="table table-striped table-advance table-hover table-responsive table-bordered">
                <thead>
                  <tr>
                   <!--  <th>Kode Barang</th> -->
                    <!-- <th>No</th> -->
                    <th>Nama Produk</th>
                     <th>Jenis Produk</th>
                    <th style="width: 200px;">Deskripsi Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Ukuran</th>
                    <th>Satuan</th>
                    <th style="width: 100px">Images</th>
                    <?php if($ses['role']==1) {?><td>Aksi </td> <?php } ?> 
                </tr>
                 </thead>
                  <tbody>
                   <?php
                   $no = 1;
                     foreach ($produk as $produk) {
                    ?>
         
                 
                  <tr>
                   <!--  <td><?php echo $barang->kode_barang ?></td> -->
                   <!-- <td><?php echo $no++ ?></td>  -->
                    <td><?php echo $produk->nama_sub_produk ?></td>
                    <td><?php echo $produk->nama_produk ?></td>
                    <td><?php echo $produk->deskripsi_sub_produk ?></td>
                    <td><?php echo $produk->harga_sub_produk ?></td>
                    <td><?php echo $produk->jumlah_sub_produk ?></td>
                    <td><?php echo $produk->ukuran ?></td>
                    <td><?php echo $produk->satuan ?></td>
                    <td> <?php if (preg_match('/\bhttp\b/', $produk->images) || preg_match('/\bhttps\b/', $produk->images)) {?>
                      <img style="width:100px;height:100px" class="gmb" src="<?php echo $produk->images ?>" >
                      <?php } else{ ?>
                      <img style="width:100px;height:100px" class="gmb" src="<?php echo base_url(); ?>gambar/noimage.png" >
                      <?php } ?>
                    </td>
                    <?php if($ses['role']==1) {?><td><a class='btn btn-info' href = "<?php echo base_url(); ?>produk/edit/<?php echo $produk->id_sub_produk?>">Edit</a> | <button  class='btn btn-danger modaldelete' data-delete='<?php echo $produk->id_sub_produk ?>'>Delete</button> </td>
                    <?php } ?> 
                  </tr>
                  <?php
             }
             ?>
                </tbody>
              </table>
            </div>
          </div>
            </section>
          </div>
        </div>
        <!-- page end-->
      </section>
    </section>

    <div class="modal fade" id="modaldeleteshow" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">
          <center>Konfirmasi Barang</center></h4>
      </div>
      <div class="modal-body">
        <center>
        Apakah benar ingin menghapus barang?
      </center>
      </div>
      <div class="modal-footer">
        <center>
          <button type="button" class="btn btn-success" id="deleteconf1" data-delete="">Ya</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
        
      </center>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

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

<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable();
} );

</script>

</html>
