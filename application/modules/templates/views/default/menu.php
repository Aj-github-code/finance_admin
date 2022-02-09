<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="main-sidebar app-sidebar sidebar-scroll">
    <div class="main-sidebar-header">
        <a class="desktop-logo logo-light active" href="<?php echo base_url(); ?>" class="text-center mx-auto">
            <img src="<?php echo assets_url(); ?>img/logo/mycomlogo.png" class="main-logo">
        </a>
        <a class="desktop-logo icon-logo active"href="<?php echo base_url(); ?>">
            <img src="<?php echo assets_url(); ?>img/logo/mycomlogo.png" class="logo-icon">
        </a>
        <a class="desktop-logo logo-dark active" href="<?php echo base_url(); ?>">
            <img src="<?php echo assets_url(); ?>img/logo/mycomlogo.png" class="main-logo dark-theme" alt="logo">
        </a>
        <a class="logo-icon mobile-logo icon-dark active" href="<?php echo base_url(); ?>">
            <img src="<?php echo assets_url(); ?>img/logo/mycomlogo.png" class="logo-icon dark-theme" alt="logo">
        </a>
    </div>
    <div class="main-sidebar-loggedin">
        <div class="app-sidebar__user">
            <div class="dropdown user-pro-body text-center">
                <div class="user-pic">
                    <?php
                        $profile_pic_url = assets_url('img/faces/6.jpg');
                        if(!empty($user_data['profile_pic']))
                        {
                            $profile_pic_url = content_url('profile/'.$user_data['profile_pic']);
                        }
                    ?>
                    <img src="<?php echo $profile_pic_url; ?>" alt="<?php echo $this->session->userdata('full_name'); ?>" class="rounded-circle mCS_img_loaded">
                </div>
                <div class="user-info">
                    <h6 class=" mb-0 text-dark"><?php echo $this->session->userdata('full_name'); ?></h6>
                    <!-- <span class="text-muted app-sidebar__user-name text-sm">Super Admin</span> -->
                </div>
            </div>
        </div>
    </div><!-- /user -->
    <div class="sidebar-navs">
        <ul class="nav  nav-pills-circle">
            <li class="nav-item" data-toggle="tooltip" data-placement="top" title="" data-original-title="My Profile" aria-describedby="tooltip365540">
                <a class="nav-link text-center m-2" href="<?php echo base_url(profile_constants::profile_url); ?>">
                    <i class="far fa-user"></i>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Change Password">
                <a class="nav-link text-center m-2" href="<?php echo base_url(password_constants::password_url); ?>">
                    <i class="fas fa-unlock-alt"></i>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Sign Out">
                <a class="nav-link text-center m-2" href="<?php echo base_url(signin_constants::logout_url); ?>">
                    <i class="fe fe-power"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="main-sidebar-body">
        <ul class="side-menu ">
            <li class="slide <?php if(isset($menu) && $menu == 'dashboard'){ echo 'active'; } ?>">
                <a class="side-menu__item" href="<?php echo base_url(dashboard_constants::dashboard_url); ?>">
                    <i class="side-menu__icon fe fe-airplay"></i>
                    <span class="side-menu__label">Dashboard</span>
                </a>
            </li>

            <li class="slide <?php if(isset($menu) && $menu == 'Users'){ echo 'active-menu-expanded is-expanded'; } ?>">
                <a class="side-menu__item <?php if(isset($menu) && $menu == 'Users'){ echo 'active'; } ?>" data-toggle="slide" href="javascript:void(0);">
                <i class="side-menu__icon fe fe-user"></i>
                    <span class="side-menu__label">Users</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <li class="<?php if(isset($menu) && $menu == 'Users' && isset($submenu) && $submenu == 'users'){ echo 'active'; } ?>">
                        <a class="slide-item <?php if(isset($menu) && $menu == 'Users' && isset($submenu) && $submenu == 'users'){ echo 'active'; } ?>" href="<?php echo base_url(users_constants::users_url); ?>">Users List</a>
                    </li>
                    <li class="<?php if(isset($menu) && $menu == 'Users Free' && isset($submenu) && $submenu == 'users_free'){ echo 'active'; } ?>">
                        <a class="slide-item <?php if(isset($menu) && $menu == 'Users Free' && isset($submenu) && $submenu == 'users_free'){ echo 'active'; } ?>" href="<?php echo base_url(users_constants::users_free_url); ?>">Free Top-up</a>
                    </li>
                    <li class="<?php if(isset($menu) && $menu == 'Users Re-TopUp' && isset($submenu) && $submenu == 're_topup'){ echo 'active'; } ?>">
                        <a class="slide-item <?php if(isset($menu) && $menu == 'Users Re-TopUp' && isset($submenu) && $submenu == 're_topup'){ echo 'active'; } ?>" href="<?php echo base_url(users_constants::users_retopup_url); ?>">Re Top-up</a>
                    </li>
                </ul>
            </li>
            <li class="slide <?php if(isset($menu) && $menu == 'directs'){ echo 'active'; } ?>">
                <a class="side-menu__item" href="<?php echo base_url(directs_constants::directs_url); ?>">
                    <i class="side-menu__icon fe fe-shopping-cart"></i>
                    <span class="side-menu__label">Directs</span>
                </a>
            </li>
            <li class="slide <?php if(isset($menu) && $menu == 'genealogy list'){ echo 'active-menu-expanded is-expanded'; } ?>">
                <a class="side-menu__item <?php if(isset($menu) && $menu == 'genealogy list'){ echo 'active'; } ?>" data-toggle="slide" href="javascript:void(0);">
                    <i class="side-menu__icon icon fa fa-users"></i>
                    <span class="side-menu__label">Genealogy</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <li class="<?php if(isset($menu) && $menu == 'left member list' && isset($submenu) && $submenu == 'l_list'){ echo 'active'; } ?>">
                        <a class="slide-item <?php if(isset($menu) && $menu == 'left member list' && isset($submenu) && $submenu == 'l_list'){ echo 'active'; } ?>" href="<?php echo base_url(genealogy_constants::left_member_url); ?>">Left List</a>
                    </li>
                    <li class="<?php if(isset($menu) && $menu == 'right member' && isset($submenu) && $submenu == 'r_list'){ echo 'active'; } ?>">
                        <a class="slide-item <?php if(isset($menu) && $menu == 'right member' && isset($submenu) && $submenu == 'r_list'){ echo 'active'; } ?>" href="<?php echo base_url(genealogy_constants::right_member_url); ?>">Right List</a>
                    </li>
                    <li class="<?php if(isset($menu) && $menu == 'direct list' && isset($submenu) && $submenu == 'd_list'){ echo 'active'; } ?>">
                        <a class="slide-item <?php if(isset($menu) && $menu == 'direct list' && isset($submenu) && $submenu == 'd_list'){ echo 'active'; } ?>" href="<?php echo base_url(genealogy_constants::my_directs_url); ?>">Direct List</a>
                    </li>
                </ul>
            </li>
            <li class="slide <?php if(isset($menu) && $menu == 'binary tree'){ echo 'active-menu-expanded is-expanded'; } ?>">
                <a class="side-menu__item <?php if(isset($menu) && $menu == 'binary tree'){ echo 'active'; } ?>" data-toggle="slide" href="javascript:void(0);">
                    <i class="side-menu__icon icon fa fa-users"></i>
                    <span class="side-menu__label">Network</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <li class="<?php if(isset($menu) && $menu == 'binary tree' && isset($submenu) && $submenu == 'b_tree'){ echo 'active'; } ?>">
                        <a class="slide-item <?php if(isset($menu) && $menu == 'binary tree' && isset($submenu) && $submenu == 'b_tree'){ echo 'active'; } ?>" href="<?php echo base_url(binary_constants::binary_tree_url); ?>">Binary Tree</a>
                    </li>
                    <li class="<?php if(isset($menu) && $menu == 'dircet tree' && isset($submenu) && $submenu == 'd_tree'){ echo 'active'; } ?>">
                        <a class="slide-item <?php if(isset($menu) && $menu == 'dircet tree' && isset($submenu) && $submenu == 'd_tree'){ echo 'active'; } ?>" href="<?php echo base_url(binary_constants::direct_tree_url); ?>">Direct Tree</a>
                    </li>
                </ul>
            </li>
            <li class="slide <?php if(isset($menu) && $menu == 'payouts records'){ echo 'active-menu-expanded is-expanded'; } ?>">
                <a class="side-menu__item <?php if(isset($menu) && $menu == 'payouts records'){ echo 'active'; } ?>" data-toggle="slide" href="javascript:void(0);">
                    <i class="side-menu__icon fas fa-shopping-cart"></i>
                    <span class="side-menu__label">Payout</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <li class="<?php if(isset($menu) && $menu == 'payouts records' && isset($submenu) && $submenu == 'payouts'){ echo 'active'; } ?>">
                        <a class="slide-item <?php if(isset($menu) && $menu == 'payouts records' && isset($submenu) && $submenu == 'payouts'){ echo 'active'; } ?>" href="<?php echo base_url(accounts_constants::payouts_url); ?>">Payout Income</a>
                    </li>
                    <li class="<?php if(isset($menu) && $menu == 'payouts records' && isset($submenu) && $submenu == 'payouts_records'){ echo 'active'; } ?>">
                        <a class="slide-item <?php if(isset($menu) && $menu == 'payouts records' && isset($submenu) && $submenu == 'payouts_records'){ echo 'active'; } ?>" href="<?php echo base_url(accounts_constants::payouts_records_url); ?>">Payout Income History</a>
                    </li>
                </ul>
            </li>

            <li class="slide <?php if(isset($menu) && $menu == 'franchise'){ echo 'active-menu-expanded is-expanded'; } ?>">
                <a class="side-menu__item <?php if(isset($menu) && $menu == 'franchise'){ echo 'active'; } ?>" data-toggle="slide" href="javascript:void(0);">
                    <i class="side-menu__icon la la-bar-chart"></i>
                    <span class="side-menu__label">Franchise</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <li class="<?php if(isset($menu) && $menu == 'franchise' && isset($submenu) && $submenu == 'list'){ echo 'active'; } ?>">
                        <a class="slide-item <?php if(isset($menu) && $menu == 'franchise' && isset($submenu) && $submenu == 'list'){ echo 'active'; } ?>" href="<?php echo base_url(franchise_constants::franchise_url); ?>">List</a>
                    </li>
                    <li class="<?php if(isset($menu) && $menu == 'franchise' && isset($submenu) && $submenu == 'add'){ echo 'active'; } ?>">
                        <a class="slide-item <?php if(isset($menu) && $menu == 'franchise' && isset($submenu) && $submenu == 'add'){ echo 'active'; } ?>" href="<?php echo base_url(franchise_constants::add_franchise_url); ?>">Add</a>
                    </li>
                </ul>
            </li>
            <li class="slide <?php if(isset($menu) && $menu == 'franchise_products'){ echo 'active-menu-expanded is-expanded'; } ?>">
                <a class="side-menu__item <?php if(isset($menu) && $menu == 'franchise_products'){ echo 'active'; } ?>" data-toggle="slide" href="javascript:void(0);">
                    <i class="side-menu__icon fas fa-dolly-flatbed"></i>
                    <span class="side-menu__label">Franchise Products</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <li class="<?php if(isset($menu) && $menu == 'franchise_products' && isset($submenu) && $submenu == 'list'){ echo 'active'; } ?>">
                        <a class="slide-item <?php if(isset($menu) && $menu == 'franchise_products' && isset($submenu) && $submenu == 'list'){ echo 'active'; } ?>" href="<?php echo base_url(franchise_products_constants::franchise_products_url); ?>">List</a>
                    </li>
                    <li class="<?php if(isset($menu) && $menu == 'franchise_products' && isset($submenu) && $submenu == 'add'){ echo 'active'; } ?>">
                        <a class="slide-item <?php if(isset($menu) && $menu == 'franchise_products' && isset($submenu) && $submenu == 'add'){ echo 'active'; } ?>" href="<?php echo base_url(franchise_products_constants::add_franchise_product_url); ?>">Add</a>
                    </li>
                </ul>
            </li>

            <li class="slide <?php if(isset($menu) && $menu == 'orders'){ echo 'active'; } ?>">
                <a class="side-menu__item" href="<?php echo base_url(orders_constants::orders_url); ?>">
                    <i class="side-menu__icon fe fe-shopping-cart"></i>
                    <span class="side-menu__label">Franchise Orders</span>
                    <span class="badge badge-info side-badge" id="pending-orders">0</span>
                </a>
            </li>

            <?php /* ?><li class="slide <?php if(isset($menu) && $menu == 'products'){ echo 'active-menu-expanded is-expanded'; } ?>">
                <a class="side-menu__item <?php if(isset($menu) && $menu == 'products'){ echo 'active'; } ?>" data-toggle="slide" href="javascript:void(0);">
                    <i class="side-menu__icon fas fa-dolly-flatbed"></i>
                    <span class="side-menu__label">Products</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <li class="sub-slide <?php if(isset($submenu) && $submenu == 'categories'){ echo 'active-menu-expanded is-expanded'; } ?>">
                        <a class="sub-side-menu__item" data-toggle="sub-slide" href="javascript:void(0);">
                            <span class="sub-side-menu__label">Categories</span>
                            <i class="sub-angle fe fe-chevron-down"></i>
                        </a>
                        <ul class="sub-slide-menu">
                            <li class="<?php if(isset($submenu) && $submenu == 'categories' && isset($childmenu) && $childmenu == 'list'){ echo 'active'; } ?>">
                                <a class="sub-slide-item <?php if(isset($submenu) && $submenu == 'categories' && isset($childmenu) && $childmenu == 'list'){ echo 'active'; } ?>" href="<?php echo base_url(product_constants::product_categories_url); ?>">List</a>
                            </li>
                            <li class="<?php if(isset($submenu) && $submenu == 'categories' && isset($childmenu) && $childmenu == 'add'){ echo 'active'; } ?>">
                                <a class="sub-slide-item <?php if(isset($submenu) && $submenu == 'categories' && isset($childmenu) && $childmenu == 'add'){ echo 'active'; } ?>" href="<?php echo base_url(product_constants::add_product_category_url); ?>">Add</a>
                            </li>
                        </ul>
                    </li>

                    <li class="sub-slide <?php if(isset($submenu) && $submenu == 'brands'){ echo 'active-menu-expanded is-expanded'; } ?>">
                        <a class="sub-side-menu__item" data-toggle="sub-slide" href="javascript:void(0);">
                            <span class="sub-side-menu__label">Brands</span>
                            <i class="sub-angle fe fe-chevron-down"></i>
                        </a>
                        <ul class="sub-slide-menu">
                            <li class="<?php if(isset($submenu) && $submenu == 'brands' && isset($childmenu) && $childmenu == 'list'){ echo 'active'; } ?>">
                                <a class="sub-slide-item <?php if(isset($submenu) && $submenu == 'brands' && isset($childmenu) && $childmenu == 'list'){ echo 'active'; } ?>" href="<?php echo base_url(product_constants::product_brands_url); ?>">List</a>
                            </li>
                            <li class="<?php if(isset($submenu) && $submenu == 'brands' && isset($childmenu) && $childmenu == 'add'){ echo 'active'; } ?>">
                                <a class="sub-slide-item <?php if(isset($submenu) && $submenu == 'brands' && isset($childmenu) && $childmenu == 'add'){ echo 'active'; } ?>" href="<?php echo base_url(product_constants::add_product_brand_url); ?>">Add</a>
                            </li>
                        </ul>
                    </li>

                    <li class="sub-slide <?php if(isset($submenu) && $submenu == 'sizes'){ echo 'active-menu-expanded is-expanded'; } ?>">
                        <a class="sub-side-menu__item" data-toggle="sub-slide" href="javascript:void(0);">
                            <span class="sub-side-menu__label">Sizes</span>
                            <i class="sub-angle fe fe-chevron-down"></i>
                        </a>
                        <ul class="sub-slide-menu">
                            <li class="<?php if(isset($submenu) && $submenu == 'sizes' && isset($childmenu) && $childmenu == 'list'){ echo 'active'; } ?>">
                                <a class="sub-slide-item <?php if(isset($submenu) && $submenu == 'sizes' && isset($childmenu) && $childmenu == 'list'){ echo 'active'; } ?>" href="<?php echo base_url(product_constants::product_sizes_url); ?>">List</a>
                            </li>
                            <li class="<?php if(isset($submenu) && $submenu == 'sizes' && isset($childmenu) && $childmenu == 'add'){ echo 'active'; } ?>">
                                <a class="sub-slide-item <?php if(isset($submenu) && $submenu == 'sizes' && isset($childmenu) && $childmenu == 'add'){ echo 'active'; } ?>" href="<?php echo base_url(product_constants::add_product_size_url); ?>">Add</a>
                            </li>
                        </ul>
                    </li>

                    <li class="sub-slide <?php if(isset($submenu) && $submenu == 'colors'){ echo 'active-menu-expanded is-expanded'; } ?>">
                        <a class="sub-side-menu__item" data-toggle="sub-slide" href="javascript:void(0);">
                            <span class="sub-side-menu__label">Colors</span>
                            <i class="sub-angle fe fe-chevron-down"></i>
                        </a>
                        <ul class="sub-slide-menu">
                            <li class="<?php if(isset($submenu) && $submenu == 'colors' && isset($childmenu) && $childmenu == 'list'){ echo 'active'; } ?>">
                                <a class="sub-slide-item <?php if(isset($submenu) && $submenu == 'colors' && isset($childmenu) && $childmenu == 'list'){ echo 'active'; } ?>" href="<?php echo base_url(product_constants::product_colors_url); ?>">List</a>
                            </li>
                            <li class="<?php if(isset($submenu) && $submenu == 'colors' && isset($childmenu) && $childmenu == 'add'){ echo 'active'; } ?>">
                                <a class="sub-slide-item <?php if(isset($submenu) && $submenu == 'colors' && isset($childmenu) && $childmenu == 'add'){ echo 'active'; } ?>" href="<?php echo base_url(product_constants::add_product_color_url); ?>">Add</a>
                            </li>
                        </ul>
                    </li>

                    <li class="sub-slide <?php if(isset($submenu) && $submenu == 'products'){ echo 'active-menu-expanded is-expanded'; } ?>">
                        <a class="sub-side-menu__item" data-toggle="sub-slide" href="javascript:void(0);">
                            <span class="sub-side-menu__label">Products</span>
                            <i class="sub-angle fe fe-chevron-down"></i>
                        </a>
                        <ul class="sub-slide-menu">
                            <li class="<?php if(isset($submenu) && $submenu == 'products' && isset($childmenu) && $childmenu == 'list'){ echo 'active'; } ?>">
                                <a class="sub-slide-item <?php if(isset($submenu) && $submenu == 'products' && isset($childmenu) && $childmenu == 'list'){ echo 'active'; } ?>" href="<?php echo base_url(product_constants::products_url); ?>">List</a>
                            </li>
                            <li class="<?php if(isset($submenu) && $submenu == 'products' && isset($childmenu) && $childmenu == 'add'){ echo 'active'; } ?>">
                                <a class="sub-slide-item <?php if(isset($submenu) && $submenu == 'products' && isset($childmenu) && $childmenu == 'add'){ echo 'active'; } ?>" href="<?php echo base_url(product_constants::add_product_url); ?>">Add</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li><?php */ ?>

            <li class="slide <?php if(isset($menu) && $menu == 'announcements'){ echo 'active-menu-expanded is-expanded'; } ?>">
                <a class="side-menu__item <?php if(isset($menu) && $menu == 'announcements'){ echo 'active'; } ?>" data-toggle="slide" href="javascript:void(0);">
                    <i class="side-menu__icon icon fa fa-bullhorn"></i>
                    <span class="side-menu__label">Announcements</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <li class="<?php if(isset($menu) && $menu == 'announcements' && isset($submenu) && $submenu == 'list'){ echo 'active'; } ?>">
                        <a class="slide-item <?php if(isset($menu) && $menu == 'announcements' && isset($submenu) && $submenu == 'list'){ echo 'active'; } ?>" href="<?php echo base_url(announcements_constants::announcements_url); ?>">List</a>
                    </li>
                    <li class="<?php if(isset($menu) && $menu == 'announcements' && isset($submenu) && $submenu == 'add'){ echo 'active'; } ?>">
                        <a class="slide-item <?php if(isset($menu) && $menu == 'announcements' && isset($submenu) && $submenu == 'add'){ echo 'active'; } ?>" href="<?php echo base_url(announcements_constants::add_announcement_url); ?>">Add</a>
                    </li>
                </ul>
            </li>

            <li class="slide <?php if(isset($menu) && $menu == 'news'){ echo 'active-menu-expanded is-expanded'; } ?>">
                <a class="side-menu__item <?php if(isset($menu) && $menu == 'news'){ echo 'active'; } ?>" data-toggle="slide" href="javascript:void(0);">
                    <i class="side-menu__icon icon fa fa-bullhorn"></i>
                    <span class="side-menu__label">News</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <li class="<?php if(isset($menu) && $menu == 'news' && isset($submenu) && $submenu == 'list'){ echo 'active'; } ?>">
                        <a class="slide-item <?php if(isset($menu) && $menu == 'news' && isset($submenu) && $submenu == 'list'){ echo 'active'; } ?>" href="<?php echo base_url(news_constants::news_url); ?>">List</a>
                    </li>
                    <li class="<?php if(isset($menu) && $menu == 'news' && isset($submenu) && $submenu == 'add'){ echo 'active'; } ?>">
                        <a class="slide-item <?php if(isset($menu) && $menu == 'news' && isset($submenu) && $submenu == 'add'){ echo 'active'; } ?>" href="<?php echo base_url(news_constants::add_news_url); ?>">Add</a>
                    </li>
                </ul>
            </li>

            <li class="slide <?php if(isset($menu) && $menu == 'gallery'){ echo 'active-menu-expanded is-expanded'; } ?>">
                <a class="side-menu__item <?php if(isset($menu) && $menu == 'gallery'){ echo 'active'; } ?>" data-toggle="slide" href="javascript:void(0);">
                    <i class="side-menu__icon icon ion-md-images"></i>
                    <span class="side-menu__label">Gallery</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <li class="<?php if(isset($menu) && $menu == 'gallery' && isset($submenu) && $submenu == 'list'){ echo 'active'; } ?>">
                        <a class="slide-item <?php if(isset($menu) && $menu == 'gallery' && isset($submenu) && $submenu == 'list'){ echo 'active'; } ?>" href="<?php echo base_url(gallery_constants::gallery_url); ?>">List</a>
                    </li>
                    <li class="<?php if(isset($menu) && $menu == 'gallery' && isset($submenu) && $submenu == 'add'){ echo 'active'; } ?>">
                        <a class="slide-item <?php if(isset($menu) && $menu == 'gallery' && isset($submenu) && $submenu == 'add'){ echo 'active'; } ?>" href="<?php echo base_url(gallery_constants::upload_image_form_url); ?>">Upload</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</aside>