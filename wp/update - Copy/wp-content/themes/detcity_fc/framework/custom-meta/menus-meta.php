<?php
/* Food Menus Meta box setup function. */
$prefix = '';

$meta_box['menus'] = array(
	'id'		=> 'portfolio-meta-box',
	'title'		=> THEMENAME.'&nbsp;Menus Options',
	'page'		=> 'menus',
	'context'	=> 'normal',
	'priority'	=> 'core',
	'fields'	=> array(
		array(
			'name'	=> 'Full Size Image',
			'id'	=> $prefix . 'fullimg',
			'type'	=> 'upload',
			'desc'	=>'Use this image field only if you want to choose a different image to load when lightbox is opened.',
			'std'	=> ''
		),
		array(
			'name'	=> 'Cycle sldier Featured Slider',
			'id'	=> $prefix . 'slider_alignoptions',
			'desc'	=> 'Select the option below which will display this post in assinged stage layout..',
			'type'	=> 'select',
			'std'	=>'full',
			'options' =>array(
					'full'		=> 'Full',
					'partialleft'  => 'Partial Left', 
					'partialright'	=>'Partial Right'
			)
		),
		array(
			"name"	=> "Price",
			"type"	=> "text",
			"id"	=> "price",
			"std"	=> "",
			"title"	=> "Enter The Price",
			"desc"	=> "Enter the price of the meal excluding the currency symbol"
		),
			array(
			"name"	=> "Menu Description",
			"type"	=> "textarea",
			"id"	=> "item_desc",
			"std"	=> "",
			"title"	=> "Enter The Desc",
			"desc"	=> "Enter the Desc"
		),
		array(
			'name'	=> 'Custom Sidebar',
			'id'	=> $prefix . 'custom_widget',
			'type'	=> 'customselect',
			'desc'	=> 'Select the Sidebar you want to assign for this page.',
			"std"	=> "",
			"options"=> $sidebarwidget
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