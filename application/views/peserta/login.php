<!DOCTYPE html>
<html lang="en">
<?php $uri3 = $this->uri->segment(3); ?>
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="icon" href="<?php echo base_url(); ?>assets/img/logo undip.png">
    <title><?php echo $title;?></title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    
    <!-- Documentation extras -->
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets_peserta/css/material-kit.css?v=2.0.0">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/assets_peserta/css/demo.css">
</head>
<body class="signup-page ">
<nav class="navbar navbar-color-on-scroll fixed-top navbar-expand-lg"  color-on-scroll="100"  id="sectionsNav">
    <div class="container">
        <div class="navbar-translate">
            <a class="navbar-brand" href="#"><img src="<?php echo base_url(); ?>/assets/img/logo undip.png" style="max-width: 100%;height: 50px;" alt=""></a>
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
        </div>
    </div>
</nav>
<div class="page-header header-filter" filter-color="black" style="background-image: url(&apos;/Aplikasi_CBT/assets/img/ict_tc_undip2.jpg&apos;); background-size: cover; background-position: top center;">
        <div class="container">
            <div class="row">
                <div class="col-md-6 ml-auto mr-auto">
                    <div class="card card-signup">
                        <h2 class="card-title text-center">Login Sistem</h2>
                        <div class="card-body">
                        <?php if($this->session->flashdata('gagal')){?>
                            <div class="alert alert-danger">
                                <div class="alert-icon">
                                    <i class="material-icons">error_outline</i>
                                </div>
                                <?php echo $this->session->flashdata('gagal');?>
                            </div>
                        <?php } ?>
                            <div class="row">
                                <div class="col-md-12 mr-auto">
                                    <?php echo form_open(base_url().'authpeserta/cek_login_peserta','class="login-form" id="login-form"');?>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">face</i>
                                                </span>
                                                <input type="text" class="form-control" placeholder="Masukkan username" name="formusername" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">lock_outline</i>
                                                </span>
                                                <input type="password" name="formpassword" placeholder="password berupa tanggal lahir, contoh : 1997-02-21" class="form-control" required />
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-round">Masuk</button>
                                        </div>
                                    </form>
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
                    &copy; <script>document.write(new Date().getFullYear())</script>,  <i class="material-icons"></i>  <a href="https://www.creative-tim.com" target="_blank">Universitas Diponegoro</a> 
                </div>
            </div>
        </footer>
</div>
        <!--   Core JS Files   -->
    <script src="<?php echo base_url(); ?>assets/assets_peserta/js/core/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/assets_peserta/js/core/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/assets_peserta/js/bootstrap-material-design.js"></script>
    <!--  Plugin for Date Time Picker and Full Calendar Plugin  -->
    <script src="<?php echo base_url(); ?>assets/assets_peserta/js/plugins/moment-locale.min.js"></script>
    <!-- Material Kit Core initialisations of plugins and Bootstrap Material Design Library -->
    <script src="<?php echo base_url(); ?>assets/assets_peserta/js/material-kit.js?v=2.0.0"></script>
    </body>
</html>