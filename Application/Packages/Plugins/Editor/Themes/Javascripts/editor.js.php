jQuery( document ).ready( function ( $ ) {
    $( '.filter-selector' ).on( 'SwitchFilterOut', function ( event, filtername, elem ) {
        if ( filtername == 'editor' ) {
            var editor = tinymce.get( elem.attr( 'id' ) );
            if ( editor ) {
                elem[0].value = editor.getContent( );
                editor.remove( );
            }
        }
    });

    $( '.filter-selector' ).on( 'SwitchFilterIn', function ( event, filtername, elem ) {
        if ( filtername == 'editor' ) {
            try {
                var config = <?php echo json_decode( $_GET['config'] ) ? $_GET['config']: '{}'; ?>;
                config.elements = elem.attr( 'id' );

                tinymce.init( config );
            } catch( error ) {
                if ( typeof( console ) !== 'undefined' ) {
                    console.log( error.message );
                }
            }
        }
    });
});



