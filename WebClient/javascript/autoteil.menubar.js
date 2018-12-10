$.widget("todo.menuBar", { 
	_create: function() {
		var that = this;
		this.element.find(".show_todos").click(function() {
			that._trigger("onShowAutoteilClicked");
			return false;
		});
		this.element.find(".create_todo").click(function() {
			that._trigger("onCreateAutoteilClicked");
			return false;
		});
	}
});