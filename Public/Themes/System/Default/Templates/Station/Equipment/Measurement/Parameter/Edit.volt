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

					<h4 class = "title-bottom-line">{{ _._( 'text_station_equipment_measurement_parameter_title' ) }}</h4>
					<blockquote class = "fw-300 note">{{ _._( 'text_station_equipment_measurement_parameter_description' ) }}</blockquote>

					<div class = "control-group column-group validation">
						<label for = "parameter" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_parameter' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'parameter', 'placeholder' : _._( 'placeholder_parameter' )  ) }}
							<p class = "tip">{{ _._( 'tip_parameter' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "code" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_code' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'code', 'placeholder' : _._( 'placeholder_code' )  ) }}
							<p class = "tip">{{ _._( 'tip_code' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "min" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_min' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'min', 'placeholder' : _._( 'placeholder_min' )  ) }}
							<p class = "tip">{{ _._( 'tip_min' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "max" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_max' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'max', 'placeholder' : _._( 'placeholder_max' )  ) }}
							<p class = "tip">{{ _._( 'tip_max' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "default" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_default' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'default', 'placeholder' : _._( 'placeholder_default' )  ) }}
							<p class = "tip">{{ _._( 'tip_default' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "station_equipment_measurement_unit_id" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_station_equipment_measurement_unit' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ select( 'station_equipment_measurement_unit_id', var_station_equipment_measurement_units, 'using' : ['station_equipment_measurement_unit_id', 'unit'], 'useEmpty' : true, 'emptyText' : _._( 'placeholder_station_equipment_measurement_unit' ) ) }}
							<p class = "tip">{{ _._( 'tip_station_equipment_measurement_unit' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "station_equipment_id" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_station_equipment' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ select( 'station_equipment_id', var_station_equipments, 'using' : ['station_equipment_id', 'name'], 'useEmpty' : true, 'emptyText' : _._( 'placeholder_station_equipment' ) ) }}
							<p class = "tip">{{ _._( 'tip_station_equipment' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "user_group_id" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_user_group' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ _._( 'placeholder_user_group' ) }}
							<ul class = "unstyled">
								{% for user_group in var_user_groups %}
									<li><span class = "custom-checkbox">{{ check_field( 'user_group_id' ~ '[' ~ user_group.getId( ) ~ ']', 'value' : user_group.getId( ), 'id' : 'user_group_id' ~ '[' ~ user_group.getId( ) ~ ']' ) }} <label for = "{{ 'user_group_id' ~ '[' ~ user_group.getId( ) ~ ']' }}">{{ user_group.group }}</label></span></li>
								{% endFor %}
							</ul>
							<p class = "tip">{{ _._( 'tip_user_group' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "sort_order" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_sort_order' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'sort_order', 'placeholder' : _._( 'placeholder_sort_order' )  ) }}
							<p class = "tip">{{ _._( 'tip_sort_order' ) }}</p>
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
					<button type = "submit" class = "ink-button lightblue info push-right"><i class = "fa fa-save quarter-right-space"></i> {{ _._( 'btn_save' ) }}</button>
					<button type = "reset" class = "ink-button red danger push-right"><i class = "fa fa-eraser quarter-right-space"></i> {{ _._( 'btn_clear' ) }}</button>
				</section>
			</section>
		</div>
	</div>
</form>