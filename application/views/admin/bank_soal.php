
<nav class="side-navbar">
      <div class="side-navbar-wrapper">
        <div class="sidenav-header d-flex align-items-center justify-content-center">
          <div class="sidenav-header-inner text-center"><img src="<?php echo base_url(); ?>assets/img/logo undip.png" alt="person" class="img-fluid">
           <h2 class="h5 text-uppercase"><?php echo $username; ?></h2><span class="text-uppercase"><?php echo $grup; ?></span>
          </div>
          <div class="sidenav-header-logo"><a href="" class="brand-small text-center"><strong>C</strong><strong class="text-primary">A</strong><strong>T</strong></div>
        </div>
        <div class="admin-menu">
          <ul id="side-admin-menu" class="side-menu list-unstyled">
            <li><a href="<?php echo base_url(); ?>administrator/dashboard"> <i class="fa fa-home"></i><span>Home</span></a></li>
            <li> <a href="<?php echo base_url(); ?>administrator/datapeserta"><i class="fa fa-users"></i><span>Data Peserta</span></a></li>
            <li> <a href="<?php echo base_url(); ?>administrator/kategorisoal"><i class="fa fa-hand-o-right"> </i><span>Kategori Soal</span></a></li>
            <li><a href="<?php echo base_url(); ?>administrator/dataruang"><i class="fa fa-map-marker"></i>&nbsp;<span>Data Ruang</span></a></li>
            <li> <a href="<?php echo base_url(); ?>administrator/soaltrial"><i class="fa fa-pencil"></i><span>Soal Trial</span></a></li>
            <li class="active"> <a href="<?php echo base_url(); ?>administrator/banksoal"><i class="fa fa-pencil"></i><span>Bank Soal</span></a></li>
            <li><a href="<?php echo base_url(); ?>administrator/aktivasisoal"><i class="fa fa-key"></i><span>Aktivasi Soal</span></a></li>    
            <li> <a href="<?php echo base_url(); ?>administrator/dataoperator"> <i class="fa fa-user-circle-o"> </i><span>Data Operator</span></a></li>
            <li> <a href="<?php echo base_url(); ?>administrator/rekapnilai"> <i class="fa fa-check-square-o"> </i><span>Rekap Nilai</span></a></li>
            <li> <a href="<?php echo base_url(); ?>administrator/lihat_laporan"> <i class="fa fa-check-square-o"> </i><span>Rekap Laporan</span></a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="page home-page">
      <!-- navbar-->
      <header class="header">
        <nav class="navbar">
          <div class="container-fluid">
            <div class="navbar-holder d-flex align-items-center justify-content-between">
              <div class="navbar-header">
                <a id="toggle-btn" href="#" class="menu-btn"><i class="icon-bars"> </i></a>
                <a href="<?php echo base_url(); ?>administrator/dashboard" class="navbar-brand">
                  <div class="brand-text d-none d-md-inline-block"><span>Admin Area </span><strong class="text-primary"> Sistem Ujian Online Pasca Sarjana Undip</strong></div>
                </a>
              </div>
              <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                <li class="nav-item"><a href="#" onclick="return get_pass();" class="nav-link ganti-password">Ubah Password <i class="fa fa-lock"></i></a></li>
                <li class="nav-item"><a href="#" onclick="return logout();" class="nav-link logout">Logout<i class="fa fa-sign-out"></i></a></li>
              </ul>
            </div>
          </div>
        </nav>
      </header>
      <div class="breadcrumb-holder">   
        <div class="container-fluid">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>administrator/dashboard">Home</a></li>
            <li class="breadcrumb-item active">Bank Soal</li>
          </ul>
        </div>
      </div>
      <section class="charts">
        <div class="container-fluid">
          <header> 
            <h1 class="h3">Bank Soal</h1>
          </header>
          <div class="row">
            <div class="col-lg-4">
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>Bank Soal</h3>
                  <p>Versi 1</p>
                </div>
                <div class="icon">
                  <i class="fa fa-pencil"></i>
                </div>
                <a href="<?php echo base_url(); ?>administrator/banksoalv1" class="small-box-footer">Klik Disini&nbsp;<i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="small-box bg-success">
                <div class="inner">
                  <h3>Bank Soal</h3>
                  <p>Versi 2</p>
                </div>
                <div class="icon">
                  <i class="fa fa-pencil"></i>
                </div>
                <a href="<?php echo base_url(); ?>administrator/banksoalv2" class="small-box-footer">Klik Disini&nbsp;<i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3>Bank Soal</h3>
                  <p>Versi 3</p>
                </div>
                <div class="icon">
                  <i class="fa fa-pencil"></i>
                </div>
                <a href="<?php echo base_url(); ?>administrator/banksoalv3" class="small-box-footer">Klik Disini&nbsp;<i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>
          <header class="hapus-bank-soal"><h1 class="h3">Hapus Bank Soal</h1></header>
          <div class="row">
            <div class="col-lg-12">
              <div class="alert alert-danger">Untuk menghapus seluruh data bank soal bisa diklik&nbsp;<strong><a href="#" onclick="return soal_h();" style="color: #AA0000;">disini</a></strong>.Lakukan jika seluruh pemakaian sistem selesai digunakan untuk pembersihan data di server</div>
            </div>
          </div>
        </div>
      </section>

