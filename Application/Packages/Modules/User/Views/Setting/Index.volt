{{ form( var_save_url, 'method' : 'post', 'enctype' : 'multipart/form-data', 'class' : 'ink-form' ) }}

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
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_avatar_key' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'avatar_key', 'placeholder' : _._( 'placeholder_avatar_key' )  ) }}
							<p class = "tip">{{ _._( 'tip_avatar_key' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_avatar_dir' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'avatar_dir', 'placeholder' : _._( 'placeholder_avatar_dir' )  ) }}
							<p class = "tip">{{ _._( 'tip_avatar_dir' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_avatar_tmb_dir' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'avatar_tmb_dir', 'placeholder' : _._( 'placeholder_avatar_tmb_dir' )  ) }}
							<p class = "tip">{{ _._( 'tip_avatar_tmb_dir' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_avatar_default' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'avatar_default', 'placeholder' : _._( 'placeholder_avatar_default' )  ) }}
							<p class = "tip">{{ _._( 'tip_avatar_default' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_avatar_tmb_dimension' ) }}</b></label>
						<div class = "medium-100 small-100 tiny-100 all-80 column-group">
							<div class = "all-45 control">{{ text_field( 'avatar_tmb_width', 'placeholder' : _._( 'placeholder_avatar_tmb_width' )  ) }}</div>
							<div class = "all-10 align-center">x</div>
							<div class = "all-45 control">{{ text_field( 'avatar_tmb_height', 'placeholder' : _._( 'placeholder_avatar_tmb_height' )  ) }}</div>
							<p class = "tip">{{ _._( 'tip_avatar_tmb_dimension' ) }}</p>
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