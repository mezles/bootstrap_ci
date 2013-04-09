(function($) {
	'use strict';
	
	$(function() {
		/* global */
		var QIKY = {};
		
		/**
		 * This is use for global function
		 *
		 * Local script should not be added here
		 *
		 */
		 
		 QIKY.global = {
			init: function() {
				/*init tooltip */
				QIKY.global.tooltip();
				
				/* init datepicker */
				QIKY.global.datepicker();
				
				/* init radio buttons */
				QIKY.global.radiobutton();
				
				/* init submit forms*/
				QIKY.global.submitform();
				
			},
			
			/**
			 * this is use for adding tooltip on page
			 * - just follow bootstrap tooltip markup and add class helptip
			 *
			 * access: global
			 */
			tooltip: function() {
				/* assign text to my personal id legend on form */
				$('.helptip').tooltip();
			},
			
			/**
			 * this is for adding datepicker on input text field with id as date
			 * access: global
			 */
			datepicker: function() {
				/* set datepicker to birthdate field */
				$('#date').datepicker();
			},
			
			/**
			 * this is for switching values on radio button, button value will be added to hidden gender field for form submission
			 *
			 * access: global
			 */
			radiobutton: function() {
				/* assign value to hidden input on radio button for submission */
				$('button.radio').click(function() {
					$('input[name=gender]').val( $(this).val() );
				});
			},
			
			/**
			 * this is for form submission, access globally
			 *
			 * please see login or register page for html markup for post redirection
			 * and personal id page for no redirect
			 */
			submitform: function() {
				/* adds pop over to form */
				$('form input, form select').hover(function() {
					$(this).popover('show');
				}).mouseout(function() {
					$(this).popover('hide');
				});
				
				/* js form validation */
				if ( $('form').hasClass( 'global' ) ) {
					$('form').validate({
						rules: { /* add rules here */
							email: { required: true, email: true},
							password:{required:true,minlength: 6},
							re_password:{required:true, equalTo: "input[name=password]"}
						},
						errorClass: "help-inline",
						errorElement: "span",
						errorPlacement: function(error, element) {
							if ($(element).parent().next().is('span.help-inline')) {
								$(element).parent().next().remove();
							}
							
							$(element).parent().after(error);
						},
						highlight:function(element, errorClass, validClass) {
							$(element).parents('.control-group').removeClass('success');
							$(element).parents('.control-group').addClass('error');
						},
						unhighlight: function(element, errorClass, validClass) {
							$(element).parents('.control-group').removeClass('error');
							$(element).parents('.control-group').addClass('success');
						},
						submitHandler: function(form) {
							/**
							 * responsible for form submission thru ajax 
							 * must add hidden field action for ajax url
							 * must add hidden field redirect for redirection after ajax success
							 */
							$.ajax({
								url: APP.siteurl + $('input[name=action]').val(),
								type: 'POST',
								dataType: 'json',
								data: $(form).serialize(),
								beforeSend: function() {
									$('button[type=submit]').button('loading');
									$(form).children('div.alert').remove();
									$(form).children('.control-group').removeClass('success error');
								},
								success: function( response ) {
									$('button[type=submit]').button('reset');
									
									if ( response.error ) {
										$(form).prepend('<div class="alert alert-error"><button data-dismiss="alert" class="close" type="button">&#215;</button>' + response.msg + '</div>');
									} else {
										if ( ($(form).has('input[name=redirect]').length)  ) {
											$(form).prepend('<div class="alert alert-success"><button data-dismiss="alert" class="close" type="button">&#215;</button>' + response.msg + '</div>');
										} else {
											window.location.href = $(form).attr('action');
										}
										
									}
								},
								error: function() {
									$('button[type=submit]').button('reset');
								}
							});
							return false;
						}
					});
				}
				
					
			},
			
			popup_confirm: function( _link, _id ) {
				var _return = false;
				/* $('a.delete').click(function() {
					var _id = $(this).data('id'); */
					
					$('body').prepend(
						'<div id="deleteModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">' + 
							'<div class="modal-header">' + 
								'<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>' + 
								'<h3 id="myModalLabel">Confirm Delete</h3>' +
							'</div>' + 
							'<div class="modal-body">' +
								'<p>Are you sure to delete this item?</p>' + 
							'</div>' + 
							'<div class="modal-footer">' +
								'<button class="btn" data-dismiss="modal" aria-hidden="true">No</button>' +
								'<button class="btn btn-primary" id="yes">Yes</button>' + 
							'</div>' +
						'</div>'
					);
					
					$('#deleteModal').on('shown', function() {
						$(this).find('button#yes').click(function() {
							$.ajax({
								url: APP.siteurl + _link,
								type: 'POST',
								dataType: 'json',
								data: {
									'csrf_token' : $('input[name=csrf_token]').val(),
									'id' : parseInt(_id)
								},
								beforeSend: function() {
									
								},
								success: function( response ) {
									if( response.error === false ) {
										_return = true;
									}
								},
								error: function() {
									_return = false;
								}
							});
						});
					}).on('hidden', function() {
						$(this).remove();
					}).modal('show');					
					
				/* }); */
				
				return _return;
				
			}
			
		 }
		 
		 /**
		  * This is for Personal ID page
		  *
		  * All script pertaining to personal id should be put in here
		  */
		 QIKY.personal_id = {
			init: function() {
				var self = this;
				
				/** 
				 * check if USER.login_count is present and is number type
				 * USER.login_count must be 1 for the welcome popup to appear, meaning first time login 
				 */
				if ( (typeof(USER.login_count) === 'number') &&  (1 === parseInt(USER.login_count))  ) {
					/**
					 * session popup is needed for first time user so that popup welcome popup message wil show only once
					 * when trying to navigate to 'My Personal ID' page
					 * 
					 */
					if ( (typeof(USER.session_popup) === 'number') &&  (1 !== parseInt(USER.session_popup))  ) {
						self.welcome_popup();
						self.session_popup();
					}
					
				}

				/* triggers datepicker when clicking birthday field */
				$('#birthday').click(function() {
					$('#date').datepicker('show');
				});
				
			},
			
			welcome_popup: function() {
				$('#welcome-popup').modal('show');
			},
			
			session_popup: function() {
				$.ajax({
					url: APP.ajaxurl + '/session_popup',
					type: 'POST',
					dataType: 'json',
					data: {
						'csrf_token' : $('input[name=csrf_token]').val()
					},
					beforeSend: function() {
						
					},
					success: function( response ) {
						
					},
					error: function() {
						
					}
				});
			}
			
		 }
		 
		 
		 
		 /**
		  * This is for My Details page
		  *
		  * All script pertaining to personal id should be put in here
		  */
		 QIKY.my_details = {
			init: function() {
				var self = this;
				
				self.save_popup_digital_prof_details();
				self.delete_profile_details();
			},
			
			save_popup_digital_prof_details: function() {
				$('.popup-profile').validate({
					rules: { /* add rules here */
						email: { required: false, email: true}
					},
					errorClass: "help-inline",
					errorElement: "span",
					highlight:function(element, errorClass, validClass) {
						$(element).parents('.control-group').removeClass('success');
						$(element).parents('.control-group').addClass('error');
					},
					unhighlight: function(element, errorClass, validClass) {
						$(element).parents('.control-group').removeClass('error');
						$(element).parents('.control-group').addClass('success');
					},
					submitHandler: function(form) {
						$(form).ajaxSubmit({
							target: '.pop-message'
						});
						return false;
					}
				});
			},
			
			delete_profile_details: function() {
				$('a.delete').click(function() {
					var 
						_id = $(this).data('id'),
						test = QIKY.global.popup_confirm( 'digicard/delete_user_profile_detail', _id );
					
					console.log(test);
				});
				
			}
			
			
		 }
		 
		 
		 /**
		  ************************************************************************
		  * Script initializations here - START
		  ************************************************************************/
			QIKY.global.init();
			
			/* if page is in home (currently at my-personal-id page)*/
			if ( APP.controller == 'digicard' && APP.method == 'personal_id' ) {				
				QIKY.personal_id.init();
			}
			
			/* if page is in my details (currently at my-details page)*/
			if ( APP.controller == 'digicard' && APP.method == 'details' ) {				
				QIKY.my_details.init();
			}
			
		/**
		  ************************************************************************
		  * Script initializations here - END
		  ************************************************************************/
		  
		// $("#test").html('');
		// $("#test").html('<span>Uploading....</span>');
		// $(".popup-profile").ajaxForm({
			// target: '#test'
		// }).submit();
		 
	});
	
})(jQuery);