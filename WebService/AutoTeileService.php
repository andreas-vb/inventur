<?php
	class AutoTeileService {
		const DATABASE_ERROR = "DATABASE_ERROR";
		const NOT_FOUND = "NOT_FOUND";
		const INVALID_INPUT = "INVALID_INPUT";
		const OK = "OK";
		const VERSION_OUTDATED = "VERSION_OUTDATED"; 
		
		public function updateAutoteil($autoteil) {
			$link = new mysqli("localhost", "root", "", "inventur"); 
			$link->set_charset("utf8");
			$update_statement = "UPDATE inventur SET ".
								"name = '$autoteil->name', ".
								"inventur_date = '$autoteil->inventur_date', ".
								"notes = '$autoteil->notes', ".
								"farbe = '$autoteil->farbe', ".
								"bestand = '$autoteil->bestand', ".
								"preis = '$autoteil->preis', ".
								"WHERE teilenr = $autoteil->teilenr";
			$link->query($update_statement);
			$affected_rows = $link->affected_rows;
			if ($affected_rows === 0) {
				$select_statement = "SELECT COUNT(*) FROM todo WHERE teilenr = $autoteil->teilenr";
				$result_set = $link->query($select_statement);
				$row = $result_set->fetch_row();
				$link->close();
				$count = intval($row[0]);
				if ($count === 1) {
					return AutoTeileService::VERSION_OUTDATED;
				}
				return AutoTeileService::NOT_FOUND;
			}
			ELSE {
				$link->close();
			}
		}
		
		
		public function deleteAutoteil($teilenr) {
			$link = new mysqli("localhost", "root", "", "inventur"); 
			$link->set_charset("utf8"); //nicht notwendig, da keine Zeichen in die DB geschrieben werden
			$delete_statement = "DELETE FROM inventur WHERE teilenr = $teilenr";
			$link->query($delete_statement);
			$link->close();
		}
		
		public function createTodo($autoteil) {
			if ($autoteil->name === "") {
				$result = new CreateTodoResult();
				$result->status_code = AutoTeileService::INVALID_INPUT;
				$result->validation_messages["title"] = "Der Titel ist eine Pflichtangabe. Bitte geben Sie einen Titel an.";
				return $result;
			}
			$link = new mysqli("localhost", "root", "", "inventur"); 
			$link->set_charset("utf8");
			$insert_statement = "INSERT INTO inventur SET ".
								"inventur_date = CURDATE(), ".
								"due_date = '$autoteil->due_date', ".
								"title = '$autoteil->title', ".
								"notes = '$autoteil->notes',".
								"version = 1";
			$link->query($insert_statement);
			$id = $link->insert_id;
			$link->close();
			$result = new CreateTodoResult();
			$result->status_code = AutoTeileService::OK;
			$result->id = $id;
			return $result;
		}
		
		public function readAutoteil($id) {
			$link = new mysqli("localhost", "root", "", "todolist"); 
			$link->set_charset("utf8");
			$select_statement =	"SELECT id, created_date, due_date, version, ".
								"due_date <= CURDATE() as due, author, title, notes ".
								"FROM todo ".
								"WHERE id = $id";
			$result_set = $link->query($select_statement);
			$autoteil = $result_set->fetch_object("Autoteil");
			$link->close();
			if ($autoteil === NULL) {
				return AutoTeileService::NOT_FOUND;
			}
			return $autoteil;
		}
		
		
		public function readAutoteile(){
		    $link = new mysqli("localhost", "root", "", "todolist"); 
			if ($link->connect_error !== NULL) {
				return AutoTeileService::DATABASE_ERROR;
			}
			$link->set_charset("utf8");
			$select_statement =	"SELECT id, created_date, due_date, version, ".
								"due_date <= CURDATE() as due, author, title, notes ".
								"FROM todo ".
								"ORDER BY due_date ASC";
			$result_set = $link->query($select_statement);
			
			$autoteils = array();
			$autoteil = $result_set->fetch_object("Autoteil");
			while($autoteil !== NULL) {
				$autoteils[] = $autoteil;
				$autoteil = $result_set->fetch_object("Autoteil");
				}
			$link->close();
			return $autoteils;
		}
	}
?>