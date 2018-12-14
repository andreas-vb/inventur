$.widget("autoteil.liste", {  
  _create: function() { 
	$.ajax({
		url: "/inventur/WebService/autoteile", 
		dataType: "json",
		success: this._appendAutoteil,
		context: this
	}); 
  },
  
  reload: function() {
	this.element.find(".autoteil:not(.template)").remove();
	$.ajax({
		url: "/inventur/WebService/autoteile", 
		dataType: "json",
		success: this._appendAutoteil,
		context: this
	});   
  },
  
  _appendAutoteil: function(autoteile) {
	  var that = this
		for (var i = 0; i < autoteile.length; i++){
			var autoteil = autoteile[i];
			var autoteilElement = this.element.find(".template").clone().removeClass("template");
			autoteilElement.find(".title").text(autoteil.title);
			autoteilElement.find(".author").text(autoteil.author);
			autoteilElement.find(".inventur_date").text(autoteil.inventur_date);
			autoteilElement.find(".gesamt").text((autoteil.preis * autoteil.bestand) + " €");
			autoteilElement.click(autoteil.url, function(event) {
				that._trigger("onAutoteilClicked", null, event.data);
			});	
			autoteilElement.find(".delete_autoteil").click(autoteil.url, function(event) {
				that._trigger("onDeleteAutoteilClicked", null, event.data);
				return false;			//Verhindert, dass übergeordnete Clickhandler ausgeführt werden, die Bearbeitung wird also unterbrochen.
			});
			autoteilElement.find(".edit_autoteil").click(autoteil, function(event) {
				that._trigger("onEditAutoteilClicked", null, event.data);
				return false;			//Verhindert, dass übergeordnete Clickhandler ausgeführt werden, die Bearbeitung wird also unterbrochen.
			});
			autoteilElement.find(".create_autoteil").click(autoteil, function(event) {
				that._trigger("onCreateAutoteilClicked", null, event.data);
				return false;			//Verhindert, dass übergeordnete Clickhandler ausgeführt werden, die Bearbeitung wird also unterbrochen.
			});
			this.element.append(autoteilElement);
		}
	}
});