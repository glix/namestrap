<?php

/*
Plugin Name: Wordpress Popup Scheduler
Plugin URI: http://maketecheasier.com/
Description: Wp Popup Scheduler allows you to add a popup box to your blog. You can customize the popup to suit your blog theme and schedule it to popup as and when you like it. 
Version: 1.3.1
Author: Damien Oh
Author URI: http://maketecheasier.com/about

Copyright 2007  Damien Oh  (email : damien@maketecheasier.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


$WPS_config = array ('enable_popup' => "0",
'popup_title' => "Welcome Back!",
'display_message' => "Thanks for reading my blog. If you like what I write, why not subscribe to my feed?<br><br>If you are busy, I can send the latest post to your email. Just subscribe to my email updates.<br><br>Your Name", 
'close_text' => "[Close Window]",
'display_page' => "single",
'popup_destination' => "http://",
'popup_width' => "400",
'popup_left' => "200",
'popup_top' => "200",
'popup_position' => "center",
'show_popup_on' => "visitor_return",
'schedule_option' => "",
'delaytime' => "0",
'autoscroll'=> "1",
'show_popup_interval' => "3",
'next_display_date' => "",
'return_count' => "3",
'popup_day' => "01",
'popup_mth' =>"01",
'popup_yr' => "2008",
'show_popup_consec' => "1",
'display_style' => "popup",
'background_color' => "#FFFFFF",
'closetext_color' => "#FFFFFF",
'headline_color' => "#FFFFFF",
'headline_align' => "center",
'wps_path' => "",
'rich_text'=>"1",
'content_hash'=>"");

add_option('WPS_setting', $WPS_config, 'Settings for WordPress Popup Scheduler');

$WPS = get_option("WPS_setting");
// Pre-2.6 compatibility
if ( ! defined( 'WP_CONTENT_URL' ) )
      define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
if ( ! defined( 'WP_PLUGIN_URL' ) )
      define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );

$WPS['wps_path'] = WP_PLUGIN_URL.'/wp-popup-scheduler/';
update_option('WPS_setting', $WPS);

if(isset($_POST['check_post']) && $_POST['check_post']==1)
{	if(isset($_POST['enable_popup']))
	{  $WPS['enable_popup'] = "1";
	}else {
		$WPS['enable_popup'] = "0";
	}
	if(isset($_POST['rich_text']))
	{	$WPS['rich_text'] = "1";
	}else
	{	$WPS['rich_text'] = "2";
	}
	if(isset($_POST['autoscroll']))
	{  $WPS['autoscroll'] = "1";
	}else {
		$WPS['autoscroll'] = "0";
	}
	$WPS['popup_title'] = strip_tags($_POST['headline_text']);
	$disp_msg = $_POST['display_message'];
	$WPS['display_message'] = strTrimTotal($disp_msg);
	$WPS['content_hash'] = md5($WPS['display_message'].$WPS['popup_title']);
	$WPS['close_text'] = strip_tags($_POST['close_text']);
	$WPS['display_page'] = $_POST['display_page'];
	if($WPS['display_page']=="other") $WPS['popup_destination'] = $_POST['popup_destination'];
	$show_popup_on = $_POST['show_popup_on'];
	$WPS['show_popup_on'] = $show_popup_on;
	if($_POST['delaytime']=="") $WPS['delaytime'] = "0";
	else	$WPS['delaytime'] = $_POST['delaytime'];
	if($show_popup_on == "visitor_return")
	{	
		$WPS['return_count'] = $_POST['return_count'];
	}elseif ($show_popup_on == "schedule")
	{
		$WPS['popup_day'] = $_POST['popup_day'];
		$WPS['popup_mth'] = $_POST['popup_mth'];
		$WPS['popup_yr'] = $_POST['popup_yr'];
		$WPS['schedule_option'] = $_POST['schedule_option'];
		if($WPS['schedule_option'] == "consecutive")
			$WPS['show_popup_consec'] = $_POST['show_popup_consec'];
		else
		{
			$WPS['show_popup_interval'] = $_POST['show_popup_interval'];		
			$current_date = date('Ymd');
			$display_date = date('Ymd',mktime(0,0,0,$WPS['popup_mth'],$WPS['popup_day'],$WPS['popup_yr']));
			while ($display_date < $current_date)
			{	$display_date += $WPS['show_popup_interval'];
			}				
			$WPS['next_display_date'] = $display_date;
		}
	}
	$WPS['display_style'] = $_POST['display_style'];
	$WPS['background_color'] = $_POST['bg_color'];
	$WPS['closetext_color'] = $_POST['closetext_color'];
	$WPS['headline_color'] = $_POST['headline_color'];
	$WPS['popup_width'] = $_POST['popup_width'];
	$WPS['popup_height'] = $_POST['popup_height'];
	$WPS['popup_position'] = $_POST['popup_position'];
	$WPS['headline_align'] = $_POST['headline_align'];
	if($WPS['popup_position'] == "user-defined"){
		$WPS['popup_left'] = $_POST['popup_left'];
		$WPS['popup_top'] = $_POST['popup_top'];
	}
	update_option('WPS_setting', $WPS);
	$message = "Popup configuration saved successfully.";
}

add_action('admin_menu', 'WPS_add_option_page');
add_action('init', 'WPS_set_cookie');
	
if($WPS['enable_popup']=="1")
{	add_action('wp_head', 'load_popup_css');
	$url = parse_url(get_option('home'));
	$displayed_mode = $WPS['display_style'];
	
	if($WPS['show_popup_on']=="everytime")
	{	if($displayed_mode != "before_post" && $displayed_mode != "after_post")
			add_filter('wp_footer', 'load_WPS_message');
		else
			add_filter('the_content', 'WPS_hook');
	}
	else if($WPS['show_popup_on']=="new_visitor" && $_COOKIE["WPS_return_count"] < 1)
	{	if($displayed_mode != "before_post"  && $displayed_mode != "after_post")
			add_filter('wp_footer', 'load_WPS_message');
		else
			add_filter('the_content', 'WPS_hook');
	}
	else if($WPS['show_popup_on']=="visitor_return" && $_COOKIE["WPS_return_count"] == ($WPS['return_count']-1))
	{	if($displayed_mode != "before_post"  && $displayed_mode != "after_post")
			add_filter('wp_footer', 'load_WPS_message');
		else
			add_filter('the_content', 'WPS_hook');
	}
	else if($WPS['show_popup_on']=="schedule" && $WPS['schedule_option'] == "consecutive" && $WPS['show_popup_consec']!=0)
	{	$schedule_start_date = date('Ymd',mktime(0,0,0,$WPS['popup_mth'],$WPS['popup_day'],$WPS['popup_yr']));
		$schedule_end_date = date('Ymd',mktime(0,0,0,$WPS['popup_mth'],$WPS['popup_day']+$WPS['show_popup_consec']-1,$WPS['popup_yr']));
		$current_date = date('Ymd');
		if($current_date >= $schedule_start_date && $current_date <= $schedule_end_date)
		{	if($_COOKIE['WPS_display_count']<1)
			{	setcookie("WPS_display_count",2, time()+60*60*24, $url['path']."/");
				if($displayed_mode != "before_post" && $displayed_mode != "after_post")
					add_filter('wp_footer', 'load_WPS_message');
				else
					add_filter('the_content', 'WPS_hook');
			}
		}
	}
	else if( $WPS['show_popup_on'] == "onupdate") 
	{
		if ($_COOKIE['WPS_content_hash'] != $WPS['content_hash']) 
		{	setcookie('WPS_content_hash', $WPS['content_hash']);
			if($displayed_mode != "before_post"  && $displayed_mode != "after_post") 
				add_filter('wp_footer', 'load_WPS_message');
			else 	
				add_filter('the_content', 'WPS_hook');
		}
	}
	else if($WPS['show_popup_on']=="schedule" && $WPS['schedule_option'] == "interval")
	{	$current_date = date('Ymd');
		if($current_date == $WPS['next_display_date'])
		{	if($_COOKIE['WPS_display_count']<1)  
			{	
				setcookie("WPS_display_count",2, time()+60*60*24, $url['path']."/");
				if($displayed_mode != "before_post" && $displayed_mode != "after_post")
					add_filter('wp_footer', 'load_WPS_message');
				else
					add_filter('the_content', 'WPS_hook');
			}
		}
		elseif($current_date > $WPS['next_display_date'])
		{	$wps_yr = substr($WPS['next_display_date'],0,4);
			$wps_mth = substr($WPS['next_display_date'],4,2);
			$wps_day = substr($WPS['next_display_date'],6,2);
			$WPS['next_display_date'] =date('Ymd',mktime(0,0,0,$wps_mth,$wps_day+$WPS['show_popup_interval'],$wps_yr));
			update_option('WPS_setting', $WPS);
		}
	}
}

////////////////////////////////////// functions //////////////////////////////////////////////////////////////////////////

function WPS_add_option_page ()
{
	add_options_page('WP Popup Scheduler', 'WP Popup Scheduler', 8, basename(__FILE__), 'WPS_option_page');
}
	
function WPS_option_page ()
{
	global $message,$user_ID;
	$rich_text_msg = "";
	$WPS = get_option("WPS_setting");
	if($message!="") {
?>
	<div class="updated"><strong><p><?php echo _e($message); ?></p></strong></div>
<?php }
?>	<a name="top"></a>
	<?php load_popup_css(); ?>
     <?php if($WPS['rich_text']==NULL || $WPS['rich_text']==1){ ?>
    	<?php $rich_text_msg = 'checked="checked"'; ?>
	<script>
	 	var full_path = '<?php echo $WPS['wps_path'].'editor/'; ?>';
	</script>
    <script language="JavaScript" type="text/javascript" src="<?php echo $WPS['wps_path'].'editor/jscripts/tiny_mce/tiny_mce.js'; ?>"></script> 
     <script type="text/javascript">
tinyMCE.init({
	plugins : "paste,inlinepopups",
	theme : "advanced",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_buttons1 : "bold,italic,underline, strikethrough, bullist, numlist,outdent, indent,justifyleft, justifycenter, justifyright, justifyfull,undo, redo, link, unlink,cleanup,image",
	theme_advanced_buttons2 : "fontsizeselect,fontselect,formatselect, underline, forecolor, cut,paste,pastetext, pasteword, removeformat, hr,code,",
	theme_advanced_buttons3 : "",
	theme_advanced_source_editor_width : "400",
	theme_advanced_source_editor_height : "400",
	mode : "exact",
	elements : "display_message" 
});
</script>
	<?php } ?>
	 <script type="text/javascript" src="<?php echo $WPS['wps_path']."simple_popup.js";?>"></script>
	<div class="wrap">
        <h2><?php _e("WordPress Popup Scheduler Option");?></h2>
		<p><?php _e("A multi-purpose, fully customizable popup scheduler <em>(Note: This plugin requires your readers to have cookie and javascript enabled on their browser)");?></em></p>
		<p><a href="http://maketecheasier.com/wordpress-plugins/wordpress-popup-scheduler"><?php _e("How to use it?");?></a></p>
		<p><a href="http://maketecheasier.com/wordpress-plugins/wordpress-popup-scheduler#comment"><?php _e("Comments and suggestions");?></a></p>
		<p>&nbsp;</p>
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=wp-popup-scheduler.php" id="popup_form">
		<input type="hidden" name="check_post" value="1" />
		<h3><?php _e("When to show your popup?");?></h3>
		<table cellspacing="5px">
		<tr><td><input type="radio" name="show_popup_on" value="new_visitor" <?php if($WPS['show_popup_on']=="new_visitor") echo 'checked="checked"';?> /></td><td><?php _e("when new visitors arrived.");?></td></tr>
		<tr><td><input type="radio" name="show_popup_on" value="visitor_return" <?php if($WPS['show_popup_on']=="visitor_return") echo 'checked="checked"';?>/></td><td> <?php _e("When visitors return for the ");?><select name="return_count">
			<option <?php if($WPS['return_count']==2) echo 'selected="selected" ';?> value="2"><?php _e("second");?></option>
			<option <?php if($WPS['return_count']==3) echo 'selected="selected" ';?> value="3"><?php _e("third");?></option>
			<option <?php if($WPS['return_count']==4) echo 'selected="selected" ';?> value="4"><?php _e("fourth");?></option>
			<option <?php if($WPS['return_count']==5) echo 'selected="selected" ';?> value="5"><?php _e("fifth");?></option>
			</select> <?php _e("visit.");?></td></tr>
		<tr><td><input type="radio" name="show_popup_on" value="schedule" <?php if($WPS['show_popup_on']=="schedule") echo 'checked="checked"';?>/></td><td><?php _e("starting from");?> <select name="popup_day">
	<option value="01" <?php if($WPS['popup_day']=="01") echo 'selected="selected" ';?>>1</option>
	<option value="02" <?php if($WPS['popup_day']=="02") echo 'selected="selected" ';?>>2</option>
	<option value="03" <?php if($WPS['popup_day']=="03") echo 'selected="selected" ';?>>3</option>
	<option value="04" <?php if($WPS['popup_day']=="04") echo 'selected="selected" ';?>>4</option>
	<option value="05" <?php if($WPS['popup_day']=="05") echo 'selected="selected" ';?>>5</option>
	<option value="06" <?php if($WPS['popup_day']=="06") echo 'selected="selected" ';?>>6</option>
	<option value="07" <?php if($WPS['popup_day']=="07") echo 'selected="selected" ';?>>7</option>
	<option value="08" <?php if($WPS['popup_day']=="08") echo 'selected="selected" ';?>>8</option>
	<option value="09" <?php if($WPS['popup_day']=="09") echo 'selected="selected" ';?>>9</option>
	<option value="10" <?php if($WPS['popup_day']=="10") echo 'selected="selected" ';?>>10</option>
	<option value="11" <?php if($WPS['popup_day']=="11") echo 'selected="selected" ';?>>11</option>
	<option value="12" <?php if($WPS['popup_day']=="12") echo 'selected="selected" ';?>>12</option>
	<option value="13" <?php if($WPS['popup_day']=="13") echo 'selected="selected" ';?>>13</option>
	<option value="14" <?php if($WPS['popup_day']=="14") echo 'selected="selected" ';?>>14</option>
	<option value="15" <?php if($WPS['popup_day']=="15") echo 'selected="selected" ';?>>15</option>
	<option value="16" <?php if($WPS['popup_day']=="16") echo 'selected="selected" ';?>>16</option>
	<option value="17" <?php if($WPS['popup_day']=="17") echo 'selected="selected" ';?>>17</option>
	<option value="18" <?php if($WPS['popup_day']=="18") echo 'selected="selected" ';?>>18</option>
	<option value="19" <?php if($WPS['popup_day']=="19") echo 'selected="selected" ';?>>19</option>
	<option value="20" <?php if($WPS['popup_day']=="20") echo 'selected="selected" ';?>>20</option>								
	<option value="21" <?php if($WPS['popup_day']=="21") echo 'selected="selected" ';?>>21</option>
	<option value="22" <?php if($WPS['popup_day']=="22") echo 'selected="selected" ';?>>22</option>
	<option value="23" <?php if($WPS['popup_day']=="23") echo 'selected="selected" ';?>>23</option>
	<option value="24" <?php if($WPS['popup_day']=="24") echo 'selected="selected" ';?>>24</option>
	<option value="25" <?php if($WPS['popup_day']=="25") echo 'selected="selected" ';?>>25</option>
	<option value="26" <?php if($WPS['popup_day']=="26") echo 'selected="selected" ';?>>26</option>
	<option value="27" <?php if($WPS['popup_day']=="27") echo 'selected="selected" ';?>>27</option>
	<option value="28" <?php if($WPS['popup_day']=="28") echo 'selected="selected" ';?>>28</option>
	<option value="29" <?php if($WPS['popup_day']=="29") echo 'selected="selected" ';?>>29</option>
	<option value="30" <?php if($WPS['popup_day']=="30") echo 'selected="selected" ';?>>30</option>
	<option value="31" <?php if($WPS['popup_day']=="31") echo 'selected="selected" ';?>>31</option>
	</select>&nbsp;
	<select name="popup_mth">
	<option value="01" <?php if($WPS['popup_mth']=="01") echo 'selected="selected" ';?>><?php _e("Jan");?></option>
	<option value="02" <?php if($WPS['popup_mth']=="02") echo 'selected="selected" ';?>><?php _e("Feb");?></option>
	<option value="03" <?php if($WPS['popup_mth']=="03") echo 'selected="selected" ';?>><?php _e("Mar");?></option>
	<option value="04" <?php if($WPS['popup_mth']=="04") echo 'selected="selected" ';?>><?php _e("Apr");?></option>
	<option value="05" <?php if($WPS['popup_mth']=="05") echo 'selected="selected" ';?>><?php _e("May");?></option>
	<option value="06" <?php if($WPS['popup_mth']=="06") echo 'selected="selected" ';?>><?php _e("Jun");?></option>
	<option value="07" <?php if($WPS['popup_mth']=="07") echo 'selected="selected" ';?>><?php _e("Jul");?></option>
	<option value="08" <?php if($WPS['popup_mth']=="08") echo 'selected="selected" ';?>><?php _e("Aug");?></option>
	<option value="09" <?php if($WPS['popup_mth']=="09") echo 'selected="selected" ';?>><?php _e("Sep");?></option>
	<option value="10" <?php if($WPS['popup_mth']=="10") echo 'selected="selected" ';?>><?php _e("Oct");?></option>
	<option value="11" <?php if($WPS['popup_mth']=="11") echo 'selected="selected" ';?>><?php _e("Nov");?></option>
	<option value="12" <?php if($WPS['popup_mth']=="12") echo 'selected="selected" ';?>><?php _e("Dec");?></option>
	</select> &nbsp;
	<select name="popup_yr">
	<option value="2008" <?php if($WPS['popup_yr']=="2008") echo 'selected="selected" ';?>>2011</option>
	<option value="2009" <?php if($WPS['popup_yr']=="2009") echo 'selected="selected" ';?>>2012</option>
   	<option value="2010" <?php if($WPS['popup_yr']=="2010") echo 'selected="selected" ';?>>2013</option>
   	<option value="2010" <?php if($WPS['popup_yr']=="2010") echo 'selected="selected" ';?>>2014</option>
   	<option value="2010" <?php if($WPS['popup_yr']=="2010") echo 'selected="selected" ';?>>2015</option>
   	<option value="2010" <?php if($WPS['popup_yr']=="2010") echo 'selected="selected" ';?>>2016</option>
   	<option value="2010" <?php if($WPS['popup_yr']=="2010") echo 'selected="selected" ';?>>2017</option>
	</select></td>
		<td><p><input type="radio" name="schedule_option" value="consecutive" <?php if($WPS['schedule_option']=="consecutive") echo 'checked="checked"';?> /> <?php _e("for");?> <input type="text" name="show_popup_consec" value="<?php echo $WPS['show_popup_consec'];?>" maxlength="3" size="1" /> <?php _e("days");?></p>
		<p><input type="radio" name="schedule_option" value="interval" <?php if($WPS['schedule_option']=="interval") echo 'checked="checked"';?>/> <?php _e("every");?> <input type="text" name="show_popup_interval" maxlength="2" size="2" value="<?php echo $WPS['show_popup_interval']; ?>" /> <?php _e("days");?></p></td></tr>
		<tr><td><input type="radio" name="show_popup_on" id="show_popup_everytime" value="everytime" <?php if($WPS['show_popup_on']=="everytime") echo 'checked="checked"';?> onclick="checkDisplay()"/></td><td><?php _e("at all time");?>.</td></tr>
		<tr><td><input type="radio" name="show_popup_on" value="onupdate" <?php if($WPS['show_popup_on']=="onupdate") echo 'checked="checked"';?> /></td><td><?php _e("whenever you make changes to the popup content.");?></td></tr></table>
		<p>&nbsp;</p>
        <h3><?php _e("Set delay for popup");?></h3>
        <p>Delay for <input type="text" size="2" maxlength="3" name="delaytime" id="delaytime" value="<?php echo $WPS['delaytime']; ?>" onkeyup="checkDelayTime();" /> seconds before showing popup?  <em>(0 for no delay)</em></p>
		<p>&nbsp;</p>
        <h3><?php _e("Where to show your popup?");?></h3>
		<table>
		<tr><td><input type="radio" name="display_page" value="home" <?php if($WPS['display_page']=="home") echo 'checked="checked"'?> /></td><td><?php _e("Home page");?></td></tr>
		<tr><td><input type="radio" name="display_page" value="single" id="show_popup_single" <?php if($WPS['display_page']=="single") echo 'checked="checked"'?>/></td><td><?php _e("Visitor landing page");?></td></tr>
		<tr><td><input type="radio" name="display_page" value="other" <?php if($WPS['display_page']=="other") echo 'checked="checked"'?>/></td><td><?php _e("A specific page");?>. <input type="text" name="popup_destination" size="40" value="<?php echo $WPS['popup_destination']; ?>" /></td></tr></table> 
		<p>&nbsp;</p>
		<table><tr><td rowspan="2" valign="top">Display popup on </td><td valign="top" colspan="2"><input type="radio" name="popup_position" value="center" <?php if($WPS['popup_position']=="center") echo 'checked="checked"';  ?> /> <?php _e("center of screen");?></td></tr>
		<tr><td valign="top"><input type="radio" name="popup_position" value="user-defined" <?php if($WPS['popup_position']=="user-defined") echo 'checked="checked"';  ?> /> <?php _e("set popup location: ");?></td><td> Left: <input type="text" maxlength="4" name="popup_left" id="popup_left" size="4" value="<?php echo $WPS['popup_left'];?>" />px <?php _e("(input <strong><em>-1</em></strong> to centralize horizontally. Enter number only)");?><br /><?php _e("Top");?>: <input type="text" maxlength="4" size="4" name="popup_top" id="popup_top" value="<?php echo $WPS['popup_top']; ?>"  />px <?php _e("(input <strong><em>-1</em></strong> to centralize vertically. Enter number only)");?>. </td></tr></table>
		<p>&nbsp;</p>
		<h3><?php _e("How to show your popup?");?></h3>
		<table>
		<tr><td><input type="radio" name="display_style" value="before_post" <?php if($WPS['display_style']=="before_post") echo 'checked="checked" ';?> /></td><td><?php _e("No effect - place before first post");?></td></tr>
		<tr><td><input type="radio" name="display_style" value="after_post" <?php if($WPS['display_style']=="after_post") echo 'checked="checked" ';?>></td><td><?php _e("No effect - place after first post");?></td></tr>
		<tr><td><input type="radio" name="display_style" value="popup" <?php if($WPS['display_style']=="popup") echo 'checked="checked" ';?> ></td><td><?php _e("Simple Popup");?></td></tr>
		<tr><td><input type="radio" name="display_style" value="dropdown" <?php if($WPS['display_style']=="dropdown") echo 'checked="checked" ';?> ></td><td><?php _e("Drop down");?></td></tr>
		<tr><td><input type="radio" name="display_style" value="fadein" <?php if($WPS['display_style']=="fadein") echo 'checked="checked" ';?> ></td><td><?php _e("Fade In");?></td></tr>
		<tr><td><input type="radio" name="display_style" value="lightbox" <?php if($WPS['display_style']=="lightbox") echo 'checked="checked" ';?> ></td><td><?php _e("Lightbox");?></td></tr>
		</table>
		<p>&nbsp;</p>
		<h3><?php _e("What to show on your popup?");?></h3>
		<p>Popup width: <input type="text" name="popup_width" id="popup_width" size="2"maxlength="3" value="<?php echo $WPS['popup_width'];?>" />px</p>
		<table><tr><td><?php _e("Type your close popup text:");?> <input type="text" id="close_text" name="close_text" size="40" value="<?php echo htmlspecialchars(stripslashes($WPS['close_text'])); ?>" /></td><td><?php _e("Color:");?> <input type="text" id="close_color" name="closetext_color" size="7" maxlength="7" value="<?php echo $WPS['closetext_color'];?>" /></td><td> <div id="close_selectedColor" style="width:40px;height:20px;border: #000000 solid thin; cursor:pointer; background-color:<?php echo $WPS['closetext_color'];?>" onclick="document.getElementById('close_selectColor').style.display = 'block'"></div></td><td><div id="close_selectColor" style="cursor:pointer;display:none"><?php color_picker('close'); ?></div></td></tr></table>
		<p><?php _e("Type your popup headline here");?></p>
		<table><tr><td><input type="text" id="headline_text" name="headline_text" value="<?php echo htmlspecialchars(stripslashes($WPS['popup_title'])); ?>" size="40" /></td><td><?php _e("Align:");?> <select name="headline_align"><option value="center" <?php if($WPS['headline_align']=="center") echo 'selected="selected"'; ?>><?php _e("Center");?></option>
												<option value="left" <?php if($WPS['headline_align']=="left") echo 'selected="selected"'; ?>><?php _e("Left");?></option>
												<option value="right" <?php if($WPS['headline_align']=="right") echo 'selected="selected"'; ?>><?php _e("Right");?></option>
				</select></td><td><td><?php _e("Color:");?> <input type="text" id="headline_color" name="headline_color" size="7" maxlength="7" value="<?php echo $WPS['headline_color'];?>" /></td><td> <div id="headline_selectedColor" style="width:40px;height:20px;border: #000000 solid thin;cursor:pointer; background-color:<?php echo $WPS['headline_color'];?>" onclick="document.getElementById('headline_selectColor').style.display = 'block'"></div></td><td><div id="headline_selectColor" style="cursor:pointer;display:none"><?php color_picker('headline'); ?></div></td></tr></table>
        <h3><?php _e("Rich Text Editor");?></h3>
        <p><input type="checkbox" name="rich_text" <?php echo $rich_text_msg; ?> /> <?php _e("Use rich text editor to compose message?"); ?></p>
		<p><?php _e("Type the message that you want to display");?></p>
		
		<textarea name="display_message" id="display_message" cols="60" rows="15" ><?php echo stripslashes($WPS['display_message']); ?></textarea>
		<p><input type="checkbox" name="autoscroll" <?php if($WPS['autoscroll']=="1") echo 'checked="checked"'; ?> /> <?php _e("Enable Autoscrolling. (The Popup will follow as the user scrolls down the page.)"); ?></p>
		<br/>(Note: You can also change the look and feel of the popup via the popup_css.css file in the wp-popup-scheduler folder)
        <p>&nbsp;</p> 
			<script type="text/javascript">
			function checkDisplay()
			{ 	show_popup_everytime = document.getElementById('show_popup_everytime');
				show_popup_single = document.getElementById('show_popup_single');
				if(show_popup_everytime.checked && show_popup_single.checked)
				{	alert("The combination of displaying your popup at all time and at visitor landing page will show your popup at every single page. This could cause annoyance to your readers. Are you sure you want to do this?");
				}
			}
			
			function checkDelayTime()
			{
				delaytime = document.getElementById('delaytime').value;
				if(!(delaytime>=0 && delaytime<=999))
				{	alert("Only numbers are allowed for the delay time");
					document.getElementById('delaytime').value = "";
					document.getElementById('delaytime').focus();
					return false;
				}
			}
			function updateColor(color,location)
			{	document.getElementById(location+'_selectedColor').style.backgroundColor = color;
				document.getElementById(location+'_color').value = color;
			}
			
			function selectColor(color,location)
			{	document.getElementById(location+'_selectedColor').style.backgroundColor = color;
				document.getElementById(location+'_color').value = color;
				document.getElementById(location+'_selectColor').style.display = 'none';
			}
			
			function getRadioCheckedValue(radio_name) 
			{	var oRadio = document.forms[0].elements[radio_name];
				for(var i = 0; i < oRadio.length; i++) 
				{	if(oRadio[i].checked) 
					{	return oRadio[i].value;
					}
				}
				return '';
			} 
						
			function preview_popup()
			{	var closetext = '<span style="color:'+document.getElementById('close_color').value+'">'+document.getElementById('close_text').value+'</span>';
				var popup_title = '<span style="color:'+document.getElementById('headline_color').value+'">'+document.getElementById('headline_text').value+'</span>';
				var effect = getRadioCheckedValue('display_style');
				var popup_content = document.getElementById('display_message').value;	
				var headline_align = document.getElementById('popup_form').elements['headline_align'];
				headline_align = headline_align.options[headline_align.selectedIndex].value;
				if(effect == "lightbox")
				{	popup_content = '<div class="wps_closewin_text" align="right"><br/><a href="" onclick="document.getElementById(\'WPS_preview\').style.visibility=\'hidden\';document.getElementById(\'lightbox_div\').style.visibility=\'hidden\';return false;">'+closetext+'</a><br/><br/></div><div class="wps_headline"><h2 align="'+headline_align+'">'+popup_title+'</h2><p>'+popup_content+'</p></div>';
				}
				else
				{	popup_content = '<div class="wps_closewin_text" align="right"><br/><a href="" onclick="document.getElementById(\'WPS_preview\').style.visibility=\'hidden\';return false;">'+closetext+'</a><br/><br/></div><div class="wps_headline"><h2 align="'+headline_align+'">'+popup_title+'</h2><p>'+popup_content+'</p></div>';
				}
				var bg_color = document.getElementById('bg_color').value;
				var popup_width = document.getElementById('popup_width').value;
				var popup_position = getRadioCheckedValue('popup_position');
				var popup_left = "";
				popup_top = "";
				if(popup_position == 'center')
				{	popup_left = popupLeftPosition(popup_width);
					popup_top = popupTopPosition();
				}else
				{	popup_left = document.getElementById('popup_left').value;
					popup_top = document.getElementById('popup_top').value;
				}
				document.getElementById('WPS_preview').style.left = popup_left+'px';
				document.getElementById('WPS_preview').style.backgroundColor = bg_color;
				document.getElementById('WPS_preview').style.width = popup_width+'px';
				document.getElementById('WPS_preview').innerHTML = popup_content;
					
				if(effect == "popup")
				{ 	document.getElementById('WPS_preview').style.visibility = "visible";
					document.getElementById('WPS_preview').style.top = popup_top+ "px";
				}
				else if(effect == "dropdown")
				{	document.getElementById('WPS_preview').style.visibility = "visible";
					document.getElementById('WPS_preview').style.top = "-400px";
					document.getElementById('WPS_preview').animation = setInterval('DropDownEffect(document.getElementById("WPS_preview"),popup_top,10)',60);
				}
				else if(effect == "fadein")
				{	document.getElementById('WPS_preview').style.top = popup_top + "px";
					document.getElementById('WPS_preview').fade = 0;
					document.getElementById('WPS_preview').animation = setInterval('fadeIn(document.getElementById("WPS_preview"))',150);
				}
				else if(effect == "lightbox")
				{	pageheight = getPageHeight();
					document.getElementById('lightbox_div').style.height = pageheight+'px';
					lightbox(document.getElementById('lightbox_div'));
					document.getElementById('WPS_preview').style.top = popup_top + "px";
					document.getElementById('WPS_preview').style.visibility = "visible";
				}
			}
			
			</script>
		<table border="0"><tr><td><?php _e("Pick background color:");?> <input type="text" name="bg_color" id="bg_color" size="8" value="<?php echo $WPS['background_color']; ?>"/></td><td><div id="bg_selectedColor" style="width:40px; height:20px; border:thin solid #000000; cursor:pointer; background-color:<?php echo $WPS['background_color']; ?>" onclick="document.getElementById('bg_selectColor').style.display = 'block'"></div></a></td><td><div id="bg_selectColor" style="cursor:pointer;display:none"><?php color_picker('bg'); ?></div></td></tr></table>
		<p>&nbsp;</p>		
        <div style="border:thin dashed #666666;width:600px;padding:10px"><strong>Preview</strong>
        <ul style="margin-left:15px;list-style:circle; ">
        <li>Preview only works when <em>simple popup</em>, <em>dropdown</em>, <em>fade in</em>  or <em>lightbox</em> is selected.</li>
        <li>Depending on theme that you have used on your site, the actual font might differ from the preview font</li>
        	<li>If you have make changes to the display message, please save first before viewing the preview.</li></ul>
        </p><a href="#top" onclick="preview_popup(this);" style="font-size:medium">Click Here To See The Preview Popup</a></p>
        </div>
    	<p>&nbsp;</p>
		<p><input type="checkbox" name="enable_popup" <?php if($WPS['enable_popup']==1) echo 'checked ="checked"'; ?>/> <?php _e("Enable pop-up");?></p>
         <p class="submit"><input type="submit" name="Submit" value="<?php _e('Update Options') ?>" />
</p>
	</form>      
	<h2><?php _e("Support");?></h2>
	<p><?php _e("Support can be found at ");?><a href="http://maketecheasier.com/wordpress-plugins/wordpress-popup-scheduler"><?php _e("WP-Popup-Scheduler Support page");?></a></p>
	<p><?php _e("If you like this plugin, you can show your support via donation to aid in this plugin development.");?> </p>
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but21.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
">
</form>
	<div id="WPS_preview" class="wps_popup" style="margin:auto;z-index:100;position:absolute;left:0px;top:-400px;visibility:hidden"></div> 
    <div id="lightbox_div" style="overflow:auto;width:100%;background-color:#000000;z-index:50;position:absolute;left:0px;top:0px;visibility:hidden"></div>
	</div>
<?php
}

function WPS_set_cookie () 
{	
	$visit_count = 1;
	$today_date = date('Ymd');
	$display_count = 0;
	$url = parse_url(get_option('home'));
	if(!is_admin()){
		if(isset($_COOKIE['WPS_return_count'])){
			$visit_count = $_COOKIE['WPS_return_count'] + 1;
		}
		setcookie("WPS_return_count",$visit_count, time()+60*60*24*365, $url['path']."/");
		if(isset($_COOKIE['WPS_date']) && $today_date > $_COOKIE['WPS_date']){
			setcookie("WPS_date",$today_date, time()+60*60*24, $url['path']);
			setcookie("WPS_display_count",$display_count, time()+60*60*24,$url['path']."/");
		}
		else if (!isset($_COOKIE['WPS_date'])){
			setcookie("WPS_date",$today_date, time()+60*60*24, $url['path']);
			setcookie("WPS_display_count",$display_count, time()+60*60*24, $url['path']."/");
		}	
	}
}

function load_popup_css() {
	echo "\n".'<!-- Start Of WP Popup Scheduler Script -->'."\n";
	if(@file_exists(TEMPLATEPATH.'/popup_css.css')) {
		echo '<link rel="stylesheet" href="'.get_stylesheet_directory_uri().'/popup_css.css" type="text/css" media="screen" />'."\n";	
	} else {
		echo '<link rel="stylesheet" href="'.get_option('siteurl').'/wp-content/plugins/wp-popup-scheduler/popup_css.css" type="text/css" media="screen" />'."\n";
	}	
	echo '<!-- End Of WP Popup Scheduler Script -->'."\n";
}

function WPS_hook($content='')
{	global $messagedisplayed;
	$WPS = get_option("WPS_setting");
	if(!$messagedisplayed){	
		if(($WPS['display_page']=="home" && is_home()) || ($WPS['display_page']=="single" && !is_feed()))
		{	$popup_code = '<p class="wps_content" style="background-color:'.$WPS['background_color'].'">'.htmlspecialchars_decode(stripslashes($WPS['display_message'])).'</p>';
			$messagedisplayed = true;
			if($WPS['display_style']=="before_post")
				$content = $popup_code.$content;
			else
				$content = $content.$popup_code;
		}
		else if($WPS['display_page']=="other" && $WPS['popup_destination']==get_permalink() &&!is_home())
		{	$popup_code = '<p class="wps_content" style="background-color:'.$WPS['background_color'].'">'.htmlspecialchars_decode(stripslashes($WPS['display_message'])).'</p>';
			$messagedisplayed = true;
			if($WPS['display_style']=="before_post")
				$content = $popup_code.$content;
			else
				$content = $content.$popup_code;
		}
	}
	return $content;
} 

function load_WPS_message()
{
	$WPS = get_option("WPS_setting");
	$display_effect = $WPS['display_style'];
	$popup_content ="";
	$closetext = '<span style="color:'.$WPS['closetext_color'].'">'.$WPS['close_text'].'</span>';
	$popup_title = '<span style="color:'.$WPS['headline_color'].'">'.$WPS['popup_title'].'</span>';
	if($display_effect == "lightbox")
	{	$popup_content = '<div class="wps_closewin_text"><a href="" onclick="document.getElementById(\\\'WPS_popup_message\\\').style.visibility=\\\'hidden\\\';document.getElementById(\\\'lightbox_div\\\').style.visibility=\\\'hidden\\\';return false;">'.$closetext.'</a></div><div class="wps_headline"><h2 align="'.$WPS['headline_align'].'">'.$popup_title.'</h2></div><div class="wps_body">'.htmlentities($WPS['display_message']).'</div>';
	}else
	{	$popup_content = '<div class="wps_closewin_text"><a href="" onclick="document.getElementById(\\\'WPS_popup_message\\\').style.visibility=\\\'hidden\\\';return false;">'.$closetext.'</a></div><div class="wps_headline"><h2 align="'.$WPS['headline_align'].'">'.$popup_title.'</h2></div><div class="wps_body">'.htmlentities($WPS['display_message']).'</div>';
	}
	$cur_url = retrieveURL();
	if(($WPS['display_page']=="home" && is_home()) || $WPS['display_page']=="single")
	{	
?>	<script type="text/javascript" src="<?php echo $WPS['wps_path']."simple_popup_min.js";?>"></script>
	<?php if($WPS['autoscroll']=="1"){ ?>
	<script type="text/javascript" src="<?php echo $WPS['wps_path']."float.js";?>"></script>
	<?php } ?>
	<script type="text/javascript">
		var popup_width = '<?php echo $WPS['popup_width']; ?>';
		var bg_color = '<?php echo $WPS['background_color']; ?>';
		var popup_content = '<?php echo ($popup_content); ?>';
		var effect = '<?php echo $WPS['display_style']; ?>';
		var delay = <?php echo ($WPS['delaytime']*1000); ?>;
		var autoscroll = <?php if($WPS['autoscroll'] ==1) echo '1'; else echo '0'; ?>;
		<?php if($WPS['popup_position']=="center"){
					echo 'var popup_left = "center";';
					echo 'var popup_top = "center";';
			}else{
					if($WPS['popup_left']=="-1") 
						echo 'var popup_left = "center";';
					else
						echo "var popup_left = ".$WPS['popup_left'].";";
					if($WPS['popup_top']==-1) 
						echo 'var popup_top = "center";';
					else
						echo "var popup_top = ".$WPS['popup_top'].";";
			} ?>
		loadPopup(popup_content,bg_color,popup_width,effect,popup_left,popup_top,delay,autoscroll);
	</script>
<?php	}
	else if($WPS['display_page']=="other" && $WPS['popup_destination']==retrieveURL()) 
	{	
?>	<script type="text/javascript" src="<?php echo $WPS['wps_path']."simple_popup_min.js";?>"></script>
<?php if($WPS['autoscroll']=="1"){ ?>
	<script type="text/javascript" src="<?php echo $WPS['wps_path']."float.js";?>"></script>
	<?php } ?>
	<script type="text/javascript">
		 var popup_width = '<?php echo $WPS['popup_width']; ?>';
		 var bg_color = '<?php echo $WPS['background_color']; ?>';
		 var popup_content = '<?php echo $popup_content; ?>';
		var effect = '<?php echo $WPS['display_style']; ?>';
		var delay = <?php echo ($WPS['delaytime']*1000); ?>;
		var autoscroll = <?php if($WPS['autoscroll'] ==1) echo '1'; else echo '0'; ?>;
		 <?php if($WPS['popup_position']=="center"){
					echo 'var popup_left = "center";';
					echo 'var popup_top = "center";';
			}else{
					if($WPS['popup_left']=="-1") 
						echo 'var popup_left = "center";';
					else
						echo "var popup_left = ".$WPS['popup_left'].";";
					if($WPS['popup_top']==-1) 
						echo 'var popup_top = "center";';
					else
						echo "var popup_top = ".$WPS['popup_top'].";";
//					echo "var popup_left = ".$WPS['popup_left'].";";
//					echo "var popup_top = ".$WPS['popup_top'].";";
			} ?>
			loadPopup(popup_content,bg_color,popup_width,effect,popup_left,popup_top,delay,autoscroll);
			<?php if($WPS['autoscroll']=="1"){ ?>
			//start();
			<?php } ?>
	</script>
<?php	}
}

function retrieveURL() { 
	$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : ""; 
	$protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s; 
	$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]); 
	return $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI']; 
} 

function strTrimTotal($input) {
    $input = trim($input);
    for($i=0;$i<strlen($input);$i++) {
        if(substr($input, $i, 1) != " ") {
            $output .= trim(substr($input, $i, 1));
        } else {
            $output .= " ";
        }
    }
    return $output;
}

function strleft($s1, $s2) { 
return substr($s1, 0, strpos($s1, $s2)); 
}

function color_picker($location)
{
	$color_code = array("0","3","6","9","C","F");
 	echo '<table cellspacing="1" style="border:0; background:#000000"><tr>';	
	//output first row of color code
	for($i=0;$i<count($color_code);$i++){
		$hex_color = $color_code[$i].$color_code[$i].$color_code[$i].$color_code[$i].$color_code[$i].$color_code[$i];
		echo "<tr>";
		echo '<td style="background:#000000" onMouseOver="updateColor(\'#000000\',\''.$location.'\')" onClick="selectColor(\'#000000\',\''.$location.'\')" height="10" width="10"></td>';
		echo '<td style="background:#'.$hex_color.'" onMouseOver="updateColor(\'#'.$hex_color.'\',\''.$location.'\')" onClick="selectColor(\'#'.$hex_color.'\',\''.$location.'\')" height="10" width="10"></td>';
		echo '<td style="background:#000000" onMouseOver="updateColor(\'#000000\',\''.$location.'\')" onClick="selectColor(\'#000000\',\''.$location.'\')" height="10" width="10"></td>';
		
		for($j=0;$j<3;$j++){
			for($k=0;$k<count($color_code);$k++){
				$hex_color = $color_code[$j].$color_code[$j].$color_code[$k].$color_code[$k].$color_code[$i].$color_code[$i]; 
				echo '<td style="background:#'.$hex_color.'" onMouseOver="updateColor(\'#'.$hex_color.'\',\''.$location.'\')" onClick="selectColor(\'#'.$hex_color.'\',\''.$location.'\')" height="10" width="10"></td>';
			}
		}
		echo "</tr>";
	}
	for($i=0;$i<count($color_code);$i++){
			
		echo "<tr>";
		switch ($i)
		{ case 0: 
			$hex_color = "FF0000";
			echo '<td style="background:#000000" onMouseOver="updateColor(\'#000000\',\''.$location.'\')" onClick="selectColor(\'#000000\',\''.$location.'\')" height="10" width="10"></td>';
			echo '<td style="background:#'.$hex_color.'" onMouseOver="updateColor(\'#'.$hex_color.'\',\''.$location.'\')" onClick="selectColor(\'#'.$hex_color.'\',\''.$location.'\')" height="10" width="10"></td>';
			echo '<td style="background:#000000" onMouseOver="updateColor(\'#000000\',\''.$location.'\')" onClick="selectColor(\'#000000\',\''.$location.'\')" height="10" width="10"></td>';
			break;
		  case 1:	
		  	$hex_color = "00FF00";
			echo '<td style="background:#000000" onMouseOver="updateColor(\'#000000\',\''.$location.'\')" onClick="selectColor(\'#000000\',\''.$location.'\')" height="10" width="10"></td>';
			echo '<td style="background:#'.$hex_color.'" onMouseOver="updateColor(\'#'.$hex_color.'\',\''.$location.'\')" onClick="selectColor(\'#'.$hex_color.'\',\''.$location.'\')" height="10" width="10"></td>';
			echo '<td style="background:#000000" onMouseOver="updateColor(\'#000000\',\''.$location.'\')" onClick="selectColor(\'#000000\',\''.$location.'\')" height="10" width="10"></td>';
			break;
		  case 2:
		  	$hex_color = "0000FF";
			echo '<td style="background:#000000" onMouseOver="updateColor(\'#000000\',\''.$location.'\')" onClick="selectColor(\'#000000\',\''.$location.'\')" height="10" width="10"></td>';
			echo '<td style="background:#'.$hex_color.'" onMouseOver="updateColor(\'#'.$hex_color.'\',\''.$location.'\')" onClick="selectColor(\'#'.$hex_color.'\',\''.$location.'\')" height="10" width="10"></td>';
			echo '<td style="background:#000000" onMouseOver="updateColor(\'#000000\',\''.$location.'\')" onClick="selectColor(\'#000000\',\''.$location.'\')" height="10" width="10"></td>';
			break;
		  case 3:
		  	$hex_color = "FFFF00";
			echo '<td style="background:#000000" onMouseOver="updateColor(\'#000000\',\''.$location.'\')" onClick="selectColor(\'#000000\',\''.$location.'\')" height="10" width="10"></td>';
			echo '<td style="background:#'.$hex_color.'" onMouseOver="updateColor(\'#'.$hex_color.'\',\''.$location.'\')" onClick="selectColor(\'#'.$hex_color.'\',\''.$location.'\')" height="10" width="10"></td>';
			echo '<td style="background:#000000" onMouseOver="updateColor(\'#000000\',\''.$location.'\')" onClick="selectColor(\'#000000\',\''.$location.'\')" height="10" width="10"></td>';
			break;
		  case 4:
		  	$hex_color = "00FFFF";
			echo '<td style="background:#000000" onMouseOver="updateColor(\'#000000\',\''.$location.'\')" onClick="selectColor(\'#000000\',\''.$location.'\')" height="10" width="10"></td>';
			echo '<td style="background:#'.$hex_color.'" onMouseOver="updateColor(\'#'.$hex_color.'\',\''.$location.'\')" onClick="selectColor(\'#'.$hex_color.'\',\''.$location.'\')" height="10" width="10"></td>';
			echo '<td style="background:#000000" onMouseOver="updateColor(\'#000000\',\''.$location.'\')" onClick="selectColor(\'#000000\',\''.$location.'\')" height="10" width="10"></td>';
			break;
		   case 5:
		  	$hex_color = "FF00FF";
			echo '<td style="background:#000000" onMouseOver="updateColor(\'#000000\',\''.$location.'\')" onClick="selectColor(\'#000000\',\''.$location.'\')" height="10" width="10"></td>';
			echo '<td style="background:#'.$hex_color.'" onMouseOver="updateColor(\'#'.$hex_color.'\',\''.$location.'\')" onClick="selectColor(\'#'.$hex_color.'\',\''.$location.'\')" height="10" width="10"></td>';
			echo '<td style="background:#000000" onMouseOver="updateColor(\'#000000\',\''.$location.'\')" onClick="selectColor(\'#000000\',\''.$location.'\')" height="10" width="10"></td>';
			break;
		}
		for($j=3;$j<6;$j++){
			for($k=0;$k<count($color_code);$k++){
				$hex_color = $color_code[$j].$color_code[$j].$color_code[$k].$color_code[$k].$color_code[$i].$color_code[$i]; 
				echo '<td style="background:#'.$hex_color.'" onMouseOver="updateColor(\'#'.$hex_color.'\',\''.$location.'\')" onClick="selectColor(\'#'.$hex_color.'\',\''.$location.'\')" height="10" width="10"></td>';
			}
		}
		echo "</tr>";
	}

	echo "</table>";
}
?>
