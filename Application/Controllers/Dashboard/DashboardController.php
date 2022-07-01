<?php

	namespace Application\Controllers\Dashboard;

	use Application\Models\Station\Station,
		Application\Models\Station\Equipment,
		Application\Models\Station\EquipmentMeasurement,
		Application\Models\Station\EquipmentMeasurementParameter,
		Application\Models\Station\EquipmentMeasurementParameterAlert,
		Application\Models\Station\EquipmentMeasurementParameterGroup;


	/**
	 * Access Control List
	 *
	 * @Acl( "controller" = "Dashboard", "description" = "Dashboard Access." )
	 */

	class DashboardController extends \Application\Controllers\BaseController {

		/**
		 * Set Permission
		 *
		 * @Acl( "key" = "index", "name" = "Index", "description" = "Dashbard Index." )
		 */

		public function indexAction ( ) {

			$language = $this->language->load( 'system', array( 'Dashboard/Common', 'Dashboard/Index' ) );

			$station                                       = Station::Find( array(
				'( is_archived = 0 OR is_archived IS NULL )'
			));
			$station_equipment                             = Equipment::Find( array(
				'( is_archived = 0 OR is_archived IS NULL )'
			));
			$station_equipment_measurement_parameter_group = EquipmentMeasurementParameterGroup::Find( array(
				'( is_archived = 0 OR is_archived IS NULL )',
				'order' => 'sort_order ASC'
			));

			$this->tag->setDefault( 'date_from', 										date( "Y-m-d", strtotime( '-5 day' ) ) );
			$this->tag->setDefault( 'date_to', 											date( "Y-m-d" ) );

			$this->view->setVar( '_', 													$language );
			$this->view->setVar( 'var_station', 										$station );
			$this->view->setVar( 'var_station_equipment', 								$station_equipment );
			$this->view->setVar( 'var_station_equipment_measurement_parameter_group', 	$station_equipment_measurement_parameter_group );

			$this->view->pick( 'Dashboard/Index' );

		}

		public function summaryAction ( ) {

			if ( $this->request->isAjax( ) ) {

				$station_equipment_measurement_parameter_group_id = $this->request->getQuery( 'station_equipment_measurement_parameter_group_id', 'int' );
				$station_id                                       = $this->request->getQuery( 'station_id', 'int' );
				$date_from                                        = $this->request->getQuery( 'date_from', 'string' );
				$date_to                                          = $this->request->getQuery( 'date_to', 'string' );
				
				$station                                          = Station::findFirst( $station_id );
				$station_equipment                                = $station->getEquipments( );
				$station_equipment_measurement_group              = EquipmentMeasurementParameterGroup::findFirst( $station_equipment_measurement_parameter_group_id );
				$station_equipment_measurement_group_link         = $station_equipment_measurement_group->getEquipmentMeasurementParameterGroupLink( );
				
				$station_equipment_measurement_parameter_group  = array( );
				foreach ( $station_equipment_measurement_group_link as $link ) {
					$measurement_parameter = $link->getEquipmentMeasurementParameter( array(
						'( is_archived = 0 OR is_archived IS NULL )'
					));
					if ( is_object( $measurement_parameter ) ) {
	 					if ( $measurement_parameter->hasUserGroup( ) ) {
							$measurement_parameter_unit = $measurement_parameter->getEquipmentMeasurementUnit(array(
								'( is_archived = 0 OR is_archived IS NULL )'
							));

							$station_equipment_measurement_parameter_group[$link->station_equipment_measurement_parameter_id] = array(
								'id'           => $measurement_parameter->getId( ),
								'parameter'    => $measurement_parameter->parameter,
								'code'         => $measurement_parameter->code,
								'default'      => $measurement_parameter->default,
								'min'          => $measurement_parameter->min,
								'max'          => $measurement_parameter->max,
								'unit'         => array(
									'name'         => $measurement_parameter_unit->unit,
									'symbol_left'  => $measurement_parameter_unit->symbol_left,
									'symbol_right' => $measurement_parameter_unit->symbol_right,
								)
							);
						}
					}
				}

				$station_equipment_measurement 	= array( );
				foreach ( $station_equipment as $equipment ) {
					$station_equipment_measurements = $equipment->getMeasurements( array(
						'( is_archived = 0 OR is_archived IS NULL ) AND station_id = :station_id: AND station_equipment_id = :station_equipment_id: AND DATE( created_on ) >= :date_from: AND DATE( created_on ) <= :date_to:',
						'order'	=> 'created_on DESC',
						'bind' => array( 
							'station_id'           => $station->getId( ),
							'station_equipment_id' => $equipment->getId( ),
							'date_from'            => $date_from,
							'date_to'              => $date_to
						)
					));

					foreach ( $station_equipment_measurements as $measurement ) {
						$station_equipment_measurement_link = $measurement->getEquipmentMeasurementParameterLink( );

						foreach ( $station_equipment_measurement_link as $link ) {
							if ( array_key_exists( $link->station_equipment_measurement_parameter_id, $station_equipment_measurement_parameter_group ) ) {
								
								$station_equipment_measurement[$equipment->getId( )][$link->station_equipment_measurement_parameter_id][$measurement->created_on] = array(
									'parameter_id' => $link->station_equipment_measurement_parameter_id,
									'value'        => $link->value,
									'created_on'   => $measurement->created_on
								);
								$station_equipment_measurement_tabular[$equipment->getId( )][$measurement->created_on][$link->station_equipment_measurement_parameter_id] = array(
									'parameter_id' => $link->station_equipment_measurement_parameter_id,
									'value'        => $link->value,
									'created_on'   => $measurement->created_on
								);

								$station_equipment_measurement_graph[$link->getEquipmentMeasurementParameter( )->code][strtotime( $measurement->created_on )] = array( $measurement->created_on, $link->value );
								ksort( $station_equipment_measurement_graph[$link->getEquipmentMeasurementParameter( )->code] );
							}
						}
					}
				}

				$latest_station_equipment_measurement = array( );
				foreach ( $station_equipment as $equipment ) {
					$measurements = $equipment->getMeasurements( array(
						'( is_archived = 0 OR is_archived IS NULL ) AND station_id = :station_id: AND station_equipment_id = :station_equipment_id:',
						'order' => 'created_on DESC',
						'limit'	=> 1,
						'bind' => array( 
							'station_id'           => $station->getId( ),
							'station_equipment_id' => $equipment->getId( ),
						)
					));

					foreach ( $measurements as $measurement ) {
						$latest_station_equipment_measurement_parameter_link = $measurement->getEquipmentMeasurementParameterLink( );
						foreach ( $latest_station_equipment_measurement_parameter_link as $link ) {
							$latest_station_equipment_measurement_parameter_values[$link->station_equipment_measurement_parameter_id] = $link->value;
						}
					}
				}

				$latest_station_equipment_measurement_parameter_alert 			= EquipmentMeasurementParameterAlert::find( );
				$latest_station_equipment_measurement_parameter_alerts 			= array( );
				$_alerts = array( );
				foreach ( $latest_station_equipment_measurement_parameter_alert as $alert ) {
					$latest_station_equipment_measurement_parameter_alert_link 	= $alert->getEquipmentMeasurementParameterAlertLink( );
					$passed = false;
					$_parameters = array( );
					foreach ( $latest_station_equipment_measurement_parameter_alert_link as $alert_link ) {
						if ( array_key_exists( $alert_link->station_equipment_measurement_parameter_id, $latest_station_equipment_measurement_parameter_values ) ) {
							echo $alert_link->getEquipmentMeasurementParameter( )->code . ":";
							if ( $alert_link->comparison ) {
								echo "Max: {$alert_link->max} <= {$latest_station_equipment_measurement_parameter_values[$alert_link->station_equipment_measurement_parameter_id]} && Min: {$alert_link->min} >= {$latest_station_equipment_measurement_parameter_values[$alert_link->station_equipment_measurement_parameter_id]} <br />";
								if ( ( int ) $alert_link->max <= $latest_station_equipment_measurement_parameter_values[$alert_link->station_equipment_measurement_parameter_id]  && ( int ) $alert_link->min >= $latest_station_equipment_measurement_parameter_values[$alert_link->station_equipment_measurement_parameter_id] ) {
									$passed = true;
									$_parameters[$alert_link->getEquipmentMeasurementParameter( )->code] = $latest_station_equipment_measurement_parameter_values[$alert_link->station_equipment_measurement_parameter_id];
								} else {
									$passed = false;
									break;
								}
							} else {
								echo "Min: {$alert_link->min} <= {$latest_station_equipment_measurement_parameter_values[$alert_link->station_equipment_measurement_parameter_id]} && Max: {$alert_link->max} >= {$latest_station_equipment_measurement_parameter_values[$alert_link->station_equipment_measurement_parameter_id]} <br />";
								if ( ( int ) $alert_link->min <= $latest_station_equipment_measurement_parameter_values[$alert_link->station_equipment_measurement_parameter_id]  && ( int ) $alert_link->max >= $latest_station_equipment_measurement_parameter_values[$alert_link->station_equipment_measurement_parameter_id] ) {
									$passed = true;
									$_parameters[$alert_link->getEquipmentMeasurementParameter( )->code] = $latest_station_equipment_measurement_parameter_values[$alert_link->station_equipment_measurement_parameter_id];
								} else {
									$passed = false;
									break;
								}
							}
						}
					}

					if ( $passed == true ) {
						$_level = $alert->getLevel( );
						$_alerts[] = array(
							'title' 		=> $alert->title,
							'description' 	=> $alert->description,
							'level'			=> array(
								'title'			=> $_level->title,
								'description'	=> $_level->description,
								'class'			=> $_level->class,
							), 
							'parameters' 	=> $_parameters
						);
						$latest_station_equipment_measurement_parameter_alerts[] = $alert;
						echo count( $latest_station_equipment_measurement_parameter_alerts ) . "<br />";
					}
				}

				$this->view->setVar( '_', 															$this->language->load( 'system', array( 'Index', 'Dashboard/Common', 'Dashboard/Index' ) ) );
				$this->view->setVar( 'var_station', 												$station );
				$this->view->setVar( 'var_station_equipment', 										$station_equipment );
				$this->view->setVar( 'var_station_equipment_measurement_group', 					$station_equipment_measurement_group );
				$this->view->setVar( 'var_station_equipment_measurement_parameter_group', 			$station_equipment_measurement_parameter_group );
				$this->view->setVar( 'var_station_equipment_measurement', 							$station_equipment_measurement );
				$this->view->setVar( 'var_station_equipment_measurement_tabular', 					$station_equipment_measurement_tabular );
				$this->view->setVar( 'var_station_equipment_measurement_graph', 					$station_equipment_measurement_graph );
				$this->view->setVar( 'var_station_equipment_measurement_parameter_group_ids', 		$station_equipment_measurement_parameter_group_ids );
				$this->view->setVar( 'var_latest_station_equipment_measurement_parameter_alerts', 	$latest_station_equipment_measurement_parameter_alerts );

				$this->view->disableLevel( array(
					\Phalcon\Mvc\View::LEVEL_LAYOUT 		=> true,
					\Phalcon\Mvc\View::LEVEL_MAIN_LAYOUT 	=> true,
				));

				return $this->view->pick( 'Dashboard/Partial/Summary' );

			} 

			$this->view->disable( );
			return $this->response->redirect( array(
				'for' 			=> 'admin-controller',
				'folder'		=> 'dashoard',
				'controller' 	=> 'index',
			));

		}


	} // END CLASS DASHBOARD CONTROLLER