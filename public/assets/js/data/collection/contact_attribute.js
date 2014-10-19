define('collection/contact_attribute', ['backbone', 'model/contact_attribute'], function(Backbone, ContactAttributeModel) {
	
	return Backbone.Collection.extend({
		
		model: ContactAttributeModel
		
	});
	
});