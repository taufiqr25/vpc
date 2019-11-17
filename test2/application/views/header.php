<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title><?= $title ?></title>

    <!-- Fontfaces CSS-->
    <link href="<?= base_url() ?>assets/css/font-face.css" rel="stylesheet" media="all">
    <link href="<?= base_url() ?>assets/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="<?= base_url() ?>assets/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="<?= base_url() ?>assets/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="<?= base_url() ?>assets/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="<?= base_url() ?>assets/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="<?= base_url() ?>assets/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="<?= base_url() ?>assets/vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="<?= base_url() ?>assets/vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="<?= base_url() ?>assets/vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="<?= base_url() ?>assets/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="<?= base_url() ?>assets/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
	<link href="<?= base_url() ?>assets/css/theme.css" rel="stylesheet" media="all">
	<!-- Jquery JS-->
	<script src="<?= base_url() ?>assets/vendor/jquery-3.2.1.min.js"></script>
	<!-- Main JS-->
	<script src="<?= base_url() ?>assets/js/main.js"></script>
    <!-- Bootstrap JS-->
    <script src="<?= base_url() ?>assets/vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="<?= base_url() ?>assets/vendor/bootstrap-4.1/bootstrap.min.js"></script>

</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="<?= base_url() ?>assets/index.html">
                            <img src="<?= base_url() ?>assets/images/icon/logo.png" alt="CoolAdmin" />
                        </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </header>
        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="#">
                    <img src="<?= base_url() ?>assets/images/icon/logo.png" alt="Cool Admin" />
                </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        <li class="<?php if(MENU_AKTIF == "home")echo "active"?>">
                            <a href="home">
								<i class="fas fa-home"></i>Dashboard</a>
                        </li>
                        <li class="<?php if(MENU_AKTIF == "barang")echo "active"?>">
                            <a href="barang">
								<i class="fas fa-list"></i></i>Daftar Barang</a>
						</li>
						<li class="<?php if(MENU_AKTIF == "order")echo "active"?>">
                            <a href="order">
								<i class="fas fa-shopping-cart"></i>Daftar Order</a>
						</li>
						<li class="<?php if(MENU_AKTIF == "user")echo "active"?>">
                            <a href="user">
								<i class="fas fa-users"></i></i>Daftar User</a>
                        </li>
                        <li class="<?php if(MENU_AKTIF == "") ?> has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-copy"></i>Pages</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="#">Login</a>
                                </li>
                                <li>
                                    <a href="#">Register</a>
                                </li>
                                <li>
                                    <a href="#">Forget Password</a>
                                </li>
                            </ul>
                        </li>
                        <li class="<?php if(MENU_AKTIF == "") ?> has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-desktop"></i>UI Elements</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="#">Button</a>
                                </li>
                                <li>
                                    <a href="#">Badges</a>
                                </li>
                                <li>
                                    <a href="#">Tabs</a>
                                </li>
                                <li>
                                    <a href="#">Cards</a>
                                </li>
                                <li>
                                    <a href="#">Alerts</a>
                                </li>
                                <li>
                                    <a href="#">Progress Bars</a>
                                </li>
                                <li>
                                    <a href="#">Modals</a>
                                </li>
                                <li>
                                    <a href="#">Switchs</a>
                                </li>
                                <li>
                                    <a href="#">Grids</a>
                                </li>
                                <li>
                                    <a href="#">Fontawesome Icon</a>
                                </li>
                                <li>
                                    <a href="#">Typography</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap">
                            <div class="form-header" action="" method="POST">
                                
                            </div>
                            <div class="form-header header-button">
                                <div class="noti-wrap">
                                    
                                </div>
                                <div class="account-wrap">
                                    <div class="account-item clearfix js-item-menu">
                                        <div class="image">
                                            <img src="https://image.flaticon.com/icons/svg/60/60992.svg" alt="admin" />
                                        </div>
                                        <div class="content">
                                            <a class="js-acc-btn" href="#">Admin CariYuk</a>
                                        </div>
                                        <div class="account-dropdown js-dropdown">
                                            <div class="account-dropdown__footer">
                                                <a href="logout">
                                                    <i class="zmdi zmdi-power"></i>Logout</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- END HEADER DESKTOP-->