<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( 'Page %s', max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" href="<?php bloginfo( 'template_directory' ); ?>/style.css" />
<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php wp_head(); ?>
<!-- scripts -->
<?php wp_print_scripts( 'modernizr' ); ?>
<!--[if lt IE 9]>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
<?php wp_print_scripts( 'selectivizr' ); ?>
<![endif]-->

<?php if ( defined( 'TYPEKIT_ID' ) ) : ?>
<!-- typekit -->
<script src="http://use.typekit.com/<?php echo TYPEKIT_ID; ?>.js"></script>
<script>try{Typekit.load();}catch(e){}</script>
<?php endif; ?>

</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed container">
	<header id="branding" role="banner">
			<hgroup>
				<h1 id="site-title">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
						<?php bloginfo( 'name' ); ?>
					</a>	
				</h1>
				<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
			</hgroup>

			<?php get_search_form(); ?>

			<nav id="access" role="navigation">
				<h3 class="assistive-text">Main menu</h3>
				<?php /*  Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff. */ ?>
				<div class="skip-link">
					<a class="assistive-text" href="#content" title="Skip to primary content">
						Skip to primary content
					</a>
				</div>
				<div class="skip-link">
					<a class="assistive-text" href="#secondary" title="Skip to secondary content">
						Skip to secondary content
					</a>
				</div>
				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
			</nav><!-- #access -->
	</header><!-- #branding -->

	<div id="main">
