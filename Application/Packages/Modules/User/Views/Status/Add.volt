<form action = "{{ var_save_url }}" method = "post" enctype = "multipart/form-data" class = "ink-form clearfix">

	{{ hidden_field( security.getTokenKey( ), 'value' : security.getToken( ) ) }}

	<div class = "column-group horizontal-gutters">
		<div class = "all-70 large-100 medium-100 small-100 tiny-100">
			<section class = "panel primary">
				<header class = "panel-header">
					<h6 class = "panel-title">
						<i class = "fa fa-file-text-o half-right-space"></i> {{ _._( 'panel_title' ) }}
					</h6>
				</header>

				<section class = "panel-body">

					<div class = "control-group column-group validation">
						<label for = "status" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_status' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'status', 'placeholder' : _._( 'placeholder_status' )  ) }}
							<p class = "tip">{{ _._( 'tip_status' ) }}</p>
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
						<label for = "sort_order" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_sort_order' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'sort_order', 'placeholder' : _._( 'placeholder_sort_order' )  ) }}
							<p class = "tip">{{ _._( 'tip_sort_order' ) }}</p>
						</div>
					</div>

				</section>

				<section class = "panel-footer clearfix">
					<button type = "submit" class = "ink-button lightblue info push-right"><i class = "fa fa-save quarter-right-space"></i> {{ _._( 'text_save' ) }}</button>
					<button type = "reset" class = "ink-button red danger push-right"><i class = "fa fa-eraser quarter-right-space"></i> {{ _._( 'text_clear' ) }}</button>
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

				</section>

				<section class = "panel-footer clearfix">
					<button type = "submit" class = "ink-button lightblue info push-right"><i class = "fa fa-save quarter-right-space"></i> {{ _._( 'text_save' ) }}</button>
					<button type = "reset" class = "ink-button red danger push-right"><i class = "fa fa-eraser quarter-right-space"></i> {{ _._( 'text_clear' ) }}</button>
				</section>
			</section>
		</div>
	</div>
</form>