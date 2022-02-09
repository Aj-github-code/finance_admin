<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header bd-b">
                <h5 class="card-title mb-0">Filters</h5>
            </div>
            <div class="card-body">
                <form class="" action="">
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
                                     <input type='text' class="form-control bg-white" id="ownid" name="ownid" value="<?php echo set_value('ownid', (isset($ownid) ? $ownid : 'ROOT')); ?>"    placeholder="" />
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mt-4">
                            <button type="button" class="btn btn-main-primary mr-1" onclick="filterTable();">Filter</button>
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
                <div id="dataTableWrap">
                    <div class="table-responsive">
                        <table id="dataTableId"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>