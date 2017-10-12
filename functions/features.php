<?php

function add_metabox_department_sites(){
	add_meta_box(
		'metabox_sites',
		'Programs, Teams, and Other Websites',
		'show_meta_dep_sites',
		'department'
		);
}
add_action('add_meta_boxes', 'add_metabox_department_sites');

function show_meta_dep_sites() {
	global $post;

    // Use nonce for verification to secure data sending
	wp_nonce_field( basename( __FILE__ ), 'department_nonce' );

	?>

	<!-- my custom value input -->
	<p>
		A website for an event, program, initiative, or team that is owned by the department.
	</p>
	<table class="form-table">
		<tbody>
			<?php
				for ($var = 0; ++$var <= 5; ) {
			?>

				<tr>
					<th>
						<label for="department_text_<?= $var ?>" class="block">Related Site <?= $var ?> Title</label>
					</th>
					<td>
						<input id="department_text_<?= $var ?>" type="text" name="department_text_<?= $var ?>" value="<?= get_post_meta($post->ID, "department_text_".$var, true); ?>">
					</td>
				</tr>
				<tr>
					<th>
						<label for="department_url_<?= $var ?>" class="block">Related Site <?= $var ?> URL</label>
					</th>
					<td>
						<input id="department_url_<?= $var ?>" type="text" name="department_url_<?= $var ?>" value="<?= get_post_meta($post->ID, "department_url_".$var, true); ?>">
					</td>
				</tr>
				<tr>
					<td colspan="2"></td>
				</tr>
			<?php
				}
			?>
			
		</tbody>
	</table>
	<br />
	<hr />

	<?php
}

function add_metabox_department_social(){
	add_meta_box(
		'metabox_social',
		'Social Media',	
		'show_meta_dep_social',
		'department'
		);
}
add_action('add_meta_boxes', 'add_metabox_department_social');

function show_meta_dep_social() {
	global $post;

    // Use nonce for verification to secure data sending
	wp_nonce_field( basename( __FILE__ ), 'department_nonce' );

	?>

	<!-- my custom value input -->
	<table class="form-table">
		<tbody>
			<tr>
				<th>
					<label for="dep_facebook" class="block">
						Facebook
					</label>
				</th>
				<td>
					<input id="dep_facebook" type="text" name="dep_facebook" value="<?= get_post_meta($post->ID, "dep_facebook", true); ?>">
				</td>
			</tr>
			<tr>
				<th>
					<label for="dep_flickr" class="block">
						Flickr
					</label>
				</th>
				<td>
					<input id="dep_flickr" type="text" name="dep_flickr" value="<?= get_post_meta($post->ID, "dep_flickr", true); ?>">
				</td>
			</tr>
			<tr>
				<th>
					<label for="dep_google" class="block">
						Google+
					</label>
				</th>
				<td>
					<input id="dep_google" type="text" name="dep_google" value="<?= get_post_meta($post->ID, "dep_google", true); ?>">
				</td>
			</tr>
			<tr>
				<th>
					<label for="dep_instagram" class="block">
						Instagram
					</label>
				</th>
				<td>
					<input id="dep_instagram" type="text" name="dep_instagram" value="<?= get_post_meta($post->ID, "dep_instagram", true); ?>">
				</td>
			</tr>
			<tr>
				<th>
					<label for="dep_linkedin" class="block">
						Linkedin
					</label>
				</th>
				<td>
					<input id="dep_linkedin" type="text" name="dep_linkedin" value="<?= get_post_meta($post->ID, "dep_linkedin", true); ?>">
				</td>
			</tr>
			<tr>
				<th>
					<label for="dep_pinterest" class="block">
						Pinterest
					</label>
				</th>
				<td>
					<input id="dep_pinterest" type="text" name="dep_pinterest" value="<?= get_post_meta($post->ID, "dep_pinterest", true); ?>">
				</td>
			</tr>
			<tr>
				<th>
					<label for="dep_twitter" class="block">
						Twitter
					</label>
				</th>
				<td>
					<input id="dep_twitter" type="text" name="dep_twitter" value="<?= get_post_meta($post->ID, "dep_twitter", true); ?>">
				</td>
			</tr>
			<tr>
				<th>
					<label for="dep_tumblr" class="block">
						Tumblr
					</label>
				</th>
				<td>
					<input id="dep_tumblr" type="text" name="dep_tumblr" value="<?= get_post_meta($post->ID, "dep_tumblr", true); ?>">
				</td>
			</tr>
			<tr>
				<th>
					<label for="dep_vimeo" class="block">
						Vimeo
					</label>
				</th>
				<td>
					<input id="dep_vimeo" type="text" name="dep_vimeo" value="<?= get_post_meta($post->ID, "dep_vimeo", true); ?>">
				</td>
			</tr>
			<tr>
				<th>
					<label for="dep_youtube" class="block">
						YouTube
					</label>
				</th>
				<td>
					<input id="dep_youtube" type="text" name="dep_youtube" value="<?= get_post_meta($post->ID, "dep_youtube", true); ?>">
				</td>
			</tr>
		</tbody>
	</table>

    <?php
}

function department_save_meta_fields( $post_id ) {

	if (!isset($_POST["department_nonce"]) || !wp_verify_nonce($_POST["department_nonce"], basename(__FILE__)))
		return $post_id;

	if(!current_user_can("edit_post", $post_id))
		return $post_id;

	if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
		return $post_id;

	for ($var = 0; ++$var <= 5; ) {
		update_post_meta($post_id, "department_text_".$var, $_POST["department_text_".$var]);
		update_post_meta($post_id, "department_url_".$var, $_POST["department_url_".$var]);
	}

	update_post_meta($post_id, "dep_facebook", $_POST["dep_facebook"]);
	update_post_meta($post_id, "dep_flickr", $_POST["dep_flickr"]);
	update_post_meta($post_id, "dep_google", $_POST["dep_google"]);
	update_post_meta($post_id, "dep_instagram", $_POST["dep_instagram"]);
	update_post_meta($post_id, "dep_linkedin", $_POST["dep_linkedin"]);
	update_post_meta($post_id, "dep_pinterest", $_POST["dep_pinterest"]);
	update_post_meta($post_id, "dep_twitter", $_POST["dep_twitter"]);
	update_post_meta($post_id, "dep_tumblr", $_POST["dep_tumblr"]);
	update_post_meta($post_id, "dep_vimeo", $_POST["dep_vimeo"]);
	update_post_meta($post_id, "dep_youtube", $_POST["dep_youtube"]);
}
add_action( 'save_post', 'department_save_meta_fields' );
add_action( 'new_to_publish', 'department_save_meta_fields' );



function add_metabox_spotlight(){
	global $post;
   	$frontpage_id = get_option('page_on_front');
   	if($post->ID == $frontpage_id):
    	add_meta_box('Spotlight', 'Spotlights', 'show_spotlight', 'page', 'normal', 'high');
   	endif;
}
add_action( 'add_meta_boxes', 'add_metabox_spotlight' );

function show_spotlight() {

	global $post;

    // Use nonce for verification to secure data sending
	wp_nonce_field( basename( __FILE__ ), 'spotlight_nonce' );

	?>

	<!-- my custom value input -->
	<p>
		Content for the 3 box that overlay the homepage video. 
	</p>
	<table class="form-table">
		<tbody>
			<?php
				for ($var = 0; ++$var <= 3; ) {
			?>

				<tr>
					<th>
						<label for="spotlight_title_<?= $var ?>" class="block">Spotlight Title <?= $var ?></label>
					</th>
					<td>
						<input id="spotlight_title_<?= $var ?>" type="text" name="spotlight_title_<?= $var ?>" value="<?= get_post_meta($post->ID, "spotlight_title_".$var, true); ?>">
					</td>
				</tr>
				<tr>
					<th>
						<label for="spotlight_content_<?= $var ?>" class="block">Spotlight Content <?= $var ?> <br>(250 max characters)</label>
					</th>
					<td>
						<textarea id="spotlight_content_<?= $var ?>" name="spotlight_content_<?= $var ?>" maxlength="250" cols="22" style="resize: both; width: 400px; height: 150px;"><?= get_post_meta($post->ID, "spotlight_content_".$var, true); ?>
						</textarea>
					</td>
				</tr>
				<tr>
					<th>
						<label for="spotlight_button_text<?= $var ?>" class="block">Spotlight Button Text <?= $var ?></label>
					</th>
					<td>
						<input id="spotlight_button_text<?= $var ?>" type="text" name="spotlight_button_text<?= $var ?>" value="<?= get_post_meta($post->ID, "spotlight_button_text".$var, true); ?>" maxlength="20">
					</td>
				</tr>
				<tr>
					<th>
						<label for="spotlight_button_url<?= $var ?>" class="block">Spotlight Button URL <?= $var ?></label>
					</th>
					<td>
						<input id="spotlight_button_url<?= $var ?>" type="text" name="spotlight_button_url<?= $var ?>" value="<?= get_post_meta($post->ID, "spotlight_button_url".$var, true); ?>">
					</td>
				</tr>
				<tr>
					<td colspan="2"><hr></td>
				</tr>
			<?php
				}
			?>
			
		</tbody>
	</table>
	<br />
	<hr />

	<?php
}

function spotlight_save_meta_fields( $post_id ){

	if (!isset($_POST["spotlight_nonce"]) || !wp_verify_nonce($_POST["spotlight_nonce"], basename(__FILE__)))
	return $post_id;

	if(!current_user_can("edit_post", $post_id))
		return $post_id;

	if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
		return $post_id;

	for ($var = 0; ++$var <= 3; ) {
		update_post_meta($post_id, "spotlight_title_".$var, $_POST["spotlight_title_".$var]);
		update_post_meta($post_id, "spotlight_content_".$var, $_POST["spotlight_content_".$var]);
		update_post_meta($post_id, "spotlight_button_text".$var, $_POST["spotlight_button_text".$var]);
		update_post_meta($post_id, "spotlight_button_url".$var, $_POST["spotlight_button_url".$var]);
	}
}
add_action( 'save_post', 'spotlight_save_meta_fields' );
add_action( 'new_to_publish', 'spotlight_save_meta_fields' );



function shortcode_button_faq(){
    if(wp_script_is("quicktags"))
    {
        ?>
            <script type="text/javascript">
                
                //this function is used to retrieve the selected text from the text editor
                function getSel()
                {
                    var txtarea = document.getElementById("content");
                    var start = txtarea.selectionStart;
                    var finish = txtarea.selectionEnd;
                    return txtarea.value.substring(start, finish);
                }

                QTags.addButton( 
                    "faq_shortcode", 
                    "FAQ", 
                    callback
                );

                function callback()
                {

                	var name = prompt("What Org Group did you want to display?");
                    name = name.replace(/\s+/g, '-').toLowerCase();
                    var selected_text = getSel();
                    QTags.insertContent("[faq-list org_groups='"+  name +"']");
                }
            </script>
        <?php
    }
}
add_action("admin_print_footer_scripts", "shortcode_button_faq");

function shortcode_button_contact(){
    if(wp_script_is("quicktags"))
    {
        ?>
            <script type="text/javascript">
                
                //this function is used to retrieve the selected text from the text editor
                function getSel()
                {
                    var txtarea = document.getElementById("content");
                    var start = txtarea.selectionStart;
                    var finish = txtarea.selectionEnd;
                    return txtarea.value.substring(start, finish);
                }

                QTags.addButton( 
                    "contact_shortcode", 
                    "Contact", 
                    callback
                );

                function callback()
                {

                	var name = prompt("What is the title of the contact you would like to display?");
                    //name = name.replace(/\s+/g, '-').toLowerCase();
                    var selected_text = getSel();
                    QTags.insertContent("[contactblock contactname='"+  name +"']");
                }
            </script>
        <?php
    }
}
add_action("admin_print_footer_scripts", "shortcode_button_contact");

function shortcode_button_iframe(){
    if(wp_script_is("quicktags"))
    {
        ?>
            <script type="text/javascript">
                
                //this function is used to retrieve the selected text from the text editor
                function getSel()
                {
                    var txtarea = document.getElementById("content");
                    var start = txtarea.selectionStart;
                    var finish = txtarea.selectionEnd;
                    return txtarea.value.substring(start, finish);
                }

                QTags.addButton( 
                    "iframe_shortcode", 
                    "IFrame", 
                    callback
                );

                function callback()
                {

                	var url = prompt("What URL? If using YouTube or Vimeo please use the embed URL.");
                	var width = prompt("What is the width in pixels?");
                	var height = prompt("What is the height in pixels?");

                    name = name.replace(/\s+/g, '-').toLowerCase();
                    var selected_text = getSel();
                    QTags.insertContent("[iframe if_url='" + url + "' if_width='" + width + "' if_height='" + height + "']");
                }
            </script>
        <?php
    }
}
add_action("admin_print_footer_scripts", "shortcode_button_iframe");

function shortcode_button_calendar(){
    if(wp_script_is("quicktags"))
    {
        ?>
            <script type="text/javascript">
                
                //this function is used to retrieve the selected text from the text editor
                function getSel()
                {
                    var txtarea = document.getElementById("content");
                    var start = txtarea.selectionStart;
                    var finish = txtarea.selectionEnd;
                    return txtarea.value.substring(start, finish);
                }

                QTags.addButton( 
                    "calendar_shortcode", 
                    "Calendar", 
                    callback
                );

                function callback()
                {
					var action = 'upcoming';
                	var calid = prompt("What is calendar ID?");
                	var count = prompt("How many do you want to display?");               	

                    name = name.replace(/\s+/g, '-').toLowerCase();
                    var selected_text = getSel();
                    QTags.insertContent("[calendar cal_id='" + calid + "' action='" + action + "' count='" + count + "']");
                }
            </script>
        <?php
    }
}
add_action("admin_print_footer_scripts", "shortcode_button_calendar");

function shortcode_button_publication(){
    if(wp_script_is("quicktags"))
    {
        ?>
            <script type="text/javascript">
                
                QTags.addButton( 
                    "publication_shortcode", 
                    "Publication List", 
                    callback
                );

                function callback()
                {

                    QTags.insertContent("[publication-list]");
                }
            </script>
        <?php
    }
}
add_action("admin_print_footer_scripts", "shortcode_button_publication");

function shortcode_button_menu(){
    if(wp_script_is("quicktags"))
    {
        ?>
            <script type="text/javascript">
                
                //this function is used to retrieve the selected text from the text editor
                function getSel()
                {
                    var txtarea = document.getElementById("content");
                    var start = txtarea.selectionStart;
                    var finish = txtarea.selectionEnd;
                    return txtarea.value.substring(start, finish);
                }

                QTags.addButton( 
                    "menu_shortcode", 
                    "Menu Panel", 
                    callback
                );

                function callback()
                {
                	var name = prompt("What menu did you want to display?");
                    name = name.replace(/\s+/g, '-').toLowerCase();
                    var header = prompt("What do you want the menu header to say?");
                    var selected_text = getSel();
                    QTags.insertContent("[menu menu_name='"+ name +"' header='"+ header +"']");
                }
            </script>
        <?php
    }
}
add_action("admin_print_footer_scripts", "shortcode_button_menu");

//Adds responsive class to images
function image_tag_class($class) {
    $class .= ' img-fluid';
    return $class;
}
add_filter('get_image_tag_class', 'image_tag_class' );

?>