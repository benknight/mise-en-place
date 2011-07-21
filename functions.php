<?php 

/**
 * Set the content width based on the theme's design and stylesheet.
 */
// $content_width = 600;

/**
 * Disable twentyeleven setup and define our own custom
 */
function twentyeleven_setup() { return false; }
function twentyeleven_get_theme_options() { return false; }
function disable_stuff() { return false; }

add_action( 'after_setup_theme', 'custom_theme_setup' );
function custom_theme_setup() {

	// plugins
	require 'plugins/breadcrumb-trail/breadcrumb-trail.php';
	require 'plugins/section-subnav.php';
	require 'plugins/posts-widget.php';

	// editor css
	add_editor_style();
	
	// nav menus
	register_nav_menu( 'primary', 'Primary Menu' );
	register_nav_menu( 'quicklinks', 'Quicklinks' );
	
	// theme features
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'status', 'quote', 'image' ) );
	add_theme_support( 'post-thumbnails' );
	
	// disable certain actions & filters
	remove_filter( 'wp_page_menu_args', 'twentyeleven_page_menu_args' );
	remove_action( 'widgets_init', 'twentyeleven_widgets_init' );
	remove_filter( 'excerpt_length', 'twentyeleven_excerpt_length' );
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_filter( 'body_class', 'twentyeleven_body_classes' );
	add_filter( 'index_rel_link', 'disable_stuff' );
	add_filter( 'parent_post_rel_link', 'disable_stuff' );
	add_filter( 'start_post_rel_link', 'disable_stuff' );
	add_filter( 'previous_post_rel_link', 'disable_stuff' );
	add_filter( 'next_post_rel_link', 'disable_stuff' );
	add_filter( 'post_comments_feed_link_html', 'disable_stuff' );
}

/**
 * wp_page_menu() args
 */
function custom_page_menu_args( $args ) {
	$args['show_home'] = false;
	return $args;
}
add_filter( 'wp_page_menu_args', 'custom_page_menu_args' );

/**
 * Default Dashboard settings
 */
add_action( 'user_register', 'custom_dashboard_widgets' );
function custom_dashboard_widgets( $user_id ) {
	update_user_meta( $user_id, 'metaboxhidden_dashboard', array(
		'dashboard_recent_comments',
		'dashboard_plugins',
		'dashboard_recent_drafts',
		'dashboard_primary',
		'dashboard_secondary',
		'dashboard_incoming_links',
		'dashboard_quick_press'
	));
	add_option( 'custom_dashboard', 1 );
	// TODO: add page speed widget
}
if ( is_admin() && ! get_option( 'custom_dashboard' ) ) {
	global $current_user;
	get_currentuserinfo();
	custom_dashboard_widgets( $current_user->ID );
}

/*
 * Scripts & Styles
 * ( scripts loaded in footer for faster page loading )
 *
 */
add_action( 'init', 'custom_scripts_and_styles' );
function custom_scripts_and_styles() {

	if ( ! is_admin() ) {
	
		// jquery
		wp_deregister_script( 'jquery' );
	    wp_register_script(
	    	'jquery', 
	    	'http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js',
	    	array(),
	    	'1.6.2',
	    	true
	    );
		
		// modernizr
	    wp_register_script(
	    	'modernizr', 
	    	'http://www.modernizr.com/downloads/modernizr-2.0.6.js',
	    	array(),
	    	'2.0.6',
	    	false
	    );
	    
	    // respondjs
	    wp_register_script(
	    	'respondjs', 
	    	get_stylesheet_directory_uri() . '/js/libs/respond.min.js',
	    	array(),
	    	false,
	    	false
	    );

		// selectivizr
	    wp_register_script(
	    	'selectivizr', 
	    	get_stylesheet_directory_uri() . '/js/mylibs/selectivizr-min.js',
	    	array(),
	    	'1.0.2',
	    	false
	    );
	    	    		
		// galleria jquery plugin
		wp_register_script(
			'galleria', 
			get_stylesheet_directory_uri() . '/js/mylibs/galleria/galleria-1.2.4.min.js',
			array( 'jquery' ),
			'1.2.4',
			false
		);
		
		// jquery plugins
		wp_register_script(
			'theme-plugins', 
			get_stylesheet_directory_uri() . '/js/plugins.js',
			array( 'jquery' ),
			false,
			true
		);
		
		// script
		wp_register_script(
			'theme-script',
			get_stylesheet_directory_uri() . '/js/script.js',
			array( 'jquery' ),
			false,
			true
		);
	}
}

/**
 * Register our sidebars and widgetized areas. Also register the default Epherma widget.
 *
 */
add_action( 'widgets_init', 'custom_widgets_init' );
function custom_widgets_init() {

	register_sidebar( array(
		'name' => 'Default Sidebar',
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));

	register_sidebar( array(
		'name' => 'Homepage Sidebar',
		'id' => 'sidebar-home',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	
	register_sidebar( array(
		'name' => 'Footer Sidebar',
		'id' => 'sidebar-footer',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
}

/**
 * Add 'has-thumbnail' class to posts with thumbnails
 */
add_filter( 'post_class', 'custom_post_class' );
function custom_post_class( $classes ) {
	global $post;
	if ( has_post_thumbnail( $post->ID ) ) {
		$classes[] = 'has-thumbnail';
	}
	return $classes;
}

/**
 * Excerpts
 */
add_filter( 'excerpt_length', 'custom_excerpt_length', 10 );
function custom_excerpt_length( $length ) {
	return 40; // words
}

add_filter( 'excerpt_more', 'custom_excerpt_more' );
function custom_excerpt_more( $more ) {
	global $post;
	return '&hellip;';
}

/**
 * Add 'archive' class to search results body
 */
add_filter( 'body_class', 'add_archive_to_search');
function add_archive_to_search( $classes ) {
	if ( is_search() ) {
		$classes[] = 'archive';
	}
	return $classes;
}

/**
 * Brand the admin
 */
add_action( 'login_head', 'project_admin_head' );
add_action( 'admin_head', 'project_admin_head' );
function project_admin_head() {
	?><style type="text/css">
		/* overwrite login logo */
		.login h1 a {
			background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/img/logo.png);
			height: 45px;
			opacity: 0.8;
		}
		#header-logo {
			background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/img/icon-32x32.gif);
			background-size: 16px 16px;
			opacity: 0.55;
		}
	</style><?php
}