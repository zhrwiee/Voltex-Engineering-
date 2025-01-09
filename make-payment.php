<?php
require_once 'config.php';
require_once 'stripe-php-10.3.0/init.php';
require_once __DIR__ . '/vendor/autoload.php';
include ('connect-server.php');

use Stripe\Stripe;

$stripe = new \Stripe\StripeClient(STRIPE_SECRET_KEY);

// Check if the service_id is provided in the POST request
if (isset($_POST['service_id'])) {
    $service_id = $_POST['service_id'];

    // Fetch service details from the database
    $select_service = mysqli_query($conn, "SELECT * FROM `services_record` WHERE service_id = '$service_id'") or die('query failed');
    if ($select_service && mysqli_num_rows($select_service) > 0) {
        $fetch_row = mysqli_fetch_assoc($select_service);

        // Fetch unit price from the service_price table based on service_type
        $service_type = $fetch_row['service_type'];
        $fetch_price = mysqli_query($conn, "SELECT price FROM `service_price` WHERE services = '$service_type'") or die('price query failed');
        $price_row = mysqli_fetch_assoc($fetch_price);
        $unit_price = $price_row['price'];

        // Create line items based on the fetched service details
        $lineItems = [
            [
                'price_data' => [
                    'currency' => 'myr',
                    'product_data' => [
                        'name' => $fetch_row['service_type'],
                    ],
                    'unit_amount' => $unit_price * 100, // Convert to cents
                ],
                'quantity' => 1,
                'tax_rates' => [STRIPE_TAX_RATE_ID]
            ]
            // Add more line items if needed
        ];

        // Create Stripe checkout session
        $checkoutSession = $stripe->checkout->sessions->create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => 'http://localhost/Voltex/checkout-success.php?provider_session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => 'http://localhost/Voltex/view-details.php?provider_session_id={CHECKOUT_SESSION_ID}',
        ]);

        // Store the checkout session ID in a session variable for use in checkout-success.php
        $_SESSION['checkout_session_id'] = $checkoutSession->id;

        // Redirect to the payment page
        header('Location: ' . $checkoutSession->url);
        exit;
    } else {
        // Service details not found, handle the error or redirect accordingly
        echo "Service details not found.";
    }
} else {
    // Redirect or handle the case where service_id is not provided
    echo "Service ID not provided.";
}
?>
