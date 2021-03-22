<!DOCTYPE html>
<html lang="en" data-textdirection="ltr">
    <head>
        <?php $this->load->view('admin/layout/head'); ?>
    </head>
    <body id="app-container" class="menu-sub-hidden show-spinner right-menu">
        <nav class="navbar fixed-top">
            <div class="d-flex align-items-center navbar-left">
                <a href="#" class="menu-button d-none d-md-block">
                    <svg class="main" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 9 17">
                        <rect x="0.48" y="0.5" width="7" height="1"></rect>
                        <rect x="0.48" y="7.5" width="7" height="1"></rect>
                        <rect x="0.48" y="15.5" width="7" height="1"></rect>
                    </svg>
                    <svg class="sub" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 17">
                        <rect x="1.56" y="0.5" width="16" height="1"></rect>
                        <rect x="1.56" y="7.5" width="16" height="1"></rect>
                        <rect x="1.56" y="15.5" width="16" height="1"></rect>
                    </svg>
                </a>
                <a href="#" class="menu-button d-xs-block d-sm-block d-md-none">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 17">
                        <rect x="0.5" y="0.5" width="25" height="1"></rect>
                        <rect x="0.5" y="7.5" width="25" height="1"></rect>
                        <rect x="0.5" y="15.5" width="25" height="1"></rect>
                    </svg>
                </a>
                <div class="search" data-search-path="<?php echo site_url('admin/flows?'); ?>">
                    <input placeholder="Search..." name="search">
                    <span class="search-icon">
                        <i class="simple-icon-magnifier"></i>
                    </span>
                </div>
            </div>
            <a class="navbar-logo" href="<?php echo site_url('admin') ?>">
                <span class="logo d-none d-xs-block"></span>
                <span class="logo-mobile d-block d-xs-none"></span>
            </a>
            <div class="navbar-right">
                <div class="header-icons d-inline-block align-middle">
                    <button class="header-icon btn btn-empty d-none d-sm-inline-block" type="button" id="fullScreenButton">
                        <i class="simple-icon-size-fullscreen"></i>
                        <i class="simple-icon-size-actual"></i>
                    </button>
                </div>
                <div class="user d-inline-block">
                    <button class="btn btn-empty p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="name"><?php echo $this->user['email']; ?></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right mt-3">
                        <!-- <a class="dropdown-item" href="<?php echo site_url('admin/profile'); ?>">Account</a> -->
                        <a class="dropdown-item" href="<?php echo site_url('admin/logout'); ?>">Sign out</a>
                    </div>
                </div>
            </div>
        </nav>
        <div class="menu">
            <div class="main-menu">
                <div class="scroll">
                    <ul class="list-unstyled">
                        <li class="<?php echo (isset($tab) && $tab == 'dashboard') ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/dashboard'); ?>">
                                <i class="iconsminds-shop-4"></i>
                                <span>Dashboards</span>
                            </a>
                        </li>
                        <li class="<?php echo (isset($tab) && $tab == 'flow') ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/flows'); ?>">
                                <i class="iconsminds-digital-drawing"></i> Flows
                            </a>
                        </li>
                        <li class="<?php echo (isset($tab) && $tab == 'submissions') ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/submissions'); ?>">
                                <i class="iconsminds-air-balloon-1"></i> Submissions
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <main>