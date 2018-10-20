Ext.define('Todoliste.controller.AppController', {
	extend: 'Ext.app.Controller',
	config: {
		control: {
			todolist: {
				itemtap: 'showTodoDetails'
			}
		},
		refs: {
			main: 'main'
		}
	},
	showTodoDetails: function(list, index, target, record) {
		var main = this.getMain();
		var todoForm = Ext.widget('todoform'); // Equivalent to Ext.create('widget.panel')
		todoForm.setRecord(record);
		main.push(todoForm);
	}
});