<?php
/* 
 *   Plugin Name: Contact Widget
 *   Plugin URI: http://www.namestrap.com
 *   Version: Current Version 
 *   Author: Name please 
 *   Description: What does your plugin do and what features does it offer... 
 * Proper way to enqueue scripts and styles
 */
	
    function theme_name_scripts() {
        //wp_enqueue_style( 'style-name', plugins_url('/css/contact-widget.css', __FILE__), array(), '1.0.0', true );
        //wp_enqueue_script( 'script-name', get_template_directory_uri() . '/js/example.js', array(), '1.0.0', true );
        wp_register_style( 'my-plugin', plugins_url( '/contact-widget/css/contact-widget.css' ) );
        wp_enqueue_style( 'my-plugin' );
    }
    add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );

    add_action( 'widgets_init', 'register_my_widget' );
    function register_my_widget() {  
        register_widget( 'My_Widget' );  
    }
    class My_Widget extends WP_Widget {
		function My_Widget() {  
			$widget_ops = array( 'classname' => 'Contact', 'description' => __('A widget that displays the Contact detail ', 'contact') );  
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'contact-widget' );  
			$this->WP_Widget( 'contact-widget', __('Contact Widget', 'contact'), $widget_ops, $control_ops );  
		}  
		function widget( $args, $instance ){
			extract( $args );
			$title = apply_filters('widget_title', $instance['title'] );  
			$address = $instance['address'];
			$phone = $instance['phone'];
			$fax= $instance['fax'];
			$email= $instance['email'];
			$web= $instance['web'];
			echo $before_widget;  
			// Display the widget title   
			if ( $title )  
				echo $before_title . $title . $after_title;  
			//Display the name
			if( $address )
				echo '<div class="contact-detail"><span class="fa fa-home"></span><p>'. $address . '</p></div><div class="clearfix"></div>';
			if( $phone || $fax )
				echo '<div class="contact-detail"><span class="fa fa-phone"></span><p>Phone: '. $phone . '</p><p>Fax: '. $fax .'</p></div><div class="clearfix"></div>';
			if($email || $web)
				echo '<div class="contact-detail"><span class="fa fa-envelope"></span><p>Email: '. $email . '</p><p>Web: '. $web .'</p></div><div class="clearfix"></div>';
		}         
		function update( $new_instance, $old_instance ) {  
			$instance = $old_instance;  
			//Strip tags from title and name to remove HTML  
			$instance['title'] = strip_tags( $new_instance['title'] );  
			$instance['address'] = strip_tags( $new_instance['address'] );
			$instance['phone'] = strip_tags( $new_instance['phone'] );
			$instance['fax'] = strip_tags( $new_instance['fax'] );
			$instance['email'] = strip_tags( $new_instance['email'] );
			$instance['web'] = strip_tags( $new_instance['web'] );
			return $instance;  
		}
		function form( $instance ) {
			//Set up some default widget settings.
			$defaults = array( 'title' => __('Contact', 'contact'), 'address' => __('', 'contact'),'phone' =>__('','contact'), 'fax' => __('', 'contact'), 'email' => __('', 'contact'), 'web' => __('', 'contact'));
			$instance = wp_parse_args( (array) $instance, $defaults );?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'contact'); ?></label>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'address' ); ?>"><?php _e('Address:', 'contact'); ?></label>
				<input id="<?php echo $this->get_field_id( 'address' ); ?>" name="<?php echo $this->get_field_name( 'address' ); ?>" value="<?php echo $instance['address']; ?>" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'phone' ); ?>"><?php _e('Phone No:', 'contact'); ?></label>
				<input id="<?php echo $this->get_field_id( 'phone' ); ?>" name="<?php echo $this->get_field_name( 'phone' ); ?>" value="<?php echo $instance['phone']; ?>" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'fax' ); ?>"><?php _e('Fax:', 'contact'); ?></label>
				<input id="<?php echo $this->get_field_id( 'fax' ); ?>" name="<?php echo $this->get_field_name( 'fax' ); ?>" value="<?php echo $instance['fax']; ?>" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e('Email:', 'contact'); ?></label>
				<input id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" value="<?php echo $instance['email']; ?>" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'web' ); ?>"><?php _e('Web:', 'contact'); ?></label>
				<input id="<?php echo $this->get_field_id( 'web' ); ?>" name="<?php echo $this->get_field_name( 'web' ); ?>" value="<?php echo $instance['web']; ?>" style="width:100%;" />
			</p>
			<?php
		}
    }
?>