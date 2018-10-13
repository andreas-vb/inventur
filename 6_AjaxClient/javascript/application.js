$(function() {
	$(document).ajaxError(function(event, response) {
		$("#error_dialog").errorDialog("open",response.statusText);
		$("#todo_details").hide();
		$("#todo_list").show();
		if (response.status == 404) {
			$("#todo_list").todoList("reload");
		}
	});
	$("#error_dialog").errorDialog();
	$("#todo_list").todoList({
		onTodoClicked: function(event, todoUrl) {
			$("#todo_list").hide();
			$("#todo_details").show();
			$("#todo_details").todoDetails("load", todoUrl);
		},
		onDeleteTodoClicked: function(event, todoUrl) {
			$("#delete_dialog").deleteDialog("open", todoUrl);
		}
	});
	$("#todo_details").todoDetails();
	$("#delete_dialog").deleteDialog({
		onTodoDeleted: function() {
			$("#todo_list").todoList("reload");
		}
	});
	$("#edit_dialog").editDialog();	
});