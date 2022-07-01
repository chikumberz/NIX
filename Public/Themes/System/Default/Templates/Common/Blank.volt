<!DOCTYPE html>
<html lang = "en">
	<head>
		<meta charset = "utf-8">
		<meta http-equiv = "X-UA-Compatible" content = "IE=edge,chrome=1">
		<title>{{ setting.get( 'title' ) }}</title>
		<meta name = "description" content = "{{ setting.get( 'description' ) }}">
		<meta name = "keywords" content = "{{ setting.get( 'keywords' ) }}">
		<meta name = "author" content = "Benjamin Taluyo">
		<meta name = "HandheldFriendly" content = "true">
		<meta name = "MobileOptimized" content = "320">
		<meta name = "viewport" content = "width=device-width, initial-scale=1.0, maximum-scale=1.0, userscalable=0">

		<?php

			// COMMON STYLESHEETS
			$this->assets
					->collection( 'common-stylesheets' )
					->addCss( $this->url->get( array(
						'for'		=> 'theme-common',
						'folder'	=> 'Plugins/JQuery/Stylesheets',
						'file' 		=> 'jquery-ui.min.css'
					)), false )
					->addCss( $this->url->get( array(
						'for'		=> 'theme-common',
						'folder'	=> 'Plugins/JQuery/Stylesheets',
						'file' 		=> 'jquery-ui-timepicker.min.css'
					)), false )
					/*->addCss( $this->url->get( array(
						'for'		=> 'theme-common',
						'folder'	=> 'Plugins/JQuery Easy UI/Stylesheets',
						'file' 		=> 'jquery-easy-ui.css'
					)), false )*/
					->addCss( $this->url->get( array(
						'for'		=> 'theme-common',
						'folder'	=> 'Stylesheets',
						'file' 		=> 'font-awesome.min.css'
					)), false )
					/*->addCss( $this->url->get( array(
						'for'		=> 'theme-common',
						'folder'	=> 'Stylesheets',
						'file' 		=> 'ink.min.css'
					)), false )*/
					->addCss( $this->url->get( array(
						'for'		=> 'theme-common',
						'folder'	=> 'Stylesheets',
						'file' 		=> 'ink-flex.css'
					)), false )
					->addCss( $this->url->get( array(
						'for'		=> 'theme-common',
						'folder'	=> 'Stylesheets',
						'file' 		=> 'ink-theme.css'
					)), false )
					->addCss( $this->url->get( array(
						'for'		=> 'theme-common',
						'folder'	=> 'Stylesheets',
						'file' 		=> 'nix-pagination.css'
					)), false )
					->addCss( $this->url->get( array(
						'for'		=> 'theme-common',
						'folder'	=> 'Stylesheets',
						'file' 		=> 'nix-panel.css'
					)), false );

			$this->assets
					->collection( 'common-stylesheets-ie' )
					->addCss( $this->url->get( array(
						'for'		=> 'theme-common',
						'folder'	=> 'Stylesheets',
						'file' 		=> 'ink-ie.min.css'
					)), false );

			// SYSTEM STYLESHEETS
			$this->assets
					->collection( 'system-stylesheets' )
					->addCss( $this->url->get( array(
						'for'		=> 'theme-system',
						'folder'	=> 'Stylesheets',
						'file' 		=> 'Style.css'
					)), false );


			/*****************************************************************************************/


			// COMMON JAVASCRIPT
			$this->assets
					->collection( 'common-javascripts' )
					->addJs( $this->url->get( array(
						'for'		=> 'theme-common',
						'folder'	=> 'Plugins/Modernizr/Javascripts',
						'file' 		=> 'modernizr.min.js'
					)), false )
					->addJs( $this->url->get( array(
						'for'		=> 'theme-common',
						'folder'	=> 'Plugins/JQuery/Javascripts',
						'file' 		=> 'jquery.min.js'
					)), false )
					->addJs( $this->url->get( array(
						'for'		=> 'theme-common',
						'folder'	=> 'Plugins/JQuery/Javascripts',
						'file' 		=> 'jquery-ui.min.js'
					)), false )
					->addJs( $this->url->get( array(
						'for'		=> 'theme-common',
						'folder'	=> 'Plugins/JQuery/Javascripts',
						'file' 		=> 'jquery-ui-timepicker.min.js'
					)), false )
					->addJs( $this->url->get( array(
						'for'		=> 'theme-common',
						'folder'	=> 'Plugins/JQuery/Javascripts',
						'file' 		=> 'jquery-ui-touch.min.js'
					)), false )
					->addJs( $this->url->get( array(
						'for'		=> 'theme-common',
						'folder'	=> 'Plugins/JQuery Easy UI/Javascripts',
						'file' 		=> 'jquery-easy-ui.min.js'
					)), false )
					->addJs( $this->url->get( array(
						'for'		=> 'theme-common',
						'folder'	=> 'Plugins/IScroll/Javascripts',
						'file' 		=> 'iscroll.js'
					)), false )
					->addJs( $this->url->get( array(
						'for'		=> 'theme-common',
						'folder'	=> 'Plugins/Flot/Javascripts',
						'file' 		=> 'flot.min.js'
					)), false )
					->addJs( $this->url->get( array(
						'for'		=> 'theme-common',
						'folder'	=> 'Plugins/Flot/Javascripts',
						'file' 		=> 'flot.time.min.js'
					)), false )
					->addJs( $this->url->get( array(
						'for'		=> 'theme-common',
						'folder'	=> 'Plugins/Flot/Javascripts',
						'file' 		=> 'flot.canvas.min.js'
					)), false )
					->addJs( $this->url->get( array(
						'for'		=> 'theme-common',
						'folder'	=> 'Javascripts',
						'file' 		=> 'global.js'
					)), false )
					->addJs( $this->url->get( array(
						'for'		=> 'theme-common',
						'folder'	=> 'Javascripts',
						'file' 		=> 'function.js'
					)), false )
					->addJs( $this->url->get( array(
						'for'		=> 'theme-common',
						'folder'	=> 'Javascripts',
						'file' 		=> 'print.js'
					)), false )
					->addJs( $this->url->get( array(
						'for'		=> 'theme-common',
						'folder'	=> 'Javascripts',
						'file' 		=> 'ink.js'
					)), false )
					->addJs( $this->url->get( array(
						'for'		=> 'theme-common',
						'folder'	=> 'Javascripts',
						'file' 		=> 'autoload.js'
					)), false );

			// SYSTEM JAVASCRIPT
			$this->assets
					->collection( 'system-javascripts' );

		?>

		<!-- ICONS -->
			<!--
			<link rel = "shortcut icon" href = "">
			<link rel = "apple-touch-icon-precomposed" href = "">
			<link rel = "apple-touch-icon-precomposed" size = "72x72" href = "">
			<link rel = "apple-touch-icon-precomposed" size = "114x114" href = "">
			<link rel = "apple-touch-startup-image" href = "" media = "screen and (min-device-width: 200px) and (max-device-width: 320px) and (orientation:portrait)">
			<link rel = "apple-touch-startup-image" href = "" media = "screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
			<link rel = "apple-touch-startup-image" href = "" media = "screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
			-->
		<!-- END ICONS -->

		<!-- STYLESHEETS -->
			{{ assets.outPutCss( 'common-stylesheets' ) }}
			{{ assets.outPutCss( 'system-stylesheets' ) }}

			<!--[if lt IE 9 ]>
	            {{ assets.outPutCss( 'common-stylesheets-ie' ) }}
	        <![endif]-->

			{{ assets.outPutCss( ) }}
		<!-- END STYLESHEETS -->

		<!-- JAVASCRIPT -->
			{{ assets.outPutJs( 'common-javascripts' ) }}
			{{ assets.outPutJs( 'system-javascripts' ) }}
			<script type = "text/javascript">
	            Modernizr.load({
	              	test: Modernizr.flexbox,
	              	nope : '<?php echo sprintf( $this->config->urls->themes->common, 'Stylesheets', 'ink-legacy.min.css' ); ?>'
	            });
	        </script>

			{{ assets.outPutJs( ) }}
		<!-- END JAVASCRIPT -->
	</head>
	<body>
		{{ content( ) }}
	</body>
</html>