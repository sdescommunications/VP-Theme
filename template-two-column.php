<?php
/**
 * Template Name: Two Column
 **/
?>
<?php get_header('second'); the_post();?>
<div class="container">	

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
	
</div>
<?php get_footer();?>