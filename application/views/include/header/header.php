<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="<?php echo base_url( 'assets/css/bootstrap.css' ); ?>" rel="stylesheet">
    <link href="<?php echo base_url( 'assets/css/jasny-bootstrap.min.css' ); ?>" rel="stylesheet">
    <link href="<?php echo base_url( 'assets/css/bootstrap-responsive.css' ); ?>" rel="stylesheet">
    <link href="<?php echo base_url( 'assets/css/jasny-bootstrap-responsive.css' ); ?>" rel="stylesheet">
    <link href="<?php echo base_url( 'assets/css/font-awesome.min.css' ); ?>" rel="stylesheet">
	<link href="<?php echo base_url( 'assets/css/style.css' ); ?>" rel="stylesheet">
	<link href="<?php echo base_url( 'assets/css/style-responsive.css' ); ?>" rel="stylesheet">
	<link href="<?php echo base_url( 'assets/css/datepicker.css' ); ?>" rel="stylesheet">
	<!-- Add fancyBox -->
	<link rel="stylesheet" href="<?php echo base_url( 'assets/js/fancybox/source/jquery.fancybox.css?v=2.1.4'); ?>" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo base_url( 'assets/js/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5'); ?>" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo base_url( 'assets/js/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7'); ?>" type="text/css" media="screen" />
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="<?php echo base_url( 'assets/js/html5shiv.js'); ?>"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url( 'assets/ico/apple-touch-icon-144-precomposed.png' ); ?>">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url( 'assets/ico/apple-touch-icon-114-precomposed.png' ); ?>">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url( 'assets/ico/apple-touch-icon-72-precomposed.png' ); ?>">
                    <link rel="apple-touch-icon-precomposed" href="<?php echo base_url( 'assets/ico/apple-touch-icon-57-precomposed.png' ); ?>">
                                   <link rel="shortcut icon" href="<?php echo base_url( 'assets/ico/favicon.png' ); ?>">

	<?php
		$page = get_current_controller_method(); 
	?>
	<script type="text/javascript">
	/* <![CDATA[ */
		var 
			APP = {
				"siteurl"			:	"<?php echo site_url('/'); ?>",
				"ajaxurl"			:	"<?php echo site_url('/ajax') . '/'; ?>",
				"controller"		:	"<?php echo $page['controller']; ?>",
				"method"		:	"<?php echo $page['method']; ?>"
			},
		
			USER = {};
	/* ]]> */
	</script>
	
  </head>

  <body>