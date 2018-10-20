Ext.define('Todoliste.view.Main', {
	extend: 'Ext.navigation.View',
	xtype: 'main',
	config: {
		items: {
			xtype: 'todolist'
		},
		defaultBackButtonText: 'Zurück'
	}
});