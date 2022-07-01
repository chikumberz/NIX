<?php

	namespace Application\Controllers\Station;

	use \Phalcon\Paginator\Adapter\QueryBuilder as AdapterPaginator;

	use \Phalcon\Validation,
		\Phalcon\Validation\Validator\PresenceOf,
		\Phalcon\Validation\Validator\Email,
		\Phalcon\Validation\Validator\Identical,
		\Phalcon\Validation\Validator\StringLength,
		\Phalcon\Validation\Validator\Confirmation,
		\Phalcon\Validation\Validator\Regex,
		\Phalcon\Validation\Validator\InclusionIn;

	use \Application\Libraries\Engine\Paginator\Paginator;

	use Application\Models\Station\Station,
		Application\Models\Station\Equipment,
		Application\Models\Station\EquipmentMeasurement,
		Application\Models\Station\EquipmentMeasurementParameter,
		Application\Models\Station\EquipmentMeasurementParameterAlert,
		Application\Models\Station\EquipmentMeasurementParameterGroup;


	class ApiController extends \Application\Controllers\BaseController {

		public function alertAction ( ) {

			$station_id                                       = $this->request->getPost( 'station_id', 'int' );

			$station                                          = Station::findFirst( ( int ) $station_id );
			
			if ( is_object( $station ) ) {
				$station_equipment                            = $station->getEquipments( );

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
									$_parameter = $alert_link->getEquipmentMeasurementParameter( );
									$_unit 		= $_parameter->getEquipmentMeasurementUnit( );
									$_parameters[$_parameter->code] = array( 
										'value' 		=> $latest_station_equipment_measurement_parameter_values[$alert_link->station_equipment_measurement_parameter_id],
										'unit'			=> $_unit->unit,
										'symbol_left'	=> $_unit->symbol_left,
										'symbol_right'	=> $_unit->symbol_right,
									);
								} else {
									$passed = false;
									break;
								}
							} else {
								echo "Min: {$alert_link->min} <= {$latest_station_equipment_measurement_parameter_values[$alert_link->station_equipment_measurement_parameter_id]} && Max: {$alert_link->max} >= {$latest_station_equipment_measurement_parameter_values[$alert_link->station_equipment_measurement_parameter_id]} <br />";
								if ( ( int ) $alert_link->min <= $latest_station_equipment_measurement_parameter_values[$alert_link->station_equipment_measurement_parameter_id]  && ( int ) $alert_link->max >= $latest_station_equipment_measurement_parameter_values[$alert_link->station_equipment_measurement_parameter_id] ) {
									$passed = true;
									$_parameter = $alert_link->getEquipmentMeasurementParameter( );
									$_unit 		= $_parameter->getEquipmentMeasurementUnit( );
									$_parameters[$_parameter->code] = array( 
										'value' 		=> $latest_station_equipment_measurement_parameter_values[$alert_link->station_equipment_measurement_parameter_id],
										'unit'			=> $_unit->unit,
										'symbol_left'	=> $_unit->symbol_left,
										'symbol_right'	=> $_unit->symbol_right,
									);
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
			}

			$response = array(
				'name'     		=> $station->name,
				'location' 		=> $station->location,
				'alerts'		=> $_alerts,
				'alerts_cnt'	=> count( $_alerts )
			);

			echo "<pre>";
			print_r( $response );
			echo "</pre>";
			// exit();

			return $this->response->setJsonContent( $response );

		}

	} // END CLASS API