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
            <li><a href="<?php echo base_url(); ?>operator/dashboard"> <i class="fa fa-home"></i><span>Dashboard</span></a></li>
            <li> <a href="<?php echo base_url(); ?>operator/home"><i class="fa fa-book"></i><span>Tata Tertib</span></a></li>
            <li> <a href="<?php echo base_url(); ?>operator/list_peserta"> <i class="fa fa-pencil"></i><span>Data Laporan</span></a></li>
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
              <div class="navbar-header"><a id="toggle-btn" href="#" class="menu-btn"><i class="icon-bars"> </i></a><a href="<?php echo base_url(); ?>operator/dashboard" class="navbar-brand">
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
            <li class="breadcrumb-item">Home</li>
          </ul>
        </div>
      </div>
      <section class="charts">
        <div class="container-fluid">
          <header>
            <h1 class="h3">Detail Laporan</h1>
          </header>
          <div class="row">
            <div class="col-lg-12">
              <div class="card bar-chart-example">
                <div class="card-header d-flex align-items-center row asd">
                  <div class="d-flex p-2">
                    <h2 class="h5 display">Laporan Peserta</h2>
                  </div>
                </div>
                <?php if ($this->session->flashdata('gagal')) :?>
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <strong><i class="fa fa-times-circle-o"></i></strong>&nbsp;&nbsp;<?php echo $this->session->flashdata('gagal'); ?>
                      </div>
                <?php endif;?>
                <div class="card-body">
                <?php echo form_open_multipart(base_url()."operator/list_peserta/simpan_laporan",'class="formlaporan" id="formlaporan"');?>
                  <div class="row">
                    <input type="hidden" name="id_laporan" id="id_laporan" value="<?php echo $id_unik; ?>">
                    <div class="tulis-laporan col-md-2"><label><strong>Nama</strong></label></div>
                    <div class="tulis-laporan col-md-10">
                        <?php echo $username;?>
                    </div>
                    <div class="tulis-laporan col-md-2"><label><strong>No Peserta</strong></label></div>
                    <div class="tulis-laporan col-md-10">
                      <?php echo $no_peserta;?>
                    </div>
                    <div class="tulis-laporan col-md-2"><label><strong>Laporan</strong></label></div>
                    <div class="tulis-laporan col-md-10">
                      <textarea name="laporanpeserta" id="laporanpeserta" class="form-control">
                        <?php echo tampil_jawaban($isi,TRUE);?>
                      </textarea>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-2"></div>
                        <div class="col-md-10">
                          <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;&nbsp;Simpan</button>
                          <a href="<?php echo base_url(); ?>operator/list_peserta" class="btn btn-default"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Kembali</a>
                        </div>
                  </div>
                </form>
                </div>
              </div>
            </div>
            </div>
        </div>
      </section>