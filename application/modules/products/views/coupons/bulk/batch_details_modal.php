<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="modal" id="batch-details-modal">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content modal-content-demo">
            <input type="hidden" name="id" id="id" value="">

            <div class="modal-header">
                <h6 class="modal-title">Batch Details</h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row"><div class="col-md-12" id="load_batch_details"></div></div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function load_batch_details() {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url(product_constants::load_batch_details_url); ?>',
            dataType: 'HTML',
            data: {},
            success: function(data){
                $('#load_batch_details').html(data);
            }
        });
    }

    function show_details(organization_id, id, sel) {
        $('#batch-details-modal').modal('show');
        $('#id').val(id);
        $('#load_batch_details').html('');
        load_batch_details();
    }

    $("#batch-details-modal").on("hide.bs.modal", function(e) {
        $('#batchDataTableWrap').html('<div class="table-responsive"><table id="batchDataTableId"></table></div>');
    });
</script>