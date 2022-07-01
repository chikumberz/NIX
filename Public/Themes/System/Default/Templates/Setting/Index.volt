<form action = "{{ var_form_url }}" method = "post" enctype = "multipart/form-data" class = "ink-form">

	{{ hidden_field( var_token_key, 'value' : var_token ) }}
	
	<div class = "column-group horizontal-gutters">
		<div class = "all-70 large-100 medium-100 small-100 tiny-100">
			<section class = "panel primary">
				<header class = "panel-header">
					<h6 class = "panel-title">
						<i class = "fa fa-file-text-o half-right-space"></i> {{ _._( 'text_title' ) }}
					</h6>
				</header>	
				
				<section class = "panel-body">

					<h4 class = "title-bottom-line">{{ _._( 'text_setting_title' ) }}</h4>
					<blockquote class = "fw-300 note">{{ _._( 'text_setting_description' ) }}</blockquote>
					
					
					<div class = "control-group column-group validation">
						<label for = "title" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_title' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'title', 'placeholder' : _._( 'placeholder_title' )  ) }}
							<p class = "tip">{{ _._( 'tip_title' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "description" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_description' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'description', 'placeholder' : _._( 'placeholder_description' )  ) }}
							<p class = "tip">{{ _._( 'tip_description' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "address" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_address' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'address', 'placeholder' : _._( 'placeholder_address' )  ) }}
							<p class = "tip">{{ _._( 'tip_address' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "backend_url" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_backend_url' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'backend_url', 'placeholder' : _._( 'placeholder_backend_url' )  ) }}
							<p class = "tip">{{ _._( 'tip_backend_url' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "backend_theme" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_backend_theme' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ select( 'backend_theme', var_backend_themes, 'useEmpty' : true, 'emptyText' : _._( 'placeholder_backend_theme' )  ) }}
							<p class = "tip">{{ _._( 'tip_backend_theme' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "frontend_theme" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_frontend_theme' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ select( 'frontend_theme', var_frontend_themes, 'useEmpty' : true, 'emptyText' : _._( 'placeholder_frontend_theme' )  ) }}
							<p class = "tip">{{ _._( 'tip_frontend_theme' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "backend_language" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_backend_language' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ select( 'backend_language', var_backend_languages, 'useEmpty' : true, 'emptyText' : _._( 'placeholder_backend_language' )  ) }}
							<p class = "tip">{{ _._( 'tip_backend_language' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "frontend_language" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_frontend_language' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ select( 'frontend_language', var_frontend_languages, 'useEmpty' : true, 'emptyText' : _._( 'placeholder_frontend_language' )  ) }}
							<p class = "tip">{{ _._( 'tip_frontend_language' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "avatar_size" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_avatar_size' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'avatar_size', 'placeholder' : _._( 'placeholder_avatar_size' )  ) }}
							<p class = "tip">{{ _._( 'tip_avatar_size' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "table_show" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_table_show' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_area( 'table_show', 'placeholder' : _._( 'placeholder_table_show' )  ) }}
							<p class = "tip">{{ _._( 'tip_table_show' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "table_show_default" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_table_show_default' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'table_show_default', 'placeholder' : _._( 'placeholder_table_show_default' )  ) }}
							<p class = "tip">{{ _._( 'tip_table_show_default' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<p class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_seo_url' ) }}</b></p>
						<ul class = "control unstyled medium-100 small-100 tiny-100 all-80">
							<li class = "custom-radio">{{ radio_field( 'seo_url', 'value' : '0', 'id' : 'seo_url_0' ) }} <label for = "seo_url_0">{{ _._( 'placeholder_seo_url_no' ) }}</label></li>
							<li class = "custom-radio">{{ radio_field( 'seo_url', 'value' : '1', 'id' : 'seo_url_1' ) }} <label for = "seo_url_1">{{ _._( 'placeholder_seo_url_yes' ) }}</label></li>
						</ul>
						<p class = "tip">{{ _._( 'tip_seo_url' ) }}</p>
					</div>

					<div class = "control-group column-group validation">
						<p class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_maintenance' ) }}</b></p>
						<ul class = "control unstyled medium-100 small-100 tiny-100 all-80">
							<li class = "custom-radio">{{ radio_field( 'maintenance', 'value' : '0', 'id' : 'maintenance_0' ) }} <label for = "maintenance_0">{{ _._( 'placeholder_maintenance_no' ) }}</label></li>
							<li class = "custom-radio">{{ radio_field( 'maintenance', 'value' : '1', 'id' : 'maintenance_1' ) }} <label for = "maintenance_1">{{ _._( 'placeholder_maintenance_yes' ) }}</label></li>
						</ul>
						<p class = "tip">{{ _._( 'tip_maintenance' ) }}</p>
					</div>

					<div class = "control-group column-group validation">
						<label for = "user_status_active" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_user_status_active' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ select( 'user_status_active', var_user_status, 'using' : ['user_status_id', 'status'] , 'useEmpty' : true, 'emptyText' : _._( 'placeholder_user_status_active' )  ) }}
							<p class = "tip">{{ _._( 'tip_user_status_active' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<p class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_error_display' ) }}</b></p>
						<ul class = "control unstyled medium-100 small-100 tiny-100 all-80">
							<li class = "custom-radio">{{ radio_field( 'error_display', 'value' : '0', 'id' : 'error_display_0' ) }} <label for = "error_display_0">{{ _._( 'placeholder_error_display_no' ) }}</label></li>
							<li class = "custom-radio">{{ radio_field( 'error_display', 'value' : '1', 'id' : 'error_display_1' ) }} <label for = "error_display_1">{{ _._( 'placeholder_error_display_yes' ) }}</label></li>
						</ul>
						<p class = "tip">{{ _._( 'tip_error_display' ) }}</p>
					</div>

					<div class = "control-group column-group validation">
						<p class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_error_log' ) }}</b></p>
						<ul class = "control unstyled medium-100 small-100 tiny-100 all-80">
							<li class = "custom-radio">{{ radio_field( 'error_log', 'value' : '0', 'id' : 'error_log_0' ) }} <label for = "error_log_0">{{ _._( 'placeholder_error_log_no' ) }}</label></li>
							<li class = "custom-radio">{{ radio_field( 'error_log', 'value' : '1', 'id' : 'error_log_1' ) }} <label for = "error_log_1">{{ _._( 'placeholder_error_log_yes' ) }}</label></li>
						</ul>
						<p class = "tip">{{ _._( 'tip_error_log' ) }}</p>
					</div>
					
					<div class = "control-group column-group validation">
						<label for = "error_log_file" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_error_log_file' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'error_log_file', 'placeholder' : _._( 'placeholder_error_log_file' )  ) }}
							<p class = "tip">{{ _._( 'tip_error_log_file' ) }}</p>
						</div>
					</div>
					
					<div class = "control-group column-group validation">
						<p class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_sql_log' ) }}</b></p>
						<ul class = "control unstyled medium-100 small-100 tiny-100 all-80">
							<li class = "custom-radio">{{ radio_field( 'sql_log', 'value' : '0', 'id' : 'sql_log_0' ) }} <label for = "sql_log_0">{{ _._( 'placeholder_sql_log_no' ) }}</label></li>
							<li class = "custom-radio">{{ radio_field( 'sql_log', 'value' : '1', 'id' : 'sql_log_1' ) }} <label for = "sql_log_1">{{ _._( 'placeholder_sql_log_yes' ) }}</label></li>
						</ul>
						<p class = "tip">{{ _._( 'tip_sql_log' ) }}</p>
					</div>

					<div class = "control-group column-group validation">
						<label for = "sql_log_file" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_sql_log_file' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'sql_log_file', 'placeholder' : _._( 'placeholder_sql_log_file' )  ) }}
							<p class = "tip">{{ _._( 'tip_sql_log_file' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<p class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_class_log' ) }}</b></p>
						<ul class = "control unstyled medium-100 small-100 tiny-100 all-80">
							<li class = "custom-radio">{{ radio_field( 'class_log', 'value' : '0', 'id' : 'class_log_0' ) }} <label for = "class_log_0">{{ _._( 'placeholder_class_log_no' ) }}</label></li>
							<li class = "custom-radio">{{ radio_field( 'class_log', 'value' : '1', 'id' : 'class_log_1' ) }} <label for = "class_log_1">{{ _._( 'placeholder_class_log_yes' ) }}</label></li>
						</ul>
						<p class = "tip">{{ _._( 'tip_class_log' ) }}</p>
					</div>

					<div class = "control-group column-group validation">
						<label for = "class_log_file" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_class_log_file' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'class_log_file', 'placeholder' : _._( 'placeholder_class_log_file' )  ) }}
							<p class = "tip">{{ _._( 'tip_class_log_file' ) }}</p>
						</div>
					</div>


				</section>

				<section class = "panel-footer clearfix">
					<button type = "submit" class = "ink-button lightblue info push-right"><i class = "fa fa-save quarter-right-space"></i> {{ _._( 'btn_save' ) }}</button>
					<button type = "reset" class = "ink-button red danger push-right"><i class = "fa fa-eraser quarter-right-space"></i> {{ _._( 'btn_clear' ) }}</button>
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
					<button type = "submit" class = "ink-button lightblue info push-right"><i class = "fa fa-save quarter-right-space"></i> {{ _._( 'btn_save' ) }}</button>
					<button type = "reset" class = "ink-button red danger push-right"><i class = "fa fa-eraser quarter-right-space"></i> {{ _._( 'btn_clear' ) }}</button>
				</section>
			</section>
		</div>
	</div>
</form>