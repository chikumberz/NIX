<h3>{{ var_station.name }}</h3>
<p>{{ var_station.location }}</p>

<section id = "summary" class = "ink-tabs top">
	<ul class = "tabs-nav">
		<li><a href = "#inside_tab_1" class = "tabs-tab">{{ _._( 'tab_tabular_data' ) }}</a></li>
		<li><a href = "#inside_tab_2" class = "tabs-tab">{{ _._( 'tab_graph' ) }}</a></li>
		<li><a href = "#inside_tab_3" class = "tabs-tab">{{ _._( 'tab_report' ) }}</a></li>
		<li><a href = "#inside_tab_4" class = "tabs-tab">{{ _._( 'tab_connection_status' ) }}</a></li>
		<li><a href = "#inside_tab_5" class = "tabs-tab">{{ _._( 'tab_alert' ) }}<span class = "ink-badge red">{{ var_latest_station_equipment_measurement_parameter_alerts | length }}</span></a></li>
	</ul>

	<section id = "inside_tab_1" class = "tabs-content">
		<h4>{{ _._( 'title_tabular_data' ) }}</h4>
		<p>{{ _._( 'description_tabular_data' ) }}</p>

		{% for equipment in var_station_equipment %}
			<section class = "panel default">
				<header class = "panel-header">
					<h6 class = "panel-title"><i class = "fa fa-bars half-right-space"></i> {{ equipment.name }}</h6>
				</header>	
				
				<section class = "panel-body clearfix">
					<div class = "overflow-horizontal">
						<table class = "ink-table">
							{% if var_station_equipment_measurement[equipment.getId( )] is defined %}
								<tr>
									<th class = "align-left" style = "white-space: nowrap;">DATE</th>
									{% for parameter_id, measurements in var_station_equipment_measurement[equipment.getId( )] %}
										<th style = "white-space: nowrap;">
											{% if var_station_equipment_measurement_parameter_group[parameter_id] is defined %}
												{{ var_station_equipment_measurement_parameter_group[parameter_id]['parameter'] }}
											{% endIf %}
										</th>
									{% endFor %}
								</tr>
							{% else %}
								<tr>
									<td class = "align-center">{{ _._( 'no_result_found' ) }}</td>
								</tr>
							{% endIf %}
						
							{% if var_station_equipment_measurement_tabular[equipment.getId( )] is defined %}
								
								{% set var_average = [] %}

								{% for created_on, measurements in var_station_equipment_measurement_tabular[equipment.getId( )] %}
									<tr>
										<td style = "white-space: nowrap;">{{ created_on }}</td>
										{% for parameter_id, measurement in measurements %}
											{% if var_station_equipment_measurement_parameter_group[parameter_id] is defined %}
											<td class = "align-center" style = "white-space: nowrap;">
												
												{% if  var_average[parameter_id] is defined %}
													<?php $var_average[$parameter_id]['value'] 	+= $measurement['value']; ?>
													<?php $var_average[$parameter_id]['cnt'] 	+= 1; ?>
												{% else %}
													<?php $var_average[$parameter_id]['value'] 	= $measurement['value']; ?>
													<?php $var_average[$parameter_id]['cnt'] 	= 1; ?>
												{% endIf %}

												{{ var_station_equipment_measurement_parameter_group[parameter_id]['unit']['symbol_left'] }} 
												{{ measurement['value'] }} 
												{{ var_station_equipment_measurement_parameter_group[parameter_id]['unit']['symbol_right'] }}
											
												{% if measurement['value'] > var_station_equipment_measurement_parameter_group[parameter_id]['default'] %}
													<span class = "fa fa-long-arrow-up red"></span>
												{% else %}
													<span class = "fa fa-long-arrow-down green"></span>
												{% endIf %}
											</td>
											{% endIf %}
										{% endFor %}
									</tr>
								{% endFor %}
								<tr class = "red">
									<td style = "white-space: nowrap;"><strong>{{ _._( 'text_average' ) }}</strong></td>
									{% for parameter_id, average in var_average %}
										<td class = "align-center">
											{{ var_station_equipment_measurement_parameter_group[parameter_id]['unit']['symbol_left'] }}
											<?php echo round( $average['value'] / $average['cnt'], 2 ); ?>
											{{ var_station_equipment_measurement_parameter_group[parameter_id]['unit']['symbol_right'] }}
										</td>
									{% endFor %}
								</tr>
							{% endIf %}
						</table>
					</div>
				</section>
				<section class = "panel-footer clearfix">
				</section>
			</section>
		{% endFor %}
	</section>
	<section id = "inside_tab_2" class = "tabs-content">
		<h4>{{ _._( 'title_graph' ) }}</h4>
		<p>{{ _._( 'description_graph' ) }}</p>
		<div id = "graph" class = "graph all-100 clearfix" style = "height: 500px;"></div>
		<div id = "small-graph" class = "graph all-100 column-group clearfix"></div>
	</section>
	<section id = "inside_tab_3" class = "tabs-content">
		<h4>{{ _._( 'title_report' ) }}</h4>
		<p>{{ _._( 'description_report' ) }}</p>

		<hr>
		
		<div id = "report-to-print">
			<h4>{{ _._( 'title_tabular_data_summary' ) }}</h4>
			<p>{{ _._( 'description_tabular_data_summary' ) }}</p>

			{% for equipment in var_station_equipment %}
				<section class = "panel default">
					<header class = "panel-header">
						<h6 class = "panel-title"><i class = "fa fa-bars half-right-space"></i> {{ equipment.name }}</h6>
					</header>	
					
					<section class = "panel-body clearfix">
						<div class = "">
							<table class = "ink-table all-100">
								{% if var_station_equipment_measurement[equipment.getId( )] is defined %}
									<tr>
										<th class = "align-left" style = "">DATE</th>
										{% for parameter_id, measurements in var_station_equipment_measurement[equipment.getId( )] %}
											<th style = "">
												{% if var_station_equipment_measurement_parameter_group[parameter_id] is defined %}
													{{ var_station_equipment_measurement_parameter_group[parameter_id]['parameter'] }}
												{% endIf %}
											</th>
										{% endFor %}
									</tr>
								{% else %}
									<tr>
										<td class = "align-center">{{ _._( 'no_result_found' ) }}</td>
									</tr>
								{% endIf %}
							
								{% if var_station_equipment_measurement_tabular[equipment.getId( )] is defined %}
									
									{% set var_average = [] %}

									{% for created_on, measurements in var_station_equipment_measurement_tabular[equipment.getId( )] %}
										<tr>
											<td style = "">{{ created_on }}</td>
											{% for parameter_id, measurement in measurements %}
												{% if var_station_equipment_measurement_parameter_group[parameter_id] is defined %}
												<td class = "align-center" style = "white-space: nowrap;">
													
													{% if  var_average[parameter_id] is defined %}
														<?php $var_average[$parameter_id]['value'] 	+= $measurement['value']; ?>
														<?php $var_average[$parameter_id]['cnt'] 	+= 1; ?>
													{% else %}
														<?php $var_average[$parameter_id]['value'] 	= $measurement['value']; ?>
														<?php $var_average[$parameter_id]['cnt'] 	= 1; ?>
													{% endIf %}

													{{ var_station_equipment_measurement_parameter_group[parameter_id]['unit']['symbol_left'] }} 
													{{ measurement['value'] }} 
													{{ var_station_equipment_measurement_parameter_group[parameter_id]['unit']['symbol_right'] }}
												
													{% if measurement['value'] > var_station_equipment_measurement_parameter_group[parameter_id]['default'] %}
														<span class = "fa fa-long-arrow-up red"></span>
													{% else %}
														<span class = "fa fa-long-arrow-down green"></span>
													{% endIf %}
												</td>
												{% endIf %}
											{% endFor %}
										</tr>
									{% endFor %}
									<tr class = "red">
										<td style = ""><strong>{{ _._( 'text_average' ) }}</strong></td>
										{% for parameter_id, average in var_average %}
											<td class = "align-center">
												{{ var_station_equipment_measurement_parameter_group[parameter_id]['unit']['symbol_left'] }}
												<?php echo round( $average['value'] / $average['cnt'], 2 ); ?>
												{{ var_station_equipment_measurement_parameter_group[parameter_id]['unit']['symbol_right'] }}
											</td>
										{% endFor %}
									</tr>
								{% endIf %}
							</table>
						</div>
					</section>
					<section class = "panel-footer clearfix">
					</section>
				</section>
			{% endFor %}
			
			<hr>

			<h4>{{ _._( 'title_graph_summary' ) }}</h4>
			<p>{{ _._( 'description_graph_summary' ) }}</p>
			<div id = "graph-report" class = "graph all-100 clearfix" style = "height: 500px;"></div>
			
			<hr>

			<h4>{{ _._( 'title_alert_summary' ) }}</h4>
			<p>{{ _._( 'description_alert_summary' ) }}</p>
			{% for alert in var_latest_station_equipment_measurement_parameter_alerts %}
				{% set alert_level = alert.getLevel( ) %}
				<section class = "ink-alert page-callout {{ alert_level.class }}">
					<h5>{{ alert.title }}</h5>
					<p>{{ alert.description }}</p>
				</section>
			{% endFor %}
		</div>
		<div class = "all-100 align-center">
			<a class = "ink-button lightblue" onclick = "$('#report-to-print').print( ); return false;">{{ _._( 'btn_print' ) }}</a>
		</div>
	</section>
	<section id = "inside_tab_4" class = "tabs-content">
		<h4>{{ _._( 'title_connection_status' ) }}</h4>
		<p>{{ _._( 'description_connection_status' ) }}</p>
		<hr />
		<span class = "check-connection"></span>
		<hr />
	</section>
	<section id = "inside_tab_5" class = "tabs-content">
		<h4>{{ _._( 'title_alert' ) }}</h4>
		<p>{{ _._( 'description_alert' ) }}</p>
		{% for alert in var_latest_station_equipment_measurement_parameter_alerts %}
			{% set alert_level = alert.getLevel( ) %}
			<section class = "ink-alert page-callout {{ alert_level.class }}">
				<h5>{{ alert.title }}</h5>
				<p>{{ alert.description }}</p>
			</section>
		{% endFor %}
	</section>
</section>

<script type = "text/javascript">
	jQuery( "document" ).ready( function ( $ ) {

		var graph_data	= [],
			cnt 		= 0,
			data 		= {{ var_station_equipment_measurement_graph | json_encode }},
			colors 		= [ "#E15656", "#A6D037", "#61A5E4", "#FBD75B", "#FFB878", "#DBADFF", "#E1E1E1" ];

		for ( var label_key in data ) {

			var temp_data = [];

			for ( var cnt_key in data[label_key] ) {

				temp_data.push( [ new Date( data[label_key][cnt_key][0] ), data[label_key][cnt_key][1] ] );

			}

			graph_data.push( { data : temp_data, label : label_key, color : colors[cnt] } ); 

			cnt++;

		}


		function tooltip ( x, y, content ) {
			$( "<div id = 'graph-tooltip'>" + content + "</div>" )
				.css({
					"position" 			: "absolute",
					"display"  			: "none",
					"top" 				: y + 5,
					"left" 				: x + 5,
					"padding" 			: "4px",
					"color" 			: "#ffffff",
					"background-color" 	: "#000000",
					"opacity"			: 0.75,
					"border-radius" 	: "3px"
				})
				.appendTo( "body" )
				.fadeIn( 200 );
		}

		var options = { 
			canvas 	: true,
			series 	: {
				"lines" 	: { show : true },
				"points" 	: { show : true },
			},
			xaxis 	: {
				"mode"			: "time",
				
			},
			grid 	: { 
				"hoverable" 	: true,
				"clickable"		: true,
				"borderWidth" 	: 0
			}
		};

		var plot = $.plot( 
			"#graph", 
			graph_data,
			options 
		);

		var plot_report = $.plot( 
			"#graph-report", 
			graph_data,
			options 
		);

		$( ".graph").bind( "plothover", function( event, position, item ) {

			var $tooltip = $( "#graph-tooltip" );

			if( item ) {
				if( prevpoint != item.dataIndex ) {
					prevpoint = item.dataIndex;

					$tooltip.remove( );

					var time = item.datapoint[0],
						point = Math.round( item.datapoint[1] ),
						date = new Date( time );
						tooltip ( item.pageX, item.pageY, point + " " + item.series.label.toLowerCase( ) + " on " + date.toLocaleDateString( ) )
				}
			} 
			else { 
				$tooltip.remove( );
				prevpoint = null
			}
		});

		$.each( graph_data, function ( index, data ) {
			var container 	= $( "#small-graph" );
			var small_graph = $( "<div />", {
				"class" : "all-50 vertical-space",
				"id"  	: "small-graph-" + index
			}).css({
				height : "300px"
			});

			container.append( small_graph );

			var plot = $.plot( 
				"#small-graph-" + index, 
				[data],
				options 
			);
		});

		$( ".check-connection" ).each( function ( index, connection ) {
			var self = $( this );

			self.html( $( "<img />", {
				"class" : "status",
				"src" 	: "{{ url([ 'for' : 'theme-system', 'folder' : 'Images', 'file' : 'loader.gif' ]) }}" 
			})).append( "{{ _._( 'text_connecting', [ 'station' : var_station.name ] ) }}" );
			setTimeout( function ( ) {
				self.html( $( "<span />", {
					"class" : "round status green",
				})).append( "{{ _._( 'text_connected' ) }}" );
			}, 15000 );
		});
	});
</script>