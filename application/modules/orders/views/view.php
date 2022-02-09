<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
    $orderstatus            = '';
    $orderstatusclass       = '';
    $order_status           = $order['order_status'];
    if($order_status == 'pending')
    {
        $orderstatus        = 'Pending';
        $orderstatusclass   = 'info';
    }
    else if($order_status == 'approved')
    {
        $orderstatus        = 'Approved';
        $orderstatusclass   = 'success';
    }
    else if($order_status == 'rejected')
    {
        $orderstatus        = 'Rejected';
        $orderstatusclass   = 'danger';
    }
    else if($order_status == 'delivered')
    {
        $orderstatus        = 'Delivered';
        $orderstatusclass   = 'success';
    }

    $order_errors = $this->session->flashdata('order_errors');
?>
<div class="row">
    <div class="col-md-12">
        <?php if(!empty($order_errors)){ ?>
            <div class="card">
                <div class="card-header bd-b">
                    <h6 class="card-title text-danger mb-0">Order Error</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mg-b-1 text-md-nowrap bg-danger">
                            <thead>
                                <tr>
                                    <th class="text-left tx-black">Product</th>
                                    <th class="text-right tx-black">Available Stock</th>
                                    <th class="text-right tx-black">Order Quantity</th>
                                    <th class="text-left tx-black">Error</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($order_errors as $key => $value) {
                                ?>
                                        <tr>
                                            <th class="text-left"><?php echo $value['product_name']; ?></th>
                                            <td class="text-right"><?php echo $value['product_stock']; ?></td>
                                            <td class="text-right"><?php echo $value['order_quantity']; ?></td>
                                            <th class="text-left"><?php echo $value['error']; ?></th>
                                        </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div class="card custom-card" id="additional-alerts">
            <div class="card-header bd-b">
                <h6 class="card-title mb-0">Order Status</h6>
            </div>
            <div class="card-body">
                <div class="text-wrap">
                    <div class="example p-0" style="border: none;">
                        <div class="alert alert-<?php echo $orderstatusclass; ?> mb-0" role="alert">
                            <h4 class="alert-heading"><?php echo $orderstatus; ?>!</h4>
                            <?php if(!empty($order['message'])){ ?>
                                <hr>
                                <p class="mb-0"><?php echo $order['message']; ?></p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="product-details table-responsive text-nowrap">
                    <table class="table table-bordered table-hover mb-0 text-nowrap">
                        <thead>
                            <tr>
                                <th class="text-left w-100">Product</th>
                                <th class="w-150">Quantity</th>
                                <th class="text-right">Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(isset($order_products) && !empty($order_products))
                                {
                                    foreach ($order_products as $key => $value) {
                                        $product_id         = $value['product_id'];
                                        $product_name       = $value['name'];
                                        $product_quantity   = $value['quantity'];
                                        $product_amount     = handle_number_format($value['amount']);
                                        $product_total      = handle_number_format($value['total_amount']);
                                        $product_d_p        = handle_number_format($value['d_p']);
                                        $product_total_d_p  = handle_number_format($value['total_d_p']);
                                        $image              = assets_url('img/ecommerce/01.jpg');
                                        if(!empty($value['thumbnail']))
                                        {
                                            $image          = base_url().'public/content/'.$value['thumbnail'];
                                        }
                            ?>
                                        <tr>
                                            <td class="text-left">
                                                <div class="media">
                                                    <div class="card-aside-img">
                                                        <img src="<?php echo $image; ?>" alt="<?php echo $product_name; ?>" class="h-60 w-60">
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="card-item-desc mt-0">
                                                            <h6 class="font-weight-semibold mt-0 text-uppercase"><?php echo $product_name; ?></h6>
                                                            <dl class="card-item-desc-1">
                                                              <dt>D. P.: </dt>
                                                              <dd>₹<?php echo $product_d_p; ?></dd>
                                                            </dl>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group text-right">
                                                    <?php echo $product_quantity; ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-right">₹<?php echo $product_total_d_p; ?></td>
                                        </tr>
                            <?php
                                    }
                                }
                                else
                                {
                            ?>
                                    <tr>
                                        <td colspan="4" class="text-center">No product found!</td>
                                    </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-6">
        <div class="card">
            <div class="card-header bd-b">
                <h3 class="card-title mb-0">Address</h3>
            </div>
            <div class="card-body">
                <p><?php echo (isset($order['address']) ? $order['address'] : ''); ?></p>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bd-b">
                <div class="card-title mb-0">Order Summery</div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>Order Quantity</td>
                                <td class="text-right"><?php echo $order['total_quantity']; ?></td>
                            </tr>
                            <tr>
                                <td><span>Order Subtotal</span></td>
                                <td class="text-right text-muted"><span>₹<?php echo handle_number_format($order['total_d_p']); ?></span></td>
                            </tr>
                            <tr>
                                <td><span>GST Type</span></td>
                                <td class="text-right text-muted">
                                    <span>
                                        <?php
                                            if(isset($order['gst_type']) && !empty($order['gst_type']))
                                            {
                                                if($order['gst_type'] == 'cgst_sgst')
                                                {
                                                    echo 'CGST+SGST';
                                                }
                                                else
                                                {
                                                    echo 'IGST';
                                                }
                                            }
                                            else
                                            {
                                                echo 'NA';
                                            }
                                        ?>
                                    </span>
                                </td>
                            </tr>
                            <?php
                                if($order['gst_type'] == 'cgst_sgst')
                                {
                                    $cgst       = '0.00';
                                    $sgst       = '0.00';
                                    
                                    if(isset($order['gst_type']) && !empty($order['gst_type']))
                                    {
                                        $cgst   = $order['total_cgst'];
                                        $sgst   = $order['total_sgst'];
                                    }
                            ?>
                                    <tr>
                                        <td><span>CGST</span></td>
                                        <td class="text-right text-muted"><span>₹<?php echo handle_number_format($cgst); ?></span></td>
                                    </tr>
                                    <tr>
                                        <td><span>SGST</span></td>
                                        <td class="text-right text-muted"><span>₹<?php echo handle_number_format($sgst); ?></span></td>
                                    </tr>
                            <?php
                                }
                                else if($order['gst_type'] == 'igst')
                                {
                                    $igst       = $order['total_igst'];
                            ?>
                                    <tr>
                                        <td><span>IGST</span></td>
                                        <td class="text-right text-muted"><span>₹<?php echo handle_number_format($igst); ?></span></td>
                                    </tr>
                            <?php
                                }
                                else
                                {
                                    $gst        = $order['total_gst'];
                            ?>
                                    <tr>
                                        <td><span>GST</span></td>
                                        <td class="text-right text-muted"><span>₹<?php echo handle_number_format($gst); ?></span></td>
                                    </tr>
                            <?php
                                }
                            ?>
                            <tr>
                                <td><span>Service Charge</span></td>
                                <td class="text-right text-muted"><span>₹<?php echo handle_number_format($order['service_charge']); ?></span></td>
                            </tr>
                            <tr>
                                <td><span>Order Total</span></td>
                                <td><h2 class="price text-right mb-0">₹<?php echo handle_number_format($order['final_d_p']); ?></h2></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if($order_status == 'pending' || $order_status == 'approved'){ ?>
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-success mt-2 mb-4 w-100" type="button" value="Process Order" style="font-size: 20px;font-weight: 700;" onclick="process_order();">Process Order</button>
        </div>
    </div>
<?php } ?>

<div class="modal" id="order-process-modal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content modal-content-demo">
            <form id="order-form-id" method="POST" action="<?php echo base_url(orders_constants::process_order_url); ?>">
                <input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                <input type="hidden" name="order_id" id="order_id" value="<?php echo $order['id']; ?>">
                <input type="hidden" name="order_number" id="order_number" value="<?php echo $order['order_number']; ?>">

                <div class="modal-header">
                    <h6 class="modal-title">Process Order</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Order Status <span class="asterisk">*</span></label>
                                <div class="order_status_wrap"></div>
                                <div class="orderstatuserror error_msg"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">GST Type <span class="asterisk">*</span></label>
                                <div class="order_gst_type_wrap"></div>
                                <div class="ordergsttypeerror error_msg"></div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="row">
                        <div class="col-md-12">
                            <div class="form-group m-b-5">
                                <label class="form-label">GST (%)</label>
                                <input type="text" class="form-control" id="gst_rate" name="gst_rate" value="<?php //echo $order['gst_rate']; ?>">
                            </div>
                        </div>
                    </div> -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Service Charge</label>
                                <input type="text" class="form-control" id="service_charge" name="service_charge" value="<?php echo $order['service_charge']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group m-b-5">
                                <label class="form-label">Message</label>
                                <textarea class="form-control" id="message" name="message" rows="2" data-error=".messageerror"><?php echo $order['message']; ?></textarea>
                                <div class="messageerror error_msg"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button class="btn btn-main-primary" type="submit">Submit</button>
                    <button class="btn btn-secondary custom-btn-secondary" type="button" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    var order_status = '<?php echo $order_status; ?>';
    var order_gst_type = '<?php echo $order['gst_type']; ?>';
    var orderstatusoptions = '';
    if(order_status == 'pending')
    {
        order_status = '';
        var orderstatusoptions = '<option value="approved">Approve</option><option value="rejected">Reject</option>';
    }
    else if(order_status == 'approved')
    {
        order_status = 'delivered';
        var orderstatusoptions = '<option value="delivered">Deliver</option>';
    }

    function process_order() {
        $('#order-process-modal').modal('show');
        $('.order_status_wrap').html('<select class="select2" name="order_status" id="order_status" style="width: 100%;" data-error=".orderstatuserror"><option value="">-- Select Status --</option>'+orderstatusoptions+'</select>');
        $('#order_status').select2({
            dropdownParent: $("#order-process-modal"),
        });
        $("#order_status").val(order_status).trigger('change');

        $('.order_gst_type_wrap').html('<select class="select2" name="order_gst_type" id="order_gst_type" style="width: 100%;" data-error=".ordergsttypeerror"><option value="">-- Select GST Type --</option><option value="cgst_sgst">CGST+SGST</option><option value="igst">IGST</option></select>');
        $('#order_gst_type').select2({
            dropdownParent: $("#order-process-modal"),
        });
        $("#order_gst_type").val(order_gst_type).trigger('change');
    }

    $("#order-form-id").validate({
        rules: {
            order_status: {
                required: true,
            },
            order_gst_type: {
                required: true,
            },
            // gst_rate: {
            //     number: true,
            // },
            service_charge: {
                number: true,
            },
        },
        messages: {
            order_status: {
                required: 'Please select status',
            },
            order_gst_type: {
                required: 'Please select gst type',
            },
            gst_rate: {
                number: 'Please enter valid gst',
            },
            service_charge: {
                number: 'Please enter valid service charge',
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