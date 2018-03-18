<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo lang('customer_title'); ?>
        <small><?php echo lang('customer_create_heading'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo lang('customer_create_heading'); ?></li>
    </ol>
</section>


<!-- Main content -->
<section class="content">

    <!-- Form create new customer -->
    <div class="box box-default">
        <?php echo form_open("customer/customer_create_ajax"); ?>  
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo lang('customer_create_subtitle'); ?></h3>                
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">                
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php echo form_input($email); ?>
                            </div>
                            <!-- /.form-group -->
                            <div class="form-group">
                                <?php echo form_input($fullname); ?>
                            </div>
                            <!-- /.form-group -->

                        </div>
                        <!-- /.col -->                                
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <?php echo form_button($submit, '<i class="fa fa-user-plus"></i>' . ' ' . lang('customer_submit_button')); ?>
                <a class="btn btn-danger pull-right btn-flat" href="../customer/index"><i class="fa fa-times"></i>
                    <?php echo lang('cancel_button'); ?>
                </a>
            </div>
        <?php echo form_close(); ?>
    </div>
    <!-- /.box -->
</section>

