<?php

function rep_meta_box_markup($object){	
	wp_nonce_field(basename(__FILE__), "meta-box-nonce");
	?>

	<table class="form-table">
		<tbody>
			<tr>
				<th>		
					<label class="block" for="<?= 'rep_title' ?>">Rep Title</label>
				</th>
				<td>
					<input type="text" id="<?= 'rep_title' ?>" name="<?= 'rep_title' ?>" value="<?= get_post_meta($object->ID, "rep_title", true) ?>">
				</td>
			</tr>
			<tr>
				<th>		
					<label class="block" for="<?= 'rep_phone' ?>">Rep Phone</label>
				</th>
				<td>
					<input type="text" id="<?= 'rep_phone' ?>" name="<?= 'rep_phone' ?>" value="<?= get_post_meta($object->ID, "rep_phone", true) ?>">
				</td>
			</tr>
			<tr>
				<th>		
					<label class="block" for="<?= 'rep_email' ?>">Rep Email</label>
				</th>
				<td>
					<input type="text" id="<?= 'rep_email' ?>" name="<?= 'rep_email' ?>" value="<?= get_post_meta($object->ID, "rep_email", true) ?>">
				</td>
			</tr>
			<tr>
				<th>		
					<label class="block" for="<?= 'rep_location' ?>">Rep Location</label>
				</th>
				<td>
					<input type="text" id="<?= 'rep_location' ?>" name="<?= 'rep_location' ?>" value="<?= get_post_meta($object->ID, "rep_location", true) ?>">&emsp;(ex: Millican Hall 161)
				</td>
			</tr>
		</tbody>
	</table>

	<?php
}

function add_rep_metabox(){
	add_meta_box("rep-meta-box", "Rep Title", "rep_meta_box_markup", "page", "normal", "high", null);
}

add_action("add_meta_boxes", "add_rep_metabox");

function save_rep_meta_box($post_id, $post, $update)
	{
	    if (!isset($_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], basename(__FILE__)))
	        return $post_id;

	    if(!current_user_can("edit_post", $post_id))
	        return $post_id;

	    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
	        return $post_id;
	    

	    update_post_meta($post_id, "rep_title", $_POST["rep_title"]);
	    update_post_meta($post_id, "rep_phone", $_POST["rep_phone"]);
	    update_post_meta($post_id, "rep_email", $_POST["rep_email"]);
	    update_post_meta($post_id, "rep_location", $_POST["rep_location"]);
	   
	}

add_action("save_post", "save_rep_meta_box", 10, 3);


?>