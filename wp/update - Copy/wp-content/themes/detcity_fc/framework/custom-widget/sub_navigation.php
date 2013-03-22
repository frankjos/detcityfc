<?php
/**
 * Plugin Name: Sub Pages Widget
 * Description: A widget used for displaying all sub pages.
 * Version: 1.0
 */
	// Register Widget
	function widget_sub_page_navigation() {
		register_widget( 'widget_sub_page_navigation' );
	}

	// Define the Widget as an extension of WP_Widget
	If (!Class_Exists('widget_sub_page_navigation')){
		/* constructor */
		class widget_sub_page_navigation extends WP_Widget {
			var $base_url;
			var $arr_option;
			function __construct(){
			
				global $themename;
				// Setup the Widget data
				parent::__construct (
					false,
					$this->t(THEMENAME.'-Sub Pages'),
					array('description' => $this->t('You can add this widget to sidebars on pages to show all sub pages of the current one.'))
				);
		
				// Read base_url
				$this->base_url = site_url().'/'.Str_Replace("\\", '/', SubStr(RealPath(DirName(__FILE__)), Strlen(ABSPATH)));
			}
			
			function t ($text, $context = ''){
				// Translates the string $text with context $context
				If ($context == '')
				return __($text, __CLASS__);
				else
				return _x($text, $context, __CLASS__);
			}
  
			function default_options(){
				// Default settings
				return array(
				'title' => $this->t('Navigation'),
				'sortby' => 'menu_order, post_title'    
				);
			}
			
			function load_options($options){
				$options = (ARRAY) $options;
				// Delete empty values
				foreach ($options AS $key => $value)
				if (!$value) unset($options[$key]);
				
				// Load options
				$this->arr_option = Array_Merge ($this->default_options(), $options);
			}
  
			function get_option($key, $default = false){
				if (isset($this->arr_option[$key]) && $this->arr_option[$key])
					return $this->arr_option[$key];
				else
					return $default;
			}
	
			function set_option($key, $value){
				$this->arr_option[$key] = $value;
			}
			
			function widget ($widget_args, $options){
				// Load options
				$this->load_options ($options); unset ($options);
					
				// if this isn't a page we bail out.
				if ( !is_page() ) return false;
					if ($GLOBALS['post']->post_parent != 0)
						$parent = get_post($GLOBALS['post']->post_parent);
					else
						$parent = false;
				    // Default Args for selecting sub pages
					$page_args = array(
						'title_li' => '',
						'child_of' => get_the_id(),
						'sort_column' => $this->get_option('sortby'),
						'exclude'  => $this->get_option('exclude'),
						'depth'    => 1,
						'echo'     => false
					);
					// What to show?
					if ($page_listing = wp_list_pages($page_args)){
						// There are some sub pages
						if ($this->get_option('replace_widget_title'))
						$this->set_option('title', get_the_title());
					}
    				else {
						// There are no sub pages
					    // there are no sub pages we try to show all pages in the same depth level.
						$page_args['child_of'] = ($parent ? $parent->ID : 0);
      
						// If the parent page is a real page its title will be our widget title
						if ($parent && $this->get_option('replace_widget_title'))
							$this->set_option('title', $parent->post_title);
						
						// Read the subpages again
						if (!$page_listing = wp_list_pages($page_args)) return false;
					}

					// Widget output    
					echo $widget_args['before_widget'];
				
				// Widget title
				echo $widget_args['before_title'] . $this->get_option('title') . $widget_args['after_title'];
				
				// output Page listing		
				echo '<ul>';
				echo $page_listing;
				if ($parent)
				echo '<li class="upward"><a href="'.get_permalink($parent->ID).'" title="'.$parent->post_title.'">'.$parent->post_title.'</a></li>';
				echo '</ul>';
					
				// Widget bottom  
				echo $widget_args['after_widget'];
			}
			
			function form ($options){
				// Load options
				$this->load_options ($options); unset ($options);?>
				<p>
				<?php echo $this->t('Title:'); ?>
				<input type="text" name="<?php  echo $this->get_field_name('title') ?>" value="<?php echo $this->get_option('title') ?>" />
				</p>
				
				<p>
				<input type="checkbox" value="yes" name="<?php echo $this->get_field_name('replace_widget_title') ?>"<?php Checked( $this->get_option('replace_widget_title'), 'yes' ); ?>/>
				<?php echo $this->t('Replace the widget title with the title of the parent page if possible.') ?>
				</p>
				
				<p>
				<?php _e( 'Sort by:','atp_admin'); ?>
				<select name="<?php echo $this->get_field_name('sortby'); ?>">
					<option value="menu_order" <?php selected( $this->get_option('sortby'), 'menu_order' ); ?> ><?php _e('Page order','atp_admin'); ?></option>
					<option value="post_title" <?php selected( $this->get_option('sortby'), 'post_title' ); ?> ><?php _e('Page title','atp_admin'); ?></option>
					<option value="ID" <?php selected( $this->get_option('sortby'), 'ID' ); ?> ><?php _e( 'Page ID','atp_admin' ); ?></option>
				</select>
				</p>
				
				<p>
				<?php _e( 'Exclude:','atp_admin' ); ?>
				<input type="text" value="<?php echo $this->get_option('exclude'); ?>" name="<?php echo $this->get_field_name('exclude'); ?>" /><br />
				<small><?php _e( 'Page IDs, separated by commas.','atp_admin' ); ?></small>
				</p>
				<?php
				
			}
		
			function update ($new_settings, $old_settings){ return $new_settings; }
		}
	
	}

	/* Add our function to the widgets_init hook. */
	add_action( 'widgets_init', 'widget_sub_page_navigation' );

?>