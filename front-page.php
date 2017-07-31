<?php get_header();?>
<div class="container">
			<h1><?= get_the_title() ?></h1>
			<hr />

			<section>
				<aside>
					<?= do_shortcode( get_post_meta( $post->ID, 'page_sidecolumn', $single=true ) ); ?>
				</aside>
				<article>
					<?php if (have_posts()) :
						while (have_posts()) : the_post();
						the_content();
						endwhile;
						else:
							
						endif; 
					?>
				</article>
			</section>
		</div>
		<div class="yellow">
			<div class="container">
				<div class="row">
					<div class="col-lg-4 col-md-12">

						<div class="menu menu-left">
							<div class="menu-header">
								Other Resources
							</div>
							
							<?= wp_nav_menu(array(
								'theme_location' => 'home-resource-menu',
								'menu_class' => 'list-group list-unstyled', 
								'walker' => new Side_Menu(),
							)) ?>
						</div>

					</div>
					<div class="col-lg-8 col-md-12">
						<h2>In the News</h2>
						<hr />
						<?= News::toHTMLHOME('home') ?>
					</div>
				</div>
			</div>
		</div>
<?php get_footer();?>