<div class="section section-basic" style="margin-top: 30px;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <div class="title" id="datetime">
                        </div>  
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center" style="margin-bottom: 30px;">
                        <div class="title">
                            <h2 style="font-weight: bold;">HASIL UJIAN</h2>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="title">
                            <div class="alert alert-rose">
                                    <table class="table" id="peserta_hasil">
                                        <tr>
                                            <td width="25%" class="baris_nama"><h4>Nama</h4></td>
                                            <td width="75%" class="baris_nama"><h4><?php echo ucwords(strtolower($nama));?></h4></td>
                                        </tr>
                                        <tr>
                                            <td width="25%" class="baris_nama"><h4>No.Ujian</h4></td>
                                            <td width="75%" class="baris_nama"><h4><?php echo $no_ujian; ?></h4></td>
                                        </tr>
                                    </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                    <div class="col-md-4">
                        <div class="title">
                            <?php if($jumlah_nilai > 0){ ?>
                            <div class="alert alert-success">
                                <table class="table" id="peserta_nilai">
                                    <tr>
                                        <td width="75%" class="baris_nilai"><h4>Total Jumlah Benar</h4></td>
                                        <td width="25%" class="baris_nilai text-center"><h4 id="asu"><?php echo $nilai->total?></h4></td>
                                    </tr>
                                    <tr>
                                        <td width="75%" class="baris_nilai"><h4>Total Nilai</h4></td>
                                        <td width="25%" class="baris_nilai text-center"><h4 id="asu"><?php echo $nilai->nilai?></h4></td>
                                    </tr>
                                </table>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                             <div class="card card-nav-tabs">
                                <div class="card-header card-header-info">
                                   <div class="nav-tabs-navigation">
                                        <div class="nav-tabs-wrapper">
                                            <ul class="nav nav-tabs" data-tabs="tabs">
                                             <li class="nav-item">
                                                <div class="nav-link soal">
                                                    List hasil Ujian
                                                </div>
                                             </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div> 
                            <div class="card-body ">
                                <div class="tab-content">
                                  <div class="tab-pane active" id="hasilujian">
                                    <?php if ($jumlah_baris == 0){ ?>
                                        <div class="alert alert-danger">
                                            <div class="container">
                                                <div class="alert-icon">
                                                    <i class="material-icons">info_outline</i>
                                                </div>
                                                Saat ini masih belum ada data yang masuk
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="text-center">
                                                <tr>
                                                    <th width="5%">No</th>
                                                    <th width="25%">Nama Ujian</th>
                                                    <th width="25%">Kategori</th>
                                                    <th width="20%">Jumlah Soal</th>
                                                    <th width="20%">Jumlah Benar</th>  
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php echo $html;?>
                                            </tbody>
                                        </table>
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