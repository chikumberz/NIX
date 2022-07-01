<section class = "panel primary">
	<header class = "panel-header">
		<h6 class = "panel-title"><i class = "fa fa-credit-card half-right-space"></i> {{ _._( 'panel_title' ) }}</h6>
	</header>

	<section class = "panel-body no-margin no-padding">
		<blockquote class = "fw-300 note half-horizontal-padding quarter-vertical-padding">{{ _._( 'panel_description' ) }}</blockquote>
		<hr />
		<div class = "half-horizontal-padding clearfix">
			<section id = "package_tab" class = "ink-tabs left">
				<ul class = "tabs-nav">
					{% for package_type, package in var_packages  %}
						<li><a class = "tabs-tab" href = "#{{ package_type }}">{{ package_type | capitalize }}</a></li>
					{% endfor  %}
				</ul>

				{% for package_type, packages in var_packages %}
					<section id = "{{ package_type }}" class = "tabs-content">
						<table id = "package_table_{{ package_type }}" class = "ink-table alternating" data-page-size = "15" data-pagination = "#package_pagination_{{ package_type }}">
							<tr>
								<th>{{ _._( 'text_name' ) | upper }}</th>
								<th>{{ _._( 'text_version' ) | upper }}</th>
								<th>{{ _._( 'text_status' ) | upper }}</th>
								<th>{{ _._( 'text_enabled' ) | upper }}</th>
								<th>{{ _._( 'text_action' ) | upper }}</th>
							</tr>

							{% for package in packages %}
								<tr>
									<td>
										<b>{{ package['infos']['title'] }}</b>
										{% if package['infos']['author'] is defined %}
										<small>( {{ package['infos']['author'] }} )</small>
										{% endif %}
										<blockquote class = "fw-300 note half-horizontal-padding quarter-vertical-padding">
											{{ package['infos']['description'] }}
											<br /><br />
											{% if package['infos']['website'] is defined %}
												<small><a href = "{{ package['infos']['website'] }}">{{ package['infos']['website'] }}</a></small>
											{% endif %}
										</blockquote>
									</td>
									<td class = "align-center">{{ package['infos']['version'] }}</td>
									<td></td>
									<td class = "align-center">
										<span class = "custom-checkbox" style = "margin-top: -10px;">{{ check_field( 'enabled[' ~ package['id'] ~ ']', 'value' : package['id'], 'id' : package['id'], 'class' : 'enable' ) }}<label for = "{{ package['id'] }}"></label></span>
									</td>
									<td class = "align-center">
										<div class = "button-group push-center" style = "display: inline-block;">
											<?php $_package = explode( '\\', $package['id'] ); ?>
											{% if package.isInstalled( package['id'] ) %}
												<span class = "ink-button"><i class = "fa fa-trash-o"></i></span>
												<a href = "{{ url([ 'for' : 'package-uninstall', 'type' : _package[0]|lower, 'name' : _package[1]|lower ]) }}" class = "ink-button red">{{ _._( 'text_uninstall' ) }}</a>
											{% else %}
												<span class = "ink-button"><i class = "fa fa-download"></i></span>
												<a href = "{{ url([ 'for' : 'package-install', 'type' : _package[0]|lower, 'name' : _package[1]|lower ]) }}" class = "ink-button green">{{ _._( 'text_install' ) }}</a>
											{% endif %}
										</div>
									</td>
								</tr>
							{% endfor %}
						</table>

						<nav class = "ink-navigation push-right" id = "package_pagination_{{ package_type }}">
						    <ul class = "pagination"></ul>
						</nav>
					</section>
				{% endfor %}
			</section>
		</div>
	</section>
</section>

<script type = "text/javascript">
	$( 'input[type="checkbox"].enable' ).on( 'change', function ( ) {
		var self = $( this ),
			params = self.val( ).toLowerCase( ).split( '\\' );

		if ( self.is( ':checked' )  ) {
			var url = '{{ url([ "for" : "package-enable", "type" : ":type", "name" : ":name" ]) }}';
			url = url.replace( ':type', params[0] );
			url = url.replace( ':name', params[1] );

		} else {
			var url = '{{ url([ "for" : "package-disable", "type" : ":type", "name" : ":name" ]) }}';
			url = url.replace( ':type', params[0] );
			url = url.replace( ':name', params[1] );
		}

		window.location = url;
	});
</script>