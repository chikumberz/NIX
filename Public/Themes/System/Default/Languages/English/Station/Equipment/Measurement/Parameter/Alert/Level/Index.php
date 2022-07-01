<?php

	$_['text_title'] 					= 'Equipment Measurement Parameter Alert Levels';
	$_['text_description'] 				= '';

	$_['table_grid_structure']			= array(
											'EquipmentMeasurementParameterAlertLevel.title' 	=> array(
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
											'EquipmentMeasurementParameterAlertLevel.is_archived' => array(
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


