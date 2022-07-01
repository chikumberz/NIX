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

					<h4 class = "title-bottom-line">{{ _._( 'text_user_account_title' ) }}</h4>
					<blockquote class = "fw-300 note">{{ _._( 'text_user_account_description' ) }}</blockquote>

					<div class = "control-group column-group validation">
						<label for = "title" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_title' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'title', 'placeholder' : _._( 'placeholder_title' )  ) }}
							<p class = "tip">{{ _._( 'tip_title' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "slug" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_slug' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'slug', 'placeholder' : _._( 'placeholder_slug' )) }}
							<p class = "tip">{{ _._( 'tip_slug' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "description" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_description' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'description', 'placeholder' : _._( 'placeholder_description' )) }}
							<p class = "tip">{{ _._( 'tip_description' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "keywords" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_keywords' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'keywords', 'placeholder' : _._( 'placeholder_keywords' )) }}
							<p class = "tip">{{ _._( 'tip_keywords' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "content" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_content' ) }}</b></label>
						<div class = "column-group medium-100 small-100 tiny-100 all-80">
							<div class = "control all-100 quarter-bottom-space">{{ select( 'filter_id', var_filters, 'useEmpty' : true, 'emptyText' : _._( 'placeholder_filter_id' ), 'id' : 'page_filter_id', 'class' : 'filter-selector' ) }}</div>
							<div class = "control all-100">{{ text_area( 'content', 'placeholder' : _._( 'placeholder_content' ), 'class' : 'page_content' ) }}</div>
							<p class = "tip">{{ _._( 'tip_content' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "status_id" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_status' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ select( 'status_id', var_status, 'useEmpty' : true, 'emptyText' : _._( 'placeholder_status' ) ) }}
							<p class = "tip">{{ _._( 'tip_status' ) }}</p>
						</div>
					</div				</section>
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
