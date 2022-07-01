<?php
	
	namespace Application\Models\Station;

	class EquipmentMeasurement extends \Phalcon\Mvc\Model {

		public $station_equipment_measurement_id;
		public $station_id;
		public $station_equipment_id;
		public $file;
		public $is_archived;
		public $sort_order;
		public $created_on;
		public $updated_on;
		public $created_by_id;
		public $updated_by_id;

		public function initialize ( ) {

			$this->belongsTo( 'station_id', 'Application\Models\Station\Station', 'station_id', array( 
				'alias' 		=> 'Station' 
			));

			$this->belongsTo( 'station_equipment_id', 'Application\Models\Station\Equipment', 'station_equipment_id', array( 
				'alias' 		=> 'Equipment' 
			));

			$this->hasMany( 'station_equipment_measurement_id', 'Application\Models\Station\EquipmentMeasurementParameterLink', 'station_equipment_measurement_id', array( 
				'foreignKey'	=> array(
					'action' => \Phalcon\Mvc\Model\Relation::ACTION_CASCADE
				),
				'alias' => 'EquipmentMeasurementParameterLink' 
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

			return 'pl-wms-station_equipment_measurement';

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

			return $this->station_equipment_measurement_id;

		}

		public function getParameters ( ) {

			$parameters       = array( );
			$measurement_link = $this->modelsManager
				->createBuilder( )
				->addFrom( 'Application\Models\Station\EquipmentMeasurementParameterLink', 'EquipmentMeasurementParameterLink' )
				->leftJoin( 'Application\Models\Station\EquipmentMeasurementParameter', '[EquipmentMeasurementParameterLink].station_equipment_measurement_parameter_id = [EquipmentMeasurementParameter].station_equipment_measurement_parameter_id', 'EquipmentMeasurementParameter' )
				->leftJoin( 'Application\Models\Station\EquipmentMeasurementUnit', '[EquipmentMeasurementParameter].station_equipment_measurement_unit_id = [EquipmentMeasurementUnit].station_equipment_measurement_unit_id', 'EquipmentMeasurementUnit' )
				->where( '[EquipmentMeasurementParameterLink].station_equipment_measurement_id = :station_equipment_measurement_id:', array( 'station_equipment_measurement_id' => $this->getId( ) ) )
				->getQuery( )
				->execute( );

			foreach ( $measurement_link as $link ) {
				$parameters[$parameter->getId( )] = $link;
			}

			return $parameters;

		}

	} // END CLASS EQUIPMENT MEASUREMENT