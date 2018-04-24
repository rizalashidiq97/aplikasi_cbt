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
                                            <div class="nav-link soal">
                                                    Soal Trial 
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div> 
                        <div class="card-body ">
                            <div class="tab-content">
                                <div class="tab-pane active" id="hasilujian">
                                    <div class="container">
                                    <?php if ($trial1['jumlah_soal_trial'] == 0){ ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="alert alert-danger">
                                                    <div class="container">
                                                        <div class="alert-icon">
                                                            <i class="material-icons">info_outline</i>
                                                        </div>
                                                        Saat ini masih belum ada data soal
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="panel panel-default">
                                                  <div class="panel-body">
                                                    <table class="table table-bordered">
                                                      <tr>
                                                        <td width="35%" style="font-weight: bold;">Nama</td><td width="65%"><?php echo ucwords(strtolower($nama));?></td>
                                                      </tr>
                                                      <tr>
                                                        <td style="font-weight: bold;">Nama Ujian</td><td><?php echo $trial['nama_ujian']?></td>
                                                      </tr>
                                                      <tr>
                                                        <td style="font-weight: bold;">Jumlah Soal</td>
                                                        <td><?php echo $trial1['jumlah_soal_trial']?></td>
                                                      </tr>
                                                      <tr>
                                                        <td style="font-weight: bold;">Waktu</td>
                                                        <td><?php echo $trial['waktu'].' menit' ?></td>
                                                      </tr>
                                                      <tr>
                                                      <?php if(!is_null($trial['nilai'])){?>
                                                          <td style="font-weight: bold;">Hasil Ujian</td>
                                                          <td><?php echo $trial['nilai'].'/100';?></td>
                                                      <?php }?>
                                                      </tr>
                                                    </table>
                                                  </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="alert alert-warning">
                                                  Waktu boleh mengerjakan ujian adalah saat tombol "MULAI" berwarna hijau..!
                                                </div>
                                                <?php if(is_null($trial['status'])) {?>
                                                <a href="<?php echo base_url(); ?>peserta/main_soal_trial" class="btn btn-success btn-lg" id="tbl_mulai"><i class="material-icons" style="vertical-align:middle;">done</i>&nbsp;&nbsp;MULAI</a>
                                                <?php }else if($trial['status'] == 'N'){ ?>
                                                <button class="btn btn-danger btn-lg" id="tbl_selesai">Trial sudah di ikuti</button>
                                                <?php }?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>