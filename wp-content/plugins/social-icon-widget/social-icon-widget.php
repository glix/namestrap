<?php
    /* 
    Plugin Name: Social Icon Widget
    Plugin URI: http://www.namestrap.com
    Version: Current Version 
    Author: Name please 
    Description: What does your plugin do and what features does it offer... 
    */  


/**
 * Proper way to enqueue scripts and styles
 */
    function theme_social_scripts() {
        //wp_enqueue_style( 'style-name', plugins_url('/css/contact-widget.css', __FILE__), array(), '1.0.0', true );
        wp_enqueue_script( 'script-name', plugins_url( '/social-icon-widget/js/tooltip.js' ), array(), '1.0.0', true );

        wp_register_style( 'my-social-plugin', plugins_url( '/social-icon-widget/css/social-icon-widget.css' ) );
        wp_enqueue_style( 'my-social-plugin' );
    }

    add_action( 'wp_enqueue_scripts', 'theme_social_scripts' );

    add_action( 'widgets_init', 'register_my_social_widget' );
    function register_my_social_widget() {  
        register_widget( 'My__Social_Widget' );  
    }
    class My__Social_Widget extends WP_Widget {
    function My__Social_Widget() {  
            $widget_ops = array( 'classname' => 'Social', 'description' => __('A widget that displays the Social detail ', 'social') );  
            $control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'social-widget' );  
            $this->WP_Widget( 'social-widget', __('Social Icon Widget', 'social'), $widget_ops, $control_ops );  
        }  
    function widget( $args, $instance ){
            extract( $args );
            $title = apply_filters('widget_title', $instance['title'] );
            $twitter = $instance['twitter'];  
            $facebook = $instance['facebook'];
            $dribbble = $instance['dribbble'];
            $linkedin = $instance['linkedin'];
            $skype = $instance['skype'];
            $youtube = $instance['youtube'];
            $flickr = $instance['flickr'];
            $github = $instance['github'];
            $instagram = $instance['instagram'];
            $googleplus = $instance['google-plus'];
            $pinterest = $instance['pinterest'];
            $tumblr = $instance['tumblr'];
            $vimeo = $instance['vimeo-square'];
            $rss = $instance['rss'];
    
            echo $before_widget;  
            // Display the widget title   
            if ( $title )  
                echo $before_title . $title . $after_title;  
            //Display the name
            if( $twitter )
                echo '<a target="_blank" href="'.$twitter.'"><i title="" data-placement="top" data-toggle="tooltip" data-original-title="twitter" class="social-icon fa fa-twitter"></i></a>';
            if( $facebook )
                echo '<a target="_blank" href="'.$facebook.'"><i title="" data-placement="top" data-toggle="tooltip" data-original-title="facebook" class="social-icon fa fa-facebook"></i></a>';
            if( $dribbble )
                echo '<a target="_blank" href="'.$dribbble.'"><i title="" data-placement="top" data-toggle="tooltip" data-original-title="dribbble" class="social-icon fa fa-dribbble"></i></a>';
            if( $linkedin )
                echo '<a target="_blank" href="'.$linkedin.'"><i title="" data-placement="top" data-toggle="tooltip" data-original-title="linkedin" class="social-icon fa fa-linkedin"></i></a>';
            if( $skype )
                echo '<a target="_blank" href="'.$skype.'"><i title="" data-placement="top" data-toggle="tooltip" data-original-title="skype" class="social-icon fa fa-skype"></i></a>';
            if( $youtube )
                echo '<a target="_blank" href="'.$youtube.'"><i title="" data-placement="top" data-toggle="tooltip" data-original-title="youtube" class="social-icon fa fa-youtube"></i></a>';
            if( $github )
                echo '<a target="_blank" href="'.$github.'"><i title="" data-placement="top" data-toggle="tooltip" data-original-title="github" class="social-icon fa fa-github"></i></a>';
            if( $instagram )
                echo '<a target="_blank" href="'.$instagram.'"><i title="" data-placement="top" data-toggle="tooltip" data-original-title="instagram" class="social-icon fa fa-instagram"></i></a>';
            if( $flickr )
                echo '<a target="_blank" href="'.$flickr.'"><i title="" data-placement="top" data-toggle="tooltip" data-original-title="flickr" class="social-icon fa fa-flickr"></i></a>';
            if( $googleplus )
                echo '<a target="_blank" href="'.$googleplus.'"><i title="" data-placement="top" data-toggle="tooltip" data-original-title="google-plus" class="social-icon fa fa-google-plus"></i></a>';
            if( $pinterest )
                echo '<a target="_blank" href="'.$pinterest.'"><i title="" data-placement="top" data-toggle="tooltip" data-original-title="pinterest" class="social-icon fa fa-pinterest"></i></a>';
            if( $tumblr )
                echo '<a target="_blank" href="'.$tumblr.'"><i title="" data-placement="top" data-toggle="tooltip" data-original-title="tumblr" class="social-icon fa fa-tumblr"></i></a>';
            if( $vimeo )
                echo '<a target="_blank" href="'.$vimeo.'"><i title="" data-placement="top" data-toggle="tooltip" data-original-title="vimeo-square" class="social-icon fa fa-vimeo-square"></i></a>';
            if( $rss )
                echo '<a target="_blank" href="'.$rss.'"><i title="" data-placement="top" data-toggle="tooltip" data-original-title="rss" class="social-icon fa fa-rss"></i></a>';
            
    }         
    function update( $new_instance, $old_instance ) {  
            $instance = $old_instance;  
            //Strip tags from title and name to remove HTML  
            $instance['title'] = strip_tags( $new_instance['title'] );  
            $instance['twitter'] = strip_tags( $new_instance['twitter'] );
            $instance['facebook'] = strip_tags( $new_instance['facebook'] );
            $instance['dribble'] = strip_tags( $new_instance['dribble'] );
            $instance['linkedin'] = strip_tags( $new_instance['linkedin'] );
            $instance['skype'] = strip_tags( $new_instance['skype'] );
            $instance['youtube'] = strip_tags( $new_instance['youtube'] );
            $instance['github'] = strip_tags( $new_instance['github'] );
            $instance['instagram'] = strip_tags( $new_instance['instagram'] );
            $instance['flickr'] = strip_tags( $new_instance['flickr'] );
            $instance['google-plus'] = strip_tags( $new_instance['google-plus'] );
            $instance['pinterest'] = strip_tags( $new_instance['pinterest'] );
            $instance['tumblr'] = strip_tags( $new_instance['tumblr'] );
            $instance['vimeo-square'] = strip_tags( $new_instance['vimeo-square'] );
            $instance['rss'] = strip_tags( $new_instance['rss'] );
            return $instance;  
    }
    function form( $instance ) {
            //Set up some default widget settings.
            $defaults = array( 'title' => __('Social', 'social'), 'flickr' => __('', 'social'), 'twitter' => __('', 'social'), 'facebook' => __('http://', 'social'),'dribble' => __('http://', 'social'),'linkedin' => __('http://', 'social'), 'skype' => __('http://', 'social'),'youtube' => __('http://', 'social'), 'github' => __('http://', 'social'), 'instagram' => __('http://', 'social'),'flickr' => __('http://', 'social'), 'google-plus' => __('http://', 'social'),'pinterest' => __('http://', 'social'), 'tumblr' => __('http://', 'social'),'rss' => __('http://', 'social'),'vimeo-square' => __('http://', 'social'));
            $instance = wp_parse_args( (array) $instance, $defaults );?>
            <p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'social'); ?></label>
                <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e('twitter:', 'social'); ?></label>
                <input id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" value="<?php echo $instance['twitter']; ?>" style="width:100%;" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php _e('facebook:', 'social'); ?></label>
                <input id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" value="<?php echo $instance['facebook']; ?>" style="width:100%;" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'dribbble' ); ?>"><?php _e('dribbble:', 'social'); ?></label>
                <input id="<?php echo $this->get_field_id( 'dribbble' ); ?>" name="<?php echo $this->get_field_name( 'dribbble' ); ?>" value="<?php echo $instance['dribbble']; ?>" style="width:100%;" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'linkedin' ); ?>"><?php _e('linkedin:', 'social'); ?></label>
                <input id="<?php echo $this->get_field_id( 'linkedin' ); ?>" name="<?php echo $this->get_field_name( 'linkedin' ); ?>" value="<?php echo $instance['linkedin']; ?>" style="width:100%;" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'skype' ); ?>"><?php _e('skype:', 'social'); ?></label>
                <input id="<?php echo $this->get_field_id( 'skype' ); ?>" name="<?php echo $this->get_field_name( 'skype' ); ?>" value="<?php echo $instance['skype']; ?>" style="width:100%;" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'youtube' ); ?>"><?php _e('youtube:', 'social'); ?></label>
                <input id="<?php echo $this->get_field_id( 'youtube' ); ?>" name="<?php echo $this->get_field_name( 'youtube' ); ?>" value="<?php echo $instance['youtube']; ?>" style="width:100%;" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'github' ); ?>"><?php _e('github:', 'social'); ?></label>
                <input id="<?php echo $this->get_field_id( 'github' ); ?>" name="<?php echo $this->get_field_name( 'github' ); ?>" value="<?php echo $instance['github']; ?>" style="width:100%;" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'instagram' ); ?>"><?php _e('instagram:', 'social'); ?></label>
                <input id="<?php echo $this->get_field_id( 'instagram' ); ?>" name="<?php echo $this->get_field_name( 'instagram' ); ?>" value="<?php echo $instance['instagram']; ?>" style="width:100%;" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'flickr' ); ?>"><?php _e('flickr:', 'social'); ?></label>
                <input id="<?php echo $this->get_field_id( 'flickr' ); ?>" name="<?php echo $this->get_field_name( 'flickr' ); ?>" value="<?php echo $instance['flickr']; ?>" style="width:100%;" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'google-plus' ); ?>"><?php _e('google-plus:', 'social'); ?></label>
                <input id="<?php echo $this->get_field_id( 'google-plus' ); ?>" name="<?php echo $this->get_field_name( 'google-plus' ); ?>" value="<?php echo $instance['google-plus']; ?>" style="width:100%;" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'pinterest' ); ?>"><?php _e('pinterest:', 'social'); ?></label>
                <input id="<?php echo $this->get_field_id( 'pinterest' ); ?>" name="<?php echo $this->get_field_name( 'pinterest' ); ?>" value="<?php echo $instance['pinterest']; ?>" style="width:100%;" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'tumblr' ); ?>"><?php _e('tumblr:', 'social'); ?></label>
                <input id="<?php echo $this->get_field_id( 'tumblr' ); ?>" name="<?php echo $this->get_field_name( 'tumblr' ); ?>" value="<?php echo $instance['tumblr']; ?>" style="width:100%;" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'vimeo-square' ); ?>"><?php _e('vimeo-square:', 'social'); ?></label>
                <input id="<?php echo $this->get_field_id( 'vimeo-square' ); ?>" name="<?php echo $this->get_field_name( 'vimeo-square' ); ?>" value="<?php echo $instance['vimeo-square']; ?>" style="width:100%;" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'rss' ); ?>"><?php _e('rss:', 'social'); ?></label>
                <input id="<?php echo $this->get_field_id( 'rss' ); ?>" name="<?php echo $this->get_field_name( 'rss' ); ?>" value="<?php echo $instance['rss']; ?>" style="width:100%;" />
            </p>
            
       
        <?php
    }
    }
?>