<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $title; ?></title>
	<meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/font-awesome/css/font-awesome.min.css">
    <!-- Custom icon font-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/fontastic.css">
    <!-- datatables -->
    <link href="<?php echo base_url(); ?>assets/vendor/DataTables/datatables.min.css" rel="stylesheet">
    <!-- Google fonts - Roboto -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <!-- Custom Scrollbar-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css">
    <!-- select2 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/select2-4.0.6-rc.1/dist/css/select2.css">
    <!-- sweet alert -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/sweetalert2/dist/sweetalert2.min.css">
    <!-- toastr js -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/toastr/build/toastr.min.css">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.blue.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css">
    <!-- Favicon-->
    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/img/logo undip.png">
</head>
<body>
	<div id="modal-logout"></div>
    <div id="modal-password">
        <div id="m_ubahpassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade">
        <div role="document" class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <div id="header-modal-ubahpass">Ubah Password</div>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <form name="edit_pass" id="edit_pass" onsubmit="return ubah_password();">
              <div class="modal-body">
                  <input type="hidden" name="id" id="id" value="0">
                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                  <div class="row" style="padding: 6px;">
                    <div class="col-md-4" style="padding-top: 8px;font-size: 0.9em;">Username</div>
                    <div class="col-md-8">
                      <input type="text" class="form-control" name="username" id="username" readonly>
                    </div>
                  </div>
                  <div class="row" style="padding: 6px;">
                    <div class="col-md-4" style="padding-top: 8px;font-size: 0.9em;">Password Lama</div>
                    <div class="col-md-8">
                        <input type="password" class="form-control" name="pass_lama" id="pass_lama" required>
                    </div> 
                  </div>
                  <div class="row" style="padding: 6px;">
                    <div class="col-md-4" style="padding-top: 8px;font-size: 0.9em;">Password Baru</div>
                    <div class="col-md-8">
                    <div class="input-group">
                        <input type="password" class="form-control" name="pass_baru" id="pass_baru" required>                        
                        <span class="input-group-btn">
                            <button class="btn btn-info" type="button" id="see_ubah_pass"><i class="fa fa-eye"></i></button>
                        </span> 
                    </div>
                    <div style="font-size:0.9em;color: #FF4747;">*password yang diisi minimal 8 karakter</div>
                    </div> 
                  </div>
                  <div class="row" style="padding: 6px;">
                    <div class="col-md-4" style="padding-top: 8px;font-size: 0.9em;">Konfirmasi Password Baru</div>
                    <div class="col-md-8">
                        <input type="password" class="form-control" name="konf_baru" id="konf_baru" required>
                    </div> 
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-secondary"><i class="fa fa-close"></i>&nbsp;&nbsp;Tutup</button>
                <button class="btn btn-primary"><i class="fa fa-check-square-o"></i>&nbsp;&nbsp;Simpan</button>
              </div>
            </form>         
          </div>
        </div>
      </div>
    </div>
    <?php $this->load->view($v); ?>
    
	<footer class="main-footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-4">
              <p>Your company &copy; 2017-2019</p>
            </div>
            <div class="col-sm-4 text-center">
              <p style="color: white"> 25 Desember 2017</p>
            </div>
            <div class="col-sm-4 text-right">
              <p>Design by <a href="https://bootstrapious.com" class="external">Bootstrapious</a></p>
            </div>
          </div>
        </div>
    </footer>
	<script src="<?php echo base_url(); ?>assets/js/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/popper.js"> </script>
    <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/DataTables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/select2-4.0.6-rc.1/dist/js/select2.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/toastr/build/toastr.min.js"></script>
    <script type="text/javascript">
     var base_url = "<?php echo base_url(); ?>";
     var uri_js = "<?php echo $this->config->item('uri_js'); ?>";
     data_csrf ={token_value : "<?php echo $this->security->get_csrf_hash(); ?>"};
     $.ajaxSetup({
        data: {
            "<?php echo $this->security->get_csrf_token_name(); ?>" : "<?php echo $this->security->get_csrf_hash(); ?>"
        }
    }); 
    
    </script>
    <script src="<?php echo base_url(); ?>assets/js/mainop_app.js"></script>

    <!-- notifikasi area -->
    <?php if($this->session->flashdata('toast_success')) : ?>
        <script>
        toastr.success('<?php echo $this->session->flashdata('toast_success'); ?>','Sukses!',{
            timeOut: 2000,
            "positionClass": "toast-top-center",
            "progressBar": true
        });
        </script>  
    <?php endif; ?> 
    <?php if($this->session->flashdata('sukses')) : ?>
        <script>
        swal({
            title: "Sukses!",
            text: "<?php echo $this->session->flashdata('sukses'); ?>",
            timer: 1500,
            showConfirmButton: false,
            type: 'success'
        });
        </script>  
    <?php endif; ?>                      
</body>
</html>

 