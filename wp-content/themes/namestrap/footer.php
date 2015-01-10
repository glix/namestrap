	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="container">
			<div class="row">
				<div class="col-xs-6 col-sm-3"> 
					<?php  dynamic_sidebar( 'Footer Column 1' ); ?>
				</div>
				<div class="col-xs-6 col-sm-3"> 
					<?php  dynamic_sidebar( 'Footer Column 2' ); ?>
				</div>
				<div class="col-xs-6 col-sm-3"> 
					<?php  dynamic_sidebar( 'Footer Column 3' ); ?>
				</div>
				<div class="col-xs-6 col-sm-3"> 
					<?php  dynamic_sidebar( 'Footer Column 4' ); ?>
				</div>
			</div>
		</div>		
	</footer><!-- #colophon -->
	<div id="footer-bottom">
		<div class="container">
			<div class="row">
				<div class="copyright col-xs-12 col-sm-6">
					<?php printf( __( 'Copyright Namestrap. All rights are reserved. Designed by' )); ?>
					<a href="<?php echo esc_url( __( 'http://www.dannyglix.com/', 'namestrap' ) ); ?>"><?php printf( __( 'DannyGlix' )); ?></a> 
				</div>
				<ul class="footer-menu col-xs-12 col-sm-6">
					<li class=""><?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="ajax_load_wrapper" style="display:none;">
		<img src="<?php echo get_bloginfo('template_directory'); ?>/img/loadingAnimation.gif" alt="loading..">
	</div>
	<script type="text/javascript">
		$(function(){
			$('.ajax_load_wrapper').css('height',($(document).height()-178));
		});
	</script>
	<script type="text/javascript">
		$(function(){
			$("#bs-example-navbar-collapse-1 #menu-item-856 a").addClass("fancybox fancybox.iframe");
		});
	</script>
	<?php wp_footer(); ?>
</body>
</html>