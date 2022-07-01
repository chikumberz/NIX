<form action = "{{ url([ 'for' : 'admin-action', 'folder' : 'dashboard', 'controller' : 'dashboard', 'action' : 'summary' ]) }}" class = "ink-form">

	<div class = "column-group gutters push-center">
		<div class = "control-group all-20">
			<label for = "station_id" class = "">{{ _._( 'filter_station' ) }}</label>
			<div class = "control">
				{{ select( 'station_id', var_station, 'using' : ['station_id', 'name'] ) }}
			</div>
		</div>

		<div class = "control-group all-20">
			<label for = "date_from" class = "">{{ _._( 'filter_date_from' ) }}</label>
			<div class = "control">
				{{ text_field( 'date_from', 'class' : 'ink-datepicker' ) }}
			</div>
		</div>

		<div class = "control-group all-20">
			<label for = "date_to" class = "">{{ _._( 'filter_date_to' ) }}</label>
			<div class = "control">
				{{ text_field( 'date_to', 'class' : 'ink-datepicker' ) }}
			</div>
		</div>

		<div class = "control-group all-20">
			<label for = "apply" class = "">{{ _._( 'filter_action' ) }}</label>
			<div class = "control">
				<a class = "ink-button green success no-margin" id = "apply">{{ _._( 'filter_action_apply' ) }}</a>
			</div>
		</div>
	</div>
	
	<hr />

	<section class = "all-100">
		<section class = "ink-tabs left">
			<ul class = "tabs-nav" id = "fetch-summary">
				{% for parameter_group in var_station_equipment_measurement_parameter_group %}
					<li>
						<a href = "#main_tab" class = "tabs-tab static-radio-in-tab">
							{{ parameter_group.title }}
							{{ radio_field( 'station_equipment_measurement_parameter_group_id', 'value' : parameter_group.getId( ), 'id' : 'parameter_group-' ~ parameter_group.getId( ) ) }}
						</a>
					</li>
				{% endFor %}
			</ul>
			<section id = "main_tab" class = "tabs-content">
				
			</section>
		</section>
	</section>
</form>

<script type = "text/javascript">
	jQuery( "document" ).ready( function ( $ ) {
		$( "#fetch-summary li a" ).on( 'click', function ( ) {
			var self 		= $( this );
				form 		= self.closest( 'form' );

			self.children( 'input[type=radio]' ).prop( 'checked', true );

			$.ajax({
				"url" 		: form.attr( "action" ),
				"data" 		: form.serialize( ),
				"dataType" 	: "html",
				"type"		: "GET"
			}).done( function ( html ) {
				$( "#main_tab" ).html( html );
				Ink.requireModules( ["Ink.Dom.Selector_1", "Ink.UI.Tabs_1"], function ( Selector, Tabs ) {
					var tabs_object = new Tabs( '#summary' );
				});
			});
		});

		$( "#fetch-summary li a" ).first( ).trigger( 'click' );
		$( "#apply" ).on( "click", function ( ) {
			$( "#fetch-summary li.active a" ).trigger( 'click' );
			return false;
		});

		setInterval( function ( ) {
			$( "#apply" ).trigger( 'click' );
		}, 120000 );
	});
</script>