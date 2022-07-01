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

					<h4 class = "title-bottom-line">{{ _._( 'text_station_equipment_measurement_parameter_alert_title' ) }}</h4>
					<blockquote class = "fw-300 note">{{ _._( 'text_station_equipment_measurement_parameter_alert_description' ) }}</blockquote>

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
							{{ text_area( 'description', 'placeholder' : _._( 'placeholder_description' )  ) }}
							<p class = "tip">{{ _._( 'tip_description' ) }}</p>
						</div>
					</div>
					
					<div class = "control-group column-group validation">
						<label for = "" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_parameters' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							<ul class = "unstyled  column-group horizontal-gutters">
								<li class = "all-100">
									<div class = "push-right">
										<span class = "custom-checkbox">
											<input type = "checkbox" id = "toggle-check-all" class = "toggle-check" /> 
											<label for = "toggle-check-all">Check / Uncheck All</label>
										</span>
									</div>
								</li>
								{% for equipment in var_equipments %}
									<li class = "small-100 tiny-100 all-50 no-margin push-left">
										<div class = "column half-vertical-padding half-horizontal-padding rounded bordered-dash clearfix">
											<span class = "custom-checkbox">
												{{ check_field( 'equipment-' ~ equipment.getId( ), 'class' : 'toggle-check toggle-check-all' ) }}
												<label for = "equipment-{{ equipment.getId( ) }}"><strong>{{ equipment.name }}</strong></label>
											</span>
											<div class = "all-100 clearfix">
												<ul class = "unstyled half-left-space">
												{% for parameter in equipment.getEquipmentMeasurementParameter( ) %}
													<li class = "clearfix">
														<span class = "custom-checkbox">
															{{ check_field( 'parameter[' ~ parameter.getId( ) ~ ']', 'value' : parameter.getid( ), 'id' : 'parameter[' ~ parameter.getId( ) ~ ']', 'class' :  'equipment-' ~ equipment.getId( ) ~ ' toggle-check-all' ) }}
															<label for = "{{ 'parameter[' ~ parameter.getId( ) ~ ']' }}" class = "no-margin-left">{{ parameter.parameter }}</label>
														</span>
														<div class = "all-100 clearfix quarter-vertical-padding">
															<div class = "control-group column-group validation">
																<label for = "{{ 'min[' ~ parameter.getId( ) ~ ']' }}" class = "medium-100 small-100 tiny-100 all-20 align-left">{{ _._( 'field_min' ) }}</label>
																<div class = "control medium-100 small-100 tiny-100 all-80">
																	{{ text_field( 'min[' ~ parameter.getId( ) ~ ']', 'placeholder' : _._( 'placeholder_min' ), 'class' : 'all-70 align-center'  ) }}
																	<p class = "tip">{{ _._( 'tip_min' ) }}</p>
																</div>
															</div>

															<div class = "control-group column-group validation">
																<label for = "{{ 'max[' ~ parameter.getId( ) ~ ']' }}" class = "medium-100 small-100 tiny-100 all-20 align-left">{{ _._( 'field_max' ) }}</label>
																<div class = "control medium-100 small-100 tiny-100 all-80">
																	{{ text_field( 'max[' ~ parameter.getId( ) ~ ']', 'placeholder' : _._( 'placeholder_max' ), 'class' : 'all-70 align-center'  ) }}
																	<p class = "tip">{{ _._( 'tip_max' ) }}</p>
																</div>
															</div>

															<div class = "control-group column-group validation">
																<label for = "{{ 'comparison[' ~ parameter.getId( ) ~ ']' }}" class = "medium-100 small-100 tiny-100 all-40 align-left">{{ _._( 'field_comparison' ) }}</label>
																<div class = "control medium-100 small-100 tiny-100 all-60">
																	{{ select( 'comparison[' ~ parameter.getId( ) ~ ']', var_comparisons ) }}
																	<p class = "tip">{{ _._( 'tip_comparison' ) }}</p>
																</div>
															</div>
														</div>
													</li>
												{% endFor %}
												</ul>
											</div>
										</div>
									</li>
								{% endFor %}						
							</ul>
							<p class = "tip">{{ _._( 'tip_parameters' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "level_id" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_level_id' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ select( 'level_id', var_equipment_measurement_parameter_alert_levels, 'using' : ['station_equipment_measurement_parameter_alert_level_id', 'title'], 'useEmpty' : true, 'emptyText' : _._( 'placeholder_level_id' ) ) }}
							<p class = "tip">{{ _._( 'tip_level_id' ) }}</p>
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