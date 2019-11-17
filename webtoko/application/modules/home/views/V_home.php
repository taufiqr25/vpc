    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <!--overview start-->
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-laptop"></i> Dashboard</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="<?php echo base_url() ;?>home">Home</a></li>
              <li><i class="fa fa-laptop"></i>Dashboard</li>
            </ol>
          </div>
        </div>

        <div class="row">

          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="info-box brown-bg">
              <i class="fa fa-shopping-cart"></i>
              <div class="title" style="font-size: 25px">Pendapatan Hari Ini</div>
                            <div class="count" style="font-size:22px">Rp <?php echo number_format($orderhariini[0]->total,0,"",".")?></div>
            </div>
       
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="info-box blue-bg">
              <i class="fa fa-book"></i>
              <div class="title" style="font-size: 25px">Jumlah Barang Yang Paling Sedikit</div>
                            <div class="count" style="font-size:22px"><?php echo $minimalbarang[0]->nama_sub_produk?> : <?php echo $minimalbarang[0]->jumlah_sub_produk?> barang </div>
            </div>
            <!--/.info-box-->
          </div>
          <!--/.col-->


    

        <!--   <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box dark-bg">
              <i class="fa fa-thumbs-o-up"></i>
              <div class="count">4.362</div>
              <div class="title">Order</div>
            </div>

          </div>


          <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
              <i class="fa fa-cubes"></i>
              <div class="count">1.426</div>
              <div class="title">Stock</div>
            </div> -->

          </div>
          <!--/.col-->

        </div>