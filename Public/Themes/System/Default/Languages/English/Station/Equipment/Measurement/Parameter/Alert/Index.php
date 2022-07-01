<?php

	$_['text_title'] 					= 'Equipment Measurement Parameter Alerts';
	$_['text_description'] 				= '';

	$_['table_grid_structure']			= array(
											'EquipmentMeasurementParameterAlert.title' 	=> array(
												'column'	=> 'title',
												'text' 		=> 'Title',
												'sort'		=> true, 			
												'attributes'	=> array(
													'class'	=> 'align-left'
												),
												'row' 		=> array(
													'prepend'	=> '',
													'append'	=> '',
													'attributes' => array(
													
													),
													'replace' => array(

													)
												)
											),
											'EquipmentMeasurementParameterAlert.is_archived' => array(
												'column'	=> 'is_archived',
												'text' 		=> 'Archived',		
												'sort'		=> true, 
												'search'	=> false,
												'attributes'	=> array(
													'class'	=> 'align-left'
												),
												'row' 		=> array(
													'attributes'	=> array(
														'class'	=> 'align-center'
													),
													'replace' => array(
														NULL	=> 'NO',
														0		=> 'NO',
														1		=> 'YES',
													)
												)
											),
										);


