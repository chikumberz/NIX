<?php

	namespace Application\Libraries\Engine\View;


	class View extends \Phalcon\Mvc\View {

		private $_theme_dir;

	    protected function _engineRender( $engines, $view_path, $silence, $must_clean, $cache ) {

	        $override = $this->getViewOverride( $engines, $view_path );

	        if ( $override ) {
	            $original_view_dir = $this->getViewsDir( );
	            $this->setViewsDir( $override );
	            $return = parent::_engineRender( $engines, $view_path, $silence, $must_clean, $cache );
	            $this->setViewsDir( $original_view_dir );
	            return $return;
	        }

	        return parent::_engineRender( $engines, $view_path, $silence, $must_clean, $cache );

	    }

	    private function getViewOverride ( array $engines, $view_path ) {

	        if ( $this->getCurrentRenderLevel( ) === \Phalcon\Mvc\View::LEVEL_MAIN_LAYOUT ) {
	            $override_view_dir = $this->getThemeDir( );
			} else {
	            return;
	        }

	        foreach ( $engines as $extension => $engine ) {
	            $override = $override_view_dir . $view_path . $extension;

			    if ( is_readable( $override ) ) {
	                return $override_view_dir;
	            }
	        }

	    }

	    public function setThemeDir ( $dir ) {

	        $this->_theme_dir = $dir;

	    }

	    public function getThemeDir ( ) {

	        return $this->_theme_dir;

	    }

	} // END CLASS VIEW