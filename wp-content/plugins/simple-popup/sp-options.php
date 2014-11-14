<?php


add_action('admin_menu', 'sp_create_menu');

function sp_create_menu() {

	//create new top-level menu
	add_menu_page('SimplePop', 'SimplePop', 'manage_options', __FILE__, 'sp_settings_page');

	//call register settings function
	add_action( 'admin_init', 'register_mysettings' );
}


function register_mysettings() {
	//register our settings
	register_setting( 'sp-settings-group', 'popup_box_content' );
	register_setting( 'sp-settings-group', 'popup_box_delay' );
	register_setting( 'sp-settings-group', 'popup_box_border_color' );
	register_setting( 'sp-settings-group', 'popup_box_border_width');
	register_setting( 'sp-settings-group', 'popup_box_rounded_corner');
	register_setting( 'sp-settings-group', 'popup_box_enabled');
	register_setting( 'sp-settings-group', 'popup_box_floating');
	register_setting( 'sp-settings-group', 'popup_box_visits');
}

function sp_settings_page() {
?>
<div class="wrap">
<h2>WordPress SimplePop Options</h2>

<form method="post" action="options.php">
    <?php settings_fields( 'sp-settings-group' ); ?>
    <?php //do_settings( 'baw-settings-group' ); ?>
    <table class="form-table">
        
    	 <th scope="row">Enabled</th>
        <td>
        	<?php $popup_is_enabled = get_option('popup_box_enabled');  ?>
        	<input type="radio" name="popup_box_enabled" value="true" <?php echo ($popup_is_enabled == 'true' ? 'checked=checked' : '' )  ?>  />Yes
        	<input type="radio" name="popup_box_enabled" value="false" <?php echo ($popup_is_enabled == 'false' ? 'checked=checked' : '' )  ?> />No
        	
        </tr>
         
        <tr valign="top">
        <th scope="row">Delay Time</th>
        <td><input type="text" name="popup_box_delay" value="<?php echo get_option('popup_box_delay'); ?>" />ms</td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Floating Box</th>
        <td>
        	<?php $popup_is_floating = get_option('popup_box_floating');  ?>
        	<input type="radio" name="popup_box_floating" value="true" <?php echo ($popup_is_floating == 'true' ? 'checked=checked' : '' )  ?>  />Yes
        	<input type="radio" name="popup_box_floating" value="false" <?php echo ($popup_is_floating == 'false' ? 'checked=checked' : '' )  ?> />No
        	
        </td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Border Color</th>
        <td><input type="color" name="popup_box_border_color" value="<?php echo get_option('popup_box_border_color'); ?>" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Border Width</th>
        <td><input type="number" name="popup_box_border_width" value="<?php echo get_option('popup_box_border_width'); ?>" />px</td>
        </tr>
        <tr valign="top">
        <th scope="col">Rounded Corners (true/false)</th>
        <td><input type="text" name="popup_box_rounded_corner" value="<?php echo get_option('popup_box_rounded_corner'); ?>" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Popup Content</th>
        <td>
        	<?php if ( function_exists( 'wp_editor' ) ): ?>
        		<?php wp_editor( get_option('popup_box_content'), 'popup_box_content' ) ?>	
        	<?php else: ?>
        		<textarea rows="20" cols="60" id="popup_box_content" name="popup_box_content"><?php echo  get_option('popup_box_content'); ?></textarea>
        		<p class="description">The visual editor is only supported on WordPress version 3.3+ please upgrade your WP installation to use visual editor with this plugin.</p>
        	<?php endif; ?>
        </td>
        </tr>
        
    </table>
    
    <p class="submit">
    <input type="submit" class="button-primary"  value="<?php _e('Save Changes') ?>" />
    </p>

</form>
</div>
<?php } ?>