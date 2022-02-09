<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="main-content">
    <div class="main-header  side-header">
        <div class="container-fluid">
            <div class="main-header-left ">
                <div class="app-sidebar__toggle mobile-toggle" data-toggle="sidebar">
                    <a class="open-toggle" href="javascript:void(0);"><i class="header-icons" data-eva="menu-outline"></i></a>
                    <a class="close-toggle" href="javascript:void(0);"><i class="header-icons" data-eva="close-outline"></i></a>
                </div>
                <div class="responsive-logo">
                    <a href="<?php echo base_url(); ?>"><img src="<?php echo assets_url(); ?>img/logo/myheavenlogo.png" class="logo-1"></a>
                    <a href="<?php echo base_url(); ?>"><img src="<?php echo assets_url(); ?>img/logo/myheavenlogo.png" class="logo-11"></a>
                    <a href="<?php echo base_url(); ?>"><img src="<?php echo assets_url(); ?>img/logo/myheavenlogo.png" class="logo-2"></a>
                    <a href="<?php echo base_url(); ?>"><img src="<?php echo assets_url(); ?>img/logo/myheavenlogo.png" class="logo-12"></a>
                </div>
            </div>
            <div class="main-header-right">
                <div class="nav nav-item  navbar-nav-right ml-auto">
                    <div class="nav-item full-screen fullscreen-button">
                        <a class="new nav-link full-screen-link" href="#"><i class="fe fe-maximize"></i></span></a>
                    </div>
                    <div class="dropdown  nav-item main-header-message ">
                        <a class="new nav-link" href="#" ><i class="fe fe-mail"></i><span class=" pulse-danger"></span></a>
                        <div class="dropdown-menu">
                            <div class="menu-header-content bg-primary-gradient text-left d-flex">
                                <div class="">
                                    <h6 class="menu-header-title text-white mb-0">No Messages</h6>
                                </div>
                                <div class="my-auto ml-auto">
                                    <!-- <a class="badge badge-pill badge-warning float-right" href="javascript:void(0);">Mark All Read</a> -->
                                </div>
                            </div>
                            <div class="main-message-list chat-scroll">
                                <?php /* ?><a href="#" class="p-3 d-flex border-bottom">
                                    <div class="  drop-img  cover-image  " data-image-src="<?php echo assets_url(); ?>img/faces/3.jpg">
                                        <span class="avatar-status bg-teal"></span>
                                    </div>

                                    <div class="wd-90p">
                                        <div class="d-flex">
                                            <h5 class="mb-1 name">Paul Molive</h5>
                                            <p class="time mb-0 text-right ml-auto float-right">10 min ago</p>
                                        </div>
                                        <p class="mb-0 desc">I'm sorry but i'm not sure how...</p>
                                    </div>
                                </a><?php */ ?>
                            </div>
                            <div class="text-center dropdown-footer">
                                <a href="javascript:void(0);">VIEW ALL</a>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown nav-item main-header-notification">
                        <a class="new nav-link" href="javascript:void(0);"><i class="fe fe-bell"></i><span class=" pulse"></span></a>
                        <div class="dropdown-menu">
                            <div class="menu-header-content bg-primary-gradient text-left d-flex">
                                <div class="">
                                    <h6 class="menu-header-title text-white mb-0">No Notifications</h6>
                                </div>
                                <div class="my-auto ml-auto">
                                    <!-- <a class="badge badge-pill badge-warning float-right" href="javascript:void(0);">Mark All Read</a> -->
                                </div>
                            </div>
                            <div class="main-notification-list Notification-scroll">
                                <?php /* ?><a class="d-flex p-3 border-bottom" href="#">
                                    <div class="notifyimg bg-success-transparent">
                                        <i class="la la-shopping-basket text-success"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h5 class="notification-label mb-1">New Order Received</h5>
                                        <div class="notification-subtext">1 hour ago</div>
                                    </div>
                                    <div class="ml-auto" >
                                        <i class="las la-angle-right text-right text-muted"></i>
                                    </div>
                                </a><?php */ ?>
                            </div>
                            <div class="dropdown-footer">
                                <a href="javascript:void(0);">VIEW ALL</a>
                            </div>
                        </div>
                    </div>
                    <?php
                        $profile_pic_url = assets_url('img/faces/6.jpg');
                        if(!empty($user_data['profile_pic']))
                        {
                            $profile_pic_url = content_url('profile/'.$user_data['profile_pic']);
                        }
                    ?>
                    <div class="dropdown main-profile-menu nav nav-item nav-link">
                        <a class="profile-user d-flex" href="">
                            <img src="<?php echo $profile_pic_url; ?>" alt="<?php echo $user_data['full_name']; ?>" class="rounded-circle mCS_img_loaded"><span></span>
                        </a>
                        <div class="dropdown-menu">
                            <div class="main-header-profile header-img">
                                <div class="main-img-user">
                                    <img alt="<?php echo $user_data['full_name']; ?>" src="<?php echo $profile_pic_url; ?>">
                                </div>
                                <h6><?php echo $user_data['full_name']; ?></h6>
                                <!-- <span>Super Admin</span> -->
                            </div>
                            <a class="dropdown-item" href="<?php echo base_url(profile_constants::profile_url); ?>"><i class="far fa-user"></i> My Profile</a>
                            <a class="dropdown-item" href="<?php echo base_url(password_constants::password_url); ?>"><i class="fas fa-unlock-alt"></i> Change Password</a>
                            <a class="dropdown-item" href="<?php echo base_url(signin_constants::logout_url); ?>"><i class="fas fa-sign-out-alt"></i> Sign Out</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>