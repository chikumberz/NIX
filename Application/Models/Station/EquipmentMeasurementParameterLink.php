<?php

	namespace Application\Models\Station;

	class EquipmentMeasurementParameterLink extends \Phalcon\Mvc\Model {

		public $station_equipment_measurement_parameter_link_id;
		public $station_equipment_measurement_id;
		public $station_equipment_measurement_parameter_id;
		public $value;


		public function initialize ( ) {

			$this->belongsTo( 'station_equipment_measurement_id', 'Application\Models\Station\EquipmentMeasurement', 'station_equipment_measurement_id', array( 
				'foreignKey'	=> array(
					'action' => \Phalcon\Mvc\Model\Relation::ACTION_CASCADE
				),
				'alias' 		=> 'EquipmentMeasurement' 
			));

			$this->belongsTo( 'station_equipment_measurement_parameter_id', 'Application\Models\Station\EquipmentMeasurementParameter', 'station_equipment_measurement_parameter_id', array( 
				'alias' 		=> 'EquipmentMeasurementParameter' 
			));

			$this->useDynamicUpdate( true );
		
		}

		public function getSource ( ) {

			return 'pl-wms-station_equipment_measurement_parameter_link';

		}

		public function getId ( ) {

			return $this->station_equipment_measurement_parameter_link_id;

		}

	} // END CLASS EQUIPMENT MEASUREMENT PARAMETER LINK