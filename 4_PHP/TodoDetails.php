<?php 
require "TodoFunctions.php";
$id = $_REQUEST["id"];
$todo = read_todo($id);
?>

<!DOCTYPE html> 
<html>
  <head>
    <meta charset="utf-8"/>
    <title>Todo-Liste</title>
    <link rel="stylesheet" type="text/css" href="css/common.css"/>  
  </head>
  <body>
    <div id="header">
      <h1><?php echo htmlspecialchars($todo["title"]); ?></h1>
      <a href="TodoList.html" id="home"><img src="images/home.png" alt=""/></a>
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
      <form action="..." method="post">
        <table>
          <tr>
            <td>
              <label for="due_date">Fällig</label><span class="label">, </span>
              <label for="author">Autor:</label></td>
            <td id="due_date_td">
              <input type="text" name="due_date" id="due_date" value= "<?php echo $todo["due_date"]; ?>" readonly="readonly" disabled="disabled"/>
            </td>
            <td id="created_date_td">
              <input type="text" name="created_date" id="created_date" value= "<?php echo $todo["created_date"]; ?>" readonly="readonly" disabled="disabled"/>
            </td>
            <td id="author_td">
              <input type="text" name="author" id="author" value= "<?php echo $todo["author"]; ?>" readonly="readonly" disabled="disabled" />
            </td>
          </tr>
          <tr>
            <td><label for="notes">Notizen:</label></td>
            <td colspan="3">
              <textarea name="notes" id="notes" rows="10" cols="10" readonly="readonly" disabled="disabled"><?php echo htmlspecialchars($todo["notes"]); ?></textarea>
            </td>
          </tr>
          <tr>
            <td id="buttons" colspan="4">
              <input type="submit" name="delete" value="Löschen"/>
            </td>
          </tr>
        </table>
      </form>
    </div>
  </body>
</html>