<?php
	/* get current menu navigation active class from /helpers/global_helper.php */
	$nav = menu_nav_current_active();
?>
<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-inner">
	<div class="container-fluid">
	  <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	  </button>
	  <a class="brand" href="#">Qiky</a>
	  <div class="nav-collapse collapse">
		<ul class="nav pull-right">
			<li class="dropdown">
				<a href="#" class="navbar-link dropdown-toggle" data-toggle="dropdown" role="button">
					<?php _e( 'Logged in as '); ?>
					<?php echo ($this->user_model->get_user_meta()) 
								? ucwords( $this->user_model->get_user_meta()->firstname . ' ' . $this->user_model->get_user_meta()->lastname ) 
								: $this->session->userdata('user_data')['username']; ?><b class="caret"></b></a>
				<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
					<li role="presentation"><a href="#" tabindex="-1" role="menuitem"><?php _e( 'Notifications' ); ?></a></li>
					<li role="presentation"><a href="#" tabindex="-1" role="menuitem"><?php _e( 'Edit User Details' ); ?></a></li>
					<li role="presentation"><a href="#" tabindex="-1" role="menuitem"><?php _e( 'Change Password' ); ?></a></li>
					<li role="presentation"><a href="#" tabindex="-1" role="menuitem"><?php _e( 'Settings' ); ?></a></li>
					<li class="divider" role="presentation"></li>
					<li role="presentation"><a href="<?php echo site_url( '/sign-out' ); ?>" tabindex="-1" role="menuitem"><?php _e( 'Log Out' ); ?></a></li>
				</ul>
			</li>
		</ul>
		<ul class="nav">
		  <li class="<?php echo $nav->timeline; ?>"><a href="<?php echo site_url( '/' ); ?>">Timeline</a></li>
		  <li class="<?php echo $nav->digicard; ?>"><a href="<?php echo site_url( '/my-digicards' ); ?>">My Digicards</a></li>
		  <li class="<?php echo $nav->contact; ?>"><a href="<?php echo site_url( '/my-contacts' ); ?>">My Contacts</a></li>
		  <li class="<?php echo $nav->directory;?>"><a href="<?php echo site_url( '/directory' ); ?>">Directory</a></li>
		</ul>
	  </div><!--/.nav-collapse -->
	</div>
  </div>
</div>