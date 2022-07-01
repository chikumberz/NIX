<form method = "get" enctype = "multipart/form-data" class = "ink-form clearfix">
	
	{{ hidden_field( var_token_key, 'value' : var_token ) }}

	<section class = "panel primary">
		<header class = "panel-header">
			<h6 class = "panel-title"><i class = "fa fa-credit-card half-right-space"></i> {{ _._( 'text_title' ) }}</h6>
		</header>	

		<section class = "panel-body no-margin no-padding">
			<blockquote class = "fw-300 note half-horizontal-padding quarter-vertical-padding">{{ _._( 'text_description' ) }}</blockquote>
			<hr />
			<!-- TOOLBAR -->
			<div class = "half-horizontal-padding">
				<div class = "toolbar column-group horizontal-gutters quarter-bottom-space">
					<div class = "all-100 xlarge-60 quarter-vertical-space">
						<ul class = "left unstyled xlarge-push-left large-push-center medium-push-center small-push-center tiny-push-center">
							<li class = "ink-dropdown" data-target = "#visible-columns">
								<a href = "javascript:void(0);" class = "ink-button lightblue info no-margin less-padding"><i class = "fa fa-list-ol"></i></a>
								<ul id = "visible-columns" class = "dropdown-menu hide-all no-margin unstyled">
									<li class = "heading">{{ _._( 'table_grid_column_field' ) }}</li>
									<li class = "separator-above"></li>
									<li class = "heading">
										<ul class = "no-margin unstyled">
											<?php foreach ( $var_sql_columns as $property => $column ) { ?>
												<?php if ( !isset( $column['visible'] ) || $column['visible'] == true || $column['visible'] === "" ) { ?>
													<li>
														<span class = "custom-checkbox">
															<input type = "checkbox" name = "visible[]" value = "<?php echo $property; ?>" checked = "checked" id = "<?php echo strtolower( $property ); ?>"/> 
															<label for = "<?php echo strtolower( $property ); ?>"><?php echo $column['text']; ?></label>
														</span>
													</li>
												<?php } else { ?>
													<li>
														<span class = "custom-checkbox">
															<input type = "checkbox" name = "visible[]" value = "<?php echo $property; ?>"  id = "<?php echo strtolower( $property ); ?>"/> 
															<label for = "<?php echo strtolower( $property ); ?>"><?php echo $column['text']; ?></label>
														</span>
													</li>
												<?php } ?>
											<?php } ?>
										</ul>
									</li>
								</ul>
							</li>
							<li>{{ select( 'show', var_table_shows, 'useEmpty' : true, 'emptyText' : _._( 'table_grid_show_field' ), 'class' : '' ) }}</li>
							<li>{{ select( 'bulk', _._( 'table_grid_bulk_action' ), 'useEmpty' : true, 'emptyText' : _._( 'table_grid_bulk_field' ), 'class' : '' ) }}</li>
							<li>
								<div class = "ink-dropdown red" data-target = "#grid-action-menu" id = "grid-action">
									<button class = "ink-button green success no-margin"><i class = "fa fa-sort-amount-desc"></i></button>
									<ul id = "grid-action-menu" class = "dropdown-menu hide-all no-margin unstyled">
										<li class = "active"><a href = "#" onclick = "$( this ).closest( 'form' ).submit( );"><i class = "fa fa-tasks quarter-right-space"></i>{{ _._( 'btn_apply' ) }}</a></li>
										<li class = "separator-above"></li>
										<li><a href = "{{ url.get( ['for' : 'admin-action', 'folder' : 'user', 'controller' : var_controller, 'action' : 'add'] ) }}"><i class = "fa fa-download quarter-right-space"></i> {{ _._( 'btn_add' ) }}</a></li>
										<li class = "separator-above"></li>
										<li><a href = "{{ url.get( ['for' : 'admin-action', 'folder' : 'user', 'controller' : var_controller, 'action' : 'print'] ) }}"><i class = "fa fa-print quarter-right-space"></i> {{ _._( 'btn_print' ) }}</a></li>
									</ul>
								</div>
							</li>
						</ul>
					</div>

					<div class = "all-100 xlarge-40 quarter-vertical-space">
						<div class = "control-group no-margin">
							<div class = "control append-button prepend-symbol" role = "search">
								<span>	
									<i class = "fa fa-search"></i>
									{{ text_field( 'search', 'placeholder' : _._( 'table_grid_search_placeholder' ) ) }}
								</span>
								{{ submit_button( 'search_btn', 'value' :  _._( 'btn_search' ), 'class' : 'ink-button green success', 'style' : 'width: 7em;' ) }}
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END TOOLBAR -->

			<table id = "items" class = "ink-table alternating bordered no-radius table-grid">
				<thead>
					<tr>
						<th class = "align-center" style = "width: 5%;">
							<span class = "custom-checkbox">
								<input type = "checkbox" id = "toggle_checked" class = "toggle-check"/>
								<label for = "toggle_checked" class = "no-padding">&nbsp;</label>
							</span>
						</th>
						<?php $var_column_cnt = 0; ?>
						<?php foreach ( $var_sql_columns as $property => $column ) { ?>
							<?php if ( !isset( $column['visible'] ) || $column['visible'] == true || $column['visible'] === "" ) { ?>
								<?php 
									$attributes = "";
									foreach ( ( isset( $column['attributes'] ) ? $column['attributes'] : array( ) ) as $key => $value ) {
										$attributes .= " {$key} = '{$value}' ";
									}
									$var_column_cnt++;
								?>
								<th <?php echo $attributes; ?>>
									<?php if ( isset( $column['sort'] ) && $column['sort'] === true ) { ?>
										<?php
											$old_query_string['order'] 		= $var_order;
											$old_query_string['orderby'] 	= $var_order_by;
											$new_query_string 				= $old_query_string;

											if ( isset( $new_query_string['orderby'] ) && $new_query_string['orderby'] == $property ) {
												if ( $new_query_string['order'] == 'asc' ) {
													$new_query_string['order'] = 'desc';
												} else {
													$new_query_string['order'] = 'asc';
												}
											} else {
												$new_query_string['orderby'] = $property;
												$new_query_string['order'] = 'asc';
											}
										?>
										<a href = "?<?php echo http_build_query( $new_query_string ); ?>">
											<span><?php echo $column['text']; ?></span>
											<?php if ( isset( $old_query_string['orderby'] ) && $old_query_string['orderby'] == $property ) { ?>
												<?php if ( $old_query_string['order'] == 'asc' ) { ?>
													<i class = "fa fa-caret-up"></i>
												<?php } else if ( $old_query_string['order'] == 'desc' ) { ?>
													<i class = "fa fa-caret-down"></i>
												<?php } ?>
											<?php } else { ?>
												<i class = "fa fa-sort"></i>
											<?php } ?>
										</a>
									<?php } else { ?>
										<span><?php echo $column['text']; ?></span>
									<?php } ?>
								</th>
							<?php } ?>
						<?php } ?>
						<th class = "align-center">{{ _._( 'text_action' ) }}</th>
					</tr>
				</thead>
				
				<tbody>
					{% if var_sql_data.hasItems( ) %}
						<?php foreach ( $var_sql_data->getItems( ) as $row ) { ?>
							<tr>
								<td class = "align-center">
									<span class = "custom-checkbox">
										<input type = "checkbox" name = "id[]" value = "<?php echo $row->getId( ); ?>" id = "check-<?php echo $row->getId( ); ?>" class = "toggle_checked"/>
										<label for = "check-<?php echo $row->getId( ); ?>" class = "no-padding">&nbsp;</label>
									</span>
								</td>
								<?php foreach ( $var_sql_columns as $properties => $column ) { ?>
									<?php if ( !isset( $column['visible'] ) || $column['visible'] == true || $column['visible'] === "" ) { ?>
										<?php 
											$properties 	= explode( '.', $column['column'] );
											$cnt 			= count( $properties ); 
											$index 			= 1;
											$extract_row 	= $row;	
											$attributes 	= "";

											foreach ( ( isset( $column['row']['attributes'] ) ? $column['row']['attributes'] : array( ) ) as $key => $value ) {
												$attributes .= " {$key} = '{$value}' ";
											}
										?>
										<?php foreach ( $properties as $key => $property ) { ?>
											<?php if ( $index == $cnt ) { ?>
												<td <?php echo $attributes; ?>>
													<?php echo isset( $column['row']['prepend'] ) ? $column['row']['prepend'] : ''; ?>
													<?php if ( isset( $column['row']['replace'] ) && array_key_exists( $extract_row->{$property}, $column['row']['replace'] ) ) { ?>
														<?php echo $column['row']['replace'][$extract_row->{$property}]; ?>
													<?php } else { ?>
														<?php echo $extract_row->{$property}; ?>
													<?php } ?>
													<?php echo isset( $column['row']['append'] ) ? $column['row']['append'] : ''; ?>
												</td>
											<?php } else { ?>
												<?php $extract_row = $extract_row->{$property}; $index++; ?>
											<?php } ?>
										<?php } ?>
									<?php } ?>
								<?php } ?>
								<td>
									<div class = "button-toolbar ink-dropdown red push-right" data-target = "#actions-{{ row.getId( ) }}">
										<div class = "button-group" style = "width: 7.5em;">
											<button class = "ink-button default no-margin">{{ _._( 'btn_action' ) }}</button>
											<button class = "ink-button green no-margin"><i class = "fa fa-sort-amount-desc"></i></button>
										</div>

										<ul id = "actions-{{ row.getId( ) }}" class = "dropdown-menu hide-all no-margin unstyled">
											<?php if ( property_exists( $row, 'is_archived' ) ) { ?>
												<?php if ( $row->is_archived ) { ?>
													<li><a href = "<?php echo $this->url->get( array( 'for' => 'admin-full', 'folder' => 'user', 'controller' => $var_controller, 'action' => 'unarchive', 'params' => $row->getId( ) ) ); ?>"><i class = "fa fa-folder-open quarter-right-space"></i>{{ _._( 'btn_unarchive'  ) }}</a></li>
												<?php } else { ?>
													<li><a href = "<?php echo $this->url->get( array( 'for' => 'admin-full', 'folder' => 'user', 'controller' => $var_controller, 'action' => 'view', 'params' => $row->getId( ) ) ); ?>"><i class = "fa fa-file-text quarter-right-space"></i>{{ _._( 'btn_view'  ) }}</a></li>
													<li><a href = "<?php echo $this->url->get( array( 'for' => 'admin-full', 'folder' => 'user', 'controller' => $var_controller, 'action' => 'edit', 'params' => $row->getId( ) ) ); ?>"><i class = "fa fa-pencil quarter-right-space"></i>{{ _._( 'btn_edit'  ) }}</a></li>
													<li><a href = "<?php echo $this->url->get( array( 'for' => 'admin-full', 'folder' => 'user', 'controller' => $var_controller, 'action' => 'archive', 'params' => $row->getId( ) ) ); ?>"><i class = "fa fa-archive quarter-right-space"></i>{{ _._( 'btn_archive'  ) }}</a></li>
													<li class = "active"><a href = "<?php echo $this->url->get( array( 'for' => 'admin-full', 'folder' => 'user', 'controller' => $var_controller, 'action' => 'delete', 'params' => $row->getId( ) ) ); ?>"><i class = "fa fa-trash-o quarter-right-space"></i>{{ _._( 'btn_delete'  ) }}</a></li>
												<?php } ?>
											<?php } else { ?>
												<li><a href = "<?php echo $this->url->get( array( 'for' => 'admin-full', 'folder' => 'user', 'controller' => $var_controller, 'action' => 'view', 'params' => $row->getId( ) ) ); ?>"><i class = "fa fa-file-text quarter-right-space"></i>{{ _._( 'btn_view'  ) }}</a></li>
												<li><a href = "<?php echo $this->url->get( array( 'for' => 'admin-full', 'folder' => 'user', 'controller' => $var_controller, 'action' => 'edit', 'params' => $row->getId( ) ) ); ?>"><i class = "fa fa-pencil quarter-right-space"></i>{{ _._( 'btn_edit'  ) }}</a></li>
												<li class = "active"><a href = "<?php echo $this->url->get( array( 'for' => 'admin-full', 'folder' => 'user', 'controller' => $var_controller, 'action' => 'delete', 'params' => $row->getId( ) ) ); ?>"><i class = "fa fa-trash-o quarter-right-space"></i>{{ _._( 'btn_delete'  ) }}</a></li>
											<?php } ?>
										</ul>
									</div>								
								</td>
							</tr>
						<?php } ?>
					{% else %}
						<tr>
							<td colspan= "{{ var_column_cnt + 2 }}" class = "align-center">{{ _._( 'text_no_result' ) }}</td>
						</tr>
					{% endIf %}
				</tbody>
			</table>
		</section>

		<section class = "panel-footer clearfix">
			<!-- TOOLBAR -->
			<div class = "toolbar column-group horizontal-gutters">
				<div class = "all-100 xlarge-50 quarter-vertical-space">
					
				</div>

				<div class = "all-100 xlarge-50 quarter-vertical-space">
					<nav class = "ink-navigation xlarge-push-right clearfix" id = "items-pagination">
						{{ var_sql_data.getPager( ) }}
					</nav>
				</div>
			</div>
			<!-- END TOOLBAR -->
		</section>
	</section>
</form>