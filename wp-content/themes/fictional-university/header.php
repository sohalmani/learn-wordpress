<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <?php wp_head(); ?>
</head>
<body>
<header class="site-header">
    <div class="container">
        <h1 class="school-logo-text float-left">
            <a href="<?php echo site_url(); ?>"><strong>Fictional</strong> University</a>
        </h1>
        <span class="js-search-trigger site-header__search-trigger"><i class="fa fa-search"
                                                                       aria-hidden="true"></i></span>
        <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
        <div class="site-header__menu group">
            <nav class="main-navigation">
                <?php wp_nav_menu(array("theme_location" => "header_main")); ?>
                <!--                <ul>-->
                <!--                    <li><a href="--><?php //echo site_url('/about'); ?><!--">About Us</a></li>-->
                <!--                    <li><a href="#">Programs</a></li>-->
                <!--                    <li><a href="#">Events</a></li>-->
                <!--                    <li><a href="#">Campuses</a></li>-->
                <!--                    <li><a href="#">Blog</a></li>-->
                <!--                </ul>-->
            </nav>
            <div class="site-header__util">
                <?php if (!is_user_logged_in()): ?>
                    <a href="<?php echo esc_url(wp_login_url()); ?>" class="btn btn--small btn--orange float-left push-right">Login</a>
                    <a href="<?php echo esc_url(wp_registration_url()); ?>" class="btn btn--small btn--dark-orange float-left">Sign Up</a>
                <?php else: ?>
                    <a href="<?php echo esc_url(wp_logout_url()); ?>" class="btn btn--small btn--dark-orange float-left btn--with-photo">
                        <span class="site-header__avatar"><?php echo (get_avatar(get_current_user_id(), 60)); ?></span>
                        <span class="btn__text">Logout</span>
                    </a>
                <?php endif; ?>
                <a href="<?php echo esc_url(site_url('/search')); ?>" class="search-trigger js-search-trigger"><i class="fa fa-search" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
</header>
