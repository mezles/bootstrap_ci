<?php echo $header; ?>
	<style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
	  p.bottom span {
		width: 49%;
		display: inline-block;
	  }

    </style>
	
    <div class="container">

      <?php echo form_open( '/register', array( 'class' => 'form-signin global') ); ?>
		<?php echo form_hidden( 'action', 'register/save'); ?>
		<legend><?php _e( 'Register here'); ?></legend>
		
		<div class="control-group">
			<label class="control-label" for="email"><?php _e( 'Email address'); ?></label>
			<div class="controls">
				<div class="input-prepend">
					<span class="add-on"><i class="icon-envelope"></i></span>
					<?php echo form_input( array( 
						'name' => 'email', 'id' => 'email', 
						'placeholder' => 'Email address', 'class' => 'span3 required',
						'rel' => 'popover', 'data-content' => 'Enter your email address.',
						'data-original-title' => 'Email address') ); ?>
				</div>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="password"><?php _e( 'Password'); ?></label>
			<div class="controls">
				<div class="input-prepend">
					<span class="add-on"><i class="icon-lock"></i></span>
					<?php echo form_password( array( 
						'name' => 'password', 'id' => 'password', 
						'placeholder' => 'Password', 'class' => 'span3 required',
						'rel' => 'popover', 'data-content' => 'Enter your password.',
						'data-original-title' => 'Password') ); ?>
				</div>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="re_password"><?php _e( 'Retype password'); ?></label>
			<div class="controls">
				<div class="input-prepend">
					<span class="add-on"><i class="icon-lock"></i></span>
					<?php echo form_password( array( 
						'name' => 're_password', 'id' => 're_password', 
						'placeholder' => 'Retype password', 'class' => 'span3 required',
						'rel' => 'popover', 'data-content' => 'Retype your password.',
						'data-original-title' => 'Retype password') ); ?>
				</div>
			</div>
		</div>
	
        <button class="btn btn-large btn-primary" type="submit" data-complete-text="Registered!"><?php _e( 'Sign up' ); ?></button>
		<hr />
		<p class="bottom">
			<span class="text-left"><a href="<?php echo site_url('/login'); ?>"><?php _e( '&laquo;&nbsp;Log in' ); ?></a></span>
		</p>
      <?php echo form_close(); ?>
	
<?php echo $footer; ?>
