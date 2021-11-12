<?php

/**
 * STARTER-KIT-SYMFONY
 * PHP version 7.
 *
 * @category App\Service
 *
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 *
 * @see     https://github.com/madbrain67/STARTER-KIT-SYMFONY
 */

namespace App\Service\Token;

/*
 * STARTER-KIT-SYMFONY
 * PHP version 7.
 *
 * @category App\Service
 *
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 *
 * @see     https://github.com/madbrain67/STARTER-KIT-SYMFONY
 */

use Symfony\Component\HttpFoundation\Session\Session;

/**
 * STARTER-KIT-SYMFONY
 * PHP version 7.
 *
 * @category App\Service
 *
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 *
 * @see     https://github.com/madbrain67/STARTER-KIT-SYMFONY
 */
class TokenGenerator implements TokenGeneratorInterface
{
    /**
     * Undocumented variable.
     *
     * @var string
     */
    private $alphabet;

    /**
     * Undocumented variable.
     *
     * @var int
     */
    private $alphabetLength;

    /**
     * Undocumented variable.
     *
     * @var string
     */
    private $token;

    /**
     * Void __construct().
     *
     * @param int $length comment
     */
    public function __construct(int $length = 64)
    {
        $this->_setAlphabet();
        $this->_generate($length);
    }

    /**
     * Undocumented function.
     *
     * @return void
     */
    private function _setAlphabet()
    {
        $alphabet = implode(range('a', 'z'))
                    .implode(range('A', 'Z'))
                    .implode(range(0, 9));

        $this->alphabet = $alphabet;
        $this->alphabetLength = strlen($alphabet);
    }

    /**
     * Undocumented function.
     *
     * @param int $length comment
     *
     * @return void
     */
    public function _generate(int $length)
    {
        $token = '';

        for ($i = 0; $i < $length; ++$i) {
            $randomKey = $this->_getRandomInteger(0, $this->alphabetLength);
            $token .= $this->alphabet[$randomKey];
        }

        $this->token = $token;
    }

    /**
     * Undocumented function.
     *
     * @param int $min comment
     * @param int $max comment
     */
    private function _getRandomInteger(int $min, int $max): int
    {
        $range = ($max - $min);

        if ($range < 0) {
            // Not so random...
            return $min;
        }

        $log = log($range, 2);

        // Length in bytes.
        $bytes = (int) ($log / 8) + 1;

        // Length in bits.
        $bits = (int) $log + 1;

        // Set all lower bits to 1.
        $filter = (int) (1 << $bits) - 1;

        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));

            // Discard irrelevant bits.
            $rnd = $rnd & $filter;
        } while ($rnd >= $range);

        return $min + $rnd;
    }

    /**
     * Undocumented function.
     *
     * @return void
     */
    public function setSession()
    {
        $session = new Session();
        $session->set('token', $this->token);
    }

    /**
     * Function getToken().
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Function __toString().
     *
     * @return string
     */
    public function __toString()
    {
        return $this->token;
    }
}
