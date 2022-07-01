<div id = "files_permission_start">
	<form id = "chmod_form">
		<table class = "file-perms-table">
			<thead>
				<tr>
					<td></td>
					<td>r&nbsp;&nbsp;</td>
					<td>w&nbsp;&nbsp;</td>
					<td>x&nbsp;&nbsp;</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>{{ _._( 'text_user' ) }}</td>
					<td><input id = "u_4" type = "checkbox" data-value = "4" data-group = "user" onChange = "chmod_logic( );" {{ var_permission_user_4 ? 'checked = "checked"' : '' }} /></td>
					<td><input id = "u_2" type = "checkbox" data-value = "2" data-group = "user" onChange = "chmod_logic( );" {{ var_permission_user_2 ? 'checked = "checked"' : '' }} /></td>
					<td><input id = "u_1" type = "checkbox" data-value = "1" data-group = "user" onChange = "chmod_logic( );" {{ var_permission_user_1 ? 'checked = "checked"' : '' }} /></td>
				</tr>
				<tr>
					<td>{{ _._( 'text_group' ) }}</td>
					<td><input id = "g_4" type = "checkbox" data-value = "4" data-group = "group" onChange = "chmod_logic( );" {{ var_permission_group_4 ? 'checked = "checked"' : '' }} /></td>
					<td><input id = "g_2" type = "checkbox" data-value = "2" data-group = "group" onChange = "chmod_logic( );" {{ var_permission_group_2 ? 'checked = "checked"' : '' }} /></td>
					<td><input id = "g_1" type = "checkbox" data-value = "1" data-group = "group" onChange = "chmod_logic( );" {{ var_permission_group_1 ? 'checked = "checked"' : '' }} /></td>
				</tr>
				<tr>
					<td>{{ _._( 'text_all' ) }}</td>
					<td><input id = "a_4" type = "checkbox" data-value = "4" data-group = "all" onChange = "chmod_logic( );" {{ var_permission_all_4 ? 'checked = "checked"' : '' }} /></td>
					<td><input id = "a_2" type = "checkbox" data-value = "2" data-group = "all" onChange = "chmod_logic( );" {{ var_permission_all_2 ? 'checked = "checked"' : '' }} /></td>
					<td><input id = "a_1" type = "checkbox" data-value = "1" data-group = "all" onChange = "chmod_logic( );" {{ var_permission_all_1 ? 'checked = "checked"' : '' }} /></td>
				</tr>
				<tr>
					<td></td>
					<td colspan = "3"><input type = "text" name = "chmod_value" id = "chmod_value" value = "{{ var_permission }}" data-def-value = "{{ var_permission }}"></td>
				</tr>
			</tbody>
		</table>

		{% if var_is_folder %}
			<div> {{ _._( 'text_file_permission_recursive' ) }}
				<ul>
					<li><input value="none" name="apply_recursive" type="radio" checked> {{ _._( 'text_no' ) }}</li>
					<li><input value="files" name="apply_recursive" type="radio"> {{ _._( 'text_files' ) }}</li>
					<li><input value="folders" name="apply_recursive" type="radio"> {{ _._( 'text_folders' ) }}</li>
					<li><input value="both" name="apply_recursive" type="radio"> {{ _._('text_files') }} & {{ _._( 'text_folders' ) }}</li>
				</ul>
			</div>
		{% endIf %}

	</form>
</div>