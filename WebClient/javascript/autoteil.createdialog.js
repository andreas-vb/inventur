$.widget("todo.createDialog", $.ui.dialog, {
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
	
	open: function(todo) {
		this._todo = todo;
		this.element.find(".validation_message").empty();
		this.element.find("#author_field").removeClass("ui-state-error");
		this.element.find("#author_field").val(todo.author);
		this.element.find("#title_field").removeClass("ui-state-error");
		this.element.find("#title_field").val(todo.title);
		this.element.find("#inventur_date_field").val(todo.inventur_date);
		this.element.find("#notes_field").val(todo.notes);
		this._super();
	},
	
	_create: function() {
		var that = this;
		this.element.find("#inventur_date_field").datepicker({ dateFormat: "yy-mm-dd" });
		var ok = this.options.buttons[0];
		ok.click = function() {
			var todo = {
				author: that.element.find("#author_field").val(),
				title: that.element.find("#title_field").val(), //keine Parameter-Übergabe bei val-Methode --> Text wird ausgelesen
				inventur_date: that.element.find("#inventur_date_field").val(),
				notes: that.element.find("#notes_field").val()
			};
			$.ajax({
				type: "POST",
				url: "/inventur/WebService/todos",
				data: todo,
				headers: { "If-Match": that._todo.version },
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