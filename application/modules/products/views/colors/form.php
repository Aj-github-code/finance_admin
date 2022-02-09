<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header bd-b">
                <h5 class="card-title mb-0"><?php echo $page_title; ?></h5>
            </div>
            <div class="card-body">
                <form id="formId" class="" method="POST" action="" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" id="id" name="id" value="<?php echo (isset($post_data['id']) ? $post_data['id'] : ''); ?>">

                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="row row-sm">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Color Name <span class="asterisk">*</span></label>
                                        <input type='text' class="form-control" id="name" name="name" placeholder="" value="<?php echo set_value('name', (isset($post_data['name']) ? $post_data['name'] : '')); ?>" data-error=".nameerror" maxlength="255" required/>
                                        <div class="nameerror error_msg"><?php echo form_error('name', '<label class="danger">', '</label>'); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Status <span class="asterisk">*</span></label>
                                <select class="select2" name="status" id="status" style="width: 100%;" data-error=".statuserror" required>
                                    <option value="">-- Select Status --</option>
                                    <option value="1" <?php if(isset($post_data['status']) && $post_data['status'] == 1){ echo 'selected="selected"'; } ?>>Active</option>
                                    <option value="0" <?php if(isset($post_data['status']) && $post_data['status'] == 0){ echo 'selected="selected"'; } ?>>In-Active</option>
                                </select>
                                <div class="statuserror error_msg"><?php echo form_error('status', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="row row-sm">
                        <div class="col-12 mg-t-10">
                            <button class="btn btn-main-primary pd-x-20 mr-2" type="submit">Save</button>
                            <a href="<?php echo base_url(product_constants::product_colors_url); ?>" class="btn btn-secondary custom-btn-secondary">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $('#status').select2();

    $("#formId").validate({
        rules: {
            name: {
                required: true,
            },
            status: {
                required: true,
            },
        },
        messages: {
            name: {
                required: 'Please enter color name',
            },
            status: {
                required: 'Please select status',
            },
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
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(placement).append(error)
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form, event){
            function unique_color() {
                var check_result = false;
                var name            = $('#name').val();
                var user_id         = $('#id').val();
                var csrf_token      = '<?php echo $this->security->get_csrf_hash(); ?>';

                $.ajax({
                    type: "POST",
                    url: base_url+'<?php echo Product_constants::check_unique_color; ?>',
                    async: false,
                    data: {name : name, id : user_id, '<?php echo $this->security->get_csrf_token_name(); ?>' : csrf_token},
                    beforeSend: function() {
                        showLoader();
                    },
                    success: function(response){
                        hideLoader();
                        check_result = response;
                    }
                });
                return check_result;
            }

            var check_color = unique_color();
            if(check_color)
            {
                showLoader();
                form.submit();
            }
            else
            {
                hideLoader();
                $('.nameerror').append('<div id="name-error" class="error" style="">Name already exist</div>');
            }
        }
    });
</script>
