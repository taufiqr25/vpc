<section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-file-text-o"></i> Form elements</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.html">Home</a></li>
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
                <form class="form-horizontal " method="POST" action="<?php echo base_url()?>jenis_produk/edit" enctype="multipart/form-data">
                     <?php
                  foreach ($produk as $produk) {
                    # code...
                  ?>
                 <input type="hidden" name = "id_produk" class="form-control"  value="<?php echo $produk->id_produk ?>">
                               <div class="form-group">
                    <label class="col-sm-2 control-label">Nama Produk</label>
                    <div class="col-sm-10">
                      <input type="text" name="nama_produk" id="nama_produk" class="form-control" value="<?php echo $produk->nama_produk?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Jenis Produk</label>
                    <div class="col-sm-10">
                      
                        <select class="form-control m-bot15" name="kategori_produk" id="kategori_produk" >
                           <?php  $acc1="";$acc2="";$acc="";
                          if($produk->kategori_produk == "Pakaian") {
                            $acc1="selected";
                          } else if ($produk->kategori_produk == "Aksesoris"){
                            $acc2="selected";
                          }else{
                            $acc="selected";
                          }?>
                                              <option value="" hidden="hidden" style="color: #f2f2f2"  <?php echo $acc ?>  >Silahkan Pilih Role</option>
                                              <option value="Pakaian" <?php echo $acc1 ?>>Pakaian</option>
                                              <option value="Aksesoris"<?php echo $acc2 ?>>Aksesoris</option>           
                  </select>
                   </div>
                </div>
                     <?php } ?>

                   <div class="form-group">
                   <div class="box-footer">
                <input type="submit" name = "submit" class="btn btn-primary" value="submit">
              </div>
            </form>
          </div>