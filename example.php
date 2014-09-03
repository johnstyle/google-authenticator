<?php

use Johnstyle\GoogleAuthenticator\GoogleAuthenticator;

include 'vendor/autoload.php';

/**
 * Step 1 - Register application
 */
$google = new GoogleAuthenticator();

// Register application
echo $google->getQRCodeUrl('MyApplicationName') . "\n";

// Save secret Key
$secretKey = $google->getSecretKey();

/**
 * Step 2 - Check code
 */
$google = new GoogleAuthenticator($secretKey);

// User submit code
$userSubmitCode = '';

// Verify Code
if ($google->verifyCode($userSubmitCode)) {

    // OK
}
