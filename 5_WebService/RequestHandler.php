<?php
require "vendor\autoload.php";
require "IgnoreCaseMiddleware.php";
require "DenyCachingMiddleware.php";
require "Todo.php";
require "CreateTodoResult.php";
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
$app->add(new DenyCachingMiddleware());

$app->get(
  "/todos",
  function ($request, $response) {
	$todo_service = new TodoService();
	$todos = $todo_service->readTodos();
	
	foreach ($todos as $todo) {
		$todo->url = "/inventur/5_WebService/todos/$todo->id";
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
		$response = $response->withHeader("Etag", $todo->version);
		unset($todo->version);
		$response = $response->withJson($todo);
		return $response;
	});

$app->post(
	"/todos",
	function ($request, $response) {
		$todo = new Todo();
		$todo->title = $request->getParsedBodyParam("title");
		$todo->due_date = $request->getParsedBodyParam("due_date");
		$todo->notes = $request->getParsedBodyParam("notes");
		
		$todo_service = new TodoService();
		$result = $todo_service->createTodo($todo); 
		
		if ($result->status_code === TodoService::INVALID_INPUT) {
					$response = $response->withstatus(400);
					return $response->withJson($result->validation_messages);
				}
		$response = $response->withStatus(201);
		$response = $response->withHeader("Location", "/inventur/5_WebService/todos/$result->id");
		return $response;
	});	
	
$app->delete (
	"/todos/{id}", 
	function ($request, $response, $id) {
		$todo_service = new TodoService();
		$todo_service->deleteTodo($id);
	});
	
$app->put(
	"/todos/{id}", 
	function ($request, $response, $id) {
		$todo = new Todo();
		$todo->id = $id;
		$todo->title = $request->getParsedBodyParam("title");
		$todo->due_date = $request->getParsedBodyParam("due_date");
		$todo->notes = $request->getParsedBodyParam("notes");
		$todo->version = $request->getHeaderLine("If-Match");

		if ($todo->title == "") {
			$validation_messages = array();
			$validation_messages["title"] = "Der Titel ist eine Pflichtangabe. Bitte geben Sie einen Titel an.";
			$response = $response->withStatus(400);
			return $response->withJson($validation_messages);
		}		
		
 		$todo_service = new TodoService();
		$result = $todo_service->updateTodo($todo);
		if ($result === TodoService::VERSION_OUTDATED) {
			$response = $response->withStatus(412);
			return $response;
		}
		if ($result === TodoService::NOT_FOUND) {
			$response = $response->withStatus(404);
			return $response;		
		}
	});

$app->run();
?>
