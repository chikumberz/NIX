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

					<h4 class = "title-bottom-line">{{ _._( 'text_station_equipment_measurement_unit_title' ) }}</h4>
					<blockquote class = "fw-300 note">{{ _._( 'text_station_equipment_measurement_unit_description' ) }}</blockquote>

					<div class = "control-group column-group validation">
						<label for = "unit" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_unit' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'unit', 'placeholder' : _._( 'placeholder_unit' )  ) }}
							<p class = "tip">{{ _._( 'tip_unit' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "value" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_value' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'value', 'placeholder' : _._( 'placeholder_value' )  ) }}
							<p class = "tip">{{ _._( 'tip_value' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "symbol_left" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_symbol_left' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'symbol_left', 'placeholder' : _._( 'placeholder_symbol_left' )  ) }}
							<p class = "tip">{{ _._( 'tip_symbol_left' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "symbol_right" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_symbol_right' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'symbol_right', 'placeholder' : _._( 'placeholder_symbol_right' ) ) }}
							<p class = "tip">{{ _._( 'tip_symbol_right' ) }}</p>
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