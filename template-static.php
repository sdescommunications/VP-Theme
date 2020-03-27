<?php
/**
 * Template Name: Static Billboard
 **/
?>
<?php get_header('static'); the_post();?>
<div class="container">	

	<h1><?php the_title();?></h1>
	<hr />
	<section>		
		<?php the_content();?>		
	</section>	
</div>
<?php get_footer();?>