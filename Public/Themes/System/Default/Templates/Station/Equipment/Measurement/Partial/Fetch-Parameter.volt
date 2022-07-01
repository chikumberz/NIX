{% for parameter in var_station_equipment_measurement_parameters %}
<div class = "control-group column-group validation">
	<label for = "" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ parameter.parameter }}</b></label>
	<div class = "control medium-100  small-100 tiny-100 all-80">
		{{ text_field( 'value' ~ '[' ~ parameter.getId( ) ~ ']' ) }}
	</div>
</div>
{% endFor %}