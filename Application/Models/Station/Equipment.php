<?php
	
	namespace Application\Models\Station;

	class Equipment extends \Phalcon\Mvc\Model {

		public $station_equipment_id;
		public $name;
		public $is_archived;
		public $sort_order;
		public $created_on;
		public $updated_on;
		public $created_by_id;
		public $updated_by_id;

		public function initialize ( ) {

			$this->hasMany( 'station_equipment_id', 'Application\Models\Station\EquipmentLink', 'station_equipment_id', array( 
				'foreignKey'	=> array(
					'action' => \Phalcon\Mvc\Model\Relation::ACTION_CASCADE
				),
				'alias' => 'EquipmentLink' 
			));

			$this->hasMany( 'station_equipment_id', 'Application\Models\Station\EquipmentMeasurementParameter', 'station_equipment_id', array( 
				'foreignKey'	=> array(
					'action' => \Phalcon\Mvc\Model\Relation::ACTION_CASCADE
				),
				'alias' => 'EquipmentMeasurementParameter' 
			));

			$this->hasMany( 'station_equipment_id', 'Application\Models\Station\EquipmentMeasurement', 'station_equipment_id', array( 
				'foreignKey'	=> array(
					'action' => \Phalcon\Mvc\Model\Relation::ACTION_CASCADE
				),
				'alias' => 'EquipmentMeasurement' 
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

			return 'pl-wms-station_equipment';

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

			return $this->station_equipment_id;

		}

		public function getParameters ( ) {

			return $this->getEquipmentMeasurementParameter( array(  
				'( is_archived = 0 OR is_archived IS NULL )'
			));

		}

		public function getMeasurements ( $parameter ) {

			return $this->getEquipmentMeasurement( $parameter );

		}

	} // END CLASS EQUIPMENT