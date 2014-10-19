define('view/addressbook/contacts', [
	'backbone', 'collection/contact', 'view/addressbook/contacts/contact', 'collection/contact_attribute'],
	function(Backbone, ContactCollection, ContactView, AttributeCollection) {
	
	return Backbone.View.extend({
		
		initialize: function() {
			this.contacts = new ContactCollection;
			
			this.initializeEvents();
			
			this.$el = $('section#contacts');
		},
		
		initializeEvents: function() {
			this.contacts.on('add', this.handleContactAdd, this);
			this.contacts.on('remove', this.handleContactRemove, this);
			this.contacts.on('change', this.handleContactChange, this);
		},
		
		render: function() {
			this.contacts.fetch();
						
			this.$el.find('ul').append(
				$('<li></li>', { 'class': 'add' })
					.append(
						$('<a></a>', { text: 'Add Contact', 'class': 'btn' })
					)
					.on('click', this.handleAddContactClick.bind(this))
			);
		},
		
		showInfo: function(contact, editMode) {
			if(typeof this.selectedContact === 'object' && this.selectedContact != null) {
				if(this.selectedContact.isNew()) {
					this.contacts.remove(this.selectedContact);
				}
				
				if(typeof this.selectedContact === 'object' && 
					this.selectedContact != null && 
					typeof this.selectedContact.contactView === 'object' && 
					this.selectedContact.contactView != null) {
					this.selectedContact.contactView.$el.removeClass('current');
				}
			}
						
			contact.contactView.$el.addClass('current');
			
			this.trigger('contact-click', contact, editMode);
				
			this.selectedContact = contact;
		},
		
		hideInfo: function() {
			this.selectedContact = null;
			
			this.trigger('contact-click', null);
		},
		
		
		// !Event Handlers
		
		handleContactAdd: function(contact) {
			var contactView = new ContactView({ model: contact }),
				self = this;
			
			contact.contactView = contactView;
			
			contactView.render();
			contactView.$el.on('click', function() {
				if(!self.selectedContact || self.selectedContact != contact) {
					self.showInfo(contact);
				}
			});
		},
		
		handleContactRemove: function(contact) {
			if(contact === this.selectedContact) {
				this.hideInfo();
			}
			
			if(typeof contact.contactView === 'object') {
				contact.contactView.remove();
			}
		},
		
		handleContactChange: function(contact) {
			if(typeof contact.contactView === 'object') {
				contact.contactView.render();
			}
		},
		
		handleAddContactClick: function() {
			if(typeof this.selectedContact === 'object' && this.selectedContact != null && 
				this.selectedContact.isNew()) {
				return;	
			}
			
			var ContactModel = this.contacts.model,
				newContact = new ContactModel;
				
			newContact.set('attributes', new AttributeCollection);
			
			this.contacts.add(newContact);
			
			this.showInfo(newContact, true);
		}
		
	});
	
});