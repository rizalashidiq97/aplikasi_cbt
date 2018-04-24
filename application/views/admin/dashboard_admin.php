<nav class="side-navbar">
      <div class="side-navbar-wrapper">
        <div class="sidenav-header d-flex align-items-center justify-content-center">
          <div class="sidenav-header-inner text-center"><img src="<?php echo base_url(); ?>assets/img/logo undip.png" alt="person" class="img-fluid rounded-circle">
            <h2 class="h5 text-uppercase"><?php echo $username; ?></h2><span class="text-uppercase"><?php echo $grup; ?></span>
          </div>
          <div class="sidenav-header-logo"><a href="index.html" class="brand-small text-center"><strong>C</strong><strong class="text-primary">A</strong><strong>T</strong></div>
        </div>
        <div class="admin-menu">
          <ul id="side-admin-menu" class="side-menu list-unstyled">
            <li class="active"><a href="<?php echo base_url(); ?>administrator/dashboard"> <i class="fa fa-home"></i><span>Home</span></a></li>
            <li> <a href="<?php echo base_url(); ?>administrator/datapeserta"><i class="fa fa-users"></i><span>Data Peserta</span></a></li>
            <li> <a href="<?php echo base_url(); ?>administrator/kategorisoal"> <i class="fa fa-hand-o-right"> </i><span>Kategori Soal</span></a></li>
            <li><a href="<?php echo base_url(); ?>administrator/dataruang"><i class="fa fa-map-marker"></i>&nbsp;<span>Data Ruang</span></a></li>
            <li> <a href="<?php echo base_url(); ?>administrator/soaltrial"><i class="fa fa-pencil"></i><span>Soal Trial</span></a></li>
            <li> <a href="<?php echo base_url(); ?>administrator/banksoal"><i class="fa fa-pencil"></i><span>Bank Soal</span></a></li>    
            <li><a href="<?php echo base_url(); ?>administrator/aktivasisoal"><i class="fa fa-key"></i><span>Aktivasi Soal</span></a></li> 
            <li> <a href="<?php echo base_url(); ?>administrator/dataoperator"> <i class="fa fa-user-circle-o"> </i><span>Data Operator</span></a></li>
            <li> <a href="<?php echo base_url(); ?>administrator/rekapnilai"> <i class="fa fa-check-square-o"> </i><span>Rekap Nilai</span></a></li>
            <li> <a href="<?php echo base_url(); ?>administrator/lihat_laporan"> <i class="fa fa-check-square-o"> </i><span>Rekap Laporan</span></a></li>
            </li>
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
              <div class="navbar-header"><a id="toggle-btn" href="#" class="menu-btn"><i class="icon-bars"> </i></a><a href="<?php echo base_url(); ?>administrator/dashboard" class="navbar-brand">
                  <div class="brand-text d-none d-md-inline-block"><span>Admin Area </span><strong class="text-primary"> Sistem Ujian Online Pasca Sarjana Undip</strong></div></a></div>
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
            <li class="breadcrumb-item">Home</li>
          </ul>
        </div>
      </div>
      <section class="statistics section-padding section-no-padding-bottom">
        <div class="container-fluid">
        <header> 
            <h1 class="h3">Statistik & Dashboard</h1>
        </header>
          <div class="row d-flex align-items-stretch custom">
            <div class="col-lg-6">
              <div class="wrapper user-activity">
                <h2 class="display h4">Login Sistem</h2>
                <div id="data-login" class="number"></div>
                <h3 class="h4 display">Peserta</h3>
                <div class="progress">
                  
                </div>
                <div class="page-statistics d-flex justify-content-between">
                  <div class="new-visites"></div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="wrapper income text-center">
                <div class="icon"><i class="fa fa-user"></i></div>
                <div id="data-pendaftar" class="number"></div><strong class="text-primary">Pendaftar</strong>
                <p>Banyaknya pendaftar </p>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="charts">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">
              <div class="card bar-chart-example">
                <div class="card-header d-flex align-items-center row asd">
                  <div class="d-flex p-2">
                    <h2 class="h5 display">Soal Terunggah di Sistem</h2>
                  </div>
                </div>
                <div class="card-body">
                  <?php if($exist_data == 0){ ?>
                          <div class="alert alert-info">Data masih belum terupload</div>
                  <?php 
                        }
                        else{ 
                    ?>
                  <div class="table-responsive container fluid">
                    <table class="display table table-bordered">
                      <thead class="text-center thead-light">
                        <tr>
                          <th width="25%">Kategori</th>
                          <th width="25%">Versi 1</th>
                          <th width="25%">Versi 2</th>
                          <th width="25%">Versi 3</th>
                        </tr>
                      </thead>
                      <tbody> 
                      <?php
                        foreach($data as $datas) {?>
                          <tr>
                            <td><?php echo $datas->kategori;?></td>
                            <td class="text-center"><?php echo $datas->versi1;?>&nbsp;&nbsp;soal</td>
                            <td class="text-center"> <?php echo $datas->versi2;?>&nbsp;&nbsp;soal</td>
                            <td class="text-center"><?php echo $datas->versi3;?>&nbsp;&nbsp;soal</td>
                          </tr>
                      <?php } ?>
                      </tbody>
                    </table>
                  </div>
                  <?php }?>
                </div>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="card bar-chart-example">
                <div class="card-header d-flex align-items-center row asd">
                  <div class="d-flex p-2">
                    <h2 class="h5 display">Statistik Pendaftar Jurusan S-2 Universitas Diponegoro</h2>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="dashboardtable" class="display table table-bordered">
                      <thead class="text-center thead-light">
                        <tr>
                          <th width="10%">No</th>
                          <th width="65%">Nama Prodi</th>
                          <th width="25%">Jumlah Pendaftar</th>
                        </tr>
                      </thead>
                      <tbody> 

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            </div>
        </div>
      </section>