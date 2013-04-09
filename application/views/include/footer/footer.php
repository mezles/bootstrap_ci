<?php if (! in_array($this->uri->segment(1), array( 'login', 'register' ) ) ): ?>
      <hr>

      <footer>
        <p><?php _e( '&copy; Company 2013' ); ?></p>
      </footer>
<?php endif; ?>
    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
	<script src="<?php echo base_url( 'assets/js/bootstrap.min.js' ); ?>"></script>
	<script src="<?php echo base_url( 'assets/js/jasny-bootstrap.min.js' ); ?>"></script>
	<script src="<?php echo base_url( 'assets/js/bootstrap-datepicker.js' ); ?>"></script>
	<script src="<?php echo base_url( 'assets/js/jquery.form.js' ); ?>"></script>
	<script src="<?php echo base_url( 'assets/js/application.js' ); ?>"></script>
	
	<!-- Add fancyBox -->
	<script type="text/javascript" src="<?php echo base_url( 'assets/js/fancybox/lib/jquery.mousewheel-3.0.6.pack.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url( 'assets/js/fancybox/source/jquery.fancybox.pack.js?v=2.1.4'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url( 'assets/js/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url( 'assets/js/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.5'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url( 'assets/js/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7'); ?>"></script>
	
	<!--
    <script src="<?php echo base_url( 'assets/js/bootstrap-transition.js' ); ?>"></script>
    <script src="<?php echo base_url( 'assets/js/bootstrap-alert.js' ); ?>"></script>
    <script src="<?php echo base_url( 'assets/js/bootstrap-modal.js' ); ?>"></script>
    <script src="<?php echo base_url( 'assets/js/bootstrap-dropdown.js' ); ?>"></script>
    <script src="<?php echo base_url( 'assets/js/bootstrap-scrollspy.js' ); ?>"></script>
    <script src="<?php echo base_url( 'assets/js/bootstrap-tab.js' ); ?>"></script>
    <script src="<?php echo base_url( 'assets/js/bootstrap-tooltip.js' ); ?>"></script>
    <script src="<?php echo base_url( 'assets/js/bootstrap-popover.js' ); ?>"></script>
    <script src="<?php echo base_url( 'assets/js/bootstrap-button.js' ); ?>"></script>
    <script src="<?php echo base_url( 'assets/js/bootstrap-collapse.js' ); ?>"></script>
    <script src="<?php echo base_url( 'assets/js/bootstrap-carousel.js' ); ?>"></script>
    <script src="<?php echo base_url( 'assets/js/bootstrap-typeahead.js' ); ?>"></script>
	-->
	
  </body>
</html>
