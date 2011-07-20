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
	    	get_stylesheet_directory_uri() . '/js/mylibs/selectivizr-1.0.2/selectivizr-min.js',
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

/**
 * Custom settings
 */
add_action( 'admin_menu', 'miseenplace_custom_settings' );
function miseenplace_custom_settings() {
	$custom_settings = array(
		'Street Address' 	=> 'street_address',
		'City'				=> 'city',
		'State'				=> 'state',
		'Zip Code'			=> 'zip_code',
		'Phone'				=> 'phone',
		'Fax'				=> 'fax',
		'Facebook Page'		=> 'facebook_url',
		'Twitter Profile'	=> 'twitter_url'
	);
	foreach ( $custom_settings as $name => $id ) {
		register_setting( 'general', $id );
		add_settings_field( 
			$id, 
			$name, 
			'custom_settings_callback',
			'general',
			'default',
			$id
		);
	}
}
function custom_settings_callback( $id ) {
	?><input type="text" 
		name="<?php echo $id; ?>" 
		id="<?php echo $id; ?>" 
		value="<?php echo get_option( $id ); ?>" 
		class="regular-text" /><?php
}

/**
 * Display subnav based on wp-generated css hooks
 *
 * TODO: make this a widget
 *
 */
function custom_subnav() {

	// check for a preselected menu item
	global $subnav_selected_item;
	$selected_class = $subnav_selected_item ? "menu-item-$subnav_selected_item" : false;
	
	$nav_menus = get_registered_nav_menus();
				
	foreach ( array_keys( $nav_menus ) as $nav_menu ) {
	
		$nav = wp_nav_menu( array( 'theme_location' => $nav_menu, 'echo' => false ) );
		
		$xml = simplexml_load_string( $nav );
		
		if ( ! empty( $xml->ul ) ) : foreach ( $xml->ul[0]->li as $menu_item ) :
		
			$menu_item_class = (string) $menu_item['class'];
			if ( ( strstr( $menu_item_class, 'current-menu-ancestor' )
				|| strstr( $menu_item_class, 'current-menu-item' )
				|| strstr( $menu_item_class, 'current-menu-parent' ) 
				|| strstr( $menu_item_class, $selected_class ) )
				&& ! empty( $menu_item->ul ) 
				&& strstr( (string) $menu_item->ul[0]['class'], 'sub-menu' ) ) {
					echo '<nav id="miseenplace-subnav">';
					echo '<h1>' . $menu_item->a->asXML() . '</h1>';
					echo $menu_item->ul->asXML();
					echo '</nav>';
					return;
			}
		
		endforeach; endif;
	}
}