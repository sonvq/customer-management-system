<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo lang('index_heading'); ?>
        <small><?php echo lang('index_heading_list'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo lang('index_heading_list'); ?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">          

            <div class="box">
                <div class="box-header">
                    <h3 class="padding-10 box-title"><?php echo lang('index_subheading'); ?></h3>
                    <a href="<?php echo base_url(); ?>auth/create_user" class="btn btn-primary btn-flat padding-10 pull-right"><i class="fa fa-user-plus"></i> 
                        <?php echo lang('index_create_user_link'); ?>
                    </a>
                    <a href="<?php echo base_url(); ?>auth/create_group" class="btn btn-primary btn-flat padding-10 margin-right-10 pull-right"><i class="fa fa-user-plus"></i> 
                        <?php echo lang('index_create_group_link'); ?>
                    </a>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th><?php echo lang('index_fname_th');?></th>
                            <th><?php echo lang('index_lname_th');?></th>
                            <th><?php echo lang('index_email_th');?></th>
                            <th><?php echo lang('index_groups_th');?></th>
                            <th><?php echo lang('index_status_th');?></th>
                            <th><?php echo lang('index_action_th');?></th>
                        </tr>
                        <?php foreach ($users as $user):?>
                            <tr>
                                <td><?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?></td>
                                <td><?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?></td>
                                <td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
                                <td>
                                    <?php foreach ($user->groups as $group):?>
                                        <?php echo anchor("auth/edit_group/".$group->id, htmlspecialchars($group->name,ENT_QUOTES,'UTF-8')) ;?><br />
                                    <?php endforeach?>
                                </td>
                                <td><?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, lang('index_active_link')) : anchor("auth/activate/". $user->id, lang('index_inactive_link'));?></td>
                                <td><?php echo anchor("auth/edit_user/".$user->id, 'Edit') ;?></td>
                            </tr>
                        <?php endforeach;?>
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
