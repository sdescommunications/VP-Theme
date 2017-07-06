<?php get_header('second'); the_post();

$image_url 	= has_post_thumbnail( $post->ID ) ?
wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID), 'full', false ) : null;

if ( $image_url ) {
	$image_url = $image_url[0];
}

//Department Fields
$dname		= get_post_meta( $post->ID, 'department_directorname', true);
$phone 		= get_post_meta( $post->ID, 'department_phone', true );
$fax 		= get_post_meta( $post->ID, 'department_fax', true );
$email 		= get_post_meta( $post->ID, 'department_email', true );
$loc 		= get_post_meta( $post->ID, 'department_loc', true );
$map 		= get_post_meta( $post->ID, 'department_map', true );
$purl 		= get_post_meta( $post->ID, 'department_primary_url', true );

//Programs, Teams, and Other Websites
$pto_text_1	= get_post_meta( $post->ID, 'department_text_1', true );
$pto_url_1	= get_post_meta( $post->ID, 'department_url_1', true );
$pto_text_2 = get_post_meta( $post->ID, 'department_text_2', true );
$pto_url_2 	= get_post_meta( $post->ID, 'department_url_2', true );
$pto_text_3 = get_post_meta( $post->ID, 'department_text_3', true );
$pto_url_3 	= get_post_meta( $post->ID, 'department_url_3', true );
$pto_text_4 = get_post_meta( $post->ID, 'department_text_4', true );
$pto_url_4 	= get_post_meta( $post->ID, 'department_url_4', true );
$pto_text_5 = get_post_meta( $post->ID, 'department_text_5', true );
$pto_url_5	= get_post_meta( $post->ID, 'department_url_5', true );

//Social Media
$fb 		= get_post_meta( $post->ID, 'dep_facebook', true );
$flickr 	= get_post_meta( $post->ID, 'dep_flickr', true );
$google 	= get_post_meta( $post->ID, 'dep_google', true );
$instagram 	= get_post_meta( $post->ID, 'dep_instagram', true );
$linkedin 	= get_post_meta( $post->ID, 'dep_linkedin', true );
$pinterest 	= get_post_meta( $post->ID, 'dep_pinterest', true );
$twitter 	= get_post_meta( $post->ID, 'dep_twitter', true );
$tumblr 	= get_post_meta( $post->ID, 'dep_tumblr', true );
$vimeo 		= get_post_meta( $post->ID, 'dep_vimeo', true );
$youtube 	= get_post_meta( $post->ID, 'dep_youtube', true );

?>

<div id="content" class="site-content">
	<div class="container">
		<h1><?= get_the_title() ?></h1>
		<hr>
		<section>
			<aside>
				<?php if(!empty($image_url)){ ?>
				<img src="<?= $image_url ?>" class="img-fluid">
				<?php } ?>
				<div class="menu mt-3">
					<div class="menu-header">Contact</div>
					<table class="table table-hover mt-3">
						<tbody>
							<?php if(!empty($phone)){ ?>
							<tr>
								<th scope="row"><i class="fa fa-lg fa-fw fa-phone"><span class="sr-only">Phone</span></i></th>
								<td><?= $phone ?></td>
							</tr>
							<?php  } ?>
							<?php if(!empty($fax)){ ?>
							<tr>
								<th scope="row"><i class="fa fa-lg fa-fw fa-fax"><span class="sr-only">Fax</span></i></th>
								<td><?= $fax ?></td>
							</tr>
							<?php  } ?>
							<?php if(!empty($email)){ ?>
							<tr>
								<th scope="row"><i class="fa fa-lg fa-fw fa-envelope"><span class="sr-only">Email</span></i></th>
								<td><a href="mailto:<?= $email ?>"><?= $email ?></a></td>
							</tr>
							<?php  } ?>
							<?php if(!empty($map) && !empty($loc)){ ?>
							<tr>
								<th scope="row"><i class="fa fa-lg fa-fw fa-map-marker"><span class="sr-only">Location</span></i></th>
								<td><a href="<?= $map ?>"><?= $loc ?></a></td>
							</tr>
							<?php  } ?>
							<?php if(!empty($purl)){ ?>
							<tr>
								<th scope="row"><i class="fa fa-lg fa-fw fa-link"><span class="sr-only">Website</span></i></th>
								<td><a href="<?= $purl ?>"><?= $purl ?></a></td>
							</tr>
							<?php  } ?>
						</tbody>
					</table>
				</div>
			</aside>
			<article>
				<h2 class="muted"><?= $dname ?></h2>
				<p>
					<?php if(!empty($purl)){ ?>
						<?= the_content() ?>
					<?php } ?>
				</p>
				<?php if(!empty($pto_url_1) && !empty($pto_text_1)){ ?>
					<h3>Programs, Teams, and Other Websites</h3>
					<hr>
				<?php } ?>
				
				<table class="table table-hover mt-3">
					<tbody>
						<?php if(!empty($pto_url_1) && !empty($pto_text_1)){ ?>
						<tr>
							<th scope="row" width="50px"><i class="fa fa-lg fa-fw fa-link"><span class="sr-only">Link</span></i></th>
							<td><a href="<?= $pto_url_1 ?>"><?= $pto_text_1 ?></a></td>
						</tr>
						<?php  } ?>
						<?php if(!empty($pto_url_2) && !empty($pto_text_2)){ ?>
						<tr>
							<th scope="row" width="50px"><i class="fa fa-lg fa-fw fa-link"><span class="sr-only">Link</span></i></th>
							<td><a href="<?= $pto_url_2 ?>"><?= $pto_text_2 ?></a></td>
						</tr>
						<?php  } ?>
						<?php if(!empty($pto_url_3) && !empty($pto_text_3)){ ?>
						<tr>
							<th scope="row" width="50px"><i class="fa fa-lg fa-fw fa-link"><span class="sr-only">Link</span></i></th>
							<td><a href="<?= $pto_url_3 ?>"><?= $pto_text_3 ?></a></td>
						</tr>
						<?php  } ?>
						<?php if(!empty($pto_url_4) && !empty($pto_text_4)){ ?>
						<tr>
							<th scope="row" width="50px"><i class="fa fa-lg fa-fw fa-link"><span class="sr-only">Link</span></i></th>
							<td><a href="<?= $pto_url_4 ?>"><?= $pto_text_4 ?></a></td>
						</tr>
						<?php  } ?>
						<?php if(!empty($pto_url_5) && !empty($pto_text_5)){ ?>
						<tr>
							<th scope="row" width="50px"><i class="fa fa-lg fa-fw fa-link"><span class="sr-only">Link</span></i></th>
							<td><a href="<?= $pto_url_5 ?>"><?= $pto_text_5 ?></a></td>
						</tr>
						<?php  } ?>
					</tbody>
				</table>
				<?php if(!empty($fb)){ ?>
					<h3>Social Media</h3>
					<hr>
				<?php } ?>
				<table class="table table-hover mt-3">
					<tbody>
						<?php if(!empty($fb)){ ?>
						<tr>
							<th scope="row" width="50px"><i class="fa fa-lg fa-fw fa-facebook-official"><span class="sr-only">Facebook</span></i></th>
							<td><a href="<?= $fb ?>">Facebook</a></td>
						</tr>
						<?php  } ?>
						<?php if(!empty($flickr)){ ?>
						<tr>
							<th scope="row" width="50px"><i class="fa fa-lg fa-fw fa-flickr"><span class="sr-only">Instagram</span></i></th>
							<td><a href="<?= $flickr ?>">Flickr</a></td>
						</tr>
						<?php  } ?>
						<?php if(!empty($google)){ ?>
						<tr>
							<th scope="row" width="50px"><i class="fa fa-lg fa-fw fa-google"><span class="sr-only">Instagram</span></i></th>
							<td><a href="<?= $google ?>">Google+</a></td>
						</tr>
						<?php  } ?>
						<?php if(!empty($instagram)){ ?>
						<tr>
							<th scope="row" width="50px"><i class="fa fa-lg fa-fw fa-instagram"><span class="sr-only">Instagram</span></i></th>
							<td><a href="<?= $instagram ?>">Instagram</a></td>
						</tr>
						<?php  } ?>
						<?php if(!empty($linkedin)){ ?>
						<tr>
							<th scope="row" width="50px"><i class="fa fa-lg fa-fw fa-linkedin"><span class="sr-only">Instagram</span></i></th>
							<td><a href="<?= $linkedin ?>">Linkedin</a></td>
						</tr>
						<?php  } ?>
						<?php if(!empty($pinterest)){ ?>
						<tr>
							<th scope="row" width="50px"><i class="fa fa-lg fa-fw fa-pinterest"><span class="sr-only">Instagram</span></i></th>
							<td><a href="<?= $pinterest ?>">Pinterest</a></td>
						</tr>
						<?php  } ?>
						<?php if(!empty($twitter)){ ?>
						<tr>
							<th scope="row" width="50px"><i class="fa fa-lg fa-fw fa-twitter"><span class="sr-only">Twitter</span></i></th>
							<td><a href="<?= $twitter ?>">Twitter</a></td>
						</tr>
						<?php  } ?>
						<?php if(!empty($tumblr)){ ?>
						<tr>
							<th scope="tumblr" width="50px"><i class="fa fa-lg fa-fw fa-tumblr"><span class="sr-only">Instagram</span></i></th>
							<td><a href="<?= $tumblr ?>">Tumblr</a></td>
						</tr>
						<?php  } ?>
						<?php if(!empty($vimeo)){ ?>
						<tr>
							<th scope="row" width="50px"><i class="fa fa-lg fa-fw fa-vimeo"><span class="sr-only">Instagram</span></i></th>
							<td><a href="<?= $vimeo ?>">Vimeo</a></td>
						</tr>
						<?php  } ?>
						<?php if(!empty($youtube)){ ?>
						<tr>
							<th scope="row" width="50px"><i class="fa fa-lg fa-fw fa-youtube"><span class="sr-only">Youtube</span></i></th>
							<td><a href="<?= $youtube ?>">YouTube</a></td>
						</tr>
						<?php  } ?>
					</tbody>
				</table>
			</article>
		</section>
	</div>
</div>

<?php get_footer();?>