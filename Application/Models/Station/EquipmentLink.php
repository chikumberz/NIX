<?php
	
	namespace Application\Models\Station;

	class EquipmentLink extends \Phalcon\Mvc\Model {

		public $station_equipment_link_id;
		public $station_id;
		public $station_equipment_id;
		public $station_equipment_serial_no;
		public $ftp_location;

		public function initialize ( ) {

			$this->belongsTo( 'station_id', 'Application\Models\Station\Station', 'station_id', array( 
				'foreignKey'	=> array(
					'action' => \Phalcon\Mvc\Model\Relation::ACTION_CASCADE
				),
				'alias' => 'Station' 
			));

			$this->belongsTo( 'station_equipment_id', 'Application\Models\Station\Equipment', 'station_equipment_id', array( 
				'foreignKey'	=> array(
					'action' => \Phalcon\Mvc\Model\Relation::ACTION_CASCADE
				),
				'alias' => 'Equipment' 
			));

			$this->useDynamicUpdate( true );

		}

		public function getSource ( ) {

			return 'pl-wms-station_equipment_link';

		}

		public function getId ( ) {

			return $this->station_equipment_link_id;

		}

	} // END CLASS EQUIPMENT LINK