Ext.define("Todoliste.view.TodoList", {
	extend: 'Ext.dataview.List',
	xtype: 'todolist',
	config: {
		store: 'Todos',
		itemTpl: '<div>{title}</div>',
		emptyText: 'keine Todos',
		plugins: [
			{
				type: 'pullrefresh',
				pullText: 'Zum Aktualisieren herunterziehen',
				releaseText: 'Zum Aktualisieren loslassen', 
				loadingText: 'lädt...',
				loadedText: '',
				lastUpdatedText: '',
				lastUpdatedDateFormat: ''				
			}
		]
	}
});