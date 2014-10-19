define('view/addressbook/info', 
	['backbone', 'view/addressbook/info/attribute', 'jquery.textwidth', 'model/contact_attribute'], 
	function(Backbone, AttributeView, jqueryTextWidth, ContactAttributeModel) {
	
	return Backbone.View.extend({
		
		editMode: false,
		
		initialize: function(options) {
			this.addressBook = options && options.addressBook || null;
			
			this.$el = $('section#info');
		},
		
		setContact: function(contact) {
			if(contact != this.model) {
				if(typeof this.model === 'object' && this.model.hasChanged()) {
					if(!confirm('You have pending changes. Are you sure you wish to continue?')) {
						return;
					}
				}
				
				this.model = contact;
			
				this.render();
			}
		},
		
		setEditMode: function(editMode) {
			this.editMode = editMode;
			
			this.render();
		},
		
		render: function() {
			var controls 		= this.$el.find('.controls'),
				header 			= this.$el.find('.head'),
				attributes 		= this.$el.find('.attributes'),
				container,
				self = this;
							
			if(this.editMode) {
				container = header.find('div.edit');
				var firstNameField = container.find('.text .name input[name="first_name"]');
				
				firstNameField
					.val(this.model.get('first_name'))
					.trigger('keyup');
				container.find('.text .name input[name="last_name"]')
					.val(this.model.get('last_name'))
					.trigger('keyup');
				container.find('.text .company input[name="company_name"]')
					.val(this.model.get('company_name'))
					.trigger('keyup');
			}
			else {
				container = header.find('div.view');
				
				// Reset all fields, incase any are actually empty
				container.find('.text span').text('');

				container.find('.text .name span.first').text(this.model.get('first_name'));
				container.find('.text .name span.last').text(this.model.get('last_name'));
				container.find('.text .company span').text(this.model.get('company_name'));
			}
			
			
			// Update image
			var photoImage = header.find('.photo img');
			
			photoImage.removeAttr('src');
			
			var photoUrl;
			if((photoUrl = this.model.photoUrl())) {
				photoImage.attr('src', photoUrl);
			}
			
			
			// Show correct view container
			this.$el.find('div.edit, div.view').hide();
			container.show();
			
			// If we're in edit mode, we'll have a first name field. Focus on it.
			if(typeof firstNameField != 'undefined') {
				firstNameField.focus();
			}
			
			
			// Create events here, so attribute events don't get cleared
			this.createEvents();
			
			
			// Iterate and render attribute views
			this.$el.find('.attributes .container').html('');
			if(this.model.has('attributes')) {
				this.model.get('attributes').forEach(function(attribute) {
					attribute.attributeView = new AttributeView({ 
						model: attribute, 
						editable: self.editMode });
			
					attribute.attributeView.render();					
				});
			}
			
			this.$el.show();
						
			controls.find('a.edit').text(this.editMode ? 'Save' : 'Edit');
			attributes.find('a.add').toggle(this.editMode);
		},
		
		createEvents: function() {
			this.unbindEvents();
			
			var head 			= this.$el.find('.head'),
				attributes 		= this.$el.find('.attributes'),
				controls 		= this.$el.find('.controls'),
				self 			= this;
			
			controls.find('a.edit').off('click').on('click', function() {
				if(self.editMode) {
					// Only save, if changes have been made
					if(self.model.hasChanged()) {
						if(self.model.isValid()) {
							self.model.save();
						}
						else {
							alert('Contacts require at least a first name');
						}
					}
					// If there's no changes and it's a new contact, just remove it
					else if(self.model.isNew()) {
						self.editMode = false;
						
						self.model.collection.remove(self.model);
						
						return;
					}
				}
				
				self.setEditMode(!self.editMode);
			});
			
			controls.find('a.delete').off('click').on('click', function() {
				if(confirm('Are you sure?')) {
					self.addressBook.contactsView.contacts.remove(self.model);
					self.addressBook.hideInfoView();
					
					self.model.destroy();
				}
			});
			
			var updateField = function() {
				$(this).css('width', $(this).textWidth() + 10);
				
				var key = $(this).attr('name'),
					val = $(this).val();
					
				// Don't want to update the model unless the value's actually changed.
				// Otherwise it'll be marked as updated and it'll be a pointless request
				if(val !== self.model.get(key)) {
					self.model.set($(this).attr('name'), $(this).val());
				}
			};
			
			this.$el.find('input[type="text"]')
				.off('keyup')
				.keyup(function() {
					updateField.call(this);
				})
				.off('blur')
				.blur(function() {
					updateField.call(this);
				});
			
			
			// Attribute management
						
			var attributeCollection = this.model.get('attributes');
			
			attributes.find('a.add').click(function() {
				attributeCollection.add(new ContactAttributeModel);
			});
			
			attributeCollection.on('add', this.handleAttributeAdd, this);
			attributeCollection.on('remove', this.handleAttributeRemove, this);
		},
		
		unbindEvents: function() {
			var head = this.$el.find('.head'),
				attributes = this.$el.find('.attributes'),
				controls = this.$el.find('.controls'),
				self = this;
			
			controls.find('a.edit').off('click');
			controls.find('a.delete').off('click');
			
			this.$el.find('input[type="text"]').off('keyup');
			
			attributes.find('a.add').off('click');
			
			if(this.model.has('attributes')) {
				this.model.get('attributes').off('add', null, this);
				this.model.get('attributes').off('remove', null, this);
			}
		},
		
		handleAttributeAdd: function(attribute) {
			var attributes = this.$el.find('.attributes');
			
			attribute.attributeView = new AttributeView({ 
				model: attribute, 
				editable: this.editMode });
			
			attribute.attributeView.render();
		},
		
		handleAttributeRemove: function(attribute) {			
			if(typeof attribute.attributeView === 'object') {
				attribute.attributeView.unbindEvents();
				attribute.attributeView.remove();
			}
		}
		
	});
	
});