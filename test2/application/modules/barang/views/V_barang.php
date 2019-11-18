<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <!-- USER DATA-->
                    <div class="user-data m-b-30">
                        <h3 class="title-3 m-b-30">
                            <i class="fas fa-list"></i>Data Barang</h3>
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
                                        <td>Nama Barang</td>
                                        <td>Harga</td>
                                        <td>Kondisi</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                    <?php 
                                    if($data_barang->num_rows() > 0){
                                        foreach ($data_barang->result() as $data) {?>
                                    <tr>
                                        <td>
                                            <label class="au-checkbox">
                                                <input type="checkbox">
                                                <span class="au-checkmark"></span>
                                            </label>
                                        </td>
                                        <td><?= $data->nama_barang ?></td>
                                        <td><?= $data->harga ?></td>
                                        <td><?= $data->kondisi ?></td>
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

<script type="text/javascript">
function hapus(id) {
   $.ajax({
     url: '<?= base_url() ?>barang/hapus',
     type: 'POST',
     data: { id:id }
   }).done(function(response){
       get_data();
   })
}
function get_data() {
    $.ajax({
        url: '<?php echo base_url() ?>barang/get_data'
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