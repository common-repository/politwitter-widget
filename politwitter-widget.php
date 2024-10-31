<?php
/*
Plugin Name: politwitter.ca Widget
Plugin URI: http://politwitter.ca/page/widget
Description: Canadian political twitter widget. Display the latest political tweets, with options to only show tweets from a specific party, province or MPs only.
Version: 1.0
Author: Canadaka.net
Author URI: http://www.canadaka.net
*/

/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'load_widgets' );

/**
 * Register our widget.
 * 'Example_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function load_widgets() {
	register_widget( 'politwitter_widget' );
}

/**
 * Example Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 * @since 0.1
 */
class politwitter_widget extends WP_Widget {

	// Widget setup.
	function politwitter_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'politwitter', 'description' => __('Canadian political twitter widget', 'politwitter') );
		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 800, 'id_base' => 'politwitter' );
		/* Create the widget. */
		$this->WP_Widget( 'politwitter', __('politwitter.ca Widget', 'politwitter'), $widget_ops, $control_ops );
	}

	//How to display the widget on the screen.
	function widget($args, $instance) {
		extract($args);
		
		//$title = apply_filters('widget_title', $instance['title'] );
		$type = $instance['type'];
		$category = $instance['category'];
		$province = $instance['province'];
		$hash = str_replace('#', '', $instance['hash']);
		$mp = $instance['mp'];
		$scrollbar = $instance['scrollbar'];
		$width = $instance['width'];
		$referrer = 'http://'.$_SERVER["SERVER_NAME"];
		
		$type = isset($instance['type']) ? $instance['type'] : 'all';
		$mp = isset($instance['mp']) ? $instance['mp'] : 0;
		$scrollbar = isset($instance['scrollbar']) ? $instance['scrollbar'] : 0;
		$width = isset($instance['width']) ? $instance['width'] : 300;
		$height = isset($instance['height']) ? $instance['height'] : 400;
		
		//echo $before_widget;
		//if ( $title ) echo $before_title . $title . $after_title; /* Display the widget title if one was input (before and after defined by themes). */

		echo '<iframe src="http://politwitter.ca/includes/widget.php?type='.$type.'&category='.$category.'&hash='.$hash.'&province='.$province.'&mp='.$mp.'&scrollbar='.$scrollbar.'&width='.$width.'&referrer='.urlencode($referrer).'" id="tweets" width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no"></iframe>';

		//echo $after_widget;
	}


	//Update the widget settings.
	function update($new_instance, $old_instance) {
		/*
		$instance = $old_instance;
		//$instance['title'] = strip_tags($new_instance['title']);
		$instance['type'] = $new_instance['type'];
		$instance['category'] = $new_instance['category'];
		$instance['hash'] = $new_instance['hash'];
		$instance['mp'] = $new_instance['mp'];
		$instance['scrollbar'] = $new_instance['scrollbar'];
		$instance['width'] = $new_instance['width'];

		return $instance;
		*/
		return $new_instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		$defaults = array( 'width' => '300' ); /* Set up some default widget settings. */
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		
        ?>
		<p>
			<label for="<?php echo $this->get_field_id('type'); ?>">Type:
			<select id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>" size="1">
				<option value="all">All</option>
				<option value="category" <?php selected($instance['type'], 'category'); ?>>Partisan</option>
				<option value="province" <?php selected($instance['type'], 'province'); ?>>Province</option>
				<option value="hash" <?php selected($instance['type'], 'hash'); ?>>Hash</option>
			</select></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('mp'); ?>">MPs Only?
			<select id="<?php echo $this->get_field_id('mp'); ?>" name="<?php echo $this->get_field_name('mp'); ?>" size="1">
				<option value="0" <?php selected($instance['mp'], '0'); ?>>no</option>
				<option value="1" <?php selected($instance['mp'], '1'); ?>>yes</option>
			</select></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('scrollbar'); ?>">Show scrollbar
			<select id="<?php echo $this->get_field_id('scrollbar'); ?>" name="<?php echo $this->get_field_name('scrollbar'); ?>" size="1">
				<option value="1" <?php selected($instance['scrollbar'], '1'); ?>>yes</option>
				<option value="0" <?php selected($instance['scrollbar'], '0'); ?>>no</option>			
			</select></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('width'); ?>">Width:
			<input id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" value="<?php echo $instance['width']; ?>" style="width: 90px;" type="text">
		</p></label>
		
		<br />
		<span style="color:#999999; font-size:80%;">The below options only apply when selecting a different "Type" above. These will be ignored if type is not changed from "all".</span>
		<p>
			<label for="<?php echo $this->get_field_id('category'); ?>">Partisan:
			<select id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" size="1">
				<option value=""></option>
				<option value="liberal" <?php selected($instance['category'], 'liberal'); ?>>Liberal</option>
				<option value="conservative" <?php selected($instance['category'], 'conservative'); ?>>Conservative</option>
				<option value="ndp" <?php selected($instance['category'], 'ndp'); ?>>NDP</option>
				<option value="green" <?php selected($instance['category'], 'green'); ?>>Green</option>
				<option value="bloc" <?php selected($instance['category'], 'bloc'); ?>>Bloc Québécois</option>
				<option value="other" <?php selected($instance['category'], 'other'); ?>>other</option>
				<option value="media" <?php selected($instance['category'], 'media'); ?>>media</option>
			</select></label>	
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('province'); ?>">Province:
			<select id="<?php echo $this->get_field_id('province'); ?>" name="<?php echo $this->get_field_name('province'); ?>" size="1">
				<option value=""></option>
				<option value="ab" <?php selected($instance['province'], 'ab'); ?>>Alberta</option>
				<option value="bc" <?php selected($instance['province'], 'bc'); ?>>British Columbia</option>
				<option value="mb" <?php selected($instance['province'], 'mb'); ?>>Manitoba</option>
				<option value="nb" <?php selected($instance['province'], 'nb'); ?>>New Brunswick</option>
				<option value="nl" <?php selected($instance['province'], 'nl'); ?>>Newfoundland</option>
				<option value="ns" <?php selected($instance['province'], 'ns'); ?>>Nova Scotia</option>
				<option value="on" <?php selected($instance['province'], 'on'); ?>>Ontario</option>
				<option value="pe" <?php selected($instance['province'], 'pe'); ?>>Prince Edward Island</option>
				<option value="qc" <?php selected($instance['province'], 'qc'); ?>>Quebec</option>
				<option value="sk" <?php selected($instance['province'], 'sk'); ?>>Saskatchewan</option>
				<option value="tt" <?php selected($instance['province'], 'tt'); ?>>Territories (yk, nt, nu)</option>
			</select></label>	
		</p>	
		<p>
			<label for="<?php echo $this->get_field_id('hash'); ?>">Hash:
			<input id="<?php echo $this->get_field_id('hash'); ?>" name="<?php echo $this->get_field_name('hash'); ?>" value="<?php echo $instance['hash']; ?>" style="width: 90px;" type="text"></label>
		</p>
	<?php
	}
}
?>