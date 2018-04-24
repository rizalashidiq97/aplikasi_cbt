
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
            <li class="active"> <a href="<?php echo base_url(); ?>administrator/rekapnilai"> <i class="fa fa-check-square-o"> </i><span>Rekap Nilai</span></a></li>
            <li> <a href="<?php echo base_url(); ?>administrator/lihat_laporan"> <i class="fa fa-check-square-o"> </i><span>Rekap Laporan</span></a></li>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div id="m_nilai" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade">
        <div role="document" class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <div id="header-modal-nilai">Detail Nilai</div>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
              <div class="modal-body">
                <div class="row" style="padding: 6px;">
                    <div class="col-md-2" style="padding-top: 8px;font-size: 0.9em;">Nama <div class="pull-right">:</div></div>
                    <div class="col-md-9" id="nama" style="padding-top: 8px;font-size: 0.9em;padding-left: 0;"></div>
                </div>
                <div class="row" style="padding: 6px;">
                    <div class="col-md-2" style="padding-top: 8px;font-size: 0.9em;">No Peserta <div class="pull-right">:</div></div>
                    <div class="col-md-9" id="nopeserta" style="padding-top: 8px;font-size: 0.9em;padding-left: 0;"></div>
                </div><br>
                <div class="row" style="padding: 6px;">
                    <div class="col-md-6" style="padding-top: 8px;font-size: 0.9em;"><b>Daftar Nilai Per Kategori :</b></div>
                </div>
                <div id="data-nilai"></div>
              </div>
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
            <li class="breadcrumb-item active">Hasil Rekap Nilai</li>
          </ul>
        </div>
      </div>
      <section class="charts">
        <div class="container-fluid">
          <header> 
            <h1 class="h3">Hasil Rekap Nilai</h1>
          </header>
          <div class="alert alert-info">
            <div style="margin-bottom: 5px;">Status ujian saat ini&nbsp;&nbsp;: </div>
            <div class="table-responsive">
              <table id="tabel-ujian" class="display table">
                  <tbody> 
                    <tr>
                      <td width="25%"><strong>Banyak Soal</strong></td>
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
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header d-flex align-items-center row">
                  <div class="d-flex p-2">
                    <h2 class="h5 display" style="width: 17vw;padding-top: 10px;">Pilih Berdasarkan :</h2>
                    <select name="pilih_rekap" id="pilih_rekap" class="form-control">
                      <option value="">Hasil Tes Ujian</option>
                      <option value="trial">Hasil Tes Trial</option>
                    </select>
                  </div>
                    <div class="ml-auto p-2 text-right">
                      <button class="btn btn-info btn-sm" id="refresh_ujian"><i class="fa fa-refresh" aria-hidden="true"></i>&nbsp;&nbsp;Refresh</button>
                      <a id="link-rekap" href="<?php echo base_url(); ?>export/excelrata2" class="btn btn-success btn-sm "><i class="fa fa-download" aria-hidden="true"></i>&nbsp;&nbsp;Export ke Excel</a>
                      <button class="btn btn-danger btn-sm" onclick="return h_soalaktivasi();" data-toggle="tooltip" data-placement="top" title="Aksi ini akan menghapus semua data nilai keseluruhan"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;&nbsp;Reset data</button>
                    </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="rekapnilaiavg" class="display table table-bordered">
                    </table>
                </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

