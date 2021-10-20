<?php
/**
 * Stackable functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Stackable
 */

if ( ! function_exists( 'stackable_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function stackable_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Stackable, use a find and replace
	 * to change 'stackable' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'stackable', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 2000, 1500, true );

	// Enable support for custom logo.
	add_theme_support( 'custom-logo', array(
		'height'      => 240,
		'width'       => 240,
		'flex-height' => true,
	) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'stackable' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'stackable_custom_background_args', array(
		'default-color'    => 'ffffff',
		'default-image'    => '',
	) ) );

	/**
	 * Add support for Eventbrite.
	 * See: https://wordpress.org/plugins/eventbrite-api/
	 */
	add_theme_support( 'eventbrite' );

	/**
	 * Add support for WooCommerce.
	 */
	add_theme_support( 'woocommerce' );
}
endif;
add_action( 'after_setup_theme', 'stackable_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function stackable_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'stackable_content_width', 900 );
}
add_action( 'after_setup_theme', 'stackable_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function stackable_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'stackable' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget widget-small %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Top Footer', 'stackable' ),
		'id'            => 'sidebar-2',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Bottom Footer', 'stackable' ),
		'id'            => 'sidebar-3',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget widget-small %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'stackable_widgets_init' );

if ( ! function_exists( 'stackable_fonts_url' ) ) :
/**
 * Register Google fonts for Stackable.
 *
 * Create your own stackable_fonts_url() function to override in a child theme.
 *
 * @return string Google fonts URL for the theme.
 */
function stackable_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/* translators: If there are characters in your language that are not supported by Poppins, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== esc_html_x( 'on', 'Poppins font: on or off', 'stackable' ) ) {
		$fonts[] = 'Poppins:400,700';
	}

	/* translators: If there are characters in your language that are not supported by Lato, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== esc_html_x( 'on', 'Lato font: on or off', 'stackable' ) ) {
		$fonts[] = 'Lato:400,700,400italic,700italic';
	}

	/* translators: If there are characters in your language that are not supported by Inconsolata, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== esc_html_x( 'on', 'Inconsolata font: on or off', 'stackable' ) ) {
		$fonts[] = 'Inconsolata:400,700';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;

/**
 * Enqueue scripts and styles.
 */
function stackable_scripts() {
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.4.1' );

	wp_enqueue_style( 'stackable-fonts', stackable_fonts_url(), array(), null );

	wp_enqueue_style( 'stackable-style', get_stylesheet_uri() );

	wp_enqueue_script( 'stackable-back-top', get_template_directory_uri() . '/js/back-top.js', array(), '20120206', true );

	wp_enqueue_script( 'stackable-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	wp_enqueue_script( 'stackable-navigation', get_template_directory_uri() . '/js/navigation.js', array( 'jquery' ), '20151231', true );

	if ( get_theme_mod( 'stackable_sticky_header' ) ) {
		wp_enqueue_script( 'stackable-header', get_template_directory_uri() . '/js/header.js', array(), '20130115', true );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_localize_script( 'stackable-back-top', 'stackableButtonTitle', array(
		'desc' => esc_html__( 'Back to top', 'stackable' ),
	) );

	wp_localize_script( 'stackable-navigation', 'stackableScreenReaderText', array(
		'expand'   => esc_html__( 'expand child menu', 'stackable' ),
		'collapse' => esc_html__( 'collapse child menu', 'stackable' ),
	) );
}
add_action( 'wp_enqueue_scripts', 'stackable_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require( get_template_directory() . '/inc/woocommerce.php' );
}

// Add Stackable specific code.
require get_template_directory() . '/stackable.php';
require get_template_directory() . '/stackable-customizer.php';
require get_template_directory() . '/stackable-editor.php';