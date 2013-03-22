<?php
/* Post Meta box setup function. */
$prefix = '';
$meta_box['post'] = array(
	'id'		=> 'post-meta-box',
	'title'		=> THEMENAME.'&nbsp;Post Options',
	'page'		=> 'post',
	'context'	=> 'normal',
	'priority'	=> 'core',
	'fields'	=> array(
		array(
			'name'	=> 'Custom Subheader Teaser Options',
			'id'	=> $prefix . 'subheader_teaser_options',
			'std'	=> '',
			'type'	=> 'select',
			'desc'	=> 'Select the Teaser type mode you want to display in subheader of the this Post',
			"options"=> array(
				"default"	=> "Default",
				"custom"	=> "Custom", 
				"twitter"	=> "Twitter", 
				"disable"	=> "Disable"

			)	
		),
		array(
			"name"	=> "Custom Subheader Teaser Text/HTML",
			"type"	=> "textarea",
			"id"	=> "page_desc",
			"std"	=> "",
			"class"	=> "sub_teaser_option custom",
			"title"	=> "Custom Subheader Teaser Text/HTML",
			"desc"	=> "Enter the text which will appear in the subheader of this post. If you want to use bold text use html strong element example &lt;strong&gt;bold text &lt;/strong&gt;"
		),
		array(
			'name'	=> 'Page Background Image',
			'type'	=> 'upload',
			'id'	=> 'page_bg_image',
			'std'	=> '',
			'title'	=> 'Background Image',
			'desc'	=> 'Upload the image for the page background'
		),	
		array(
			"name"	=> "Header Background",
			"type"	=> "color",
			"id"	=> "header_bg_color",
			"std"	=> "",
			"title"	=> "Header Background",
			"desc"	=> "Choose the color for Header background"
		),
		array(
			"name"	=> "Subheader Background",
			"type"	=> "color",
			"id"	=> "subheader_bg_color",
			"std"	=> "",
			"title"	=> "Subheader Background",
			"desc"	=> "Choose the color for Subheader background"
		),

		array(
			'name'	=> 'Custom Sidebar',
			'id'	=> $prefix . 'custom_widget',
			'type'	=> 'customselect',
			"std"	=> "",
			'desc'	=> 'Select the Sidebar you want to assign for this page.',
			"options"=> $sidebarwidget
		),
	
		array(
			'name'	=> 'Layout Option',
			'id'	=> $prefix . 'sidebar_options',
			'type'	=> 'select',
			"std"	=> "",
			'desc'	=> 'Select the Layout style you want to use for this page, Left Sidebar or Right Sidebar or Full Width with no sidebar.',
			"options"=> array(
				"rightsidebar"	=> "Right Sidebar", 
				"leftsidebar"	=> "Left Sidebar",
				"fullwidth"	=> "Full Width"
			)	
		)
	
	)
);
?>