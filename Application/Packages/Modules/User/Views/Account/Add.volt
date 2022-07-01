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
						<label for = "avatar" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_avatar' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ file_field( 'avatar', 'accept' : 'image/jpeg, image/jpg, image/png' , 'placeholder' : _._( 'placeholder_avatar' )  ) }}
							<p class = "tip">{{ _._( 'tip_avatar' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "username" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_username' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'username', 'placeholder' : _._( 'placeholder_username' )  ) }}
							<p class = "tip">{{ _._( 'tip_username' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "password" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_password' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ password_field( 'password', 'placeholder' : _._( 'placeholder_password' ) ) }}
							<p class = "tip">{{ _._( 'tip_password' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "password_confirm" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_password_confirm' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ password_field( 'password_confirm', 'placeholder' : _._( 'placeholder_password_confirm' ) ) }}
							<p class = "tip">{{ _._( 'tip_password_confirm' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "group_id" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_group' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ select( 'group_id', var_groups, 'using' : ['user_group_id', 'group'], 'useEmpty' : true, 'emptyText' : _._( 'placeholder_group' ) ) }}
							<p class = "tip">{{ _._( 'tip_group' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "status_id" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_status' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ select( 'status_id', var_status, 'using' : ['user_status_id', 'status'], 'useEmpty' : true, 'emptyText' : _._( 'placeholder_status' ) ) }}
							<p class = "tip">{{ _._( 'tip_status' ) }}</p>
						</div>
					</div>

					<h4 class = "title-bottom-line">{{ _._( 'text_user_profile_title' ) }}</h4>
					<blockquote class = "fw-300 note">{{ _._( 'text_user_profile_description' ) }}</blockquote>

					<div class = "control-group column-group validation">
						<label for = "first_name" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_first_name' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'first_name', 'placeholder' : _._( 'placeholder_first_name' )) }}
							<p class = "tip">{{ _._( 'tip_first_name' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "middle_name" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_middle_name' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'middle_name', 'placeholder' : _._( 'placeholder_middle_name' ) ) }}
							<p class = "tip">{{ _._( 'tip_middle_name' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "last_name" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_last_name' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'last_name', 'placeholder' : _._( 'placeholder_last_name' ) ) }}
							<p class = "tip">{{ _._( 'tip_last_name' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<p class = "label medium-100 small-100 tiny-100 all-20 align-left">{{ _._( 'field_gender' ) }}</p>
						<ul class = "control unstyled medium-100 small-100 tiny-100 all-80">
							<li class = "custom-radio">{{ radio_field( 'gender', 'value' : 'male', 'id' : 'male' ) }} <label for = "male">{{ _._( 'field_gender_male' ) }}</label></li>
							<li class = "custom-radio">{{ radio_field( 'gender', 'value' : 'female', 'id' : 'female' ) }} <label for = "female">{{ _._( 'field_gender_female' ) }}</label></li>
						</ul>
						<p class = "tip">{{ _._( 'tip_gender' ) }}</p>
					</div>

					<div class = "control-group column-group validation">
						<label for = "birth_date" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_birth_date' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'birth_date', 'placeholder' : _._( 'placeholder_birth_date' ), 'class' : 'ink-datepicker' ) }}
							<p class = "tip">{{ _._( 'tip_birth_date' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "birth_place" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_birth_place' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'birth_place', 'placeholder' : _._( 'placeholder_mobile_no' ) ) }}
							<p class = "tip">{{ _._( 'tip_birth_place' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "mobile_no" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_mobile_no' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'mobile_no', 'placeholder' : _._( 'placeholder_mobile_no' ) ) }}
							<p class = "tip">{{ _._( 'tip_mobile_no' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "telephone_no" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_telephone_no' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'telephone_no', 'placeholder' : _._( 'placeholder_telephone_no' ) ) }}
							<p class = "tip">{{ _._( 'tip_telephone_no' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "fax_no" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_fax_no' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'fax_no', 'placeholder' : _._( 'placeholder_fax_no' ) ) }}
							<p class = "tip">{{ _._( 'tip_fax_no' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "email" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_email' ) }}</b></label>
						<div class = "control append-symbol medium-100 small-100 tiny-100 all-80">
							<span>
								{{ text_field( 'email', 'placeholder' : _._( 'placeholder_email' ) ) }}
								<i class = "fa fa-envelope-o"></i>
							</span>
							<p class = "tip">{{ _._( 'tip_email' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "address" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_address' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'address', 'placeholder' : _._( 'placeholder_address' ) ) }}
							<p class = "tip">{{ _._( 'tip_address' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "city" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_city' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'city', 'placeholder' : _._( 'placeholder_city' ) ) }}
							<p class = "tip">{{ _._( 'tip_city' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "state" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_state' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'state', 'placeholder' : _._( 'placeholder_state' ) ) }}
							<p class = "tip">{{ _._( 'tip_state' ) }}</p>
						</div>
					</div>

					<div class = "control-group column-group validation">
						<label for = "zip" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_zip' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ text_field( 'zip', 'placeholder' : _._( 'placeholder_zip' ) ) }}
							<p class = "tip">{{ _._( 'tip_zip' ) }}</p>
						</div>
					</div>

					{% if var_countries is defined  %}
					<div class = "control-group column-group validation">
						<label for = "country_id" class = "medium-100 small-100 tiny-100 all-20 align-left"><b>{{ _._( 'field_country' ) }}</b></label>
						<div class = "control medium-100 small-100 tiny-100 all-80">
							{{ select( 'country_id', var_countries, 'using' : ['country_id', 'country'], 'useEmpty' : true, 'emptyText' : _._( 'placeholder_country' )  ) }}
							<p class = "tip">{{ _._( 'tip_country' ) }}</p>
						</div>
					</div>
					{% endIf %}

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