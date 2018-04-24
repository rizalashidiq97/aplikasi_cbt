<div class="section section-basic" style="margin-top: 30px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-right">
                <div class="title" id="datetime"></div>
            </div>
                <div class="card card-nav-tabs">
                    <div class="card-header card-header-info">
                        <div class="nav-tabs-navigation">
                            <div class="nav-tabs-wrapper">
                                <ul class="nav nav-tabs" data-tabs="tabs">
                                    <li class="nav-item">
                                        <div class="nav-link soal">Daftar Tes / Ujian</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div> 
                     <div class="card-body ">
                        <div class="tab-content">
                            <div class="tab-pane active" id="hasilujian">
                                <div class="container">
                                <?php if ($hitung > 0) {?> 
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="15%">Nama Ujian</th>
                                            <th width="10%">Jumlah Soal</th>
                                            <th width="10%">Waktu</th>
                                            <th width="10%">Keterlambatan</th>
                                            <th width="15%">Waktu Mulai</th>
                                            <th width="5%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        $i = 1;
                                        foreach ($list_ujian as $h) { ?>
                                        <tr>
                                            <td class="ctr"><?php echo $i++;?></td>
                                            <td><?php echo $h['nama_ujian']?></td>
                                            <td><?php echo $h['jumlah_soal']?></td>
                                            <td><?php echo $h['waktu'].'&nbsp;menit'?></td>
                                            <td><?php echo $h['terlambat'].'&nbsp;menit'?></td>
                                            <td><?php echo timehelper($h['tgl_mulai'],'l')?></td>  
                                        <?php if($h['status'] == 'Belum Ikut'){ ?>
                                            <td>
                                            <a class="btn btn-info" href="<?php echo base_url(); ?>peserta/persiapan_ujian/<?php echo $h['id'];?>"><i class="material-icons">border_color</i>&nbsp;&nbsp;Ikuti Ujian</a></td>
                                        <?php 
                                            } else if ($h['status'] == 'Sedang Tes'){ ?>
                                            <td>
                                            <a class="btn btn-warning" href="<?php echo base_url(); ?>peserta/soal_ujian/<?php echo $h['id'];?>"><blink><i class="material-icons">border_color</i>&nbsp;&nbsp; Sedang Ujian</blink></a></td>
                                        <?php    
                                            } else if ($h['status'] == 'Waktu Habis'){ ?>
                                            <td>
                                            <a class="btn btn-danger" href="<?php echo base_url(); ?>peserta/soal_ujian/<?php echo $h['id'];?>"><blink><i class="material-icons">cancel</i>&nbsp;&nbsp;Waktu Habis</blink></a></td>
                                        <?php 
                                            } else if ($h['status'] == 'Selesai'){ ?>
                                            <td>
                                            <a class="btn btn-success" href="<?php echo base_url(); ?>peserta/hasil_ujian"><i class="material-icons">done_all</i>&nbsp;&nbsp;Selesai</a></td>
                                        <?php } ?>
                                        </tr>   
                                    <?php } ?>       
                                    </tbody>
                                    </table>
                                <?php }else { ?>
                                <div class="alert alert-danger">
                                    <div class="container">
                                        <div class="alert-icon">
                                            <i class="material-icons">info_outline</i>
                                        </div>
                                        Saat ini masih belum ada data yang masuk
                                    </div>
                                </div>
                                <?php }?>
                            </div>     
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>