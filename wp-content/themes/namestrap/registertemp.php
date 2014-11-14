<?php
/*
Template Name: Register
*/

?>
<div class="container content_wrapper">
	<div class="row">
				<div class="col-xs-12">
			<div class="page-header site-header-wrapper box-wrapper-style">
				<div class="pull-left">
					<h2 class="site-font-color site-h2-heading">Register</h2>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="col-xs-12">
			<div class="content-container box-wrapper-style custom_box_wrapper">
				<div class="login" id="theme-my-login">
	<p class="message">Register For This Site</p>		<form name="registerform" id="registerform" action="/namestrap/?page_id=875" method="post">
		<p>
			<label for="user_login">Username</label>
			<input type="text" name="user_login" id="user_login" class="input" value="" size="20" />
		</p>

		<p>
			<label for="user_email">E-mail</label>
			<input type="text" name="user_email" id="user_email" class="input" value="" size="20" />
		</p>

				<p><label for="pass1">Password</label>
		<input autocomplete="off" name="pass1" id="pass1" class="input" size="20" value="" type="password" /></p>
		<p><label for="pass2">Confirm Password</label>
		<input autocomplete="off" name="pass2" id="pass2" class="input" size="20" value="" type="password" /></p>
		
		<p id="reg_passmail"></p>

		<p class="submit">
			<input type="submit" name="wp-submit" id="wp-submit" value="Register" />
			<input type="hidden" name="redirect_to" value="http://localhost/namestrap/?page_id=872&amp;pending=activation" />
			<input type="hidden" name="instance" value="" />
			<input type="hidden" name="action" value="register" />
		</p>
	</form>
	<ul class="tml-action-links">
<li><a href="http://localhost/namestrap/?page_id=872" rel="nofollow">Log In</a></li>
<li><a href="http://localhost/namestrap/?page_id=877" rel="nofollow">Lost Password</a></li>
</ul>
</div>


			</div>
		</div>
			</div>
</div>
