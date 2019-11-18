     </header>
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-table"></i> Table</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="<?php echo base_url() ;?>home">Home</a></li>
            </ol>
          </div>
        </div>
        <div class="form-group">
         <div class="row">
          <div class="col-lg-12">
         <a href = "<?php echo base_url(); ?>satuan/add" class= "btn btn-primary pull-right">Tambah Satuan</a>
       </div>
     </div>
     </div>
        <!-- page start-->
              <div class="row">
          <div class="col-sm-12">

              <table class="table table-striped table-advance table-hover table-bordered">
                <tbody>
                  <tr>
                    <th width="100px">No</th>
                    <th>Satuan</th>
<!--                     <th>Nama Pembeli</th> -->
                    <th width="200px">Aksi</th>
                </tr>
                  </tr>
                   <?php
                   $no = 1;
                     foreach ($satuan as $satuan) {
                    ?>
                  <tr>
                    <td><?php echo $no++ ?></td> 
<!--                     <td><?php echo $order->nama_pembeli ?></td> -->
                    <td><?php echo $satuan->satuan ?></td>
                     <td><a class='btn btn-info' href = "<?php echo base_url(); ?>satuan/edit/<?php echo $satuan->id_satuan?>">Edit</a> | <button  class='btn btn-danger modaldelete' data-delete='<?php echo $satuan->id_satuan ?>' >Delete</button> </td>
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
      </div>
      <div class="modal-body">
        <center>
        Apakah benar ingin menghapus satuan?
      </center>
      </div>
      <div class="modal-footer">
        <center>
          <button type="button" class="btn btn-success" id="deleteconf5" data-delete="">Ya</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
        
      </center>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>