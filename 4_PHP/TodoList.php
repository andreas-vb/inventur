<?php
require "TodoFunctions.php";
$todos = read_todos();
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
      <h1>Todo-Liste</h1>
      <a id="home" href="TodoList.html"><img src="images/home.png" alt=""/></a>
    </div>
    <div>
      <form action="..." method="post">
        <input type="text" name="username" id="username"/>
        <input type="image" name="logon" src="images/logon.png" alt="Anmelden" id="logon"/>
      </form>
      <img src="images/blank.png" alt=""/>
    </div>
    <div>
      <table>
        <tr>
          <th>
            <a href="...">Fällig+</a>          
          </th>
          <th>
            <a href="...">Titel</a>
          </th>
          <th>
            <a href="...">Autor</a>
          </th>
          <th>Aktionen</th>
        </tr>
        <?php foreach ($todos as $todo) { ?>
		<tr class="<?php if ($todo["due"] === TRUE) echo "due"; ?>">
          <td><?php echo $todo["due_date"]; ?></td>
          <td><a class="<?php if ($todo["due"] === "1") echo "due"; ?>" href="TodoDetails.php?id=<?php echo $todo["id"]; ?>"><?php echo htmlspecialchars($todo["title"]); ?></a></td>
          <td><?php echo $todo["author"]; ?></td>
          <td></td>
        </tr>
		<?php } ?>
      </table>
      <span id="pagesize_selector">
        Anzahl:
        <a href="...">5</a>
        <span class="disabled">10</span>
        <a href="...">20</a>
        <a href="...">50</a>
      </span>
    </div>
  </body>
</html>