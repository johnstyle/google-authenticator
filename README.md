#Google-Authenticator [![Flattr this](https://api.flattr.com/button/flattr-badge-large.png)](https://flattr.com/submit/auto?user_id=Johnstyle&url=https%3A%2F%2Fgithub.com%2Fjohnstyle%2Fgoogle-authenticator%2F)

[![Latest Stable Version](https://poser.pugx.org/johnstyle/google-authenticator/v/stable.png)](https://packagist.org/packages/johnstyle/google-authenticator)
[![Total Downloads](https://poser.pugx.org/johnstyle/google-authenticator/downloads.png)](https://packagist.org/packages/johnstyle/google-authenticator)
[![Build Status](https://travis-ci.org/johnstyle/google-authenticator.png?branch=master)](https://travis-ci.org/johnstyle/google-authenticator)
[![Dependency Status](https://www.versioneye.com/user/projects/541442669e162254b40000e5/badge.svg?style=flat)](https://www.versioneye.com/user/projects/541442669e162254b40000e5)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/1ca02d65-8610-44ac-ba40-84390b0873b5/mini.png)](https://insight.sensiolabs.com/projects/1ca02d65-8610-44ac-ba40-84390b0873b5)

Google Authenticator

##Usage

###Step 1 - Register application

```PHP
$google = new GoogleAuthenticator();

// Register application
echo $google->getQRCodeUrl('MyApplicationName');

// Save secret Key
$secretKey = $google->getSecretKey();
```

###Step 2 - Verify Code

```PHP
$google = new GoogleAuthenticator($secretKey);

// User submit code
$userSubmitCode = '';

// Verify Code
if ($google->verifyCode($userSubmitCode)) {

    // OK
}
```

##Demonstration
[Demonstration](http://github.johnstyle.fr/repository/johnstyle/google-authenticator/)
