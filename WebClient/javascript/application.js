$(function() {
	$(document).ajaxError(function(event, response) {
		if (response.status == 400) {
			return;
		}
		$("#error_dialog").errorDialog("open",response.statusText);
		$("#autoteil_details").hide();
		$("#autoteil_list").show();
		$("#menu_bar").show();
		if (response.status == 404) {
			$("#autoteil_list").liste("reload");
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
			$("#autoteil_details").hide();
			$("#autoteil_list").show();
			$("#autoteil_list").liste("reload");
		},		
		onCreateAutoteilClicked: function(event, todo) {
			$("#create_dialog").createDialog("open", todo);
		}
	});
	$("#autoteil_list").liste({
		onAutoteilClicked: function(event, todoUrl) {
			$("#autoteil_list").hide();
			$("#autoteil_details").show();
			$("#autoteil_details").details("load", todoUrl);
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
	$("#autoteil_details").details();
	$("#delete_dialog").deleteDialog({
		onAutoteilDeleted: function() {
			$("#autoteil_list").liste("reload");
		}
	});
	$("#edit_dialog").editDialog({	
		onAutoteilEdited: function() {
			$("#autoteil_list").liste("reload");
		}
	});
	$("#create_dialog").createDialog({	
		onAutoteilCreated: function() {
			$("#autoteil_list").liste("reload");
		}
	});
});