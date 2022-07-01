<?php

	$_['text_title'] 					= 'Countries';
	$_['text_description'] 				= '';

	$_['table_grid_structure']			= array(
											'Country.country' 	=> array(
												'column'	=> 'country',
												'text' 		=> 'Country',
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
											'Country.iso_code_2' 	=> array(
												'column'	=> 'iso_code_2',
												'text' 		=> 'ISO Code II',
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
											'Country.iso_code_3' 	=> array(
												'column'	=> 'iso_code_3',
												'text' 		=> 'ISO Code III',
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
											'Country.is_archived' => array(
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


