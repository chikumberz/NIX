<?php
	
	namespace Application\Models\Station;

	class EquipmentMeasurementParameterAlertLevel extends \Phalcon\Mvc\Model {

		public $station_equipment_measurement_parameter_alert_level_id;
		public $title;
		public $description;
		public $is_archived;
		public $class;
		public $sort_order;
		public $created_on;
		public $updated_on;
		public $created_by_id;
		public $updated_by_id;

		public function initialize ( ) {

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

			return 'pl-wms-station_equipment_measurement_parameter_alert_level';

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

			return $this->station_equipment_measurement_parameter_alert_level_id;

		}

	} // END CLASS EQUIPMENT MEASUREMENT PARAMETER ALERT LEVEL