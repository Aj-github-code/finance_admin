<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
        <div class="card overflow-hidden project-card">
            <a href="<?php echo base_url(franchise_constants::franchise_url); ?>">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="my-auto">
                            <i class="la la-bar-chart" style="margin: 0 10px 0 -10px;opacity: 1;color: #000 !important;"></i>
                        </div>
                        <div class="project-content">
                            <h6 style="color: #000;">Franchise</h6>
                            <ul>
                                <li>
                                    <b class="tx-success">Active</b>
                                    <span style="color: #0ba360 !important;"><?php echo $franchise['active']; ?></span>
                                </li>

                                <li>
                                    <b class="tx-danger">In-Active</b>
                                    <span style="color: #f53c5b !important;"><?php echo $franchise['inactive']; ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
        <div class="card overflow-hidden project-card">
            <a href="<?php echo base_url(franchise_products_constants::franchise_products_url); ?>">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="my-auto">
                            <i class="fas fa-dolly-flatbed" style="margin: 0 10px 0 -10px;opacity: 1;color: #000 !important;font-size: 50px;"></i>
                        </div>
                        <div class="project-content">
                            <h6 style="color: #000;">Products</h6>
                            <ul>
                                <li>
                                    <b class="tx-success">Active</b>
                                    <span style="color: #0ba360 !important;"><?php echo $products['active']; ?></span>
                                </li>

                                <li>
                                    <b class="tx-danger">In-Active</b>
                                    <span style="color: #f53c5b !important;"><?php echo $products['inactive']; ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
        <div class="card overflow-hidden project-card">
            <a href="<?php echo base_url(orders_constants::orders_url); ?>">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="my-auto">
                            <i class="fe fe-shopping-cart" style="margin: 0 10px 0 -10px;opacity: 1;color: #000 !important;font-size: 55px;"></i>
                        </div>
                        <div class="project-content">
                            <h6 style="color: #000;">Orders</h6>
                            <ul>
                                <li>
                                    <b class="tx-success">Completed</b>
                                    <span style="color: #0ba360 !important;"><?php echo $orders['completed']; ?></span>
                                </li>

                                <li>
                                    <b class="tx-danger">Pending</b>
                                    <span style="color: #f53c5b !important;"><?php echo $orders['pending']; ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
        <div class="card overflow-hidden project-card">
            <a href="<?php echo base_url(announcements_constants::announcements_url); ?>">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="my-auto">
                            <i class="fa fa-bullhorn" style="margin: 0 10px 0 -10px;opacity: 1;color: #000 !important;font-size: 55px;"></i>
                        </div>
                        <div class="project-content">
                            <h6 style="color: #000;">Announcements</h6>
                            <ul>
                                <li>
                                    <b class="tx-success">Active</b>
                                    <span style="color: #0ba360 !important;"><?php echo $announcements['active']; ?></span>
                                </li>

                                <li>
                                    <b class="tx-danger">In-Active</b>
                                    <span style="color: #f53c5b !important;"><?php echo $announcements['inactive']; ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
        <div class="card overflow-hidden project-card">
            <a href="<?php echo base_url(news_constants::news_url); ?>">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="my-auto">
                            <i class="fa fa-bullhorn" style="margin: 0 10px 0 -10px;opacity: 1;color: #000 !important;font-size: 55px;"></i>
                        </div>
                        <div class="project-content">
                            <h6 style="color: #000;">News</h6>
                            <ul>
                                <li>
                                    <b class="tx-success">Active</b>
                                    <span style="color: #0ba360 !important;"><?php echo $news['active']; ?></span>
                                </li>

                                <li>
                                    <b class="tx-danger">In-Active</b>
                                    <span style="color: #f53c5b !important;"><?php echo $news['inactive']; ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="card-header pt-4 pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-10 ">Sale Statistics</h4>
                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
            </div>
            <div class="pl-4 pr-4 pt-4 pb-3">
                <div class="">
                    <div class="row">
                        <div class="col-md-6 col-6 text-center">
                            <div class="task-box primary mb-0">
                                <p class="mb-0 tx-12">Total Orders</p>
                                <h3 class="mb-0"><?php echo $orders['completed']; ?></h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-6 text-center">
                            <div class="task-box danger mb-0">
                                <p class="mb-0 tx-12">Total Revenue</p>
                                <h3 class="mb-0">₹ <?php echo handle_number_format($order_summary['final_d_p']); ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="task-stat pb-0">
                <div class="d-flex tasks">
                    <div class="mb-0">
                        <div class="h6 fs-15 mb-0"><i class="far fa-dot-circle text-primary mr-2"></i>Total Quantity</div>
                    </div>
                    <span class="float-right ml-auto"><?php echo $order_summary['total_quantity']; ?></span>
                </div>
                <div class="d-flex tasks">
                    <div class="mb-0">
                        <div class="h6 fs-15 mb-0"><i class="far fa-dot-circle text-primary mr-2"></i>Total D.P.</div>
                    </div>
                    <span class="float-right ml-auto">₹ <?php echo handle_number_format($order_summary['total_d_p']); ?></span>
                </div>
                <div class="d-flex tasks">
                    <div class="mb-0">
                        <div class="h6 fs-15 mb-0"><i class="far fa-dot-circle text-primary mr-2"></i>Total B.V.</div>
                    </div>
                    <span class="float-right ml-auto">₹ <?php echo handle_number_format($order_summary['total_b_v']); ?></span>
                </div>
                <div class="d-flex tasks">
                    <div class="mb-0">
                        <div class="h6 fs-15 mb-0"><i class="far fa-dot-circle text-primary mr-2"></i>Total GST</div>
                    </div>
                    <span class="float-right ml-auto">₹ <?php echo handle_number_format($order_summary['total_gst']); ?></span>
                </div>
                <div class="d-flex tasks mb-0 border-bottom-0">
                    <div class="mb-0">
                        <div class="h6 fs-15 mb-0"><i class="far fa-dot-circle text-primary mr-2"></i>Total Service Charge</div>
                    </div>
                    <span class="float-right ml-auto">₹ <?php echo handle_number_format($order_summary['service_charge']); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>