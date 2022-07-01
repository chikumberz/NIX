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

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_source_dir' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'source_dir', 'placeholder' : _._( 'placeholder_source_dir' )  ) }}
							<p class = "tip">{{ _._( 'tip_source_dir' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_source_path' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'source_path', 'placeholder' : _._( 'placeholder_source_path' )  ) }}
							<p class = "tip">{{ _._( 'tip_source_path' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_icon_theme' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'icon_theme', 'placeholder' : _._( 'placeholder_icon_theme' )  ) }}
							<p class = "tip">{{ _._( 'tip_icon_theme' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_default_view' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'default_view', 'placeholder' : _._( 'placeholder_default_view' )  ) }}
							<p class = "tip">{{ _._( 'tip_default_view' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_file_number_limit_js' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'file_number_limit_js', 'placeholder' : _._( 'placeholder_file_number_limit_js' )  ) }}
							<p class = "tip">{{ _._( 'tip_file_number_limit_js' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<p class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_ellipsis_title_after_first_row' ) }}</b></p>
						<ul class = "control unstyled medium-100 small-100 tiny-100 all-70 no-margin">
							<li class = "custom-radio">{{ radio_field( 'ellipsis_title_after_first_row', 'value' : '0', 'id' : 'ellipsis_title_after_first_row_0' ) }} <label for = "ellipsis_title_after_first_row_0">{{ _._( 'placeholder_ellipsis_title_after_first_row_no' ) }}</label></li>
							<li class = "custom-radio">{{ radio_field( 'ellipsis_title_after_first_row', 'value' : '1', 'id' : 'ellipsis_title_after_first_row_1' ) }} <label for = "ellipsis_title_after_first_row_1">{{ _._( 'placeholder_ellipsis_title_after_first_row_yes' ) }}</label></li>
						</ul>
						<p class = "tip">{{ _._( 'tip_ellipsis_title_after_first_row' ) }}</p>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_lazy_loading_file_number_threshold' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'lazy_loading_file_number_threshold', 'placeholder' : _._( 'placeholder_lazy_loading_file_number_threshold' )  ) }}
							<p class = "tip">{{ _._( 'tip_lazy_loading_file_number_threshold' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<p class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_remember_text_filter' ) }}</b></p>
						<ul class = "control unstyled medium-100 small-100 tiny-100 all-70 no-margin">
							<li class = "custom-radio">{{ radio_field( 'remember_text_filter', 'value' : '0', 'id' : 'remember_text_filter_0' ) }} <label for = "remember_text_filter_0">{{ _._( 'placeholder_remember_text_filter_no' ) }}</label></li>
							<li class = "custom-radio">{{ radio_field( 'remember_text_filter', 'value' : '1', 'id' : 'remember_text_filter_1' ) }} <label for = "remember_text_filter_1">{{ _._( 'placeholder_remember_text_filter_yes' ) }}</label></li>
						</ul>
						<p class = "tip">{{ _._( 'tip_remember_text_filter' ) }}</p>
					</div>

					<div class = "control-group column-group validation">
						<p class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_show_folder_size' ) }}</b></p>
						<ul class = "control unstyled medium-100 small-100 tiny-100 all-70 no-margin">
							<li class = "custom-radio">{{ radio_field( 'show_folder_size', 'value' : '0', 'id' : 'show_folder_size_0' ) }} <label for = "show_folder_size_0">{{ _._( 'placeholder_show_folder_size_no' ) }}</label></li>
							<li class = "custom-radio">{{ radio_field( 'show_folder_size', 'value' : '1', 'id' : 'show_folder_size_1' ) }} <label for = "show_folder_size_1">{{ _._( 'placeholder_show_folder_size_yes' ) }}</label></li>
						</ul>
						<p class = "tip">{{ _._( 'tip_show_folder_size' ) }}</p>
					</div>

					<div class = "control-group column-group validation">
						<p class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_show_sorting_bar' ) }}</b></p>
						<ul class = "control unstyled medium-100 small-100 tiny-100 all-70 no-margin">
							<li class = "custom-radio">{{ radio_field( 'show_sorting_bar', 'value' : '0', 'id' : 'show_sorting_bar_0' ) }} <label for = "show_sorting_bar_0">{{ _._( 'placeholder_show_sorting_bar_no' ) }}</label></li>
							<li class = "custom-radio">{{ radio_field( 'show_sorting_bar', 'value' : '1', 'id' : 'show_sorting_bar_1' ) }} <label for = "show_sorting_bar_1">{{ _._( 'placeholder_show_sorting_bar_yes' ) }}</label></li>
						</ul>
						<p class = "tip">{{ _._( 'tip_show_sorting_bar' ) }}</p>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_copy_cut_max_size' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'copy_cut_max_size', 'placeholder' : _._( 'placeholder_copy_cut_max_size' )  ) }}
							<p class = "tip">{{ _._( 'tip_copy_cut_max_size' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_copy_cut_max_count' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'copy_cut_max_count', 'placeholder' : _._( 'placeholder_copy_cut_max_count' )  ) }}
							<p class = "tip">{{ _._( 'tip_copy_cut_max_count' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<p class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_enable_transliteration' ) }}</b></p>
						<ul class = "control unstyled medium-100 small-100 tiny-100 all-70 no-margin">
							<li class = "custom-radio">{{ radio_field( 'enable_transliteration', 'value' : '0', 'id' : 'enable_transliteration_0' ) }} <label for = "enable_transliteration_0">{{ _._( 'placeholder_enable_transliteration_no' ) }}</label></li>
							<li class = "custom-radio">{{ radio_field( 'enable_transliteration', 'value' : '1', 'id' : 'enable_transliteration_1' ) }} <label for = "enable_transliteration_1">{{ _._( 'placeholder_enable_transliteration_yes' ) }}</label></li>
						</ul>
						<p class = "tip">{{ _._( 'tip_enable_transliteration' ) }}</p>
					</div>

					<div class = "control-group column-group validation">
						<p class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_convert_spaces' ) }}</b></p>
						<ul class = "control unstyled medium-100 small-100 tiny-100 all-70 no-margin">
							<li class = "custom-radio">{{ radio_field( 'convert_spaces', 'value' : '0', 'id' : 'convert_spaces_0' ) }} <label for = "convert_spaces_0">{{ _._( 'placeholder_convert_spaces_no' ) }}</label></li>
							<li class = "custom-radio">{{ radio_field( 'convert_spaces', 'value' : '1', 'id' : 'convert_spaces_1' ) }} <label for = "convert_spaces_1">{{ _._( 'placeholder_convert_spaces_yes' ) }}</label></li>
						</ul>
						<p class = "tip">{{ _._( 'tip_convert_spaces' ) }}</p>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_replace_with' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'replace_with', 'placeholder' : _._( 'placeholder_replace_with' )  ) }}
							<p class = "tip">{{ _._( 'tip_replace_with' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_max_size_upload' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'max_size_upload', 'placeholder' : _._( 'placeholder_max_size_upload' )  ) }}
							<p class = "tip">{{ _._( 'tip_max_size_upload' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<p class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_enable_java_upload' ) }}</b></p>
						<ul class = "control unstyled medium-100 small-100 tiny-100 all-70 no-margin">
							<li class = "custom-radio">{{ radio_field( 'enable_java_upload', 'value' : '0', 'id' : 'enable_java_upload_0' ) }} <label for = "enable_java_upload_0">{{ _._( 'placeholder_enable_java_upload_no' ) }}</label></li>
							<li class = "custom-radio">{{ radio_field( 'enable_java_upload', 'value' : '1', 'id' : 'enable_java_upload_1' ) }} <label for = "enable_java_upload_1">{{ _._( 'placeholder_enable_java_upload_yes' ) }}</label></li>
						</ul>
						<p class = "tip">{{ _._( 'tip_enable_java_upload' ) }}</p>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_java_upload_max_size' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'java_upload_max_size', 'placeholder' : _._( 'placeholder_java_upload_max_size' )  ) }}
							<p class = "tip">{{ _._( 'tip_java_upload_max_size' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_hidden_folders' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_area( 'hidden_folders', 'placeholder' : _._( 'placeholder_hidden_folders' )  ) }}
							<p class = "tip">{{ _._( 'tip_hidden_folders' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_hidden_files' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_area( 'hidden_files', 'placeholder' : _._( 'placeholder_hidden_files' )  ) }}
							<p class = "tip">{{ _._( 'tip_hidden_files' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<p class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_enable_create_files' ) }}</b></p>
						<ul class = "control unstyled medium-100 small-100 tiny-100 all-70 no-margin">
							<li class = "custom-radio">{{ radio_field( 'enable_create_files', 'value' : '0', 'id' : 'enable_create_files_0' ) }} <label for = "enable_create_files_0">{{ _._( 'placeholder_enable_create_files_no' ) }}</label></li>
							<li class = "custom-radio">{{ radio_field( 'enable_create_files', 'value' : '1', 'id' : 'enable_create_files_1' ) }} <label for = "enable_create_files_1">{{ _._( 'placeholder_enable_create_files_yes' ) }}</label></li>
						</ul>
						<p class = "tip">{{ _._( 'tip_enable_create_files' ) }}</p>
					</div>

					<div class = "control-group column-group validation">
						<p class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_enable_delete_files' ) }}</b></p>
						<ul class = "control unstyled medium-100 small-100 tiny-100 all-70 no-margin">
							<li class = "custom-radio">{{ radio_field( 'enable_delete_files', 'value' : '0', 'id' : 'enable_delete_files_0' ) }} <label for = "enable_delete_files_0">{{ _._( 'placeholder_enable_delete_files_no' ) }}</label></li>
							<li class = "custom-radio">{{ radio_field( 'enable_delete_files', 'value' : '1', 'id' : 'enable_delete_files_1' ) }} <label for = "enable_delete_files_1">{{ _._( 'placeholder_enable_delete_files_yes' ) }}</label></li>
						</ul>
						<p class = "tip">{{ _._( 'tip_enable_delete_files' ) }}</p>
					</div>

					<div class = "control-group column-group validation">
						<p class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_enable_create_folders' ) }}</b></p>
						<ul class = "control unstyled medium-100 small-100 tiny-100 all-70 no-margin">
							<li class = "custom-radio">{{ radio_field( 'enable_create_folders', 'value' : '0', 'id' : 'enable_create_folders_0' ) }} <label for = "enable_create_folders_0">{{ _._( 'placeholder_enable_create_folders_no' ) }}</label></li>
							<li class = "custom-radio">{{ radio_field( 'enable_create_folders', 'value' : '1', 'id' : 'enable_create_folders_1' ) }} <label for = "enable_create_folders_1">{{ _._( 'placeholder_enable_create_folders_yes' ) }}</label></li>
						</ul>
						<p class = "tip">{{ _._( 'tip_enable_create_folders' ) }}</p>
					</div>

					<div class = "control-group column-group validation">
						<p class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_enable_delete_folders' ) }}</b></p>
						<ul class = "control unstyled medium-100 small-100 tiny-100 all-70 no-margin">
							<li class = "custom-radio">{{ radio_field( 'enable_delete_folders', 'value' : '0', 'id' : 'enable_delete_folders_0' ) }} <label for = "enable_delete_folders_0">{{ _._( 'placeholder_enable_delete_folders_no' ) }}</label></li>
							<li class = "custom-radio">{{ radio_field( 'enable_delete_folders', 'value' : '1', 'id' : 'enable_delete_folders_1' ) }} <label for = "enable_delete_folders_1">{{ _._( 'placeholder_enable_delete_folders_yes' ) }}</label></li>
						</ul>
						<p class = "tip">{{ _._( 'tip_enable_delete_folders' ) }}</p>
					</div>

					<div class = "control-group column-group validation">
						<p class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_enable_upload_files' ) }}</b></p>
						<ul class = "control unstyled medium-100 small-100 tiny-100 all-70 no-margin">
							<li class = "custom-radio">{{ radio_field( 'enable_upload_files', 'value' : '0', 'id' : 'enable_upload_files_0' ) }} <label for = "enable_upload_files_0">{{ _._( 'placeholder_enable_upload_files_no' ) }}</label></li>
							<li class = "custom-radio">{{ radio_field( 'enable_upload_files', 'value' : '1', 'id' : 'enable_upload_files_1' ) }} <label for = "enable_upload_files_1">{{ _._( 'placeholder_enable_upload_files_yes' ) }}</label></li>
						</ul>
						<p class = "tip">{{ _._( 'tip_enable_upload_files' ) }}</p>
					</div>

					<div class = "control-group column-group validation">
						<p class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_enable_rename_files' ) }}</b></p>
						<ul class = "control unstyled medium-100 small-100 tiny-100 all-70 no-margin">
							<li class = "custom-radio">{{ radio_field( 'enable_rename_files', 'value' : '0', 'id' : 'enable_rename_files_0' ) }} <label for = "enable_rename_files_0">{{ _._( 'placeholder_enable_rename_files_no' ) }}</label></li>
							<li class = "custom-radio">{{ radio_field( 'enable_rename_files', 'value' : '1', 'id' : 'enable_rename_files_1' ) }} <label for = "enable_rename_files_1">{{ _._( 'placeholder_enable_rename_files_yes' ) }}</label></li>
						</ul>
						<p class = "tip">{{ _._( 'tip_enable_rename_files' ) }}</p>
					</div>

					<div class = "control-group column-group validation">
						<p class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_enable_rename_folders' ) }}</b></p>
						<ul class = "control unstyled medium-100 small-100 tiny-100 all-70 no-margin">
							<li class = "custom-radio">{{ radio_field( 'enable_rename_folders', 'value' : '0', 'id' : 'enable_rename_folders_0' ) }} <label for = "enable_rename_folders_0">{{ _._( 'placeholder_enable_rename_folders_no' ) }}</label></li>
							<li class = "custom-radio">{{ radio_field( 'enable_rename_folders', 'value' : '1', 'id' : 'enable_rename_folders_1' ) }} <label for = "enable_rename_folders_1">{{ _._( 'placeholder_enable_rename_folders_yes' ) }}</label></li>
						</ul>
						<p class = "tip">{{ _._( 'tip_enable_rename_folders' ) }}</p>
					</div>

					<div class = "control-group column-group validation">
						<p class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_enable_duplicate_files' ) }}</b></p>
						<ul class = "control unstyled medium-100 small-100 tiny-100 all-70 no-margin">
							<li class = "custom-radio">{{ radio_field( 'enable_duplicate_files', 'value' : '0', 'id' : 'enable_duplicate_files_0' ) }} <label for = "enable_duplicate_files_0">{{ _._( 'placeholder_enable_duplicate_files_no' ) }}</label></li>
							<li class = "custom-radio">{{ radio_field( 'enable_duplicate_files', 'value' : '1', 'id' : 'enable_duplicate_files_1' ) }} <label for = "enable_duplicate_files_1">{{ _._( 'placeholder_enable_duplicate_files_yes' ) }}</label></li>
						</ul>
						<p class = "tip">{{ _._( 'tip_enable_duplicate_files' ) }}</p>
					</div>

					<div class = "control-group column-group validation">
						<p class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_enable_copy_cut_files' ) }}</b></p>
						<ul class = "control unstyled medium-100 small-100 tiny-100 all-70 no-margin">
							<li class = "custom-radio">{{ radio_field( 'enable_copy_cut_files', 'value' : '0', 'id' : 'enable_copy_cut_files_0' ) }} <label for = "enable_copy_cut_files_0">{{ _._( 'placeholder_enable_copy_cut_files_no' ) }}</label></li>
							<li class = "custom-radio">{{ radio_field( 'enable_copy_cut_files', 'value' : '1', 'id' : 'enable_copy_cut_files_1' ) }} <label for = "enable_copy_cut_files_1">{{ _._( 'placeholder_enable_copy_cut_files_yes' ) }}</label></li>
						</ul>
						<p class = "tip">{{ _._( 'tip_enable_copy_cut_files' ) }}</p>
					</div>

					<div class = "control-group column-group validation">
						<p class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_enable_copy_cut_folders' ) }}</b></p>
						<ul class = "control unstyled medium-100 small-100 tiny-100 all-70 no-margin">
							<li class = "custom-radio">{{ radio_field( 'enable_copy_cut_folders', 'value' : '0', 'id' : 'enable_copy_cut_folders_0' ) }} <label for = "enable_copy_cut_folders_0">{{ _._( 'placeholder_enable_copy_cut_folders_no' ) }}</label></li>
							<li class = "custom-radio">{{ radio_field( 'enable_copy_cut_folders', 'value' : '1', 'id' : 'enable_copy_cut_folders_1' ) }} <label for = "enable_copy_cut_folders_1">{{ _._( 'placeholder_enable_copy_cut_folders_yes' ) }}</label></li>
						</ul>
						<p class = "tip">{{ _._( 'tip_enable_copy_cut_folders' ) }}</p>
					</div>

					<div class = "control-group column-group validation">
						<p class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_enable_chmod_files' ) }}</b></p>
						<ul class = "control unstyled medium-100 small-100 tiny-100 all-70 no-margin">
							<li class = "custom-radio">{{ radio_field( 'enable_chmod_files', 'value' : '0', 'id' : 'enable_chmod_files_0' ) }} <label for = "enable_chmod_files_0">{{ _._( 'placeholder_enable_chmod_files_no' ) }}</label></li>
							<li class = "custom-radio">{{ radio_field( 'enable_chmod_files', 'value' : '1', 'id' : 'enable_chmod_files_1' ) }} <label for = "enable_chmod_files_1">{{ _._( 'placeholder_enable_chmod_files_yes' ) }}</label></li>
						</ul>
						<p class = "tip">{{ _._( 'tip_enable_chmod_files' ) }}</p>
					</div>

					<div class = "control-group column-group validation">
						<p class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_enable_chmod_folders' ) }}</b></p>
						<ul class = "control unstyled medium-100 small-100 tiny-100 all-70 no-margin">
							<li class = "custom-radio">{{ radio_field( 'enable_chmod_folders', 'value' : '0', 'id' : 'enable_chmod_folders_0' ) }} <label for = "enable_chmod_folders_0">{{ _._( 'placeholder_enable_chmod_folders_no' ) }}</label></li>
							<li class = "custom-radio">{{ radio_field( 'enable_chmod_folders', 'value' : '1', 'id' : 'enable_chmod_folders_1' ) }} <label for = "enable_chmod_folders_1">{{ _._( 'placeholder_enable_chmod_folders_yes' ) }}</label></li>
						</ul>
						<p class = "tip">{{ _._( 'tip_enable_chmod_folders' ) }}</p>
					</div>

					<div class = "control-group column-group validation">
						<p class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_enable_preview_text_files' ) }}</b></p>
						<ul class = "control unstyled medium-100 small-100 tiny-100 all-70 no-margin">
							<li class = "custom-radio">{{ radio_field( 'enable_preview_text_files', 'value' : '0', 'id' : 'enable_preview_text_files_0' ) }} <label for = "enable_preview_text_files_0">{{ _._( 'placeholder_enable_preview_text_files_no' ) }}</label></li>
							<li class = "custom-radio">{{ radio_field( 'enable_preview_text_files', 'value' : '1', 'id' : 'enable_preview_text_files_1' ) }} <label for = "enable_preview_text_files_1">{{ _._( 'placeholder_enable_preview_text_files_yes' ) }}</label></li>
						</ul>
						<p class = "tip">{{ _._( 'tip_enable_preview_text_files' ) }}</p>
					</div>

					<div class = "control-group column-group validation">
						<p class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_enable_edit_text_files' ) }}</b></p>
						<ul class = "control unstyled medium-100 small-100 tiny-100 all-70 no-margin">
							<li class = "custom-radio">{{ radio_field( 'enable_edit_text_files', 'value' : '0', 'id' : 'enable_edit_text_files_0' ) }} <label for = "enable_edit_text_files_0">{{ _._( 'placeholder_enable_edit_text_files_no' ) }}</label></li>
							<li class = "custom-radio">{{ radio_field( 'enable_edit_text_files', 'value' : '1', 'id' : 'enable_edit_text_files_1' ) }} <label for = "enable_edit_text_files_1">{{ _._( 'placeholder_enable_edit_text_files_yes' ) }}</label></li>
						</ul>
						<p class = "tip">{{ _._( 'tip_enable_edit_text_files' ) }}</p>
					</div>

					<div class = "control-group column-group validation">
						<p class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_enable_create_text_files' ) }}</b></p>
						<ul class = "control unstyled medium-100 small-100 tiny-100 all-70 no-margin">
							<li class = "custom-radio">{{ radio_field( 'enable_create_text_files', 'value' : '0', 'id' : 'enable_create_text_files_0' ) }} <label for = "enable_create_text_files_0">{{ _._( 'placeholder_enable_create_text_files_no' ) }}</label></li>
							<li class = "custom-radio">{{ radio_field( 'enable_create_text_files', 'value' : '1', 'id' : 'enable_create_text_files_1' ) }} <label for = "enable_create_text_files_1">{{ _._( 'placeholder_enable_create_text_files_yes' ) }}</label></li>
						</ul>
						<p class = "tip">{{ _._( 'tip_enable_create_text_files' ) }}</p>
					</div>

					<div class = "control-group column-group validation">
						<p class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_enable_googledoc' ) }}</b></p>
						<ul class = "control unstyled medium-100 small-100 tiny-100 all-70 no-margin">
							<li class = "custom-radio">{{ radio_field( 'enable_googledoc', 'value' : '0', 'id' : 'enable_googledoc_0' ) }} <label for = "enable_googledoc_0">{{ _._( 'placeholder_enable_googledoc_no' ) }}</label></li>
							<li class = "custom-radio">{{ radio_field( 'enable_googledoc', 'value' : '1', 'id' : 'enable_googledoc_1' ) }} <label for = "enable_googledoc_1">{{ _._( 'placeholder_enable_googledoc_yes' ) }}</label></li>
						</ul>
						<p class = "tip">{{ _._( 'tip_enable_googledoc' ) }}</p>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_extensions_previewable_text_file' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_area( 'extensions_previewable_text_file', 'placeholder' : _._( 'placeholder_extensions_previewable_text_file' )  ) }}
							<p class = "tip">{{ _._( 'tip_extensions_previewable_text_file' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_extensions_previewable_text_file_no_prettify' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_area( 'extensions_previewable_text_file_no_prettify', 'placeholder' : _._( 'placeholder_extensions_previewable_text_file_no_prettify' )  ) }}
							<p class = "tip">{{ _._( 'tip_extensions_previewable_text_file_no_prettify' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_extensions_editable_text_file' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_area( 'extensions_editable_text_file', 'placeholder' : _._( 'placeholder_extensions_editable_text_file' )  ) }}
							<p class = "tip">{{ _._( 'tip_extensions_editable_text_file' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_extensions_googledoc_file' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_area( 'extensions_googledoc_file', 'placeholder' : _._( 'placeholder_extensions_googledoc_file' )  ) }}
							<p class = "tip">{{ _._( 'tip_extensions_googledoc_file' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_extensions_viewerjs_file' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_area( 'extensions_viewerjs_file', 'placeholder' : _._( 'placeholder_extensions_viewerjs_file' )  ) }}
							<p class = "tip">{{ _._( 'tip_extensions_viewerjs_file' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_extensions_image' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_area( 'extensions_image', 'placeholder' : _._( 'placeholder_extensions_image' )  ) }}
							<p class = "tip">{{ _._( 'tip_extensions_image' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_extensions_file' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_area( 'extensions_file', 'placeholder' : _._( 'placeholder_extensions_file' )  ) }}
							<p class = "tip">{{ _._( 'tip_extensions_file' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_extensions_video' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_area( 'extensions_video', 'placeholder' : _._( 'placeholder_extensions_video' )  ) }}
							<p class = "tip">{{ _._( 'tip_extensions_video' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_extensions_audio' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_area( 'extensions_audio', 'placeholder' : _._( 'placeholder_extensions_audio' )  ) }}
							<p class = "tip">{{ _._( 'tip_extensions_audio' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_extensions_misc' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_area( 'extensions_misc', 'placeholder' : _._( 'placeholder_extensions_misc' )  ) }}
							<p class = "tip">{{ _._( 'tip_extensions_misc' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_image_max_width' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'image_max_width', 'placeholder' : _._( 'placeholder_image_max_width' )  ) }}
							<p class = "tip">{{ _._( 'tip_image_max_width' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_image_max_height' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'image_max_height', 'placeholder' : _._( 'placeholder_image_max_height' )  ) }}
							<p class = "tip">{{ _._( 'tip_image_max_height' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_image_max_mode' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'image_max_mode', 'placeholder' : _._( 'placeholder_image_max_mode' )  ) }}
							<p class = "tip">{{ _._( 'tip_image_max_mode' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<p class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_enable_image_resizing' ) }}</b></p>
						<ul class = "control unstyled medium-100 small-100 tiny-100 all-70 no-margin">
							<li class = "custom-radio">{{ radio_field( 'enable_image_resizing', 'value' : '0', 'id' : 'enable_image_resizing_0' ) }} <label for = "enable_image_resizing_0">{{ _._( 'placeholder_enable_image_resizing_no' ) }}</label></li>
							<li class = "custom-radio">{{ radio_field( 'enable_image_resizing', 'value' : '1', 'id' : 'enable_image_resizing_1' ) }} <label for = "enable_image_resizing_1">{{ _._( 'placeholder_enable_image_resizing_yes' ) }}</label></li>
						</ul>
						<p class = "tip">{{ _._( 'tip_enable_image_resizing' ) }}</p>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_image_resizing_width' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'image_resizing_width', 'placeholder' : _._( 'placeholder_image_resizing_width' )  ) }}
							<p class = "tip">{{ _._( 'tip_image_resizing_width' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_image_resizing_height' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'image_resizing_height', 'placeholder' : _._( 'placeholder_image_resizing_height' )  ) }}
							<p class = "tip">{{ _._( 'tip_image_resizing_height' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_image_resizing_mode' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'image_resizing_mode', 'placeholder' : _._( 'placeholder_image_resizing_mode' )  ) }}
							<p class = "tip">{{ _._( 'tip_image_resizing_mode' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_image_resizing_override' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'image_resizing_override', 'placeholder' : _._( 'placeholder_image_resizing_override' )  ) }}
							<p class = "tip">{{ _._( 'tip_image_resizing_override' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<p class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_enable_fixed_image_creation' ) }}</b></p>
						<ul class = "control unstyled medium-100 small-100 tiny-100 all-70 no-margin">
							<li class = "custom-radio">{{ radio_field( 'enable_fixed_image_creation', 'value' : '0', 'id' : 'enable_fixed_image_creation_0' ) }} <label for = "enable_fixed_image_creation_0">{{ _._( 'placeholder_enable_fixed_image_creation_no' ) }}</label></li>
							<li class = "custom-radio">{{ radio_field( 'enable_fixed_image_creation', 'value' : '1', 'id' : 'enable_fixed_image_creation_1' ) }} <label for = "enable_fixed_image_creation_1">{{ _._( 'placeholder_enable_fixed_image_creation_yes' ) }}</label></li>
						</ul>
						<p class = "tip">{{ _._( 'tip_enable_fixed_image_creation' ) }}</p>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_fixed_path_from_filemanager' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'fixed_path_from_filemanager', 'placeholder' : _._( 'placeholder_fixed_path_from_filemanager' )  ) }}
							<p class = "tip">{{ _._( 'tip_fixed_path_from_filemanager' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_fixed_image_creation_name_to_prepend' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'fixed_image_creation_name_to_prepend', 'placeholder' : _._( 'placeholder_fixed_image_creation_name_to_prepend' )  ) }}
							<p class = "tip">{{ _._( 'tip_fixed_image_creation_name_to_prepend' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_fixed_image_creation_name_to_append' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'fixed_image_creation_name_to_append', 'placeholder' : _._( 'placeholder_fixed_image_creation_name_to_append' )  ) }}
							<p class = "tip">{{ _._( 'tip_fixed_image_creation_name_to_append' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_fixed_image_creation_width' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'fixed_image_creation_width', 'placeholder' : _._( 'placeholder_fixed_image_creation_width' )  ) }}
							<p class = "tip">{{ _._( 'tip_fixed_image_creation_width' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_fixed_image_creation_height' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'fixed_image_creation_height', 'placeholder' : _._( 'placeholder_fixed_image_creation_height' )  ) }}
							<p class = "tip">{{ _._( 'tip_fixed_image_creation_height' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_fixed_image_creation_option' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'fixed_image_creation_option', 'placeholder' : _._( 'placeholder_fixed_image_creation_option' )  ) }}
							<p class = "tip">{{ _._( 'tip_fixed_image_creation_option' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<p class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_enable_relative_image_creation' ) }}</b></p>
						<ul class = "control unstyled medium-100 small-100 tiny-100 all-70 no-margin">
							<li class = "custom-radio">{{ radio_field( 'enable_relative_image_creation', 'value' : '0', 'id' : 'enable_relative_image_creation_0' ) }} <label for = "enable_relative_image_creation_0">{{ _._( 'placeholder_enable_relative_image_creation_no' ) }}</label></li>
							<li class = "custom-radio">{{ radio_field( 'enable_relative_image_creation', 'value' : '1', 'id' : 'enable_relative_image_creation_1' ) }} <label for = "enable_relative_image_creation_1">{{ _._( 'placeholder_enable_relative_image_creation_yes' ) }}</label></li>
						</ul>
						<p class = "tip">{{ _._( 'tip_enable_relative_image_creation' ) }}</p>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_relative_path_from_current_pos' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'relative_path_from_current_pos', 'placeholder' : _._( 'placeholder_relative_path_from_current_pos' )  ) }}
							<p class = "tip">{{ _._( 'tip_relative_path_from_current_pos' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_relative_image_creation_name_to_prepend' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'relative_image_creation_name_to_prepend', 'placeholder' : _._( 'placeholder_relative_image_creation_name_to_prepend' )  ) }}
							<p class = "tip">{{ _._( 'tip_relative_image_creation_name_to_prepend' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_relative_image_creation_name_to_append' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'relative_image_creation_name_to_append', 'placeholder' : _._( 'placeholder_relative_image_creation_name_to_append' )  ) }}
							<p class = "tip">{{ _._( 'tip_relative_image_creation_name_to_append' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_relative_image_creation_width' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'relative_image_creation_width', 'placeholder' : _._( 'placeholder_relative_image_creation_width' )  ) }}
							<p class = "tip">{{ _._( 'tip_relative_image_creation_width' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_relative_image_creation_height' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'relative_image_creation_height', 'placeholder' : _._( 'placeholder_relative_image_creation_height' )  ) }}
							<p class = "tip">{{ _._( 'tip_relative_image_creation_height' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_relative_image_creation_option' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'relative_image_creation_option', 'placeholder' : _._( 'placeholder_relative_image_creation_option' )  ) }}
							<p class = "tip">{{ _._( 'tip_relative_image_creation_option' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<p class = "medium-100 small-100 tiny-100 all-30 align-left"><b>{{ _._( 'field_enable_aviary' ) }}</b></p>
						<ul class = "control unstyled medium-100 small-100 tiny-100 all-70 no-margin">
							<li class = "custom-radio">{{ radio_field( 'enable_aviary', 'value' : '0', 'id' : 'enable_aviary_0' ) }} <label for = "enable_aviary_0">{{ _._( 'placeholder_enable_aviary_no' ) }}</label></li>
							<li class = "custom-radio">{{ radio_field( 'enable_aviary', 'value' : '1', 'id' : 'enable_aviary_1' ) }} <label for = "enable_aviary_1">{{ _._( 'placeholder_enable_aviary_yes' ) }}</label></li>
						</ul>
						<p class = "tip">{{ _._( 'tip_enable_aviary' ) }}</p>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_aviary_api_key' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'aviary_api_key', 'placeholder' : _._( 'placeholder_aviary_api_key' )  ) }}
							<p class = "tip">{{ _._( 'tip_aviary_api_key' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_aviary_api_secret' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'aviary_api_secret', 'placeholder' : _._( 'placeholder_aviary_api_secret' )  ) }}
							<p class = "tip">{{ _._( 'tip_aviary_api_secret' ) }}</p>
						</div>
					</div>

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

				</section>

				<section class = "panel-footer clearfix">
					<button type = "submit" class = "ink-button lightblue info push-right"><i class = "fa fa-save quarter-right-space"></i> {{ _._( 'text_save' ) }}</button>
					<button type = "reset" class = "ink-button red danger push-right"><i class = "fa fa-eraser quarter-right-space"></i> {{ _._( 'text_clear' ) }}</button>
				</section>
			</section>
		</div>
	</div>
</form>