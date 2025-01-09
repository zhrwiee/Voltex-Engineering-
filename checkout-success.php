<?php
require_once 'config.php';
require_once 'stripe-php-10.3.0/init.php';
require_once __DIR__ . '/vendor/autoload.php';
include('connect-server.php');

$stripe = new \Stripe\StripeClient(STRIPE_SECRET_KEY);

if (isset($_GET['provider_session_id'])) {

        echo "Payment successful! Redirecting...";

        header('Location: http://localhost/Voltex/book.php?tab=4');
exit;
    } else {
        echo "Payment successful, but failed to update service record. Please contact support.";
    }
?>