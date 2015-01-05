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

namespace Johnstyle\GoogleAuthenticator;

use Base32\Base32;

/**
 * Class GoogleAuthenticator
 *
 * @author  Jonathan Sahm <contact@johnstyle.fr>
 * @package Johnstyle\GoogleAuthenticator
 */
class GoogleAuthenticator
{
    const API_URL = 'https://chart.googleapis.com/chart?chs={chs}&chld=M|0&cht=qr&chl={chl}';
    const CODE_LENGTH = 6;
    const SECRET_LENGTH = 16;

    /** @var string $secretKey */
    protected $secretKey;

    /** @var array $base32Chars */
    protected $base32Chars = array(
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H',
        'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P',
        'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X',
        'Y', 'Z', '2', '3', '4', '5', '6', '7',
        '='
    );

    /**
     * @param  null $secretKey
     * @throws GoogleAuthenticatorException
     */
    public function __construct($secretKey = null)
    {
        $this->secretKey = $secretKey;

        if (is_null($this->secretKey)) {

            $this->secretKey = $this->generateSecretKey();
        }

        if(static::SECRET_LENGTH !== strlen($this->secretKey)
            || 0 !== count(array_diff(str_split($this->secretKey), $this->base32Chars))) {

            throw new GoogleAuthenticatorException('Invalid secret key');
        }
    }

    /**
     * @return string
     */
    public function generateSecretKey()
    {
        $base32Chars = $this->base32Chars;

        unset($base32Chars[32]);

        $secretKey = '';

        for ($i = 0; $i < static::SECRET_LENGTH; $i++) {

            $secretKey .= $base32Chars[array_rand($base32Chars)];
        }

        return $secretKey;
    }

    /**
     * @param  string $applicationName
     * @param  int    $size
     * @return mixed
     */
    public function getQRCodeUrl($applicationName, $size = 200)
    {
        return str_replace(
            array(
                '{chs}',
                '{chl}'
            ),
            array(
                $size . 'x' . $size,
                urlencode('otpauth://totp/' . $applicationName . '?secret=' . $this->getSecretKey())
            ),
            static::API_URL
        );
    }

    /**
     * @return string
     */
    public function getSecretKey()
    {
        return $this->secretKey;
    }

    /**
     * @param  string $code
     * @param  int    $range
     * @return bool
     */
    public function verifyCode($code, $range = 1)
    {
        $timeIndex = $this->getTimeIndex();

        for ($i = -$range; $i <= $range; $i++) {

            if (((string) $code) === $this->getCode($timeIndex + $i)) {

                return true;
            }
        }

        return false;
    }

    /**
     * @param  int $timeIndex
     * @return string
     */
    public function getCode($timeIndex = null)
    {
        if (is_null($timeIndex)) {

            $timeIndex = $this->getTimeIndex();
        }

        $secretkey = Base32::decode($this->secretKey);

        $hm = hash_hmac('SHA1', chr(0) . chr(0) . chr(0) . chr(0) . pack('N*', $timeIndex), $secretkey, true);

        $value = unpack('N', substr($hm, ord(substr($hm, -1)) & 0x0F, 4));

        $value = $value[1] & 0x7FFFFFFF;

        return str_pad($value % pow(10, static::CODE_LENGTH), static::CODE_LENGTH, '0', STR_PAD_LEFT);
    }

    /**
     * @return int
     */
    public function getTimeIndex()
    {
        return floor(time() / 30);
    }
}
