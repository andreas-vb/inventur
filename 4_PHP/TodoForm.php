<?php

require "TodoFunctions.php";

if ($_SERVER["REQUEST_METHOD"] === "GET") {
	$autoteil = array ();
	$autoteil["title"] = "";
	$autoteil["due_date"] = "";
	$autoteil["notes"] = "";
}

	if (isset($_REQUEST["cancel"])) {
		header("Location: Index.php");	
		exit();
	}
	if (isset($_REQUEST["save"])) {
		$autoteil = array();
		$autoteil["title"] = $_REQUEST["title"];
		$autoteil["due_date"] = $_REQUEST["due_date"];
		$autoteil["notes"] = $_REQUEST["notes"];
		$created = create_todo($autoteil);
		if ($created === TRUE) {
			header("Location: Index.php");
			exit();
		}
	}
	?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    <title>Todo-Liste</title>
    <link rel="stylesheet" type="text/css" href="./css/common.css"/>  
  </head>
  <body>
    <div id="header">
      <h1>Neues Todo</h1>
      <a id="home" href="./index.php"><img src="images/home.png" alt=""/></a>
    </div>
    <div>
      <ul>
        <li><a href="TodoForm.php">Neues Todo</a></li>
      </ul>
      <form id="logoff_form" action="..." method="post">
        <span id="username">Marc</span>
        <input type="image" name="logoff" src="images/logoff.png" alt="Abmelden" id="logoff"/>
      </form>
      <img src="images/blank.png" alt=""/>
    </div>
    <div>
      <form action="TodoForm.php" method="post">
        <table>
		<?php if (isset($created) && $created === FALSE) { ?>
		<tr class="validation_message">
			<td></td>
			<td colspan="2">Bitte geben Sie einen Titel an.</td>
			</tr>
			<?php } ?>
          <tr>
            <td><label for="due_date">Fällig</label><span class="label">, </span>
                 <label for="title">Titel:</label></td>
            <td id="due_date_td">
              <input type="text" name="due_date" id="due_date" value="<?php echo $autoteil["due_date"]; ?>" />
            </td>
            <td id="title_td">
              <input type="text" name="title" id="title" value="<?php echo $autoteil["title"]; ?>" />
            </td>
          </tr>
          <tr>
            <td><label for="notes">Notizen:</label></td>
            <td colspan="2">
              <textarea name="notes" id="notes" rows="10" cols="10"><?php echo $autoteil["notes"]; ?></textarea>
            </td>
          </tr>
          <tr>
            <td id="buttons" colspan="3">
              <img src="images/blank.png" alt=""/>
              <input type="submit" name="cancel" value="Abbrechen"/>
              <input type="submit" name="save" value="Speichern"/>
            </td>
          </tr>
        </table>
      </form>
    </div>
  </body>
</html>
