<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="modal" id="coupon-data-modal">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content modal-content-demo">
            <form class="" action="" id="bulkFormId">
                <div class="modal-header">
                    <h6 class="modal-title">Batch Upload Data</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row"><div class="col-md-12" id="load_coupon_data"></div></div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button class="btn btn-main-primary" type="submit" id="bulkFormSubmitBtn">Save</button>
                    <button class="btn btn-secondary custom-btn-secondary" type="button" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $("#coupon-data-modal").on("hide.bs.modal", function(e) {
        $('#load_coupon_data').html('');
    });

    $("#bulkFormId").validate({
        rules: {
            
        },
        messages: {
            
        },
        ignore: "input[type=hidden]",
        errorClass: "danger",
        successClass: "success",
        highlight: function(e, t) {
            $(e).removeClass(t)
        },
        unhighlight: function(e, t) {
            $(e).removeClass(t)
        },
        errorElement : 'div',
        submitHandler: function(form, event){
            event.preventDefault();

            var formArray   = $('#bulkFormId').serializeArray();
            var postObject  = {};
            $.each(formArray, function(i, field){
                postObject[field.name]  = field.value;
            });
            var error_user  = [];
            $('.error_user').each(function() {
                error_user.push($(this).val());
            });
            var error_user_message  = [];
            $('.error_user_message').each(function() {
                error_user_message.push($(this).val());
            });
            postObject['error_user_array']          = error_user;
            postObject['error_user_message_array']  = error_user_message;
            postObject['organization_id']           = $("#organization_id option:selected").val();
            
            postObject['<?php echo $this->security->get_csrf_token_name(); ?>'] = $('#<?php echo $this->security->get_csrf_token_name(); ?>').val();
            
            delete postObject["error_user"];
            delete postObject["error_user_message"];
            
            $.ajax({
                type: "POST",
                dataType: "json",
                url: base_url+"<?php echo product_constants::save_bulk_coupon_url; ?>",
                async: false,
                data: postObject,
                beforeSend: function() {
                    showLoader();
                },
                success: function(response){
                    hideLoader();

                    if(response.error == 0)
                    {
                        load_status_popup("success", response.message);
                        $('#coupon-data-modal').modal('hide');
                        filterTable();
                    }
                    else
                    {
                        load_status_popup("error", response.message);
                    }
                }
            });
        }
    });
</script>