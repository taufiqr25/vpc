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
                <form class="form-horizontal " method="POST" action="<?php echo base_url()?>user/edit" enctype="multipart/form-data">
                  <?php
                  foreach ($user as $user) {
                    # code...
                  ?>
                 <!--  <div class="form-group">
                    <label class="col-sm-2 control-label">Kode Barang</label>
                    <div class="col-sm-10">
                      <input type="text" name="kode_barang" class="form-control">
                    </div>
                  </div> -->
                  <input type="hidden" name = "id" class="form-control"  value="<?php echo $user->id ?>">
                               <div class="form-group">
                    <label class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-10">
                      <input type="text" name="username" id="username" class="form-control" value="<?php echo $user->username?>">
                    </div>
                  </div>
                   <div class="form-group">
                    <label class="col-sm-2 control-label">Nama User</label>
                    <div class="col-sm-10">
                      <input type="text" name="nama_user" id="nama_user" class="form-control" value="<?php echo $user->nama_user?>" >
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10">
                      <input type="password" name="password" id="password" class="form-control">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Role</label>
                    <div class="col-sm-10">
                        <select class="form-control m-bot15" name="role" id="role">
                          <?php $acc1="";$acc2="";$acc="";
                          if($user->role == 1) {
                            $acc1="selected";
                          } elseif ($user->role == 2){
                            $acc2="selected";
                          }else{
                            $acc="selected";
                          }?>
                                              <option value="" hidden="hidden" style="color: #f2f2f2"  <?php echo $acc ?>  >Silahkan Pilih Role</option>
                                              <option value="1" <?php echo $acc1 ?> >Admin</option>
                                              <option value="2" <?php echo $acc2 ?> >Pegawai</option>           
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