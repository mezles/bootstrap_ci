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
				</div>
				
				<div class="alert alert-block">
					<button type="button" class="close" data-dismiss="alert"><?php _e( '&times;'); ?></button>
					<h4><?php _e( 'Warning!'); ?></h4>
					<p><?php _e( 'Fill up '); ?><a href="<?php echo site_url( '/my-personal-id' ); ?>" class="btn btn-danger"><?php _e( 'My Personal ID' ); ?></a><?php _e( ' before accessing this page.' ); ?></p>
				</div>
				
          </div>
        
        </div><!--/span-->
      </div><!--/row-->
	  
		 
<?php echo $footer; ?>