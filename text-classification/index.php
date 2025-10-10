<?php

$api_url = 'http://127.0.0.1:5000/predict_sentiment'; // Replace with the actual URL of your Python API endpoint
$text_to_analyze = 'pangit'; // Replace with the text you want to analyze

$data = json_encode(array('text' => $text_to_analyze));

$ch = curl_init($api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

if ($http_code == 200) {
    $result = json_decode($response, true);
    if ($result) {
        echo "Predicted Sentiment: " . $result['sentiment'] . "<br>";
        echo "Confidence: " . $result['confidence'] . "<br>";
    } else {
        echo "Error decoding JSON response.<br>";
    }
} else {
    echo "Error: API request failed with HTTP code " . $http_code . "<br>";
    echo "Response: " . $response . "<br>";
}
