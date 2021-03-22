<!DOCTYPE html>
<html lang="en" data-textdirection="ltr">
    <head>
        <?php $this->load->view('front/layout/head'); ?>
    </head>
    <body id="app-container" class="menu-sub-hidden show-spinner right-menu">
        <nav class="navbar fixed-top">
            <a class="navbar-logo ml-4" href="<?php echo site_url(); ?>">
                <span class="logo d-none d-xs-block"></span>
                <span class="logo-mobile d-block d-xs-none"></span>
            </a>
            <div class="user d-inline-block">
                <a class="btn btn-primary btn-shadow mr-3" href="<?php echo site_url('admin'); ?>">Login</a>
                <a class="btn btn-secondary btn-shadow mr-3" href="<?php echo site_url('register'); ?>">Register</a>
            </div>
        </nav>
        <main style="margin-left: 60px !important;">