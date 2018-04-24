
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
            <li> <a href="<?php echo base_url(); ?>administrator/soaltrial"><i class="fa fa-pencil"></i><span>Soal Trial</span></a></li>
            <li> <a href="<?php echo base_url(); ?>administrator/banksoal"><i class="fa fa-pencil"></i><span>Bank Soal</span></a></li>
            <li><a href="<?php echo base_url(); ?>administrator/aktivasisoal"><i class="fa fa-key"></i><span>Aktivasi Soal</span></a></li>    
            <li> <a href="<?php echo base_url(); ?>administrator/dataoperator"> <i class="fa fa-user-circle-o"> </i><span>Data Operator</span></a></li>
            <li> <a href="<?php echo base_url(); ?>administrator/rekapnilai"> <i class="fa fa-check-square-o"> </i><span>Rekap Nilai</span></a></li>
            <li class="active"> <a href="<?php echo base_url(); ?>administrator/lihat_laporan"> <i class="fa fa-check-square-o"> </i><span>Rekap Laporan</span></a></li>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    
    <div id="m_laporan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade">
        <div role="document" class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <div id="header-modal-laporan">Detail Laporan</div>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
              <div class="modal-body" id="isilaporan"></div>
              <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-secondary"><i class="fa fa-close"></i>&nbsp;&nbsp;Tutup</button>
              </div>         
          </div>
        </div>
      </div>

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
            <li class="breadcrumb-item active">Rekap Laporan</li>
          </ul>
        </div>
      </div>
      <section class="charts">
        <div class="container-fluid">
          <header> 
            <h1 class="h3">Hasil Rekap Laporan</h1>
          </header>
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header d-flex align-items-center row">
                  <div class="d-flex p-2" style="margin-top: 8px;">
                    <h2 class="h5 display" style="width: 6vw;padding-top: 6px;">Periode : </h2>
                    <select name="periode" id="periode" class="periode form-control">
                      <optgroup label="Pilih Periode">
                          <option value="">Semua</option>
                        <?php foreach($periode as $p){?>
                          <option value="<?php echo $p->periode?>"><?php echo $p->periode?></option>
                        <?php } ?>
                      </optgroup>
                    </select>
                  </div>
                  <div class="ml-auto p-2 text-right">
                    <button class="btn btn-info btn-sm" id="refresh_laporan"><i class="fa fa-refresh" aria-hidden="true"></i>&nbsp;&nbsp;Refresh</button>
                    <a id="cetak_laporan" href="#" class="btn btn-success btn-sm "><i class="fa fa-download" aria-hidden="true"></i>&nbsp;&nbsp;Export ke Excel</a>
                    <button onclick="return hapus_laporan();" class="btn btn-danger btn-sm "><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;&nbsp;Reset Data</button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="lihat_laporan" class="display table table-bordered">
                      <thead class="text-center thead-light">
                        <tr>
                          <th width="5%">Id</th>
                          <th width="20%">Nama</th>
                          <th width="20%">No Peserta</th>
                          <th width="20%">Pilih Prodi</th>
                          <th width="5%">Periode</th>
                          <th class="no-sort" width="10%">Aksi</th>
                        </tr>
                      </thead>
                      <tbody> 
                      </tbody>
                      <tfoot class="text-center thead-light">
                        <tr>
                          <th width="5%">Id</th>
                          <th width="20%">Nama</th>
                          <th width="20%">No Peserta</th>
                          <th width="20%">Pilih Prodi</th>
                          <th width="5%">Periode</th>
                          <th class="no-sort" width="10%">Aksi</th>
                        </tr>
                      </tfoot>
                    </table>
                </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

