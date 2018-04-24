<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Soal <?php echo $kategori->kategori ;?> - Sistem Ujian Online Universitas Diponegoro</title>
    <link rel="icon" href="<?php echo base_url(); ?>assets/img/logo undip.png">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets_peserta/css/material-kit.css?v=2.0.0">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/sweetalert2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/toastr/build/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/assets_peserta/css/demo.css">

    <!--     Fonts and icons     -->
    
  </head>
   <body class="index-page" style="background: url(&apos;/Aplikasi_CBT/assets/img/back02.jpg&apos;)">
    <!-- Navigation -->
    <nav class="navbar navbar-color-on-scroll fixed-top navbar-expand-lg" color-on-scroll="100" id="sectionsNav">
        <div class="container">
            <div class="navbar-translate">
                <a class="navbar-brand" href="./index.html"><img src="<?php echo base_url(); ?>assets/img/logo undip.png" style="max-width: 100%;height: 50px;" alt=""></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    <span class="navbar-toggler-icon"></span>
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <strong class="nav-link brand">Sistem Ujian Online Universitas Diponegoro </strong> 
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                     <li class="dropdown nav-item">
                        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                            <i class="material-icons">account_circle</i>
                        </a>                
                        <div class="dropdown-menu dropdown-with-icons">
                            <a href="javascript:void(0)" class="dropdown-item">
                                <i class="material-icons">account_circle</i> <?php echo ucwords(strtolower($nama));?> (<?php echo $no_ujian;?>)
                            </a>
                            <a href="<?php echo base_url(); ?>siswa/index" class="dropdown-item">
                                <i class="material-icons">exit_to_app</i> Log Out
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="section section-basic" style="margin-bottom: 30px;">
        <div class="section-tabs">
            <div id="nav-tabs">
                <div class="baris">
                    <div class="col-md-8">
                        <form role="form" name="_form" method="post" id="_form">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <div class="card card-nav-tabs">
                              <div class="card-header card-header-primary">
                               <div class="nav-tabs-navigation">
                                <div class="nav-tabs-wrapper">
                                 <ul class="nav nav-tabs" data-tabs="tabs">
                                  <li class="nav-item">
                                    <div class="nav-link soal">
                                      Soal Ke <div class="btn btn-info btn-sm" id="soalke" style="padding: 0.220625rem 1.25rem;"></div>
                                    </div>
                                   </li>
                                   <li class="nav-item ml-auto">
                                    <div class="nav-link soal">
                                        <div class="btn btn-success btn-sm" style="padding: 0.220625rem 1.25rem;"><p style="margin: 0;font-size: 14px;"><b><?php echo strtoupper($kategori->kategori);?></b></p></div>
                                    </div>
                                   </li>
                                   <li class="nav-item ml-auto">
                                    <div class="nav-link soal">
                                      <div class="btn btn-sm" style="padding: 0.120625rem 1.25rem;margin: 4px;font-size: 16px;" id="waktu_countdown"></div> 
                                    </div>
                                   </li>
                                  </ul>
                                </div>
                               </div>
                              </div> 
                            <div class="card-body ">
                                <div class="tab-content" style="position: relative;">
                                    <div class="tab-pane active" id="profile">
                                       <div class="ajax-load" style="display: none;"><img src="/Aplikasi_CBT/assets/img/giphy.gif" alt=""></div>
                                        <?php echo $html;?>        
                                    </div>
                                </div>
                            </div>
                           <div class="card-footer baris">
                                <a class="btn btn-soal-bottom btn-info btn-lg" id="back" onclick="return back();" style="color:#fff;"><strong><i class="material-icons">keyboard_arrow_left</i>&nbsp;&nbsp;Prev</strong></a>
                                <a class="btn btn-soal-bottom btn-info btn-lg" id="next" onclick="return next();" style="color:#fff;"><strong><i class="material-icons">keyboard_arrow_right</i>&nbsp;&nbsp;Next</strong></a>
                                <a class="btn btn-soal-bottom btn-success btn-lg ml-auto" id="submit" onclick="return simpan();" style="color:#fff;"><strong><i class="material-icons">done_all</i>&nbsp;&nbsp;Simpan</strong></a>
                                <input type="hidden" name="jml_soal" value="<?php echo $no; ?>">
                            </div>
                            </form> 
                           </div>
                        </div>   
                                <div class="col-md-4">
                                    <div class="card card-nav-tabs">
                                        <div class="card-header card-header-rose">
                                            <div class="nav-tabs-navigation">
                                                <div class="nav-tabs-wrapper">
                                                    <ul class="nav nav-tabs" data-tabs="tabs">
                                                        <li class="nav-item">
                                                        <div class="nav-link" >
                                                                Navigasi Soal
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="card-body ">
                                            <div class="tab-content">
                                                <div class="tab-pane active tampil_jawaban" id="profile">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>   
                        </div>
                    </div>
    </div>

    <footer class="footer ">
        <div class="container">
            <div class="copyright center">
                &copy;
                <script>
                    document.write(new Date().getFullYear())
                </script>, 
                <a href="https://www.creative-tim.com" target="_blank">Universitas Diponegoro</a> 
            </div>
        </div>
    </footer>

    <!-- /.container -->

    <!-- Bootstrap core JavaScript -->
    <script src="<?php echo base_url(); ?>assets/assets_peserta/js/core/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/assets_peserta/js/core/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/assets_peserta/js/bootstrap-material-design.js"></script>
    <!--  Plugin for Date Time Picker and Full Calendar Plugin  -->
    <script src="<?php echo base_url(); ?>assets/vendor/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/toastr/build/toastr.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/countdown/jquery.plugin.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/countdown/jquery.countdown.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/assets_peserta/js/plugins/moment-locale.min.js"></script>
    <!-- Material Kit Core initialisations of plugins and Bootstrap Material Design Library -->
    <script src="<?php echo base_url(); ?>assets/assets_peserta/js/material-kit.js?v=2.0.0"></script>
    <script>
        $.ajaxSetup({
            data: {
                "<?php echo $this->security->get_csrf_token_name(); ?>" : "<?php echo $this->security->get_csrf_hash(); ?>"
            }
        });
        var base_url = '<?php echo base_url();?>';
        id_tes = '<?php echo $id_tes;?>';

        $(document).ready(function() {
            hitung();
            simpan();      
            buka(1);
        });

        soal = $('.step');
        total_soal = soal.length;

        next = function() {
            var berikutnya  = $("#next").attr('rel');
            berikutnya = parseInt(berikutnya);
            berikutnya = berikutnya > total_soal ? total_soal : berikutnya;

            $("#soalke").html('<p style="margin: 0;font-size: 14px;"><b>'+berikutnya+'</b></p>');

            $("#next").attr('rel', (berikutnya+1));
            $("#back").attr('rel', (berikutnya-1));
            
            var sudah_akhir = berikutnya == total_soal ? 1 : 0;

            $(".step").hide();
            $("#soal_"+berikutnya).show();

            if (sudah_akhir == 1) {
                $("#back").show();
                $("#next").hide();
                $("#submit").show();
            } else if (sudah_akhir == 0) {
                $("#next").show();
                $("#back").show();
                $("#submit").hide();
            }

            simpan();
        }

        back = function() {
            var back  = $("#back").attr('rel');
            back = parseInt(back);
            back = back < 1 ? 1 : back;
            $("#soalke").html('<p style="margin: 0;font-size: 14px;"><b>'+back+'</b></p>');
            
            $("#back").attr('rel', (back-1));
            $("#next").attr('rel', (back+1));

            $(".step").hide();
            $("#soal_"+back).show();

            var sudah_awal = back == 1 ? 1 : 0;
            
            if (sudah_awal == 1) {
                $("#back").hide();
                $("#next").show();
                $("#submit").hide();
            } else if (sudah_awal == 0) {
                $("#next").show();
                $("#back").show();
                $("#submit").hide();
            }
            simpan();
            
        }

        buka = function(id_soal) {
            $("#next").attr('rel',(id_soal+1));
            $("#back").attr('rel',(id_soal-1));
            if(id_soal != 1){
                back();
                next();
            }
            else if(total_soal < 2){
                $("#back").hide();
                $("#next").hide();
                $("#submit").show();
            }
            else{
                $("#back").hide();
                $("#next").show();
                $("#submit").hide();
            }    
            $("#soalke").html('<p style="margin: 0;font-size: 14px;"><b>'+id_soal+'</b></p>');
            $(".step").hide();
            $("#soal_"+id_soal).show();

            simpan();
        }

        simpan = function(){
            var data = $('#_form').serialize();
            $('.ajax-load').show();
            $.ajax({
                type : "POST",
                url : base_url+"peserta/simpan_jwb/"+id_tes,
                data : data,     
            }).done(function(response){
                $('.ajax-load').hide();
                var hasil_jawaban = "";
                var panjang_arr = response.data.length;
                for(var i = 0;i < panjang_arr;i++){
                    if(response.data[i] != ""){
                        hasil_jawaban += '<button class="btn btn-soal btn-success btn-sm" onclick="return buka('+(i+1)+');">'+(i+1)+'. '+response.data[i]+'</button>';
                    }
                    else{
                        hasil_jawaban += '<button class="btn btn-soal btn-warning btn-sm" onclick="return buka('+(i+1)+');">'+(i+1)+'. -</button>';
                    }
                }
                $(".tampil_jawaban").html(hasil_jawaban);
            });
            return false;
        } 

        hitung = function() {
            <?php 
                $tgl_selesai = $jam_selesai;
                $tgl_selesai = strtotime($tgl_selesai);
                $tgl_baru = date('F j, Y H:i:s', $tgl_selesai);
            ?>

            var waktu_selesai = new Date('<?php echo $tgl_baru; ?>');
            $('#waktu_countdown').countdown(
                {   
                    until: waktu_selesai, 
                    serverSync: dari_server,
                    alwaysExpire: true, 
                    format: 'HMS', 
                    compact: true,
                    onTick:highlightbutton, 
                    onExpiry: selesai
                }
            );
        }

        function toastr_info(message){
            toastr.info(message,'Info',{
                timeOut: 2000,
                "positionClass": "toast-top-center",
                "progressBar": true
            });
        }

        function highlightbutton(periods){
            $(this).addClass('btn-success');
            var time_left = $.countdown.periodsToSeconds(periods);
            if(time_left === 900){
                toastr_info('Waktu tersisa 15 menit..');
            }
            else if(time_left === 300){
                toastr_info('Waktu tersisa 5 menit..');
            }
            else if (time_left <= 300 && time_left > 60){
                $(this).removeClass('btn-success').addClass('btn-warning');
            }
            else if (time_left === 60) {
                toastr_info('Waktu tersisa 1 menit..'); 
            }
            else if(time_left <= 60){
                $(this).removeClass('btn-warning').addClass('btn-danger'); 
            } 
        }

        dari_server = function() { 
            var time = null; 
            $.ajax({
                url: base_url+'peserta/get_servertime', 
                async: true, 
                dataType: 'text', 
                success: function(text) { 
                    time = new Date(text); 
                }, 
                error: function(http, message, exc) { 
                    time = new Date(); 
                }
            }); 
            return time; 
        }

        selesai = function(){
            swal({
              title: 'Waktu Habis !',
              text: 'Halaman ini akan ditutup dalam 3 detik',
              timer: 3000,
              type: 'error',
              allowOutsideClick: false,
              onOpen: () => {swal.showLoading()}
            }).then((result) => {
                var data = $('#_form').serialize();
                    $.ajax({
                        type: "POST",
                        url: base_url+"peserta/hitung_nilai/"+id_tes,
                        data : data,
                    }).done(function(response) {
                        if (response.status == "ok") {
                            window.location.assign(base_url+"peserta/hasil_ujian"); 
                        } else {
                            localStorage.setItem("gagal",response.msg);
                            window.location.assign(base_url+"peserta/hasil_ujian");
                        }
                    });
                });              
            return false;
        }
    </script>
  </body>

</html>