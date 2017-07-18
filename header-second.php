<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= wp_title( '&raquo;', true, 'right' ); bloginfo( 'name' ); ?> - UCF</title>	

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

	<div class="header-content">
		<div class="skip text-center hidden-xs-up" id="skpToContent">
			<a href="#content"><i class="fa fa-lg fa-chevron-down"><span class="sr-only">Skip to Content</span></i></a>
		</div>
		<div class="container">
			<section class="site-title">			
				<article>
					<a href="<?= site_url() ?>" class="float-left"><?= str_replace(' | ', '<br />', get_bloginfo('name')) ?><hr /></a>							
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
				'menu' => 'header-menu', 
				'menu_class' => 'navbar-nav',
				'container_class' => 'collapse navbar-collapse',
				'container_id' => 'navbarSupportedContent',
				'walker' => new Nav_Menu(),
				)) ?>
				
				
			</nav>
			<div class="header-break">
				<img src="http://it-dev.sdes.ucf.edu/testing/vp/images/breaker.jpg" class="img-fluid" />
			</div>
		</div>
	</div>

	<!-- content area -->
	<div id="content" class="site-content">