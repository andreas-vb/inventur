<?php
require "vendor\autoload.php";
require "IgnoreCaseMiddleware.php";
require "DenyCachingMiddleware.php";
require "Todo.php";
require "TodoService.php";

$config = [
    "settings" => [ 
      "displayErrorDetails" => true,
    ],
    "foundHandler" => function() {
      return new \Slim\Handlers\Strategies\RequestResponseArgs();
    }
];

$app = new \Slim\App($config);
$app->add(new IgnoreCaseMiddleware());
//$app->add(new DenyCachingMiddleware());

$app->get(
  "/todos",
  function ($request, $response) {
	$todo_service = new TodoService();
	$todos = $todo_service->readTodos();
	
	foreach ($todos as $todo) {
		$todo->url = "/andreas-vb/5_WebService/todos/$todo->id";
		unset($todo->id);
	}
	
	
	if ($todos === TodoService::DATABASE_ERROR) {
		$response = $response->withStatus(500);
		return $response;
	}
	
	$response = $response->withJson($todos);
	return $response;
  });
  
$app->get(
	"/todos/{id}",
	function ($request, $response, $id) {
		$todo_service = new TodoService();
		$todo = $todo_service->readTodo($id);
		if ($todo === TodoService::NOT_FOUND) {
			$response = $response->withStatus(404);
			return $response;
		}
		unset($todo->id);
		$response = $response->withJson($todo);
		return $response;
	});

$app->post (
	"/todos",
	function ($request, $response) {
		$response = $response->withStatus(201);
		$response = $response->withHeader("Location", "/andreas-vb/5_WebService/todos/9999");
		return $response;
	});	
	
	
$app->run();
?>
