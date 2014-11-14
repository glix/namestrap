<?php get_header(); ?>
<div class="container content_wrapper">
	<div class="row">
		<?php while ( have_posts() ) : the_post(); ?>
		<div class="col-xs-12">
			<div class="page-header site-header-wrapper box-wrapper-style">
				<div class="pull-left">
					<h2 class="site-font-color site-h2-heading"><?php the_title(); ?></h2>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="col-xs-12">
			<div class="content-container box-wrapper-style custom_box_wrapper">
				<?php the_content(); ?>
			</div>
		</div>
		<?php endwhile; // end of the loop. ?>
	</div>
</div>
<?php get_footer(); ?>