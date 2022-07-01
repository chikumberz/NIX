<div class = "ink-form column-group horizontal-gutters">
	<div class = "all-70 large-100 medium-100 small-100 tiny-100">
		<section class = "panel primary">
			<header class = "panel-header">
				<h6 class = "panel-title"><i class = "fa fa-file-text-o half-right-space"></i> {{ _._( 'text_title' ) }}</h6>
			</header>
	
			<section class = "panel-body clearfix">

				<h4 class = "title-bottom-line">{{ _._( 'text_user_group_title' ) }}</h4>
				<blockquote class = "fw-300 note">{{ _._( 'text_user_group_description' ) }}</blockquote>

				<div class = "control-group column-group validation">
					<label for = "" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_group' ) }}</b></label>
					<div class = "control medium-100 small-100 tiny-100 all-80">
						{{ group }}
					</div>
				</div>

				<div class = "control-group column-group validation">
					<label for = "" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_description' ) }}</b></label>
					<div class = "control medium-100 small-100 tiny-100 all-80">
						{{ description }}
					</div>
				</div>

				<div class = "control-group column-group validation">
					<label for = "" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_permissions' ) }}</b></label>
					<div class = "control medium-100 small-100 tiny-100 all-80">
						<ul class = "unstyled column-group horizontal-gutters">
							{% for permissions in var_permissions %}
								<li class = "small-100 tiny-100 all-50 no-margin push-left">
									<div class = "column half-vertical-padding half-horizontal-padding rounded bordered-dash clearfix">
										<label for = "" class = "fw-700"><?php echo ucwords( str_replace( '_', ' ', \Phalcon\Text::uncamelize( $permissions->controller ) ) ); ?></label>
										<ul class = "unstyled no-margin-vertical half-left-space">
										{% for position, sub_permissions in permissions.permissions %}
											<li class = "">
												<span class = "custom-checkbox">
													{{ check_field( 'permissions' ~ '[' ~ permissions.controller ~ '][' ~ position ~ ']', 'value' : sub_permissions['key'], 'id' : 'permissions' ~ '[' ~ permissions.controller ~ '][' ~ sub_permissions['key'] ~ ']', 'class' : 'permissions' ~ '-access toggle-check-all', 'disabled' : 'disabled' ) }}
													<label for = "">{{ sub_permissions['name'] }}</label>
												</span>
											</li>
										{% endFor %}
										</ul>
									</div>
								</li>
							{% endFor %}						
						</ul>
					</div>
				</div>

				<div class = "control-group column-group validation">
					<label for = "" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_sort_order' ) }}</b></label>
					<div class = "control medium-100 small-100 tiny-100 all-80">
						{{ sort_order }}
					</div>
				</div>

			</section>
			
			<section class = "panel-footer clearfix">
				<a href = "javascript:void(0);" class = "ink-button red danger push-right dialog-trigger"><i class = "fa fa-trash-o"></i></a>
				<a href = "{{ var_archive_url }}" class = "ink-button default push-right"><i class = "fa fa-suitcase"></i></a>
				<a href = "{{ var_edit_url }}" class = "ink-button default push-right"><i class = "fa fa-edit"></i></a>
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
				<a href = "javascript:void(0);" class = "ink-button red danger push-right dialog-trigger"><i class = "fa fa-trash-o"></i></a>
				<a href = "{{ var_archive_url }}" class = "ink-button default push-right"><i class = "fa fa-suitcase"></i></a>
				<a href = "{{ var_edit_url }}" class = "ink-button default push-right"><i class = "fa fa-edit"></i></a>
			</section>
		</section>
	</div>
</div>

<div class = "ink-shade fade">
	<div id = "dialog" class = "ink-modal fade" data-trigger = ".dialog-trigger" data-width = "30%" data-height = "30%">
		<div class = "modal-header">
			<button class = "modal-close ink-dismiss"></button>
			<h2>{{ _._( 'delete_confirm_title' ) }}</h2>
		</div>
		<div class = "modal-body">
			{{ _._( 'delete_confirm_message' ) }}
		</div>
		<div class = "modal-footer">
			<div class = "push-right">
				<a href = "{{ var_delete_url }}" class = "ink-button red danger">{{ _._( 'btn_delete' ) }}</a>
				<a href = "javascript:void(0);" class = "ink-button default ink-dismiss">{{ _._( 'btn_cancel' ) }}</a>
			</div>
		</div>
	</div>
</div>