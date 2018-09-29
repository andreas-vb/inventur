<?php
function read_todo($id){
$link = mysqli_connect("localhost","root","","todolist");
if ($link === FALSE) {
	return FALSE;
}

mysqli_set_charset($link, "utf8");

$sql_statement = "SELECT id, created_date, due_date, author, title, notes ".
				 "FROM todo ".
				 "WHERE id = $id";
$result_set = mysqli_query($link, $sql_statement);

if ($result_set === FALSE) {
	mysqli_close($link);
	return FALSE;
}

$todo = mysqli_fetch_assoc($result_set);
mysqli_close($link);
return $todo;
}

function read_todos(){
	$link = mysqli_connect("localhost","root","","todolist");
	mysqli_set_charset($link, "utf8");
	$sql_statement = "SELECT id, due_date, author, title, due_date <= CURDATE() as due ".
				 "FROM todo ".
				 "ORDER BY due_date ASC";
	$result_set = mysqli_query($link, $sql_statement);
	$todos = mysqli_fetch_all($result_set, MYSQLI_ASSOC);
	
	
    mysqli_close($link);
	return $todos;

}

function create_todo($todo) {
	if ($todo["title"] === "") {
		return FALSE;
	}
	$link = mysqli_connect("localhost","root","","todolist");
	mysqli_set_charset($link, "utf8");
	$sql_statement = "INSERT INTO todo SET ".
					"created_date = CURDATE(), ".
					"due_date = '$todo[due_date]', ".
					"title = '$todo[title]', ".
					"notes = '$todo[notes]'";
	mysqli_query($link, $sql_statement);
	mysqli_close($link);
	return TRUE;
}
?>