<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo lang('customer_title'); ?>
        <small><?php echo lang('customer_listing_subtitle'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo lang('customer_listing_subtitle'); ?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">          

            <div class="box">
                <div class="box-header">
                    <h3 class="padding-10 box-title"><?php echo lang('customer_listing_description'); ?></h3>
                    <a href="../customer/customer_create" class="btn btn-primary btn-flat padding-10 pull-right"><i class="fa fa-user-plus"></i> <?php echo lang('new_customer'); ?></a>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="customer_data" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fullname</th>
                                <th>Email</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Fullname</th>
                                <th>Email</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->