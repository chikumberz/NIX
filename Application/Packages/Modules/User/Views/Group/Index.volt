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

		<section class = "panel-footer">
			<ul class = "nix-pagination clearfix">
				<li>
					<select name = "" id = "page-rows">
						<option value = "10">10</option>
						<option value = "20">20</option>
					</select>
				</li>
				<li><span class = "divider"></span></li>
				<li><a href = "" id = "page-first"><i class = "fa fa-step-backward"></i></a></li>
				<li><a href = "" id = "page-previous"><i class = "fa fa-caret-left"></i></a></li>
				<li><span class = "divider"></span></li>
				<li>
					<span class = "">Page</span>
					<input type = "text" id = "page-no"/>
					<span class = "">of 12</span>
				</li>
				<li><span class = "divider"></span></li>
				<li><a href = "" id = "page-next"><i class = "fa fa-caret-right"></i></a></li>
				<li><a href = "" id = "page-last"><i class = "fa fa-step-forward"></i></a></li>
				<li><span class = "divider"></span></li>
				<li><a href = "" id = "page-reload"><i class = "fa fa-repeat"></i></a></li>
				<li class = "push-right">Displaying 1 to 10 of 114 items</li>
			</ul>
		</section>
	</section>
{{ end_form( ) }}