<?php

	$_['text_title'] 					= 'Equipment Measurements';
	$_['text_description'] 				= '';

	$_['table_grid_structure']			= array(
											'Station.name' 	=> array(
												'column'	=> 'Station.name',
												'text' 		=> 'Station',
												'sort'		=> true, 			
												'attributes'	=> array(
													'class'	=> 'align-left'
												),
												'row' 		=> array(
													'prepend'	=> '',
													'append'	=> '',
													'attributes' => array(
													
													)
												)
											),
											'Equipment.name' 	=> array(
												'column'	=> 'Equipment.name',
												'text' 		=> 'Equipment',
												'sort'		=> true, 			
												'attributes'	=> array(
													'class'	=> 'align-left'
												),
												'row' 		=> array(
													'prepend'	=> '',
													'append'	=> '',
													'attributes' => array(
													
													)
												)
											),
											'Equipment.is_archived' => array(
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


