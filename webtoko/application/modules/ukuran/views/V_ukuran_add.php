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
                <form class="form-horizontal " method="POST" action="<?php echo base_url()?>ukuran/add" enctype="multipart/form-data">
                 <!--  <div class="form-group">
                    <label class="col-sm-2 control-label">Kode Barang</label>
                    <div class="col-sm-10">
                      <input type="text" name="kode_barang" class="form-control">
                    </div>
                  </div> -->
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Ukuran</label>
                    <div class="col-sm-10">
                      <input type="text" name="ukuran" id="ukuran" class="form-control">
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
                
                  
                    <div class="form-group">
                   <div class="box-footer">
                <input type="submit" name = "submit" class="btn btn-primary" value="submit">
              </div>
            </form>
          </div>