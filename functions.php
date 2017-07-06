<?php
require_once('functions/base.php');   			# Base theme functions
require_once('functions/feeds.php');			# Where functions related to feed data live
require_once('custom-taxonomies.php');  		# Where per theme taxonomies are defined
require_once('custom-post-types.php');  		# Where per theme post types are defined
require_once('functions/admin.php');  			# Admin/login functions
require_once('functions/config.php');			# Where per theme settings are registered
require_once('shortcodes.php');         		# Per theme shortcodes

//Add theme-specific functions here.

require_once('functions/features.php');


function recent_posts_function($atts) {
	extract(shortcode_atts(array(
		'posts' => 1,
	), $atts));

	$args = array(
		'post_type' => array('news'),
		'orderby' => 'title',
		'order'   => 'ASC',
		'posts_per_page' => $posts,
		);
	$object = new WP_Query($args);			

	ob_start();
	?>
	<ul>
	<?php
	if ( $object->have_posts() ) :
		while ( $object->have_posts() ) : $object->the_post();			

	?>

	<li><a href="<?= get_permalink() ?>"><?= get_the_title() ?></a></li>

	<?php endwhile; wp_reset_postdata(); ?>
	</ul>
	<!-- show pagination here -->
	<?php else : ?>
	<!-- show 404 error here -->
	<?php endif; ?>


	<?php 
	return ob_get_clean();
}

function register_shortcodes(){
   add_shortcode('recent-posts', 'recent_posts_function');
}
add_action( 'init', 'register_shortcodes');





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

                	var name = prompt("What Tag is used for this FA");
                	var name2 = prompt("What Tag is used for this FA");
                	var name3 = prompt("What Tag is used for this FA");
                    var selected_text = getSel();
                    QTags.insertContent("[faq]" +  name + "[/faq]");
                }
            </script>
        <?php
    }
}
add_action("admin_print_footer_scripts", "shortcode_button_faq");

function shortcode_button_script2(){
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
                    "blah_shortcode", 
                    "blah", 
                    callback
                );

                function callback()
                {

                	var name=prompt("What Tag is used for this FA");
                	var name2=prompt("What Tag is used for this FA");
                	var name3=prompt("What Tag is used for this FA");
                    var selected_text = getSel();
                    QTags.insertContent("[blah]" +  name + "[/blah]");
                }
            </script>
        <?php
    }
}
add_action("admin_print_footer_scripts", "shortcode_button_script2");


?>