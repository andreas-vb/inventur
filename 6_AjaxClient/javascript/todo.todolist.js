$.widget("todo.todoList", {  
  _create: function() { 
	$.ajax({
		url: "/andreas-vb/5_WebService/todos", 
		dataType: "json",
		success: this._appendTodos,
		context: this
	}); 
  },
  
  reload: function() {
	this.element.find(".todo:not(.template)").remove();
	$.ajax({
		url: "/andreas-vb/5_WebService/todos", 
		dataType: "json",
		success: this._appendTodos,
		context: this
	});   
  },
  
  _appendTodos: function(todos) {
	  var that = this
		for (var i = 0; i < todos.length; i++){
			var todo = todos[i];
			var todoElement = this.element.find(".template").clone().removeClass("template");
			todoElement.find(".title").text(todo.title);
			todoElement.find(".author").text(todo.author);
			todoElement.find(".due_date").text(todo.due_date);
			todoElement.click(todo.url, function(event) {
				that._trigger("onTodoClicked", null, event.data);
			});	
			todoElement.find(".delete_todo").click(todo.url, function(event) {
				that._trigger("onDeleteTodoClicked", null, event.data);
				return false;			//Verhindert, dass übergeordnete Clickhandler ausgeführt werden, die Bearbeitung wird also unterbrochen.
			});
			todoElement.find(".edit_todo").click(todo, function(event) {
				that._trigger("onEditTodoClicked", null, event.data);
				return false;			//Verhindert, dass übergeordnete Clickhandler ausgeführt werden, die Bearbeitung wird also unterbrochen.
			});
			this.element.append(todoElement);
		}
	}
});