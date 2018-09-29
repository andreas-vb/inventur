<?php
	class TodoService {
		const DATABASE_ERROR = "DATABASE_ERROR";
		const NOT_FOUND = "NOT_FOUND";
		
		public function readTodo($id) {
			$link = new mysqli("localhost", "root", "", "todolist"); 
			$link->set_charset("utf8");
			$select_statement =	"SELECT id, created_date, due_date, ".
								"due_date <= CURDATE() as due, author, title, notes ".
								"FROM todo ".
								"WHERE id = $id";
			$result_set = $link->query($select_statement);
			$todo = $result_set->fetch_object("Todo");
			$link->close();
			if ($todo === NULL) {
				return TodoService::NOT_FOUND;
			}
			return $todo;
		}
		
		
		public function readTodos(){
		    $link = new mysqli("localhost", "root", "", "todolist"); 
			if ($link->connect_error !== NULL) {
				return TodoService::DATABASE_ERROR;
			}
			$link->set_charset("utf8");
			$select_statement =	"SELECT id, created_date, due_date, ".
								"due_date <= CURDATE() as due, author, title, notes ".
								"FROM todo ".
								"ORDER BY due_date ASC";
			$result_set = $link->query($select_statement);
			
			$todos = array();
			$todo = $result_set->fetch_object("Todo");
			while($todo !== NULL) {
				$todos[] = $todo;
				$todo = $result_set->fetch_object("Todo");
				}
			$link->close();
			return $todos;
		}
	}
?>