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
			},
			{
				xtype: 'textfield',
				name: 'author',
				label: 'Autor',
				readOnly: true
			},
			{
				xtype: 'datepickerfield',
				name: 'inventur_date',
				label: 'Datum',
				readOnly: true,
				dateFormat: 'd.m.Y'
			},
			{
				xtype: 'textareafield',
				name: 'notes',
				label: 'Notizen',
				readOnly: true
			},
			{
				xtype: 'textfield',
				name: 'farbe',
				label: 'Farbe',
				readOnly: true
			},
			{
				xtype: 'numberfield',
				name: 'bestand',
				label: 'Bestand',
				readOnly: true
			},
			{
				xtype: 'numberfield',
				name: 'preis',
				label: 'Preis',
				readOnly: true
			}
		]
	}
});