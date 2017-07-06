<?php
/**
 * Template Name: One Column
 **/
?>
<?php get_header('second');

if ( have_posts() ) {
	while ( have_posts() ) {
		the_post(); 
		?>
		<div class="container">

			<?php if(is_page('Departments')){ ?>

			<h1><?php the_title();?></h1>
			<hr />

			<section>
				<aside>
					<?= Department::toHTMLMENU(); ?>
				</aside>
				<article>
					<?= Department::toHTML(); ?>
				</article>
			</section>

			<?php } elseif (is_page('News')){ ?>

				<h1><?php the_title();?></h1>
				<hr />

				<section>
					<aside>
						<?= News::toHTMLMENU(); ?>
					</aside>
					<article>
						<?= News::toHTMLFULL(); ?>
					</article>
				</section>

			<?php }else{ ?>
			<h1><?php the_title();?></h1>
			<hr />
			<section>		
				<article class="full-width">
					<?php the_content();?>
				</article>

			</section>
			<?php } ?>

		</div>
		<?php
	} // end while
} // end if

?>


<?php get_footer();?>