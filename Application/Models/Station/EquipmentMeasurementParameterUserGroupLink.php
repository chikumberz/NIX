<?php

	namespace Application\Models\Station;

	class EquipmentMeasurementParameterUserGroupLink extends \Phalcon\Mvc\Model {

		public $station_measurement_parameter_user_group_link_id;
		public $station_measurement_parameter_id;
		public $user_group_id;


		public function initialize ( ) {

			$this->belongsTo( 'station_measurement_parameter_id', 'Application\Models\Station\EquipmentMeasurementParameter', 'station_measurement_parameter_id', array( 
				'foreignKey'	=> array(
					'action' => \Phalcon\Mvc\Model\Relation::ACTION_CASCADE
				),
				'alias' 		=> 'EquipmentMeasurementParameter' 
			));

			$this->belongsTo( 'user_group_id', 'Application\Models\User\Group', 'user_group_id', array( 
				'foreignKey'	=> array(
					'action' => \Phalcon\Mvc\Model\Relation::ACTION_CASCADE
				),
				'alias' 		=> 'Group' 
			));

			$this->useDynamicUpdate( true );
		
		}

		public function getSource ( ) {

			return 'pl-wms-station_equipment_measurement_parameter_user_group_link';

		}

	} // END CLASS EQUIPMENT MEASUREMENT PARAMETER USER GROUP LINK