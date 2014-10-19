define('collection/group', ['backbone', 'model/group'], function(Backbone, GroupModel) {
	
	return Backbone.Collection.extend({
		
		model: GroupModel,
		url: '/api/groups'
		
	});
	
});