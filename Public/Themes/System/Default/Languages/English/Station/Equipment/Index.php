<?php

	$_['text_title'] 					= 'Equipements';
	$_['text_description'] 				= '';

	$_['table_grid_structure']			= array(
											'Equipment.name' 	=> array(
												'column'	=> 'name',
												'text' 		=> 'Name',
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


