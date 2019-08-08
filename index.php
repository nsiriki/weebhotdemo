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
	
	
	$response = new \stdClass();
	//$response->speech = $text;
	$response->payload->google->expectUserResponse->richResponse->items[0]->simpleResponse->textToSpeech = $text;
	//$response->source = "webhook";
	echo json_encode($response);
	
	
}
else
{
	echo "Method not allowed";
}

?> 
