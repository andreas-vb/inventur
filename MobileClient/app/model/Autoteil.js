Ext.define('AutoteileListe.model.Autoteil', {
	extend: 'Ext.data.Model',
	config: {
		fields: [
			'title',
			'author',
			{
				name: 'inventur_date',
				type: 'date'
			},
			'notes',
			'version',
			'farbe',
			'bestand',
			'preis',
		],
		idProperty: 'url'
	
	}
});