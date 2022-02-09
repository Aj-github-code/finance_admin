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
                                        <label class="form-label">Title <span class="asterisk">*</span></label>
                                        <input type='text' class="form-control" id="title" name="title" placeholder="" value="<?php echo set_value('title', (isset($post_data['title']) ? $post_data['title'] : '')); ?>" data-error=".titleerror" maxlength="100" required/>
                                        <div class="titleerror error_msg"><?php echo form_error('title', '<label class="danger">', '</label>'); ?></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>File</label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="file" name="file" required data-error=".fileerror">
                                                    <label class="custom-file-label" for="file">Choose file</label>
                                                </div>
                                                <div class="fileerror error_msg"><?php echo form_error('file', '<label class="danger">', '</label>'); ?></div>
                                            </div>
                                        </div>
                                        <?php if(isset($post_data['file']) && !empty($post_data['file'])){ ?>
                                            <div class="col-md-12" id="file_wrap">
                                                <div class="row m-b-20">
                                                    <div class="col-md-12">
                                                        <a href="<?php echo content_url($post_data['file']); ?>" target="_blank" id="file_tag"><?php echo basename(parse_url($post_data['file'], PHP_URL_PATH)); ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-md-12">
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
                                    <div class="form-group">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="12" data-error=".descriptionerror"><?php echo (isset($post_data['description']) ? $post_data['description'] : ''); ?></textarea>
                                        <div class="descriptionerror error_msg"><?php echo form_error('description', '<label class="danger">', '</label>'); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row row-sm">
                        <div class="col-12 mg-t-10">
                            <button class="btn btn-main-primary pd-x-20 mr-2" type="submit">Save</button>
                            <a href="<?php echo base_url(announcements_constants::announcements_url); ?>" class="btn btn-secondary custom-btn-secondary">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php echo Modules::run("gallery/gallery_images/modal"); ?>

<script type="text/javascript">
    $('#status').select2();

    $("#formId").validate({
        rules: {
            title: {
                required: true,
            },
            file: {
                extension: 'pdf'
            },
            status: {
                required: true,
            },
        },
        messages: {
            title: {
                required: 'Please enter title',
            },
            file: {
                extension: 'Only pdf file is allowed'
            },
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