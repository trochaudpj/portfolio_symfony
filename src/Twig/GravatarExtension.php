<?php

/**
 * STARTER-KIT-SYMFONY
 * PHP version 7.
 *
 * @category App\Controller\Admin
 *
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 *
 * @see     https://github.com/madbrain67/STARTER-KIT-SYMFONY
 */

namespace App\Twig;

/*
 * STARTER-KIT-SYMFONY
 * PHP version 7.
 *
 * @category App\Controller\Admin
 *
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 *
 * @see     https://github.com/madbrain67/STARTER-KIT-SYMFONY
 */

use App\Api\Gravatar\Gravatar;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * STARTER-KIT-SYMFONY
 * PHP version 7.
 *
 * @category App\Controller\Admin
 *
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 *
 * @see     https://github.com/madbrain67/STARTER-KIT-SYMFONY
 */
class GravatarExtension extends AbstractExtension
{
    /**
     * Variable $this->gravatar.
     *
     * @var Gravatar
     */
    private $gravatar;

    /**
     * Void __construct().
     *
     * @param Gravatar $gravatar comment
     */
    public function __construct(Gravatar $gravatar)
    {
        $this->gravatar = $gravatar;
    }

    /**
     * Function getFunctions().
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('gravatar', [$this, 'gravatar']),
            new TwigFunction('vcard', [$this, 'vcard']),
            new TwigFunction('qrcode', [$this, 'qrcode']),
            new TwigFunction('profile', [$this, 'profile']),
        ];
    }

    /**
     * Retourne de le gravatar de l'utilisateur ou l'image par defaut.
     *
     * @param string      $email         comment
     * @param bool        $forced_avatar comment
     * @param string|null $avatar        comment
     */
    public function gravatar(string $email, bool $forced_avatar, $avatar): string
    {
        return $this->gravatar->avatar($email, $forced_avatar, $avatar);
    }

    /**
     * Retourne le lien pour l'url.vcf du compte gravatar si il existe.
     *
     * @param string $email comment
     */
    public function vcard(string $email): ?string
    {
        $vcard = $this->gravatar->vcard($email);

        return null !== $vcard ? $vcard : null;
    }

    /**
     * Retourne l'image du qrCode du compte gravatar si elle existe.
     *
     * @param string $email comment
     */
    public function qrcode(string $email): ?string
    {
        $qrcode = $this->gravatar->qrCode($email);

        return null !== $qrcode ? $qrcode : null;
    }

    /**
     * Retourne le nom prenom du compte gravatar si il existe sinon l'email du compte.
     */
    public function profile(string $email): string
    {
        $profile = $this->gravatar->profile($email);

        return null !== $profile ? $profile : $email;
    }
}
