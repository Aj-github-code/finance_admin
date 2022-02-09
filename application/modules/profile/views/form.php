<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row row-sm">
    <div class="col-lg-3 text-center">
        <?php $this->load->view('avatar'); ?>
    </div>

    <div class="col-lg-9">
        <div class="card">
            <div class="card-header bd-b">
                <h5 class="card-title mb-0"><?php echo $page_title; ?></h5>
            </div>
            <div class="card-body">
                <form id="formId" class="" method="POST" action="" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Name: <span class="asterisk">*</span></label>
                                <input type='text' class="form-control" id="full_name" name="full_name" placeholder="" value="<?php echo set_value('full_name', (isset($post_data['full_name']) ? $post_data['full_name'] : '')); ?>" data-error=".fullnameerror" maxlength="64" required/>
                                <div class="fullnameerror error_msg"><?php echo form_error('full_name', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Email: <span class="asterisk">*</span></label>
                                <input type='text' class="form-control to_lowercase" id="email" name="email" placeholder="" value="<?php echo set_value('email', (isset($post_data['email']) ? $post_data['email'] : '')); ?>" data-error=".emailerror" maxlength="50" required/>
                                <div class="emailerror error_msg"><?php echo form_error('email', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Mobile: <span class="asterisk">*</span></label>
                                <input type='text' class="form-control validate_integer" id="mobile" name="mobile" placeholder="" value="<?php echo set_value('mobile', (isset($post_data['mobile']) ? $post_data['mobile'] : '')); ?>" data-error=".mobileerror" maxlength="10" required/>
                                <div class="mobileerror error_msg"><?php echo form_error('mobile', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Date Of Birth:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                        </div>
                                    </div>
                                    <input type='text' class="form-control pickadate p-l-0" id="dob" name="dob" placeholder="" value="<?php echo set_value('dob', (isset($post_data['dob']) ? $post_data['dob'] : '')); ?>" data-error=".doberror" />
                                </div>
                                <div class="doberror error_msg"><?php echo form_error('dob', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="2" data-error=".addresserror"><?php echo (isset($post_data['address']) ? $post_data['address'] : ''); ?></textarea>
                                <div class="addresserror error_msg"><?php echo form_error('address', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-12">
                            <button class="btn btn-main-primary pd-x-20 mg-t-10" type="submit">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(".pickadate").pickadate({
        format: 'yyyy-mm-dd',
        selectMonths: true,
        selectYears: 200
    });

    $("#formId").validate({
        rules: {
            full_name: {
                required: true,
            },
            email: {
                required: true,
                email_regex: '#email',
            },
            mobile: {
                required: true,
                mobile_regex: '#mobile',
            },
        },
        messages: {
            full_name: {
                required: 'Please enter name',
            },
            email:{
                required: 'Please enter email',
                email_regex: 'Please enter valid email',
            },
            mobile:{
                required: 'Please enter mobile number',
                mobile_regex: 'Please enter valid mobile number',
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
            showLoader();
            form.submit();
        }
    });
</script>