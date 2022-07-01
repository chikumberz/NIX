{{ assets.outputCSS( 'file-manager-css' ) }}
<script type = "text/javascript">
	var config = {
		editor: '{{ var_config['editor'] }}',
		apply: '{{ var_config['apply'] }}',
		view: {{ var_config['view'] }},
		type: {{ var_config['type'] }},
		field_id: {{ var_config['field_id']  ? 'true' : 'false' }},
		popup: {{ var_config['popup'] ? 'true' : 'false' }},
		crossdomain: {{ var_config['crossdomain'] ? 'true' : 'false' }},
		duplicate: {{ var_config['enable_duplicate_files'] ? 'true' : 'false' }},
		clipboard: '{{ var_config['clipboard'] }}',
		sort_by: '{{ var_config['sort_by'] }}',
		sort_order: {{ var_config['sort_order'] ? 'true' : 'false' }},
		transliteration: {{ var_config['enable_transliteration'] ? 'true' : 'false' }},
		convert_spaces: {{ var_config['convert_spaces'] ? 'true' : 'false' }},
		replace_with: '{{ var_config['replace_with'] }}',
		relative_url: {{ var_config['relative_url'] ? 'true' : 'false' }},
		copy_cut_files_allowed: {{ var_config['enable_copy_cut_files'] ? 'true' : 'false' }},
		copy_cut_folders_allowed: {{ var_config['enable_copy_cut_folders'] ? 'true' : 'false' }},
		copy_cut_max_size: {{ var_config['copy_cut_max_size'] }},
		copy_cut_max_count: {{ var_config['copy_cut_max_count'] }},
		chmod_files_allowed: {{ var_config['enable_chmod_files'] ? 'true' : 'false' }},
		chmod_folders_allowed: {{ var_config['enable_chmod_folders'] ? 'true' : 'false' }},
		edit_text_files_allowed: {{ var_config['enable_edit_text_files'] ? 'true' : 'false' }},
		max_size_upload: '{{ var_config['max_size_upload'] }}',
		file_number_limit_js: {{ var_config['file_number_limit_js'] }},
		lazy_loading_file_number_threshold: {{ var_config['lazy_loading_file_number_threshold'] }},
		files_cnt: {{ var_config['files_cnt'] }},
		current_folder: '{{ var_config['current_folder'] }}',
		current_directory: '{{ var_config['current_directory'] }}',
		current_cache_directory: '{{ var_config['current_cache_path'] }}',
		aviary: {
			enable: {{ var_config['enable_aviary'] ? 'true' : 'false' }},
			api: {
				key: '{{ var_config['aviary_defaults_config']['key'] }}',
				version: '{{ var_config['aviary_defaults_config']['version'] }}',
			},
			theme: '{{ var_config['aviary_defaults_config']['theme'] }}',
			tools: '{{ var_config['aviary_defaults_config']['tools'] }}',
			language: '{{ var_config['aviary_defaults_config']['language'] }}',
		},
		urls: {
			current: '{{ var_config['current_url'] }}',
			view: '{{ var_config['url_view'] }}',
			type: '{{ var_config['url_type'] }}',
			filter: '{{ var_config['url_filter'] }}',
			sort: '{{ var_config['url_sort'] }}',
			extract: '{{ var_config['url_extract'] }}',
			chmod: '{{ var_config['url_chmod'] }}',
			change_mode: '{{ var_config['url_change_mode'] }}',
			edit_text: '{{ var_config['url_edit_text'] }}',
			save_text: '{{ var_config['url_save_text'] }}',
			save_image: '{{ var_config['url_save_image'] }}',
			save_mode: '{{ var_config['url_save_mode'] }}',
			preview_text: '{{ var_config['url_preview_text'] }}',
			preview_media: '{{ var_config['url_preview_media'] }}',
			download: '{{ var_config['url_download'] }}',
			upload: '{{ var_config['url_upload'] }}',
			create_file: '{{ var_config['url_create_file'] }}',
			rename_file: '{{ var_config['url_rename_file'] }}',
			duplicate_file: '{{ var_config['url_duplicate_file'] }}',
			delete_file: '{{ var_config['url_delete_file'] }}',
			create_folder: '{{ var_config['url_create_folder'] }}',
			rename_folder: '{{ var_config['url_rename_folder'] }}',
			delete_folder: '{{ var_config['url_delete_folder'] }}',
			clipboard_copy: '{{ var_config['url_clipboard_copy'] }}',
			clipboard_cut: '{{ var_config['url_clipboard_cut'] }}',
			clipboard_paste: '{{ var_config['url_clipboard_paste'] }}',
			clipboard_clear: '{{ var_config['url_clipboard_clear'] }}',
		},
		languages: {
			ok: '{{ _._( 'text_ok' ) | slashes }}',
			copy: '{{ _._( 'text_copy' ) | slashes }}',
			cut: '{{ _._( 'text_cut' ) | slashes }}',
			cancel: '{{ _._( 'text_cancel' ) | slashes }}',
			rename: '{{ _._( 'text_rename' ) | slashes }}',
			paste: '{{ _._( 'text_paste' ) | slashes }}',
			paste_here: '{{ _._( 'text_paste_here' ) | slashes }}',
			paste_confirm: '{{ _._( 'text_paste_confirm' ) | slashes }}',
			duplicate: '{{ _._( 'text_duplicate' ) | slashes }}',
			change: '{{ _._( 'text_change' ) | slashes }}',
			select: '{{ _._( 'text_select' ) | slashes }}',
			extract: '{{ _._( 'text_extract' ) | slashes }}',
			filename: '{{ _._( 'text_filename' ) | slashes }}',
			file_info: '{{ _._( 'text_file_info' ) | slashes }}',
			edit_file: '{{ _._( 'text_edit_file' ) | slashes }}',
			edit_image: '{{ _._( 'text_edit_image' ) | slashes }}',
			new_file: '{{ _._( 'text_new_file' ) | slashes }}',
			new_folder: '{{ _._( 'text_new_folder' ) | slashes }}',
			show_url: '{{ _._( 'text_show_url' ) | slashes }}',
			insert_folder_name: '{{ _._( 'text_insert_folder_name' ) | slashes }}',
			files_on_clipboard: '{{ _._( 'text_files_on_clipboard' ) | slashes }}',
			clipboard_clear_confirm: '{{ _._( 'text_clipboard_clear_confirm' ) | slashes }}',
			file_permission: '{{ _._( 'text_file_permission' ) | slashes }}',
			error_extension: '{{ _._( 'text_error_extension' ) | slashes }}',
			error_upload: '{{ _._( 'text_error_upload' ) }}',
		},
		extensions: {
			all: new Array( '{{  var_config['extensions'] | join( "','" )}}' ),
			images: new Array( '{{ var_config['extensions_image'] | join( "','" )}}' ),
			audio: new Array( '{{ var_config['extensions_audio'] | join( "','" )}}' ),
			video: new Array( '{{ var_config['extensions_video'] | join( "','" )}}' ),
			misc: new Array( '{{ var_config['extensions_misc'] | join( "','" )}}' ),
		}
	};
</script>
{{ assets.outputJS( 'file-manager-js' ) }}

<div class = "container-fluid">
	<!-- UPLOAD START -->
	<div class = "uploader">
	    <div class = "text-center">
	    	<button class = "btn btn-inverse close-uploader"><i class = "icon-backward icon-white"></i> {{ _._( 'text_return_files_list' ) }}</button>
	    </div>

	    <div class = "space10"></div>
	    <div class = "space10"></div>

	    <div class = "tabbable upload-tabbable">
			{% if var_config['enable_java_upload'] %}
			<ul class = "nav nav-tabs">
				<li class = "active"><a href = "#tab1" data-toggle = "tab">{{ _._( 'text_upload_base' ) }}</a></li>
				<li><a href = "#tab2" id = "uploader-btn" data-toggle = "tab">{{ _._( 'text_upload_java' ) }}</a></li>
		    </ul>
		    <div class="tab-content">
				<div class="tab-pane active" id="tab1">
			{% endIf %}
					<form action = "{{ url.get({ 'for' : 'file-manager' }) }}" method = "post" enctype = "multipart/form-data" id = "rfmDropzone" class = "dropzone">
				    	<input type = "hidden" name = "source_current_dir" value = "{{ var_config['source_current_dir'] }}"/>
				    	<input type = "hidden" name = "source_current_cache_dir" value = "{{ var_config['source_current_cache_dir'] }}"/>
					    <div class = "fallback">
							<h3>{{ _._( 'text_upload_file' ) }}:</h3><br/>
							<input name = "file" type = "file" />
							<input type = "hidden" name = "fldr" value = "{{ var_config['current_folder'] }}"/>
							<input type = "hidden" name = "view" value = "{{ var_config['view'] }}"/>
							<input type = "hidden" name = "type" value = "{{ var_config['type'] }}"/>
							<input type = "hidden" name = "field_id" value = "{{ var_config['field_id'] }}"/>
			      			<input type = "hidden" name = "relative_url" value = "{{ var_config['return_relative_url'] }}"/>
							<input type = "hidden" name = "popup" value = "{{ var_config['popup'] }}"/>
							<input type = "hidden" name = "filter" value = "{{ var_config['filter'] }}"/>
							<input type = "submit" name = "submit" value = "{{ _._( 'text_ok' ) }}" />
						</div>
					</form>
					<div class="upload-help">{{ _._( 'text_upload_base_help' ) }}</div>
				{% if var_config['enable_java_upload'] %}
				</div>
				<div class = "tab-pane" id = "tab2">
			    	<div id = "iframe-container"></div>
			    	<div class = "upload-help">{{ _._( 'text_upload_java_help' ) }}</div>
				{% endIf %}
				</div>
			</div>
		</div>
	</div>
	<!-- UPLAOD END -->

	<!-- HEADER -->
	<div class = "navbar">
	    <div class = "navbar-inner">
	        <div class = "container-fluid">
		   		<button type = "button" class = "btn btn-navbar" data-toggle = "collapse" data-target = ".nav-collapse">
					<span class = "icon-bar"></span>
					<span class = "icon-bar"></span>
					<span class = "icon-bar"></span>
			    </button>
			    <div class = "brand">{{ _._( 'text_toolbar' ) }}</div>
			    <div class = "nav-collapse collapse">
					<div class = "filters">
					    <div class = "row-fluid">
							<div class = "span4 half">
							    {% if var_config['enable_upload_files'] %}
									<button class = "tip btn upload-btn" title = "{{ _._( 'text_upload_file' ) }}"><i class = "rficon-upload"></i></button>
							    {% endIf %}
							    {% if var_config['enable_create_text_files'] %}
									<button class = "tip btn create-file-btn" title = "{{ _._( 'text_new_file' ) }}"><i class = "icon-plus"></i><i class = "icon-file"></i></button>
							    {% endIf %}
							     {% if var_config['enable_create_folders'] %}
									<button class = "tip btn create-folder-btn" title = "{{ _._( 'text_new_folder' ) }}"><i class = "icon-plus"></i><i class = "icon-folder-open"></i></button>
							    {% endIf %}
							     {% if var_config['enable_copy_cut_files'] OR var_config['enable_copy_cut_folders'] %}
								    <button class = "tip btn clipboard-paste-btn" title = "{{ _._( 'text_paste_here' ) }}"><i class="rficon-clipboard-apply"></i></button>
								    <button class = "tip btn clipboard-clear-btn" title = "{{ _._( 'text_clipboard_clear' ) }}"><i class="rficon-clipboard-clear"></i></button>
								{% endIf %}
							</div>
							<div class="span2 half view-controller">
							    <button class = "btn tip {{ var_config['view'] == 0 ? 'btn-inverse' : '' }}" id = "view0" data-value = "0" title = "{{ _._( 'text_view_boxes' ) }}">
							    	<i class = "icon-th {{ var_config['view'] == 0 ? 'icon-white' : '' }}"></i>
							    </button>
							    <button class = "btn tip {{ var_config['view'] == 1 ? 'btn-inverse' : '' }}" id = "view1" data-value = "1" title = "{{ _._( 'text_view_list' ) }}">
							    	<i class = "icon-align-justify {{ var_config['view'] == 1 ? 'icon-white' : '' }}"></i>
							    </button>
							    <button class = "btn tip {{ var_config['view'] == 2 ? 'btn-inverse' : '' }}" id = "view2" data-value = "2" title = "{{ _._( 'text_view_columns_list' ) }}">
							    	<i class = "icon-fire {{ var_config['view'] == 2 ? 'icon-white' : '' }}"></i>
							    </button>
							</div>
							<div class = "span6 entire types">
								<span>{{ _._( 'text_filters' ) }}:</span>
								{% if var_config['type'] != 2 AND var_config['type'] != 3 %}
								    <input id = "select-type-1" name = "radio-sort" type = "radio" data-item = "ff-item-type-1" checked = "checked"  class = "hide"  />
								    <label id = "ff-item-type-1" title = "{{ _._( 'text_files' ) }}" for = "select-type-1" class = "tip btn ff-label-type-1"><i class = "icon-file"></i></label>
								    <input id = "select-type-2" name = "radio-sort" type = "radio" data-item = "ff-item-type-2" class = "hide"  />
								    <label id = "ff-item-type-2" title = "{{ _._( 'text_images' ) }}" for = "select-type-2" class = "tip btn ff-label-type-2"><i class = "icon-picture"></i></label>
								    <input id = "select-type-3" name = "radio-sort" type = "radio" data-item = "ff-item-type-3" class = "hide"  />
								    <label id = "ff-item-type-3" title = "{{ _._( 'text_archives' ) }}" for = "select-type-3" class = "tip btn ff-label-type-3"><i class = "icon-inbox"></i></label>
								    <input id = "select-type-4" name = "radio-sort" type = "radio" data-item = "ff-item-type-4" class = "hide"  />
								    <label id = "ff-item-type-4" title = "{{ _._( 'text_videos' ) }}" for = "select-type-4" class = "tip btn ff-label-type-4"><i class = "icon-film"></i></label>
								    <input id = "select-type-5" name = "radio-sort" type = "radio" data-item = "ff-item-type-5" class = "hide"  />
								    <label id = "ff-item-type-5" title = "{{ _._( 'text_music' ) }}" for = "select-type-5" class = "tip btn ff-label-type-5"><i class = "icon-music"></i></label>
							    {% endIf %}
							    <input accesskey = "f" type = "text" class = "filter-input {{ ( var_config['type'] != 2 AND var_config['type'] != 3 ) ? '' : 'filter-input-notype' }}" id = "filter-input" name = "filter" placeholder = "{{ _._( 'text_text_filter' ) }}..." value = "{{ var_config['filter'] }}"/>
							   	{% if var_config['files_cnt'] > var_config['file_number_limit_js'] %}
							    	<label id = "filter" class = "btn"><i class = "icon-play"></i></label>
							    {% endIf %}

								{% if var_config['type'] != 2 AND var_config['type'] != 3 %}
								    <input id = "select-type-all" name = "radio-sort" type = "radio" data-item = "ff-item-type-all" class = "hide"  />
								    <label id = "ff-item-type-all" title = "{{ _._( 'text_all' ) }}" data-item = "ff-item-type-all" for = "select-type-all" style = "margin-rigth: 0px;" class = "tip btn btn-inverse ff-label-type-all"><i class = "icon-remove icon-white"></i></label>
								{% endIf %}
							</div>
					    </div>
					</div>
		   		</div>
			</div>
	    </div>
	</div>
	<!-- HEADER END -->

	<!-- BREADCRUMB -->
	<div class = "row-fluid">
		<ul class = "breadcrumb">
			<li class = "pull-left"><a href = "{{ var_config['url'] }}"><i class = "icon-home"></i></a></li>
			<li><span class = "divider">/</span></li>
			{% for key, breadcrumb in var_config['breadcrumbs'] %}
				{% if key === 'active' %}
					<li class = "active">{{ breadcrumb['name'] }}</li>
				{% else %}
					<li><a href = "{{ breadcrumb['url'] }}">{{ breadcrumb['name'] }}</a></li>
					<li><span class = "divider">/</span></li>
				{% endIf %}
			{% endFor %}
			<li class = "pull-right"><a class = "btn-small" href = "javascript:void(0);" id = "info"><i class = "icon-question-sign"></i></a></li>
			<li class = "pull-right"><a id = "refresh" class = "btn-small" href = "{{ var_config['url'] }}?{{ var_config['url_params'] ~ var_config['current_folder'] }}"><i class = "icon-refresh"></i></a></li>

			<li class = "pull-right">
			    <div class = "btn-group">
					<a href = "#" class = "btn dropdown-toggle sorting-btn" data-toggle = "dropdown">
					  	<i class = "icon-signal"></i><span class = "caret"></span>
					</a>
					<ul class = "dropdown-menu pull-left sorting">
				    	<li class = "text-center"><strong>{{ _._( 'text_sorting' ) }}</strong></li>
						<li><a href = "javascript:void(0);" class = "sorter sort-name {{ var_config['sort_by'] == 'name' ? ( var_config['sort_order'] ? 'descending' : 'ascending' ) : '' }}" data-sort = "name">{{ _._( 'text_filename' ) }}</a></li>
						<li><a href = "javascript:void(0);" class = "sorter sort-date {{ var_config['sort_by'] == 'date' ? ( var_config['sort_order'] ? 'descending' : 'ascending' ) : '' }}" data-sort = "date">{{ _._( 'text_date' ) }}</a></li>
						<li><a href = "javascript:void(0);" class = "sorter sort-size {{ var_config['sort_by'] == 'size' ? ( var_config['sort_order'] ? 'descending' : 'ascending' ) : '' }}" data-sort = "size">{{ _._( 'text_size' ) }}</a></li>
						<li><a href = "javascript:void(0);" class = "sorter sort-extension {{ var_config['sort_by'] == 'extension' ? ( var_config['sort_order'] ? 'descending' : 'ascending' ) : '' }}" data-sort = "extension">{{ _._( 'text_type' ) }}</a></li>
					</ul>
			    </div>
			</li>
		</ul>
	</div>
	<!-- BREADCRUMB END -->

	<!-- BODY -->
	<div class = "row-fluid ff-container">
		<div class = "span12">
			{% if var_config['source_current_dir_exists'] === false %}
	    		<div class = "alert alert-error">There is an error! The upload folder there isn't. Check your config.php file.</div>
			{% else %}
				<h4 id = "help">{{ _._( 'text_swipe_help' ) }}</h4>

				<?php if ( isset( $folder_message ) ) { ?>
					<div class = "alert alert-block"><?php echo $folder_message; ?></div>
				<?php } ?>

				{% if var_config['show_sorting_bar'] %}
					<div class = "sorter-container {{ 'list-view' ~ var_config['view'] }}">
						<div class = "file-name"><a class = "sorter sort-name {{ ( var_config['sort_by'] == 'name' ? ( var_config['sort_order'] ? 'descending' : 'ascending' ) : '' ) }}" href = "javascript:void('')" data-sort = "name">{{ _._( 'text_filename' ) }}</a></div>
						<div class = "file-date"><a class = "sorter sort-date {{ ( var_config['sort_by'] == 'date' ? ( var_config['sort_order'] ? 'descending' : 'ascending' ) : '' ) }}" href = "javascript:void('')" data-sort = "date">{{ _._( 'text_date' ) }}</a></div>
						<div class = "file-size"><a class = "sorter sort-size {{ ( var_config['sort_by'] == 'size' ? ( var_config['sort_order'] ? 'descending' : 'ascending' ) : '' ) }}" href = "javascript:void('')" data-sort = "size">{{ _._( 'text_size' ) }}</a></div>
						<div class = "img-dimension">{{ _._( 'text_dimension' ) }}</div>
						<div class = "file-extension"><a class="sorter sort-extension {{ ( var_config['sort_by'] == 'extension' ? ( var_config['sort_order'] ? 'descending' : 'ascending' ) : '' ) }}" href="javascript:void('')" data-sort = "extension">{{ _._( 'text_type' ) }}</a></div>
						<div class = "file-operations">{{ _._( 'text_operations' ) }}</div>
				    </div>
			    {% endIf %}

			    <ul class = "grid cs-style-2 {{ 'list-view' ~ var_config['view'] }}" id = "main-item-container">
					{% for folder in var_config['folders_list'] %}
						<li class = "{{ ( folder['file'] == '..' ) ? 'back' : 'dir' }}" style = "<?php echo ( $var_config['filter'] != '' && stripos( $folder['file'], $var_config['filter'] ) === false ) ? 'display: none;' : ''; ?>">
							<figure data-file = "{{ folder['file'] }}" data-file-url = "{{ folder['source_url'] }}" data-source-path = "{{ folder['current_path'] }}" data-source-cache-path = "{{ folder['current_cache_path'] }}" class = "{{ ( folder['file'] == '..' ) ? 'back-directory' : 'directory' }}" data-type = "{{ ( folder['file'] != '..' ) ? 'dir' : '' }}">
								{% if folder['file'] == '..' %}
								<input type = "hidden" class = "data-source-path" value = "{{ folder['current_path'] }}"/>
			    				<input type = "hidden" class = "data-source-cache-path" value = "{{ folder['current_cache_path'] }}"/>
								{% endIf %}

								<a href = "{{ var_config['url_params_build'] }}<?php echo rawurlencode( $folder['directory'] ); ?>" class = "folder-link">
									<div class = "img-precontainer">
										<div class = "img-container directory"><span></span>
											<img class = "directory-img"  src = "{{ folder['image_url'] }}" />
										</div>
									</div>
									<div class = "img-precontainer-mini directory">
										<div class = "img-container-mini">
										    <span></span>
										    <img class = "directory-img"  src="{{ folder['image_url'] }}" />
										</div>
								    </div>

								    {% if folder['file'] == '..' %}
										<div class = "box no-effect">
											<h4>{{ _._( 'text_back' ) }}</h4>
										</div>
				   					</a>
									{% else %}
									</a>

								    <div class = "box">
										<h4 class = "{{ var_config['ellipsis_title_after_first_row'] ? 'ellipsis' : '' }}">
											<a href = "{{ var_config['url_params_build'] }}<?php echo rawurlencode( $folder['directory'] ); ?>" class = "folder-link">{{ folder['file'] }}</a>
										</h4>
								    </div>

								    <input type = "hidden" class = "name" value = "{{ folder['file_lcase'] }}"/>
								    <input type = "hidden" class = "date" value = "{{ folder['date'] }}"/>
								    <input type = "hidden" class = "size" value = "{{ folder['size'] }}"/>
								    <input type = "hidden" class = "extension" value = "dir"/>

								    <div class = "file-date">{{ date( _._( 'text_date_type' ), folder['date'] ) }}</div>
								    {% if var_config['show_folder_size'] %}
								    	<div class = "file-size">{{ folder['size_str'] }}</div>
								    {% endIf %}
								    <div class = 'file-extension'>dir</div>
								    <figcaption>
									    <a href = "javascript:void(0)" class = "tip-left edit-button rename-file-paths {{ ( var_config['enable_rename_folders'] AND !folder['prevent_rename'] ) ? 'rename-folder-btn' : '' }}" title = "{{ _._( 'text_rename' ) }}">
									    	<i class = "icon-pencil {{ ( !var_config['enable_rename_folders'] OR folder['prevent_rename'] ) ? 'icon-white' : '' }}"></i>
									    </a>
									    <a href = "javascript:void(0)" class = "tip-left erase-button {{ ( var_config['enable_delete_folders'] AND !folder['prevent_delete'] ) ? 'delete-folder-btn' : '' }}" title = "{{ _._( 'text_erase' ) }}" data-confirm = "{{ _._( 'text_confirm_folder_del' ) }}">
									    	<i class = "icon-trash {{ ( !var_config['enable_delete_folders'] OR folder['prevent_delete'] ) ? 'icon-white' : '' }}"></i>
									    </a>
								    </figcaption>
								    {% endIf %}
								</a>
							</figure>
						</li>
					{% endFor %}

					{% for file_key, file in var_config['files_list'] %}
						<li class = "ff-item-type-{{ file['type'] }} file" style = "<?php echo ( $var_config['filter'] != '' && stripos( $folder['file'], $var_config['filter'] ) === false ) ? 'display: none;' : ''; ?>">
							<figure data-file = "{{ file['file'] }}" data-file-url = "{{ file['source_url'] }}" data-source-path = "{{ file['current_path'] }}" data-source-cache-path = "{{ file['current_cache_path'] }}" class = "{{ ( file['type'] == 2 ) ? 'img' : 'file' }}">
								<a href = "javascript:void(0);" class = "link" data-file = "{{ file['file'] }}" data-file-url = "{{ file['source_url'] }}" data-source-path = "{{ file['current_path'] }}" data-source-cache-path = "{{ file['current_cache_path'] }}" data-function = "{{ var_config['apply'] }}">
									<div class = "img-precontainer">
										{% if file['image_has_icon'] AND file['image_is_icon'] %}
											<div class = "filetype">{{ file['extension_lcase'] }}</div>
										{% endIf %}
										<div class = "img-container">
					   						<span></span>
					   						<img {{ var_config['lazy_loading_enabled'] ? 'data-original' : 'src' }} = "{{ file['image_url'] }}" alt = "" class = "{{ var_config['lazy_loading_enabled'] ? 'lazy-loaded' : '' }} {{ file['image_is_original'] ? 'original' : '' }} {{ file['image_is_icon'] ? 'icon' : '' }}" />
					   					</div>
									</div>
									<div class = "img-precontainer-mini {{ file['type'] == 2 ? 'original-thumb' : '' }}">
										<div class = "filetype {{ file['extension_lcase'] }} {{ !file['prevent_edit'] ? 'edit-text-file-allowed' : '' }} {{ !file['image_is_icon'] ? 'hide' : '' }}">{{ file['extension_lcase'] }}</div>
										<div class = "img-container-mini">
											<span></span>
											{% if file['image_is_thumb'] OR file['image_is_original'] %}
												<img {{ var_config['lazy_loading_enabled'] ? 'data-original' : 'src' }} = "{{ file['image_url'] }}" alt = "" class = "{{ var_config['lazy_loading_enabled'] ? 'lazy-loaded' : '' }} {{ file['image_is_original'] ? 'original' : '' }} {{ file['image_is_icon'] ? 'icon' : '' }}" />
											{% endIf %}
										</div>
									</div>
									{% if file['image_is_icon'] %}
									<div class = "cover"></div>
									{% endIf %}
								</a>

								<div class = "box">
									<h4 class = "{{ var_config['ellipsis_title_after_first_row'] ? 'ellipsis' : '' }}">
										<a href = "javascript:void(0);" class = "link" data-function = "{{ var_config['apply'] }}">{{ file['name'] }}</a>
									</h4>
							    </div>

							    <input type = "hidden" class = "name" value = "{{ file['file_lcase'] }}"/>
							    <input type = "hidden" class = "date" value = "{{ file['date'] }}"/>
							    <input type = "hidden" class = "size" value = "{{ file['size'] }}"/>
							    <input type = "hidden" class = "extension" value = "{{ file['extension_lcase'] }}"/>

							    <div class = "file-date">{{ date( _._( 'text_date_type' ), file['date'] ) }}</div>
								<div class = "file-size">{{ file['size_str'] }}</div>
								<div class = "img-dimension">{{ file['type'] == 2 ? file['width'] ~ 'x' ~ file['height'] : '' }}</div>
							    <div class = "file-extension">{{ file['extension_lcase'] }}</div>

							    <figcaption>
									<form action = "{{ var_config['url_download'] }}" method = "post" class = "download-form" id = "form{{ file_key }}">
										<input type = "hidden" name = "name" value = "{{ file['file'] }}" class = "name_download" />
										<input type = "hidden" name = "source_path" value = "{{ file['current_path'] }}" />
										<input type = "hidden" name = "source_cahe_path" value = "{{ file['current_cache_path'] }}" />

										<a href = "javascript:void(0);" title = "{{ _._( 'text_download' ) }}" class = "tip-right" onclick = "$('#form{{ file_key }}').submit();"><i class = "icon-download"></i></a>
										{% if file['type'] == 2 AND file['image_has_thumb'] AND file['extension_lcase'] != 'tiff' AND file['extension_lcase'] != 'tif' %}
											<a href = "#previewLightbox" title = "{{ _._( 'text_preview' ) }}" class = "tip-right preview-btn" data-toggle = "lightbox"><i class = "icon-eye-open"></i></a>
										{% elseif ( file['type'] == 4 OR file['type'] == 5 ) AND !file['prevent_play'] %}
											<a href = "javascript:void(0);" title = "{{ _._( 'text_preview' ) }}" class = "tip-right modalAV {{ file['type'] == 5 ? 'audio' : 'video' }}" data-file-url = "{{ var_config['url_preview_media'] }}?name={{ file['name'] }}&file={{ file['file'] }}&file_url={{ file['source_url'] }}&source_path={{ file['current_path'] }}"><i class = "icon-eye-open"></i></a>
										{% elseif var_config['enable_preview_text_files'] AND !file['prevent_preview'] %}
											<a href = "javascript:void(0);" title = "{{ _._( 'text_preview' ) }}" class = "tip-right file-preview-btn" data-file-url = "{{ var_config['url_preview_text'] }}?mode=text&name={{ file['name'] }}&file={{ file['file'] }}&file_url={{ file['source_url'] }}&source_path={{ file['current_path'] }}"><i class = "icon-eye-open"></i></a>
										{% elseif var_config['enable_googledoc'] AND !file['prevent_googledoc'] %}
											<a href = "docs.google.com;" title = "{{ _._( 'text_preview' ) }}" class = "tip-right file-preview-btn" data-file-url = "{{ var_config['url_preview_text'] }}?mode=google&name={{ file['name'] }}&file={{ file['file'] }}&file_url={{ file['source_url'] }}&source_path={{ file['current_path'] }}"><i class = "icon-eye-open"></i></a>
										{% elseif var_config['enable_viewerjs'] AND !file['prevent_viewerjs'] %}
											<a href = "docs.google.com;" title = "{{ _._( 'text_preview' ) }}" class = "tip-right file-preview-btn" data-file-url = "{{ var_config['url_preview_text'] }}?mode=viewerjs&name={{ file['name'] }}&file={{ file['file'] }}&file_url={{ file['source_url'] }}&source_path={{ file['current_path'] }}"><i class = "icon-eye-open"></i></a>
										{% else %}
											<a class = "preview-btn disabled"><i class = "icon-eye-open icon-white"></i></a>
										{% endIf %}

										<a href = "javascript:void(0);" title = "{{ _._( 'text_rename' ) }}" class = "tip-left edit-button rename-file-paths {{ var_config['enable_rename_files'] AND !file['prevent_rename'] ? 'rename-file-btn' : '' }}"><i class="icon-pencil {{ !var_config['enable_rename_files'] AND !file['prevent_rename'] ? 'icon-white' : '' }}"></i></a>
										<a href = "javascript:void(0);" title = "{{ _._( 'text_erase' ) }}" class = "tip-left erase-button {{ var_config['enable_delete_files'] AND !file['prevent_delete'] ? 'delete-file-btn' : '' }}" data-confirm = "{{ _._('text_confirm_del') }}"><i class = "icon-trash {{ !var_config['enable_delete_files'] AND !file['delete_rename'] ? 'icon-white' : '' }}"></i></a>
									</form>
							    </figcaption>
							</figure>
						</li>
					{% endFor %}
				</ul>
			{% endIf %}
		</div>
	</div>
	<!-- BODY END -->
</div>

<script type = "text/javascript">
	var files_duplicate = new Array( );

	{% for key, value in var_config['files_duplicate'] %}
		files_duplicate[{{ key }}] = '{{ value }}';
	{% endFor %}
</script>

<!-- LIGHTBOX DIV START -->
<div id = "previewLightbox" class = "lightbox hide fade"  tabindex = "-1" role = "dialog" aria-hidden = "true">
    <div class = 'lightbox-content'>
	    <img id = "full-img" src = "">
    </div>
</div>
<!-- LIGHTBOX DIV END -->

<!-- LOADING DIV START -->
<div id = "loading_container" style = "display:none;">
    <div id = "loading" style = "background-color:#000; position:fixed; width:100%; height:100%; top:0px; left:0px;z-index:100000"></div>
    <img id = "loading_animation" src = "/NIX/Application/Packages/Plugins/FileManager/Themes/Images/storing_animation.gif" alt = "loading" style = "z-index:10001; margin-left:-32px; margin-top:-32px; position:fixed; left:50%; top:50%"/>
</div>
<!-- LOADING DIV END -->

<!-- PLAYER DIV START -->
<div class = "modal hide fade" id = "preview-media">
  	<div class = "modal-header">
    	<button type = "button" class = "close" data-dismiss = "modal" aria-hidden = "true">&times;</button>
    	<h3>{{ _._( 'text_preview' ) }}</h3>
  	</div>
 	<div class = "modal-body">
  		<div class = "row-fluid preview-body"></div>
  	</div>
</div>
<!-- PLAYER DIV END -->

<img id = 'image_editor' src = '' class = "hide" />

{% if var_config['lazy_loading_enabled'] %}
    <script type = "text/javascript">
    	$( function ( ) {
    		$( ".lazy-loaded" ).lazyload({
			    event: 'scrollstop'
			});
    	});
    </script>
{% endIf %}
<!-- BODY END -->


