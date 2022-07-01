<header id = "login-header">
	<h5 class = "page-title half-padding">
		{{ var_title }}
		<small class = "page-sub-title">{{ var_address }}</small>
	</h5>
</header>

<div class = "ink-grid">
	<div class = "column-group push-center push-middle" style = "height: 580px;">
		{{ form( var_login_auth_url, 'method' : 'post', 'enctype' : 'multipart/form-data', 'class' : 'ink-form' ) }}
			{{ hidden_field( security.getTokenKey( ), 'value' : security.getToken( ) ) }}

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

			<section id = "login-form">
				<div id = "login-form-border">
					<div id = "login-thumbnail" class = "">
						<div class = "push-center all-50">
							<div id = "thumb" class = "round">
								<img src = "<?php echo $this->url->get( array( 'for' => 'theme-system', 'folder' => 'Images', 'file' => 'denr-logo.jpg' ) ); ?>" alt = "">
							</div>
						</div>
						<div id = "caption" class = "align-center">
							<h6>{{ var_title }}</h6>
							<small>{{ var_address }}</small>
						</div>
					</div>

					<div id = "form">
						<div class = "control-group">
							<div class = "control append-symbol">
								<span>
									{{ text_field( 'username', 'placeholder' : 'Username' ) }}
									<i class = "fa fa-user"></i>
								</span>
							</div>
						</div>

						<div class = "control-group">
							<div class = "control append-symbol">
								<span>
									{{ password_field( 'password', 'placeholder' : 'Password' ) }}
									<i class = "fa fa-lock"></i>
								</span>
							</div>
						</div>

						<div class = "control-group">
							<!-- <span class = "custom-checkbox">{{ check_field( 'remember_me' ) }}<label for = "remember_me" class = "no-margin"> Remember Me</label></span> -->
							<button type = "submit" class = "ink-button lightblue no-margin all-100"><i class = "fa fa-unlock half-right-space"></i> <strong>{{ _._( 'text_sign_in' ) }}</strong></button>
						</div>
					</div>
				</div>
			</section>
		</form>
	</div>
</div>

<footer id = "login-footer" class = "clearfix">
	<div class = "column-group">
		<div class = "all-50 small-100 tiny-100 horizontal-padding quarter-vertical-padding copyright">
			<small>{{ _._( 'text_footer' ) }}</small>
		</div>

		<div class = "all-50 small-100 tiny-100 small-horizontal-padding tiny-quarter-vertical-padding">
			<div class = "button-toolbar push-right small-push-center tiny-push-center">
				<div class = "button-group">
					<a href = "" class = "ink-button"><i class = "fa fa-desktop"></i></a>
					<a href = "" class = "ink-button"><i class = "fa fa-ellipsis-h"></i></a>
					<a href = "" class = "ink-button"><i class = "fa fa-wheelchair"></i></a>
				</div>
			</div>
		</div>
	</div>
</footer>