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
