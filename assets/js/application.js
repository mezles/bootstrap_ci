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
				
				/* init fancybox */
				QIKY.global.fancybox();
				
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
			
			/* loads fancybox */
			fancybox: function() {
				$(".fancybox").fancybox();
			},
						
			/**
			 * this is for form submission, access globally
			 *
			 * please see login or register page for html markup for post redirection
			 * and personal id page for no redirect
			 */
			submitform: function() {				
				/* js form validation */
				if ( $('form').hasClass( 'global' ) ) {
					/* adds pop over to form */
					$('form input, form select').hover(function() {
						$(this).popover('show');
					}).mouseout(function() {
						$(this).popover('hide');
					});
				
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
				var 
					_local = {
						init: function() {
							var self = this;
							self.create_confirm();
						},

						create_confirm: function() {
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
						},
						
						showModal: function() {
							$('#deleteModal').on('shown', function() {
								var _this = $(this);
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
												_this.find('.modal-body').prepend(
													'<div class="alert alert-success"><button data-dismiss="alert" class="close" type="button">&#215;</button>' + response.msg + ' Reloading page</div>'
												);
												setTimeout(function(){
													  window.location.reload();
												},2000);
											} else {
												_this.find('.modal-body').prepend('<div class="alert alert-error"><button data-dismiss="alert" class="close" type="button">&#215;</button>' + response.msg + '</div>');
											}
										},
										error: function() {
											
										}
									});
								});
							}).on('hidden', function() {
								$(this).remove();
							}).modal('show');
							
						}
					};
					
				_local.init();
				_local.showModal();
					
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
				self.add_new_profile();
				self.delete_profile();
				self.change_profile_pic();
			},
			
			save_popup_digital_prof_details: function() {
			
				$('a.popup-edit').click(function() {
				
				});
				
				$('a.add_prof_detail, a.popup-edit').click(function() {
					var _prof_detail_id = $(this).data('id');
										
					$('#popup-profile-'+ _prof_detail_id).validate({
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
								target: '.pop-message',
								success: function( responseText, statusText, xhr, $form) {
									if ( statusText === 'success' ) {
										setTimeout(function(){
											  window.location.reload();
										},2000);
									}
								}
							});
							// return false;
						}
					});
					
				});
				
				$('.modal-profile-detail').on('hidden', function() {
					window.location.reload();
				});
				
			},
			
			delete_profile_details: function() {
				$('a.popup-delete').click(function() {
					var 
						_id = $(this).data('id');
					QIKY.global.popup_confirm( 'digicard/delete_user_profile_detail', _id );
				
				});
				
			},
			
			add_new_profile: function() {
				$('.popup-add-new-profile').validate({
					rules: { /* add rules here */
						profile_name: { required: true }
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
							beforeSubmit: function() {
								$(form).find('.alert').remove();
							},
							success: function( responseText, statusText, xhr, $form) {
								if ( statusText === 'success' ) {
									var _response = $.parseJSON(responseText);
									
									$($form).find('.modal-footer').prepend(_response.msg);
									if ( !_response.error ) {
										setTimeout(function(){
											window.location.reload();
										},2000);
									}
									
								} else {
									$($form).find('.pop-message').html('There was an error in posting your request. Please reload page and try again.');
								}
							}
						});
						// return false;
					}
				});
				
				$('#add-new-profile').on('show', function() {
					$(this).find('.control-group').removeClass('success error');
					$(this).find('.help-inline').remove();
					$(this).find('input[name=profile_name]').val('');
					$(this).find('.alert').remove();
				});
			},
			
			delete_profile: function() {
				$('a[data-toggle="tab"]').on('shown', function (e) {
					e.target // activated tab
					e.relatedTarget // previous tab
					$(e.relatedTarget).find('.icon-remove').remove();

					if( 0 == parseInt( $(e.target).data('built-in') ) ) {
						$(e.target).append('<i class="icon-remove popup-delete" title="Remove Profile"></i>');
						// $('.helptip').tooltip();
					}
					
					$(e.target).find('.popup-delete').click(function() {
						var 
							_id = parseInt($(e.target).data('id'));
						QIKY.global.popup_confirm( 'digicard/delete_profile', _id );
					});
				});
				
			},
			
			change_profile_pic: function() {
				/* get personal photo on reload */
				_ajax_change_photo( 1 );
				
				/* when chaning tabs */
				$('a[data-toggle="tab"]').on('shown', function (e) {
					e.target // activated tab
					e.relatedTarget // previous tab
					
					_ajax_change_photo( parseInt($(e.target).data('id')) );
					
				});
				
				function _ajax_change_photo( _id ) {
					$.ajax({
						url: APP.ajaxurl + 'get_profile_pic',
						type: 'POST',
						dataType: 'json',
						data: {
							'csrf_token' : $('input[name=csrf_token]').val(),
							'id' : _id
						},
						beforeSend: function() {
							$('.img-holder img').hide();
							$('.img-holder div').addClass('img-holder-load');
							$('.img-holder .photo-spin').css('display', 'block');
						},
						success: function( response ) {
							
							if( response.error === false ) {
								$('.img-holder img').attr('src', response.image);
								$('.img-holder .fancybox').attr('href', response.image);
							} else {
								$('.img-holder img').attr('src', APP.siteurl+'assets/img/no-image-blue.png');
								$('.img-holder .fancybox').attr('href', APP.siteurl+'assets/img/no-image-blue.png');
							}
							
							setTimeout(function(){
								$('.img-holder img').fadeIn();
								$('.img-holder div').removeClass('img-holder-load');
								$('.img-holder .photo-spin').css('display', 'none');
							},100);
							
						},
						error: function() {
							
						}
					});
				}
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