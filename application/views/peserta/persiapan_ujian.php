<div class="section section-basic" style="margin-top: 30px;">
    <div class="container">
      <div class="row">
         <div class="col-md-12 text-right">
             <div class="title" id="datetime"></div>  
         </div>
         <div class="col-md-12">
            <div class="card card-nav-tabs">
                <div class="card-header card-header-primary">
                   <div class="nav-tabs-navigation">
                      <div class="nav-tabs-wrapper">
                          <ul class="nav nav-tabs" data-tabs="tabs">
                              <li class="nav-item">
                                <div class="nav-link soal">Persiapan Ujian</div>
                              </li>
                          </ul>
                      </div>
                    </div>
                </div> 
                <div class="card-body ">
                    <div class="tab-content">
                      <div class="tab-pane active" id="hasilujian">
                        <div class="container">
                          <div class="row">
                            <div class="col-md-8">
                              <div class="panel panel-default">
                                <div class="panel-body">
                                  <input type="hidden" name="tgl_mulai" id="tgl_mulai" value="<?php echo $waktu_mulai; ?>">
                                  <input type="hidden" name="tgl_terlambat" id="tgl_terlambat" value="<?php echo $waktu_terlambat; ?>">
                                  <input type="hidden" name="id_tes" id="id_tes" value="<?php echo $persiapan['id']?>">
                                  <table class="table table-bordered">
                                    <tr>
                                      <td width="35%" style="font-weight: bold;">Nama</td><td width="65%"><?php echo ucwords(strtolower($nama));?></td>
                                    </tr>
                                    <tr>
                                      <td style="font-weight: bold;">Nama Ujian</td><td><?php echo $persiapan['nama_ujian']?></td>
                                    </tr>
                                    <tr>
                                      <td style="font-weight: bold;">Jumlah Soal</td><td><?php echo $persiapan['jumlah_soal']?></td>
                                    </tr>
                                    <tr>
                                      <td style="font-weight: bold;">Waktu</td><td><?php echo $persiapan['waktu'].' menit' ?></td>
                                    </tr>
                                    <tr>
                                      <td style="font-weight: bold;">Keterlambatan</td><td><?php echo $persiapan['terlambat'].' menit'?></td>
                                    </tr>
                                    <tr>
                                      <td style="font-weight: bold;">Waktu Mulai</td><td><?php echo timehelper($persiapan['tgl_mulai'],'l')?></td>
                                    </tr>
                                  </table>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="alert alert-warning">
                              Waktu boleh mengerjakan ujian adalah saat tombol "MULAI" berwarna hijau..!
                              </div>
                              <?php if($status == 'N') {?>
                                <button class="btn btn-danger btn-lg" id="tbl_habis">Anda Sudah Ikuti Ujian Ini</button>      
                              <?php } else{?>
                                <button class="btn btn-info btn-lg" id="tombol"></button>
                              <?php }?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>