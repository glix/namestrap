<?php
	/*
		Template Name: Enquiry Page
	*/
?>
<?php get_header(); ?>
<div class="container content_wrapper">
	<div class="row">
		<?php 
			if(isset($_GET['d']) && !empty($_GET['d'])){
				$post = get_post($_GET['d'], ARRAY_A);
				$domain_name = "";
				if(!empty($post)){
					$domain_name = $post['post_title'];
				}
			}
		?>
		<script type="text/javascript">
			$(function(){
				var domain_name = '<?php echo $domain_name; ?>';
				if(domain_name != ""){
					$('input[name="domain-name"]').val(domain_name);
				}
			});
		</script>
		<?php while ( have_posts() ) : the_post(); ?>
		<div class="col-xs-12">
			<div class="page-header site-header-wrapper box-wrapper-style">
				<div class="pull-left">
					<h2 class="site-font-color site-h2-heading"><?php the_title(); ?></h2>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="col-xs-7">
			<div class="content-container enquiry_form box-wrapper-style">
				
					<?php the_content(); ?>
				
			</div>
		</div>
		<?php endwhile; // end of the loop. ?>
		<div class="col-xs-5 box-wrapper-style custom-col-5 no-padding">
			<ul class="widget-list">
				<?php dynamic_sidebar( 'sidebar-1' ); ?>
			</ul>
		</div>
	</div>
</div>
<?php get_footer(); ?>