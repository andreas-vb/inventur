$.widget("autoteil.createDialog", $.ui.dialog, {
	options: {
		autoOpen: false, 
		modal: true,
		buttons: [
			{
				text: "Speichern"
			},			
			{
				text: "Abbrechen"
			}
		],
		width: 550
	},
	
	open: function(autoteil) {
		this._autoteil = autoteil;
		this.element.find(".validation_message").empty();
		this.element.find("#author_field").removeClass("ui-state-error");
		this.element.find("#author_field").val(autoteil.author);
		this.element.find("#title_field").removeClass("ui-state-error");
		this.element.find("#title_field").val(autoteil.title);
		this.element.find("#inventur_date_field").val(autoteil.inventur_date);
		this.element.find("#notes_field").val(autoteil.notes);
		this.element.find("#preis_field").val(autoteil.notes);
		this.element.find("#bestand_field").val(autoteil.notes);
		this.element.find("#farbe_field").val(autoteil.notes);
		this._super();
	},
	
	_create: function() {
		var that = this;
		this.element.find("#inventur_date_field").datepicker({ dateFormat: "yy-mm-dd" });
		var ok = this.options.buttons[0];
		ok.click = function() {
			that._autoteil = {
				author: that.element.find("#author_field").val(),
				title: that.element.find("#title_field").val(), //keine Parameter-Übergabe bei val-Methode --> Text wird ausgelesen
				inventur_date: that.element.find("#inventur_date_field").val(),
				notes: that.element.find("#notes_field").val(),
				preis: that.element.find("#preis_field").val(),
				bestand: that.element.find("#bestand_field").val(),
				farbe: that.element.find("#color_field").val()
			};
			
			console.log("create called"+that._autoteil);
			var output = "";
			for (property in that._autoteil) {
				output += property + ': ' + that._autoteil[property]+'; ';
			}
			console.log(output);
			console.log(that._autoteil.version);
			$.ajax({
				type: "POST",
				url: "/inventur/WebService/todos",
				data: that._autoteil,
				headers: { "If-Match": that._autoteil.version },
				success: function() {
					that.close();
					that._trigger("onTodoCreated");
				},
				error: function(response) {
					if (response.status == 400) {
						var validationMessages = $.parseJSON(response.responseText);
						that.element.find(".validation_message").text(validationMessages.title);
						that.element.find("#title_field").addClass("ui-state-error").focus();
					}
					else {
						this.element.find(".validation_message").empty();
						this.element.find("#title_field").removeClass("ui-state-error");
					}
					
					if (response.status == 400) {
						var validationMessages = $.parseJSON(response.responseText);
						that.element.find(".validation_message").text(validationMessages.title);
						that.element.find("#author_field").addClass("ui-state-error").focus();
					}
					else {
						this.element.find(".validation_message").empty();
						this.element.find("#author_field").removeClass("ui-state-error");
					}
					
					if (response.status == 400) {
						var validationMessages = $.parseJSON(response.responseText);
						that.element.find(".validation_message").text(validationMessages.title);
						that.element.find("#inventur_date_field").addClass("ui-state-error").focus();
					}
					else {
						this.element.find(".validation_message").empty();
						this.element.find("#inventur_date_field").removeClass("ui-state-error");
					}
					
				}
			})

		};
		var cancel = this.options.buttons[1];
		cancel.click = function(){
			that.close();
		};
		this._super();
	}
});