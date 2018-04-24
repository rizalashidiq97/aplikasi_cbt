<?php 
    $uri2 = $this->uri->segment(2);
    $uri3 = $this->uri->segment(3); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="icon" href="<?php echo base_url(); ?>assets/img/logo undip.png">
    <title><?php echo $title;?></title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/sweetalert2/dist/sweetalert2.min.css">
    <!-- toastr js -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/toastr/build/toastr.min.css">
    <!-- Documentation extras -->
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets_peserta/css/material-kit.css?v=2.0.0">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/assets_peserta/css/demo.css">
</head>
<?php if($uri2 == 'home'){ ?>
    <body filter-color="black" style="background: url(&apos;/Aplikasi_CBT/assets/img/back01.jpg&apos;) no-repeat center center fixed;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">
<?php }else{ ?>
    <body class="index-page" style="background: url(&apos;/Aplikasi_CBT/assets/img/back02.jpg&apos;)">
<?php } ?>
<!-- Navigation -->
    <nav class="navbar navbar-color-on-scroll fixed-top navbar-expand-lg" color-on-scroll="100" id="sectionsNav">
        <div class="container">
            <div class="navbar-translate">
                <a class="navbar-brand" href="<?php echo base_url(); ?>peserta/home"><img src="<?php echo base_url(); ?>assets/img/logo undip.png" style="max-width: 100%;height: 50px;" alt=""></a>
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
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url(); ?>peserta/home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url(); ?>peserta/data_pribadi">Data Pribadi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url(); ?>peserta/persiapan_trial_ujian">
                             Test Trial
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url(); ?>peserta/list_ujian">
                             Soal Ujian
                        </a>
                    </li>
                     <li class="dropdown nav-item">
                        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                            <i class="material-icons">account_circle</i>
                        </a>                
                        <div class="dropdown-menu dropdown-with-icons">
                            <a href="javascript:void(0)" class="dropdown-item">
                                <i class="material-icons">account_circle</i> <?php echo ucwords(strtolower($nama));?> (<?php echo $no_ujian;?>)
                            </a>
                            <a href="#" onclick="return logout();" class="dropdown-item">
                                <i class="material-icons">exit_to_app</i> Log Out
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div id="modal-logout">
        <div id="m_logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade">
        <div role="document" class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <div id="header-modal">Logout Sistem</div>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
              <div class="modal-body">
                  Apa kamu ingin keluar dari sistem ? 
              </div>
              <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-secondary"><i class="fa fa-close"></i>&nbsp;&nbsp;Tutup</button>
                <a class="btn btn-primary" id="tbl-logout">Logout</a>
              </div>        
          </div>
        </div>
      </div>
    </div>
    <!-- Page Content -->
    <?php $this->load->view($v);?>

    <!-- Footer -->
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

    <script src="<?php echo base_url(); ?>assets/assets_peserta/js/core/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/assets_peserta/js/core/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/assets_peserta/js/bootstrap-material-design.js"></script>
    <script src="<?php echo base_url(); ?>assets/assets_peserta/js/plugins/moment-locale.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/toastr/build/toastr.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/countdown/jquery.plugin.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/countdown/jquery.countdown.min.js"></script>
    <!-- Material Kit Core initialisations of plugins and Bootstrap Material Design Library -->
    <script src="<?php echo base_url(); ?>assets/assets_peserta/js/material-kit.js?v=2.0.0"></script>
    <script>
        var base_url = "<?php echo base_url(); ?>";
        var uri_js = "<?php echo $this->config->item('uri_js'); ?>";
        $.ajaxSetup({
        data: {
            "<?php echo $this->security->get_csrf_token_name(); ?>" : "<?php echo $this->security->get_csrf_hash(); ?>"
        }
    }); 
    </script>
    <script src="<?php echo base_url(); ?>assets/assets_peserta/js/app.js"></script>
    <script>
        var datetime = null,
        date = null;

        var update = function () {
            moment.locale("id");
            datetime.html('<i class="material-icons" style="vertical-align:middle;">av_timer</i> '+moment().format('dddd,Do MMMM YYYY | H:mm:ss'));
        };
        $(document).ready(function() {
            datetime = $('#datetime')
            update();
            setInterval(update, 1000);
        });
    </script>
    </body>
</html>