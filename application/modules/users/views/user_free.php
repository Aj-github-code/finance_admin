<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header bd-b">
                <h5 class="card-title mb-0"><?php echo $page_title; ?></h5>
            </div>
            <div class="card-body ">
                <form id="formId" class="" method="POST" action="" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="csrf">
                    <input type="hidden" id="id" name="id" value="<?php echo (isset($post_data['id']) ? $post_data['id'] : ''); ?>">

                    <label class="form-label "><span class="primary"><?php echo $message;?></span></label>

                    <div class="row d-flex justify-content-around">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">User id <span class="asterisk">*</span></label>
                                <input type='text' class="form-control" id="ownid" name="ownid" placeholder="" value="<?php echo set_value('ownid', (isset($list['ownid']) ? $list['ownid'] : '')); ?>" data-error=".owniderror" maxlength="191" required/>
                                <div class="owniderror error_msg"><?php echo form_error('ownid', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                    </div>

                  
                    <div class="row d-flex justify-content-around">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Package <span class="asterisk">*</span></label>
                                <select class="select2" name="pin" id="pin" style="width: 100%;" data-error=".pinerror" required>
                                    <option value="">-- Select Package --</option>
                                    <option value="500" <?php if(isset($post_data['pin']) && $post_data['pin'] == 500){ echo 'selected="selected"'; } ?>>5,000</option>
                                    <option value="1000" <?php if(isset($post_data['pin']) && $post_data['pin'] == 1000){ echo 'selected="selected"'; } ?>>10,000</option>
                                    <option value="2000" <?php if(isset($post_data['pin']) && $post_data['pin'] == 2000){ echo 'selected="selected"'; } ?>>20,000</option>
                                    <option value="50000" <?php if(isset($post_data['pin']) && $post_data['pin'] == 50000){ echo 'selected="selected"'; } ?>>50,000</option>
                                    <option value="100000" <?php if(isset($post_data['pin']) && $post_data['pin'] == 100000){ echo 'selected="selected"'; } ?>>1,00,000</option>
                                    <option value="300000" <?php if(isset($post_data['pin']) && $post_data['pin'] == 300000){ echo 'selected="selected"'; } ?>>3,00,000</option>
                                    <option value="500000" <?php if(isset($post_data['pin']) && $post_data['pin'] == 500000){ echo 'selected="selected"'; } ?>>5,00,000</option>
                                </select>
                                <div class="statuserror error_msg"><?php echo form_error('status', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="row row-sm">
                        <div class="col-12 mg-t-10 text-right">
                            <button class="btn btn-main-primary pd-x-20 mr-2" type="submit">Save</button>
                            <a href="<?php echo base_url(users_constants::users_free_url); ?>" class="btn btn-secondary custom-btn-secondary">Cancel</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#pin').select2();

    $("#formId").validate({
        rules: {
            ownid: {
                required: true,
            },
            pin: {
                required: true,
            },
        },
        messages: {
            ownid: {
                required: 'Please enter User id',
            },
            pin:{
                required: 'Please select pin',
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
            event.preventDefault();
            var csrf_token          = $('#<?php echo $this->security->get_csrf_token_name(); ?>').val();
            var ownid                = $('#ownid').val();
            var pin                 = $('#pin').val();
            // var image               = $('#image')[0].files[0];



                    showLoader();
                    form.submit();
               
        }
    });
</script>



