<?php
require 'vendor/autoload.php';

// Set your secret key. Remember to switch to your live secret key in production!
\Stripe\Stripe::setApiKey('your_secret_key'); // Replace with your Stripe secret key

// Retrieve JSON from POST body
$json_str = file_get_contents('php://input');
$json_obj = json_decode($json_str);

// Extract booking data or other necessary information
$bookingData = $json_obj->bookingData;

// Calculate or retrieve amount to be charged
// For example, $amount = 1000 for a $10.00 charge
$amount = calculateAmount($bookingData); // Implement this function based on your pricing logic

try {
    // Create a new checkout session
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => 'Service Booking',
                ],
                'unit_amount' => $amount,
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => 'https://yourdomain.com/success.html?session_id={CHECKOUT_SESSION_ID}', // Replace with your success URL
        'cancel_url' => 'https://yourdomain.com/cancel.html', // Replace with your cancel URL
    ]);

    // Return session ID to the frontend
    echo json_encode(['id' => $session->id]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

// Function to calculate amount
function calculateAmount($bookingData) {
    // Implement your pricing logic here
    // Return amount in cents (for USD)
    return 1000; // Example: $10.00
}
?>
