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

		<iframe src="<?= $if_url ?>" width="<?= $if_width ?>" height="<?= $if_height ?>" frameborder="0" scrolling="no" allowfullscreen></iframe>

		<?php
	} else {
		?>
		<iframe src="<?= $if_url ?>" width="<?= $if_width ?>" height="<?= $if_height ?>" frameborder="0" scrolling="no" ></iframe>
		<?php
	}
	?>

	<?php
	return ob_get_clean();

}
add_shortcode('iframe', 'sc_iframe');

function sc_calendar($atts){
	extract(shortcode_atts(array(
		'cal_id'=>"",
		'action' => "",
		'count' => "",
		), $atts));

	$limit = $count;
	$url = 'https://events.ucf.edu/calendar/';
	$json = $url.$cal_id.'/sdes/'.$action.'/feed.json';   

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL, $json);
	$result = curl_exec($ch);
	curl_close($ch);

	$obj = json_decode($result);

	foreach ($obj as $field ) {
		if ($x++ < $limit) {

			$date = strtotime($field->starts);

			?>
			<div class="row event">
				<div class="col-sm-3 date">
					<div class="month"><?= date('M', $date) ?></div>
					<div class="day"><?= date('d', $date) ?></div>
				</div>
				<div class="col-sm-8 description">
					<h3 class="event-title"><a href="<?= $field->url ?>"><?= substr($field->title, 0, 17) ?> ...</a></h3>
					<h4 class="location"><a href="<?= $field->location_url ?>"><?= $field->location ?></a></h4>
				</div>
			</div>
			<?php

		}else{
			break;
		}		
	}

	?>

	<p>
		<a class="btn btn-callout float-right" href="<?= $url.$cal_id ?>/sdes/<?= $action ?>/">More Events</a>
	</p>

	<?php

}
add_shortcode('calendar', 'sc_calendar');

function sc_menu($atts){
	extract(shortcode_atts(array(
		'menu_name' => 'main',
		'header' => null
		), $atts));

	ob_start();
	?>

	<div class="menu">
		<div class="menu-header">
			<?= $header ?>
		</div>

		<?= wp_nav_menu(array(
			'menu' => $menu_name,
			'menu_class' => 'list-group list-unstyled menu-right', 
			'walker' => new Side_Menu(),
			)) ?>
		</div>

		<?php
		return ob_get_clean();
}
add_shortcode('menu', 'sc_menu');

function sc_redirect ($atts){
	extract(shortcode_atts(array(
		'url' => 'main',
	), $atts));

	ob_start();
	?>

	<p>Seems like you have JavaScript turned off please go to <a href="<?= $url ?>"><?= $url ?></a></p> 		
		
	<script type="text/javascript">
		window.location = "<?= $url ?>"
	</script>;

	<?php
		return ob_get_clean();

}
add_shortcode('redirect', 'sc_redirect');

function sc_caa(){
	$root = 'https://afia.ucf.edu'; // Marketing Prod
	$filename = $root . '/student-complaints-and-appeals/';

	// fetch file
	$opts = array(
			'http' => array(
				'method' => 'GET',
				'timeout' => '15'
			)
		);
	$context = stream_context_create( $opts );
	$feed = file_get_contents($filename, false, $context );

	
	if( $feed )
	{
		$json = json_decode($feed);

		if($title != $json->title) { 
			$title = $json->title;
		}

		//$data->site_css($json->stylesheet, 'screen');
		$content = $json->content;
	}
	else
	{
		$content = 'Could not load ' . $filename;
	}

	ob_start();
	?>

	<style type="text/css">
		.container .container{ padding: 0; }
	</style>

	<div class="row">
		<div class="col-md-10">
			<?= $content; ?>
		</div>
	</div>

	<?php
	return ob_get_clean();
}

add_shortcode('caa', 'sc_caa');

?>
