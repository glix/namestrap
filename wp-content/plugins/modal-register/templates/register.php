<div id="register-modal-outer">

	<div id="register-modal-box" >
		<form name="register-modal" id="register-modal-form" action="/wp-admin/admin-ajax.php" method="post">
			<div class="modal-register-error"></div>
			<p>
				<label>Username</label>
				<input type="text" name="username" id="register-username" class="input" value="" size="20" tabindex="111" />
				
				<label>Email</label>
				<input type="text" name="email" id="register-email" class="input" value="" size="20" tabindex="222" />	
			</p>
			
			<p>
				<label>Password</label>
				<input type="password" name="password" id="register-pass" class="input" value="" size="20" tabindex="333" />
				
				<label>Password again</label>
				<input type="password" name="re_password" id="register-re-pass" class="input" value="" size="20" tabindex="444" />
			</p>
			
			<p>
				<label>Type word below</label>
				<input type="text" name="captcha" id="captcha_word" class="input" value="" size="20" tabindex="555" />
			</p>
			
			<div class="register-buttons">
				<label id="modal-register-captcha" rel="<?php echo $this->pluginurl?>/captcha.php?r="  style="background-image: url('<?php echo $this->pluginurl?>/captcha.php?r=<?php echo time()?>'); ">&nbsp;&nbsp;&nbsp;</label>
			
				<input type="submit" name="modal-register-submit" id="modal-register-submit" value="Register" tabindex="666" />&nbsp;&nbsp;
				<input type="button" class="simplemodal-close" value="Cancel" id="modal-register-close"  />			
			</div>
			
			<div class="modal-register-loading"></div>
			<input type="hidden" name="action" value="modal_register" />
		</form>
	</div>

</div>
