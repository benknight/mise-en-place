
	</div><!-- #main -->

	<footer id="colophon" role="contentinfo">
	
		<div class="container">
			<?php dynamic_sidebar( 'sidebar-footer' ); ?>
			
			<div id="site-generator">
				<p>Website made by <a href="http://benknight.me">Benjamin Knight</a> in Portland, Maine.</p>
			</div>
		</div>
		
	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_print_scripts( 'jquery' ); ?>
<script>window.jQuery || document.write('<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/libs/jquery-1.6.4.min.js"><\/script>')</script>

<?php wp_footer(); ?>
<?php wp_print_scripts( 'theme-plugins' ); ?>
<?php wp_print_scripts( 'theme-script' ); ?>
<!-- end scripts-->

<!-- google analytics -->
<script>
/* var _gaq=[["_setAccount","UA-XXXXX-X"],["_trackPageview"]];
(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
g.src=("https:"==location.protocol?"//ssl":"//www")+".google-analytics.com/ga.js";
s.parentNode.insertBefore(g,s)}(document,"script")); */
</script>

</body>
</html>