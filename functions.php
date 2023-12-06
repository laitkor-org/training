<?php
/**
 * Override redux sample data message
 * -------------------------------------------------
 * this will override the sample config message
 * that shows when activating the redux framework plugin
 */
add_action( 'admin_init', 'goblog_override_redux_message', 30 );
function goblog_override_redux_message() {
	update_option( 'ReduxFrameworkPlugin_ACTIVATED_NOTICES', array() );
}

/**
 * Redux Framework Settings
 * -------------------------------------------------
 * Check if $bpxl_goblog_options is not already set and config file exists
 * then include the config file
 */
if ( ! isset( $bpxl_goblog_options ) && file_exists( get_template_directory() . '/inc/theme-options/settings-config.php' ) ) {
	require_once get_template_directory() . '/inc/theme-options/settings-config.php';
}

/**
 * Demo Importer
 * -------------------------------------------------
 * Include one click demo importer
 */
require get_template_directory() . '/inc/demo-importer/demo-importer.php';

/*
 * Make theme available for translation.
 * Translations can be filed in the /languages/ directory.
 * If you're building a theme based on Goblog, use a find and replace
 * to change 'goblog' to the name of your theme in all the template files.
 */
load_theme_textdomain( 'goblog', get_template_directory() . '/languages' );

// TGMA Plugin Activation
require get_template_directory() . '/inc/plugins/class-tgm-plugin-activation.php';
require get_template_directory() . '/inc/plugins/required-class.php';

/**
 * Sets up the content width value based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 768;
}

// Theme Functions
require get_template_directory() . '/inc/theme-functions.php';

// AMP Support
require get_template_directory() . '/inc/amp-support.php';

/**
 * Sets up theme defaults and registers the various WordPress features that
 * GoBlog supports.
 */
function bpxl_theme_setup() {
	global $bpxl_goblog_options;

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	// This theme supports the following post formats.
	add_theme_support( 'post-formats', array( 'gallery', 'link', 'quote', 'video', 'image', 'status', 'audio' ) );

	// Register WordPress Custom Menus
	add_theme_support( 'menus' );
	register_nav_menu( 'main-menu', __( 'Main Menu', 'goblog' ) );

	// Register Post Thumbnails
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 150, 150, true );
	add_image_size( 'featured', 770, 360, true ); // featured
	add_image_size( 'featured570', 570, 365, true ); // featured570
	add_image_size( 'featured370', 370, 250, true ); // featured370
	add_image_size( 'related', 240, 185, true ); // related
	add_image_size( 'featuredthumb', 330, 160, true ); // related
	add_image_size( 'widgetthumb', 55, 55, true ); // widgetthumb

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);

	// Remove Emoji Support
	if ( ! isset( $bpxl_goblog_options['bpxl_emoji'] ) == '1' ) {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
	}

	add_theme_support( 'align-wide' );

	add_theme_support(
		'editor-color-palette',
		array(
			array(
				'name'  => __( 'Orange', 'goblog' ),
				'slug'  => 'orange',
				'color' => '#ff8800',
			),
			array(
				'name'  => __( 'Black', 'goblog' ),
				'slug'  => 'black',
				'color' => '#000000',
			),
			array(
				'name'  => __( 'Dark Gray', 'goblog' ),
				'slug'  => 'dark-gray',
				'color' => '#555555',
			),
			array(
				'name'  => __( 'Light Gray', 'goblog' ),
				'slug'  => 'light-gray',
				'color' => '#777777',
			),
		)
	);
}
add_action( 'after_setup_theme', 'bpxl_theme_setup' );

// Post and Category Meta Boxes
require_once get_template_directory() . '/inc/meta-boxes.php';
require get_template_directory() . '/inc/category-meta/Tax-meta-class/class-usage.php';

// Google Web fonts
if ( ! class_exists( 'ReduxFramework' ) ) {
	function goblog_fonts_url() {
		$fonts_url = '';

		/*
		 Translators: If there are characters in your language that are not
		* supported by Open Sans, translate this to 'off'. Do not translate
		* into your own language.
		*/
		$open_sans = _x( 'on', 'Open Sans font: on or off', 'goblog' );

		/*
		 Translators: If there are characters in your language that are not
		* supported by Noto Sans, translate this to 'off'. Do not translate
		* into your own language.
		*/
		$noto_sans = _x( 'on', 'Noto Sans font: on or off', 'goblog' );

		/*
		 Translators: If there are characters in your language that are not
		* supported by Montserrat, translate this to 'off'. Do not translate
		* into your own language.
		*/
		$montserrat = _x( 'on', 'Montserrat font: on or off', 'goblog' );

		if ( 'off' !== $noto_sans || 'off' !== $open_sans || 'off' !== $montserrat ) {
			$font_families = array();

			if ( 'off' !== $open_sans ) {
				$font_families[] = 'Open Sans:400,400i,600,600i,700,700italic,800,800i';
			}

			if ( 'off' !== $noto_sans ) {
				$font_families[] = 'Noto Sans:400,400i,700,700italic';
			}

			if ( 'off' !== $montserrat ) {
				$font_families[] = 'Montserrat:400,700';
			}

			$query_args = array(
				'family' => urlencode( implode( '|', $font_families ) ),
				'subset' => urlencode( 'latin,latin-ext' ),
			);

			$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
		}

		return esc_url_raw( $fonts_url );
	}

	function goblog_add_google_fonts() {
		wp_enqueue_style( 'goblog-google-fonts', goblog_fonts_url(), array(), null );
	}
	add_action( 'wp_enqueue_scripts', 'goblog_add_google_fonts' );
}

// Add Stylesheets
function bpxl_stylesheets() {
	global $bpxl_goblog_options;
	wp_enqueue_style( 'goblog-style', get_stylesheet_uri() );

	if ( class_exists( 'ReduxFramework' ) ) {
		$bpxl_primary_color = $bpxl_goblog_options['bpxl_color_one'];
		$background_color   = $bpxl_goblog_options['bpxl_body_bg']['background-color'];
		$background_image   = isset( $bpxl_goblog_options['bpxl_body_bg']['background-image'] ) ? $bpxl_goblog_options['bpxl_body_bg']['background-image'] : '';
		$background_pattern = $bpxl_goblog_options['bpxl_bg_pattern'];
		$header_slider_opacity = $bpxl_goblog_options['bpxl_header_slider_opacity'];
		// Navigation
		$bpxl_nav_link_color            = $bpxl_goblog_options['bpxl_nav_link_color']['regular'];
		$bpxl_nav_link_hover_color      = $bpxl_goblog_options['bpxl_nav_link_color']['hover'];
		$bpxl_nav_dropdown_bg_color     = $bpxl_goblog_options['bpxl_nav_drop_bg_color'];
		$bpxl_nav_drop_link_color       = $bpxl_goblog_options['bpxl_nav_drop_link_color']['regular'];
		$bpxl_nav_drop_link_hover_color = $bpxl_goblog_options['bpxl_nav_drop_link_color']['hover'];
		// On/Off Options
		$bpxl_lightbox          = $bpxl_goblog_options['bpxl_lightbox'];
		$bpxl_responsive_layout = $bpxl_goblog_options['bpxl_responsive_layout'];
		$bpxl_rtl               = $bpxl_goblog_options['bpxl_rtl'];
	} else {
		$bpxl_primary_color = '#FF8800';
		$background_color   = '#f2f2f2';
		$background_image   = '';
		$background_pattern = 'nopattern';
		$header_slider_opacity = 0.6;
		// Navigation
		$bpxl_nav_link_color            = '#8B8B8B';
		$bpxl_nav_link_hover_color      = '#FFFFFF';
		$bpxl_nav_dropdown_bg_color     = '#353535';
		$bpxl_nav_drop_link_color       = '#FFFFFF';
		$bpxl_nav_drop_link_hover_color = '#FFFFFF';
		// On/Off Options
		$bpxl_lightbox          = '1';
		$bpxl_responsive_layout = '1';
		$bpxl_rtl               = '0';
	}

	// Color Scheme
	if ( is_single() ) {
		if ( is_attachment() ) {
			$category_ID = '';
		} else {
			$category    = get_the_category();
			$category_ID = $category[0]->cat_ID;
		}
	} elseif ( is_category() ) {
		$category_ID = get_query_var( 'cat' );
	}
	if ( is_single() || is_category() ) {
		$bpxl_cat_color_1 = get_tax_meta( $category_ID, 'bpxl_color_field_id' );
		$cat_bg           = get_tax_meta( $category_ID, 'bpxl_bg_field_id' );
		$cat_repeat       = get_tax_meta( $category_ID, 'bpxl_category_repeat_id' );
		$cat_attachment   = get_tax_meta( $category_ID, 'bpxl_background_attachment_id' );
		$cat_position     = get_tax_meta( $category_ID, 'bpxl_background_position_id' );
	}

	// Color Scheme 1
	$color_scheme_1 = '';
	if ( is_single() || is_category() ) {
		if ( strlen( $bpxl_cat_color_1 ) > 2 ) {
			$color_scheme_1 = $bpxl_cat_color_1;
		} else {
			$color_scheme_1 = $bpxl_primary_color;
		}
	} elseif ( $bpxl_primary_color != '' ) {
		$color_scheme_1 = $bpxl_primary_color;
	}

	// Background Color
	if ( empty( $background_color ) ) {
		$background_color = '#f2f2f2'; }

	// Background Pattern
	$background_img = get_template_directory_uri() . '/assets/images/bg.png';
	$bg_repeat      = 'repeat';
	$bg_attachment  = 'scroll';
	$bg_position    = '0 0';
	$bg_size        = 'auto';
	if ( is_category() ) {
		if ( $cat_bg != '' ) { // Category Background Pattern
			$background_img = $cat_bg['src'];
			$bg_repeat      = $cat_repeat;
			$bg_attachment  = $cat_attachment;
			$bg_position    = $cat_position;
		} elseif ( ! empty( $background_image ) ) { // Body Custom Background Pattern
			$background_img = $bpxl_goblog_options['bpxl_body_bg']['background-image'];
			$bg_repeat      = $bpxl_goblog_options['bpxl_body_bg']['background-repeat'];
			$bg_attachment  = $bpxl_goblog_options['bpxl_body_bg']['background-attachment'];
			$bg_size        = $bpxl_goblog_options['bpxl_body_bg']['background-size'];
			$bg_position    = $bpxl_goblog_options['bpxl_body_bg']['background-position'];
		} elseif ( $background_pattern != 'nopattern' ) { // Body Default Background Pattern
			$background_img = get_template_directory_uri() . '/assets/images/' . $bpxl_goblog_options['bpxl_bg_pattern'] . '.png';
			$bg_repeat      = 'repeat';
			$bg_attachment  = 'scroll';
			$bg_position    = '0 0';
		}
	} elseif ( ! empty( $background_image ) ) { // Body Custom Background Pattern
		$background_img = $bpxl_goblog_options['bpxl_body_bg']['background-image'];
		$bg_repeat      = $bpxl_goblog_options['bpxl_body_bg']['background-repeat'];
		$bg_attachment  = $bpxl_goblog_options['bpxl_body_bg']['background-attachment'];
		$bg_size        = $bpxl_goblog_options['bpxl_body_bg']['background-size'];
		$bg_position    = $bpxl_goblog_options['bpxl_body_bg']['background-position'];
	} elseif ( $background_pattern != 'nopattern' ) { // Body Default Background Pattern
		$background_img = get_template_directory_uri() . '/assets/images/' . $bpxl_goblog_options['bpxl_bg_pattern'] . '.png';
		$bg_repeat      = 'repeat';
		$bg_attachment  = 'scroll';
		$bg_position    = '0 0';
		$bg_size        = 'auto';
	}

	// Layout Options
	$bpxl_custom_css    = '';
	$bpxl_single_layout = '';
	if ( is_single() || is_page() ) {
		if ( function_exists( 'rwmb_meta' ) ) {
			$sidebar_positions = rwmb_meta( 'bpxl_layout', $args = array( 'type' => 'image_select' ), get_the_ID() );
		} else {
			$sidebar_positions = '';
		}

		if ( ! empty( $sidebar_positions ) ) {
			$sidebar_position = $sidebar_positions;

			if ( $sidebar_position == 'left' ) {
				$bpxl_single_layout = '.single .content-area, .page .content-area { float:right; margin-left:2.4%; margin-right:0 }';
			} elseif ( $sidebar_position == 'right' ) {
				$bpxl_single_layout = '.single .content-area, .page .content-area { float:left; margin-right:2.4%; margin-left:0 }';
			} elseif ( $sidebar_position == 'none' ) {
				$bpxl_single_layout = '.single .content-area, .page .content-area { margin:0; width:100% } .related-posts ul li { width:21.6% }';
			}
		}
	}

	// Post Meta
	$bpxl_meta_css               = '';
	$bpxl_meta_date_css          = '';
	$bpxl_meta_author_css        = '';
	$bpxl_single_meta_css        = '';
	$bpxl_single_meta_date_css   = '';
	$bpxl_single_meta_author_css = '';
	// If Redux Framewoek is installed and activated
	if ( class_exists( 'ReduxFramework' ) ) {
		$bpxl_post_meta         = $bpxl_goblog_options['bpxl_post_meta'];
		$bpxl_post_author       = $bpxl_goblog_options['bpxl_post_meta_options']['1'];
		$bpxl_post_date         = $bpxl_goblog_options['bpxl_post_meta_options']['2'];
		$bpxl_post_avtar        = $bpxl_goblog_options['bpxl_post_meta_options']['6'];
		$bpxl_single_post_meta  = $bpxl_goblog_options['bpxl_single_post_meta'];
		$bpxl_single_post_date  = $bpxl_goblog_options['bpxl_single_post_meta_options']['2'];
		$bpxl_single_post_avtar = $bpxl_goblog_options['bpxl_single_post_meta_options']['6'];
	} else {
		$bpxl_post_meta         = '1';
		$bpxl_post_author       = '1';
		$bpxl_post_date         = '1';
		$bpxl_post_avtar        = '1';
		$bpxl_single_post_meta  = '1';
		$bpxl_single_post_date  = '1';
		$bpxl_single_post_avtar = '1';
	}
	if ( $bpxl_post_meta != '1' ) {
		$bpxl_meta_css = '.content-home .title-wrap, .content-archive .title-wrap { border:0; min-height:20px; padding-bottom:10px; }';
	}
	if ( $bpxl_post_date != '1' ) {
		$bpxl_meta_date_css = '.content-home .title-wrap, .content-archive .title-wrap { border:0; min-height:20px; padding-bottom:15px; }';
	}
	if ( $bpxl_post_avtar != '1' ) {
		$bpxl_meta_author_css = '.content-home .title-wrap { padding-right:20px }';
	}
	if ( $bpxl_single_post_meta != '1' ) {
		$bpxl_single_meta_css = '.single-content .post header { border:0; } .single-content .title-wrap { border:0; min-height:20px; padding-bottom:15px; }';
	}
	if ( $bpxl_single_post_date != '1' ) {
		$bpxl_single_meta_date_css = '.single-content { border:0; } .content-single .title-wrap { border:0; min-height:20px; padding-bottom:15px; }';
	}
	if ( $bpxl_single_post_avtar != '1' ) {
		$bpxl_single_meta_author_css = '.single-content .title-wrap { padding-right:20px }';
	}

	// Hex to RGB
	$bpxl_hex                       = $color_scheme_1;
	list($bpxl_r, $bpxl_g, $bpxl_b) = sscanf( $bpxl_hex, '#%02x%02x%02x' );

	// Custom CSS
	if ( isset( $bpxl_goblog_options['bpxl_custom_css'] ) ) {
		$bpxl_custom_css = $bpxl_goblog_options['bpxl_custom_css'];
	}

	$custom_css = "
	body, .menu-pusher { background-color:{$background_color}; background-image:url({$background_img}); background-repeat:{$bg_repeat}; background-attachment:{$bg_attachment}; background-position:{$bg_position} }
	.widgetslider .post-cats span, .tagcloud a:hover, .main-navigation ul li ul li a:hover, .menu ul .current-menu-item > a, .pagination span.current, .pagination a:hover, .read-more a, .more-link, .featuredslider .flex-control-nav .flex-active, input[type='submit'], #wp-calendar caption, #wp-calendar td#today, .comment-form .submit, .wpcf7-submit, .off-canvas-search .search-button, .galleryslider .flex-control-nav .flex-active { background-color:{$color_scheme_1}; }
	a, a:hover, .title a:hover, .sidebar a:hover, .sidebar-small-widget a:hover, .breadcrumbs a:hover, .meta a:hover, .post-meta a:hover, .reply:hover i, .reply:hover a, .edit-post a, .error-text, .comments-area .fn a:hover { color:{$color_scheme_1}; }
	.main-navigation a:hover, .main-navigation .current-menu-item a, .main-navigation .menu ul li:first-child, .current-menu-parent a { border-color:{$color_scheme_1}; }
	.main-navigation .menu > li > ul:before { border-bottom-color:{$color_scheme_1}; }
	.main-navigation a { color:{$bpxl_nav_link_color};} .main-navigation a:hover, .current-menu-item a, .current-menu-parent a { color:{$bpxl_nav_link_hover_color};}
	 .main-navigation ul li ul li a { background:{$bpxl_nav_dropdown_bg_color}; color:{$bpxl_nav_drop_link_color};}
	.main-navigation ul li ul li a:hover { color:{$bpxl_nav_drop_link_hover_color};}
	#wp-calendar th { background: rgba({$bpxl_r},{$bpxl_g},{$bpxl_b}, 0.6) } .slides-over { opacity:{$header_slider_opacity};} {$bpxl_single_layout} {$bpxl_custom_css} {$bpxl_meta_date_css} {$bpxl_single_meta_date_css} {$bpxl_meta_author_css} {$bpxl_single_meta_author_css} {$bpxl_meta_css} {$bpxl_single_meta_css}
	";
	wp_add_inline_style( 'goblog-style', $custom_css );

	// Font-Awesome CSS.
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css' );

	// Magnific Popup CSS.
	if ( $bpxl_lightbox == '1' ) {
		wp_enqueue_style( 'magnific-popup', get_template_directory_uri() . '/assets/css/magnific-popup.css' );
	}

	if ( $bpxl_responsive_layout == '1' ) {
		// Responsive.
		wp_enqueue_style( 'goblog-responsive', get_template_directory_uri() . '/assets/css/responsive.css' );
	}

	if ( $bpxl_rtl == '1' ) {
		// Responsive.
		wp_enqueue_style( 'goblog-rtl', get_template_directory_uri() . '/rtl.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'bpxl_stylesheets' );

/**
 * Enqueue JavaScript files
 *
 * @return void
 */
function bpxl_scripts() {
	global $bpxl_goblog_options;
	global $wp_query;

	if ( class_exists( 'ReduxFramework' ) ) {
		$bpxl_sticky_menu     = $bpxl_goblog_options['bpxl_sticky_menu'];
		$bpxl_layout          = $bpxl_goblog_options['bpxl_layout'];
		$bpxl_archive_layout  = $bpxl_goblog_options['bpxl_archive_layout'];
		$bpxl_lightbox        = $bpxl_goblog_options['bpxl_lightbox'];
		$bpxl_pagination_type = $bpxl_goblog_options['bpxl_pagination_type'];
	} else {
		$bpxl_sticky_menu     = '0';
		$bpxl_layout          = 'cblayout';
		$bpxl_archive_layout  = 'cblayout';
		$bpxl_lightbox        = '1';
		$bpxl_pagination_type = '1';
	}

	wp_enqueue_script( 'jquery' );
	if ( is_singular() ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Sticky Menu
	if ( $bpxl_sticky_menu == '1' ) {
		wp_enqueue_script( 'goblog-stickymenu', get_template_directory_uri() . '/assets/js/stickymenu.js', array( 'jquery' ), '1.0', true );
	}

	// Imagesloaded
	wp_enqueue_script( 'imagesloaded', get_template_directory_uri() . '/assets/js/imagesloaded.pkgd.min.js', array( 'jquery' ), '3.1.4', true );

	// Masonry
	if ( goblog_masonry_check() ) {
		wp_enqueue_script( 'masonry', get_template_directory_uri() . '/assets/js/masonry.pkgd.min.js', array( 'jquery' ), '4.1.1', true );
	}

	// Magnific Popup
	if ( $bpxl_lightbox == '1' ) {
		wp_enqueue_script( 'magnific-popup', get_template_directory_uri() . '/assets/js/jquery.magnific-popup.min.js', array( 'jquery' ), '1.1.0', true );
	}

	// Flexslider
	wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/assets/js/jquery.flexslider-min.js', array( 'jquery' ), '2.6.3', true );

	// FitVids
	wp_enqueue_script( 'fitVids', get_template_directory_uri() . '/assets/js/fitVids.js', array( 'jquery' ), '1.1', true );

	// Theme Specific Scripts
	wp_register_script( 'goblog-theme-scripts', get_template_directory_uri() . '/assets/js/theme-scripts.js', array( 'jquery' ), '1.0', true );
	wp_localize_script(
		'goblog-theme-scripts',
		'goblog_theme_scripts',
		array(
			'masonry_enabled' => goblog_masonry_check(),
			'pagination_type' => $bpxl_pagination_type,
			'ajaxurl'         => site_url() . '/wp-admin/admin-ajax.php',
			'posts'           => json_encode( $wp_query->query_vars ),
			'current_page'    => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
			'max_page'        => $wp_query->max_num_pages,
			'loading_text'    => esc_html__( 'Loading...', 'goblog' ),
			'load_more_text'  => esc_html__( 'Load More', 'goblog' ),
		)
	);
	wp_enqueue_script( 'goblog-theme-scripts' );

	global $is_IE;
	if ( $is_IE ) {
		wp_enqueue_script( 'html5shim', get_template_directory_uri() . '/assets/js/html5shiv.js' );
	}
}
add_action( 'wp_enqueue_scripts', 'bpxl_scripts' );

function goblog_loadmore_ajax_handler() {
	// prepare our arguments for the query
	$args                = json_decode( stripslashes( $_POST['query'] ), true );
	$args['paged']       = $_POST['page'] + 1; // we need next page to be loaded
	$args['post_status'] = 'publish';

	// it is always better to use WP_Query but not here
	query_posts( $args );

	if ( have_posts() ) :

		// run the loop
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/post-formats/content', get_post_format() );

		endwhile;

	endif;
	die; // here we exit the script and even no wp_reset_query() required!
}
add_action( 'wp_ajax_loadmore', 'goblog_loadmore_ajax_handler' ); // wp_ajax_{action}
add_action( 'wp_ajax_nopriv_loadmore', 'goblog_loadmore_ajax_handler' ); // wp_ajax_nopriv_{action}

/**
 * Enqueue Admin Scripts and Styles
 *
 * @return void
 */
function bpxl_admin_scripts() {
	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_script( 'goblog-admin-scripts', get_template_directory_uri() . '/assets/js/admin-scripts.js', array( 'jquery' ), '1.0', true );

	wp_enqueue_script( 'select2', get_template_directory_uri() . '/assets/js/select2.js', array( 'jquery' ), '4.0.13', true );
	
	wp_enqueue_style( 'select2', get_template_directory_uri() . '/assets/css/select2.css', array(), '4.0.13' );

	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css' );

	wp_enqueue_style( 'goblog-editor', get_template_directory_uri() . '/assets/css/editor.css' );

	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );
}
add_action( 'admin_enqueue_scripts', 'bpxl_admin_scripts' );

// Header Code
function bpxl_header_code_fn() {
	global $bpxl_goblog_options;
	if ( ! empty( $bpxl_goblog_options['bpxl_header_code'] ) ) {
		echo $bpxl_goblog_options['bpxl_header_code'];
	}
}
add_action( 'wp_head', 'bpxl_header_code_fn' );

// Footer Code
function bpxl_footer_code_fn() {
	global $bpxl_goblog_options;
	if ( ! empty( $bpxl_goblog_options['bpxl_footer_code'] ) ) {
		echo $bpxl_goblog_options['bpxl_footer_code'];
	}
}
add_action( 'wp_footer', 'bpxl_footer_code_fn' );

/**
 * Add preconnect for Google Fonts.
 *
 * @since Travelista 1.1.4
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function bpxl_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'bpxl_resource_hints', 10, 2 );

/**
 * Load Widgets
 *
 * @return void
 */
require get_template_directory() . '/inc/widgets/widget-ad125.php'; // 125x125 Ad Widget
require get_template_directory() . '/inc/widgets/widget-ad160.php'; // 160x600 Ad Widget
require get_template_directory() . '/inc/widgets/widget-ad300.php'; // 300x250 Ad Widget
require get_template_directory() . '/inc/widgets/widget-fblikebox.php'; // Facebook Like Box
require get_template_directory() . '/inc/widgets/widget-flickr.php'; // Flickr Widget
require get_template_directory() . '/inc/widgets/widget-author-posts.php'; // Popular Posts
require get_template_directory() . '/inc/widgets/widget-popular-posts.php'; // Popular Posts
require get_template_directory() . '/inc/widgets/widget-cat-posts.php'; // Category Posts
require get_template_directory() . '/inc/widgets/widget-random-posts.php'; // Random Posts
require get_template_directory() . '/inc/widgets/widget-recent-posts.php'; // Recent Posts
require get_template_directory() . '/inc/widgets/widget-social.php'; // Social Widget
require get_template_directory() . '/inc/widgets/widget-subscribe.php'; // Subscribe Widget
require get_template_directory() . '/inc/widgets/widget-tabs.php'; // Tabs Widget
require get_template_directory() . '/inc/widgets/widget-tweets.php'; // Tweets Widget
require get_template_directory() . '/inc/widgets/widget-video.php'; // Video Widget
require get_template_directory() . '/inc/widgets/widget-slider.php'; // Slider Widget
require get_template_directory() . '/inc/nav-walker.php'; // Nav Walker Class
require get_template_directory() . '/inc/nav-walker-mobile.php'; // Nav Walker Class

/**
 * Excerpt Length
 *
 * @return void
 */
function excerpt( $limit ) {
	$excerpt = explode( ' ', get_the_excerpt(), $limit );
	if ( count( $excerpt ) >= $limit ) {
		array_pop( $excerpt );
		$excerpt = implode( ' ', $excerpt ) . '...';
	} else {
		$excerpt = implode( ' ', $excerpt );
	}
	$excerpt = preg_replace( '`[[^]]*]`', '', $excerpt );
	return $excerpt;
}
add_filter( 'get_the_excerpt', 'do_shortcode' );

/**
 * Register Theme Widgets
 *
 * @return void
 */
function bpxl_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Primary Sidebar', 'goblog' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Main sidebar of the theme.', 'goblog' ),
			'before_widget' => '<div class="widget sidebar-widget block %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title uppercase">',
			'after_title'   => '</h3>',
		)
	);
	register_sidebar(
		array(
			'name'          => __( 'Secondary Sidebar', 'goblog' ),
			'id'            => 'sidebar-2',
			'description'   => __( 'Only displayed when 3 column layout is enabled.', 'goblog' ),
			'before_widget' => '<div class="widget sidebar-widget sidebar-small-widget block %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title uppercase">',
			'after_title'   => '</h3>',
		)
	);
	$sidebars = array( 1, 2, 3, 4 );
	foreach ( $sidebars as $number ) {
		register_sidebar(
			array(
				'name'          => __( 'Footer', 'goblog' ) . ' ' . intval( $number ),
				'id'            => 'footer-' . intval( $number ),
				'description'   => __( 'This widget area appears on footer of theme.', 'goblog' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title uppercase">',
				'after_title'   => '</h3>',
			)
		);
	}
}
add_action( 'widgets_init', 'bpxl_widgets_init' );

/**
 * Breadcrumbs
 *
 * @return void
 */
function bpxl_breadcrumb() {
	if ( ! is_home() ) {
		echo '<a href="';
		echo home_url();
		echo '"> <i class="fa fa-home"></i>';
		echo __( 'Home', 'goblog' );
		echo '</a>';
		if ( is_category() || is_single() ) {
			echo '&nbsp;&nbsp;/&nbsp;&nbsp;';
			the_category( ' &bull; ' );
			if ( is_single() ) {
				echo '&nbsp;&nbsp;/&nbsp;&nbsp;';
				the_title();
			}
		} elseif ( is_page() ) {
			echo '&nbsp;&nbsp;/&nbsp;&nbsp;';
			echo the_title();
		}
	} elseif ( is_tag() ) {
		echo '&nbsp;&nbsp;/&nbsp;&nbsp;';
		single_tag_title();
	} elseif ( is_day() ) {
		echo '&nbsp;&nbsp;/&nbsp;&nbsp;';
		echo 'Archive for ';
		the_time( 'F jS, Y' );
	} elseif ( is_month() ) {
		echo '&nbsp;&nbsp;/&nbsp;&nbsp;';
		echo 'Archive for ';
		the_time( 'F, Y' );
	} elseif ( is_year() ) {
		echo '&nbsp;&nbsp;/&nbsp;&nbsp;';
		echo 'Archive for ';
		the_time( 'Y' );
	} elseif ( is_author() ) {
		echo '&nbsp;&nbsp;/&nbsp;&nbsp;';
		echo 'Author Archive';
	} elseif ( isset( $_GET['paged'] ) && ! empty( $_GET['paged'] ) ) {
		echo '&nbsp;&nbsp;/&nbsp;&nbsp;';
		echo 'Blog Archives';
	} elseif ( is_search() ) {
		echo '&nbsp;&nbsp;/&nbsp;&nbsp;';
		echo 'Search Results';
	}
}

/**
 * Filter the page title
 *
 * @return void
 */
function bpxl_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'goblog' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'bpxl_wp_title', 10, 2 );

/**
 * Schema for Single Post
 *
 * @return void
 */
function bpxl_post_schema() {

	if ( is_singular( 'post' ) ) {
		global $post;
		global $bpxl_goblog_options;

		$bpxl_logo_url = ( ! empty( $bpxl_goblog_options['bpxl_logo']['url'] ) ? $bpxl_goblog_options['bpxl_logo']['url'] : '' );

		if ( has_post_thumbnail( $post->ID ) && ! empty( $bpxl_logo_url ) ) {

			$bpxl_post_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );

			$data = array(
				'@context'         => 'http://schema.org',
				'@type'            => 'BlogPosting',
				'author'           => array(
					'@type' => 'Person',
					'name'  => get_the_author_meta( 'display_name', $post->post_author ),
				),
				'datePublished'    => get_the_time( 'c', $post->ID ),
				'headline'         => $post->post_title,
				'image'            => array(
					'@type'  => 'ImageObject',
					'url'    => $bpxl_post_image[0],
					'width'  => $bpxl_post_image[1],
					'height' => $bpxl_post_image[2],
				),
				'publisher'        => array(
					'@type' => 'Organization',
					'name'  => get_bloginfo( 'name' ),
					'logo'  => array(
						'@type' => 'ImageObject',
						'url'   => esc_url( $bpxl_logo_url ),
					),
				),
				'dateModified'     => get_post_modified_time( 'c', '', $post->ID ),
				'mainEntityOfPage' => array(
					'@type' => 'WebPage',
					'@id'   => get_permalink( $post->ID ),
				),
			);

			echo '<script type="application/ld+json">' . PHP_EOL;
			echo wp_json_encode( $data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) , PHP_EOL;
			echo '</script>' . PHP_EOL;
		}
	}
}
add_action( 'wp_head', 'bpxl_post_schema' );

/**
 * Comments Callback
 *
 * @return void
 */
function bpxl_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		extract( $args, EXTR_SKIP );
	?>
		<li <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID(); ?>">
		<?php if ( 'div' != $args['style'] ) : ?>
		<div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
		<?php endif; ?>
		<div class="comment-author vcard">
			<?php
			if ( $args['avatar_size'] != 0 ) {
				echo get_avatar( $comment->comment_author_email, 60 );}
			?>
			<?php printf( __( '<cite class="fn uppercase">%s</cite>', 'goblog' ), get_comment_author_link() ); ?>

			<span class="reply uppercase">
			<?php
			comment_reply_link(
				array_merge(
					$args,
					array(
						'depth'      => $depth,
						'max_depth'  => $args['max_depth'],
						'reply_text' => __(
							'Reply',
							'goblog'
						),
					)
				)
			);
			?>
			</span>
		</div>
		<?php if ( $comment->comment_approved == '0' ) : ?>
				<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'goblog' ); ?></em>
				<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', 'goblog' ), get_comment_date(), get_comment_time() )
			?>
			</a>
			<?php
			edit_comment_link( __( '(Edit)', 'goblog' ), '  ', '' );
			?>
		</div>

		<div class="commentBody">
			<?php comment_text(); ?>
		</div>
		</div>
	<?php
}

/**
 * Pagination
 *
 * @return void
 */
function bpxl_pagination( $pages = '', $range = 2 ) {
	$showitems = ( $range * 2 ) + 1;

	 global $paged;
	if ( empty( $paged ) ) {
		$paged = 1;
	}
	if ( $pages == '' ) {
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if ( ! $pages ) {
			$pages = 1; }
	}

	if ( 1 != $pages ) {
		echo "<div class='pagination'>";
		if ( $paged > 2 && $paged > $range + 1 && $showitems < $pages ) {
			echo "<a href='" . get_pagenum_link( 1 ) . "'>&laquo;</a>";
		}
		if ( $paged > 1 && $showitems < $pages ) {
			echo "<a href='" . get_pagenum_link( $paged - 1 ) . "'>&lsaquo;</a>";
		}

		for ( $i = 1; $i <= $pages; $i++ ) {
			if ( 1 != $pages && ( ! ( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems ) ) {
				echo ( $paged == $i ) ? "<span class='current'>" . $i . '</span>' : "<a href='" . get_pagenum_link( $i ) . "' class='inactive' >" . $i . '</a>';
			}
		}

		if ( $paged < $pages && $showitems < $pages ) {
			echo "<a href='" . get_pagenum_link( $paged + 1 ) . "'>&rsaquo;</a>";
		}
		if ( $paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages ) {
			echo "<a href='" . get_pagenum_link( $pages ) . "'>&raquo;</a>";
		}
		echo "</div>\n";
	}
}

/**
 * Exclude Pages from Search
 *
 * @return void
 */
if ( is_search() ) {
	function bpxl_searchFilter( $query ) {
		if ( $query->is_search ) {
			$query->set( 'post_type', 'post' );
		}
		return $query;
	}
	add_filter( 'pre_get_posts', 'bpxl_searchFilter' );
}

/**
 * Insert ads after 'X' paragraph of single post content.
 *
 * @return void
 */
add_filter( 'the_content', 'prefix_insert_post_ads' );

function prefix_insert_post_ads( $content ) {
	global $bpxl_goblog_options;
	$bpxl_ad_code  = '';
	$bpxl_num_para = '';

	// If Redux Framewoek is installed and activated
    if ( class_exists( 'ReduxFramework' ) ) {
		$bpxl_para_ad = $bpxl_goblog_options['bpxl_para_ad'];
	} else {
		$bpxl_para_ad = '';
	}

	if ( $bpxl_para_ad != '' ) {
		$bpxl_ad_code  = $bpxl_goblog_options['bpxl_para_ad_code'];
		$bpxl_num_para = $bpxl_goblog_options['bpxl_para_ad'];
	}

	// $bpxl_ad_code = '<div>Ads code goes here</div>';

	if ( is_single() && ! is_admin() ) {
		return prefix_insert_after_paragraph( $bpxl_ad_code, $bpxl_num_para, $content );
	}

	return $content;
}

function prefix_insert_after_paragraph( $insertion, $paragraph_id, $content ) {
	$closing_p  = '</p>';
	$paragraphs = explode( $closing_p, $content );
	foreach ( $paragraphs as $index => $paragraph ) {

		if ( trim( $paragraph ) ) {
			$paragraphs[ $index ] .= $closing_p;
		}

		if ( $paragraph_id == $index + 1 ) {
			$paragraphs[ $index ] .= $insertion;
		}
	}

	return implode( '', $paragraphs );
}

/**
 * Facebook Open Graph Data
 *
 * @return void
 */
global $bpxl_goblog_options;
if ( isset( $bpxl_goblog_options['bpxl_fb_og'] ) ) {
	// Adding the Open Graph in the Language Attributes
	function add_opengraph_doctype( $output ) {
		return $output . ' prefix="og: http://ogp.me/ns#"';
	}
	add_filter( 'language_attributes', 'add_opengraph_doctype' );

	// Add Facebook Open Graph Tags
	function fb_og_tags() {
		global $post;

		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
		endwhile;
		endif;

		if ( is_single() || is_page() ) {

			if ( get_the_post_thumbnail( $post->ID, 'thumbnail' ) ) {
				$thumbnail_id     = get_post_thumbnail_id( $post->ID );
				$thumbnail_object = get_post( $thumbnail_id );
				$image            = $thumbnail_object->guid;
			} else {
				$image = ''; // Change this to the URL of the logo you want beside your links shown on Facebook
			}

			echo '<meta property="og:title" content="' . get_the_title() . '"/>';
			echo '<meta property="og:url" content="' . get_permalink() . '"/>';
			echo '<meta property="og:type" content="article" />';
			echo '<meta property="og:description" content="' . strip_tags( get_the_excerpt() ) . '" />';
			if ( ! empty( $image ) ) {
				echo '<meta property="og:image" content="' . $image . '" />';
			}
		} elseif ( is_home() ) {
			if ( ! empty( $bpxl_goblog_options['bpxl_logo']['url'] ) ) {
				$image = $bpxl_goblog_options['bpxl_logo']['url'];
			} else {
				$image = ''; // Change this to the URL of the logo you want beside your links shown on Facebook
			}
			echo '<meta property="og:title" content="' . get_bloginfo( 'name' ) . ' - ' . get_bloginfo( 'description' ) . '"/>';
			echo '<meta property="og:url" content="' . home_url() . '"/>';
			if ( ! empty( $image ) ) {
				echo '<meta property="og:image" content="' . $image . '" />';
			}
			echo '<meta property="og:type" content="website" />';
		}

		echo '<meta property="og:site_name" content="' . get_bloginfo( 'name' ) . '" />';
	}
	add_action( 'wp_head', 'fb_og_tags', 5 );
}

/**
 * Add Extra Fields to User Profiles
 *
 * @return void
 */
add_action( 'show_user_profile', 'bpxl_user_profile_fields' );
add_action( 'edit_user_profile', 'bpxl_user_profile_fields' );

function bpxl_user_profile_fields( $user ) {
	?>
<h3><?php _e( 'Social Profiles', 'goblog' ); ?></h3>

<table class="form-table">
	<tr>
		<th><label for="facebook"><?php _e( 'Facebook', 'goblog' ); ?></label></th>
		<td>
		<input type="text" name="facebook" id="facebook" value="<?php echo esc_attr( get_the_author_meta( 'facebook', $user->ID ) ); ?>" class="regular-text" /><br />
		<span class="description"><?php _e( 'Enter your facebook profile URL.', 'goblog' ); ?></span>
		</td>
	</tr>
	<tr>
		<th><label for="twitter"><?php _e( 'Twitter', 'goblog' ); ?></label></th>
		<td>
		<input type="text" name="twitter" id="twitter" value="<?php echo esc_attr( get_the_author_meta( 'twitter', $user->ID ) ); ?>" class="regular-text" /><br />
		<span class="description"><?php _e( 'Enter your twitter profile URL.', 'goblog' ); ?></span>
		</td>
	</tr>
	<tr>
		<th><label for="linkedin"><?php _e( 'LinkedIn', 'goblog' ); ?></label></th>
		<td>
		<input type="text" name="linkedin" id="linkedin" value="<?php echo esc_attr( get_the_author_meta( 'linkedin', $user->ID ) ); ?>" class="regular-text" /><br />
		<span class="description"><?php _e( 'Enter your LinkedIn profile URL.', 'goblog' ); ?></span>
		</td>
	</tr>
	<tr>
		<th><label for="pinterest"><?php _e( 'Pinterest', 'goblog' ); ?></label></th>
		<td>
		<input type="text" name="pinterest" id="pinterest" value="<?php echo esc_attr( get_the_author_meta( 'pinterest', $user->ID ) ); ?>" class="regular-text" /><br />
		<span class="description"><?php _e( 'Enter your Pinterest profile URL.', 'goblog' ); ?></span>
		</td>
	</tr>
	<tr>
		<th><label for="dribbble"><?php _e( 'Dribbble', 'goblog' ); ?></label></th>
		<td>
		<input type="text" name="dribbble" id="dribbble" value="<?php echo esc_attr( get_the_author_meta( 'dribbble', $user->ID ) ); ?>" class="regular-text" /><br />
		<span class="description"><?php _e( 'Enter your Dribbble profile URL.', 'goblog' ); ?></span>
		</td>
	</tr>
</table>
<?php }

add_action( 'personal_options_update', 'save_bpxl_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_bpxl_user_profile_fields' );

function save_bpxl_user_profile_fields( $user_id ) {

	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return false; }

	update_user_meta( $user_id, 'facebook', $_POST['facebook'] );
	update_user_meta( $user_id, 'twitter', $_POST['twitter'] );
	update_user_meta( $user_id, 'linkedin', $_POST['linkedin'] );
	update_user_meta( $user_id, 'pinterest', $_POST['pinterest'] );
	update_user_meta( $user_id, 'dribbble', $_POST['dribbble'] );
}

/**
 * Custom wp_link_pages
 *
 * @return void
 */
function bpxl_wp_link_pages( $args = '' ) {
	$defaults = array(
		'before'           => '<div class="pagination" id="post-pagination">' . __( '<p class="page-links-title">Pages:</p>', 'goblog' ),
		'after'            => '</div>',
		'text_before'      => '',
		'text_after'       => '',
		'next_or_number'   => 'number',
		'nextpagelink'     => __( 'Next page', 'goblog' ),
		'previouspagelink' => __( 'Previous page', 'goblog' ),
		'pagelink'         => '%',
		'echo'             => 1,
	);

	$r = wp_parse_args( $args, $defaults );
	$r = apply_filters( 'wp_link_pages_args', $r );
	extract( $r, EXTR_SKIP );

	global $page, $numpages, $multipage, $more, $pagenow;

	$output = '';
	if ( $multipage ) {
		if ( 'number' == $next_or_number ) {
			$output .= $before;
			for ( $i = 1; $i < ( $numpages + 1 ); $i = $i + 1 ) {
				$j       = str_replace( '%', $i, $pagelink );
				$output .= ' ';
				if ( $i != $page || ( ( ! $more ) && ( $page == 1 ) ) ) {
					$output .= _wp_link_page( $i );
				} else {
					$output .= '<span class="current current-post-page">';
				}

				$output .= $text_before . $j . $text_after;
				if ( $i != $page || ( ( ! $more ) && ( $page == 1 ) ) ) {
					$output .= '</a>';
				} else {
					$output .= '</span>';
				}
			}
			$output .= $after;
		} else {
			if ( $more ) {
				$output .= $before;
				$i       = $page - 1;
				if ( $i && $more ) {
					$output .= _wp_link_page( $i );
					$output .= $text_before . $previouspagelink . $text_after . '</a>';
				}
				$i = $page + 1;
				if ( $i <= $numpages && $more ) {
					$output .= _wp_link_page( $i );
					$output .= $text_before . $nextpagelink . $text_after . '</a>';
				}
				$output .= $after;
			}
		}
	}

	if ( $echo ) {
		echo $output;
	}

	return $output;
}