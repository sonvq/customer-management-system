 <script>
    $(function () {
        var dataTable = $('#customer_data').DataTable({  
             "processing":true,  
             "serverSide":true,  
             "order":[],  
             "ajax":{  
                  url:"<?php echo base_url() . 'customer/customer_ajax'; ?>",  
                  type:"POST"  
             },  
             "columnDefs":[  
                  {  
                       "targets":[4],  
                       "orderable":false,  
                  },  
             ],  
        });  

        $('#modal-delete-confirmation').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var actionTarget = button.data('action-target');
            var modal = $(this);
            console.log(actionTarget);
            modal.find('.submit-delete-item').data('action-target', actionTarget);                  
        });

        $('body .submit-delete-item').on('click', function(){
            var actionTarget = $(this).data('action-target');
            $.ajax({
                url: actionTarget,
                type: 'delete',
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    console.log(data.status);
                    if (data.status === "success") {
                        toastr.success(data.message);
                        setTimeout(function() {
                            dataTable.ajax.reload();
                        });
                    } else {
                        toastr.error(data.message);
                    }
                },
                error: function () {
                    toastr.error('Internal server error, please try again later');
                }
            });
        });

    })
</script>