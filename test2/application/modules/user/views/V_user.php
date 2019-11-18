<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <!-- USER DATA-->
                    <div class="user-data m-b-30">
                        <h3 class="title-3 m-b-30">
                            <i class="fas fa-users"></i></i>Data User</h3>
                        <div class="table-responsive table-data">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td>
                                            <label class="au-checkbox">
                                                <input type="checkbox">
                                                <span class="au-checkmark"></span>
                                            </label>
                                        </td>
                                        <td>Username</td>
                                        <td>Nama Lengkap</td>
                                        <td>Email</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                    <?php 
                                    if($data_user->num_rows() > 0){
                                        foreach ($data_user->result() as $data) {?>
                                    <tr>
                                        <td>
                                            <label class="au-checkbox">
                                                <input type="checkbox">
                                                <span class="au-checkmark"></span>
                                            </label>
                                        </td>
                                        <td><?= $data->username ?></td>
                                        <td><?= $data->nama ?></td>
                                        <td><?= $data->email ?></td>
                                        <td>
                                            <Button class="btn btn-primary"><i class="fas fa-eye"></i></button> | <Button class="btn btn-danger" onclick="hapus(<?= $data->id ?>)"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php }}else{
                                        echo "<tr><td align='center' colspan='5'>Data tidak ditemukan</td></tr>";
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END USER DATA-->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal scroll -->
<div class="modal fade" id="scrollmodal" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel">Scrolling Long Content Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo
                    risus, porta ac consectetur ac, vestibulum at eros.
                    <br> Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Confirm</button>
            </div>
        </div>
    </div>
</div>
<!-- end modal scroll -->

<script type="text/javascript">
function hapus(id) {
   $.ajax({
     url: '<?= base_url() ?>user/hapus',
     type: 'POST',
     data: { id:id }
   }).done(function(response){
       get_data();
   })
}
function get_data() {
    $.ajax({
        url: '<?php echo base_url() ?>user/get_data'
    }).done(function(response){
        var data = $.parseJSON(response);
        var tbody = '';
        if(data.length > 0){
            for(i=0;i<data.length;i++){
                var no = i+1;
                tbody += '<tr>';
                tbody += '<td><label class="au-checkbox"><input type="checkbox"><span class="au-checkmark"></span></label></td>';
                tbody += '<td>'+data[i].nama_barang+'</td>';
                tbody += '<td>'+data[i].harga+'</td>';
                tbody += '<td>'+data[i].kondisi+'</td>';
                tbody += '<td>';
                tbody += '<Button class="btn btn-primary"><i class="fas fa-eye"></i></button> | <Button class="btn btn-danger" onclick="hapus('+data[i].id+')"><i class="fas fa-trash"></i></button>';
                tbody += '</td></tr>';
            }
        }else{
            tbody += "<tr><td align='center' colspan='5'>Data tidak ditemukan</td></tr>";
        }
        $('#tbody').html(tbody);
    })
}
</script>