<!-- <?php 

$method = $_SERVER['REQUEST_METHOD'];

// Process only when method is POST
if($method == 'POST'){
	$requestBody = file_get_contents('php://input');
	$json = json_decode($requestBody);

	$text = $json->result->parameters->text;

	switch ($text) {
		case 'hi':
			$speech = "Hi, Nice to meet you";
			break;

		case 'bye':
			$speech = "Bye, good night";
			break;

		case 'anything':
			$speech = "Yes, you can type anything here.";
			break;
		
		default:
			$speech = "Sorry, I didnt get that. Please ask me something else.";
			break;
	}

	$response = new \stdClass();
	$response->speech = $speech;
	$response->displayText = $speech;
	$response->source = "webhook";
	echo json_encode($response);
}
else
{
	echo "Method not allowed";
}

?> -->


<?php
require __DIR__ . "/vendor/autoload.php";
$dotenv = Dotenv\Dotenv::create(__DIR__);

$dotenv->load();

function getWeatherData($command)
{
    //clean user data
    $location = explode("-", $command);
    if ($location[0] === 'WN') {
        try {
            $data = [
          'q' => $location[1],
          'appid' => getenv("OPEN_WEATHER_API_KEY"),
          'units' => 'metric'
        ];
            $url = getenv("OPEN_WEATHER_API_URL");
            $query_url = sprintf("%s?%s", $url, http_build_query($data));
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $query_url);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 10);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
            $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $result = curl_exec($curl);
            header('Content-type: application/json');
            $weather_data = json_decode($result, true);
            $response = [
          'weather' => $weather_data['weather'][0]['description'],
          'temp' => $weather_data['main']['temp']
        ];
            return $response;
            curl_close($curl);
        } catch (exception $e) {
            print_r($e);
        }
    }
}

