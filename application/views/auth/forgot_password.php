<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo lang('site_title_full'); ?> | <?php echo lang('forgot_password_heading');?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>themes/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">

        <!-- Font Awesome -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>themes/adminlte/bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>themes/adminlte/bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>themes/adminlte/dist/css/AdminLTE.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>themes/adminlte/plugins/iCheck/square/blue.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="<?php echo base_url(); ?>"><b><?php echo lang('site_title'); ?></b><br><?php echo lang('site_title_short'); ?></a>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg"><?php echo sprintf(lang('forgot_password_subheading'), $identity_label); ?></p>
                
                <div class="form-group has-error">
                    <label><?php echo $message; ?></label>
                </div>
                
                <?php echo form_open("auth/forgot_password");?>
                    <div class="form-group has-feedback"> 
                        <?php echo form_input($identity); ?>                        
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    
                    <div class="row">
                        <div class="col-xs-8">
                            
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <?php echo form_button($submit, lang('forgot_password_submit_btn')); ?>
                        </div>
                        <!-- /.col -->
                    </div>
                <?php echo form_close(); ?>                

                <a href="login"><?php echo lang('remembered_your_password'); ?></a><br>                

            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->

        <!-- jQuery 3 -->
        <script src="<?php echo base_url(); ?>themes/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="<?php echo base_url(); ?>themes/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="<?php echo base_url(); ?>themes/adminlte/plugins/iCheck/icheck.min.js"></script>
        
    </body>
</html>

