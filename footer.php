		</div><!-- eo .container -->
	</div><!-- eo #main -->
</div><!-- eo #page -->

<footer id="colophon" role="contentinfo">

	<div class="container">
		<?php dynamic_sidebar( 'sidebar-footer' ); ?>
		
		<div id="site-generator">
			<p>Website made by <a href="http://3c32.com">3c32</a> in Portland, Maine.</p>
		</div>
	</div>
	
</footer><!-- #colophon -->

</div><!-- eo #wrap -->

<!-- JavaScript at the bottom for fast page loading -->

<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if necessary -->
<?php wp_print_scripts( 'jquery' ); ?>
<script>window.jQuery || document.write('<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/libs/jquery-1.6.2.min.js"><\/script>')</script>

<?php wp_footer(); ?>

<?php wp_print_scripts( 'theme-plugins' ); ?>
<?php wp_print_scripts( 'theme-script' ); ?>
<!-- end scripts-->

<!--[if lt IE 7 ]>
<script src="js/libs/dd_belatedpng.js"></script>
<script>DD_belatedPNG.fix("img, .png_bg, .galleria-info"); // Fix any <img> or .png_bg bg-images. Also, please read goo.gl/mZiyb </script>
<![endif]-->

<!-- google analytics -->
<script>
	/* var _gaq=[["_setAccount","UA-XXXXX-X"],["_trackPageview"]];
	(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
	g.src=("https:"==location.protocol?"//ssl":"//www")+".google-analytics.com/ga.js";
	s.parentNode.insertBefore(g,s)}(document,"script")); */
</script>

</body>
</html>