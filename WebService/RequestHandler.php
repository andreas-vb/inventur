<?php
require "vendor\autoload.php";
require "IgnoreCaseMiddleware.php";
require "DenyCachingMiddleware.php";
require "Autoteil.php";
require "CreateAutoteilResult.php";
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
  "/autoteile",
  function ($request, $response) {
	$autoteil_service = new AutoTeileService();
	$autoteils = $autoteil_service->readAutoteile();
	
	foreach ($autoteils as $autoteil) {
		$autoteil->url = "/inventur/WebService/autoteile/$autoteil->id";
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
	"/autoteile/{id}",
	function ($request, $response, $id) {
		$autoteil_service = new AutoTeileService();
		$autoteil = $autoteil_service->readAutoteil($id);
		
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
	"/autoteile",
	function ($request, $response) {
		$autoteil = new Autoteil();
		$autoteil->author = $request->getParsedBodyParam("author");
		$autoteil->title = $request->getParsedBodyParam("title");
		$autoteil->inventur_date = $request->getParsedBodyParam("inventur_date");
		$autoteil->notes = $request->getParsedBodyParam("notes");
		$autoteil->farbe = $request->getParsedBodyParam("farbe");
		$autoteil->bestand = $request->getParsedBodyParam("bestand");
		$autoteil->preis = $request->getParsedBodyParam("preis");
		
		$autoteil_service = new AutoTeileService();
		$result = $autoteil_service->createAutoteil($autoteil); 
		
		if ($result->status_code === AutoTeileService::INVALID_INPUT) {
					$response = $response->withstatus(400);
					return $response->withJson($result->validation_messages);
				}
		$response = $response->withStatus(201);
		$response = $response->withHeader("Location", "/inventur/WebService/autoteile/$result->id");
		return $response;
	});	
	
$app->delete (
	"/autoteile/{id}", 
	function ($request, $response, $id) {
		$autoteil_service = new AutoTeileService();
		$autoteil_service->deleteAutoteil($id);
	});
	
$app->put(
	"/autoteile/{id}", 
	function ($request, $response, $id) {
		$autoteil = new Autoteil();
		$autoteil->id = $id;
		$autoteil->title = $request->getParsedBodyParam("title");
		$autoteil->author = $request->getParsedBodyParam("author");
		$autoteil->farbe = $request->getParsedBodyParam("farbe");
		$autoteil->bestand = $request->getParsedBodyParam("bestand");
		$autoteil->preis = $request->getParsedBodyParam("preis");
		$autoteil->inventur_date = $request->getParsedBodyParam("inventur_date");
		$autoteil->notes = $request->getParsedBodyParam("notes");
		$autoteil->version = $request->getHeaderLine("If-Match");

		if ($autoteil->title == "") {
			$validation_messages = array();
			$validation_messages["title"] = "Der Titel ist eine Pflichtangabe. Bitte geben Sie einen Titel an!";
			$response = $response->withStatus(400);
			return $response->withJson($validation_messages);
		}	

		if ($autoteil->author == "") {
			$validation_messages = array();
			$validation_messages["author"] = "Der Author ist eine Pflichtangabe. Bitte geben Sie einen Author an!";
			$response = $response->withStatus(400);
			return $response->withJson($validation_messages);
		}	

		if ($autoteil->inventur_date == "") {
			$validation_messages = array();
			$validation_messages["inventur_date"] = "Das Fälligkeitsdatum ist eine Pflichtangabe. Bitte geben Sie ein Datum an!";
			$response = $response->withStatus(400);
			return $response->withJson($validation_messages);
		}	

		if ($autoteil->notes == "") {
			$validation_messages = array();
			$validation_messages["notes"] = "Das Notizfeld ist eine Pflichtangabe. Bitte geben Sie eine Notiz ein!";
			$response = $response->withStatus(400);
			return $response->withJson($validation_messages);
		}	

		if ($autoteil->preis == "") {
			$validation_messages = array();
			$validation_messages["preis"] = "Die Preisangabe ist eine Pflichtangabe. Bitte geben Sie einen Preis in Zahlen ein!";
			$response = $response->withStatus(400);
			return $response->withJson($validation_messages);
		}

		if ($autoteil->bestand == "") {
			$validation_messages = array();
			$validation_messages["bestand"] = "Die Bestandangabe ist eine Pflichtangabe. Bitte geben Sie einen Bestand in Zahlen ein!";
			$response = $response->withStatus(400);
			return $response->withJson($validation_messages);
		}		
		
 		$autoteil_service = new AutoTeileService();
		$result = $autoteil_service->updateAutoteil($autoteil);
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
