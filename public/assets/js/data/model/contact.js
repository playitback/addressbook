define('model/contact', 
	['backbone', 'model/contact_attribute', 'collection/contact_attribute'], 
	function(Backbone, ContactAttributeModel, ContactAttributeCollection) {
	
	return Backbone.Model.extend({
		
		url: function() {
			return '/api/contact' + (!this.isNew() ? '/' + this.id : '');
		},
		
		parse: function(response) {
			// Parse attributes in to a usable collection
			if(typeof response.attributes == 'object' && 
				typeof response.attributes.length == 'number') {
				var attributeCollection = new ContactAttributeCollection();
					
				for(var i in response.attributes) {
					attributeCollection.add(new ContactAttributeModel(response.attributes[i]));
				}
				
				response.attributes = attributeCollection;
			}
			
			return response;
		},
		
		isValid: function() {
			if(!this.has('first_name') || $.trim(this.get('first_name')).length == 0) {
				return false;	
			}
			
			return true;
		},
		
		/**
		 * Extends the standard Backbone hasChanged method to check wether we've added any attributes
		 */
		hasChanged: function(attributes) {
			if (typeof attributes === 'undefined' || !attributes) {
				var changed = !_.isEmpty(this.changed);
				
				// If we've changed, it could be because we set the attributes collection
				// check for any added attributes
				if(changed && this.has('attributes') && 
					_.size(this.attributes) == 1 && this.get('attributes').length == 0) {
					changed = false;
				}
								
				return changed;
			}
			
			return _.has(this.changed, attr);
		},
		
		photoUrl: function() {
			if(this.has('photo_url')) {
				return this.get('photo_url');
			}
			
			return null;
		},
		
		fullName: function() {
			var nameParts = [];
			
			if(this.has('first_name') && $.trim(this.get('first_name')).length > 0) {
				nameParts.push(this.get('first_name'));
			}
			
			if(this.has('last_name') && $.trim(this.get('last_name')).length > 0) {
				nameParts.push(this.get('last_name'));
			}
			
			// Place holder for new contact
			if(nameParts.length == 0) {
				return 'No name';
			}
			
			return nameParts.join(' ');
		}
		
	});
	
});