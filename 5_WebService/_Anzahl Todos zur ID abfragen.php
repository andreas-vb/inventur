$select_statement = "SELECT COUNT(*) FROM todo WHERE id = $autoteil->id";
$result_set = $link->query($select_statement);
$row = $result_set->fetch_row();
$count = intval($row[0]);