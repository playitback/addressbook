requirejs.config({
	
	baseUrl: './assets/js/lib',
	paths: {
		model: '../data/model',
		collection: '../data/collection',
		view: '../view',
		const: '../data/const'
	}
	
});

requirejs(['underscore', 'backbone', 'jquery'], function(_, Backbone, $) {
	require(['view/addressbook'], function(AddressBookView) {
		new AddressBookView().render();
	});
});