<?php
	class AutoTeileService {
		const DATABASE_ERROR = "DATABASE_ERROR";
		const NOT_FOUND = "NOT_FOUND";
		const INVALID_INPUT = "INVALID_INPUT";
		const OK = "OK";
		const VERSION_OUTDATED = "VERSION_OUTDATED";
		const SQL_STATEMENT_WRONG_RESULT = "WRONG_SQL_STATEMENT_RESULT";
		
		public function updateAutoteil($autoteil) {
			$link = new mysqli("localhost", "root", "", "inventur"); 
			$link->set_charset("utf8");
			$update_statement = "UPDATE inventur SET ".
								"title = '$autoteil->title', ".
								"inventur_date = '$autoteil->inventur_date', ".
								"notes = '$autoteil->notes', ".
								"farbe = '$autoteil->farbe', ".
								"bestand = '$autoteil->bestand', ".
								"preis = '$autoteil->preis', ".
								"author = '$autoteil->author', ".
								"version = version + 1 ".
								"WHERE id = $autoteil->id AND version = $autoteil->version";
			$link->query($update_statement);
			$affected_rows = $link->affected_rows;
			if ($affected_rows === 0) {
				$select_statement = "SELECT COUNT(*) FROM inventur WHERE id = $autoteil->id";
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
		
		
		public function deleteAutoteil($id) {
			$link = new mysqli("localhost", "root", "", "inventur"); 
			$link->set_charset("utf8"); //nicht notwendig, da keine Zeichen in die DB geschrieben werden
			$delete_statement = "DELETE FROM inventur WHERE id = $id";
			$link->query($delete_statement);
			$link->close();
		}
		
		public function createAutoteil($autoteil) {
			if ($autoteil->title === "") {
				$result = new CreateAutoteilResult();
				$result->status_code = AutoTeileService::INVALID_INPUT;
				$result->validation_messages["title"] = "Der Titel ist eine Pflichtangabe. Bitte geben Sie einen Titel an.";
				return $result;
			}
			
			if ($autoteil->author === "") {
				$result = new CreateAutoteilResult();
				$result->status_code = AutoTeileService::INVALID_INPUT;
				$result->validation_messages["title"] = "Der Author ist eine Pflichtangabe. Bitte geben Sie einen Author an.";
				return $result;
			}
			
			if ($autoteil->inventur_date === "") {
				$result = new CreateAutoteilResult();
				$result->status_code = AutoTeileService::INVALID_INPUT;
				$result->validation_messages["title"] = "Das Fälligkeitsdatum ist eine Pflichtangabe. Bitte geben Sie einen Datum an.";
				return $result;
			}
			
			$link = new mysqli("localhost", "root", "", "inventur"); 
			$link->set_charset("utf8");
			$insert_statement = "INSERT INTO inventur SET ".
								"inventur_date = '$autoteil->inventur_date', ".
								"author = '$autoteil->author', ".
								"title = '$autoteil->title', ".
								"notes = '$autoteil->notes', ".
								"farbe = '$autoteil->farbe', ".
								"preis = '$autoteil->preis', ".
								"bestand = '$autoteil->bestand', ".
								"version = 1";
			$link->query($insert_statement);
			$id = $link->insert_id;
			$link->close();
			$result = new CreateAutoteilResult();
			$result->status_code = AutoTeileService::OK;
			$result->id = $id;
			return $result;
		}
		
		public function readAutoteil($id) {
			$link = new mysqli("localhost", "root", "", "inventur"); 
			$link->set_charset("utf8");
			$select_statement =	"SELECT id, inventur_date, version, ".
								"inventur_date <= CURDATE() as due, author, title, notes, bestand, farbe, preis ".
								"FROM inventur ".
								"WHERE id = $id";
			$result_set = $link->query($select_statement);
			if( !$result_set)
				die(AutoTeileService::SQL_STATEMENT_WRONG_RESULT);
			$autoteil = $result_set->fetch_object("Autoteil");
			$link->close();
			if ($autoteil === NULL) {
				return AutoTeileService::NOT_FOUND;
			}
			return $autoteil;
		}
		
		
		public function readAutoteile(){
		    $link = new mysqli("localhost", "root", "", "inventur"); 
			if ($link->connect_error !== NULL) {
				return AutoTeileService::DATABASE_ERROR;
			}
			$link->set_charset("utf8");
			$select_statement =	"SELECT id, inventur_date, version, ".
								"inventur_date <= CURDATE() as due, author, title, notes, bestand, preis, farbe ".
								"FROM inventur ".
								"ORDER BY inventur_date ASC";
			$result_set = $link->query($select_statement);
			if( !$result_set)
				die(AutoTeileService::SQL_STATEMENT_WRONG_RESULT);
			
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