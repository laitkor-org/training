<!DOCTYPE html>
<?php
    global $bpxl_goblog_options;

    // Page Variables
    if ( class_exists( 'ReduxFramework' ) ) {
        $bpxl_layout_type   = $bpxl_goblog_options['bpxl_layout_type'];
        $bpxl_sticky_menu   = $bpxl_goblog_options['bpxl_sticky_menu'];
        $bpxl_tagline       = $bpxl_goblog_options['bpxl_tagline'];
        $bpxl_header_slider = $bpxl_goblog_options['bpxl_header_slider'];
    } else {
        $bpxl_layout_type   = '1';
        $bpxl_sticky_menu   = '0';
        $bpxl_tagline       = '0';
        $bpxl_header_slider = '0';
    }
?>
<html class="no-js" <?php language_attributes(); ?>>
<head itemscope itemtype="http://schema.org/WebSite">
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta itemprop="url" content="<?php echo esc_url( home_url( '/' ) ); ?>"/>
    <meta itemprop="name" content="<?php bloginfo( 'name' ); ?>"/>
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <?php if ( !empty( $bpxl_goblog_options['bpxl_favicon']['url'] ) ) { ?>
    <link rel="icon" href="<?php echo esc_url( $bpxl_goblog_options['bpxl_favicon']['url'] ); ?>" type="image/x-icon" />
    <?php } ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <?php wp_head(); ?>
</head>
<?php $bpxl_layout_class = ( $bpxl_layout_type == '2' ) ? ' boxed-layout' : ''; ?>
<body id="blog" <?php body_class('main'); ?> itemscope itemtype="http://schema.org/WebPage">
    <?php wp_body_open(); ?>
    <div id="st-container" class="st-container">
		<nav class="st-menu">
			<div class="off-canvas-search">
				<div class="header-search off-search"><?php get_search_form(); ?></div>
			</div>
			<?php
                if ( has_nav_menu( 'main-menu' ) ) {
				    wp_nav_menu( array(
                        'theme_location' => 'main-menu',
                        'menu_class'     => 'menu',
                        'container'      => '',
                        'walker'         => new bpxl_nav_walker_mobile
                    ) );
                }
            ?>
		</nav>
        <div class="main-container<?php if( $bpxl_layout_type != '1' ) { echo esc_attr( $bpxl_layout_class ); } ?>">
            <div class="menu-pusher">
                <!-- START HEADER -->
                <header class="main-header clearfix <?php if ( $bpxl_sticky_menu == '1' ) { echo " header-down";} ?><?php bpxl_header_class(); ?>" itemscope itemtype="http://schema.org/WPHeader">
                    <div class="header clearfix">
                        <div class="container">
                            <div class="logo-wrap uppercase">
                                <?php
                                    if ( !empty( $bpxl_goblog_options['bpxl_logo']['url'] ) ) { ?>
                                        <div id="logo" class="site-logo uppercase">
                                            <a href="<?php echo home_url(); ?>">
                                                <img src="<?php echo esc_url( $bpxl_goblog_options['bpxl_logo']['url'] ); ?>" <?php if (!empty($bpxl_goblog_options['bpxl_retina_logo']['url'])) { echo 'data-at2x="'. esc_url( $bpxl_goblog_options['bpxl_retina_logo']['url'] ).'"';} ?> alt="<?php bloginfo( 'name' ); ?>">
                                            </a>
                                        </div>
                                        <?php
                                    } else {
                                        if( is_front_page() || is_home() || is_404() ) { ?>
                                            <h1 id="logo" class="site-logo uppercase" itemprop="headline">
                                                <a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a>
                                            </h1>
                                            <?php
                                        } else { ?>
                                            <h1 id="logo" class="site-logo uppercase" itemprop="headline">
                                                <a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a>
                                            </h2>
                                            <?php
                                        }
                                    }

                                    if ( $bpxl_tagline == '1' ) { ?>
                                        <span class="description" itemprop="description">
                                            <?php bloginfo( 'description' ); ?>
                                        </span>
                                        <?php
                                    }
                                ?>
                            </div><!--.logo-wrap-->
                            <div class="menu-btn off-menu">
                                <?php esc_html_e('Menu','goblog'); ?>
                                <span class="fa fa-align-justify"></span>
                            </div>
                            <div class="main-navigation uppercase">
                                <div class="main-nav">
                                    <nav id="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
                                        <?php
                                            if ( has_nav_menu( 'main-menu' ) ) {
                                                wp_nav_menu( array(
                                                    'theme_location' => 'main-menu',
                                                    'menu_class'     => 'menu',
                                                    'container'      => '',
                                                    'walker'         => new bpxl_nav_walker
                                                ) );
                                            }
                                        ?>
                                    </nav>
                                </div><!-- .main-nav -->
                            </div><!-- .main-navigation -->
                        </div><!-- .container -->
                    </div><!-- .header -->
                </header>
                <?php
                    if ( $bpxl_sticky_menu == '1' ) {
                        echo '<div class="header-sticky"></div>';
                    }

                    if ( $bpxl_header_slider == '1' ) {
                        if ( $bpxl_goblog_options['bpxl_header_slider_pages'] == '1' ) {
                            if( is_home() || is_front_page() ) {
                                get_template_part('template-parts/header-slider');
                            }
                        } elseif( $bpxl_goblog_options['bpxl_header_slider_pages'] == '2' ) {
                            get_template_part('template-parts/header-slider');
                        }
                    }
                ?>
                <!-- END HEADER -->
                <div class="main-wrapper clearfix">
                    <div id="page">