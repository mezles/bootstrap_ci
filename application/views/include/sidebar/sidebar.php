<?php
	/* get current sidebar active class from /helpers/global_helper.php */
	$side_nav = sidebar_nav_current_active();
?>
<div class="span3">
	<div class="well sidebar-nav">
	<ul class="nav nav-list">
		<li class="nav-header">
			<a href="#"><?php _e( 'My Qicky Digicards' ); ?></a></li>
			
			<li class="<?php echo $side_nav->digicard; ?>">
				<a href="<?php echo site_url( '/my-digicards' ); ?>"><?php _e( 'My Digicard' ); ?></a></li>
			<li class="<?php echo $side_nav->personal_id; ?>">
				<a href="<?php echo site_url( '/my-personal-id' ); ?>"><?php _e( 'My Personal ID' ); ?></a></li>
			<li class="<?php echo $side_nav->details; ?>">
				<a href="<?php echo site_url( '/my-details' ); ?>"><?php _e( 'My Details' ); ?></a></li>
			<li class="<?php echo $side_nav->new_digicard; ?>">
				<a href="<?php echo site_url( '/new-digicard' ); ?>"><?php _e( 'New Digicard' ); ?></a></li>
	</ul>
	</div><!--/.well -->
</div><!--/span-->