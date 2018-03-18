<div class="modal fade modal-danger" id="modal-delete-confirmation" tabindex="-1" role="dialog" aria-labelledby="delete-confirmation-title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="delete-confirmation-title">
                    <?php echo lang('delete_customer_title'); ?>
                </h4>
            </div>
            <div class="modal-body">
                <div class="default-message">
                    <?php echo lang('delete_customer_message'); ?>
                </div>
                <div class="custom-message"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline btn-flat" data-dismiss="modal">
                    <?php echo lang('cancel_button'); ?>
                </button>
                <button data-dismiss="modal" type="button" class="submit-delete-item btn btn-outline btn-flat"><i class="fa fa-trash"></i> 
                    <?php echo lang('delete_button'); ?>
                </button>
            </div>
        </div>
    </div>
</div>