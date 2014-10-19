define('view/addressbook/info/attribute', 
	['backbone', 'const/attribute_types', 'jquery.chosen'], 
	function(Backbone, AttributeTypes, jQueryChosen) {
	
	return Backbone.View.extend({
		
		className: 'attribute',
		
		initialize: function(options) {
			this.model = options && options.model || null;
			this.editable = options && options.editable || false;
			
			if(!this.model || typeof this.model != 'object') {
				throw 'Invalid model passed to address book attribute view';
			}
		},
		
		render: function() {
			if(this.editable) {
				this.$el.append(
					$('<a></a>', { 'class': 'btn remove', text: '-' })
				);
				
				var labelSelectField = $('<select></select>');
				
				for(var key in AttributeTypes) {
					labelSelectField.append(
						$('<option></option>', { value: key, text: AttributeTypes[key] })	
					);
				}
				
				this.$el.append(labelSelectField);
				
				var type = this.typeForLabel();
				
				if(type == 'textarea') {
					this.$el.append(
						$('<textarea></textarea>', { val: this.model.get('value') })
					);
				}
				else {
					this.$el.append(
						$('<input />', { type: type , val: this.model.get('value') })
					);
				}
								
				if(this.model.has('label')) {
					labelSelectField.val(this.model.get('label'));
				}
			}
			else {
				this.$el.append(
					$('<label></label>', { text: AttributeTypes[this.model.get('label')] })
				);
				
				this.$el.append(
					$('<span></span>', { text: this.model.get('value') })
				);
			}
			
			$('section#info .attributes .container').append(this.$el);
			
			this.createEvents();
			
			// Trigger update for a new attribute, 
			// makes sure the label is set, even if the user didn't select one
			if(typeof labelSelectField != 'undefined') {
				labelSelectField
					.chosen({ disable_search_threshold: 1000 })
					.trigger('change');
			}
		},
		
		createEvents: function() {
			this.unbindEvents();
			
			var self = this;
			
			if(this.editable) {
				this.$el.find('select').on('change', function() {
					self.model.set('label', $(this).val());
					
					self.updateField();
				});
				
				this.$el.find('input, textarea').on('keyup', function() {
					self.model.set('value', $(this).val());
				});
				
				this.$el.find('a.btn.remove').on('click', function() {
					self.model.collection.remove(self.model);
				});
			}
		},
		
		unbindEvents: function() {
			this.$el.find('select').off('change');
			this.$el.find('input, textarea').off('keyup');
			this.$el.find('a.btn.remove').off('click');
		},
		
		updateField: function() {			
			var currentField = this.$el.find('input, textarea'),
				type = this.typeForLabel(),
				field;
								
			if(type == 'textarea') {
				field = $('<textarea></textarea>', { val: this.model.get('value') });
			}
			else {
				field = $('<input />', { type: type , val: this.model.get('value') });
			}
						
			currentField.before(field);
			currentField.remove();
		},
		
		/**
		 * Returns an input type based on the key of the current attribute
		 */
		typeForLabel: function() {
			var type = 'text';
			
			if(this.model.has('label')) {
				var key = this.model.get('label').toLowerCase();
								
				if(key === 'email') {
					type = 'email';
				}
				else if(key == 'address') {
					type = 'textarea';
				}
			}
			
			return type;
		}
		
	});
	
});