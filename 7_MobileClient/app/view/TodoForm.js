Ext.define("Todoliste.view.TodoForm", {
	extend: 'Ext.form.Panel',
	xtype: 'todoform',
	config: {
		items:  [
			{
				xtype: 'textfield',
				name: 'title',
				label: 'Titel',
				readOnly: true
			}
		]
	}
});