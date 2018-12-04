Ext.define('Todoliste.controller.AppController', {
	extend: 'Ext.app.Controller',
	config: {
		control: {
			todolist: {
				itemtap: 'showTodoDetails'
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
			todoForm: 'todoform',
			deleteButton: '#deletebutton'
		}
	},
	
	showTodoDetails: function(list, index, target, record) {
		var main = this.getMain();
		var todoForm = Ext.widget('todoform'); // Equivalent to Ext.create('widget.panel')
		todoForm.setRecord(record);
		main.push(todoForm);
	},
	
	showConfirmDeleteDialog: function() {
		Ext.Msg.confirm('Löschen', 'Wirklich löschen?', this.deleteAutoteil, this);
	},
	
	deleteTodo: function(buttonId) {
		if (buttonId != 'yes') {
			return;
		}
		var todo = this.getTodoForm().getRecord();
		var todos = Ext.getStore('Todos');
		todos.remove(todo);
		todos.sync({
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