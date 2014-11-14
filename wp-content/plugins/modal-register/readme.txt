=== Register Modal ===
Contributors: kureikain
Donate link: http://www.axcoto.com/
Tags: ajax, login, modal, admin, custom register password, username
Requires at least: 2.2.0
Tested up to: 3.0
Stable tag: 1.0

Register Modal provides a modal Ajax-ify box to register for WordPress!

== Description ==

Register Modal provides a modal Ajax-ify box to register for WordPress! Pretty thing about it is
it alow you to set custom password, and it have built-in captcha as well! It's fully Ajax! User
click register link, pop-up open! User fill in, waiting and voila, he can login instantly (if you turn off 
active feature for new user)
	
== Installation ==

*Install and Activate*

1. Unzip the downloaded zip file
2. Upload the unzipped folder and its contents into the `wp-content/plugins/` directory of your WordPress installation
3. Activate Register Modal Box from Plugins page

*Implement*

Register Modal relies on the use of `wp_loginout()` in your theme. Register Modal Login will use the "register" filter to add an `class` to the 
WordPress Register link, which is what enables the plugin to work! Then a script file will handle click event on link with that class

Other than requiring that `wp_register()` is used in your theme, there are no other changes that are required to use Register Modal.


If your theme does not use `wp_register()` and you still want to use this plugin, you can manually edit your theme and add a register link as follows:
	<a href="/wp-login.php?action=register" class="axcoto-register-modal">Register</a>
Or you can add a Meta widget to your sidebar! Meta widget contains register, login/logout link!
	
*Configure*

Right now, this plugin is not configure-able! If you want to change the theme, simply directly  change .css file in assets/css/default.css
to match to your template style

== Frequently Asked Questions ==

= How can I create my own custom theme? =
Right now, this plugin is not configure-able! If you want to change the theme, simply directly  change .css file in assets/css/default.css
to match to your template style


*Have a question, be sure to let me know.*

== Screenshots ==

1. Register Modal Box