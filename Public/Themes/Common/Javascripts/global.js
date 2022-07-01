jQuery( 'document' ).ready( function ( $ ) {

	$( 'input.toggle-check' ).on( 'click', function ( ) {

		var self 	= $( this ),
			objects = $( 'input.' + self.attr( 'id' ) ),
			check  	= false;

		if ( this.checked )
			check = true;

		objects.each ( function ( ) {
			this.checked = check;
		});

	});

	/*
	var scrollbar = new IScroll( '.scrollable', {
		scrollbars: true,
		mouseWheel: true,
		interactiveScrollbars: true,
		shrinkScrollbars: 'scale',
		fadeScrollbars: true
	});

	document.addEventListener( 'touchmove', function (e) { e.preventDefault(); }, false );
	*/
});


