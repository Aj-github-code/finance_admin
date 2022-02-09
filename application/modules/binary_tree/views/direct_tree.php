<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row">
<div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header bd-b">
                <h5 class="card-title mb-0">Filters</h5>
            </div>
            <div class="card-body">
                <form class="<?php echo base_url(binary_constants::binary_tree_url)?>" action="">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">Search By User ID :</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="far fa-user"></i>
                                        </div>
                                    </div>
                                     <input type='text' class="form-control bg-white" id="ownid" name="ownid" value="<?php echo set_value('ownid', (isset($ownid) ? $ownid : '')); ?>"    placeholder="" />
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mt-4">
                            <button type="submit" class="btn btn-main-primary mr-1" >Filter</button>
                            <button type="button" class="btn btn-secondary custom-btn-secondary" onclick="clearTable();">Clear</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header bd-b">
                <h5 class="card-title mb-0"><?php echo $page_title; ?></h5>
            </div>
            <div class="card-body">
                <form id="formId" class="" method="GET" action="<?php echo base_url(binary_constants::binary_tree_list_url); ?>" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="csrf">
                    <input type="hidden" id="id" name="id" value="<?php echo (isset($post_data['id']) ? $post_data['id'] : ''); ?>">

                    
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-around">
                            <div class="form-group">
                                <?php $userid = (isset($d_user['ownid']) ? $d_user['ownid'] : '');$img = color_type($d_user['pin']);?>
                                <?php if(empty($userid)){?>
                                    <a class="tree"  href="<?php echo base_url(genealogy_constants::left_member_url);?>"'>
                                        <img src='<?php echo assets_url('img/tree/addnew2.png');?>' /><br />
                                        <span>Add New User</span>
                                    </a>
                                <?php } else{?>
                                    <a class="tree"  href="<?php echo base_url(binary_constants::direct_tree_url).'?userid='.$userid;?>" data-toggle="tooltip" title="Hooray!" id='<?php echo $d_details[$userid]; ?>' onmouseover='getTip1(this)'>
                                        <img src='<?php echo assets_url('img/tree/'.$img.' ');?>' /><br/>
                                        <span><?php echo strtoupper($userid);?></span>
                                    </a>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                
                            <?php if(count($d_lists)>0){foreach($d_lists as $value){?>
                                <div style="height: 150px;" class="col-md-3 d-flex justify-content-around">
                                        <?php $img = color_type($d_type[$value['ownid']]);?>
                                            <?php if(empty($value['ownid'])){?>
                                                <a class="tree"  href="<?php echo base_url(genealogy_constants::left_member_url);?>"'>
                                                    <img src='<?php echo assets_url('img/tree/addnew2.png');?>' /><br />
                                                    <span>Add New User</span>
                                                </a>
                                            <?php } else{?>
                                                <a class="tree"  href="<?php echo base_url(binary_constants::direct_tree_url).'?userid='.$value['ownid'];?>" id='<?php echo $d_details[$value['ownid']]; ?>' onmouseover='getTip4(this)'>
                                                    <img src='<?php echo assets_url('img/tree/'.$img.' ');?>' /><br />
                                                    <span > <?php echo strtoupper($value['ownid']); ?></span>
                                                </a>
                                            <?php }?>
                                    
                                </div>       
                            <?php }}?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    
    function getTip1(element) {
        $(element).tipbox(element.id, 1);
    }
    
    function getTip2(element) {
        $(element).tipbox(element.id, 1);
    }
    
    function getTip3(element) {
        $(element).tipbox(element.id, 1);
    }
    
    function getTip4(element) {
        $(element).tipbox(element.id, 1);
    }
    
    function getTip5(element) {
        $(element).tipbox(element.id, 1);
    }
    
    function getTip6(element) {
        $(element).tipbox(element.id, 1);
    }
    
    function getTip7(element) {
        $(element).tipbox(element.id, 1);
    }
    
 
  
</script>



