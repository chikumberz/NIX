{{ form( var_index_url, 'method' : 'post', 'enctype' : 'multipart/form-data', 'class' : '' ) }}

	{{ hidden_field( security.getTokenKey( ), 'value' : security.getToken( ) ) }}

	<section class = "nix-panel primary">
		<header class = "panel-header">
			<h6 class = "panel-title"><i class = "fa fa-credit-card half-right-space"></i> {{ _._( 'panel_title' ) }}</h6>
		</header>

		<section class = "panel-body clearfix">
			<blockquote class = "fw-300 note half-horizontal-padding quarter-vertical-padding">{{ _._( 'panel_description' ) }}</blockquote>

			{{ __GRID__ }}
		</section>

		<section class = "panel-footer"></section>
	</section>
{{ end_form( ) }}