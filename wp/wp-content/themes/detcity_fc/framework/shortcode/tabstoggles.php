<?php

	/**
	 * Toggles
	 */
	function sys_toggle_content( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'heading'	=> '',
		), $atts));
	
		$out= '<div class="simpletoggle">';
		$out .= '<span class="toggle"><a href="#">' .$heading. '</a></span>';
		$out .= '<div class="toggle_content" style="display: none;">';
		$out .= '<div class="toggleinside">';
		$out .= do_shortcode($content);
		$out .= '</div></div></div>';
		
		return $out;
	}
	add_shortcode('toggle', 'sys_toggle_content');

	/**
	 * Fancy Toggle
	 */
	function sys_fancy_toggle_content( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'heading'	=> '',
		), $atts));
		$out= '<div class="fancytoggle">';
		$out .= '<div class="fancytogglebg">';
		$out .= '<span class="toggle"><a href="#">' .$heading. '</a></span>';
		$out .= '<div class="toggle_content" style="display: none;">';
		$out .= '<div class="toggleinside">';
		$out .= do_shortcode($content);
		$out .= '</div></div>';
		$out .= '</div>';
		$out .= '</div>';
		
		return $out;
	}
	add_shortcode('fancytoggle', 'sys_fancy_toggle_content');

	/**
	 * Tabs
	 */
	function atp_tab_group( $atts, $content ){
		extract(shortcode_atts(array(
			'tabtype'	=> '',
		), $atts));
	
		$GLOBALS['tab_count'] = 0;
		do_shortcode( $content );
		if($tabtype=="vertabs") {
			$tabtype='vertabs';
		}else{ 
			$tabtype="";
		}
		$return = '<div class="systabspane '.$tabtype.'">';
		if( is_array( $GLOBALS['tabs'] ) ){
			foreach( $GLOBALS['tabs'] as $tab ){ 
				$tabs[] = '<li style="background-color:'.$tab['tabcolor'].';"><a href="#" style="color:'.$tab['textcolor'].';">'.$tab['title'].'</a></li>';
				$panes[] = '<div  class="tab_content">'.do_shortcode($tab['content']).'</div>';
			}
			$return .='<ul class="tabs">'.implode( "\n", $tabs ).'</ul>'."\n".'<div class="panes">'.implode( "\n", $panes ).'</div>';
		}
		$return.='<div class="clear"></div></div>';
		
		return $return;
	}

	function atp_tab( $atts, $content ){
		extract(shortcode_atts(array(
			'title'		=> 'Tab %d',
			'tabcolor'	=> 'Tab %d',
			'textcolor'	=> 'Tab %d'
		), $atts));

		$x = $GLOBALS['tab_count'];
		$GLOBALS['tabs'][$x] = array(
			'title'		=> sprintf( $title, $GLOBALS['tab_count'] ),
			'tabcolor'	=> sprintf( $tabcolor, $GLOBALS['tab_count'] ),
			'textcolor'	=> sprintf( $textcolor, $GLOBALS['tab_count'] ),
			'content'	=>  $content 
		);
		$GLOBALS['tab_count']++;
	}
	add_shortcode( 'minitabs', 'atp_tab_group' );
	add_shortcode( 'tab', 'atp_tab' );
?>