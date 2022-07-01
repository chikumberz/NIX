<?php
	
	namespace Application\Models\Station;

	use Application\Models\Station\EquipmentMeasurement,
		Application\Models\Station\EquipmentMeasurementParameter,
		Application\Models\Station\EquipmentMeasurementParameterGroup;

	class Station extends \Phalcon\Mvc\Model {

		public $station_id;
		public $name;
		public $location;
		public $head_name;
		public $head_position;
		public $is_archived;
		public $sort_order;
		public $created_on;
		public $updated_on;
		public $created_by_id;
		public $updated_by_id;

		public function initialize ( ) {

			$this->hasMany( 'station_id', 'Application\Models\Station\EquipmentLink', 'station_id', array( 
				'foreignKey'	=> array(
					'action' => \Phalcon\Mvc\Model\Relation::ACTION_CASCADE
				),
				'alias' => 'EquipmentLink' 
			));

			$this->hasMany( 'station_id', 'Application\Models\Station\EquipmentMeasurement', 'station_id', array( 
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

			return 'pl-wms-station';

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

			return $this->station_id;

		}

		public function getEquipments ( ) {

			$equipment_link = $this->getEquipmentLink( );
			$equipments     = array( );

			foreach ( $equipment_link as $link ) {
				$equipments[] = $link->getEquipment( ); 
			}

			return $equipments;

		}
		
		public function getEquipmentParameters ( ) {

			$parameters = array( );

			foreach ( $this->getEquipments( ) as $equipment ) {
				foreach ( $equipment->getParameters( ) as $parameter ) {
					$parameters[$parameter->getId( )] = $parameter;
				}
			}

			return $parameters;

		}

	} // END CLASS TYPE