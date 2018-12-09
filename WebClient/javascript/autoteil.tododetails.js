$.widget("todo.todoDetails", {
	load: function(todoUrl){
		$.ajax({
			url: todoUrl,
			dataType: "json",
			success: function(todo) {
				this.element.find(".h3_details").text(todo.title);
				this.element.find(".title").text(todo.title);
				this.element.find(".author").text(todo.author);
				this.element.find(".inventur_date").text(todo.inventur_date);
				this.element.find(".notes").text(todo.notes);
			},
			context: this
		});
	}
});