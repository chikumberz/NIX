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

					<h4 class = "title-bottom-line">{{ _._( 'text_station_title' ) }}</h4>
					<blockquote class = "fw-300 note">{{ _._( 'text_station_description' ) }}</blockquote>

					<div class = "control-group column-group validation">
						<label for = "name" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_name' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'name', 'placeholder' : _._( 'placeholder_name' )  ) }}
							<p class = "tip">{{ _._( 'tip_name' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "location" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_location' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'location', 'placeholder' : _._( 'placeholder_location' )  ) }}
							<p class = "tip">{{ _._( 'tip_location' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "head_name" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_head_name' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'head_name', 'placeholder' : _._( 'placeholder_head_name' )  ) }}
							<p class = "tip">{{ _._( 'tip_head_name' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "head_position" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_head_position' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'head_position', 'placeholder' : _._( 'placeholder_head_position' )  ) }}
							<p class = "tip">{{ _._( 'tip_head_position' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "equipments" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_equipment' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ _._( 'placeholder_equipment' ) }}
							<ul class = "unstyled clearfix no-margin">
								{% for equipment in var_equipments %}
									<li class = "quarter-vertical-padding clearfix">
										<div class = "all-100 custom-checkbox">{{ check_field( 'equipment_id' ~ '[' ~ equipment.getId( ) ~ ']', 'value' : equipment.getId( ), 'id' : 'equipment_id' ~ '[' ~ equipment.getId( ) ~ ']' ) }} <label for = "{{ 'equipment_id' ~ '[' ~ equipment.getId( ) ~ ']' }}">{{ equipment.name }}</label></div>
										<div class = "all-100">
											{{ text_field( 'equipment_serial_no' ~ '[' ~ equipment.getId( ) ~ ']', 'placeholder' : _._( 'placeholder_equipment_serial_no' ), 'class' : 'all-100' ) }}
											<p class = "tip">{{ _._( 'tip_equipment_serial_no' ) }}</p>

											{{ text_field( 'ftp_location' ~ '[' ~ equipment.getId( ) ~ ']', 'placeholder' : _._( 'placeholder_ftp_location' ), 'class' : 'all-100' ) }}
											<p class = "tip">{{ _._( 'tip_ftp_location' ) }}</p>
										</div>
									</li>
								{% endFor %}
							</ul>
							<p class = "tip">{{ _._( 'tip_equipment' ) }}</p>
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