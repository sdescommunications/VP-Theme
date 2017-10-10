<?php
/**
* Template Name: Concierge
*/

$image_url 	= has_post_thumbnail( $post->ID ) ?
wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID), 'full', false ) : null;

if ( $image_url ) {
	$image_url = $image_url[0];
}

$phone 		= get_post_meta( $post->ID, 'rep_phone', $single=true );
$email 		= get_post_meta( $post->ID, 'rep_email', $single=true );
$location 	= get_post_meta( $post->ID, 'rep_location', $single=true );

get_header('rep');
the_post();
?>
<script type="text/javascript">
	function search(){
	    var response = document.getElementById('url').value;
	    
	    if (response != '') {
	    	location = '//www.ucf.edu/services/?q=' + response;
	    }else{
	    	location = '//www.ucf.edu/services/';
	    }    
	}
</script>
<div class="container">
	<h1><?= the_title() ?></h1>
	<hr />
	<section>
		<aside>
			<img src="<?= $image_url ?>" class="img-fluid" alt="<?= the_title() ?>" >
			<table class="table table-hover mt-3">
				<tbody>
					<tr>
						<th scope="row"><i class="fa fa-lg fa-fw fa-phone"><span class="sr-only">Phone</span></i></th>
						<td><a href="tel:<?= $phone ?>"><?= $phone ?></a></td>
					</tr>
					<tr>
						<th scope="row"><i class="fa fa-lg fa-fw fa-envelope"><span class="sr-only">Email</span></i></th>
						<td><a href="mailto:<?= $email ?>"><?= $email ?></a></td>
					</tr>
					<tr>
						<th scope="row"><i class="fa fa-lg fa-fw fa-map-marker"><span class="sr-only">Location</span></i></th>
						<td><?= $location ?></td>
					</tr>
				</tbody>
			</table>
		</aside>
		<article>
			<?= the_content() ?>
		</article>
	</section>	
</div>
<?php
get_footer();