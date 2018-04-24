<nav class="side-navbar">
      <div class="side-navbar-wrapper">
        <div class="sidenav-header d-flex align-items-center justify-content-center">
          <div class="sidenav-header-inner text-center"><img src="<?php echo base_url(); ?>assets/img/logo undip.png" alt="person" class="img-fluid rounded-circle">
            <h2 class="h5 text-uppercase"><?php echo $user;?></h2><span class="text-uppercase"><?php echo $grup ;?></span>
          </div>
          <div class="sidenav-header-logo"><a href="index.html" class="brand-small text-center"><strong>C</strong><strong class="text-primary">A</strong><strong>T</strong></div>
        </div>
        <div class="admin-menu">
          <ul id="side-admin-menu" class="side-menu list-unstyled">
            <li class="active"><a href="<?php echo base_url(); ?>operatorv1/dashboard"> <i class="fa fa-home"></i><span>Dashboard</span></a></li>
            <li> <a href="<?php echo base_url(); ?>operatorv1/tatib"><i class="fa fa-book"></i><span>Tata Tertib</span></a></li>
            <li> <a href="<?php echo base_url(); ?>operatorv1/daftar_peserta"> <i class="fa fa-list"></i><span>Daftar Peserta</span></a></li>
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
              <div class="navbar-header"><a id="toggle-btn" href="#" class="menu-btn"><i class="icon-bars"> </i></a><a href="<?php echo base_url(); ?>operatorv1/dashboard" class="navbar-brand">
                  <div class="brand-text d-none d-md-inline-block"><span>Operator Area </span><strong class="text-primary"> Sistem Ujian Online Pasca Sarjana Undip</strong></div></a></div>
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
            <li class="breadcrumb-itema active">Dashboard</li>
          </ul>
        </div>
      </div>
      <section class="charts">
        <div class="container-fluid">
            <header>
              <h1 class="h3">Dashboard</h1>
            </header>
          <div class="row">
            <div class="col-lg-12">
              <div class="card bar-chart-example">
                <div class="card-header d-flex align-items-center row asd">
                  <div class="d-flex p-2">
                    <h2 class="h5 display">Data Pribadi</h2>
                  </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive container fluid">
                    <table class="display table table-bordered">
                      <tbody> 
                          <tr>
                            <td width="25%"><strong>Nama</strong></td>
                            <td width="75%"><?php echo $user;?></td>
                          </tr>
                          <tr>
                            <td width="25%"><strong>Peran</strong></td>
                            <td width="75%"><?php echo $grup;?></td>
                          </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="card bar-chart-example">
                <div class="card-header d-flex align-items-center row asd">
                  <div class="d-flex p-2">
                    <h2 class="h5 display">Keberlangsungan Ujian Saat Ini</h2>
                  </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive container fluid">
                    <table class="display table table-bordered">
                      <tbody> 
                          <tr>
                            <td width="25%"><strong>Banyak Soal Yang Telah Diuji</strong></td>
                            <td id="banyak_soal" width="75%"></td>
                          </tr>
                          <tr>
                            <td width="25%"><strong>Kategori</strong></td>
                            <td id="kategori-uji" width="75%"></td>
                          </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            </div>
        </div>
      </section>