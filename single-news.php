<?php
	get_header('second'); the_post();

	$image_url 	= has_post_thumbnail( $post->ID ) ?
	wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID), 'full', false ) : null;

	if ( $image_url ) {
			$image_url = $image_url[0];
		}else{
			$image_url = get_stylesheet_directory_uri() . '/images/blank.png';
		}

	$url		= get_post_meta( $post->ID, 'news_url', true);
	$strapline 	= get_post_meta( $post->ID, 'news_strapline', true );
?>
<div class="container">
	<h1>
		<?php
			if(!empty($url)){
			 	echo '<a href="' . $url . '">'. get_the_title() . '</a>';
			 } else{
			 	echo get_the_title();
			 }
		 ?>
	</h1>
	<hr>
	<section>
		<article class="full-width">
			<div class="news">
				<img src="<?= $image_url ?>" class="img-fluid">
				<div class="news-content">
					<h3 class="news-strapline"><?= $strapline ?></h3>
					<p class="datestamp">Posted <?= get_the_date( 'l, F j, Y @ g:i A', $object->post->ID ) ?></p>
					<p>
						<?= the_content() ?>
					</p>
				</div>
				<div>
					<?php include_once 'social-news.php'; ?>
				</div>
			</div>
			<a class="btn btn-callout float-right mt-3" href="<?= wp_get_referer() ?>">&lt; Back to News</a>
		</article>
	</section>
</div>
<?php get_footer(); ?>
