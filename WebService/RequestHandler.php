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
	$autoteil_service = new AutoTeileService();
	$autoteils = $autoteil_service->readTodos();
	
	foreach ($autoteils as $autoteil) {
		$autoteil->url = "/inventur/WebService/todos/$autoteil->id";
		unset($autoteil->id);
	}
	
	
	if ($autoteils === AutoTeileService::DATABASE_ERROR) {
		$response = $response->withStatus(500);
		return $response;
	}
	
	$response = $response->withJson($autoteils);
	return $response;
  });
  
$app->get(
	"/todos/{id}",
	function ($request, $response, $id) {
		$autoteil_service = new AutoTeileService();
		$autoteil = $autoteil_service->readTodo($id);
		
		if ($autoteil === AutoTeileService::NOT_FOUND) {
			$response = $response->withStatus(404);
			return $response;
		}
		
		unset($autoteil->id);
		$response = $response->withHeader("Etag", $autoteil->version);
		unset($autoteil->version);
		$response = $response->withJson($autoteil);
		return $response;
	});

$app->post(
	"/todos",
	function ($request, $response) {
		$autoteil = new Autoteil();
		$autoteil->title = $request->getParsedBodyParam("title");
		$autoteil->due_date = $request->getParsedBodyParam("due_date");
		$autoteil->notes = $request->getParsedBodyParam("notes");
		
		$autoteil_service = new AutoTeileService();
		$result = $autoteil_service->createTodo($autoteil); 
		
		if ($result->status_code === AutoTeileService::INVALID_INPUT) {
					$response = $response->withstatus(400);
					return $response->withJson($result->validation_messages);
				}
		$response = $response->withStatus(201);
		$response = $response->withHeader("Location", "/inventur/WebService/todos/$result->id");
		return $response;
	});	
	
$app->delete (
	"/todos/{id}", 
	function ($request, $response, $id) {
		$autoteil_service = new AutoTeileService();
		$autoteil_service->deleteTodo($id);
	});
	
$app->put(
	"/todos/{id}", 
	function ($request, $response, $id) {
		$autoteil = new Autoteil();
		$autoteil->id = $id;
		$autoteil->title = $request->getParsedBodyParam("title");
		$autoteil->due_date = $request->getParsedBodyParam("due_date");
		$autoteil->notes = $request->getParsedBodyParam("notes");
		$autoteil->version = $request->getHeaderLine("If-Match");

		if ($autoteil->title == "") {
			$validation_messages = array();
			$validation_messages["title"] = "Der Titel ist eine Pflichtangabe. Bitte geben Sie einen Titel an.";
			$response = $response->withStatus(400);
			return $response->withJson($validation_messages);
		}		
		
 		$autoteil_service = new AutoTeileService();
		$result = $autoteil_service->updateTodo($autoteil);
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
