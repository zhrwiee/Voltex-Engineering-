<?php
require 'vendor/autoload.php';

\Stripe\Stripe::setApiKey('sk_test_51OZRJYHejhKRUlQpwtUGiS0uVZmN3FKiB6XwjCJT5NSun61RdsYGN0uFMLbbgnAoThXEyRk2sIVlNl6MUDkV2giy00V2XCvcaQ'); 

$json_str = file_get_contents('php://input');
$json_obj = json_decode($json_str);

$bookingData = $json_obj->bookingData;

$serviceList = $bookingData->serviceList;
$price = getPriceFromDatabase($serviceList); 

try {
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'myr', 
                'product_data' => [
                    'name' => 'Service Deposit',
                ],
                'unit_amount' => $price, 
            ],
            'quantity' => 1,
            'tax_rates' => ['txr_1OefBAHejhKRUlQp9UfqyrOt']
        ]],
        'mode' => 'payment',
        'success_url' => 'http://localhost/Voltex/checkout-success.php?provider_session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => 'http://localhost/Voltex/book.php?provider_session_id={CHECKOUT_SESSION_ID}', 
    ]);

    echo json_encode(['id' => $session->id]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

function getPriceFromDatabase($serviceList) {

    $dbHost = 'localhost';      
    $dbUsername = 'root';   
    $dbPassword = '';  
    $dbName = 'voltexengineering';  

    $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT deposit FROM service_price WHERE services = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $serviceList);
    $stmt->execute();
    $stmt->bind_result($price);

    $stmt->fetch();

    $stmt->close();
    $conn->close();

    if ($price !== null) {
        return $price * 100;
    } else {
        return 1000; 
    }
}


?>
