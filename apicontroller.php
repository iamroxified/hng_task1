<?php


class apiController{
    public function hello(){
        $api = API_KEY;

// Get visitor name from query string
$visitorName = isset($_GET['visitor_name']) ? $_GET['visitor_name'] : "";
$visitorName = trim($visitorName, "\"' \t\n\r\0\x0B");

// Simulate location and temperature (replace with real IP geolocation and weather API)
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $clientIp = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $clientIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $clientIp = $_SERVER['REMOTE_ADDR'];
        }

//$location = "New York";
//$temperature = 11;

// Construct greeting message
//$greeting = "Hello, ".str_replace('\\','',$visitorName)."!, the temperature is $temperature degrees Celcius in $location";

$responses = @json_decode(file_get_contents("https://api.weatherapi.com/v1/current.json?q=$clientIp&key=$api"));


// Build response object
$response = array(
  "client_ip" => $clientIp,
  "location" => $responses->location->name,
  "greeting" => "Hello, $visitorName!, the temperature is " . $responses->current->temp_c . " degrees Celcius in " . $responses->location->name
);

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
        
    }
}