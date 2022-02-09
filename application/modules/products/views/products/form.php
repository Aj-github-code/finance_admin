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

                    <div class="bg-gray-300 nav-bg">
                        <nav class="nav nav-tabs">
                            <a class="nav-link active" data-toggle="tab" href="#tabCont1">Basic Info</a>
                            <a class="nav-link" data-toggle="tab" href="#tabCont2">Images</a>
                            <a class="nav-link" data-toggle="tab" href="#tabCont3">Size</a>
                            <a class="nav-link d-none" data-toggle="tab" href="#tabCont4">Bulk Price</a>
                        </nav>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane active show" id="tabCont1">
                            <div class="row row-sm">
                                <div class="col-md-6">
                                    <div class="row row-sm">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Product Name <span class="asterisk">*</span></label>
                                                <input type='text' class="form-control" id="name" name="name" placeholder="" value="<?php echo set_value('name', (isset($post_data['name']) ? $post_data['name'] : '')); ?>" data-error=".nameerror" maxlength="255" required/>
                                                <div class="nameerror error_msg"><?php echo form_error('name', '<label class="danger">', '</label>'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Product Code <span class="asterisk">*</span></label>
                                                <input type='text' class="form-control" id="product_code" name="product_code" placeholder="" value="<?php echo set_value('product_code', (isset($post_data['product_code']) ? $post_data['product_code'] : '')); ?>" data-error=".product_codeerror" maxlength="255" required/>
                                                <div class="product_codeerror error_msg"><?php echo form_error('product_code', '<label class="danger">', '</label>'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Brands <span class="asterisk">*</span></label>
                                                <div class="brand_wrap">
                                                    <select class="select2" name="brand_id" id="brand_id" data-error=".brand_iderror" style="width: 100%;">
                                                        <option value="">-- Select Product Brands --</option>
                                                    </select>
                                                </div>
                                                <div class="brand_iderror error_msg"><?php echo form_error('brand_id', '<label class="danger">', '</label>'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Color </label>
                                                <div class="color_wrap">
                                                    <select class="select2" name="color_id" id="color_id" data-error=".color_iderror" style="width: 100%;">
                                                        <option value="">-- Select Product Color --</option>
                                                    </select>
                                                </div>
                                                <div class="color_iderror error_msg"><?php echo form_error('color_id', '<label class="danger">', '</label>'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">MRP Price<span class="asterisk">*</span></label>
                                                <input type='text' class="form-control" id="mrp_price" name="mrp_price" placeholder="" value="<?php echo set_value('mrp_price', (isset($post_data['mrp_price']) ? $post_data['mrp_price'] : '')); ?>" data-error=".mrp_priceerror" maxlength="255" required/>
                                                <div class="mrp_priceerror error_msg"><?php echo form_error('mrp_price', '<label class="danger">', '</label>'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Selling Price<span class="asterisk">*</span></label>
                                                <input type='text' class="form-control" id="selling_price" name="selling_price" placeholder="" value="<?php echo set_value('selling_price', (isset($post_data['selling_price']) ? $post_data['selling_price'] : '')); ?>" data-error=".selling_priceerror" maxlength="255"/>
                                                <div class="selling_priceerror error_msg"><?php echo form_error('selling_price', '<label class="danger">', '</label>'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Offer Price<span class="asterisk"></span></label>
                                                <input type='text' class="form-control" id="offer_price" name="offer_price" placeholder="" value="<?php echo set_value('offer_price', (isset($post_data['offer_price']) ? $post_data['offer_price'] : '')); ?>" data-error=".offer_priceerror" maxlength="255"/>
                                                <div class="offer_priceerror error_msg"><?php echo form_error('offer_price', '<label class="danger">', '</label>'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 d-none">
                                            <div class="form-group">
                                                <label class="form-label">Special Discount (%)<span class="asterisk"></span></label>
                                                <input type='text' class="form-control" id="special_discount_price" name="special_discount_price" placeholder="" value="<?php echo set_value('special_discount_price', (isset($post_data['special_discount_price']) ? $post_data['special_discount_price'] : '')); ?>" data-error=".special_discount_priceerror" maxlength="255" />
                                                <div class="special_discount_priceerror error_msg"><?php echo form_error('special_discount_price', '<label class="danger">', '</label>'); ?></div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Product Intro <span class="asterisk">*</span></label>
                                                <input type='text' class="form-control" id="product_intro" name="product_intro" placeholder="" value="<?php echo set_value('product_intro', (isset($post_data['product_intro']) ? $post_data['product_intro'] : '')); ?>" data-error=".product_introerror" maxlength="255" required/>
                                                <div class="product_introerror error_msg"><?php echo form_error('product_intro', '<label class="danger">', '</label>'); ?></div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Delivery Timeline <span class="asterisk"></span></label>
                                                <input type='text' class="form-control" id="delivery_timeline" name="delivery_timeline" placeholder="" value="<?php echo set_value('delivery_timeline', (isset($post_data['delivery_timeline']) ? $post_data['delivery_timeline'] : '')); ?>" data-error=".delivery_timelineerror" maxlength="255" />
                                                <div class="delivery_timelineerror error_msg"><?php echo form_error('delivery_timeline', '<label class="danger">', '</label>'); ?></div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Warranty <span class="asterisk"></span></label>
                                                <input type='text' class="form-control" id="warranty" name="warranty" placeholder="" value="<?php echo set_value('warranty', (isset($post_data['warranty']) ? $post_data['warranty'] : '')); ?>" data-error=".warrantyerror" maxlength="255" />
                                                <div class="warrantyerror error_msg"><?php echo form_error('warranty', '<label class="danger">', '</label>'); ?></div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Filter For<span class="asterisk"></span></label>
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <label class="ckbox"><input type="checkbox" name="best_seller" value="1" data-error=".product_filtererror" <?php if(isset($post_data['best_seller']) && !empty($post_data['best_seller'])){?> checked <?php } ?> ><span>Bestseller</span></label>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label class="ckbox"><input type="checkbox" name="product_of_the_week" value="1" data-error=".product_filtererror" <?php if(isset($post_data['product_of_the_week']) && !empty($post_data['product_of_the_week'])){?> checked <?php } ?> ><span>Product Of the week</span></label>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label class="ckbox"><input type="checkbox" name="new" value="1" data-error=".product_filtererror" <?php if(isset($post_data['new']) && !empty($post_data['new'])){?> checked <?php } ?> ><span>New</span></label>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label class="ckbox"><input type="checkbox" name="on_offer" value="1" data-error=".product_filtererror" <?php if(isset($post_data['on_offer']) && !empty($post_data['on_offer'])){?> checked <?php } ?> ><span>On Offer</span></label>
                                                    </div>
                                                    <div class="col-lg-3" style="margin-top: 2%">
                                                        <label class="ckbox"><input type="checkbox" name="essential" value="1" data-error=".product_filtererror" <?php if(isset($post_data['essential']) && !empty($post_data['essential'])){?> checked <?php } ?> ><span>Essential</span></label>
                                                    </div>
                                                    <div class="col-lg-3" style="margin-top: 2%">
                                                        <label class="ckbox"><input type="checkbox" name="featured" value="1" data-error=".product_filtererror" <?php if(isset($post_data['featured']) && !empty($post_data['featured'])){?> checked <?php } ?> ><span>Featured</span></label>
                                                    </div>
                                                </div>
                                                <div class="product_filtererror error_msg"><?php echo form_error('product_filter', '<label class="danger">', '</label>'); ?></div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">HSN Code <span class="asterisk"></span></label>
                                                <input type='text' class="form-control" id="hsn_code" name="hsn_code" placeholder="" value="<?php echo set_value('hsn_code', (isset($post_data['hsn_code']) ? $post_data['hsn_code'] : '')); ?>" data-error=".hsn_codeerror" maxlength="255" />
                                                <div class="hsn_codeerror error_msg"><?php echo form_error('hsn_code', '<label class="danger">', '</label>'); ?></div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Visibility<span class="asterisk"></span></label>
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <label class="ckbox"><input type="checkbox" name="product_visibility" value="yes" data-error=".product_visibilityerror" <?php if(isset($post_data['product_visibility']) && $post_data['product_visibility'] == 'yes'){?> checked <?php } ?> ><span>Live product</span></label>
                                                    </div>
                                                </div>
                                                <div class="product_visibilityerror error_msg"><?php echo form_error('product_visibility', '<label class="danger">', '</label>'); ?></div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Gift Product<span class="asterisk"></span></label>
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <label class="ckbox"><input type="checkbox" id="offerable_product" name="offerable_product" value="yes" data-error=".offerable_producterror" <?php if(isset($post_data['offerable_product']) && $post_data['offerable_product'] == 'yes'){?> checked <?php } ?> ><span>Yes</span></label>
                                                    </div>
                                                </div>

                                                <div class="offerable_producterror error_msg"><?php echo form_error('offerable_product', '<label class="danger">', '</label>'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="offerable_product_wrapper">
                                                    <label class="form-label">Min Gift Product price</label>
                                                    <input type='text' class="form-control" id="min_offer_amount" name="min_offer_amount" placeholder="" value="<?php echo set_value('min_offer_amount', (isset($post_data['min_offer_amount']) ? $post_data['min_offer_amount'] : '')); ?>" data-error=".min_offer_amounterror" maxlength="255"/>

                                                    <div class="min_offer_amounterror error_msg"><?php echo form_error('min_offer_amount', '<label class="danger">', '</label>'); ?></div> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Product Availability Status <span class="asterisk">*</span></label>
                                                <select class="select2" name="availability" id="availability" style="width: 100%;" data-error=".availabilityerror" required>
                                                    <option value="1" <?php if(isset($post_data['availability']) && $post_data['availability'] == 1){ echo 'selected="selected"'; } ?>>Available</option>
                                                    <option value="2" <?php if(isset($post_data['availability']) && $post_data['availability'] == 2){ echo 'selected="selected"'; } ?>>Only Few Left</option>
                                                    <option value="3" <?php if(isset($post_data['availability']) && $post_data['availability'] == 3){ echo 'selected="selected"'; } ?>>Out Of Stock</option>
                                                </select>
                                                <div class="availabilityerror error_msg"><?php echo form_error('availability', '<label class="danger">', '</label>'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Type <span class="asterisk">*</span></label>
                                                <select class="select2" name="type" id="type" style="width: 100%;" data-error=".typeerror" required>
                                                    <option value="1" <?php if(isset($post_data['type']) && $post_data['type'] == 1){ echo 'selected="selected"'; } ?>>Product</option>
                                                    <option value="2" <?php if(isset($post_data['type']) && $post_data['type'] == 2){ echo 'selected="selected"'; } ?>>Voucher</option>
                                                </select>
                                                <div class="typeerror error_msg"><?php echo form_error('type', '<label class="danger">', '</label>'); ?></div>
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
                                                <label class="form-label">Category <span class="asterisk">*</span></label>
                                                <div class="category_wrap">
                                                    <select class="" name="category_id[]" id="category_id" data-error=".category_iderror" style="width: 100%;" >
                                                        <option value="">-- Select Category --</option>
                                                    </select>
                                                </div>
                                                <div class="categoryiderror error_msg"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">SubCategory <span class="asterisk">*</span></label>
                                                <div class="subcategory_wrap">
                                                    <select class="select2" name="subcategory_id[]" id="subcategory_id" data-error=".subcategory_iderror" style="width: 100%;" >
                                                        <option value="">-- Select Subcategory --</option>
                                                    </select>
                                                </div>
                                                <div class="subcategory_iderror error_msg"><?php echo form_error('subcategory_id', '<label class="danger">', '</label>'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">SKU <span class="asterisk">*</span></label>
                                                <input type='text' class="form-control" id="sku" name="sku" placeholder="" value="<?php echo set_value('sku', (isset($post_data['sku']) ? $post_data['sku'] : '')); ?>" data-error=".skuerror" maxlength="255" required/>
                                                <div class="skuerror error_msg"><?php echo form_error('sku', '<label class="danger">', '</label>'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Description<span class="asterisk">*</span></label>
                                                <textarea class="form-control" id="description" name="description" rows="8" data-error=".descriptionerror"><?php echo (isset($post_data['description']) ? $post_data['description'] : ''); ?></textarea>
                                                <div class="descriptionerror error_msg"><?php echo form_error('description', '<label class="danger">', '</label>'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Specification<span class="asterisk">*</span></label>
                                                <textarea class="form-control" id="specification" name="specification" rows="8" data-error=".specificationerror"><?php echo (isset($post_data['specification']) ? $post_data['specification'] : ''); ?></textarea>
                                                <div class="specificationerror error_msg"><?php echo form_error('specification', '<label class="danger">', '</label>'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Shipping<span class="asterisk">*</span></label>
                                                <textarea class="form-control" id="shipping" name="shipping" rows="8" data-error=".shippingerror"><?php echo (isset($post_data['shipping']) ? $post_data['shipping'] : ''); ?></textarea>
                                                <div class="shippingerror error_msg"><?php echo form_error('shipping', '<label class="danger">', '</label>'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Meta Title<span class="asterisk"></span></label>
                                                <input type='text' class="form-control" id="meta_title" name="meta_title" placeholder="" value="<?php echo set_value('code', (isset($post_data['meta_title']) ? $post_data['meta_title'] : '')); ?>" data-error=".meta_titleerror" maxlength="255" />
                                                <div class="meta_titleerror error_msg"><?php echo form_error('meta_title', '<label class="danger">', '</label>'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Meta Keyword<span class="asterisk"></span></label>
                                                <input type='text' class="form-control" id="meta_keyword" name="meta_keyword" placeholder="" value="<?php echo set_value('code', (isset($post_data['meta_keyword']) ? $post_data['meta_keyword'] : '')); ?>" data-error=".meta_keyworderror" maxlength="255" />
                                                <div class="meta_keyworderror error_msg"><?php echo form_error('meta_keyword', '<label class="danger">', '</label>'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Meta Description<span class="asterisk"></span></label>
                                                <textarea class="form-control" id="meta_description" name="meta_description" rows="8" data-error=".meta_descriptionerror"><?php echo (isset($post_data['meta_description']) ? $post_data['meta_description'] : ''); ?></textarea>
                                                <div class="meta_descriptionerror error_msg"><?php echo form_error('meta_description', '<label class="danger">', '</label>'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">GST<span class="asterisk"></span></label>
                                                <input type='text' class="form-control" id="product_gst" name="product_gst" placeholder="" value="<?php echo set_value('product_gst', (isset($post_data['product_gst']) ? $post_data['product_gst'] : '')); ?>" data-error=".product_gsterror" maxlength="255"/>
                                                <div class="product_gsterror error_msg"><?php echo form_error('product_gst', '<label class="danger">', '</label>'); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabCont2">
                            <div class="col-md-12">
                                <div id="thumbnail_wrapper">
                                    <?php if(isset($image_data) && !empty($image_data)){
                                        foreach ($image_data as $key => $value) {
                                    ?>
                                    <div class="thumbnail_container" id="container_<?=$key+1?>">
                                        <div class="form-group">
                                            <?php if($key == 0){?>
                                                <label class="form-label">Thumbnail:  <span class="note"> (Dimension : 600 * 600) </span> </label>
                                            <?php } else{ ?>
                                                <label class="form-label">Image <?=$key+1?>:  </label>  
                                            <?php }?>
                                            <div class="input-group">
                                                <input type="hidden" name="thumbnail_id[]" value="<?=$value['id']?>">
                                                <input type="text" placeholder="" class="form-control" id="thumbnail_<?=$key+1?>" name="thumbnail[]" data-error=".thumbnailerror" value="<?php echo set_value('thumbnail', (isset($value['thumbnail']) ? $value['thumbnail'] : '')); ?>" readonly required>
                                                <span class="input-group-btn" id="button-addon2" style="margin-right: 3px;">
                                                    <button class="btn btn-main-primary br-tl-0 br-bl-0" type="button" onclick="open_image_gallery('thumbnail_<?=$key+1?>');">Gallery</button>
                                                </span>
                                                <?php if($key == 0){ ?>
                                                <span class="input-group-btn" id="button-addon2">
                                                    <button class="btn btn-main-primary br-tl-0 br-bl-0" type="button" id="add_more_image">+</button>
                                                </span>
                                                <?php }else{?>
                                                <span class="input-group-btn" id="button-addon2"><button class="btn btn-main-primary br-tl-0 br-bl-0 remove" type="button" data-id="<?=$key+1?>">-</button></span>
                                                <?php }?>
                                            </div>
                                            <div class="thumbnailerror error_msg"><?php echo form_error('thumbnail', '<label class="danger">', '</label>'); ?></div>
                                        </div>
                                        <?php if($key == 0){?> 
                                            <div class="form-group">
                                                <label class="form-label">Hover Thumbnail: <span class="note"> (Dimension : 600 * 600) </span> </label>
                                                <div class="input-group">
                                                    <input type="text" placeholder="" class="form-control" id="hover_thumbnail" name="hover_thumbnail" data-error=".hover_thumbnailerror" value="<?php echo set_value('hover_thumbnail', (isset($post_data['hover_thumbnail']) ? $post_data['hover_thumbnail'] : '')); ?>" readonly required>
                                                    <span class="input-group-btn" id="button-addon2" style="margin-right: 3px;">
                                                        <button class="btn btn-main-primary br-tl-0 br-bl-0" type="button" onclick="open_image_gallery('hover_thumbnail');">Gallery</button>
                                                    </span>
                                                </div>
                                                <div class="hover_thumbnailerror error_msg"><?php echo form_error('hover_thumbnail', '<label class="danger">', '</label>'); ?></div>
                                            </div>
                                        <?php }?>
                                        <div class="form-group">
                                            <?php if($key == 0){?>
                                                <label class="form-label">Zoom Thumbnail:  <span class="note"> (Dimension : 600 * 600) </span> </label>
                                            <?php } else{ ?>
                                                <label class="form-label">Image <?=$key+1?>:  </label>  
                                            <?php }?>
                                            <div class="input-group">
                                                <input type="text" placeholder="" class="form-control" id="zoom_thumbnail_<?=$key+1?>" name="zoom_thumbnail[]" data-error=".zoom_thumbnailerror" value="<?php echo set_value('zoom_thumbnail', (isset($value['zoom_thumbnail']) ? $value['zoom_thumbnail'] : '')); ?>" readonly required>
                                                <span class="input-group-btn" id="button-addon2" style="margin-right: 3px;">
                                                    <button class="btn btn-main-primary br-tl-0 br-bl-0" type="button" onclick="open_image_gallery('zoom_thumbnail_<?=$key+1?>');">Gallery</button>
                                                </span>
                                            </div>
                                            <div class="zoom_thumbnailerror error_msg"><?php echo form_error('zoom_thumbnail', '<label class="danger">', '</label>'); ?></div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" placeholder="Image description" class="form-control" id="thumbnail_slug" name="thumbnail_slug[]" data-error=".thumbnail_slugerror" value="<?php echo set_value('thumbnail_slug', (isset($value['thumbnail_slug']) ? $value['thumbnail_slug'] : '')); ?>" >
                                            </div>
                                            <div class="thumbnail_slugerror error_msg"><?php echo form_error('thumbnail_slug', '<label class="danger">', '</label>'); ?></div>
                                        </div>
                                    </div>
                                    <?php } }
                                        else{ 
                                    ?>
                                    <div class="thumbnail_container" id="container_1">
                                        <div class="form-group">
                                            <label class="form-label">Thumbnail: <span class="note"> (Dimension : 600 * 600) </span></label>
                                            <div class="input-group">
                                                <input type="text" placeholder="" class="form-control" id="thumbnail" name="thumbnail[]" data-error=".thumbnailerror" value="<?php echo set_value('thumbnail', (isset($post_data['thumbnail']) ? $post_data['thumbnail'] : '')); ?>" readonly required>
                                                <span class="input-group-btn" id="button-addon2" style="margin-right: 3px;">
                                                    <button class="btn btn-main-primary br-tl-0 br-bl-0" type="button" onclick="open_image_gallery('thumbnail');">Gallery</button>
                                                </span>
                                                <span class="input-group-btn" id="button-addon2">
                                                    <button class="btn btn-main-primary br-tl-0 br-bl-0" type="button" id="add_more_image">+</button>
                                                </span>
                                            </div>
                                            <div class="thumbnailerror error_msg"><?php echo form_error('thumbnail', '<label class="danger">', '</label>'); ?></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Hover Thumbnail: <span class="note"> (Dimension : 600 * 600) </span> </label>
                                            <div class="input-group">
                                                <input type="text" placeholder="" class="form-control" id="hover_thumbnail" name="hover_thumbnail" data-error=".hover_thumbnailerror" value="<?php echo set_value('hover_thumbnail', (isset($post_data['hover_thumbnail']) ? $post_data['hover_thumbnail'] : '')); ?>" readonly required>
                                                <span class="input-group-btn" id="button-addon2" style="margin-right: 3px;">
                                                    <button class="btn btn-main-primary br-tl-0 br-bl-0" type="button" onclick="open_image_gallery('hover_thumbnail');">Gallery</button>
                                                </span>
                                            </div>
                                            <div class="hover_thumbnailerror error_msg"><?php echo form_error('hover_thumbnail', '<label class="danger">', '</label>'); ?></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Zoom Thumbnail: <span class="note"> (Dimension : 600 * 600) </span> </label>
                                            <div class="input-group">
                                                <input type="text" placeholder="" class="form-control" id="zoom_thumbnail" name="zoom_thumbnail[]" data-error=".zoom_thumbnailerror" value="<?php echo set_value('zoom_thumbnail', (isset($post_data['zoom_thumbnail']) ? $post_data['zoom_thumbnail'] : '')); ?>" readonly required>
                                                <span class="input-group-btn" id="button-addon2" style="margin-right: 3px;">
                                                    <button class="btn btn-main-primary br-tl-0 br-bl-0" type="button" onclick="open_image_gallery('zoom_thumbnail');">Gallery</button>
                                                </span>
                                            </div>
                                            <div class="zoom_thumbnailerror error_msg"><?php echo form_error('zoom_thumbnail', '<label class="danger">', '</label>'); ?></div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" placeholder="Image description" class="form-control" id="thumbnail_slug" name="thumbnail_slug[]" data-error=".thumbnail_slugerror" value="<?php echo set_value('thumbnail_slug', (isset($post_data['thumbnail_slug']) ? $post_data['thumbnail_slug'] : '')); ?>">
                                            </div>
                                            <div class="thumbnail_slugerror error_msg"><?php echo form_error('thumbnail_slug', '<label class="danger">', '</label>'); ?></div>
                                        </div>
                                    </div>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabCont3">
                            <div class="col-md-12">
                                <div class="size_chart_container" id="container_1">
                                    <div class="form-group">
                                        <label class="form-label">Size chart image</label>
                                        <div class="input-group">
                                            <input type="text" placeholder="" class="form-control" id="size_chart_image" name="size_chart_image" data-error=".size_chart_imageerror" value="<?php echo set_value('size_chart_image', (isset($post_data['size_chart_image']) ? $post_data['size_chart_image'] : '')); ?>" readonly>
                                            <span class="input-group-btn" id="button-addon2" style="margin-right: 3px;">
                                                <button class="btn btn-main-primary br-tl-0 br-bl-0" type="button" onclick="open_image_gallery('size_chart_image');">Gallery</button>
                                            </span>
                                        </div>
                                        <div class="size_chart_imageerror error_msg"><?php echo form_error('size_chart_image', '<label class="danger">', '</label>'); ?></div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" placeholder="Size chart description" class="form-control" id="size_cart_desc" name="size_cart_desc" data-error=".size_cart_descerror" value="<?php echo set_value('size_cart_desc', (isset($post_data['size_cart_desc']) ? $post_data['size_cart_desc'] : '')); ?>">
                                        </div>
                                        <div class="size_cart_descerror error_msg"><?php echo form_error('size_cart_desc', '<label class="danger">', '</label>'); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="size_wrapper">
                                    <?php if(isset($size_data) && !empty($size_data)){
                                        foreach ($size_data as $key => $value) {
                                    ?>
                                        <input type="hidden" name="product_quantity_id[]" value="<?=$value['id']?>">
                                        <div class="row row-sm row_size_wrapper" id="size_row_<?=$key+1?>">
                                            <div class="col-md-4">
                                                <?php if($key == 0){?>
                                                    <label class="form-label">Size <span class="asterisk"></span></label>
                                                <?php }?>
                                                <div class="size_wrap">
                                                    <select class="select2 size size_wrap_options" name="size_id[]" id="size_id_<?=$key+1?>" data-error=".size_iderror" style="width: 100%;" data-id="<?=$key+1?>" >
                                                        <option value="">-- Select Size --</option>
                                                        <?php if(isset($size_options) && !empty($size_options)){
                                                            foreach ($size_options as $size_option_key => $size_option_value) {
                                                        ?>
                                                            <option value="<?=$size_option_value['id']?>" <?php if($size_option_value['id'] == $value['size_id']){?> selected <?php } ?> ><?=$size_option_value['name']?></option>
                                                        <?php } } ?>
                                                    </select>
                                                </div>
                                                <div class="size_iderror error_msg"><?php echo form_error('size_id', '<label class="danger">', '</label>'); ?></div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <?php if($key == 0){?>
                                                        <label class="form-label">Size Tags<span class="asterisk"></span></label>
                                                    <?php }?>
                                                    <div class="size_tag_wrap">
                                                        <select class="select2 size_tag" name="size_tag_id[]" id="size_tag_id_<?=$key+1?>" style="width: 100%;" data-error=".size_tag_iderror" >
                                                            <option value="">-- Select Size Tag --</option>
                                                            <?php if(isset($size_tag_options[$key]) && !empty($size_tag_options[$key])){
                                                                foreach ($size_tag_options[$key] as $size_option_tag_key => $size_option_tag_value) {
                                                            ?>
                                                                <option value="<?=$size_option_tag_value['id']?>" <?php if($size_option_tag_value['id'] == $value['size_tag_id']){?> selected <?php } ?> ><?=$size_option_tag_value['size_tag_name']?></option>
                                                            <?php } } ?>
                                                        </select>
                                                    </div>
                                                    <div class="size_tag_iderror error_msg"><?php echo form_error('size_tag_id', '<label class="danger">', '</label>'); ?></div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <?php if($key == 0){?>
                                                        <label class="form-label">Quantity <span class="asterisk"></span></label>
                                                    <?php }?>
                                                    <input type="text" placeholder="" class="form-control" id="quantity_<?=$key+1?>" name="quantity[]" data-error=".quantityerror" value="<?php echo set_value('quantity', (isset($value['quantity']) ? $value['quantity'] : '')); ?>" >
                                                    <div class="quantityerror error_msg"><?php echo form_error('quantity', '<label class="danger">', '</label>'); ?></div>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label class="form-label"> </label>
                                                    <?php if($key == 0){ ?>
                                                        <div class="input-group-btn" id="button-addon2" style="padding-top: 22%;">
                                                            <button class="btn btn-main-primary br-tl-0 br-bl-0" type="button" id="add_more_size">+</button>
                                                        </div> 
                                                    <?php } else{ ?>
                                                        <div class="input-group-btn" id="button-addon2" style="padding-top: 2%;">
                                                        <button class="btn btn-main-primary br-tl-0 br-bl-0 remove_size" type="button" id="remove_more_size_<?=$key+1?>" data-id="<?=$key+1?>" >-</button>
                                                    </div> 
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>

                                    <?php }} 

                                    else if(empty($size_data) && isset($post_data['id']) ){?>
                                        <div class="row row-sm row_size_wrapper" id="size_row_1">
                                            <div class="col-md-4">
                                                <label class="form-label">Size <span class="asterisk"></span></label>
                                                <div class="size_wrap">
                                                    <select class="select2 size size_wrap_options" name="size_id[]" id="size_id_1" data-error=".size_iderror" style="width: 100%;" data-id="1" >
                                                        <option value="">-- Select Size --</option>
                                                        <?php if(isset($size_options) && !empty($size_options)){
                                                            foreach ($size_options as $size_option_key => $size_option_value) {
                                                        ?>
                                                            <option value="<?=$size_option_value['id']?>"><?=$size_option_value['name']?></option>
                                                        <?php } } ?>
                                                    </select>
                                                </div>
                                                <div class="size_iderror error_msg"><?php echo form_error('size_id', '<label class="danger">', '</label>'); ?></div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Size Tags<span class="asterisk"></span></label>
                                                    <div class="size_tag_wrap">
                                                        <select class="select2 size_tag" name="size_tag_id[]" id="size_tag_id_1" style="width: 100%;" data-error=".size_tag_iderror" >
                                                            <option value="">-- Select Size Tag --</option>
                                                        </select>
                                                    </div>
                                                    <div class="size_tag_iderror error_msg"><?php echo form_error('size_tag_id', '<label class="danger">', '</label>'); ?></div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Quantity <span class="asterisk"></span></label>
                                                    <input type="text" placeholder="" class="form-control" id="quantity_1" name="quantity[]" data-error=".quantityerror" value="<?php echo set_value('quantity', (isset($value['quantity']) ? $value['quantity'] : '')); ?>" >
                                                    <div class="quantityerror error_msg"><?php echo form_error('quantity', '<label class="danger">', '</label>'); ?></div>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label class="form-label"> </label>
                                                    <div class="input-group-btn" id="button-addon2" style="padding-top: 22%;">
                                                        <button class="btn btn-main-primary br-tl-0 br-bl-0" type="button" id="add_more_size">+</button>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                    else{ ?>
                                        <div class="row row-sm row_size_wrapper" >
                                            <div class="col-md-4">
                                                <label class="form-label">Size <span class="asterisk"></span></label>
                                                <div class="size_wrap">
                                                    <select class="select2 size" name="size_id[]" id="size_id" data-error=".size_iderror" style="width: 100%;" >
                                                        <option value="">-- Select Size --</option>
                                                    </select>
                                                </div>
                                                <div class="size_iderror error_msg"><?php echo form_error('size_id', '<label class="danger">', '</label>'); ?></div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Size Tags<span class="asterisk"></span></label>
                                                    <div class="size_tag_wrap">
                                                        <select class="select2 size_tag" name="size_tag_id[]" id="size_tag_id" style="width: 100%;" data-error=".size_tag_iderror" >
                                                            <option value="">-- Select Size Tag --</option>
                                                        </select>
                                                    </div>
                                                    <div class="size_tag_iderror error_msg"><?php echo form_error('size_tag_id', '<label class="danger">', '</label>'); ?></div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Quantity <span class="asterisk"></span></label>
                                                    <input type="text" placeholder="" class="form-control" id="quantity" name="quantity[]" data-error=".quantityerror" value="<?php echo set_value('quantity', (isset($post_data['quantity']) ? $post_data['quantity'] : '')); ?>" >
                                                    <div class="quantityerror error_msg"><?php echo form_error('quantity', '<label class="danger">', '</label>'); ?></div>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label class="form-label"> </label>
                                                    <div class="input-group-btn" id="button-addon2" style="padding-top: 22%;">
                                                        <button class="btn btn-main-primary br-tl-0 br-bl-0" type="button" id="add_more_size">+</button>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabCont4">
                            <div class="col-md-12">
                                <div class="bulk_size_wrapper">
                                    <table class="col-md-12" id="bulk_price_table">
                                        <tbody id="bulk_price_table_body">
                                            <?php if(isset($bulk_data) && !empty($bulk_data)){
                                                foreach ($bulk_data as $bulk_key => $bulk_value) {
                                            ?>
                                                <tr class="table_rows" id="table_row_<?=$bulk_key+1?>">
                                                    <td>
                                                        <div class="">
                                                            <div class="form-group">
                                                                <?php if($bulk_key == 0){ ?>
                                                                    <label class="form-label">Min Quantity<span class="asterisk">*</span></label>
                                                                <?php }?>
                                                                <input type="hidden" name="bulk_id[]" value="<?=$bulk_value['id']?>">
                                                                <input type="text" placeholder="" class="form-control" id="min_bulk_<?=$bulk_value['id']?>" name="min_bulk[]" data-error=".min_bulkerror" value="<?php echo set_value('min_bulk', (isset($bulk_value['min_bulk']) ? $bulk_value['min_bulk'] : '1')); ?>" required readonly>
                                                                <div class="min_bulkerror error_msg"><?php echo form_error('min_bulk', '<label class="danger">', '</label>'); ?></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="">
                                                            <div class="form-group">
                                                                <?php if($bulk_key == 0){ ?>
                                                                    <label class="form-label">Max Quantity<span class="asterisk">*</span></label>
                                                                <?php }?>    
                                                                <input type="text" placeholder="" class="form-control" id="max_bulk_<?=$bulk_value['id']?>" name="max_bulk[]" data-error=".max_bulkerror" value="<?php echo set_value('max_bulk', (isset($bulk_value['max_bulk']) ? $bulk_value['max_bulk'] : '')); ?>" required readonly>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>    
                                                        <div class="">
                                                            <div class="form-group">
                                                                <?php if($bulk_key == 0){ ?>
                                                                    <label class="form-label">Bulk Price <span class="asterisk">*</span></label>
                                                                <?php }?>
                                                                <input type="text" placeholder="" class="form-control" id="bulk_price_<?=$bulk_value['id']?>" name="bulk_price[]" data-error=".bulk_priceerror" value="<?php echo set_value('bulk_price', (isset($bulk_value['bulk_price']) ? $bulk_value['bulk_price'] : '')); ?>" required>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>    
                                                        <div class="">
                                                            <div class="form-group">
                                                                <?php if($bulk_key == 0){ ?>
                                                                    <label class="form-label">Discount <span class="asterisk">*</span></label>
                                                                <?php }?>
                                                                <input type="text" placeholder="" class="form-control validate_integer" id="discount_<?=$bulk_value['id']?>" name="discount[]" data-error=".discounterror" value="<?php echo set_value('discount', (isset($bulk_value['discount']) ? $bulk_value['discount'] : 0)); ?>" required>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>    
                                                        <div class="">
                                                            <div class="form-group">
                                                                <?php if($bulk_key == 0){ ?>
                                                                    <label class="form-label">Production Days <span class="asterisk">*</span></label>
                                                                <?php }?>
                                                                <input type="text" placeholder="" class="form-control validate_integer" id="production_days_<?=$bulk_value['id']?>" name="production_days[]" data-error=".production_dayserror" value="<?php echo set_value('production_days', (isset($bulk_value['production_days']) ? $bulk_value['production_days'] : '')); ?>" required>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <?php if($bulk_key == 0){ ?>
                                                            <div class="">
                                                                <div class="form-group" style="width: 100px;">
                                                                    <label class="form-label"> </label>
                                                                    <div class="input-group-btn" id="button-addon2" style="padding-top: 12%;">
                                                                        <button class="btn btn-main-primary br-tl-0 br-bl-0" type="button" id="add_bulk_price_row">+</button>
                                                                        <button class="btn btn-main-primary br-tl-0 br-bl-0" type="button" id="remove_bulk_price_row">-</button>
                                                                    </div> 
                                                                </div>
                                                            </div>
                                                        <?php }?>
                                                    </td>
                                                </tr>      
                                            <?php } }
                                            else{
                                            ?>
                                                <tr class="table_rows" id="table_row_1">
                                                    <td>
                                                        <div class="">
                                                            <div class="form-group">
                                                                <label class="form-label">Min Quantity<span class="asterisk"></span></label>
                                                                <input type="text" placeholder="" class="form-control" id="min_bulk_1" name="min_bulk[]" data-error=".min_bulkerror" value="<?php echo set_value('min_bulk', (isset($post_data['min_bulk']) ? $post_data['min_bulk'] : '1')); ?>">
                                                                <div class="min_bulkerror error_msg"><?php echo form_error('min_bulk', '<label class="danger">', '</label>'); ?></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="">
                                                            <div class="form-group">
                                                                <label class="form-label">Max Quantity<span class="asterisk"></span></label>
                                                                <input type="text" placeholder="" class="form-control" id="max_bulk_1" name="max_bulk[]" data-error=".max_bulkerror" value="<?php echo set_value('max_bulk', (isset($post_data['max_bulk']) ? $post_data['max_bulk'] : '')); ?>" >
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>    
                                                        <div class="">
                                                            <div class="form-group">
                                                                <label class="form-label">Discount <span class="asterisk"></span></label>
                                                                <input type="text" placeholder="" class="form-control validate_integer product_discount"  id="discount_1" name="discount[]" data-error=".discounterror" value="<?php echo set_value('discount', (isset($post_data['discount']) ? $post_data['discount'] : 0)); ?>" >
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>    
                                                        <div class="">
                                                            <div class="form-group">
                                                                <label class="form-label">Bulk Price <span class="asterisk"></span></label>
                                                                <input type="text" placeholder="" class="product_bulk_price form-control" id="bulk_price_1" name="bulk_price[]" data-error=".bulk_priceerror" value="<?php echo set_value('bulk_price', (isset($post_data['bulk_price']) ? $post_data['bulk_price'] : '')); ?>" readonly>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>    
                                                        <div class="">
                                                            <div class="form-group">
                                                                <label class="form-label">Production Days <span class="asterisk"></span></label>
                                                                <input type="text" placeholder="" class="form-control validate_integer" id="production_days_1" name="production_days[]" data-error=".production_dayserror" value="<?php echo set_value('production_days', (isset($post_data['production_days']) ? $post_data['production_days'] : '')); ?>" >
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="">
                                                            <div class="form-group" style="width: 100px;">
                                                                <label class="form-label"> </label>
                                                                <div class="input-group-btn" id="button-addon2" style="padding-top: 12%;">
                                                                    <button class="btn btn-main-primary br-tl-0 br-bl-0" type="button" id="add_bulk_price_row">+</button>
                                                                    <button class="btn btn-main-primary br-tl-0 br-bl-0" type="button" id="remove_bulk_price_row">-</button>
                                                                </div> 
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td>   
                                                    <div class="">
                                                        <div class="form-group">
                                                            <div class="min_bulkerror error_msg"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>   
                                                    <div class="">
                                                        <div class="form-group">
                                                            <div class="max_bulkerror error_msg"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>   
                                                    <div class="">
                                                        <div class="form-group">
                                                            <div class="bulk_priceerror error_msg"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>   
                                                    <div class="">
                                                        <div class="form-group">
                                                            <div class="discounterror error_msg"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>   
                                                    <div class="">
                                                        <div class="form-group">
                                                            <div class="production_dayserror error_msg"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                                
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row row-sm">
                        <div class="col-12 mg-t-10">
                            <button class="btn btn-main-primary pd-x-20 mr-2" type="submit">Save</button>
                            <a href="<?php echo base_url(product_constants::products_url); ?>" class="btn btn-secondary custom-btn-secondary">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php echo Modules::run("gallery/gallery_images/modal"); ?>

<script type="text/javascript">
    $('#status, #type').select2();
    $('#availability').select2();
    $('#category_id').select2({
        multiple: true
    });
    $('#subcategory_id').select2({
        // multiple: true
    });
    $('.size').select2();
    $('.size_tag').select2();
    $('.color').select2();
    $('#brand_id').select2();

    var product_id      = '<?php echo (isset($post_data["id"]) ? $post_data["id"] : ""); ?>';
    
    var category_url    = base_url+'<?php echo product_constants::get_product_multi_categories_options_url; ?>';
    var category_id     = '<?php echo (isset($post_data["category_id"]) ? $post_data["category_id"] : ""); ?>';
    var parent_id       = '';
    category_multi_select_box(category_url, category_id, '', 'multiple',parent_id);
    
    

    var subcategory_id     = '<?php echo (isset($post_data["subcategory_id"]) ? $post_data["subcategory_id"] : ""); ?>';
    if( subcategory_id != ''){
        var subcategory_url    = base_url+'<?php echo product_constants::get_product_multi_categories_options_url; ?>';
        var subparent_id       = '<?php echo (isset($post_data["category_id"]) ? $post_data["category_id"] : ""); ?>';
        subcategory_multi_select_box(subcategory_url, subcategory_id, '', 'multiple',subparent_id);
    }
    
    $(document).on('change', '#category_id', function() {
        var category_url    = base_url+'<?php echo product_constants::get_product_multi_categories_options_url; ?>';
        var category_id     = $('#subcategory_id').val();
        var parent_id       = $('#category_id').val();
        // console.log(parent_id);
        parent_id = parent_id.join(",");
        subcategory_multi_select_box(category_url, category_id, '', 'multiple',parent_id);
    });

    if(product_id == '' || product_id == null){
        var size_url    = base_url+'<?php echo product_constants::get_product_size_options_url; ?>';
        var size_id     = '<?php echo (isset($post_data["size_id"]) ? $post_data["size_id"] : ""); ?>';
        size_select_box(size_url, size_id, '', '',parent_id);
    }
    if(product_id == '' || product_id == null){
        $(document).on('change', '#size_id', function() {
            var size_tag_url    = base_url+'<?php echo product_constants::get_product_size_tag_options_url; ?>';
            var size_tag_id     = $('#size_tag').val();
            var size_id         = $('#size_id').val();
            size_tag_select_box(size_tag_url, size_tag_id, '', '',size_id);
        });
    }

    if(product_id == '' || product_id == null){
        var color_url    = base_url+'<?php echo product_constants::get_product_color_options_url; ?>';
        var color_id     = '<?php echo (isset($post_data["color_id"]) ? $post_data["color_id"] : ""); ?>';
        color_select_box(color_url, color_id, '', '');
    }

    var brand_url    = base_url+'<?php echo product_constants::get_product_brand_options_url; ?>';
    var brand_id     = '<?php echo (isset($post_data["brand_id"]) ? $post_data["brand_id"] : ""); ?>';
    brand_select_box(brand_url, brand_id, '', '');

    var color_url    = base_url+'<?php echo product_constants::get_product_color_options_url; ?>';
    var color_id     = '<?php echo (isset($post_data["color_id"]) ? $post_data["color_id"] : ""); ?>';
    color_select_box(color_url, color_id, '', '');

    var maxField = 6; //Input fields increment limitation
    var wrapper = $('#thumbnail_wrapper'); //Input field wrapper
    var thumbnail_row_count = $('.thumbnail_container').length;
    var x = thumbnail_row_count;
    $('#add_more_image').click(function(){
        x++; //Increment field counter
        var thumbnail           = 1;
        var zoom_thumbnail      = 1;
        var thumbnail_id        = "thumbnail_"+x;
        var zoom_thumbnail_id   = "zoom_thumbnail_"+x;
        var fieldHTML = '<div class="thumbnail_container" id="container_'+x+'"><div class="form-group"><label class="form-label">Image '+x+':</label><div class="input-group"><input type="text" placeholder="" class="form-control" id="thumbnail_'+x+'" name="thumbnail[]" data-error=".thumbnailerror" readonly><span class="input-group-btn" id="button-addon2" style="margin-right: 3px;"><button class="btn btn-main-primary br-tl-0 br-bl-0" type="button" data-id="'+thumbnail_id+'" onclick="open_image_gallery('+thumbnail+', this);">Gallery</button></span><span class="input-group-btn" id="button-addon2"><button class="btn btn-main-primary br-tl-0 br-bl-0 remove" type="button" data-id="'+x+'">-</button></span></div><div class="thumbnailerror error_msg"><?php echo form_error('thumbnail', '<label class="danger">', '</label>'); ?></div></div><div class="form-group"><label class="form-label">Zoom Image '+x+':</label><div class="input-group"><input type="text" placeholder="" class="form-control" id="zoom_thumbnail_'+x+'" name="zoom_thumbnail[]" data-error=".zoom_thumbnailerror" readonly><span class="input-group-btn" id="button-addon2" style="margin-right: 3px;"><button class="btn btn-main-primary br-tl-0 br-bl-0" type="button" data-id="'+zoom_thumbnail_id+'" onclick="open_image_gallery('+zoom_thumbnail+', this);">Gallery</button></span></div><div class="zoom_thumbnailerror error_msg"><?php echo form_error('zoom_thumbnail', '<label class="danger">', '</label>'); ?></div></div><div class="form-group"><div class="input-group"><input type="text" placeholder="Image description" class="form-control" id="thumbnail_slug_'+x+'" name="thumbnail_slug[]" data-error=".thumbnail_slugerror" value="<?php echo set_value('thumbnail_slug', (isset($post_data['thumbnail_slug']) ? $post_data['thumbnail_slug'] : '')); ?>"></div></div></div>';
        $(wrapper).append(fieldHTML); //Add field html
    })

    $(document).on("click", ".remove" , function() {
        var remove_id = $(this).attr("data-id");
        var remove_element = "container_"+remove_id;
        $("#"+remove_element).remove();
        x--;
    });

    var size_row = $('.row_size_wrapper').length;
    $('#add_more_size').click(function(){
        var size_options = getSizeOptions();
        var color_options = getColorOptions();
        size_row++;
        var sizeFieldHTML = '<div class="row row_size_wrapper" id="size_row_'+size_row+'"><div class="col-md-4"><div class="size_wrap"><select class="select2 size size_wrap_options" name="size_id[]" id="size_id_'+size_row+'" data-error=".size_iderror" style="width: 100%;"  data-id="'+size_row+'">'+size_options+'</select></div></div><div class="col-md-4"><div class="form-group"><div class="size_tag_wrapp"><select class="select2 size_tag" name="size_tag_id[]" id="size_tag_id_'+size_row+'" style="width: 100%;" data-error=".size_tag_iderror"  data-id="'+size_row+'"><option>-- Select Size Tag --</option></select></div></div></div><div class="col-md-3"><div class="form-group"><input type="text" placeholder="" class="form-control" id="quantity_'+size_row+'" name="quantity[]" data-error=".quantityerror"  data-id="size_row"></div></div><div class="col-md-1"><div class="form-group"><div class="input-group-btn" id="button-addon2"><button class="btn btn-main-primary br-tl-0 br-bl-0 remove_size" type="button" id="remove_size_'+size_row+'" data-id="'+size_row+'">-</button></div></div></div></div>';
        $('.size_wrapper').append(sizeFieldHTML);
        $('#size_id_'+size_row).select2();
        $('#size_tag_id_'+size_row).select2();
        $('#color_id_'+size_row).select2();
    });

    function getSizeOptions(){
        var size_url = base_url+'<?php echo product_constants::get_product_size_options_url; ?>';
        var temp_size_options = null;
        $.ajax({
            type: "GET",
            dataType: "json",
            url : size_url,
            async: false,
            data: {},
            success: function(response) {
                temp_size_options = response;
            }
        });
        return temp_size_options;
    }
    function getColorOptions(){
        var color_url = base_url+'<?php echo product_constants::get_product_color_options_url; ?>';
        var temp_color_options = null;
        $.ajax({
            type: "GET",
            dataType: "json",
            url : color_url,
            async: false,
            data: {},
            success: function(response) {
                temp_color_options = response;
            }
        });
        return temp_color_options;
    }

    $(document).on('change', '.size_wrap_options', function() {
        var row_no = $(this).attr("data-id");
        var size_id = $(this).val();
        var size_url = base_url+'<?php echo product_constants::get_product_size_tag_options_url; ?>';
        var temp_size_tag_options = null;
        $.ajax({
            type: "GET",
            dataType: "json",
            data: {product_size_id : size_id},
            url : size_url,
            async: false,
            success: function(response) {
                temp_size_tag_options = response;
                $('#size_tag_id_'+row_no).html('');
                $('#size_tag_id_'+row_no).html(response);
            }
        });
        return temp_size_tag_options;
    });

    $(document).on("click", ".remove_size" , function() {
        var remove_id = $(this).attr("data-id");
        var remove_element = "size_row_"+remove_id;
        $("#"+remove_element).remove();
        // size_row--;
    });
    $(document).ready(function(){
        $('.size').select2();
        $('.color').select2();  
    })
    $('body').on('DOMNodeInserted', 'select', function () {
        $(this).select2();
    });

    $('#add_bulk_price_row').click(function(){
        var totalRowCount = $("#bulk_price_table_body tr").length;
        var new_id = totalRowCount + 1;
        var last_max = $('#max_bulk_'+totalRowCount).val();
        var last_price = $('#bulk_price_'+totalRowCount).val();
        var production_days = $('#production_days_'+totalRowCount).val();
        var discount = $('#discount_'+totalRowCount).val();
        if(last_max == '' || last_max==null){
            $('.max_bulkerror').html('Please enter maximum quantity range');
            return false;
        }else{
            $('.max_bulkerror').html('');
        }
        if(last_price == '' || last_price==null){
            $('.bulk_priceerror').html('Please enter price range');
            return false;
        }else{
            $('.bulk_priceerror').html('');
        }
        if(production_days == '' || production_days==null){
            $('.production_dayserror').html('Please enter production days');
            return false;
        }else{
            $('.production_dayserror').html('');
        }
        var new_min = parseInt(last_max) + 1;
        var table_new_row = '<tr class="table_rows" id="table_row_'+new_id+'"><td><div class=""><div class="form-group"><input type="text" placeholder="" class="form-control" id="min_bulk_'+new_id+'" name="min_bulk[]" data-error=".min_bulkerror" value="'+new_min+'" required readonly></div></div></td><td><div class=""><div class="form-group"><input type="text" placeholder="" class="form-control" id="max_bulk_'+new_id+'" name="max_bulk[]" data-error=".max_bulkerror" required></div></div></td><td><div class=""><div class="form-group"><input type="text" placeholder="" class="form-control" id="bulk_price_'+new_id+'" name="bulk_price[]" data-error=".bulk_priceerror" required></div></div></td><td><div class=""><div class="form-group"><input type="text" placeholder="" class="form-control validate_integer" id="discount_'+new_id+'" name="discount[]" data-error=".discounterror" required></div></div></td><td><div class=""><div class="form-group"><input type="text" placeholder="" class="form-control validate_integer" id="production_days_'+new_id+'" name="production_days[]" data-error=".production_dayserror" required></div></div></td><td></td></tr>';
        $('#bulk_price_table_body').append(table_new_row);
        $('#min_bulk_1').attr('readonly', true);
        $('#max_bulk_'+totalRowCount).attr('readonly', true);
        // $('#production_days_'+totalRowCount).attr('readonly', true);
    });

    $('#remove_bulk_price_row').click(function(){
        var totalRowCount = $("#bulk_price_table_body tr").length;
        if(totalRowCount > 1){
            var remove_element = "table_row_"+totalRowCount;
            $("#"+remove_element).remove();
            $('#max_bulk_'+(totalRowCount-1)).attr('readonly', false);
        }
    });


var product_mrp_price = 0;
$(document).on("change", "#mrp_price" , function() {
    product_mrp_price = $(this).val();
    console.log(product_mrp_price);
    $(".product_discount").val(0);
    $(".product_bulk_price").val(product_mrp_price);
});
$(document).on("keyup", ".product_discount" , function() {
    var thisId = $(this).attr("id");
    var thisVal = $(this).val();
    var thisId = thisId.split("_")[1];
    console.log(thisId);
    var product_mrp_price_new = $("#mrp_price").val();
    product_mrp_price_new = product_mrp_price_new - (product_mrp_price_new*thisVal)/100;
    $("#bulk_price_"+thisId).val(product_mrp_price_new);
});

    $("#formId").validate({
        rules: {
            name: {
                required: true,
            },
            product_code: {
                required: true,
            },
            brand_id :{
                required: true,  
            },
            mrp_price :{
                required: true,
                number: true,
            },
            selling_price :{
                required: true,
                number: true,
            },
            product_intro :{
                required: true,  
            },
            category_id: {
                required: true,
            },
            subcategory_id: {
                required: true,
            },
            description: {
                required: true,
            },
            specification: {
                required: true,
            },
            shipping: {
                required: true,
            },
            product_gst: {
                digits: true,
            },
            sku: {
                required: true,
            },
            status: {
                required: true,
            },
            availability: {
                required: true,
            },
            'thumbnail[]':{
                required : true,
            },
            hover_thumbnail:{
                required : true,
            },
        },
        messages: {
            name: {
                required: 'Please enter product name',
            },
            product_code: {
                required: 'Please enter product code',
            },
            brand_id :{
                required: "Please select brand",  
            },
            mrp_price :{
                required: "Please enter MRP price",  
            },
            selling_price :{
                required: "Please enter selling price",  
            },
            product_intro :{
                required: "Please enter product intro",  
            },
            'category_id[]': {
                required: "Please select product category",
            },
            'subcategory_id[]': {
                required: "Please select product subcategory",
            },
            description: {
                required: "Please enter product description",
            },
            specification: {
                required: "Please enter product specification",
            },
            shipping: {
                required: "Please enter product shipping",
            },
            sku: {
                required: "Please enter SKU",
            },
            status:{
                required: "Please select status",
            },
            availability:{
                required: "Please select availability",
            },
            'thumbnail[]':{
                required : "Please add atleast one image",
            },  
            hover_thumbnail:{
                required : "Please add hover thumbnail image",
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
        invalidHandler: function(e, validator){
            if(validator.errorList.length)
            {
                $('#nav_tabs a[href="#' + $(validator.errorList[0].element).closest(".tab-pane").attr('id') + '"]').tab('show');
            }
        },
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

            function unique_product_name() {
                var check_result = false;
                var name            = $('#name').val();
                var user_id         = $('#id').val();
                var csrf_token      = '<?php echo $this->security->get_csrf_hash(); ?>';

                $.ajax({
                    type: "POST",
                    url: base_url+'<?php echo Product_constants::check_unique_product_name; ?>',
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

            function unique_product_code() {
                var check_result = false;
                var product_code    = $('#product_code').val();
                var user_id         = $('#id').val();
                var csrf_token      = '<?php echo $this->security->get_csrf_hash(); ?>';

                $.ajax({
                    type: "POST",
                    url: base_url+'<?php echo Product_constants::check_unique_product_code; ?>',
                    async: false,
                    data: {product_code : product_code, id : user_id, '<?php echo $this->security->get_csrf_token_name(); ?>' : csrf_token},
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

            var is_gift_product = $('#offerable_product').is(":checked");
            var min_offer_amount = $('#min_offer_amount').val();
            
            if((is_gift_product === true) && (min_offer_amount == "" || min_offer_amount <= 0 )){
                hideLoader();
                $('.min_offer_amounterror').html('<div id="name-error" class="error" style="">Please enter min gift amount</div>');
            }else{
                $('.min_offer_amounterror').html();
                var check_name = unique_product_name();
                if(check_name)
                {
                    $('.nameerror').html('');
                    var check_product_code = unique_product_code();
                    if(check_product_code)
                    {
                        $('.product_codeerror').html('');
                        showLoader();
                        form.submit();
                    }
                    else{
                        hideLoader();
                        $('.product_codeerror').html('<div id="name-error" class="error" style="">Product code already exist</div>');
                    }
                }
                else
                {
                    hideLoader();
                    $('.nameerror').html('<div id="name-error" class="error" style="">Name already exist</div>');
                }
            }
        }
    }); 
</script>