<?php

	namespace Application\Models\Station;

	class EquipmentMeasurementParameterGroupLink extends \Phalcon\Mvc\Model {

		public $station_equipment_measurement_parameter_group_link_id;
		public $station_equipment_measurement_parameter_group_id;
		public $station_equipment_measurement_parameter_id;


		public function initialize ( ) {

			$this->belongsTo( 'station_equipment_measurement_parameter_group_id', 'Application\Models\Station\EquipmentMeasurementParamenterGroup', 'station_equipment_measurement_parameter_group_id', array( 
				'foreignKey'	=> array(
					'action' => \Phalcon\Mvc\Model\Relation::ACTION_CASCADE
				),
				'alias' 		=> 'EquipmentMeasurementParamenterGroup' 
			));

			$this->belongsTo( 'station_equipment_measurement_parameter_id', 'Application\Models\Station\EquipmentMeasurementParameter', 'station_equipment_measurement_parameter_id', array( 
				'alias' 		=> 'EquipmentMeasurementParameter' 
			));

			$this->useDynamicUpdate( true );
		
		}

		public function getSource ( ) {

			return 'pl-wms-station_equipment_measurement_parameter_group_link';

		}

		public function getId ( ) {

			return $this->station_equipment_measurement_parameter_group_link_id;

		}

		public function getParameter ( ) {

			return $link->getEquipmentMeasurementParameter( );

		}

	} // END CLASS MEASUREMENTELEMENTGROUPRELATION