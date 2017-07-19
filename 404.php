<?php @header("HTTP/1.1 404 Not found", true, 404);?>
<?php disallow_direct_load('404.php');?>

<?php get_header('second'); the_post();?>
<section class="container" id="page-not-found">		
<article class="full-width">
		<h1>Page Not Found</h1>
		<?php 
		$page = get_page_by_title('404');
		if($page){
			$content = $page->post_content;
			$content = apply_filters('the_content', $content);
			$content = str_replace(']]>', ']]>', $content);
		}
		?>
		<?php if($content):?>
			<?=$content?>
		<?php else:?>
			<p>The page you requested doesn't exist.  Sorry about that.</p>
		<?php endif;?>
	</article>		
</section>

<?php get_footer();?>