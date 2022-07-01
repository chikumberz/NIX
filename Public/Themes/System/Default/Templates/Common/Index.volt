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

	        <script type = "text/javascript">
				jQuery( document ).ready( function ( $ ) {
					$( '.filter-selector' ).each( function ( ) {
						var self = $( this );
						self.data( 'oldValue', self.val( ) );

						if ( self.val( ) == '' ) {
							return true;
						}

						var elem_class 	= self.attr( 'id' ).slice( 0, -10 );
						var elem 		= $( '.' + elem_class + '_content' );

						elem.each( function ( ) {
							self.trigger( 'SwitchFilterIn', [ self.val( ), $( this ) ] );
						});
					});

					$( '.filter-selector' ).on( 'change', function ( ) {
						var self = $( this ),
							newFilter = self.val( ),
							oldFilter = self.data( 'oldValue' );

						self.data( 'oldValue', newFilter );

						var elem_class 	= self.attr( 'id' ).slice( 0, -10 );
						var elem 		= $( '.' + elem_class + '_content' );

						elem.each( function ( ) {
							self.trigger( 'SwitchFilterOut', [ oldFilter, $( this ) ] );
							self.trigger( 'SwitchFilterIn', [ newFilter, $( this ) ] );
						});
					});
				});
			</script>
		<!-- END JAVASCRIPT -->
	</head>

	<body class = "ink-drawer">
		<!--[if lte IE 9 ]>
            <div class="ink-alert basic" role="alert">
                <button class="ink-dismiss">&times;</button>
                <p>
                    <strong>You are using an outdated Internet Explorer version.</strong>
                    Please <a href="http://browsehappy.com/">upgrade to a modern browser</a>
                    to improve your web experience.
                </p>
            </div>
		<![endif]-->

		<div class = "left-drawer show">
			<aside class = "navigation hide-all show-tiny show-small">
				<section class = "user">
					<a href = "javascript:void(0);">
						<span class = "avatar">
							<i class = "status on"></i>
							<img src = "{{ url.get( [ 'for' : 'theme-system', 'folder' : 'Images', 'file' : 'avatar.jpg'] ) }}" alt = "" class = "round">
						</span>
						<span class = "name">
							Benjamin Taluyo
							<b>Administrator</b>
						</span>
						<!-- <span class = "caret fa fa-caret-down"></span> -->
					</a>
				</section>

				<h6 class = "heading">MAIN MENU</h6>
				<ul class = "nav">
					<li id = "li-dashboard">
						<a href = "javascript:void(0);" class = "ink-toggle" id = "nav-dashboard" data-target = "#li-dashboard" data-class-name-on = "active" data-class-name-off = "" data-close-on-click = "false" data-close-on-inside-click = "#nav-dashboard" data-initial-state = "false">
							<span class = "figure"><i class = "fa fa-desktop"></i></span>
							<span class = "text">Dashboard</span>
							<span class = "arrow fa fa-chevron-right"></span>
						</a>

						<ul>
							<li class = "header">Dashboard</li>
							<li>
								<a href = "#">
									<span class = "text">Version 1</span>
									<span class = "number">
										<span class = "label ink-label red">23</span>
									</span>
								</a>
								<ul>
									<li>
										<a href = "#">
											<span class = "text">Version 1</span>
											<span class = "number">
												<span class = "label ink-label red">23</span>
											</span>
										</a>
									</li>
								</ul>
							</li>
							<li>
								<a href = "#">
									<span class = "text">Version 2</span>
									<span class = "number">
										<span class = "label ink-label red">4</span>
									</span>
								</a>
							</li>
						</ul>
					</li>

					<li id = "li-user">
						<a href = "javascript:void(0);" class = "ink-toggle" id = "nav-user" data-target = "#li-user" data-class-name-on = "active" data-class-name-off = "" data-close-on-click = "false" data-close-on-inside-click = "#nav-user" data-initial-state = "false">
							<span class = "figure"><i class = "fa fa-user"></i></span>
							<span class = "text">Users</span>
							<span class = "arrow fa fa-chevron-right"></span>
						</a>

						<ul>
							<li class = "header">User</li>
							<li>
								<a href = "#">
									<span class = "text">Version 1</span>
									<span class = "number">
										<span class = "label ink-label red">23</span>
									</span>
								</a>
							</li>
							<li>
								<a href = "#">
									<span class = "text">Version 2</span>
									<span class = "number">
										<span class = "label ink-label red">4</span>
									</span>
								</a>
							</li>
						</ul>
					</li>

					<li id = "li-setting">
						<a href = "javascript:void(0);" class = "ink-toggle" id = "nav-user" data-target = "#li-setting" data-class-name-on = "active" data-class-name-off = "" data-close-on-click = "false" data-close-on-inside-click = "#nav-setting" data-initial-state = "false">
							<span class = "figure"><i class = "fa fa-cogs"></i></span>
							<span class = "text">Settings</span>
							<span class = "arrow fa fa-chevron-right"></span>
						</a>
					</li>
				</ul>
			</aside>
		</div>

		<div class = "right-drawer">
			Left drawer content...
		</div>

		<div id = "wrapper" class = "content-drawer">

			<header id = "top" class = "">
				<section class = "left push-left">
					<ul class = "toolbar light all-100">
						<li class = "hide-all show-tiny show-small tiny-10 small-10 align-left"><a href = "javascript:void(0);" class = "left-drawer-trigger fa fa-align-justify"></a></li>
						<li class = "xlarge-100 large-100 medium-100 tiny-80 small-80 align-center">
							<a href = "javascript:void(0);" class = "logo all-100 align-center">
								<img src = "<?php echo $this->url->get( array( 'for' => 'theme-system', 'folder' => 'Images', 'file' => 'mbco-logo.png' ) ); ?>" alt = "" class = "" />
								<!--<img src = "<?php echo $this->url->get( array( 'for' => 'theme-system', 'folder' => 'Images', 'file' => 'logo-text.png' ) ); ?>" alt = "" class = "text show-all hide-medium" /> -->
							</a>
						</li>
						<!--<li class = "hide-all show-tiny show-small tiny-10 small-10 align-right"><a href = "javascript:void(0);" class = "right-drawer-trigger fa fa-users"></a></li>-->
					</ul>
				</section>
				<section class = "right">
					<ul class = "toolbar left dark margin-li push-left">
						<li class = "hide-tiny hide-small"><a href = "javascript:void(0);" class = "ink-toggle fa fa-outdent" id = "toggle-mini-navigation" data-target = "body" data-close-on-click = "false" data-close-on-inside-click = "#toggle-mini-navigation" data-class-name-on = "minimized" data-class-name-off = "" data-initial-state = "false"></a></li>
						<!--
						<li><a href = "javascript:void(0);" class = "fa fa-wechat"><span class = "notification"></span></a></li>
						<li><a href = "javascript:void(0);" class = "fa fa-bell"><span class = "notification"></span></a></li>
						<li><a href = "javascript:void(0);" class = "fa fa-search"></a></li>
						-->
					</ul>
					<?php
						echo $this->navigation->render( 'top-nav-right', array(
							'class' => 'toolbar right dark margin-li push-right'
						));
					?>
				</section>
			</header>

			<aside class = "navigation hide-all show-xlarge show-large show-medium  overflow-vertical">
				<section class = "user">
					<a href = "javascript:void(0);">
						<span class = "avatar">
							<i class = "status on"></i>
							<img src = "{{ url.get( [ 'for' : 'theme-system', 'folder' : 'Images', 'file' : 'avatar.jpg'] ) }}" alt = "" class = "round"></span>
						</span>
						<span class = "name hide-small hide-tiny">
							Benjamin Taluyo
							<b>Administrator</b>
						</span>
						<!-- <span class = "caret fa fa-caret-down"></span> -->
					</a>
				</section>

				<h6 class = "heading">MAIN MENU</h6>
				<?php
					echo $this->navigation->render( 'sidebar', array( ) );
				?>
			</aside>

			<div class = "main-content">
				<div class = "ink-grid vertical-space">
					<section class = "page-header">
						<h3 class = "page-title">
							{{ _._( 'main_title' ) }}
							<small class = "page-sub-title">{{ _._( 'main_description' ) }}</small>
						</h3>
					</section>

					<section class = "page-breadcrumb clearfix">
						<nav class = "ink-navigation clearfix">
							<ul class = "breadcrumbs push-left">
								<li><i class = "fa fa-home"></i><a href = "#">Home</a></li>
								{% if var_breadcrumbs is defined %}
									{% for name, link in var_breadcrumbs %}
										<li class = "{% if loop.last %} active {% endIf %}"><a href = "{{ link }}">{{ name }}</a></li>
									{% endFor %}
								{% endIf %}
							</ul>

							<!--
							<ul class = "menu horizontal push-right">
								<li>
									<a href = "#">
										<i class = "icon fa fa-search"></i>
										Search
										<i class = "caret fa fa-caret-down"></i>
									</a>
								</li>
								<li>
									<a href = "#">
										<i class = "icon"></i>
										Language
										<i class = "caret fa fa-caret-down"></i>
									</a>
								</li>
							</ul>
							-->
						</nav>
					</section>

					{% if flicker.has( 'success' ) %}
						{% for key, message in flicker.getMessages( 'success', true ) %}
							<section class = "ink-alert page-callout success">
								<a href = "#" class = "ink-close close">x</a>
								<h5>{{ _._( 'success_message_title' ) }}</h5>
								<p>{{ message }}</p>
							</section>
						{% endFor %}
					{% endIf %}
					{% if flicker.has( 'info' ) %}
						{% for key, message in flicker.getMessages( 'info', true ) %}
							<section class = "ink-alert page-callout info">
								<a href = "#" class = "ink-close close">x</a>
								<h5>{{ _._( 'info_message_title' ) }}</h5>
								<p>{{ message }}</p>
							</section>
						{% endFor %}
					{% endIf %}
					{% if flicker.has( 'warning' ) %}
						{% for key, message in flicker.getMessages( 'warning', true ) %}
							<section class = "ink-alert page-callout warning">
								<a href = "#" class = "ink-close close">x</a>
								<h5>{{ _._( 'warning_message_title' ) }}</h5>
								<p>{{ message }}</p>
							</section>
						{% endFor %}
					{% endIf %}
					{% if flicker.has( 'error' ) %}
						{% for key, message in flicker.getMessages( 'error', true ) %}
							<section class = "ink-alert page-callout danger">
								<a href = "#" class = "ink-close close">x</a>
								<h5>{{ _._( 'error_message_title' ) }}</h5>
								<p>{{ message }}</p>
							</section>
						{% endFor %}
					{% endIf %}

					{{ content( ) }}
				</div>
			</div>
		</div>
	</body>
</html>