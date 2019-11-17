      var jumlahbeli =  $("#jumlah_beli");
      var hargabeli = $("#harga_beli");

      jumlahbeli.on("input",function(){

        var total =  jumlahbeli.val() * hargabeli.val();
        $("#total_harga").val(total);
        $("#total_harga").change()
      })

      hargabeli.on("input",function(){

        var total =  jumlahbeli.val() * hargabeli.val();
        $("#total_harga").val(total);
        $("#total_harga").change()
      })

   $('#idbarang').change(function(){
         var idbarang = $("#idbarang").find("option:selected").attr('value');
         $.ajax({
          method:'POST',
          async:true,
          url:"<?php echo base_url()?>stok/show_jumlah",
          data:{id:idbarang},
          datatype:'json',
         success:function(data){
            var json = $.parseJSON(data);
            alert(json);
        
          },
          error:function(){
            alert('tidak dapat membaca database')
             
          } 
        })
      });

           //knob
      $(function() {
        $(".knob").knob({
          'draw': function() {
            $(this.i).val(this.cv + '%')
          }
        })
      });


        
           //carousel
      $(document).ready(function() {
        $("#owl-slider").owlCarousel({
          navigation: true,
          slideSpeed: 300,
          paginationSpeed: 400,
          singleItem: true

        });
      });

      //custom select box

      $(function() {
        $('select.styled').customSelect();
      });

      /* ---------- Map ---------- */
      $(function() {
        $('#map').vectorMap({
          map: 'world_mill_en',
          series: {
            regions: [{
              values: gdpData,
              scale: ['#000', '#000'],
              normalizeFunction: 'polynomial'
            }]
          },
          backgroundColor: '#eef3f7',
          onLabelShow: function(e, el, code) {
            el.html(el.html() + ' (GDP - ' + gdpData[code] + ')');
          }
        });
      });