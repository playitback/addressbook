define('view/addressbook', 
	['backbone', 'collection/contact', 'view/addressbook/contacts', 'view/addressbook/info'], 
	function(Backbone, ContactCollection, ContactsView, InfoView) {
	
	return Backbone.View.extend({
		
		initialize: function() {						
			this.$el = $('body');
		},
		
		render: function() {
			this.contactsView = new ContactsView({ addressBook: this });
			this.contactsView.render();
			
			this.infoView = new InfoView({ addressBook: this });
			
			this.createEvents();
		},
		
		createEvents: function() {
			var self = this;
			
			this.contactsView.on('contact-click', function(contact, editMode) {
				if(typeof editMode != 'boolean') {
					editMode = false;
				}
								
				if(typeof contact === 'undefined' || contact == null) {
					self.hideInfoView();
				}
				else {
					self.infoView.editMode = editMode; // Set directly, so the view's only rendered once
					self.infoView.setContact(contact);
				}
			});
		},
		
		hideInfoView: function() {
			this.infoView.$el.hide();
		}
		
	});
	
});