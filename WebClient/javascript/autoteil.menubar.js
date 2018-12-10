$.widget("todo.menuBar", { 
	_create: function() {
		var that = this;
		this.element.find(".show_autoteile").click(function() {
			that._trigger("onShowAutoteilClicked");
			return false;
		});
		this.element.find(".create_autoteil").click(function() {
			that._trigger("onCreateAutoteilClicked");
			return false;
		});
	}
});