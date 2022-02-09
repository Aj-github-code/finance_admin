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
                                        <label class="form-label">Coupon Name <span class="asterisk">*</span></label>
                                        <input type='text' class="form-control" id="name" name="name" placeholder="" value="<?php echo set_value('name', (isset($post_data['name']) ? $post_data['name'] : '')); ?>" data-error=".nameerror" maxlength="255" required/>
                                        <div class="nameerror error_msg"><?php echo form_error('name', '<label class="danger">', '</label>'); ?></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Coupon Code <span class="asterisk">*</span></label>
                                        <input type='text' class="form-control" id="code" name="code" placeholder="" value="<?php echo set_value('code', (isset($post_data['code']) ? $post_data['code'] : '')); ?>" data-error=".codeerror" maxlength="255" required/>
                                        <div class="codeerror error_msg"><?php echo form_error('code', '<label class="danger">', '</label>'); ?></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Discount in percent <span class="asterisk"></span></label>
                                        <input type='text' class="form-control" id="dicount_percent" name="dicount_percent" placeholder="" value="<?php echo set_value('dicount_percent', (isset($post_data['dicount_percent']) ? $post_data['dicount_percent'] : '')); ?>" data-error=".dicount_percenterror" maxlength="255"/>
                                        <div class="dicount_percenterror error_msg"><?php echo form_error('dicount_percent', '<label class="danger">', '</label>'); ?></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Discount Amount <span class="asterisk"></span></label>
                                        <input type='text' class="form-control" id="discount_amount" name="discount_amount" placeholder="" value="<?php echo set_value('discount_amount', (isset($post_data['discount_amount']) ? $post_data['discount_amount'] : '')); ?>" data-error=".discount_amounterror" maxlength="255"/>
                                        <div class="discount_amounterror error_msg"><?php echo form_error('discount_amount', '<label class="danger">', '</label>'); ?></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Discount Type <span class="asterisk">*</span></label>
                                        <select class="select2" name="discount_type" id="discount_type" style="width: 100%;" data-error=".discount_typeerror" required>
                                            <option value="">-- Select Discount Type --</option>
                                            <option value="product_discount" <?php if(isset($post_data['discount_type']) && $post_data['discount_type'] == 'product_discount'){ echo 'selected="selected"'; } ?>>Product Discount</option>
                                            <option value="cart_discount" <?php if(isset($post_data['discount_type']) && $post_data['discount_type'] == 'cart_discount'){ echo 'selected="selected"'; } ?>>Cart Discount</option>
                                        </select>
                                        <div class="discount_typeerror error_msg"><?php echo form_error('discount_type', '<label class="danger">', '</label>'); ?></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Minimum purchase amount of cart<span class="asterisk"></span></label>
                                        <input type='text' class="form-control" id="min_purchase_amount" name="min_purchase_amount" placeholder="" value="<?php echo set_value('min_purchase_amount', (isset($post_data['min_purchase_amount']) ? $post_data['min_purchase_amount'] : '')); ?>" data-error=".min_purchase_amounterror" maxlength="255" />
                                        <div class="min_purchase_amounterror error_msg"><?php echo form_error('min_purchase_amount', '<label class="danger">', '</label>'); ?></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
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
                        </div>
                        <div class="col-md-6">
                            <div class="row row-sm">
                                <div class="col-md-12">
                                    <div class="form-group ">
                                        <label class="form-label">Coupon Valid From<span class="asterisk">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                                </div>
                                            </div>
                                            <input type='text' class="form-control pickadate" id="valid_from" name="valid_from" placeholder="yyyy-mm-dd" value="<?php echo set_value('valid_from', (isset($post_data['valid_from']) ? $post_data['valid_from'] : '')); ?>" data-error=".valid_fromerror" maxlength="255" required />
                                        </div>
                                        <div class="valid_fromerror error_msg"><?php echo form_error('valid_from', '<label class="danger">', '</label>'); ?></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Coupon Valid To<span class="asterisk">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                                </div>
                                            </div>
                                            <input type='text' class="form-control pickadate" id="valid_to" name="valid_to" placeholder="yyyy-mm-dd" value="<?php echo set_value('valid_to', (isset($post_data['valid_to']) ? $post_data['valid_to'] : '')); ?>" data-error=".valid_toerror" maxlength="255" required/>
                                        </div>
                                        <div class="valid_toerror error_msg"><?php echo form_error('valid_to', '<label class="danger">', '</label>'); ?></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Coupon Applicable for <span class="asterisk">*</span></label>
                                        <select class="select2 coupon_applicable" name="coupon_applicable" id="coupon_applicable" style="width: 100%;" data-error=".coupon_applicableerror" required>
                                            <option value="">-- Select Coupon Applicable for --</option>
                                            <option value="single" <?php if(isset($post_data['coupon_applicable']) && $post_data['coupon_applicable'] == 'single'){ echo 'selected="selected"'; } ?>>Single user</option>
                                            <option value="multiple" <?php if(isset($post_data['coupon_applicable']) && $post_data['coupon_applicable'] == 'multiple'){ echo 'selected="selected"'; } ?>>Multiple Users</option>
                                        </select>
                                        <div class="coupon_applicableerror error_msg"><?php echo form_error('coupon_applicable', '<label class="danger">', '</label>'); ?></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Organization<span class="asterisk">*</span></label>
                                        <div class="organization_id_wrap">
                                            <select class="select2 organization_id" name="organization_id" id="organization_id" style="width: 100%;" data-error=".organization_iderror" required>
                                                <option value="">-- Please Select Organization --</option>
                                            </select>
                                        </div>
                                        <div class="organization_iderror error_msg"><?php echo form_error('organization_id', '<label class="danger">', '</label>'); ?></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Coupon Applicable Users <span class="asterisk">*</span></label>
                                        <div class="coupon_applicable_users_wrapper">
                                            <select class="select2 coupon_applicable_users" <?php if(isset($post_data['coupon_applicable']) && $post_data['coupon_applicable'] == 'multiple'){?> multiple <?php } ?>  name="coupon_applicable_users[]" id="coupon_applicable_users" style="width: 100%;" data-error=".statuserror"  >
                                                <?php if(isset($users) && !empty($users)){
                                                    if(isset($post_data['coupon_applicable_users']) && !empty($post_data['coupon_applicable_users'])){
                                                        $coupon_applicable_users = explode(",", $post_data['coupon_applicable_users']);
                                                    }else{
                                                       $coupon_applicable_users = array(); 
                                                    }
                                                    foreach ($users as $key => $value) {?>
                                                        <option value="<?=$value['id']?>" <?php if(in_array($value['id'], $coupon_applicable_users)){?> selected <?php } ?> ><?=$value['full_name']?></option>      
                                                <?php } }?>
                                            </select>
                                        </div>
                                        <div class="coupon_applicable_userserror error_msg"><?php echo form_error('coupon_applicable_users', '<label class="danger">', '</label>'); ?></div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Category <span class="asterisk">*</span></label>
                                        <div class="coupon_category_wrap">
                                            <select class="select2 coupon_category" multiple name="coupon_category[]" id="coupon_category" style="width: 100%;" data-error=".coupon_categoryerror" required>
                                                <?php if(isset($category) && !empty($category)){
                                                    if(isset($post_data['coupon_category']) && !empty($post_data['coupon_category'])){
                                                        $coupon_category = explode(",", $post_data['coupon_category']);
                                                    }else{
                                                       $coupon_category = array(); 
                                                    }
                                                    foreach ($category as $key => $value) {
                                                ?>
                                                      <option value="<?=$value['id']?>" <?php if(in_array($value['id'], $coupon_category)){?> selected <?php } ?> ><?=$value['name']?></option>  
                                                <?php } }?>
                                            </select>
                                        </div>
                                        <div class="coupon_categoryerror error_msg"><?php echo form_error('coupon_category', '<label class="danger">', '</label>'); ?></div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">SubCategory <span class="asterisk">*</span></label>
                                        <div class="coupon_subcategory_wrap">
                                            <select class="select2 coupon_subcategory" multiple name="coupon_subcategory[]" id="coupon_subcategory" style="width: 100%;" data-error=".coupon_subcategoryerror" required>
                                                <?php if(isset($category) && !empty($category)){
                                                    if(isset($post_data['coupon_subcategory']) && !empty($post_data['coupon_subcategory'])){
                                                        $coupon_subcategory = explode(",", $post_data['coupon_subcategory']);
                                                    }else{
                                                       $coupon_subcategory = array(); 
                                                    }
                                                    foreach ($subcategory as $key => $value) {
                                                ?>
                                                      <option value="<?=$value['id']?>" <?php if(in_array($value['id'], $coupon_subcategory)){?> selected <?php } ?> ><?=$value['name']?></option>  
                                                <?php } }?>
                                            </select>
                                        </div>
                                        <div class="coupon_subcategoryerror error_msg"><?php echo form_error('coupon_subcategory', '<label class="danger">', '</label>'); ?></div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Products <span class="asterisk">*</span></label>
                                        <div class="coupon_products_wrapper">
                                            <select class="select2 coupon_products" multiple name="coupon_products[]" id="coupon_products" style="width: 100%;" data-error=".coupon_productserror" required>
                                                <?php if(isset($products) && !empty($products)){
                                                    if(isset($post_data['coupon_products']) && !empty($post_data['coupon_products'])){
                                                        $coupon_products = explode(",", $post_data['coupon_products']);
                                                    }else{
                                                       $coupon_products = array(); 
                                                    }
                                                    foreach ($products as $key => $value) {
                                                ?>
                                                      <option value="<?=$value['id']?>" <?php if(in_array($value['id'], $coupon_products)){?> selected <?php } ?> ><?=$value['name']?></option>  
                                                <?php } }?>
                                            </select>
                                        </div>
                                        <div class="coupon_productserror error_msg"><?php echo form_error('coupon_products', '<label class="danger">', '</label>'); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row row-sm">
                        <div class="col-12 mg-t-10">
                            <button class="btn btn-main-primary pd-x-20 mr-2" type="submit">Save</button>
                            <a href="<?php echo base_url(product_constants::product_coupons_url); ?>" class="btn btn-secondary custom-btn-secondary">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $('#status').select2();
    $('#discount_type').select2();
    $('.coupon_applicable').select2();
    $('.coupon_category').SumoSelect({ selectAll: true });
    $('.coupon_subcategory').SumoSelect({ selectAll: true });
    $('.coupon_products').SumoSelect({ selectAll: true });
    $(".pickadate").pickadate({
        format: 'yyyy-mm-dd',
        selectMonths: true,
        selectYears: 200
    });

    var coupon_applicable   = $('#coupon_applicable').val();
    if(coupon_applicable == 'multiple'){
        $('.coupon_applicable_users').SumoSelect({ selectAll: true });
    }else{
        $('.coupon_applicable_users').select2(); 
    }

    var coupon_id      = '<?php echo (isset($post_data["id"]) ? $post_data["id"] : ""); ?>';
    if(coupon_id == ''){
        var category_url    = base_url+'<?php echo product_constants::get_product_categories_options_url; ?>';
        var category_id     = '<?php echo (isset($post_data["category_id"]) ? $post_data["category_id"] : ""); ?>';
        var parent_id       = '';
        coupon_category_select_box(category_url, category_id, '', 'multiple',parent_id);
    }

    var organization_url    = base_url+'<?php echo organization_constants::get_organization_options_url; ?>';
    var organization_id     = '<?php echo (isset($post_data["organization_id"]) ? $post_data["organization_id"] : ""); ?>';
    var parent_id           = '';
    organization_select_box(organization_url, organization_id, '', '',parent_id);

    if(coupon_id == ''){
        $(document).on('change', '#organization_id', function() {
            var user_url            = base_url+'<?php echo organization_constants::get_organizations_users_option_url; ?>';
            var user_id             = '<?php echo (isset($post_data["user_id"]) ? $post_data["user_id"] : ""); ?>';
            var coupon_applicable   = $('#coupon_applicable').val();
            var organization_id     = $('#organization_id').val();
            if(coupon_applicable == 'single'){
                var multiple    = '';
            }
            else{
                var multiple    = 'multiple';
            }
            user_select_box(user_url, user_id, '', multiple, organization_id);
        });
    }

    
    $(document).on('change', '#coupon_applicable', function() {
        var organization_id     = $('#organization_id').val();
        if(organization_id !== ''){
            var user_url            = base_url+'<?php echo organization_constants::get_organizations_users_option_url; ?>';
            var user_id             = '<?php echo (isset($post_data["user_id"]) ? $post_data["user_id"] : ""); ?>';
            var coupon_applicable   = $('#coupon_applicable').val();
            if(coupon_applicable == 'single'){
                var multiple    = '';
            }
            else{
                var multiple    = 'multiple';
            }
            user_select_box(user_url, user_id, '', multiple, organization_id);
        }
    });
    

    $(document).on('change', '#coupon_category', function() {
        var category_url    = base_url+'<?php echo product_constants::get_product_categories_options_url; ?>';
        var category_id     = '<?php echo (isset($post_data["subcategory_id"]) ? $post_data["subcategory_id"] : ""); ?>';
        var parent_id       = $('#coupon_category').val();
        coupon_subcategory_select_box(category_url, category_id, '', 'multiple',parent_id);

        var product_url    = base_url+'<?php echo product_constants::get_coupon_product_options_url; ?>';
        var product_id     = '<?php echo (isset($post_data["product_id"]) ? $post_data["product_id"] : ""); ?>';
        var category_id    = $('#coupon_category').val();
        var subcategory_id = '';
        product_select_box(product_url, product_id, '', 'multiple',category_id,subcategory_id);
    });

    $(document).on('change', '#coupon_subcategory', function() {
        var product_url    = base_url+'<?php echo product_constants::get_coupon_product_options_url; ?>';
        var product_id     = '<?php echo (isset($post_data["product_id"]) ? $post_data["product_id"] : ""); ?>';
        var category_id    = $('#coupon_category').val();
        var subcategory_id = $('#coupon_subcategory').val();
        product_select_box(product_url, product_id, '', 'multiple',category_id,subcategory_id);
    });

    

    $("#formId").validate({
        rules: {
            name: {
                required: true,
            },
            code: {
                required: true,
            },
            discount_type: {
                required: true,
            },
            valid_from: {
                required: true,
            },
            valid_to: {
                required: true,
            },
            coupon_applicable: {
                required: true,
            },
            'coupon_category[]': {
                required: true,
            },
            'coupon_subcategory[]': {
                required: true,
            },
            'coupon_products[]': {
                required: true,
            },
            organization_id: {
                required: true,
            },
            status: {
                required: true,
            },
        },
        messages: {
            name: {
                required: 'Please enter brand name',
            },
            status:{
                required: "Please select status",
            },
            discount_type: {
                required: "Please select discount type",
            },
            valid_from: {
                required: "Please select coupon valid from date",
            },
            valid_to: {
                required: "Please select coupon valid to date",
            },
            coupon_applicable: {
                required: "Please select coupon applicable",
            },
            organization_id: {
                required: "Please select organization",
            },
            'coupon_category[]': {
                required: "Please select category",
            },
            'coupon_subcategory[]': {
                required: "Please select subcategory",
            },
            'coupon_products[]': {
                required: "Please select product",
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
            $('.error').html('');
            var dicount_percent         = $('#dicount_percent').val();
            var discount_amount         = $('#discount_amount').val();
            var discount_type           = $('#discount_type').val();
            var min_purchase_amount     = $('#min_purchase_amount').val();
            var coupon_applicable       = $('#coupon_applicable').val();
            var coupon_applicable_users = $('#coupon_applicable_users').val();
            function unique_code() {
                var check_result = false;
                var code            = $('#code').val();
                var user_id         = $('#id').val();
                var csrf_token      = '<?php echo $this->security->get_csrf_hash(); ?>';

                $.ajax({
                    type: "POST",
                    url: base_url+'<?php echo Product_constants::check_unique_coupon; ?>',
                    async: false,
                    data: {code : code, id : user_id, '<?php echo $this->security->get_csrf_token_name(); ?>' : csrf_token},
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

            var check_code = unique_code();
            if(check_code){
                if((dicount_percent == null || dicount_percent == '') && (discount_amount == null || discount_amount =='') ){
                    hideLoader();
                    $('.dicount_percenterror').append('<div id="name-error" class="error" style="">Enter discount percent</div>');
                    $('.discount_amounterror').append('<div id="name-error" class="error" style="">Enter discount amount</div>'); 
                }
                else{
                    if(discount_type == 'cart_discount' && (min_purchase_amount == null || min_purchase_amount <=0) ){
                        hideLoader();
                        $('.min_purchase_amounterror').append('<div id="name-error" class="error" style="">Please Enter minimum purchase cart amount</div>');
                    }else{
                        if((coupon_applicable == 0 || coupon_applicable == 1) && (coupon_applicable_users == null || coupon_applicable_users == '')){
                            $('.coupon_applicable_userserror').append('<div id="name-error" class="error" style="">Please select coupon applicable users</div>');
                        }else{
                            showLoader();
                            form.submit();
                        }
                    }
                }
            }
            else{
                hideLoader();
                $('.codeerror').append('<div id="name-error" class="error" style="">Code already exist</div>');
            }
        }
    });
</script>