<?php echo $header; ?>

    <?php echo $menu_nav; ?>

    <div class="container-fluid">
      <div class="row-fluid">
        <?php echo $sidebar; ?>
        <div class="span9">
          <div class="hero-unit">	
		  
				<div class="tophead">
					<span class="title"><?php echo $page_title; ?><i class="icon-question-sign helptip" data-original-title="<?php 
							_e( 'This is a tooltip for My Details, sample text here...' ); ?>"></i>
					</span>
					<div class="img-holder clearfix">
						<img class="pull-left" src="<?php echo base_url( '/assets/img/no-image-blue.png' ); ?>" />
						<ul class="unstyled">
							<li>
								<i class="icon-user helptip" data-original-title="User Name"></i><?php echo ucwords($user_meta->firstname . ' ' . $user_meta->lastname); ?></li>
							<li>
								<i class="icon-gift helptip" data-original-title="Birth Date"></i><small><?php echo date('d.m.Y', $user_meta->birthday); ?></small></li>
							<li>
								<i class="icon-globe helptip" data-original-title="Address"></i><small><?php 
									echo ucwords( $user_meta->location ); ?><?php _e( ', ' ); ?><?php echo $this->global_model->get_country_name( $user_meta->country ); ?></small></li>
							<li><?php _e( '&nbsp;'); ?></li>
							<li><?php _e( '&nbsp;'); ?></li>
							<li>
								<i class="icon-pencil helptip" data-original-title="Edit General Information"></i>
								<a href="<?php echo site_url( '/my-personal-id' ); ?>"><span class="label label-info">Edit</span></a></li>
						</ul>
					</div><!--/img-holder-->
				</div><!--/tophead-->
				
				
				<div class="tabbable"> <!-- Only required for left/right tabs -->
					<ul class="nav nav-tabs">
						<?php foreach( $profile_names as $key => $profile_name ) : ?>
							<li<?php echo ( 0 == $key ) ? ' class="active"' : ''; ?>><a href="#tab<?php echo ($key+1);?>" data-toggle="tab"><?php echo $profile_name->title; ?></a></li>
						<?php endforeach; ?>
						<li><a href="#tab<?php echo (count($profile_names)+1); ?>" data-toggle="tab"><?php _e( '+ New Profile' ); ?></a></li>
					</ul>
					<div class="tab-content">
						<?php foreach( $profile_names as $key => $profile_name ) : ?>
							<div class="tab-pane<?php echo ( 0 == $key ) ? ' active' : ''; ?>" id="tab<?php echo ($key+1); ?>">
							<?php if ( !$this->user_model->has_existing_profile( $user['id'], $profile_name->id ) ) : ?>
								<p><?php _e( 'No ' . $profile_name->title . ' Profile Details are completed yet.'); ?></p>
								<!-- Button to trigger modal -->
								<p><a class="text-info" href="#digicard-profile-details" data-toggle="modal"><?php _e( 'Complete one now.' ); ?></a></p>
							<?php else: ?>
								<div class="alert alert-info profile-detail-list"><?php
									$lists = $this->user_model->get_profile_detail_list( $user['id'], $profile_name->id );
									foreach( $lists as $list ): ?>
										<a class="btn btn-mini btn-primary" href="#"><i class="icon-user icon-white"></i><?php _e( ' -' ); ?></a>
										<a href="#"><?php echo $list->title; ?></a>
										<p class="pull-right">
											<a class="btn btn-mini btn-primary" href="#"><i class="icon-pencil icon-white"></i><?php _e( ' Edit' ); ?></a>
											<a class="btn btn-mini btn-danger delete" href="#" data-id="<?php echo $list->id; ?>"><i class="icon-remove icon-white"></i><?php _e( ' Delete' ); ?></a>
										</p>
								<?php endforeach; ?>
								</div>
							<?php endif; ?>
							</div>
						<?php endforeach; ?>
						<div class="tab-pane" id="tab<?php echo (count($profile_names)+1); ?>">
							<p>Howdy, I'm in Section <?php echo (count($profile_names)+1); ?></p>
						</div>
					</div>
				</div><!--/tabbable-->
				
	
          </div><!--/hero-unit-->
        
        </div><!--/span-->
      </div><!--/row-->
	 	
	
	<!-- Modal Digicard profile details -->
	<div id="digicard-profile-details" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<?php echo form_open_multipart('digicard/save_digital_profile_details', array( 'class' => 'form-horizontal popup-profile' ) ); ?>
		
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><?php _e( '&times;'); ?></button>
			<h3 id="myModalLabel"><?php _e( 'Digicard profile details'); ?></h3>
		</div><!--/.modal-header-->
		
		<div class="modal-body">
								
			<div class="clearfix">
				<div class="fileupload fileupload-exists pull-left" data-provides="fileupload" data-name="profile_photo" style="margin-right:10px;">
					<div class="fileupload-new thumbnail"><img src="<?php echo base_url( '/assets/img/no-image-blue.png' ); ?>" /></div>
					<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 148px; max-height: 150px; line-height: 20px;">
						<img src="<?php echo base_url( '/assets/img/no-image-blue.png' ); ?>" />
					</div>
					<div>
						<span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input type="file" name="profile_photo"/></span>
						<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
					</div>
				</div>
				<div style="margin-top:55px;">
					<fieldset>
						<div class="control-group">
							<label class="control-label" for="title" style="float:none; padding-top:0; text-align:left;"><?php _e( 'Profile Title' ); ?></label>
							<div class="controls" style="margin-left:0;">
								<input class="span3-edit required" type="text" id="title" name="title" placeholder="<?php _e( 'Profile Title' ); ?>" />
							</div>
						</div>
					</fieldset>
				</div>
			</div>
			<div>
				<fieldset>
					<legend><?php _e( 'Contacts' ); ?></legend>
					<!-- email field -->
					<div class="control-group">
						<label class="control-label" for="email"><?php _e( 'Email'); ?></label>
						<div class="controls">
							<input class="span3-edit" type="email" id="email" name="email" placeholder="Email" />
						</div>
					</div>
					<!--/email field-->
					
					<!-- mobile phone -->
					<div class="control-group">
						<label class="control-label" for="phone_mobile"><?php _e( 'Mobile Phone'); ?></label>
						<div class="controls">
							<select class="span2-edit" name="phone_mobile_code">
								<?php foreach( $country as $val ): ?>
									<option value="<?php echo $val->country_id; ?>"><?php echo '+' . $val->calling_code . ' (' . $val->iso3 . ')'; ?></option>
								<?php endforeach; ?>
							</select>
							<input class="span2" type="text" id="phone_mobile" name="phone_mobile" placeholder="Mobile Phone" />
						</div>
					</div>
					<!--/mobile phone-->
					
					<!-- home phone -->
					<div class="control-group">
						<label class="control-label" for="phone_home"><?php _e( 'Home'); ?></label>
						<div class="controls">
							<select class="span2-edit" name="phone_home_code">
								<?php foreach( $country as $val ): ?>
									<option value="<?php echo $val->country_id; ?>"><?php echo '+' . $val->calling_code . ' (' . $val->iso3 . ')'; ?></option>
								<?php endforeach; ?>
							</select>
							<input class="span2" type="text" id="phone_home" placeholder="Home" />
						</div>
					</div>
					<!--/home phone-->
					
					<!-- skype field -->
					<div class="control-group">
						<label class="control-label" for="skype"><?php _e( 'Skype'); ?></label>
						<div class="controls">
							<input class="span3-edit" type="text" id="skype" name="skype" placeholder="Skype" />
						</div>
					</div>
					<!--/skype field-->
					
					<!-- personal_url field -->
					<div class="control-group">
						<label class="control-label" for="personal_url"><?php _e( 'Personal URL'); ?></label>
						<div class="controls">
							<input class="span3-edit" type="url" id="personal_url" name="personal_url" placeholder="Personal URL" />
						</div>
					</div>
					<!--/personal_url field-->
					
					<!-- job_title field -->
					<div class="control-group">
						<label class="control-label" for="job_title"><?php _e( 'Job Title'); ?></label>
						<div class="controls">
							<input class="span3-edit" type="text" id="job_title" name="job_title" placeholder="Job Title" />
						</div>
					</div>
					<!--/job_title field-->
					
					<!-- job_title field -->
					<div class="control-group">
						<label class="control-label" for="company_logo"><?php _e( 'Company Logo'); ?></label>
						<div class="controls">
							<div class="fileupload fileupload-new" data-provides="fileupload">
								<div class="fileupload-new thumbnail"><img src="<?php echo base_url( '/assets/img/no-image-blue.png' ); ?>" /></div>
								<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 148px; max-height: 150px; line-height: 20px;"></div>
								<div>
									<span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input type="file" name="company_logo"/></span>
									<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
								</div>
							</div>
						</div>
					</div>
					<!--/job_title field-->
					
					<!-- company field -->
					<div class="control-group">
						<label class="control-label" for="company"><?php _e( 'Company'); ?></label>
						<div class="controls">
							<input class="span3-edit" type="text" id="company" name="company" placeholder="Company" />
						</div>
					</div>
					<!--/company field-->
					
					<!-- address field -->
					<div class="control-group">
						<label class="control-label" for="address"><?php _e( 'Address'); ?></label>
						<div class="controls">
							<input class="span3-edit" type="text" id="address" name="address" placeholder="Address" />
						</div>
					</div>
					<!--/address field-->
					
				</fieldset>
				
				<fieldset>
					<legend><?php _e( 'Social Links' ); ?></legend>
					<!-- facebook field -->
					<div class="control-group">
						<label class="control-label" for="social_link_fb"><?php _e( 'Facebook '); ?><i class="icon-facebook-sign"></i></label>
						<div class="controls">
							<input class="span3-edit" type="url" id="social_link_fb" name="social_link_fb" placeholder="<?php _e( 'http://www.facebook.com/yourID' ); ?>" />
						</div>
					</div>
					<!--/facebook field-->
					
					<!-- twitter field -->
					<div class="control-group">
						<label class="control-label" for="social_link_twitter"><?php _e( 'Twitter '); ?><i class="icon-twitter-sign"></i></label>
						<div class="controls">
							<input class="span3-edit" type="url" id="social_link_twitter" name="social_link_twitter" placeholder="<?php _e( 'http://www.twitter.com/yourID' ); ?>" />
						</div>
					</div>
					<!--/twitter field-->
					
					<!-- linkedin field -->
					<div class="control-group">
						<label class="control-label" for="social_link_linkedin"><?php _e( 'Linkedin '); ?><i class="icon-linkedin-sign"></i></label>
						<div class="controls">
							<input class="span3-edit" type="url" id="social_link_linkedin" name="social_link_linkedin" placeholder="<?php _e( 'http://www.linkedin.com/yourID' ); ?>" />
						</div>
					</div>
					<!--/linkedin field-->
				</fieldset>
			</div>
			
		</div><!--/.modal-body-->
		
		<div class="modal-footer">
			<?php echo form_hidden( 'action', 'digicard/save_digital_profile_details' ); ?>
			<?php echo form_hidden( 'profile_id', 1 ); ?>
			<button class="btn" data-dismiss="modal" aria-hidden="true"><?php _e( 'Close' ); ?></button>
			<button type="submit" class="btn btn-primary"><?php _e( 'Save changes'); ?></button>
		</div><!--/.modal-footer-->
		
		<div class="pop-message"></div>
			
		<?php echo form_close(); ?>
	</div><!--/modal-->
		 
<?php echo $footer; ?>