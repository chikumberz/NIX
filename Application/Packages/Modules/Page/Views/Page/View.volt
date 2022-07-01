<div class = "ink-form column-group horizontal-gutters">
	<div class = "all-70 large-100 medium-100 small-100 tiny-100">
		<section class = "panel primary">
			<header class = "panel-header">
				<h6 class = "panel-title">
					<i class = "fa fa-file-text-o half-right-space"></i> {{ _._( 'panel_title' ) }}
					<div class = "thumb float round left top">
						<img src = "{{ var_avatar }}" alt = "Avatar" class = "" />
					</div>
				</h6>
			</header>

			<section class = "panel-body clearfix">

				<h4 class = "title-bottom-line">{{ _._( 'text_user_account_title' ) }}</h4>
				<blockquote class = "fw-300 note">{{ _._( 'text_user_account_description' ) }}</blockquote>

				<div class = "control-group column-group validation">
					<label for = "" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_username' ) }}</b></label>
					<div class = "control medium-100 small-100 tiny-100 all-80">
						<span class = "red-bold-underline">{{ username }}</span>
					</div>
				</div>

				<div class = "control-group column-group validation">
					<label for = "" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_password' ) }}</b></label>
					<div class = "control medium-100 small-100 tiny-100 all-80">
						<span class = "red-bold-underline">***************</span>
					</div>
				</div>

				<div class = "control-group column-group validation">
					<label for = "" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_password_confirm' ) }}</b></label>
					<div class = "control medium-100 small-100 tiny-100 all-80">
						<span class = "red-bold-underline">***************</span>
					</div>
				</div>

				<div class = "control-group column-group validation">
					<label for = "" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_group' ) }}</b></label>
					<div class = "control medium-100 small-100 tiny-100 all-80">
						<span class = "red-bold-underline">{{ group }}</span>
					</div>
				</div>

				<div class = "control-group column-group validation">
					<label for = "" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_status' ) }}</b></label>
					<div class = "control medium-100 small-100 tiny-100 all-80">
						<span class = "red-bold-underline">{{ status }}</span>
					</div>
				</div>

				<h4 class = "title-bottom-line">{{ _._( 'text_user_profile_title' ) }}</h4>
				<blockquote class = "fw-300 note">{{ _._( 'text_user_profile_description' ) }}</blockquote>

				<div class = "control-group column-group validation">
					<label for = "" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_first_name' ) }}</b></label>
					<div class = "control medium-100 small-100 tiny-100 all-80">
						<span class = "red-bold-underline">{{ first_name }}</span>
					</div>
				</div>

				<div class = "control-group column-group validation">
					<label for = "" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_middle_name' ) }}</b></label>
					<div class = "control medium-100 small-100 tiny-100 all-80">
						<span class = "red-bold-underline">{{ middle_name }}</span>
					</div>
				</div>

				<div class = "control-group column-group validation">
					<label for = "" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_last_name' ) }}</b></label>
					<div class = "control medium-100 small-100 tiny-100 all-80">
						<span class = "red-bold-underline">{{ last_name }}</span>
					</div>
				</div>

				<div class = "control-group column-group validation">
					<label for = "" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_gender' ) }}</b></label>
					<div class = "control medium-100 small-100 tiny-100 all-80">
						<span class = "red-bold-underline">{{ gender|capitalize }}</span>
					</div>
				</div>

				<div class = "control-group column-group validation">
					<label for = "" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_birth_date' ) }}</b></label>
					<div class = "control medium-100 small-100 tiny-100 all-80">
						<span class = "red-bold-underline">{{ birth_date }}</span>
					</div>
				</div>

				<div class = "control-group column-group validation">
					<label for = "" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_birth_place' ) }}</b></label>
					<div class = "control medium-100 small-100 tiny-100 all-80">
						<span class = "red-bold-underline">{{ birth_place }}</span>
					</div>
				</div>

				<div class = "control-group column-group validation">
					<label for = "" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_mobile_no' ) }}</b></label>
					<div class = "control medium-100 small-100 tiny-100 all-80">
						<span class = "red-bold-underline">{{ mobile_no }}
					</div>
				</div>

				<div class = "control-group column-group validation">
					<label for = "" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_telephone_no' ) }}</b></label>
					<div class = "control medium-100 small-100 tiny-100 all-80">
						<span class = "red-bold-underline">{{ telephone_no }}
					</div>
				</div>

				<div class = "control-group column-group validation">
					<label for = "" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_fax_no' ) }}</b></label>
					<div class = "control medium-100 small-100 tiny-100 all-80">
						<span class = "red-bold-underline">{{ fax_no }}
					</div>
				</div>

				<div class = "control-group column-group validation">
					<label for = "" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_email' ) }}</b></label>
					<div class = "control medium-100 small-100 tiny-100 all-80">
						<a href = "mailto:{{ email }}">
							<span class = "red-bold-underline">{{ email }}<i class = "fa fa-envelope-o"></i></span>
						</a>
					</div>
				</div>

				<div class = "control-group column-group validation">
					<label for = "" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_address' ) }}</b></label>
					<div class = "control medium-100 small-100 tiny-100 all-80">
						<span class = "red-bold-underline">{{ address }}</span>
					</div>
				</div>

				<div class = "control-group column-group validation">
					<label for = "" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_city' ) }}</b></label>
					<div class = "control medium-100 small-100 tiny-100 all-80">
						<span class = "red-bold-underline">{{ city }}</span>
					</div>
				</div>

				<div class = "control-group column-group validation">
					<label for = "" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_state' ) }}</b></label>
					<div class = "control medium-100 small-100 tiny-100 all-80">
						<span class = "red-bold-underline">{{ state }}</span>
					</div>
				</div>

				<div class = "control-group column-group validation">
					<label for = "" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_zip' ) }}</b></label>
					<div class = "control medium-100 small-100 tiny-100 all-80">
						<span class = "red-bold-underline">{{ zip }}</span>
					</div>
				</div>

				{% if country is defined  %}
				<div class = "control-group column-group validation">
					<label for = "" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_country' ) }}</b></label>
					<div class = "control medium-100 small-100 tiny-100 all-80">
						<span class = "red-bold-underline">{{ country }}</span>
					</div>
				</div>
				{% endIf %}

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
					<label for = "" class = "all-100 align-left"><b>{{ _._( 'text_created_on' ) }}</b></label>
					<div class = "control all-100">{{ var_created_on }}</div>
				</div>
				<div class = "control-group column-group validation">
					<label for = "" class = "all-100 align-left"><b>{{ _._( 'text_updated_on' ) }}</b></label>
					<div class = "control all-100">{{ var_updated_on }}</div>
				</div>

				<div class = "control-group column-group validation">
					<label for = "" class = "all-100 align-left"><b>{{ _._( 'text_created_by' ) }}</b></label>
					<div class = "control all-100">{{ var_created_by }}</div>
				</div>
				<div class = "control-group column-group validation">
					<label for = "" class = "all-100 align-left"><b>{{ _._( 'text_updated_by' ) }}</b></label>
					<div class = "control all-100">{{ var_updated_by }}</div>
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
				<a href = "{{ var_delete_url }}" class = "ink-button red danger">{{ _._( 'text_delete' ) }}</a>
				<a href = "javascript:void(0);" class = "ink-button default ink-dismiss">{{ _._( 'text_cancel' ) }}</a>
			</div>
		</div>
	</div>
</div>