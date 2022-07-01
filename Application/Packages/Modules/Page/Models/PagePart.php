<?php

	namespace Application\Packages\Modules\Page\Models;

	class PagePart extends \Application\Libraries\Engine\Model\Model {

		public $page_part_id;
		public $page_id;
		public $filter_id;
		public $last_name;
		public $name;
		public $content;
		public $content_html;

		public function getSource ( ) {

			return 'mod-page_part';

		}

		public function initialize ( ) {

			$this->belongsTo( 'page_id', 'Application\Packages\Modules\Page\Models\Page', 'page_id', array(
				'alias' => 'Page'
			));

			$this->useDynamicUpdate( true );

		}

		public function getContent ( ) {

			return $this->content;

		}

	} // END CLASS PROFILE
