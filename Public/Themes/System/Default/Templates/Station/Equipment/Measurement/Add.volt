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

					<h4 class = "title-bottom-line">{{ _._( 'text_station_equipment_measurement_title' ) }}</h4>
					<blockquote class = "fw-300 note">{{ _._( 'text_station_equipment_measurement_description' ) }}</blockquote>

					<div class = "control-group column-group validation">
						<label for = "station_id" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_station_id' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ select( 'station_id', var_stations, 'using' : ['station_id', 'name'], 'useEmpty' : true, 'emptyText' : _._( 'placeholder_station_id' ), 'class' : 'fetch-content-equipment' ) }}
							<p class = "tip">{{ _._( 'tip_station_id' ) }}</p>
						</div>
					</div>


					<div class = "control-group column-group validation">
						<label for = "station_equipment_id" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_station_equipment_id' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ select( 'station_equipment_id', [], 'useEmpty' : true, 'emptyText' : _._( 'placeholder_station_equipment_id' ), 'class' : 'fetch-content-parameter', 'id' : 'display-content-equipment' ) }}
							<p class = "tip">{{ _._( 'tip_station_equipment_id' ) }}</p>
						</div>
					</div>

					<section class = "panel default">
						<header class = "panel-header">
							<h6 class = "panel-title"><i class = "fa fa-bars half-right-space"></i> {{ _._( 'field_value' ) }}</h6>
						</header>

						<section class = "panel-body clearfix" id = "display-fetch-parameter">
							
						</section>
					</section>

					<div class = "control-group column-group validation">
						<label for = "file" class = "medium-100 small-100 tiny-100 all-20 align-left">{{ _._( 'field_file' ) }}</label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'file', 'placeholder' : _._( 'placeholder_file' )  ) }}
							<p class = "tip">{{ _._( 'tip_file' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "sort_order" class = "medium-100 small-100 tiny-100 all-20 align-left">{{ _._( 'field_sort_order' ) }}</label>
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

<script type = "text/javascript">
	jQuery( "document" ).ready( function ( $ ) {
		$( ".fetch-content-equipment" ).on( "change", function ( ) {
			var container_equipment = $( "#display-content-equipment" );
			var container_parameter = $( "#display-fetch-parameter" );

			container_parameter.html( "" );

			$.ajax({
				"url" 		: "{{ url.get(['for' : 'admin-action', 'folder' : 'station', 'controller' : 'equipment-measurement', 'action' : 'fetchequipment'] ) }}",
				"data"		: { 'id' : $( this ).val( ) },
				"dataType"	: "json",
				"type"		: "GET"
			}).done( function ( json ) {
				container_equipment.html( '' );
				json[0] = "{{ _._( 'placeholder_station_equipment_id' ) }}";
				$.each( json, function ( i, item ) {
					container_equipment.append( $( '<option />', {
						value 	: i, 
						text 	: item
					}));
				});
			});
		});

		$( ".fetch-content-parameter" ).on( "change", function ( ) {
			var container = $( "#display-fetch-parameter" );
			$.ajax({
				"url" 		: "{{ url.get(['for' : 'admin-action', 'folder' : 'station', 'controller' : 'equipment-measurement', 'action' : 'fetchparameter'] ) }}",
				"data"		: { 'id' : $( this ).val( ) },
				"dataType"	: "html",
				"type"		: "GET"
			}).done( function ( html ) {
				container.html( html );
			});
		});
	});
</script>
