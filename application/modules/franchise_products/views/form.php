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
                            <div class="form-group">
                                <label class="form-label">Name <span class="asterisk">*</span></label>
                                <input type='text' class="form-control" id="name" name="name" placeholder="" value="<?php echo set_value('name', (isset($post_data['name']) ? $post_data['name'] : '')); ?>" data-error=".nameerror" maxlength="191" required/>
                                <div class="nameerror error_msg"><?php echo form_error('name', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Thumbnail:</label>
                                <div class="input-group">
                                    <input type="text" placeholder="" class="form-control" id="thumbnail" name="thumbnail" data-error=".thumbnailerror" value="<?php echo set_value('thumbnail', (isset($post_data['thumbnail']) ? $post_data['thumbnail'] : '')); ?>" readonly>
                                    <span class="input-group-btn" id="button-addon2">
                                        <button class="btn btn-main-primary br-tl-0 br-bl-0" type="button" onclick="open_image_gallery('thumbnail');">Gallery</button>
                                    </span>
                                </div>
                                <div class="thumbnailerror error_msg"><?php echo form_error('thumbnail', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Mrp <span class="asterisk">*</span></label>
                                <input type='text' class="form-control" id="mrp" name="mrp" placeholder="" value="<?php echo set_value('mrp', (isset($post_data['mrp']) ? $post_data['mrp'] : '')); ?>" data-error=".mrperror" required/>
                                <div class="mrperror error_msg"><?php echo form_error('mrp', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Opening Stock <span class="asterisk">*</span></label>
                                <input type='text' class="form-control" id="opening_stock" name="opening_stock" placeholder="" value="<?php echo set_value('opening_stock', (isset($post_data['opening_stock']) ? $post_data['opening_stock'] : '')); ?>" data-error=".openingstockerror" required/>
                                <div class="openingstockerror error_msg"><?php echo form_error('opening_stock', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">P. Code</label>
                                <input type='text' class="form-control" id="p_code" name="p_code" placeholder="" value="<?php echo set_value('p_code', (isset($post_data['p_code']) ? $post_data['p_code'] : '')); ?>" data-error=".pcodeerror"/>
                                <div class="pcodeerror error_msg"><?php echo form_error('p_code', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">HSN/SAC</label>
                                <input type='text' class="form-control" id="hsn_sac" name="hsn_sac" placeholder="" value="<?php echo set_value('hsn_sac', (isset($post_data['hsn_sac']) ? $post_data['hsn_sac'] : '')); ?>" data-error=".hsnsacerror"/>
                                <div class="hsnsacerror error_msg"><?php echo form_error('hsn_sac', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">D. P.</label>
                                <input type='text' class="form-control" id="d_p" name="d_p" placeholder="" value="<?php echo set_value('d_p', (isset($post_data['d_p']) ? $post_data['d_p'] : '')); ?>" data-error=".dperror"/>
                                <div class="dperror error_msg"><?php echo form_error('d_p', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">B. V.</label>
                                <input type='text' class="form-control" id="b_v" name="b_v" placeholder="" value="<?php echo set_value('b_v', (isset($post_data['b_v']) ? $post_data['b_v'] : '')); ?>" data-error=".bverror"/>
                                <div class="bverror error_msg"><?php echo form_error('b_v', '<label class="danger">', '</label>'); ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="row row-sm">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="7" data-error=".descriptionerror"><?php echo (isset($post_data['description']) ? $post_data['description'] : ''); ?></textarea>
                                        <div class="descriptionerror error_msg"><?php echo form_error('description', '<label class="danger">', '</label>'); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row row-sm">
                                <div class="col-md-12 d-none">
                                    <div class="form-group">
                                        <label class="form-label">Gst Type</label>
                                        <select class="select2" name="gst_type" id="gst_type" style="width: 100%;" data-error=".gsttypeerror">
                                            <option value="">-- Select Gst Type --</option>
                                            <option value="CGST" <?php if(isset($post_data['gst_type']) && $post_data['gst_type'] == 'CGST'){ echo 'selected="selected"'; } ?>>CGST</option>
                                            <option value="SGST" <?php if(isset($post_data['gst_type']) && $post_data['gst_type'] == 'SGST'){ echo 'selected="selected"'; } ?>>SGST</option>
                                            <option value="IGST" <?php if(isset($post_data['gst_type']) && $post_data['gst_type'] == 'IGST'){ echo 'selected="selected"'; } ?>>IGST</option>
                                        </select>
                                        <div class="gsttypeerror error_msg"><?php echo form_error('gst_type', '<label class="danger">', '</label>'); ?></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">GST (%)</label>
                                        <input type='text' class="form-control" id="gst" name="gst" placeholder="" value="<?php echo set_value('gst', (isset($post_data['gst']) ? $post_data['gst'] : '')); ?>" data-error=".gsterror"/>
                                        <div class="gsterror error_msg"><?php echo form_error('gst', '<label class="danger">', '</label>'); ?></div>
                                    </div>
                                </div>
                                <?php /* ?>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">CGST</label>
                                        <input type='text' class="form-control" id="cgst" name="cgst" placeholder="" value="<?php echo set_value('cgst', (isset($post_data['cgst']) ? $post_data['cgst'] : '')); ?>" data-error=".cgsterror"/>
                                        <div class="cgsterror error_msg"><?php echo form_error('cgst', '<label class="danger">', '</label>'); ?></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">SGST</label>
                                        <input type='text' class="form-control" id="sgst" name="sgst" placeholder="" value="<?php echo set_value('sgst', (isset($post_data['sgst']) ? $post_data['sgst'] : '')); ?>" data-error=".sgsterror"/>
                                        <div class="sgsterror error_msg"><?php echo form_error('sgst', '<label class="danger">', '</label>'); ?></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">IGST</label>
                                        <input type='text' class="form-control" id="igst" name="igst" placeholder="" value="<?php echo set_value('igst', (isset($post_data['igst']) ? $post_data['igst'] : '')); ?>" data-error=".igsterror"/>
                                        <div class="igsterror error_msg"><?php echo form_error('igst', '<label class="danger">', '</label>'); ?></div>
                                    </div>
                                </div>
                                <?php */ ?>
                                <div class="col-md-12 mt-2 mb-2">
                                    <div class="form-group">
                                        <!-- <label class="form-label">Return?</label> -->
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <label class="ckbox"><input type="checkbox" name="return" value="1" data-error=".returnerror" <?php if(isset($post_data['return']) && $post_data['return'] == 1){?> checked <?php } ?> ><span>Return?</span></label>
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="ckbox"><input type="checkbox" name="replace" value="1" data-error=".replaceerror" <?php if(isset($post_data['replace']) && $post_data['replace'] == 1){?> checked <?php } ?> ><span>Replace?</span></label>
                                            </div>
                                        </div>
                                        <div class="replaceerror error_msg"><?php echo form_error('replace', '<label class="danger">', '</label>'); ?></div>
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
                    </div>

                    <div class="row row-sm">
                        <div class="col-12 mg-t-10 text-right">
                            <button class="btn btn-main-primary pd-x-20 mr-2" type="submit">Save</button>
                            <a href="<?php echo base_url(franchise_products_constants::franchise_products_url); ?>" class="btn btn-secondary custom-btn-secondary">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php echo Modules::run("gallery/gallery_images/modal"); ?>

<script type="text/javascript">
    $('#gst_type, #status').select2();

    $("#formId").validate({
        rules: {
            name: {
                required: true,
            },
            mrp: {
                required: true,
                number: true,
                min: 1,
            },
            opening_stock: {
                required: true,
                number: true,
            },
            gst: {
                number: true,
            },
            // cgst: {
            //     number: true,
            // },
            // sgst: {
            //     number: true,
            // },
            // igst: {
            //     number: true,
            // },
            status: {
                required: true,
            },
        },
        messages: {
            name: {
                required: 'Please enter name',
            },
            mrp: {
                required: 'Please enter mrp',
                number: "Please enter valid mrp",
                min: "Minimum mrp must be 1",
            },
            opening_stock: {
                required: "Please enter opening stock",
                number: "Please enter valid opening stock",
            },
            gst: {
                number: 'Please enter valid gst',
            },
            // cgst: {
            //     number: 'Please enter valid cgst',
            // },
            // sgst: {
            //     number: 'Please enter valid sgst',
            // },
            // igst: {
            //     number: 'Please enter valid igst',
            // },
            status:{
                required: "Please select status",
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