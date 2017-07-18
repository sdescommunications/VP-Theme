<?php

function sc_contactblock ($atts) {
	extract(shortcode_atts(array(
		'contactname' => 'main',
		'f' => null,
		), $atts));
	$prefix = 'contact_';
	$args = array(
			'post_type' => array('contact'),
			'title' => $contactname,
		);

	// The Query
	$the_query = new WP_Query( $args );

	//die(var_dump($the_query));

	// The Loop
	if ( $the_query->have_posts() ) {
		
		$hours = get_post_meta( $the_query->post->ID, $prefix.'Hours', true );
		$phone = get_post_meta( $the_query->post->ID, $prefix.'phone', true );
		$fax = get_post_meta( $the_query->post->ID, $prefix.'fax', true );
		$email = get_post_meta( $the_query->post->ID, $prefix.'email', true );
		$building = get_post_meta( $the_query->post->ID, $prefix.'building', true );
		$room_number = get_post_meta( $the_query->post->ID, $prefix.'room', true );
		$map_id = get_post_meta( $the_query->post->ID, $prefix.'map_id', true );

		ob_start();

		if(empty($f)){
		?>
		<table class="table table-hover mt-3">
			<tbody>
				<?php if(!empty($hours)) { ?>
				<tr>
					<th scope="row"><i class="fa fa-lg fa-fw fa-clock-o"><span class="sr-only">Hours</span></i></th>
					<td><?= $hours ?></td>
				</tr>
				<?php } ?>
				<?php if(!empty($phone)) { ?>
				<tr>
					<th scope="row"><i class="fa fa-lg fa-fw fa-phone"><span class="sr-only">Phone</span></i></th>
					<td><a href="tel:<?= $phone ?>"><?= $phone ?></a></td>
				</tr>
				<?php } ?>
				<?php if(!empty($fax)) { ?>
				<tr>
					<th scope="row"><i class="fa fa-lg fa-fw fa-fax"><span class="sr-only">Fax</span></i></th>
					<td><?= $fax ?></td>
				</tr>
				<?php } ?>
				<?php if(!empty($email)) { ?>
				<tr>
					<th scope="row"><i class="fa fa-lg fa-fw fa-envelope"><span class="sr-only">Email</span></i></th>
					<td><a href="mailto:<?= $email ?>"><?= $email ?></a></td>
				</tr>
				<?php } ?>
				<?php if(!empty($building)) { ?>
				<tr>
					<th scope="row"><i class="fa fa-lg fa-fw fa-map-marker"><span class="sr-only">Location</span></i></th>
					<td><a href="http://map.ucf.edu/?show=<?= $map_id ?>" ><?= $building ?>, Room <?= $room_number ?></a></td>
				</tr>
				<?php } ?>				
			</tbody>
		</table>	
		
		<?php 
			return ob_get_clean();
		}else{
			echo (!empty($phone)) ? '<i class="fa fa-fw fa-phone"></i> <a href="tel:'.$phone.'">'.$phone.'</a><br />' : null;
			echo (!empty($email)) ? '<i class="fa fa-fw fa-envelope"></i> <a href="mailto:'.$email.'">'.$email.'</a><br />' : null;
			echo (!empty($building)) ? '<i class="fa fa-fw fa-map-marker"></i> <a href="http://map.ucf.edu/?show='.$map_id.'">'.$building.'</a><br />' : null;
		}

		
		
		/* Restore original Post Data */
		wp_reset_postdata();
	} else {
		return '<div class="alert alert-danger">Go to contact and add a contact named '.$contactname.'.</div>';
	}

}
add_shortcode('contactblock', 'sc_contactblock');

function sc_iframe ($atts) {
	extract(shortcode_atts(array(
		'if_url'=>"",
		'if_width'=>"",
		'if_height'=>"",
		), $atts));

	ob_start();
	?>

		<?php		
			if (strpos($if_url, 'youtube') !== false) {
		?>

			<iframe src="<?= $if_url ?>" width="<?= '$if_width' ?>" height="<?= $if_height ?>" frameborder="0" scrolling="no" allowfullscreen></iframe>

		<?php
			} else {
		?>
			<iframe src="<?= $if_url ?>" width="<?= '$if_width' ?>" height="<?= $if_height ?>" frameborder="0" scrolling="no" ></iframe>
			<?php
		}
	?>

	<?php
	return ob_get_clean();

}
add_shortcode('iframe', 'sc_iframe');

?>
