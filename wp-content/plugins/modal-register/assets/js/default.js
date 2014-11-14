(function ($) {
	var AxcotoRegisterModal = {
		init: function () {
			var a = this;
			
			$('.axcoto-register-modal').click( function (e) {
				e.preventDefault();
				a.show();
				return false;
			});	
			
			$('#modal-register-close').click(function () {
				return a.hide();
			})
			
			a.submitForm(a);
		},
		
		hide: function () {
			$('#register-modal-outer').hide();
			return false;
		},
		
		show: function () {
			//$('body').wrapInner($('#register-modal-outer'));
			$('#register-modal-outer').show();
				
			$('#modal-register-captcha').css('background-image', "url('" + $('#modal-register-captcha').attr('rel') + Math.random() + "')" );
			$('p.modal-register-error').html('').hide();
		},
		
		submitForm: function (a) {
			$('#register-modal-form').submit(function () {
				$('p.modal-register-error').html('').hide();
				
				if ($('#register-username').val()=='') {
					a.showError('<span>Username is empty</span>');
					return false;
				}
				
				if ($('#register-email').val()=='') {
					a.showError('<span>Email is empty</span>');
					return false;
				}
				
				if ($('#register-re-pass').val()!=$('#register-pass').val()) {
					a.showError('<span>Passwords doesn\'t match</span>');
					return false;
				}
				
				$.post(blogUrl + '/wp-admin/admin-ajax.php',
						$(this).serialize(), 
						function (data) {
							$('div.modal-register-loading').hide();
							if (data.error) {
								a.showError(data.msg);
							} else {
								alert('Register successful!\n You can login now');
								$("#register-modal-form").hide();
								//$('.simplemodal-login', $('#reader-button-container')).click();
							}
						}, 
						'json'					
					);
				
				return false;
			});
		},
		
		showError: function (msg) {
			$('.modal-register-error').html(msg).show();
		}
		
	}
	
	$(document).ready(function () {
		AxcotoRegisterModal.init();
	})
	
})(jQuery)
