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
                <form class="form-horizontal " method="POST" action="<?php echo base_url()?>order/edit1" enctype="multipart/form-data">
                  <?php
                  foreach ($order as $order) {
                    # code...
                  ?>
                 <!--  <div class="form-group">
                    <label class="col-sm-2 control-label">Kode Barang</label>
                    <div class="col-sm-10">
                      <input type="text" name="kode_barang" class="form-control">
                    </div>
                  </div> -->
                  <input type="hidden" name = "id_order" class="form-control"  value="<?php echo $order->id_order ?>">
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Jenis Produk</label>
                    <div class="col-sm-10">
                        <select class="form-control m-bot15" name="status_pemesanan" id="status_pemesanan">
                           <?php $acc1="";$acc2="";$acc3="";$acc="";
                          if($order->status_pemesanan == "Belum Dikonfirmasi") {
                            $acc1="selected";
                          } elseif ($order->status_pemesanan == "Konfirmasi"){
                            $acc2="selected";
                          }
                            elseif ($order->status_pemesanan == "Telah Dikirim"){
                            $acc3="selected";
                          }else{
                            $acc="selected";
                          }?>
                                              <option value="" hidden="hidden" style="color: #f2f2f2"  <?php echo $acc ?>  >Silahkan Pilih Status Pemesanan</option>
                                              <option value="Belum Dikonfirmasi" <?php echo $acc1 ?>>Belum Dikonfirmasi</option>
                                              <option value="Konfirmasi"<?php echo $acc2 ?>>Konfirmasi</option>
                                              <option value="Telah Dikirim"<?php echo $acc3 ?>>Telah Dikirim</option>            
                  </select>
                   </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">No Resi</label>
                    <div class="col-sm-10">
                      <input type="text" name="no_resi" id="no_resi" class="form-control" value="<?php echo $order->no_resi?>">
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