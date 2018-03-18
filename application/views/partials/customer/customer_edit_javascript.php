 <script>
    $(function () {        

        function isEmail(email) {
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return regex.test(email);
        }
        
        function formValidate()
        {            
            var email_input = $('#email').val();
            var fullname_input = $('#fullname').val();
            var customer_id = $('#customer-id').val();
            if(email_input == '' || fullname_input == '') {
                toastr.error('<?php echo lang('customer_create_email_fullname_required'); ?>');
                return false;
            }
            if (!isEmail(email_input)) {
                toastr.error('<?php echo lang('customer_create_email_invalid_format'); ?>');
                return false;
            }
            $.ajax({
                url: "<?php echo base_url(); ?>" + 'customer/customer_edit_ajax/' + customer_id,
                type: 'POST',
                dataType: 'json',
                data: {
                    'email': email_input,
                    'fullname': fullname_input
                },
                success: function (data) {
                    console.log(data);
                    console.log(data.status);
                    if (data.status === "success") {
                        toastr.success(data.message);
                        // Redirect back to listing screen
                        setTimeout(function(){
                            window.location.href = "<?php echo base_url(); ?>" + "customer/index";  
                        }, 3000);                        
                    } else {
                        toastr.error(data.message);
                    }
                },
                error: function () {
                    toastr.error('<?php echo lang('internal_server_error'); ?>');
                }
            });
        }
        
        $("#customer-edit-form")[0].addEventListener('submit', function (e) {
            e.preventDefault();
            formValidate();
        }, false);

    })
</script>