<?php

/*
 * STARTER-KIT-SYMFONY
 * PHP version 7.
 *
 * @category App\Controller
 *
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 *
 * @see     https://github.com/madbrain67/STARTER-KIT-SYMFONY
 */

namespace App\Api\Google\Recaptcha;

/*
 * STARTER-KIT-SYMFONY
 * PHP version 7.
 *
 * @category App\Controller
 *
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 *
 * @see     https://github.com/madbrain67/STARTER-KIT-SYMFONY
 */
class Recaptcha
{
    /**
     * Variable $this->_publicKey.
     *
     * @var string
     */
    private $_publicKey;

    /**
     * Variable $this->_privateKey.
     *
     * @var string
     */
    private $_privateKey;

    /**
     * Void __construct().
     *
     * @param string $publicKey  comment
     * @param string $privateKey comment
     */
    public function __construct(string $publicKey, string $privateKey)
    {
        $this->_publicKey = $publicKey;
        $this->_privateKey = $privateKey;
    }

    /**
     * Get variable $this->_publicKey.
     *
     * @return string
     */
    public function getPublicKey()
    {
        return $this->_publicKey;
    }

    /**
     * Get variable $this->_privateKey.
     *
     * @return string
     */
    public function getPrivateKey()
    {
        return $this->_privateKey;
    }

    /**
     * Function recaptchaCheck.
     *
     * @param string $postCaptcha comment
     *
     * @return object|void
     */
    public function recaptchaCheck(string $postCaptcha)
    {
        $reCaptcha = new ReCaptchaLib();
        $reCaptcha->reCaptcha($this->getPrivateKey());

        $response = $reCaptcha->verifyResponse(
            $_SERVER['REMOTE_ADDR'],
            $postCaptcha
        );

        return $response;
    }
}
