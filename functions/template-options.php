<?php
	add_action('admin_enqueue_scripts', 'admin_template_view');
	function admin_template_view()
	{
	    wp_enqueue_script('show_hide_bill_view', get_bloginfo('template_url').'/js/template-options.js', array('jquery'));
	}
?>