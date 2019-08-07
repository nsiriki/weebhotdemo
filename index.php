 <?php 

$method = $_SERVER['REQUEST_METHOD'];

// Process only when method is POST
if($method == 'POST'){
	$requestBody = file_get_contents('php://input');
	$json = json_decode($requestBody);

	$speech = $json->queryResult->parameters->text;

	switch ($speech) {
		case 'hi':
			$text = "Hi, Nice to meet you";
			break;

		case 'bye':
			$text = "Bye, good night";
			break;

		case 'anything':
			$text = "Yes, you can type anything here.";
			break;
		
		default:
			$text = "Sorry, I didnt get that. Please ask me something else.";
			break;
	}

	$agent = \Dialogflow\WebhookClient::fromData($request->json()->all());
	$intent = $agent->getIntent();
	
	$response = new \stdClass();
	//$response->speech = $text;
	$response->text = $agent->getIntent();
	$response->queryResult->fulfillmentMessages->text->text = "webhook";
	echo json_encode($response);
}
else
{
	echo "Method not allowed";
}

?> 


