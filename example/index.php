<?php
/**
 * GoogleAuthenticator
 *
 * PHP version 5
 *
 * @package  Johnstyle\GoogleAuthenticator
 * @author   Jonathan Sahm <contact@johnstyle.fr>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/johnstyle/google-authenticator
 */

use Johnstyle\GoogleAuthenticator\GoogleAuthenticator;

include '../vendor/autoload.php';

// /!\ For example ! Don't POST secret key !!
$secretKey = isset($_POST['secretKey']) ? $_POST['secretKey'] : null;

$gAuth = new GoogleAuthenticator($secretKey);

$success = false;
$step = isset($_POST['step']) ? (int) $_POST['step'] : 1;
$code = isset($_POST['code']) ? $_POST['code'] : 0;

if(0 !== $code
    && $gAuth->verifyCode($code)) {

    $step++;
    $success = true;
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Google Authenticator</title>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        <style type="text/css">
            *{margin:0;padding:0}
            body{color:#FEFEFE;background:#4A4E4F;font-family:'Open Sans', sans-serif;font-size:16px;line-height:2}
            h1{color:#F15841;font-size:30px}
            h2{color:#30B257;font-size:20px}
            a{color:#9DA08D}
            .container{width:80%;margin:100px auto;text-align:center}
            .qrcode{padding:10px;background:#fff;width:200px;height:200px;margin:20px auto;line-height:0;box-shadow:0 0 10px rgba(0,0,0,0.75)}
            form{width:250px;margin:20px auto}
            input{border:1px solid #000;font-size:20px;padding:5px 10px;text-align:center;width:128px;float:left}
            button{font-size:20px;padding:5px 0;float:right;width:100px;border:0;background:#000000;color:#fff;cursor:pointer}
            .error{background:#F15841;color:#fff;margin:20px auto;padding:5px;text-align:center;width:240px}
            .success{background:#30B257;color:#fff;margin:20px auto;padding:5px;text-align:center;width:240px}
        </style>
    </head>
    <body>
        <div class="container">
            <?php if(1 === $step): ?>
                <h1>1 - Register application</h1>
                <h2>a. Scan this QRCode with your smarphone</h2>
                <p>
                    Use Google Authenticator for mobile
                    <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2" target="_blank">Android</a>
                    or
                    <a href="https://itunes.apple.com/fr/app/google-authenticator/id388497605" target="_blank">iPhone</a>
                </p>
                <div class="qrcode"><img src="<?php echo $gAuth->getQRCodeUrl('MyApplicationName'); ?>" alt=""/></div>
                <h2>b. Copy/paste vérification code</h2>
                <form method="post">
                    <!-- /!\ For example ! Don't POST secret key !! -->
                    <input placeholder="secretKey" type="hidden" name="secretKey" value="<?php echo $gAuth->getSecretKey(); ?>"/>
                    <input placeholder="code" type="text" name="code" maxlength="6"/>
                    <button>Register</button>
                    <div style="clear:both"></div>
                </form>
            <?php else: ?>
                <h1>2 - Use Google Authenticator for signin</h1>
                <form method="post">
                    <!-- /!\ For example ! Don't POST secret key !! -->
                    <input placeholder="secretKey" type="hidden" name="secretKey" value="<?php echo $gAuth->getSecretKey(); ?>"/>
                    <input name="step" type="hidden" value="3"/>
                    <input placeholder="code" type="text" name="code" maxlength="6"/>
                    <button>Signin</button>
                    <div style="clear:both"></div>
                </form>
                <?php if(true == $success && 4 === $step): ?>
                    <div class="success">The code is correct</div>
                <?php endif; ?>
            <?php endif; ?>
            <?php if(0 !== $code && false === $success): ?>
                <div class="error">The code is incorrect</div>
            <?php endif; ?>
        </div>
    </body>
</html>
