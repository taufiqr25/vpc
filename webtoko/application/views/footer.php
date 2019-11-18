 <div class="widget-foot">
                  <!-- Footer goes here -->
                </div>
              </div>
            </div>

          </div>

        </div>
        <!-- project team & activity end -->

      </section>
    </section>
    <!--main content end-->
  </section>

   <script src="<?php echo base_url() ;?>js/jquery.js"></script>
  <script src="<?php echo base_url() ;?>js/jquery-ui-1.10.4.min.js"></script>
  <script src="<?php echo base_url() ;?>js/jquery-1.8.3.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url() ;?>js/jquery-ui-1.9.2.custom.min.js"></script>
  <!-- bootstrap -->
  <script src="<?php echo base_url() ;?>js/bootstrap.min.js"></script>
  <!-- nice scroll -->
  <script src="<?php echo base_url() ;?>js/jquery.scrollTo.min.js"></script>
  <script src="<?php echo base_url() ;?>js/jquery.nicescroll.js" type="text/javascript"></script>
  <!-- charts scripts -->
  <script src="<?php echo base_url() ;?>assets/jquery-knob/js/jquery.knob.js"></script>
  <script src="<?php echo base_url() ;?>js/jquery.sparkline.js" type="text/javascript"></script>
  <script src="<?php echo base_url() ;?>assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
  <script src="<?php echo base_url() ;?>js/owl.carousel.js"></script>
  <!-- jQuery full calendar -->
  <<script src="<?php echo base_url() ;?>js/fullcalendar.min.js"></script>
    <!-- Full Google Calendar - Calendar -->
    <script src="<?php echo base_url() ;?>assets/fullcalendar/fullcalendar/fullcalendar.js"></script>
    <!--script for this page only-->
    <script src="<?php echo base_url() ;?>js/calendar-custom.js"></script>
    <script src="<?php echo base_url() ;?>js/jquery.rateit.min.js"></script>
    <!-- custom select -->
    <script src="<?php echo base_url() ;?>js/jquery.customSelect.min.js"></script>
    <script src="<?php echo base_url() ;?>assets/chart-master/Chart.js"></script>

    <!--custome script for all page-->
    <script src="<?php echo base_url() ;?>js/scripts.js"></script>
    <!-- custom script for this page-->
    <script src="<?php echo base_url() ;?>js/sparkline-chart.js"></script>
    <script src="<?php echo base_url() ;?>js/easy-pie-chart.js"></script>
    <script src="<?php echo base_url() ;?>js/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="<?php echo base_url() ;?>js/jquery-jvectormap-world-mill-en.js"></script>
    <script src="<?php echo base_url() ;?>js/xcharts.min.js"></script>
    <script src="<?php echo base_url() ;?>js/jquery.autosize.min.js"></script>
    <script src="<?php echo base_url() ;?>js/jquery.placeholder.min.js"></script>
    <script src="<?php echo base_url() ;?>js/gdp-data.js"></script>
    <script src="<?php echo base_url() ;?>js/morris.min.js"></script>
    <script src="<?php echo base_url() ;?>js/sparklines.js"></script>
    <script src="<?php echo base_url() ;?>js/charts.js"></script>
    <script src="<?php echo base_url() ;?>js/jquery.slimscroll.min.js"></script>
    <script src="<?php echo base_url() ;?>js/custom.js"></script>
    <script src="<?php echo base_url() ;?>assets/datatables.min.js"></script>
    <script src="<?php echo base_url() ;?>assets/datatables/js/dataTables.bootstrap.min.js"></script>
<!--    <script src="<?php echo base_url() ;?>assets/datatables/js/jquery.dataTables.min.js"></script>
 -->
</body>

<script type="text/javascript">

$(function() {
      $('.gmb ').on('click', function() {
      $('.enlargeImageModalSource').attr('src', $(this).attr('src'));
      $('#enlargeImageModal').modal('show');
    });
});

  $(document).ready(function() {
    $('#example').DataTable({
      "scrollX": true
    });
  });


  $(".modalbtn").click(function(){
    $('#modalbtnshow').modal("show");
    var test = $(this).attr("data-status")
    $("#statusbenar").attr("data-status",test)
});

  $("#statusbenar").click(function(){
    var stat= $("#statusbenar").attr("data-status")
    $(location).attr('href', '<?php echo base_url('order/statusupdate')?>/'+stat+'')

  })

  $(".modaldelete").click(function(){
    $('#modaldeleteshow').modal("show");
    var test = $(this).attr("data-delete")
    $("#deleteconf").attr("data-delete",test)
});

    $(".modaldelete").click(function(){
    $('#modaldeleteshow').modal("show");
    var test = $(this).attr("data-delete")
    $("#deleteconf1").attr("data-delete",test)
});

      $(".modaldelete").click(function(){
    $('#modaldeleteshow').modal("show");
    var test = $(this).attr("data-delete")
    $("#deleteconf2").attr("data-delete",test)
});

        $(".modaldelete").click(function(){
    $('#modaldeleteshow').modal("show");
    var test = $(this).attr("data-delete")
    $("#deleteconf3").attr("data-delete",test)
});

            $(".modaldelete").click(function(){
    $('#modaldeleteshow').modal("show");
    var test = $(this).attr("data-delete")
    $("#deleteconf4").attr("data-delete",test)
});

          $(".modaldelete").click(function(){
    $('#modaldeleteshow').modal("show");
    var test = $(this).attr("data-delete")
    $("#deleteconf5").attr("data-delete",test)
});

          $(".modaldelete").click(function(){
    $('#modaldeleteshow').modal("show");
    var test = $(this).attr("data-delete")
    $("#deleteconf6").attr("data-delete",test)
});

  $("#deleteconf").click(function(){
    var stat= $("#deleteconf").attr("data-delete")
    $(location).attr('href', '<?php echo base_url('order/delete')?>/'+stat+'')

  })
  $("#deleteconf1").click(function(){
    var stat1= $("#deleteconf1").attr("data-delete")
    $(location).attr('href', '<?php echo base_url('produk/delete')?>/'+stat1+'')

  })
    $("#deleteconf2").click(function(){
    var stat2= $("#deleteconf2").attr("data-delete")
    $(location).attr('href', '<?php echo base_url('rekening/delete')?>/'+stat2+'')

  })
    $("#deleteconf3").click(function(){
    var stat3= $("#deleteconf3").attr("data-delete")
    $(location).attr('href', '<?php echo base_url('user/delete')?>/'+stat3+'')

  })
     $("#deleteconf4").click(function(){
    var stat4= $("#deleteconf4").attr("data-delete")
    $(location).attr('href', '<?php echo base_url('ukuran/delete')?>/'+stat4+'')

  })
    $("#deleteconf5").click(function(){
    var stat5= $("#deleteconf5").attr("data-delete")
    $(location).attr('href', '<?php echo base_url('satuan/delete')?>/'+stat5+'')

  })
    $("#deleteconf6").click(function(){
    var stat5= $("#deleteconf6").attr("data-delete")
    $(location).attr('href', '<?php echo base_url('jenis_produk/delete')?>/'+stat5+'')

  })
    


</script>

</html>
