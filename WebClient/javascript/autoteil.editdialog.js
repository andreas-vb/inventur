$.widget("autoteil.editDialog", $.ui.dialog, {
	options: {
		autoOpen: false, 
		modal: true,
		buttons: [
			{
				text: "OK"
			},			
			{
				text: "Abbrechen"
			}
		],
		width: 550
	},
	
	open: function(autoteil) {
		console.log("called function open with"+autoteil);
		var output = "";
		for (property in autoteil) {
			output += property + ': ' + autoteil[property]+'; ';
		}
		console.log(output);
		this._autoteil = autoteil;
		this.element.find(".validation_message").empty();
		this.element.find("#title_field").removeClass("ui-state-error");
		this.element.find("#title_field").val(autoteil.title);
		this.element.find("#inventur_date_field").removeClass("ui-state-error");
		this.element.find("#inventur_date_field").val(autoteil.inventur_date);
		this.element.find("#notes_field").removeClass("ui-state-error");
		this.element.find("#notes_field").val(autoteil.notes);
		this.element.find("#color_field").val(autoteil.farbe);
		this.element.find("#preis_field").removeClass("ui-state-error");
		this.element.find("#preis_field").val(autoteil.preis);
		this.element.find("#author_field").removeClass("ui-state-error");
		this.element.find("#author_field").val(autoteil.author);
		this.element.find("#bestand_field").removeClass("ui-state-error");
		this.element.find("#bestand_field").val(autoteil.bestand);
		this._super();
	},	
	
	_create: function() {
		var that = this;
		this.element.find("#inventur_date_field").datepicker({ dateFormat: "yy-mm-dd" });
		var ok = this.options.buttons[0];
		ok.click = function() {
			var autoteil = {
				title: that.element.find("#title_field").val(), //keine Parameter-Übergabe bei val-Methode --> Text wird ausgelesen
				inventur_date: that.element.find("#inventur_date_field").val(),
				bestand: that.element.find("#bestand_field").val(),
				farbe: that.element.find("#color_field").val(),
				author: that.element.find("#author_field").val(),
				preis: that.element.find("#preis_field").val(),
				notes: that.element.find("#notes_field").val()
			};
			
			console.log("update called"+autoteil);
			var output = "";
			for (property in autoteil) {
				output += property + ': ' + autoteil[property]+'; ';
			}
			console.log(output);
			$.ajax({
				type: "PUT",
				url: that._autoteil.url,
				data: autoteil,
				headers: { "If-Match": that._autoteil.version },
				success: function() {
					that.close();
					that._trigger("onAutoteilEdited");
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
						that.element.find(".validation_message").text(validationMessages.author);
						that.element.find("#author_field").addClass("ui-state-error").focus();
					}
					else {
						this.element.find(".validation_message").empty();
						this.element.find("#author_field").removeClass("ui-state-error");
					}
					
					if (response.status == 400) {
						var validationMessages = $.parseJSON(response.responseText);
						that.element.find(".validation_message").text(validationMessages.date);
						that.element.find("#inventur_date_field").addClass("ui-state-error").focus();
					}
					else {
						this.element.find(".validation_message").empty();
						this.element.find("#inventur_date_field").removeClass("ui-state-error");
					}
					
					if (response.status == 400) {
						var validationMessages = $.parseJSON(response.responseText);
						that.element.find(".validation_message").text(validationMessages.notes);
						that.element.find("#notes_field").addClass("ui-state-error").focus();
					}
					else {
						this.element.find(".validation_message").empty();
						this.element.find("#notes_field").removeClass("ui-state-error");
					}
					
					if (response.status == 400) {
						var validationMessages = $.parseJSON(response.responseText);
						that.element.find(".validation_message").text(validationMessages.preis);
						that.element.find("#preis_field").addClass("ui-state-error").focus();
					}
					else {
						this.element.find(".validation_message").empty();
						this.element.find("#preis_field").removeClass("ui-state-error");
					}
					
					if (response.status == 400) {
						var validationMessages = $.parseJSON(response.responseText);
						that.element.find(".validation_message").text(validationMessages.bestand);
						that.element.find("#bestand_field").addClass("ui-state-error").focus();
					}
					else {
						this.element.find(".validation_message").empty();
						this.element.find("#bestand_field").removeClass("ui-state-error");
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