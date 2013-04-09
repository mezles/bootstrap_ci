<?php echo $header; ?>

    <?php echo $menu_nav; ?>

    <div class="container-fluid">
      <div class="row-fluid">
        <?php echo $sidebar; ?>
        <div class="span9">
          <div class="hero-unit">
				
				<!-- form start -->
				<?php echo form_open( '/my-personal-id', array( 'class' => 'form-horizontal global') ); ?>
					<?php echo form_hidden( 'action', 'digicard/save_personal_id'); ?>
					<?php echo form_hidden( 'redirect', '0'); ?>
					<fieldset>
						<legend><?php echo $page_title; ?><i class="icon-question-sign helptip" data-original-title="<?php 
							_e( 'This is a tooltip for Personal ID, sample text here...' ); ?>"></i></legend>
						
						<!-- firstname field start -->
						<div class="control-group">
							<label class="control-label" for="first_name"><?php _e( 'First Name' ); ?></label>
							<div class="controls">
								<div class="input-prepend">
									<span class="add-on"><i class="icon-user"></i></span>
									<?php echo form_input( array( 
										'name' => 'first_name', 'id' => 'first_name', 
										'placeholder' => 'First Name', 'class' => 'required',
										'rel' => 'popover', 'data-content' => 'Enter your first name.',
										'data-original-title' => 'First Name', 'value' => ($user_meta) ? $user_meta->firstname : '') ); ?>
								</div>
							</div>
						</div>
						<!-- firstname field end -->
						
						<!-- lastname field start -->
						<div class="control-group">
							<label class="control-label" for="last_name"><?php _e( 'Last Name' ); ?></label>
							<div class="controls">
								<div class="input-prepend">
									<span class="add-on"><i class="icon-user"></i></span>
									<?php echo form_input( array( 
										'name' => 'last_name', 'id' => 'last_name', 
										'placeholder' => 'Last Name', 'class' => 'required',
										'rel' => 'popover', 'data-content' => 'Enter your last name.',
										'data-original-title' => 'Last Name', 'value' => ($user_meta) ? $user_meta->lastname : '') ); ?>
								</div>
							</div>
						</div>
						<!-- lastname field end -->
						
						<!-- birthday field start -->
						<div class="control-group">
							<label class="control-label" for="birthday"><?php _e( 'Birth Day' ); ?></label>
							<div class="controls">
								<div class="input-prepend date" id="date" data-date="<?php echo date('d-m-Y'); ?>" data-date-format="dd-mm-yyyy">
								  <span class="add-on"><i class="icon-calendar helptip" data-original-title="<?php _e( 'Select date here.' ); ?>"></i></span>
								  <?php echo form_input( array( 
										'name' => 'birthday', 'id' => 'birthday', 
										'placeholder' => 'Birth Day', 'readonly' => 'readonly', 
										'class' => 'required', 'rel' => 'popover',
										'data-content' => 'Enter your birth date.', 'data-original-title' => 'Birth Day',
										'value' => ($user_meta) ? date('d-m-Y', $user_meta->birthday) : '',
										'style' => 'cursor:pointer;') ); ?>
								</div>
							</div>
						</div>
						<!-- birthday field end -->
						
						<!-- sex field start -->
						<?php
							$gender = ($user_meta) ? $user_meta->gender : '';
							$m_active = ($gender == 'm') ? ' active' : '';
							$f_active = ($gender == 'f') ? ' active' : '';
						?>
						<div class="control-group">
							<label class="control-label"><?php _e( 'Sex' ); ?></label>
							<div class="controls">
								<p></p><div data-toggle="buttons-radio" class="btn-group">  
									<button class="btn btn-info radio<?php echo $m_active; ?>" id="gender" required="required" type="button" value="m"><?php _e( 'Male' ); ?></button>  
									<button class="btn btn-info radio<?php echo $f_active; ?>" id="gender" required="required" type="button" value="f"><?php _e( 'Female' ); ?></button>
									<input type="hidden" name="gender" value="<?php echo $gender; ?>"/>
								</div><p></p>
							</div>
						</div>
						<!-- sex field end -->
						
						<!-- location start -->
						<div class="control-group">
							<label class="control-label" for="location"><?php _e( 'Current Location' ); ?></label>
							<div class="controls">
								<div class="input-prepend">
									<span class="add-on"><i class="icon-globe"></i></span>
									<?php echo form_input( array( 
										'name' => 'location', 'id' => 'location', 
										'placeholder' => 'Current Location', 'class' => 'required',
										'rel' => 'popover', 'data-content' => 'Enter your location.',
										'data-original-title' => 'Location', 'value' => ($user_meta) ? $user_meta->location : '') ); ?>
								</div>
							</div>
						</div>
						<!-- location end -->
						
						<!-- country start -->
						<div class="control-group">
							<label class="control-label" for="country"><?php _e( 'Country' ); ?></label>
							<div class="controls">
								<div class="input-prepend">
									<span class="add-on"><i class="icon-flag"></i></span>
									<select id="country" name="country" class="required" rel="popover" data-content="<?php 
										_e( 'Select your country'); ?>" data-original-title="<?php _e( 'Country' ); ?>">
										<?php foreach( $country as $val ): ?>
											<?php if( $user_meta && $user_meta->country == $val->iso2): ?>
												<option value="<?php echo $val->iso2; ?>" selected><?php echo $val->short_name; ?></option>
											<?php else: ?>
												<option value="<?php echo $val->iso2; ?>"><?php echo $val->short_name; ?></option>
											<?php endif; ?>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>
						<!-- country end -->
						
						<!-- submit button start -->
						<div class="control-group">
							<div class="controls">
								<button type="submit" class="btn btn-primary" data-loading-text="<?php _e( 'saving info...'); ?>" data-complete-text="<?php 
									_e( 'Saved!'); ?>"><?php _e( 'Submit'); ?></button>
							</div>
						</div>
						<!-- submit button end -->
					</fieldset>
				<?php echo form_close(); ?>
				<!-- form end -->
				
          </div>
        
        </div><!--/span-->
      </div><!--/row-->
	  
	  <!-- Modal Welcome popup -->
	<div id="welcome-popup" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
			<h3 id="myModalLabel"><?php _e( 'Welcome to '); ?><span class="brand">Qiky</brand></h3>
		</div>
		<div class="modal-body">
			<p>Thank you for signing up with Qiky. You are just two steps away to create your first Qiky digital business cards (Digicard for short). Please continue to 1.) complete your personal ID details needed for your 2.) Digicards</p>
			<img src="<?php echo base_url( 'assets/img/welcome_popup.png' ); ?>" />
		</div>
		<div class="modal-footer">
			<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true"><?php _e( 'Continue' ); ?></button>
		</div>
	</div>
		
	
	<script type="text/javascript">
		(function() {
			"use strict";
				USER.login_count = <?php echo $login_count; ?>;
				USER.session_popup = <?php echo ($this->session->userdata('session_popup')) ? $this->session->userdata('session_popup') : 0;?>;
			
		})();
	</script>
		 
<?php echo $footer; ?>