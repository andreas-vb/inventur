Ext.define("Todoliste.view.TodoList", {
	extend: 'Ext.dataview.List',
	xtype: 'todolist',
	config: {
		store: 'Todos',
		itemTpl: '<div>{title}</div>',
		emptyText: 'keine Todos'
	}
});