define('view/addressbook/contacts/contact', ['backbone'], function(Backbone) {
	
	return Backbone.View.extend({
		
		tagName: 'li',
		events: {
			'click': 'handleClick'
		},
		
		initialize: function(options) {
			this.model = options && options.model || null;
			
			this.$el.append(
				$('<a></a>')
			);
		},
		
		render: function() {
			this.$el.find('a').text(this.model.fullName());
						
			if(this.$el.parents('section#contacts ul').length === 0) {
				$('section#contacts ul li.add').before(this.$el);
			}
		},
		
		handleClick: function() {
			this.trigger('click', this.model);
		}
		
	});
	
});