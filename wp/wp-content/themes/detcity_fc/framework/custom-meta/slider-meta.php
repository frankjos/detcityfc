<?php
	/* Slider Meta box setup function. */
	$prefix = '';
	$meta_box['slider'] = array(
		'id'		=> 'slider-meta-box',
		'title'		=> THEMENAME. ' Slider Options',
		'page'		=> 'slider',
		'context'	=> 'normal',
		'priority'	=> 'high',
		'fields'	=> array(
			array(
				'name'	=> 'Link for Slide Item',
				'id'	=> $prefix . 'postlinktype_options',
				'desc'	=> 'The url that the slide post is linked to',
				'type'	=> 'radio',
				'std'	=>'default',
				'options' =>array(
					'linkpage'		=> 'Link to Page',
					'linktocategory'=> 'Link to Category', 
					'linktopost'	=> 'Link to Post',
					'linkmanually'	=> 'Link Manually',
					'default'		=> 'default'
				)	
			),
		
			array(
				'name'	=> 'Cycle sldier Featured Slider',
				'id'	=> $prefix . 'slider_alignoptions',
				'desc'	=> 'Select the option below which will display this post in assinged stage layout..',
				'type'	=> 'select',
				'std'	=>'full',
				'options' =>array(
						'full'			=> 'Full',
						'partialleft'	=> 'Partial Left', 
						'partialright'	=>'Partial Right'
				)
			),
			array(
				'name'	=> 'Custom Sidebar',
				'id'	=> $prefix . 'custom_widget',
				'type'	=> 'customselect',
				'std'	=> '',
				'desc'	=> 'Select the Sidebar you want to assign for this page.',
				"options"=> $sidebarwidget
			),
		
			array(
				'name'	=> 'Layout Option',
				'id'	=> $prefix . 'sidebar_options',
				'type'	=> 'select',
				'std'	=> '',
				'desc'	=> 'Select the Layout style you want to use for this page, Left Sidebar or Right Sidebar or Full Width with no sidebar.',
				"options"=> array(
					"rightsidebar"	=> "Right Sidebar", 
					"leftsidebar"	=> "Left Sidebar",
					"fullwidth"		=> "Full Width"
				)	
			)
		),
	);
?>