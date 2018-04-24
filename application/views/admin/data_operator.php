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
            <li class="active"> <a href="<?php echo base_url(); ?>administrator/dataoperator"> <i class="fa fa-user-circle-o"> </i><span>Data Operator</span></a></li>
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
            <li class="breadcrumb-item active">Data Operator</li>
          </ul>
        </div>
      </div>
      <section class="charts">
        <div class="container-fluid">
          <header> 
            <h1 class="h3">Data Operator</h1>
          </header>
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header d-flex align-items-center row">
                  <div class="d-flex p-2"><h2 class="h5 display">Tabel Data Operator</h2></div>
                    <div class="ml-auto p-2 text-right">
                      <a href="#" class="btn btn-info btn-sm" onclick="return m_operator(0);"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;&nbsp;Tambah data</a>
                    </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="dataoperator" class="display table table-bordered">
                      <thead class="text-center thead-light">
                        <tr>
                          <th width="5%">Id</th>
                          <th width="25%">Username</th>
                          <th width="15%">Id Ruang</th>
                          <th width="15%">Periode</th>
                          <th width="20%">Peran</th>
                          <th class="no-sort" width="20%">Aksi</th>
                        </tr>
                      </thead>
                      <tbody> 

                      </tbody>
                      <tfoot class="text-center thead-light">
                        <tr>
                          <th width="5%">Id</th>
                          <th width="25%">Username</th>
                          <th width="15%">Id Ruang</th>
                          <th width="15%">Periode</th>
                          <th width="20%">Peran</th>
                          <th class="no-sort" width="20%">Aksi</th>
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

      <div id="m_dataoperator" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade">
        <div role="document" class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <div id="header-modal-operator"></div>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <form name="edit_operator" id="edit_operator" onsubmit="return m_simpan_operator();">
              <div class="modal-body">
                  <input type="hidden" name="id" id="id" value="0">
                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                  <table class="table table-form">
                    <tr>
                      <td style="width: 25%">Username</td>
                      <td style="width: 75%">
                        <input type="text" class="form-control" name="username" id="user_operator" required>
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 25%">Peran</td>
                      <td style="width: 75%">
                        <select name="peran" id="peran" class="form-control" required>
                          <option value="">-</option>
                          <option value="operator ruangan">Operator Ruangan</option>
                          <option value="operator utama">Operator Utama</option>
                        </select>
                      </td>
                    </tr>
                    <tr id="tr-idruang">
                       <td style="width: 25%">Id Ruang</td>
                        <td style="width: 75%">
                         <?php echo form_dropdown('idruang',$id_ruang,'','class="form-control" id="idruang" required');?> 
                       </td>  
                    </tr>
                    <tr id="tr-periode">
                      <td style="width: 25%">Periode</td>
                      <td style="width: 75%"><input type="number" class="form-control" name="periode" id="periode" min="1">
                      </td>
                    </tr>
                    <tr>
                      <td id="label-password" style="width: 25%"></td>
                      <td style="width: 75%">
                        <div class="input-group">
                          <input type="password" class="form-control" name="password" id="password">
                            <span class="input-group-btn">
                              <button class="btn btn-info" type="button" id="see_pass"><i class="fa fa-eye"></i></button>
                            </span> 
                        </div>
                      </td>
                    </tr>
                  </table>
              </div>
              <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-secondary"><i class="fa fa-close"></i>&nbsp;&nbsp;Tutup</button>
                <button class="btn btn-primary"><i class="fa fa-check-square-o"></i>&nbsp;&nbsp;Simpan</button>
              </div>
            </form>         
          </div>
        </div>
      </div>