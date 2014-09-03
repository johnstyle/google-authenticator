Google-Authenticator
====================

Google Authenticator

##Step 1 - Register application

    $google = new GoogleAuthenticator();

    // Register application
    echo $google->getQRCodeUrl('MyApplicationName');

    // Save secret Key
    $secretKey = $google->getSecretKey();


##Step 2 - Verify Code

    $google = new GoogleAuthenticator($secretKey);

    // User submit code
    $userSubmitCode = '';

    // Verify Code
    if ($google->verifyCode($userSubmitCode)) {

        // OK
    }
