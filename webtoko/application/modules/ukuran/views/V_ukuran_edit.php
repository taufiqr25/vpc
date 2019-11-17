<section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-file-text-o"></i> Form elements</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="<?php echo base_url() ;?>home">Home</a></li>
              <li><i class="icon_document_alt"></i>Forms</li>
              <li><i class="fa fa-file-text-o"></i>Form elements</li>
            </ol>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                Form Elements
              </header>
              <div class="panel-body">
                <form class="form-horizontal " method="POST" action="<?php echo base_url()?>ukuran/edit" enctype="multipart/form-data">
                  <?php
                  foreach ($ukuran as $ukuran) {
                    # code...
                  ?>
                 <!--  <div class="form-group">
                    <label class="col-sm-2 control-label">Kode Barang</label>
                    <div class="col-sm-10">
                      <input type="text" name="kode_barang" class="form-control">
                    </div>
                  </div> -->
                  <input type="hidden" name = "id_ukuran" class="form-control"  value="<?php echo $ukuran->id_ukuran ?>">
                               <div class="form-group">
                    <label class="col-sm-2 control-label">Ukuran</label>
                    <div class="col-sm-10">
                      <input type="text" name="ukuran" id="ukuran" class="form-control" value="<?php echo $ukuran->ukuran?>">
                    </div>
                  </div>
                                    <div class="form-group">
                    <label class="col-sm-2 control-label">Satuan</label>
                    <div class="col-sm-10">
                        <select class="form-control m-bot15" name="id_satuan" id="id_satuan">
                          <option value selected disabled>Silahkan Pilih Satuan Produk</option>
                          <?php

                            foreach ($satuan as $satuan) 

                            {
                              # code...
                          
                          ?>

                          <option value="<?php echo $satuan->id_satuan ?>"><?php echo $satuan->satuan ?></option>  
                      <?php

                         }
                      ?>
                  </select>
                   </div>
                 </div>   
                  
                <!--   <div class="form-group">
                    <label class="col-sm-2 control-label">Harga Beli</label>
                    <div class="col-sm-10">
                      <input type="text" name="harga_beli" id="harga_beli" class="form-control" value="<?php echo $barang->harga_beli?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Total Harga</label>
                    <div class="col-sm-10">
                      <input type="text" name="total_harga" id="total_harga" class="form-control" readonly="readonly" value="<?php echo $barang->total_harga?>">
                    </div> -->                  <!-- </div> -->
                  <?php } ?>

                   <div class="form-group">
                   <div class="box-footer">
                <input type="submit" name = "submit" class="btn btn-primary" value="submit">
              </div>
            </form>
          </div>