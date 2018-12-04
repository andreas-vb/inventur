<?php
require "TodoFunctions.php";
$autoteils = read_todos();
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
        <?php foreach ($autoteils as $autoteil) { ?>
		<tr class="<?php if ($autoteil["due"] === TRUE) echo "due"; ?>">
          <td><?php echo $autoteil["due_date"]; ?></td>
          <td><a class="<?php if ($autoteil["due"] === "1") echo "due"; ?>" href="TodoDetails.php?id=<?php echo $autoteil["id"]; ?>"><?php echo htmlspecialchars($autoteil["title"]); ?></a></td>
          <td><?php echo $autoteil["author"]; ?></td>
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