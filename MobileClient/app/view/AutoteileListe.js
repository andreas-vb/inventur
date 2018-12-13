Ext.define("AutoteileListe.view.AutoteileListe", {
	extend: 'Ext.dataview.List',
	xtype: 'AutoteileListe',
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