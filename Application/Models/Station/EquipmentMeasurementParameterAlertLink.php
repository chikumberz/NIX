<?php

	namespace Application\Models\Station;

	class EquipmentMeasurementParameterAlertLink extends \Phalcon\Mvc\Model {

		public $station_equipment_measurement_parameter_alert_link_id;
		public $station_equipment_measurement_parameter_alert_id;
		public $station_equipment_measurement_parameter_id;
		public $min;
		public $max;
		public $comparison;

		public function initialize ( ) {

			$this->belongsTo( 'station_equipment_measurement_parameter_alert_id', 'Application\Models\Station\EquipmentMeasurementParameterAlert', 'station_equipment_measurement_parameter_alert_id', array( 
				'foreignKey'	=> array(
					'action' => \Phalcon\Mvc\Model\Relation::ACTION_CASCADE
				),
				'alias' 		=> 'EquipmentMeasurementParameterAlert' 
			));

			$this->belongsTo( 'station_equipment_measurement_parameter_id', 'Application\Models\Station\EquipmentMeasurementParameter', 'station_equipment_measurement_parameter_id', array( 
				'alias' 		=> 'EquipmentMeasurementParameter' 
			));

			$this->useDynamicUpdate( true );
		
		}

		public function getSource ( ) {

			return 'pl-wms-station_equipment_measurement_parameter_alert_link';

		}

		public function getId ( ) {

			return $this->station_equipment_measurement_parameter_alert_link_id;

		}

	} // END CLASS MEASUREMENTELEMENTALERTRELATION