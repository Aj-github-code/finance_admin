<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="modal" id="batch-upload-modal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content modal-content-demo">
            <form id="uploadFormId" method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                <input type="hidden" id="org_id" name="org_id" value="">

                <div class="modal-header">
                    <h6 class="modal-title">Batch Upload Coupons</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="file" name="file" id="file" data-error=".fileerror" style="width: 100%;">
                            <div class="fileerror error_msg"></div>
                        </div>
                        <div class="col-md-12 m-t-5">
                            <a href="<?php echo assets_url('data/Sample_coupon_File.xlsx'); ?>"><u>Download Sample File</u></a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button class="btn btn-main-primary" type="submit">Upload</button>
                    <button class="btn btn-secondary custom-btn-secondary" type="button" data-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    function upload_points(sel) {
        $('#batch-upload-modal').modal('show');
        $('#org_id').val($('#organization_id').val());
    }

    $("#batch-upload-modal").on("hide.bs.modal", function(e) {
        $('#uploadFormId').validate().resetForm();
        $("#file").val(null);
    });

    function get_coupon_data(coupon_data_json) {
        var html = `
                        <div class="table-responsive">
                            <table class="table table-bordered mg-b-1 text-md-nowrap">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Coupon Name</th>
                                        <th>Coupon Code</th>
                                        <th>Discount in percent</th>
                                        <th>Discount Amount</th>
                                        <th>Discount Type</th>
                                        <th>Minimum purchase amount of cart</th>
                                        <th>Status</th>
                                        <th>Coupon Valid From</th>
                                        <th>Coupon Valid To</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;

        if(coupon_data_json.length > 0)
        {
            var rows = ``;
            for (var i = 0; i < coupon_data_json.length; i++) {
                var status = `<span class="badge badge-success">Success</span>`;
                if(coupon_data_json[i]['status'] == 'Error')
                {
                    status = `<span class="badge badge-danger">Error</span>`;
                }

                rows += `
                            <tr>
                                <input type="hidden" class="error_coupon" name="error_coupon[`+i+`]" value="`+coupon_data_json[i]['status']+`">

                                <td class="align-middle">`+coupon_data_json[i]['sr_no']+`</td>
                               
                                <td class="align-middle">
                                    <input type="text" class="form-control validate_integer wd-100 coupon_name" name="coupon_name[`+i+`]" value="`+coupon_data_json[i]['coupon_name']+`" readonly>
                                </td>
                                <td class="align-middle">
                                    <input type="text" class="form-control wd-100 coupon_code" name="coupon_code[`+i+`]" value="`+coupon_data_json[i]['coupon_code']+`" readonly>
                                </td>
                                <td class="align-middle">
                                    <input type="text" class="form-control wd-100 discount_in_percent" name="discount_in_percent[`+i+`]" value="`+coupon_data_json[i]['discount_in_percent']+`" readonly>
                                </td>
                                <td class="align-middle">
                                    <input type="text" class="form-control wd-100 discount_amount" name="discount_amount[`+i+`]" value="`+coupon_data_json[i]['discount_amount']+`" readonly>
                                    
                                </td>
                                <td class="align-middle">
                                    <input type="text" class="form-control wd-100 discount_type" name="discount_type[`+i+`]" value="`+coupon_data_json[i]['discount_type']+`" readonly>
                                    
                                </td>
                                <td class="align-middle">
                                    <input type="text" class="form-control wd-100 minimum_purchase_amount" name="minimum_purchase_amount[`+i+`]" value="`+coupon_data_json[i]['minimum_purchase_amount']+`" readonly>
                                    
                                </td>
                                <td class="align-middle">`+status+`</td>
                                <td class="align-middle">
                                    <input type="text" class="form-control wd-100 coupon_valid_from" name="coupon_valid_from[`+i+`]" value="`+coupon_data_json[i]['coupon_valid_from']+`" readonly>
                                </td>
                                <td class="align-middle">
                                    <input type="text" class="form-control wd-100 coupon_valid_to" name="coupon_valid_to[`+i+`]" value="`+coupon_data_json[i]['coupon_valid_to']+`" readonly>
                                    
                                </td>
                                
                                
                            </tr>
                        `; 
            }
            html += rows;
        }
        else
        {
            html += `
                        <tr>
                            <td>No Data</td>
                        </tr>
                    `;
            $('#bulkFormSubmitBtn').addClass('d-none');
        }
        html += `
                        </tbody>
                    </table>
                `;
                console.log(html);
        $('#load_coupon_data').html(html);
    }

    $("#uploadFormId").validate({
        rules: {
            file: {
                required: true,
                extension: "xls|xlsx"
            },
        },
        messages: {
            file:{
                required: "Please select file",
                digits: "Only xls|xlsx files are allowed",
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

            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                dataType: "json",
                url : base_url+'<?php echo product_constants::load_bulk_coupon_url; ?>',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    showLoader();
                },
                success: function(response) {
                    hideLoader();

                    if(response.error == 0)
                    {
                        load_status_popup("success", response.message);
                        $('#batch-upload-modal').modal('hide');
                        $('#coupon-data-modal').modal('show');
                        get_coupon_data(response.coupons_data);
                        console.log(response.coupons_data);
                    }
                    else if(response.error == 2)
                    {
                        $('.fileerror').html(response.message);
                    }
                    else
                    {
                        load_status_popup("error", response.message);
                    }
                }
            });
        }
    });
</script>