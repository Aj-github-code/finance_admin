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
                    <input type="hidden" name="tags_val" id="tags_val" value="">

                    <div class="row row-sm">
                        <div class="col-md-12">
                            <div class="row row-sm">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Size Name <span class="asterisk">*</span></label>
                                        <input type='text' class="form-control" id="name" name="name" placeholder="" value="<?php echo set_value('name', (isset($post_data['name']) ? $post_data['name'] : '')); ?>" data-error=".nameerror" maxlength="255" required/>
                                        <div class="nameerror error_msg"><?php echo form_error('name', '<label class="danger">', '</label>'); ?></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Size Tags <span class="asterisk">*</span></label>
                                        <input type='text' class="form-control sizetags" id="tags" name="tags" placeholder="" value="<?php echo set_value('tags', (isset($post_data['tags']) ? $post_data['tags'] : '')); ?>" data-error=".tagserror" maxlength="255" />
                                        <div class="tagserror error_msg"><?php echo form_error('tags', '<label class="danger">', '</label>'); ?></div>
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
                        <div class="col-12 mg-t-10">
                            <button class="btn btn-main-primary pd-x-20 mr-2" type="submit">Save</button>
                            <a href="<?php echo base_url(product_constants::product_sizes_url); ?>" class="btn btn-secondary custom-btn-secondary">Cancel</a>
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
                required: 'Please enter size name',
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
            event.preventDefault();
            var tags = $(".sizetags").tagsManager('tags');
            var showError = true;
            if($('#tags').val() != '')
            {
                showError = false;
            }
            else
            {
                if(tags.length > 0)
                {
                    showError = false;
                }
            }

            $('.tagserror').html('');
            if(showError)
            {
                $('.tagserror').html('<div id="tags-error" class="danger">Please enter atleast one tag</div>');
            }
            else
            {
                if($('#tags').val() != '')
                {
                    $(".sizetags").tagsManager('pushTag', $('#tags').val());
                    $('#tags').val('');
                }
                tags = $(".sizetags").tagsManager('tags');
                $('#tags_val').val(tags.join(","));
                showLoader();
                form.submit();
            }
        }
    });

    $(document).ready(function() {
        var tag_array = [<?php echo '"'.implode('","', $tags).'"' ?>];
        var tagApi = $(".sizetags").tagsManager({
            prefilled : tag_array,
        });
        
        $(".sizetags").typeahead({
            name: 'tags',
            displayKey: 'tags',
            source: function (query, process) {
            },
            afterSelect :function (item){
                tagApi.tagsManager("pushTag", item);
            }
        });
    });
</script>