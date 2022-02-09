<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="card">
    <div class="card-header bd-b">
        <div class="row">
            <div class="col-md-10"><h5 class="card-title m-t-8 mb-0"><?php echo $page_title; ?></h5></div>
            <div class="col-md-2"><button type="button" class="btn btn-main-primary small-button float-right" onclick="upload_points(this);">Upload Points</button></div>
        </div>
    </div>
    <div class="card-body">
        <div id="dataTableWrap">
            <div class="table-responsive">
                <table id="dataTableId"></table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function loadTable() {
        setTimeout(function(){
            initTable();
            hideLoader();
        }, 500);
    }

    function filterTable() {
        showLoader();
        $('#dataTableWrap').html('<div class="table-responsive"><table id="dataTableId"></table></div>');
        loadTable();
    }

    function initTable() {
        $('#dataTableId').bootstrapTable({
            url: base_url+'<?php echo product_constants::get_bulk_batch_coupon_url; ?>',
            method: 'GET',                
            queryParams: function (params) {
                q = {
                    limit           : params.limit,
                    offset          : params.offset,
                    search          : params.search,
                    sort            : (params.sort ? params.sort : ''),
                    order           : (params.order ? params.order : ''),
                    custom_search   : {
                                        organization_id         : $('#organization_id').val(),
                                      }
                }
                return q;
            },
            cache: false,
            height: 580,
            striped: true,
            toolbar: true,
            search: true,
            showRefresh: true,
            showToggle: true,
            showColumns: true,
            detailView: false,
            exportOptions: { ignoreColumn: ['action'], fileName: 'Batch Redeem Points' },
            showExport: true,
            exportDataType: 'all',
            minimumCountColumns: 2,
            showPaginationSwitch: true,
            pagination: true,
            sidePagination: 'server',
            idField: 'id',
            pageSize: 10,
            pageList: [10, 25, 50, 100, 200],
            showFooter: false,
            clickToSelect: false,
            columns: [
                [
                    {
                        field: 'sr_no',
                        title: 'Sr No.',
                        align: 'center',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'batch_id',
                        title: 'Batch Id',
                        align: 'left',
                        valign: 'middle',
                        sortable: true,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'total_coupon',
                        title: 'Total Coupon',
                        align: 'left',
                        valign: 'middle',
                        sortable: true,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'total_amount',
                        title: 'Total amount',
                        align: 'left',
                        valign: 'middle',
                        sortable: true,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'action',
                        title: 'Action',
                        align: 'center',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    }
                ]
            ]
        });
    }

    filterTable();
</script>