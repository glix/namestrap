<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>
		<?php bloginfo('name'); ?> 
		<?php //(is_home()) ? bloginfo('description') : wp_title(''); ?>
		<?php
			if(is_home()){
				bloginfo('description');
			}elseif(isset($_GET['paged'])){
				echo '';
			}else{
				wp_title('');
			}
		?>
	</title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo get_bloginfo('template_directory'); ?>/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo get_bloginfo('template_directory'); ?>/css/bootstrap-theme.min.css" />
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="<?php echo get_bloginfo('template_directory'); ?>/css/slider.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo get_bloginfo('template_directory'); ?>/css/select2.css" />
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" />

	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="<?php echo get_bloginfo('template_directory'); ?>/js/bootstrap.js"></script>
	<script type="text/javascript" src="<?php echo get_bloginfo('template_directory'); ?>/js/bootstrap-slider.js"></script>
	<script type="text/javascript" src="<?php echo get_bloginfo('template_directory'); ?>/js/select2.min.js"></script>

		<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
	<style type="text/css">
		html{
			margin: 0px;
		}
	</style>
</head>
<body <?php body_class(); ?>>
	<header>
		<div class="container">
			<div class="row">
				<div class="col-xs-4 col-sm-4">
					<div class="logo">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
							<img src="<?php bloginfo('template_directory'); ?>/img/logo.png" alt="Namestarp">
						</a>
					</div>
				</div>
				<div class="col-xs-8 col-sm-8">
					<nav class="navbar" role="navigation">
					  <div class="container-fluid">
					    <!-- Brand and toggle get grouped for better mobile display -->
					    <div class="navbar-header">
					      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					        <span class="sr-only">Toggle navigation</span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
					      </button> 
					    </div>

					  
					    <!-- Collect the nav links, forms, and other content for toggling -->
					    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					      <ul class="nav navbar-nav">
					        <li class=""><?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?></li>
					      </ul>
					    </div><!-- /.navbar-collapse -->
					  </div><!-- /.container-fluid -->
					</nav>
					
				</div>
			</div>
		</div>
	</header>