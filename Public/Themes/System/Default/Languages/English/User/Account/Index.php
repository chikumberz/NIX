<?php

	$_['text_title'] 					= 'User Accounts';
	$_['text_description'] 				= 'A user account is a collection of information that tells the system which page and files you can access, what changes you can make to the system.';

	$_['table_grid_structure']			= array(
											'Profile.first_name' 	=> array(
												'column'	=> 'Profile.first_name',
												'text' 		=> 'First Name',
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
											'Profile.last_name' 	=> array(
												'column'	=> 'Profile.last_name',
												'text' 		=> 'Last Name',	
												'sort'		=> true, 
												'attributes'	=> array(
													'class'	=> 'align-left'
												),
											),
											'Account.username' 				=> array(
												'column'	=> 'username',
												'text' 		=> 'Username',	
												'sort'		=> true, 
												'attributes'	=> array(
													'class'	=> 'align-left'
												),
											),
											'Account.email' 				=> array(
												'column'	=> 'email',
												'text' 		=> 'Email',		
												'sort'		=> true, 
												'attributes'	=> array(
													'class'	=> 'align-left'
												),
											),
											'Account.is_archived' 			=> array(
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


