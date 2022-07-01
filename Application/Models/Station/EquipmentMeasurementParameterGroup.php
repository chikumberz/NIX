<?php
	
	namespace Application\Models\Station;

	class EquipmentMeasurementParameterGroup extends \Phalcon\Mvc\Model {

		public $station_equipment_measurement_parameter_group_id;
		public $title;
		public $description;
		public $is_archived;
		public $sort_order;
		public $created_on;
		public $updated_on;
		public $created_by_id;
		public $updated_by_id;

		public function initialize ( ) {

			$this->hasMany( 'station_equipment_measurement_parameter_group_id', 'Application\Models\Station\EquipmentMeasurementParameterGroupLink', 'station_equipment_measurement_parameter_group_id', array( 
				'foreignKey'	=> array(
					'action' => \Phalcon\Mvc\Model\Relation::ACTION_CASCADE
				),
				'alias' => 'EquipmentMeasurementParameterGroupLink' 
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

			return 'pl-wms-station_equipment_measurement_parameter_group';

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

			return $this->station_equipment_measurement_parameter_group_id;

		}

		public function getParameters ( ) {

			$group_link = $this->getEquipmentMeasurementParameterGroupLink( );
			$parameters = array( );

			foreach ( $group_link as $link ) {
				$parameter = $link->getParameter( );

				if ( $parameter->hasUserGroup( 1 ) ) {
					$parameters[$parameter->getId( )] = $parameter;
				}
			}

			return $parameters;

		}

	} // END CLASS EQUIPMENT MEASUREMENT PARAMETER GROUP