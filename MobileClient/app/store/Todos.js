Ext.define('AutoteileListe.store.Todos', {
	extend: 'Ext.data.Store',
	requires: [
		'Ext.data.proxy.Rest'
	],
	config: {
		proxy: {
			type: 'rest',
			url: '/inventur/WebService/autoteile',
			reader: {
				type:'json'
			},
			listeners: {
				exception: function(proxy, response) {
					Ext.Msg.alert('Fehler', response.statusText);
				}
			}
		},
		model: 'AutoteileListe.model.Todo',
		autoLoad: true
	}
});