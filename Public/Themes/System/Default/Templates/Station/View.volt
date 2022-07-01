<div class = "ink-form column-group horizontal-gutters">
	<div class = "all-70 large-100 medium-100 small-100 tiny-100">
		<section class = "panel primary">
			<header class = "panel-header">
				<h6 class = "panel-title"><i class = "fa fa-file-text-o half-right-space"></i> {{ _._( 'text_title' ) }}</h6>
			</header>
	
			<section class = "panel-body clearfix">

				<h4 class = "title-bottom-line">{{ _._( 'text_station_title' ) }}</h4>
				<blockquote class = "fw-300 note">{{ _._( 'text_station_description' ) }}</blockquote>

				<div class = "control-group column-group validation">
					<label for = "" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_name' ) }}</b></label>
					<div class = "control medium-100 small-100 tiny-100 all-80">
						{{ name }}
					</div>
				</div>

				<div class = "control-group column-group validation">
					<label for = "" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_location' ) }}</b></label>
					<div class = "control medium-100 small-100 tiny-100 all-80">
						{{ location }}
					</div>
				</div>

				<div class = "control-group column-group validation">
					<label for = "" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_head_name' ) }}</b></label>
					<div class = "control medium-100 small-100 tiny-100 all-80">
						{{ head_name }}
					</div>
				</div>

				<div class = "control-group column-group validation">
					<label for = "" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_head_position' ) }}</b></label>
					<div class = "control medium-100 small-100 tiny-100 all-80">
						{{ head_position }}
					</div>
				</div>

				<div class = "control-group column-group validation">
					<label for = "equipments" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_equipment' ) }}</b></label>
					<div class = "control medium-100 small-100 tiny-100 all-80">
						{{ _._( 'placeholder_equipment' ) }}
						<ul class = "unstyled clearfix no-margin">
							{% for equipment in var_equipments %}
								<li class = "quarter-vertical-padding clearfix">
									<div class = "all-100 custom-checkbox">{{ check_field( 'equipment_id' ~ '[' ~ equipment.getId( ) ~ ']', 'value' : equipment.getId( ), 'disabled' : 'disabled' ) }} <label for = "{{ 'equipment_id' ~ '[' ~ equipment.getId( ) ~ ']' }}">{{ equipment.name }}</label></div>
									<div class = "all-100">{{ _._( 'field_equipment_serial_no' ) }} {{ text_field( 'equipment_serial_no' ~ '[' ~ equipment.getId( ) ~ ']', 'placeholder' : _._( 'placeholder_equipment_serial_no' ), 'class' : 'red-bold-underline', 'disabled' : 'disabled' ) }}</div>
									<div class = "all-100">{{ _._( 'field_ftp_location' ) }} {{ text_field( 'ftp_location' ~ '[' ~ equipment.getId( ) ~ ']', 'placeholder' : _._( 'placeholder_ftp_location' ), 'class' : 'red-bold-underline', 'disabled' : 'disabled' ) }}</div>
								</li>
							{% endFor %}
						</ul>
						<p class = "tip">{{ _._( 'tip_equipment' ) }}</p>
					</div>
				</div>

				<div class = "control-group column-group validation">
					<label for = "" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_sort_order' ) }}</b></label>
					<div class = "control medium-100 small-100 tiny-100 all-80">
						{{ sort_order }}
					</div>
				</div>

			</section>

			<section class = "panel-footer clearfix">
				<a href = "javascript:void(0);" class = "ink-button red danger push-right dialog-trigger"><i class = "fa fa-trash-o"></i></a>
				<a href = "{{ var_archive_url }}" class = "ink-button default push-right"><i class = "fa fa-suitcase"></i></a>
				<a href = "{{ var_edit_url }}" class = "ink-button default push-right"><i class = "fa fa-edit"></i></a>
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
				<div class = "control-group column-group validation">
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
				</div>
			</section>

			<section class = "panel-footer clearfix">
				<a href = "javascript:void(0);" class = "ink-button red danger push-right dialog-trigger"><i class = "fa fa-trash-o"></i></a>
				<a href = "{{ var_archive_url }}" class = "ink-button default push-right"><i class = "fa fa-suitcase"></i></a>
				<a href = "{{ var_edit_url }}" class = "ink-button default push-right"><i class = "fa fa-edit"></i></a>
			</section>
		</section>
	</div>
</div>

<div class = "ink-shade fade">
	<div id = "dialog" class = "ink-modal fade" data-trigger = ".dialog-trigger" data-width = "30%" data-height = "30%">
		<div class = "modal-header">
			<button class = "modal-close ink-dismiss"></button>
			<h2>{{ _._( 'delete_confirm_title' ) }}</h2>
		</div>
		<div class = "modal-body">
			{{ _._( 'delete_confirm_message' ) }}
		</div>
		<div class = "modal-footer">
			<div class = "push-right">
				<a href = "{{ var_delete_url }}" class = "ink-button red danger">{{ _._( 'btn_delete' ) }}</a>
				<a href = "javascript:void(0);" class = "ink-button default ink-dismiss">{{ _._( 'btn_cancel' ) }}</a>
			</div>
		</div>
	</div>
</div>