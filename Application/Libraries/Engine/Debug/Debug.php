<?php

    namespace Application\Libraries\Engine\Debug;

    class Debug extends \Phalcon\Debug {
        
        public function listenLowSeverity ( ) {

            set_error_handler( array( $this, 'onUncaughtLowSeverity' ) );

            register_shutdown_function( function ( ) {
                
                $error = error_get_last( );

                if ( $error && ( $error['type'] == E_ERROR ) ) {
                    $this->onUncaughtLowSeverity( $error['type'], $error['message'], $error['file'], $error['line'] );
                }

            });

            return $this;

        }

        public function onUncaughtLowSeverity ( $error_number, $error_string, $error_file, $error_line ) {

            /**
             * Cancel the output buffer if active
             */
            if ( ob_get_level( ) > 0 ) {
                ob_end_clean( );
            }

            /**
             * Avoid that multiple errors being showed
             */
            if (self::$_isActive) {
                echo $error_string;
            }

            /**
             * Globally block the debug component to avoid other errors must be shown
             */
            self::$_isActive = true;

            switch ( $error_number ) {
                case E_ERROR:
                    $error_title = 'Fatal error';
                    break;
                case E_WARNING:
                    $error_title = 'Warning';
                    break;
                case E_PARSE:
                    $error_title = 'Parse error';
                    break;
                case E_NOTICE:
                    $error_title = 'Notice';
                    break;
                case E_CORE_ERROR:
                    $error_title = 'Core error';
                    break;
                case E_CORE_WARNING:
                    $error_title = 'Core warning';
                    break;
                case E_COMPILE_ERROR:
                    $error_title = 'Compile error';
                    break;
                case E_COMPILE_WARNING:
                    $error_title = 'Compile warning';
                    break;
                case E_USER_ERROR:
                    $error_title = 'User error';
                    break;
                case E_USER_WARNING:
                    $error_title = 'User warning';
                    break;
                case E_USER_NOTICE:
                    $error_title = 'User notice';
                    break;
                case E_STRICT:
                    $error_title = 'Strict';
                    break;
                case E_RECOVERABLE_ERROR:
                    $error_title = 'Fatal error';
                    break;
                case E_DEPRECATED:
                    $error_title = 'Deprecated';
                    break;
                case E_USER_DEPRECATED:
                    $error_title = 'User deprecated';
                    break;
                default:
                    $error_title = 'Unknown error';
            }

            /**
             * Escape the error's message avoiding possible XSS injections?
             */
            $error_string = htmlspecialchars( $error_string, ENT_QUOTES );

            /**
             * Use the error info as document's title
             */
            $html  = '<html><head><title>PHP ' . $error_title . ': ' . $error_string . '</title>' . $this->getCssSources( ) . '</head><body>';

            /**
             * Get the version link
             */
            $html .= $this->getVersion( );

            /**
             * Main error info
             */
            $html .= '<div align="center"><div class="error-main">';
            $html .= '<h1>PHP ' . $error_title .  ': ' . $error_string . '</h1>';
            $html .= '<span class="error-file">' . $error_file . ' (' . $error_line . ')</span>';
            $html .= '</div>';

            /**
             * Check if the developer wants to show the backtrace or not
             */
            if ( $this->_showBackTrace ) {
                /**
                 * Create the tabs in the page
                 */
                $html .= '<div class="error-info"><div id="tabs"><ul>';
                $html .= '<li><a href="#error-tabs-1">Backtrace</a></li>';
                $html .= '<li><a href="#error-tabs-2">Request</a></li>';
                $html .= '<li><a href="#error-tabs-3">Server</a></li>';
                $html .= '<li><a href="#error-tabs-4">Included Files</a></li>';
                $html .= '<li><a href="#error-tabs-5">Memory</a></li>';

                if ( is_array( $this->_data ) ) {
                    $html .= '<li><a href="#error-tabs-6">Variables</a></li>';
                }

                $html .= '</ul>';

                /**
                 * Print backtrace
                 */
                $html .= '<div id="error-tabs-1"><table cellspacing="0" align="center" width="100%">';

                if ( $error_number == E_ERROR ) {
                    $html .= $this->showTraceItem( 0, array('file' => $error_file, 'line' => $error_line, 'function' => 'Fatal error:' ) );
                } else {
                    $trace = debug_backtrace( );

                    foreach ( $trace as $key => $line ) {
                        if ( $key === 0 ) {
                            continue;
                        }

                        /**
                         * Every line in the trace is rendered using 'showTraceItem'
                         */
                        $html .= $this->showTraceItem( $key, $line );
                    }
                }


                $html .= '</table></div>';

                /**
                 * Print _REQUEST superglobal
                 */
                $html .= '<div id="error-tabs-2"><table cellspacing="0" align="center" class="superglobal-detail">';
                $html .= '<tr><th>Key</th><th>Value</th></tr>';

                foreach ( $_REQUEST as $key => $value ) {
                    $html .= '<tr><td class="key">' . $key . '</td><td>' . htmlspecialchars( $value, ENT_QUOTES ) . '</td></tr>';
                }

                $html .= '</table></div>';

                /**
                 * Print _SERVER superglobal
                 */
                $html .= '<div id="error-tabs-3"><table cellspacing="0" align="center" class="superglobal-detail">';
                $html .= '<tr><th>Key</th><th>Value</th></tr>';

                foreach ( $_SERVER as $key => $value ) {
                    $html .= '<tr><td class="key">' . $key . '</td><td>' . htmlspecialchars( $value, ENT_QUOTES ) . '</td></tr>';
                }

                $html .= '</table></div>';

                /**
                 * Show included files
                 */
                $files = get_included_files( );

                $html .= '<div id="error-tabs-4"><table cellspacing="0" align="center" class="superglobal-detail">';
                $html .= '<tr><th>#</th><th>Path</th></tr>';

                foreach ( $files as $key => $value ) {
                    $html .= '<tr><td>' . $key . '</td><td>' . $value . '</td></tr>';
                }

                $html .= '</table></div>';

                /**
                 * Memory usage
                 */
                $memory = memory_get_usage( true );

                $html .= '<div id="error-tabs-5"><table cellspacing="0" align="center" class="superglobal-detail">';
                $html .= '<tr><th colspan=\"2\">Memory</th></tr><tr><td>Usage</td><td>' . $memory . '</td></tr>';

                $html .= '</table></div>';

                /**
                 * Print extra variables passed to the component
                 */
                if ( is_array( $this->_data ) ) {
                    $html .= '<div id="error-tabs-6"><table cellspacing="0" align="center" class="superglobal-detail">';
                    $html .= '<tr><th>Key</th><th>Value</th></tr>';

                    foreach ( $this->_data as $key => $value ) {

                        $html .= '<tr><td class="key">' . $key . '</td><td>' . $this->_getVarDump( $value[0] ) . '</td></tr>';
                    
                    }

                    $html .= '</table></div>';
                }

                $html .= '</div>';
            }

            /**
             * Get Javascript sources
             */
            $html .= $this->getJsSources( ) . '</div></body></html>';

            /**
             * Print the HTML, @TODO, add an option to store the html
             */
            echo $html;

            /**
             * Unlock the exception renderer
             */
            self::$_isActive = false;

            exit( );

        }

    } // END CLASS Debug