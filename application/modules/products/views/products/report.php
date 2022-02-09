<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header bd-b">
                <h5 class="card-title mb-0">Filters</h5>
            </div>
            <div class="card-body">
                <form class="" action="" id="filterFormId">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="organization_id" class="form-label">Organization <span class="asterisk">*</span></label>
                                <div class="organization_wrap">
                                    <select class="select2" name="organization_id" id="organization_id" data-error=".organizationiderror" style="width: 100%;" required="">
                                        <option value="">-- Select Organization --</option>
                                    </select>
                                </div>
                                <div class="organizationiderror error_msg"></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="portal_id" class="form-label">Portal <span class="asterisk">*</span></label>
                                <div class="portal_wrap">
                                    <select class="select2" name="portal_id" id="portal_id" data-error=".organizationiderror" style="width: 100%;" required="">
                                        <option value="">-- Select portal --</option>
                                        <option value="1">Employee</option>
                                        <option value="2">Bulk</option>
                                        <option value="3">Loyalty</option>
                                    </select>
                                </div>
                                <div class="organizationiderror error_msg"></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                        </div>
                                    </div>
                                    <input type='text' class="form-control bg-white daterangepicker" id="dateFilter" name="dateFilter" placeholder="" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-main-primary mr-1">Filter</button>
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

<input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

<script type="text/javascript">
    $('#portal_id').select2();
    $(".pickadate").pickadate({
        // selectYears: 20
    });

    $('.daterangepicker').daterangepicker({
        "opens": "left",
        // "autoApply": false,
        "autoUpdateInput": false,
        "placeholder":'Select a range',
        ranges: {
            'Till Today': [moment('1984-01-01'), moment()],
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract('days', 1)],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'Last Year': [moment().subtract(1, 'year').add(1,'day'), moment()]
        },
        locale: {
            format: 'YYYY-MM-DD',
            cancelLabel: 'Clear'
        },
        startDate: moment('1984-01-01'),
        endDate: moment()
    },
    function(start, end, label) {
        var dateRange = start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY');
        $(this).val(dateRange);
    });

    $('.daterangepicker').on('apply.daterangepicker', function(ev, picker) {
          $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    });
    $('.daterangepicker').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

    var organization_url    = base_url+'<?php echo organization_constants::get_organization_options_url; ?>';
    get_organization_select_box(organization_url, '', '', '', '');

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

    function clearTable() {
        showLoader();
        clear_from_to_date();
        status_select_box();
        $('#dataTableWrap').html('<div class="table-responsive"><table id="dataTableId"></table></div>');
        loadTable();
    }

    function initTable() {
        var organization = $('#organization_id').val();
        var sale_amount_title = 'Sale Amount';
        var unit_price_title = 'Unit Price';
        if(organization == 2){
            sale_amount_title = 'Redemption Point';
            unit_price_title = 'Unit Point';
        }
        $('#dataTableId').bootstrapTable({
            url: base_url+'<?php echo product_constants::get_product_report_url; ?>',
            method: 'GET',                
            queryParams: function (params) {
                q = {
                    limit           : params.limit,
                    offset          : params.offset,
                    search          : params.search,
                    sort            : (params.sort ? params.sort : ''),
                    order           : (params.order ? params.order : ''),
                    custom_search   : {
                                        // from_date               : $('#fromdateVal').val(),
                                        // to_date                 : $('#todateVal').val(),
                                        organization_id                  : $('#organization_id').val(),
                                        portal_id                  : $('#portal_id').val(),
                                        dateFilter                  : $('#dateFilter').val(),
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
            exportOptions: { ignoreColumn: ['action'], fileName: 'Products' },
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
                        field: 'name',
                        title: 'Product Name',
                        align: 'left',
                        valign: 'middle',
                        sortable: true,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'product_code',
                        title: 'Product Code',
                        align: 'left',
                        valign: 'middle',
                        sortable: true,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'category_name',
                        title: 'Category',
                        align: 'center',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'unit_price',
                        title: unit_price_title,
                        align: 'center',
                        valign: 'middle',
                        sortable: true,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'sold',
                        title: 'Sold',
                        align: 'center',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'sale_amount',
                        title: sale_amount_title,
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

        $("#filterFormId").validate({
        rules: {
            organization_id: {
                required: true,
            },
            portal_id: {
                required: true,
            },
        },
        messages: {
            organization_id:{
                required: "Please select organization",
            },
            portal_id:{
                required: "Please select portal",
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
            filterTable();
        }
    });
    // initTable();
</script>