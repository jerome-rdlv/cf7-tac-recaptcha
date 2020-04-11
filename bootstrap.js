
( function( grecaptcha, sitekey, actions ) {

	var wpcf7recaptcha = {

		execute: function( action ) {
			grecaptcha.execute(
				sitekey,
				{ action: action }
			).then( function( token ) {
				var forms = document.getElementsByTagName( 'form' );

				for ( var i = 0; i < forms.length; i++ ) {
					var fields = forms[ i ].getElementsByTagName( 'input' );

					for ( var j = 0; j < fields.length; j++ ) {
						var field = fields[ j ];

						if ( 'g-recaptcha-response' === field.getAttribute( 'name' ) ) {
							field.setAttribute( 'value', token );
							break;
						}
					}
				}
			} );
		},

		executeOnHomepage: function() {
			wpcf7recaptcha.execute( actions[ 'homepage' ] );
		},

		executeOnContactform: function() {
			wpcf7recaptcha.execute( actions[ 'contactform' ] );
		},

	};

	grecaptcha.ready(
		wpcf7recaptcha.executeOnHomepage
	);

	document.addEventListener( 'change',
		wpcf7recaptcha.executeOnContactform, false
	);

	document.addEventListener( 'wpcf7submit',
		wpcf7recaptcha.executeOnHomepage, false
	);

} )(
	grecaptcha,
	'6LcMXN4UAAAAAEWHaXATt63r8CGrTVjghShHrszg',
	{"homepage":"homepage","contactform":"contactform"}
);

