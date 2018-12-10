$(function() {
	$(document).ajaxError(function(event, response) {
		if (response.status == 400) {
			return;
		}
		$("#error_dialog").errorDialog("open",response.statusText);
		$("#todo_details").hide();
		$("#todo_list").show();
		$("#menu_bar").show();
		if (response.status == 404) {
			$("#todo_list").liste("reload");
		}
	});
	$(document).ajaxStart(function() {
		$.blockUI({ message: null });
	});
	$(document).ajaxStop(function() {
		$.unblockUI();
	});
	$("#error_dialog").errorDialog();
	$("#menu_bar").menuBar({
		onShowAutoteilClicked: function(){
			$("#todo_details").hide();
			$("#todo_list").show();
			$("#todo_list").liste("reload");
		},		
		onCreateAutoteilClicked: function(event, todo) {
			$("#create_dialog").createDialog("open", todo);
		}
	});
	$("#todo_list").liste({
		onAutoteilClicked: function(event, todoUrl) {
			$("#todo_list").hide();
			$("#todo_details").show();
			$("#todo_details").details("load", todoUrl);
		},
		onDeleteAutoteilClicked: function(event, todoUrl) {
			$("#delete_dialog").deleteDialog("open", todoUrl);
		},
		onEditAutoteilClicked: function(event, todo) {
			$("#edit_dialog").editDialog("open", todo);
		},		
		onCreateAutoteilClicked: function(event, todo) {
			$("#create_dialog").createDialog("open", todo);
		}
	});
	$("#todo_details").details();
	$("#delete_dialog").deleteDialog({
		onTodoDeleted: function() {
			$("#todo_list").liste("reload");
		}
	});
	$("#edit_dialog").editDialog({	
		onTodoEdited: function() {
			$("#todo_list").liste("reload");
		}
	});
	$("#create_dialog").createDialog({	
		onTodoCreated: function() {
			$("#todo_list").liste("reload");
		}
	});
});