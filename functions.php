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

add_action( 'after_setup_theme', 'miseenplace_theme_setup' );
function miseenplace_theme_setup() {

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
	remove_filter( 'excerpt_more', 'twentyeleven_auto_excerpt_more' );
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
function miseenplace_page_menu_args( $args ) {
	$args['show_home'] = false;
	return $args;
}
add_filter( 'wp_page_menu_args', 'miseenplace_page_menu_args' );

/**
 * Default Dashboard settings
 */
add_action( 'user_register', 'miseenplace_dashboard_widgets' );
function miseenplace_dashboard_widgets( $user_id ) {
	update_user_meta( $user_id, 'metaboxhidden_dashboard', array(
		'dashboard_recent_comments',
		'dashboard_plugins',
		'dashboard_recent_drafts',
		'dashboard_primary',
		'dashboard_secondary',
		'dashboard_incoming_links',
		'dashboard_quick_press'
	));
	add_option( 'miseenplace_dashboard', 1 );
	// TODO: add page speed widget
}
if ( is_admin() && ! get_option( 'miseenplace_dashboard' ) ) {
	global $current_user;
	get_currentuserinfo();
	miseenplace_dashboard_widgets( $current_user->ID );
}

/**
 * Scripts & Styles
 * ( scripts loaded in footer for faster page loading )
 *
 */
add_action( 'init', 'miseenplace_scripts_and_styles' );
function miseenplace_scripts_and_styles() {

	if ( ! is_admin() ) {
		
		$theme_uri = get_stylesheet_directory_uri();

		// jquery
		wp_deregister_script( 'jquery' );
		wp_register_script(
			'jquery', 
			'http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js',
			array(),
			'1.6.4',
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
		
		// selectivizr
		wp_register_script(
			'selectivizr', 
			$theme_uri . '/js/libs/selectivizr-min.js',
			array(),
			'1.0.2',
			false
		);
						
		// galleria jquery plugin
		wp_register_script(
			'galleria', 
			$theme_uri . '/js/libs/galleria/galleria-1.2.4.min.js',
			array( 'jquery' ),
			'1.2.4',
			false
		);
		
		// jquery plugins
		wp_register_script(
			'theme-plugins', 
			$theme_uri . '/js/plugins.js',
			array( 'jquery' ),
			false,
			true
		);
		
		// script
		wp_register_script(
			'theme-script',
			$theme_uri . '/js/script.js',
			array( 'jquery', 'theme-plugins' ),
			false,
			true
		);
	}
}

/**
 * Register our sidebars and widgetized areas.
 */
add_action( 'widgets_init', 'miseenplace_widgets_init' );
function miseenplace_widgets_init() {

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
add_filter( 'post_class', 'miseenplace_post_class' );
function miseenplace_post_class( $classes ) {
	global $post;
	if ( has_post_thumbnail( $post->ID ) ) {
		$classes[] = 'has-thumbnail';
	}
	return $classes;
}

/**
 * Excerpts
 */
add_filter( 'excerpt_length', 'miseenplace_excerpt_length', 10 );
function miseenplace_excerpt_length( $length ) {
	return 40; // words
}

add_filter( 'excerpt_more', 'miseenplace_excerpt_more' );
function miseenplace_excerpt_more( $more ) {
	return '&hellip; <a href="'. esc_url( get_permalink() ) . '">Read more <span class="meta-nav">&rarr;</span></a>';
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
