{{ form( var_save_url, 'method' : 'post', 'enctype' : 'multipart/form-data', 'class' : 'ink-form' ) }}

	{{ hidden_field( security.getTokenKey( ), 'value' : security.getToken( ) ) }}

	<div class = "column-group horizontal-gutters">
		<div class = "all-70 large-100 medium-100 small-100 tiny-100">
			<section class = "panel primary">
				<header class = "panel-header">
					<h6 class = "panel-title">
						<i class = "fa fa-file-text-o half-right-space"></i> {{ _._( 'panel_title' ) }}
					</h6>
				</header>

				<section class = "panel-body">
					<blockquote class = "fw-300 note">{{ _._( 'panel_description' ) }}</blockquote>

					<section id = "setting-tabs" class = "ink-tabs top">

						<ul class = "tabs-nav">
					        <li><a class = "tabs-tab" href = "#general">{{ _._( 'text_general' ) }}</a></li>
					        <li><a class = "tabs-tab" href = "#system">{{ _._( 'text_system' ) }}</a></li>
					        <li><a class = "tabs-tab" href = "#grid">{{ _._( 'text_grid' ) }}</a></li>
					        <li><a class = "tabs-tab" href = "#mail">{{ _._( 'text_mail' ) }}</a></li>
					        <li><a class = "tabs-tab" href = "#server">{{ _._( 'text_server' ) }}</a></li>
					    </ul>

						<section id = "general" class = "tabs-content">
							<div class = "control-group column-group validation">
								<label for = "title" class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_title' ) }}</b></label>
								<div class = "control medium-100 small-100 tiny-100 all-70">
									{{ text_field( 'title', 'placeholder' : _._( 'placeholder_title' )  ) }}
									<p class = "tip">{{ _._( 'tip_title' ) }}</p>
								</div>
							</div>

							<div class = "control-group column-group validation">
								<label for = "description" class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_description' ) }}</b></label>
								<div class = "control medium-100 small-100 tiny-100 all-70">
									{{ text_field( 'description', 'placeholder' : _._( 'placeholder_description' )  ) }}
									<p class = "tip">{{ _._( 'tip_description' ) }}</p>
								</div>
							</div>

							<div class = "control-group column-group validation">
								<label for = "keywords" class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_keywords' ) }}</b></label>
								<div class = "control medium-100 small-100 tiny-100 all-70">
									{{ text_field( 'keywords', 'placeholder' : _._( 'placeholder_keywords' )  ) }}
									<p class = "tip">{{ _._( 'tip_keywords' ) }}</p>
								</div>
							</div>

							<div class = "control-group column-group validation">
								<label for = "address" class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_address' ) }}</b></label>
								<div class = "control medium-100 small-100 tiny-100 all-70">
									{{ text_field( 'address', 'placeholder' : _._( 'placeholder_address' )  ) }}
									<p class = "tip">{{ _._( 'tip_address' ) }}</p>
								</div>
							</div>

							<div class = "control-group column-group validation">
								<label for = "email" class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_email' ) }}</b></label>
								<div class = "control medium-100 small-100 tiny-100 all-70">
									{{ text_field( 'email', 'placeholder' : _._( 'placeholder_email' )  ) }}
									<p class = "tip">{{ _._( 'tip_email' ) }}</p>
								</div>
							</div>

							<div class = "control-group column-group validation">
								<label for = "telephone_no" class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_telephone_no' ) }}</b></label>
								<div class = "control medium-100 small-100 tiny-100 all-70">
									{{ text_field( 'telephone_no', 'placeholder' : _._( 'placeholder_telephone_no' )  ) }}
									<p class = "tip">{{ _._( 'tip_telephone_no' ) }}</p>
								</div>
							</div>

							<div class = "control-group column-group validation">
								<label for = "fax_no" class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_fax_no' ) }}</b></label>
								<div class = "control medium-100 small-100 tiny-100 all-70">
									{{ text_field( 'fax_no', 'placeholder' : _._( 'placeholder_fax_no' )  ) }}
									<p class = "tip">{{ _._( 'tip_fax_no' ) }}</p>
								</div>
							</div>
						</section>

						<section id = "system" class = "tabs-content">
							<div class = "control-group column-group validation">
								<label for = "url" class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_url' ) }}</b></label>
								<div class = "control medium-100 small-100 tiny-100 all-70">
									{{ text_field( 'url', 'placeholder' : _._( 'placeholder_url' )  ) }}
									<p class = "tip">{{ _._( 'tip_url' ) }}</p>
								</div>
							</div>

							<div class = "control-group column-group validation">
								<label for = "theme" class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_theme' ) }}</b></label>
								<div class = "control medium-100 small-100 tiny-100 all-70">
									{{ select( 'theme', var_themes, 'useEmpty' : true, 'emptyText' : _._( 'placeholder_theme' )  ) }}
									<p class = "tip">{{ _._( 'tip_theme' ) }}</p>
								</div>
							</div>

							<div class = "control-group column-group validation">
								<label for = "language" class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_language' ) }}</b></label>
								<div class = "control medium-100 small-100 tiny-100 all-70">
									{{ select( 'language', var_languages, 'useEmpty' : true, 'emptyText' : _._( 'placeholder_language' )  ) }}
									<p class = "tip">{{ _._( 'tip_language' ) }}</p>
								</div>
							</div>
							<div class = "control-group column-group validation">
								<p class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_seo_url' ) }}</b></p>
								<ul class = "control unstyled medium-100 small-100 tiny-100 all-70 no-margin">
									<li class = "custom-radio">{{ radio_field( 'seo_url', 'value' : '0', 'id' : 'seo_url_0' ) }} <label for = "seo_url_0">{{ _._( 'placeholder_seo_url_no' ) }}</label></li>
									<li class = "custom-radio">{{ radio_field( 'seo_url', 'value' : '1', 'id' : 'seo_url_1' ) }} <label for = "seo_url_1">{{ _._( 'placeholder_seo_url_yes' ) }}</label></li>
								</ul>
								<p class = "tip">{{ _._( 'tip_seo_url' ) }}</p>
							</div>
						</section>

						<section id = "grid" class = "tabs-content">
							<div class = "control-group column-group validation">
								<label for = "table_show" class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_table_show' ) }}</b></label>
								<div class = "control medium-100 small-100 tiny-100 all-70">
									{{ text_area( 'table_show', 'placeholder' : _._( 'placeholder_table_show' )  ) }}
									<p class = "tip">{{ _._( 'tip_table_show' ) }}</p>
								</div>
							</div>

							<div class = "control-group column-group validation">
								<label for = "table_show_default" class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_table_show_default' ) }}</b></label>
								<div class = "control medium-100 small-100 tiny-100 all-70">
									{{ text_field( 'table_show_default', 'placeholder' : _._( 'placeholder_table_show_default' )  ) }}
									<p class = "tip">{{ _._( 'tip_table_show_default' ) }}</p>
								</div>
							</div>
						</section>

						<section id = "mail" class = "tabs-content">
							<div class = "control-group column-group validation">
								<label for = "mail_protocol" class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_mail_protocol' ) }}</b></label>
								<div class = "control medium-100 small-100 tiny-100 all-70">
									{{ select( 'mail_protocol', var_mail_protocols, 'useEmpty' : true, 'emptyText' : _._( 'placeholder_mail_protocol' )  ) }}
									<p class = "tip">{{ _._( 'tip_mail_protocol' ) }}</p>
								</div>
							</div>

							<div class = "control-group column-group validation">
								<label for = "mail_parameter" class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_mail_parameter' ) }}</b></label>
								<div class = "control medium-100 small-100 tiny-100 all-70">
									{{ text_field( 'mail_parameter', 'placeholder' : _._( 'placeholder_mail_parameter' )  ) }}
									<p class = "tip">{{ _._( 'tip_mail_parameter' ) }}</p>
								</div>
							</div>

							<div class = "control-group column-group validation">
								<label for = "smtp_host" class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_smtp_host' ) }}</b></label>
								<div class = "control medium-100 small-100 tiny-100 all-70">
									{{ text_field( 'smtp_host', 'placeholder' : _._( 'placeholder_smtp_host' )  ) }}
									<p class = "tip">{{ _._( 'tip_smtp_host' ) }}</p>
								</div>
							</div>

							<div class = "control-group column-group validation">
								<label for = "smtp_username" class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_smtp_username' ) }}</b></label>
								<div class = "control medium-100 small-100 tiny-100 all-70">
									{{ text_field( 'smtp_username', 'placeholder' : _._( 'placeholder_smtp_username' )  ) }}
									<p class = "tip">{{ _._( 'tip_smtp_username' ) }}</p>
								</div>
							</div>

							<div class = "control-group column-group validation">
								<label for = "smtp_password" class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_smtp_password' ) }}</b></label>
								<div class = "control medium-100 small-100 tiny-100 all-70">
									{{ text_field( 'smtp_password', 'placeholder' : _._( 'placeholder_smtp_password' )  ) }}
									<p class = "tip">{{ _._( 'tip_smtp_password' ) }}</p>
								</div>
							</div>

							<div class = "control-group column-group validation">
								<label for = "smtp_port" class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_smtp_port' ) }}</b></label>
								<div class = "control medium-100 small-100 tiny-100 all-70">
									{{ text_field( 'smtp_port', 'placeholder' : _._( 'placeholder_smtp_port' )  ) }}
									<p class = "tip">{{ _._( 'tip_smtp_port' ) }}</p>
								</div>
							</div>

							<div class = "control-group column-group validation">
								<label for = "smtp_timeout" class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_smtp_timeout' ) }}</b></label>
								<div class = "control medium-100 small-100 tiny-100 all-70">
									{{ text_field( 'smtp_timeout', 'placeholder' : _._( 'placeholder_smtp_timeout' )  ) }}
									<p class = "tip">{{ _._( 'tip_smtp_timeout' ) }}</p>
								</div>
							</div>

							<div class = "control-group column-group validation">
								<label for = "emails" class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_emails' ) }}</b></label>
								<div class = "control medium-100 small-100 tiny-100 all-70">
									{{ text_area( 'emails', 'placeholder' : _._( 'placeholder_emails' )  ) }}
									<p class = "tip">{{ _._( 'tip_emails' ) }}</p>
								</div>
							</div>
						</section>

						<section id = "server" class = "tabs-content">
							<div class = "control-group column-group validation">
								<p class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_maintenance' ) }}</b></p>
								<ul class = "control unstyled medium-100 small-100 tiny-100 all-70 no-margin">
									<li class = "custom-radio">{{ radio_field( 'maintenance', 'value' : '0', 'id' : 'maintenance_0' ) }} <label for = "maintenance_0">{{ _._( 'placeholder_maintenance_no' ) }}</label></li>
									<li class = "custom-radio">{{ radio_field( 'maintenance', 'value' : '1', 'id' : 'maintenance_1' ) }} <label for = "maintenance_1">{{ _._( 'placeholder_maintenance_yes' ) }}</label></li>
								</ul>
								<p class = "tip">{{ _._( 'tip_maintenance' ) }}</p>
							</div>

							<div class = "control-group column-group validation">
								<p class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_error_display' ) }}</b></p>
								<ul class = "control unstyled medium-100 small-100 tiny-100 all-70 no-margin">
									<li class = "custom-radio">{{ radio_field( 'error_display', 'value' : '0', 'id' : 'error_display_0' ) }} <label for = "error_display_0">{{ _._( 'placeholder_error_display_no' ) }}</label></li>
									<li class = "custom-radio">{{ radio_field( 'error_display', 'value' : '1', 'id' : 'error_display_1' ) }} <label for = "error_display_1">{{ _._( 'placeholder_error_display_yes' ) }}</label></li>
								</ul>
								<p class = "tip">{{ _._( 'tip_error_display' ) }}</p>
							</div>

							<div class = "control-group column-group validation">
								<p class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_error_log' ) }}</b></p>
								<ul class = "control unstyled medium-100 small-100 tiny-100 all-70 no-margin">
									<li class = "custom-radio">{{ radio_field( 'error_log', 'value' : '0', 'id' : 'error_log_0' ) }} <label for = "error_log_0">{{ _._( 'placeholder_error_log_no' ) }}</label></li>
									<li class = "custom-radio">{{ radio_field( 'error_log', 'value' : '1', 'id' : 'error_log_1' ) }} <label for = "error_log_1">{{ _._( 'placeholder_error_log_yes' ) }}</label></li>
								</ul>
								<p class = "tip">{{ _._( 'tip_error_log' ) }}</p>
							</div>

							<div class = "control-group column-group validation">
								<label for = "error_log_file" class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_error_log_file' ) }}</b></label>
								<div class = "control medium-100 small-100 tiny-100 all-70">
									{{ text_field( 'error_log_file', 'placeholder' : _._( 'placeholder_error_log_file' )  ) }}
									<p class = "tip">{{ _._( 'tip_error_log_file' ) }}</p>
								</div>
							</div>

							<div class = "control-group column-group validation">
								<p class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_sql_log' ) }}</b></p>
								<ul class = "control unstyled medium-100 small-100 tiny-100 all-70 no-margin">
									<li class = "custom-radio">{{ radio_field( 'sql_log', 'value' : '0', 'id' : 'sql_log_0' ) }} <label for = "sql_log_0">{{ _._( 'placeholder_sql_log_no' ) }}</label></li>
									<li class = "custom-radio">{{ radio_field( 'sql_log', 'value' : '1', 'id' : 'sql_log_1' ) }} <label for = "sql_log_1">{{ _._( 'placeholder_sql_log_yes' ) }}</label></li>
								</ul>
								<p class = "tip">{{ _._( 'tip_sql_log' ) }}</p>
							</div>

							<div class = "control-group column-group validation">
								<label for = "sql_log_file" class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_sql_log_file' ) }}</b></label>
								<div class = "control medium-100 small-100 tiny-100 all-70">
									{{ text_field( 'sql_log_file', 'placeholder' : _._( 'placeholder_sql_log_file' )  ) }}
									<p class = "tip">{{ _._( 'tip_sql_log_file' ) }}</p>
								</div>
							</div>

							<div class = "control-group column-group validation">
								<p class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_class_log' ) }}</b></p>
								<ul class = "control unstyled medium-100 small-100 tiny-100 all-70 no-margin">
									<li class = "custom-radio">{{ radio_field( 'class_log', 'value' : '0', 'id' : 'class_log_0' ) }} <label for = "class_log_0">{{ _._( 'placeholder_class_log_no' ) }}</label></li>
									<li class = "custom-radio">{{ radio_field( 'class_log', 'value' : '1', 'id' : 'class_log_1' ) }} <label for = "class_log_1">{{ _._( 'placeholder_class_log_yes' ) }}</label></li>
								</ul>
								<p class = "tip">{{ _._( 'tip_class_log' ) }}</p>
							</div>

							<div class = "control-group column-group validation">
								<label for = "class_log_file" class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_class_log_file' ) }}</b></label>
								<div class = "control medium-100 small-100 tiny-100 all-70">
									{{ text_field( 'class_log_file', 'placeholder' : _._( 'placeholder_class_log_file' )  ) }}
									<p class = "tip">{{ _._( 'tip_class_log_file' ) }}</p>
								</div>
							</div>
						</section>

					</section>
				</section>

				<section class = "panel-footer clearfix">
					<button type = "submit" class = "ink-button lightblue info push-right"><i class = "fa fa-save quarter-right-space"></i> {{ _._( 'text_save' ) }}</button>
					<button type = "reset" class = "ink-button red danger push-right"><i class = "fa fa-eraser quarter-right-space"></i> {{ _._( 'text_clear' ) }}</button>
				</section>
			</section>
		</div>

		<div class = "all-30 hide-large hide-medium hide-small hide-tiny">
			<section class = "panel primary">
				<header class = "panel-header">
					<h6 class = "panel-title">
						<i class = "fa fa-tasks half-right-space"></i> {{ _._( 'text_action' ) }}
					</h6>
				</header>

				<section class = "panel-body">
					<!-- <div class = "control-group column-group validation">
						<label for = "" class = "all-100 align-left"><b>{{ _._( 'field_created_on' ) }}</b></label>
						<div class = "control all-100">
							{{ var_created_on }}
						</div>
					</div>
					<div class = "control-group column-group validation">
						<label for = "" class = "all-100 align-left"><b>{{ _._( 'field_updated_on' ) }}</b></label>
						<div class = "control all-100">
							{{ var_updated_on }}
						</div>
					</div> -->
				</section>

				<section class = "panel-footer clearfix">
					<button type = "submit" class = "ink-button lightblue info push-right"><i class = "fa fa-save quarter-right-space"></i> {{ _._( 'text_save' ) }}</button>
					<button type = "reset" class = "ink-button red danger push-right"><i class = "fa fa-eraser quarter-right-space"></i> {{ _._( 'text_clear' ) }}</button>
				</section>
			</section>
		</div>
	</div>
{{ end_form( ) }}