<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('table'); ?>
<!--  -->
<input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

<script type="text/javascript">
    $('#status').select2();
    $(".pickadate").pickadate({
        // selectYears: 20
    });

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
        role_select_box(role_url, '', '', 'multiple');
        status_select_box();
        $('#dataTableWrap').html('<div class="table-responsive"><table id="dataTableId"></table></div>');
        loadTable();
    }

    function initTable() {
        $('#dataTableId').bootstrapTable({
            url: base_url+'<?php echo directs_constants::directs_list_url; ?>',
            method: 'GET',                
            queryParams: function (params) {
                q = {
                    limit           : params.limit,
                    offset          : params.offset,
                    search          : params.search,
                    sort            : (params.sort ? params.sort : ''),
                    order           : (params.order ? params.order : ''),
                    custom_search   : {
                                        from_date               : $('#fromdateVal').val(),
                                        to_date                 : $('#todateVal').val(),
                                        status                  : $('#status').val(),
                                      }
                }
                return q;
            },
            cache: false,
            // height: 580,
            striped: true,
            toolbar: true,
            search: true,
            showRefresh: true,
            showToggle: true,
            showColumns: true,
            detailView: false,
            exportOptions: { ignoreColumn: ['action'], fileName: 'Directs' },
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
                        title: 'sr_no',
                        align: 'center',
                        valign: 'middle',
                        sortable: true,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'name',
                        title: 'Name',
                        align: 'left',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'ownid',
                        title: 'ownid',
                        align: 'left',
                        valign: 'middle',
                        sortable: true,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 't_left',
                        title: 'Total left member',
                        align: 'left',
                        valign: 'middle',
                        sortable: true,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 't_right',
                        title: 'Total Right member',
                        align: 'left',
                        valign: 'middle',
                        sortable: true,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 't_unit_left',
                        title: 'Total unit left',
                        align: 'left',
                        valign: 'middle',
                        sortable: true,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 't_unit_right',
                        title: 'Total unit right',
                        align: 'center',
                        valign: 'middle',
                        sortable: true,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'total',
                        title: 'Total Units',
                        align: 'center',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    },

                    {
                        field: 'avl_right',
                        title: 'Available Right',
                        align: 'center',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'avl_left',
                        title: 'Available Left',
                        align: 'center',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 't_used_left',
                        title: 'Total unit used left',
                        align: 'center',
                        valign: 'middle',
                        sortable: true,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 't_used_right',
                        title: 'Total unit used right',
                        align: 'center',
                        valign: 'middle',
                        sortable: true,
                        editable: false,
                        footerFormatter: false,
                    }
                ]
            ]
        });
    }

    initTable();
</script>