Ext.define("AutoteileListe.view.AutoteileListe", {
	extend: 'Ext.dataview.List',
	xtype: 'AutoteileListe',
	config: {
		store: 'Autoteile',
		itemTpl: '<div>{title}</div>',
		emptyText: 'keine Autoteile',
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