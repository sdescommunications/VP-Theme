<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?=
		(is_singular('news')) ? '<meta property="og:title" content="'.get_the_title(get_the_ID()).'" /> <meta property="og:url" content="'.get_permalink(get_the_ID()).'" /> <meta property="og:image" content="'.get_the_post_thumbnail_url(get_the_ID()).'"/>' : NULL ;
	?>
	<title>
		<?= 
			wp_title( '&raquo;', true, 'right' );
			echo " &bull; ";
			echo str_replace(' | ', ' ', get_bloginfo('name'));
		?> &bull; UCF
	</title>	

	<link rel="shortcut icon" href="<?= get_stylesheet_directory_uri() ?>/images/favicon_black.png" />
	<link rel="apple-touch-icon" href="<?= get_stylesheet_directory_uri() ?>/images/apple-touch-icon.png" />
	<link rel="stylesheet" href="<?= get_stylesheet_directory_uri() ?>/style.css" />

	<!--[if lt IE 10]>	
	<link rel="stylesheet" href="<?= get_stylesheet_directory_uri() ?>/css/why.css" media="screen" />
	<![endif]-->	

	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" id="ucfhb-script" src="//universityheader.ucf.edu/bar/js/university-header.js"></script>
	<script src="//use.fontawesome.com/48342ef48c.js"></script>
	
	<script type="text/javascript" src="<?= get_stylesheet_directory_uri() ?>/js/tether.min.js"></script>
	<script type="text/javascript" src="<?= get_stylesheet_directory_uri() ?>/js/bootstrap.min.js"></script>	

	<!--[if lt IE 10]>
	<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.1/html5shiv.js"></script>
	<![endif]-->

	<script type="text/javascript">

		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-6562360-10']);
		_gaq.push(['_trackPageview']);

		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();

	</script>
	
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
	<header>
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
					'theme_location' => 'header-menu',
					'menu_class' => 'navbar-nav',
					'container_class' => 'collapse navbar-collapse',
					'container_id' => 'navbarSupportedContent',
					'walker' => new Nav_Menu(),
					)) ?>
					
					
				</nav>
				<div class="header-break hidden-md-down">
					<img src="<?= get_stylesheet_directory_uri() ?>/images/breaker.jpg" class="img-fluid" />
				</div>
			</div>
		</div>
	</header>
	<!-- content area -->
	<div id="content" class="site-content">