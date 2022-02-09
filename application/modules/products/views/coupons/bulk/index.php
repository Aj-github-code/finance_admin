<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header bd-b">
                <h5 class="card-title mb-0">Filters</h5>
            </div>
            <div class="card-body">
                <form class="" action="" id="formId">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="organization_id" class="form-label">Organization <span class="asterisk">*</span></label>
                                <div class="organization_wrap">
                                    <select class="select2" name="organization_id" id="organization_id" data-error=".organizationiderror" style="width: 100%;">
                                        <option value="">-- Select Organization --</option>
                                    </select>
                                </div>
                                <div class="organizationiderror error_msg"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-main-primary mr-1 m-t-27">Filter</button>
                            <button type="button" class="btn btn-secondary custom-btn-secondary m-t-27" onclick="clearTable();">Clear</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row"><div class="col-lg-12" id="table-wrap"></div></div>

<?php $this->load->view('form'); ?>
<?php $this->load->view('coupon_data_modal'); ?>
<?php $this->load->view('batch_details_modal'); ?>

<script type="text/javascript">
    var organization_url    = base_url+'<?php echo organization_constants::get_organization_options_url; ?>';
    console.log("hiii");
    get_organization_select_box(organization_url, '', '', '', '');

    function clearTable() {
        showLoader();
        get_organization_select_box(organization_url, '', '', '', '');
        $('#table-wrap').html('');
        hideLoader();
    }

    $("#formId").validate({
        rules: {
            organization_id: {
                required: true,
            },
        },
        messages: {
            organization_id:{
                required: "Please select organization",
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
            var organization_id = $("#organization_id option:selected").val();
            $('#table-wrap').html('');

            $.ajax({
                type: "GET",
                dataType: "html",
                url : base_url+'<?php echo product_constants::load_bulk_coupon_batch_url; ?>',
                data: {organization_id : organization_id},
                beforeSend: function() {
                    showLoader();
                },
                success: function(response) {
                    hideLoader();
                    $('#table-wrap').html(response);
                }
            });
        }
    });
</script>