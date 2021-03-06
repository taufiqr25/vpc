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
                <form class="form-horizontal " method="POST" action="<?php echo base_url()?>produk/edit" enctype="multipart/form-data">
                  <?php
                  foreach ($produk as $produk) {
                    # code...
                  ?>
                 <!--  <div class="form-group">
                    <label class="col-sm-2 control-label">Kode Barang</label>
                    <div class="col-sm-10">
                      <input type="text" name="kode_barang" class="form-control">
                    </div>
                  </div> -->
                  <input type="hidden" name="id_sub_produk" class="form-control"  value="<?php echo $produk->id_sub_produk ?>">
                                      <div class="form-group">
                    <label class="col-sm-2 control-label">Jenis Produk</label>
                    <div class="col-sm-10">
                        <select class="form-control m-bot15" name="id_produk" id="id_produk">
                          <?php

                            foreach ($view as $view) 

                            {
                              
                          
                          ?>

                          <option value="<?php echo $view->id_produk; ?>" <?php if($view->id_produk==$produk->id_produk) echo "selected" ?>><?php echo $view->nama_produk;?></option> 
                      <?php

                         }
                      ?>
                  </select>
                   </div>
                 </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Nama Produk</label>
                    <div class="col-sm-10">
                      <input type="text" name="nama_sub_produk" id="nama_sub_produk" class="form-control" value="<?php echo $produk->nama_sub_produk?>">
                    </div>
                  </div>
                   <div class="form-group">
                    <label class="col-sm-2 control-label">Deskripsi Produk</label>
                    <div class="col-sm-10">
                      <input type="text" name="deskripsi_sub_produk" id="deskripsi_sub_produk" class="form-control" value="<?php echo $produk->deskripsi_sub_produk?>" >
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Satuan Ukuran</label>
                    <div class="col-sm-10">
                    <?php $data_satuan = $this->M_produk->get_data_satuan(); ?>
                        <select class="form-control m-bot15" onchange="get_data_satuan(this.value)" required name="satuan" id="satuan">
                          <option value selected disabled>Silahkan Pilih Satuan Produk</option>
                          <?php foreach ($data_satuan as $data_satuan) { ?>
                            <option value="<?php echo $data_satuan->id_satuan ?>"><?php echo $data_satuan->satuan ?></option>
                         
                          <?php  } ?>        
                        </select>
                   </div>
                </div>

                <script>
                    function get_data_satuan(id_satuan) {
                      $.ajax({
                          type: "POST",
                          url: "<?php echo base_url() ?>produk/get_data_ukuran",
                          data: {
                            id_satuan: id_satuan
                          },
                          beforeSend:function(response){
                            console.log(response);
                          },
                          success: function(response) {
                            console.log(response);
                            
                            $("#div_ukuran" ).empty();
                            $("#div_ukuran" ).html(response);
                          },
                          error: function(response) {
                            console.log(response);
                          }
                      });

                        // alert(id_satuan);
                    }

                    function filter_prodi(id_prodi) {
                      
                    }
                </script>

                 <div class="form-group">
                    <label class="col-sm-2 control-label">Ukuran</label>
                    <div id="div_ukuran" class="col-sm-10">
                        <select class="form-control m-bot15" name="id_ukuran" id="id_ukuran" value="<?php echo $produk->ukuran?>">
                          <option value selected disabled>Silahkan Pilih Ukuran Produk Dahulu</option>
                                   
                        </select>
                   </div>
                </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Harga</label>
                    <div class="col-sm-10">
                      <input type="text" name="harga_sub_produk" id="harga_sub_produk" class="form-control" value="<?php echo $produk->harga_sub_produk?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Jumlah</label>
                    <div class="col-sm-10">
                      <input type="text" name="jumlah_sub_produk" id="jumlah_sub_produk" class="form-control" value="<?php echo $produk->jumlah_sub_produk?>">
                    </div>
                  </div>
                    <div class="form-group">
                    <label class="col-sm-2 control-label">Images</label>
                    <div class="col-sm-10">
                      <input type="file" name="images" id="images" class="form-control" >
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