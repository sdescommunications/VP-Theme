<?php
/**
 * Template Name: Two Column
 **/
?>
<?php get_header('second'); the_post();?>
<div class="container">
	<?php if(is_page('SASI')){ ?>

		<h1><?php the_title();?></h1>
		<hr />
		<section>
			<aside>
				<?= do_shortcode( get_post_meta( $post->ID, 'page_sidecolumn', $single=true ) ); ?>
			</aside>
			<article>
				<?php the_content();?>

				<h2>News</h2>
				<hr />
				<?= News::toHTMLHOME('sasi') ?>
			</article>
			
		</section>

	<?php } else { ?>

		<h1><?php the_title();?></h1>
		<hr />
		<section>
			<aside>
				<?= do_shortcode( get_post_meta( $post->ID, 'page_sidecolumn', $single=true ) ); ?>
			</aside>
			<article>
				<?php the_content();?>
			</article>
			
		</section>

	<?php } ?>
	
</div>
<?php get_footer();?>