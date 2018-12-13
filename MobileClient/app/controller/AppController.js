Ext.define('AutoteileListe.controller.AppController', {
	extend: 'Ext.app.Controller',
	config: {
		control: {
			AutoteileListe: {
				itemtap: 'showAutoteileDetails'
			},
			'#deletebutton': {
				tap: 'showConfirmDeleteDialog'
			},
			main: {
				push: 'showDeleteButton',
				pop: 'hideDeleteButton'
			}
		},
		refs: {
			main: 'main',
			autoteileForm: 'autoteileform',
			deleteButton: '#deletebutton'
		}
	},
	
	showAutoteileDetails: function(list, index, target, record) {
		var main = this.getMain();
		var autoteileForm = Ext.widget('autoteileform'); // Equivalent to Ext.create('widget.panel')
		autoteileForm.setRecord(record);
		main.push(autoteileForm);
	},
	
	showConfirmDeleteDialog: function() {
		Ext.Msg.confirm('Löschen', 'Wirklich löschen?', this.deleteAutoteil, this);
	},
	
	deleteAutoteil: function(buttonId) {
		if (buttonId != 'yes') {
			return;
		}
		var autoteil = this.getAutoteileForm().getRecord();
		var autoteile = Ext.getStore('Autoteile');
		autoteile.remove(autoteil);
		autoteile.sync({
			callback: function() {
				this.getMain().pop();
			},
			scope: this
		});
	},
	
	showDeleteButton: function() {
		this.getDeleteButton().setHidden(false);
	},
	
	hideDeleteButton: function() {
		this.getDeleteButton().setHidden(true);
	}
});