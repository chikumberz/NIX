<?php
	
	namespace Application\Models\Station;

	class EquipmentMeasurementParameter extends \Phalcon\Mvc\Model {

		public $station_equipment_measurement_parameter_id;
		public $station_equipment_measurement_unit_id;
		public $station_equipment_id;
		public $parameter;
		public $code;
		public $min;
		public $max;
		public $default;
		public $is_archived;
		public $sort_order;
		public $created_on;
		public $updated_on;
		public $created_by_id;
		public $updated_by_id;

		public function initialize ( ) {

			$this->belongsTo( 'station_equipment_measurement_unit_id', 'Application\Models\Station\EquipmentMeasurementUnit', 'station_equipment_measurement_unit_id', array( 
				'foreignKey'	=> array(
					'action' => \Phalcon\Mvc\Model\Relation::ACTION_CASCADE
				),
				'alias' => 'EquipmentMeasurementUnit' 
			));


			$this->belongsTo( 'station_equipment_id', 'Application\Models\Station\Equipment', 'station_equipment_id', array( 
				'foreignKey'	=> array(
					'action' => \Phalcon\Mvc\Model\Relation::ACTION_CASCADE
				),
				'alias' 		=> 'Equipment' 
			));

			$this->hasMany( 'station_equipment_measurement_parameter_id', 'Application\Models\Station\EquipmentMeasurementParameterUserGroupLink', 'station_equipment_measurement_parameter_id', array( 
				'foreignKey'	=> array(
					'action' => \Phalcon\Mvc\Model\Relation::ACTION_CASCADE
				),
				'alias' => 'EquipmentMeasurementParameterUserGroupLink' 
			));

			$this->useDynamicUpdate( true );

			$this->skipAttributesOnCreate( array(
				'update_on',
				'updated_by_id'
			));

			$this->skipAttributesOnUpdate( array(
				'created_on',
				'created_by_id'
			));

		}

		public function getSource ( ) {

			return 'pl-wms-station_equipment_measurement_parameter';

		}

		public function beforeValidationOnCreate ( ) {

			$this->beforeCreate( );

		}

		public function beforeValidationOnUpdate ( ) {

			$this->beforeUpdate( );

		}

		public function beforeCreate ( ) {

			$auth = \Phalcon\DI\FactoryDefault::getDefault( )->get( 'auth' )->getIdentity( );

			$this->created_on 		= date( 'Y-m-d H:i:s' );
			$this->created_by_id 	= ( int ) $auth['id'];

		}

		public function beforeUpdate ( ) {

			$auth = \Phalcon\DI\FactoryDefault::getDefault( )->get( 'auth' )->getIdentity( );

			$this->updated_on 		= date( 'Y-m-d H:i:s' );
			$this->updated_by_id 	= ( int ) $auth['id'];

		}

		public function getId ( ) {

			return $this->station_equipment_measurement_parameter_id;

		}

		public function getUserGroup ( ) {

			return $this->getEquipmentMeasurementParameterUserGroupLink( );
		}

		public function hasUserGroup ( ) {

			$user_group = $this->countEquipmentMeasurementParameterUserGroupLink( array( 
				'user_group_id = ?0',
				'limit' 	=> 1,
				'bind'	 	=> array( 
					0 		=> ( int ) 1
				)
			));
			
			return ( $user_group ) ? true : false;

		}

	} // END CLASS EQUIPMENT MEASUREMENT PARAMETER