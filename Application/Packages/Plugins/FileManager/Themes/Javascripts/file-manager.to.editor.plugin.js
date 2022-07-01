/**
 * plugin.js
 *
 * Copyright, Benjamin Taluyo
 */

tinymce.PluginManager.add( 'filemanager', function( editor ) {

	tinymce.activeEditor.settings.file_browser_callback = filemanager;

	function filemanager_onMessage ( event ) {
		if ( editor.settings.external_filemanager_path.toLowerCase( ).indexOf( event.origin.toLowerCase( ) ) === 0 ) {
			if ( event.data.sender === 'filemanager' ) {
				tinymce.activeEditor.windowManager.getParams( ).setUrl( event.data.url );
				tinymce.activeEditor.windowManager.close( );

				// Remove event listener for a message from ResponsiveFilemanager
				if ( window.removeEventListener ) {
					window.removeEventListener( 'message', filemanager_onMessage, false );
				} else {
					window.detachEvent( 'onmessage', filemanager_onMessage );
				}
			}
		}
	}

	function filemanager ( id, value, type, win ) {

		var width 	= window.innerWidth - 30;
		var height 	= window.innerHeight - 60;

		if ( width > 1800 )  width = 1800;
		if ( height > 1200 ) height = 1200;

		if( width > 600 ) {
			var width_reduce = ( width - 20 ) % 138;
			width = width - width_reduce + 10;
		}

		if ( type == 'image' ) {
			type = '&type=' + 2;
		} else if ( type == 'media' ) {
			type = '&type=' + 3;
		} else {
			type = '&type=' + 2;
		}

		var title = 'File Manager';

		if ( typeof editor.settings.filemanager_title !== 'undefined' && editor.settings.filemanager_title ) {
			title = editor.settings.filemanager_title;
		}

		var sort_by = '';

		if ( typeof editor.settings.filemanager_sort_by !== 'undefined' && editor.settings.filemanager_sort_by ) {
			sort_by = '&sort_by=' + editor.settings.filemanager_sort_by;
		}
		var sort_order = 0;

		if ( typeof editor.settings.filemanager_sort_order !== 'undefined' && editor.settings.filemanager_sort_order ) {
			sort_order = '&sort_order=' + editor.settings.filemanager_sort_order;
		}

		var fldr = '';

		if ( typeof editor.settings.filemanager_folder !== 'undefined' && editor.settings.filemanager_folder ) {
			fldr = '&fldr=' + editor.settings.filemanager_folder;
		}

		var crossdomain = '';

		if ( typeof editor.settings.filemanager_crossdomain !== 'undefined' && editor.settings.filemanager_crossdomain ) {
			crossdomain = '&crossdomain=1';

			// Add handler for a message from ResponsiveFilemanager
			if( window.addEventListener ){
				window.addEventListener( 'message', filemanager_onMessage, false );
			} else {
				window.attachEvent( 'onmessage', filemanager_onMessage );
			}
		}

		tinymce.activeEditor.windowManager.open({
			title: title,
			file: editor.settings.filemanager_path + '?popup=1' + type + sort_order + sort_by + fldr + crossdomain,
			width: width,
			height: height,
			resizable: true,
			maximizable: true,
			inline: 1
		}, {
			setUrl: function ( url ) {
				var field_element 	= win.document.getElementById( id );
				field_element.value = editor.convertURL( url );

				if ( 'fireEvent' in field_element ) {
					field_element.fireEvent( 'onchange' );
				} else {
					var evt = document.createEvent( 'HTMLEvents' );

					evt.initEvent( 'change', false, true );
					field_element.dispatchEvent( evt );
				}
			}
		});
	};

	return false;
});