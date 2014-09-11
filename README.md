#Google-Authenticator
====================

[![Latest Stable Version](https://poser.pugx.org/johnstyle/google-authenticator/v/stable.png)](https://packagist.org/packages/johnstyle/google-authenticator)
[![Total Downloads](https://poser.pugx.org/johnstyle/google-authenticator/downloads.png)](https://packagist.org/packages/johnstyle/google-authenticator)
[![Build Status](https://travis-ci.org/johnstyle/google-authenticator.png?branch=master)](https://travis-ci.org/johnstyle/google-authenticator)
[![Flattr this](https://api.flattr.com/button/flattr-badge-large.png)](https://flattr.com/submit/auto?user_id=Johnstyle&url=https%3A%2F%2Fgithub.com%2Fjohnstyle%2Fgoogle-authenticator%2F)

Google Authenticator

##Usage

###Step 1 - Register application

    $google = new GoogleAuthenticator();

    // Register application
    echo $google->getQRCodeUrl('MyApplicationName');

    // Save secret Key
    $secretKey = $google->getSecretKey();


###Step 2 - Verify Code

    $google = new GoogleAuthenticator($secretKey);

    // User submit code
    $userSubmitCode = '';

    // Verify Code
    if ($google->verifyCode($userSubmitCode)) {

        // OK
    }

##Demonstration
[Demonstration](http://github.johnstyle.fr/repository/johnstyle/google-authenticator/)
