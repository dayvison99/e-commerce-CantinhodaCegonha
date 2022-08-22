( function( api ) {

	// Extends our custom "storebiz" section.
	api.sectionConstructor['storebiz'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );