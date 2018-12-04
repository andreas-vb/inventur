<?php
require "vendor\autoload.php";
require "IgnoreCaseMiddleware.php";
require "DenyCachingMiddleware.php";
require "Autoteil.php";
require "CreateTodoResult.php";
require "AutoTeileService.php";

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
	$todo_service = new AutoTeileService();
	$todos = $todo_service->readTodos();
	
	foreach ($todos as $todo) {
		$todo->url = "/inventur/5_WebService/todos/$todo->id";
		unset($todo->id);
	}
	
	
	if ($todos === AutoTeileService::DATABASE_ERROR) {
		$response = $response->withStatus(500);
		return $response;
	}
	
	$response = $response->withJson($todos);
	return $response;
  });
  
$app->get(
	"/todos/{id}",
	function ($request, $response, $id) {
		$todo_service = new AutoTeileService();
		$todo = $todo_service->readTodo($id);
		
		if ($todo === AutoTeileService::NOT_FOUND) {
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
		$todo = new Autoteil();
		$todo->title = $request->getParsedBodyParam("title");
		$todo->due_date = $request->getParsedBodyParam("due_date");
		$todo->notes = $request->getParsedBodyParam("notes");
		
		$todo_service = new AutoTeileService();
		$result = $todo_service->createTodo($todo); 
		
		if ($result->status_code === AutoTeileService::INVALID_INPUT) {
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
		$todo_service = new AutoTeileService();
		$todo_service->deleteTodo($id);
	});
	
$app->put(
	"/todos/{id}", 
	function ($request, $response, $id) {
		$todo = new Autoteil();
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
		
 		$todo_service = new AutoTeileService();
		$result = $todo_service->updateTodo($todo);
		if ($result === AutoTeileService::VERSION_OUTDATED) {
			$response = $response->withStatus(412);
			return $response;
		}
		if ($result === AutoTeileService::NOT_FOUND) {
			$response = $response->withStatus(404);
			return $response;		
		}
	});

$app->run();
?>
