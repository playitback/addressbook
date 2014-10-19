define('collection/contact', ['backbone', 'model/contact', 'model/contact_attribute', 'collection/contact_attribute'], function(Backbone, ContactModel) {
	
	return Backbone.Collection.extend({
		
		model: ContactModel,
		url: '/api/contacts'
		
	});
	
});