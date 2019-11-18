     </header>
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-table"></i> Table</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.html">Home</a></li>
              <li><i class="fa fa-table"></i>Table</li>
              <li><i class="fa fa-th-list"></i>Basic Table</li>
            </ol>
          </div>
        </div>
        <div class="form-group">
         <div class="row">
          <div class="col-lg-12">
         <a href = "<?php echo base_url(); ?>user/add" class= "btn btn-primary pull-right">Tambah User</a>
       </div>
     </div>
     </div>
        <!-- page start-->
              <div class="row">
          <div class="col-sm-12">

              <table class="table table-striped table-advance table-hover table-bordered">
                <tbody>
                  <tr>
                    <th>No</th>
                    <th>Username</th>
<!--                     <th>Nama Pembeli</th> -->
                    <th>Nama User</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
                  </tr>
                   <?php
                   $no = 1;
                     foreach ($user as $user) {
                      $role = "";
                      if($user->role==1){
                        $role = 'Admin';
                      }
                      else{
                        $role = 'Pegawai';
                      }
                    ?>
                  <tr>
                    <td><?php echo $no++ ?></td> 
<!--                     <td><?php echo $order->nama_pembeli ?></td> -->
                    <td><?php echo $user->username ?></td>
                    <td><?php echo $user->nama_user ?></td>
                    <td><?php echo $role ?></td>
<!--                      <td><a href = "<?php echo base_url(); ?>user/edit/<?php echo $user->id?>">Edit</a> | <a href = "<?php echo base_url(); ?>user/delete/<?php echo $user->id?>">Delete</a> </td> -->
                     <td><a class='btn btn-info' href = "<?php echo base_url(); ?>user/edit/<?php echo $user->id?>">Edit</a> | <button  class='btn btn-danger modaldelete' data-delete='<?php echo $user->id ?>' >Delete</button> </td>
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
          <center>Konfirmasi Admin</center></h4>
      </div>
      <div class="modal-body">
        <center>
        Apakah benar ingin menghapus user Admin?
      </center>
      </div>
      <div class="modal-footer">
        <center>
          <button type="button" class="btn btn-success" id="deleteconf3" data-delete="">Ya</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
        
      </center>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>