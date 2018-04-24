<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $title; ?></title>

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets_login/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets_login/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets_login/css/form-elements.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets_login/css/style.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/logo undip.png">

    </head>

    <body>

        <!-- Top content -->
        <div class="top-content">
        	
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <img src="<?php echo base_url(); ?>assets/img/logo undip.png" style="height:120px">
                            <div class="description">
                                <h1><strong> Sistem Ujian Online Pasca Sarjana Universitas Diponegoro</strong>
                                    <!--  -->
                                </h1>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>Administrative Area</h3>
                            		<p>Masukkan username dan password untuk login</p>
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-lock"></i>
                        		</div>
                                <?php if($this->session->flashdata('gagal')){ ?>
                                <div class="col-md-12">
                                    <div class="alert alert-danger"><p>
                                        <?php echo $this->session->flashdata('gagal'); ?>
                                    </p></div>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="form-bottom">
                                <?php echo form_open(base_url().'authenticate_cat/cek_login','class="login-form" id="login-form"');?>
                                    <div class="form-group">    
                                        <select name="level" id="level" class="form-control required" title="field ini harus diisi">
                                            <option value="">--Level--</option>
                                            <option value="administrator">Admin</option>
                                            <option value="operator ruangan">Operator Ruangan</option>
                                            <option value="operator utama">Operator Utama</option>
                                        </select>
                                    </div>
			                    	<div class="form-group">
			                    		<label class="sr-only" for="form-username">Username</label>
			                        	<input type="text" name="formusername" placeholder="Username..." class="form-username form-control" id="form-username">
			                        </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-password">Password</label>
			                        	<input type="password" name="formpassword" placeholder="Password..." class="form-password form-control" id="form-password">
			                        </div>
			                        <button type="submit" class="btn">Masuk</button>
			                    </form>
		                    </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 social-login">
                        	<h3>Made by <a href="http://azmind.com"><strong>AZMIND</strong></a></h3>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>


        <!-- Javascript -->
        <script type="text/javascript">
            var base_url =" <?php echo base_url(); ?>";
        </script>
        <script src="<?php echo base_url(); ?>assets/js/jquery-3.2.1.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/assets_login/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/vendor/jquery-validation/jquery.validate.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/assets_login/js/jquery.backstretch.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/assets_login/js/scripts.js"></script>
        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->
    </body>
</html>