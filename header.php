<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		<?= str_replace(' | ', ' ', get_bloginfo('name')) ?> &bull; UCF
	</title>	

	<link rel="shortcut icon" href="http://it-dev.sdes.ucf.edu/testing/vp/images/favicon_black.png" />
	<link rel="apple-touch-icon" href="http://it-dev.sdes.ucf.edu/testing/vp/images/apple-touch-icon.png" />
	<link rel="stylesheet" href="http://it-dev.sdes.ucf.edu/testing/vp/scss/bootstrap.css" />
	<link rel="stylesheet" href="http://it-dev.sdes.ucf.edu/testing/vp/css/cards.css" media="screen" />

	<!--[if lt IE 10]>	
	<link rel="stylesheet" href="css/why.css" media="screen" />
	<![endif]-->	

	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" id="ucfhb-script" src="https://universityheader.ucf.edu/bar/js/university-header.js"></script>
	<script src="https://use.fontawesome.com/48342ef48c.js"></script>
	
	<script type="text/javascript" src="http://it-dev.sdes.ucf.edu/testing/vp/js/tether.min.js"></script>
	<script type="text/javascript" src="http://it-dev.sdes.ucf.edu/testing/vp/js/bootstrap.min.js"></script>	
	<script type="text/javascript" src="http://it-dev.sdes.ucf.edu/testing/vp/js/smoothscroll.js"></script>

	<!--[if lt IE 10]>
	<script type="text/javascript" src="js/modernizr-custom.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.1/html5shiv.js"></script>
	<![endif]-->

</head>
<body>
	<script>
		jQuery(function($) {
			$('.navbar .dropdown').hover(function() {
				$(this).find('.dropdown-menu').first().stop().fadeIn("fast");

			}, function() {
				$(this).find('.dropdown-menu').first().stop().fadeOut("fast");

			});

			$('.navbar .dropdown > a').click(function(){
				location.href = this.href;
			});

		});

		$(document).ready(function() {
			$("body").tooltip({ selector: '[data-toggle=tooltip]' });
		});			
	</script>
	<!-- header -->
	<header>
		<div class="skip text-center hidden-md-down" id="skpToContent">
			<a href="#content"><i class="fa fa-lg fa-chevron-down"><span class="sr-only">Skip to Content</span></i></a>
		</div>
		<div class="header-content">
			<div class="header-image">
				<video id="video" autoplay="" preload="auto" loop="" muted="" class="hidden-md-down">
					<!-- <source src="vid/video.webm" type="video/webm" /> -->
					<source src="http://assets.sdes.ucf.edu/video/003.mp4" type="video/mp4" />
					Your browser does not support the video tag. Please upgrade your browser.
				</video>
			</div>

			<div class="container">
				<section class="site-title">			
					<article>
						<a href="<?= site_url() ?>" class="float-left">
							<?= str_replace(' | ', '<br />', get_bloginfo('name')) ?>
							<hr />
						</a>							
					</article>
					<aside class="text-lg-right">
						<a class="btn btn-contact" href="#contact"><i class="fa fa-lg fa-comments-o"></i>&emsp;Contact Us</a>
						&emsp;
						<a class="translate" href="http://it.sdes.ucf.edu/translate/" data-toggle="tooltip" data-placement="right" title="Translate This Page!"><i class="fa fa-globe"></i></a>
					</aside>			
				</section>
			</div>
			<!-- navigation -->
			<nav class="navbar navbar-vp navbar-toggleable-md">
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<i class="fa falg fa-bars"></i>
				</button>
								
					<?= wp_nav_menu(array(
											'theme_location' => 'header-menu', 
											'menu_class' => 'navbar-nav',
											'container_class' => 'collapse navbar-collapse',
											'container_id' => 'navbarSupportedContent',
											'walker' => new Nav_Menu(),
										)) ?>
				
							
			</nav>
		</div>

		<?= do_shortcode( '[alert-list show_all="true"]' ); ?>

		<div class="callout hidden-md-down">
			<div class="container">
				<section class="card-deck">
					<?php
						for ($var = 0; ++$var <= 3; ) {
					?>
					<article class="card">
						<div class="card-block">
							<h4><?= get_post_meta($post->ID, "spotlight_title_".$var, true); ?></h4>
							<hr />
							<p>
								<?= get_post_meta($post->ID, "spotlight_content_".$var, true); ?>
							</p>
							<span class="float-right"><a href="<?= get_post_meta($post->ID, "spotlight_button_url".$var, true); ?>" class="btn btn-callout"><?= get_post_meta($post->ID, "spotlight_button_text".$var, true); ?></a></span>
						</div>
					</article>
					<?php } ?>
				</section>
			</div>

		</div>
		<div class="carousel-wrapper hidden-lg-up hidden-tiny" aria-hidden="true">

			<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">

				<div class="carousel-inner container" role="listbox">
					<?php
						for ($var = 0; ++$var <= 3; ) {
					?>
					<div class="carousel-item <?= ($var == 1)? "active" : null ?>">
						<div class="carousel-caption">
							<h3><?= get_post_meta($post->ID, "spotlight_title_".$var, true); ?></h3>
							<hr />
							<p>
								<?= get_post_meta($post->ID, "spotlight_content_".$var, true); ?>
							</p>
							<a href="<?= get_post_meta($post->ID, "spotlight_button_url".$var, true); ?>" class="btn btn-callout btn-lg btn-block"><?= get_post_meta($post->ID, "spotlight_button_text".$var, true); ?></a>
						</div>
					</div>
					<?php } ?>					
				</div>
				<ol class="carousel-indicators">
					<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
					<li data-target="#carousel-example-generic" data-slide-to="1"></li>
					<li data-target="#carousel-example-generic" data-slide-to="2"></li>
				</ol>
				<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
					<span class="icon-prev" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
					<span class="icon-next" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
			<br />
			<br />
		</div>
	</header>

	<!-- content area -->
	<div id="content" class="site-content home">