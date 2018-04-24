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
            <li> <a href="<?php echo base_url(); ?>administrator/kategorisoal"> <i class="fa fa-hand-o-right"> </i><span>Kategori Soal</span></a></li>
            <li><a href="<?php echo base_url(); ?>administrator/dataruang"><i class="fa fa-map-marker"></i>&nbsp;<span>Data Ruang</span></a></li>
            <li class="active"> <a href="<?php echo base_url(); ?>administrator/soaltrial"><i class="fa fa-pencil"></i><span>Soal Trial</span></a></li>
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
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>administrator/soaltrial">Data Soal Trial</a></li>
            <li class="breadcrumb-item active"><?php echo $judul;?></li>
          </ul>
        </div>
      </div>
      <section class="charts">
        <div class="container-fluid">
          <header> 
            <h1 class="h3">Data Soal Trial</h1>
          </header>
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header d-flex align-items-center row asd">
                  <div class="d-flex p-2"><h2 class="h5 display"><?php echo $judul;?></h2></div>
                </div>
                <div class="card-body">
                  <?php if ($this->session->flashdata('gagal')) :?>
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <strong><i class="fa fa-times-circle-o"></i></strong>&nbsp;&nbsp;<?php echo $this->session->flashdata('gagal'); ?>
                      </div>
                  <?php endif;?>
                    <?php echo form_open_multipart(base_url()."administrator/soaltrial/simpan",'class="formtrial" id="formtrial"');?>
                    <input type="hidden" name="mode" id="mode" value="<?php echo $data['mode']; ?>">
                    <input type="hidden" name="id" id="id" value="<?php echo $data['id']; ?>">
                      <div class="row">
                        <div class="col-md-2"><label><strong>Kategori</strong></label></div>
                        <div class="col-md-10">
                          <input type="text" name="kategori" id="kategori" class="form-control" value="<?php echo $data['kategori'];?>" required>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-2"><label><strong>Soal</strong></label></div>
                        <div class="col-md-10">
                          <textarea name="soal" id="soal" class="form-control">
                            <?php echo tampil_jawaban($data['soal'],TRUE);?>
                          </textarea>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12 text-center"><strong>-------------- Pilihan / Opsi --------------</strong></div>
                      </div>
                      <div class="row">
                        <div class="col-md-2"><label><strong>Opsi A</strong></label></div>
                        <div class="col-md-10">
                          <textarea name="opsia" id="opsia" class="form-control">
                            <?php echo tampil_jawaban($data['opsi_a'],TRUE);?>
                          </textarea>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-2"><label><strong>Opsi B</strong></label></div>
                        <div class="col-md-10">
                          <textarea name="opsib" id="opsib" class="form-control">
                            <?php echo tampil_jawaban($data['opsi_b'],TRUE); ?>
                          </textarea>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-2"><label><strong>Opsi C</strong></label></div>
                        <div class="col-md-10">
                          <textarea name="opsic" id="opsic" class="form-control">
                            <?php echo tampil_jawaban($data['opsi_c'],TRUE); ?>
                          </textarea>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-2"><label><strong>Opsi D</strong></label></div>
                        <div class="col-md-10">
                          <textarea name="opsid" id="opsid" class="form-control">
                            <?php echo tampil_jawaban($data['opsi_d'],TRUE); ?>
                          </textarea>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-2"><label><strong>Jawaban</strong></label></div>
                        <div class="col-md-2">
                          <select class="form-control" name="jawaban" id="jawaban" required>
                            <option value=""></option>
                          <?php 
                            for($i = 0; $i < 4;$i++){
                              $pil_opsi = $huruf_opsi[$i];
                              if($data['jawaban'] == $pil_opsi){
                                echo '<option value="'.$pil_opsi.'" selected>'.$pil_opsi.'</option>';
                              }
                              else{
                                echo '<option value="'.$pil_opsi.'">'.$pil_opsi.'</option>';
                              } 
                            }
                          ?>
                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-10">
                          <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;&nbsp;Simpan</button>
                          <a href="<?php echo base_url(); ?>administrator/soaltrial" class="btn btn-default"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Kembali</a>
                        </div>
                      </div>
                      <?php echo form_close();?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>