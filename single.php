<?php disallow_direct_load('single.php');?>
<?php get_header('second'); the_post();?>

<section class="container" id="<?=$post->post_name?>">

	<article class="full-width">
		<? if(!is_front_page())	{ ?>
		<h1><?php the_title();?></h1>
		<? } ?>
		<?php the_content();?>
	</article>

</section>

<?php get_footer();?>