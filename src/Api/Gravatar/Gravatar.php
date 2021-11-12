<?php

/**
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

namespace App\Api\Gravatar;

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

/**
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
final class Gravatar
{
    /**
     * Gravatar's url.
     */
    const GRAVATAR_URL = 'https://secure.gravatar.com';

    /**
     * Adresse e-mail.
     *
     * Toutes les URL sur Gravatar sont basées sur l'utilisation de la valeur hachée d'une adresse e-mail.
     * Les images et les profils sont tous deux accessibles via le hachage d'un e-mail, et il est considéré comme le principal
     * moyen d'identifier une identité dans le système. Pour garantir un hachage cohérent et précis, les étapes suivantes doivent
     * être suivies pour créer un hachage:
     *
     * 1 - Supprimez les espaces blancs de début et de fin d'une adresse e-mail
     * 2 - Forcer tous les caractères en minuscules
     * 3 - md5 hache la chaîne finale
     *
     * @var string
     */
    private $email;

    /**
     * La taille de l'image.
     *
     * Par défaut, les images sont présentées à 80px par 80px si aucun paramètre de taille n'est fourni.
     * Vous pouvez demander une taille d'image spécifique, qui sera fournie dynamiquement à partir de Gravatar
     * en utilisant le paramètre s= ou size= et en passant une seule dimension de pixel (puisque les images sont carrées):
     *
     * @var integer
     */
    private $size;

    /**
     * L'image par défaut à afficher s'il n'y a pas de Gravatar correspondant.
     *
     * 404: ne chargez aucune image si aucune n'est associée au hachage de l'e-mail, renvoyez plutôt une réponse HTTP 404 (fichier non trouvé)
     * mp: (mystery-person) un contour simple de style dessin animé d'une personne (ne varie pas selon le hachage des e-mails)
     * identicon: un motif géométrique basé sur un hachage d'e-mail
     * monsterid: un "monstre" généré avec différentes couleurs, visages, etc.
     * wavatar: faces générées avec des caractéristiques et des arrière-plans différents
     * retro: superbes visages pixélisés de style arcade 8 bits générés
     * robohash: un robot généré avec différentes couleurs, visages, etc.
     * blank: une image PNG transparente (bordure ajoutée au HTML ci-dessous à des fins de démonstration)
     *
     * @var string
     */
    private $default;

    /**
     * Dites à Gravatar d'utiliser l'image par défaut même s'il existe un Gravatar correspondant.
     *
     * Si, pour une raison quelconque, vous souhaitez forcer le chargement permanent de l'image par défaut,
     * vous pouvez le faire en utilisant le paramètre f= ou forcedefault= et en définissant sa valeur sur y.
     * https://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50?f=y
     *
     * @var string
     */
    private $forcedefault;

    /**
     * La cote d'audience (G, R, etc.) à laquelle restreindre le Gravatar.
     *
     * Évaluation
     * Gravatar permet aux utilisateurs d'auto-évaluer leurs images afin qu'ils puissent indiquer si une image est appropriée
     * pour un certain public. Par défaut, seules les images notées «G» sont affichées, sauf si vous indiquez que vous souhaitez
     * voir des notes plus élevées. En utilisant les paramètres r= ou rating=
     * vous pouvez spécifier l'une des évaluations suivantes pour demander des images jusqu'à et y compris cette classification:
     *
     * g : convient à l'affichage sur tous les sites Web de tout type d'audience.
     * pg : peut contenir des gestes grossiers, des personnes habillées de manière provocante, des jurons moindres ou de la violence légère.
     * r : peut contenir des choses telles que des grossièretés, une violence intense, de la nudité ou une consommation de drogues dures.
     * x : peut contenir des images sexuelles hardcore ou une violence extrêmement dérangeante.
     * Si le hachage d'e-mail demandé n'a pas d'image correspondant au niveau de classification demandé,
     * l'image par défaut est renvoyée (ou la valeur par défaut spécifiée, comme ci-dessus )
     *
     * Pour autoriser les images classées G ou PG, utilisez quelque chose comme ceci:
     *
     * https://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50?r=pg
     *
     * @var string
     */
    private $rating;

    /**
     * HTTP ou HTTPS.
     *
     * @var string
     */
    private $host = ['http://gravatar.com'];

    /**
     * Retourne le profile gravatar si il existe.
     *
     * @param string $email  comment
     * @param string $format comment
     *
     * @return array|null
     */
    private function _account(string $email, string $format)
    {
        $str = @file_get_contents(self::GRAVATAR_URL.'/'.md5(strtolower(trim($email))).'.'.$format);
        $profile = unserialize($str);
        if (is_array($profile) && isset($profile['entry'])) {
            return $profile;
        } else {
            return null;
        }
    }

    /**
     * Returns le gravatar de l'utilisateur.
     *
     * @param string      $email        comment
     * @param bool        $forcedefault comment
     * @param string|null $avatar       comment
     * @param array       $arguments    comment
     *
     * @return string
     */
    public function avatar(string $email, bool $forcedefault, $avatar, array $arguments = []): string
    {
        $forcedefault = $forcedefault === true ? '&f=y' : '';
        $default = $avatar === null ? 'blank' : $avatar;
        $size = array_key_exists('size', $arguments) ? '&s='.$arguments['size'] : '';
        $rating = array_key_exists('rating', $arguments) ? '&r='.$arguments['rating'] : '';

        return self::GRAVATAR_URL.'/avatar/'.md5(strtolower(trim($email))).'?d='.urlencode($default).$forcedefault.$size.$rating;
    }

    /**
     * Retourne le nom et prenom du profil gravatar si il existe.
     *
     * @param string $email  comment
     * @param string $format comment
     *
     * @return string|null
     */
    public function profile(string $email, string $format = 'php')
    {
        $profile = $this->_account($email, $format);
        if (null !== $profile) {
            if (null !== $profile['entry'][0]['name']['familyName'] && null !== $profile['entry'][0]['name']['givenName']) {
                return $profile['entry'][0]['name']['givenName'].' '.$profile['entry'][0]['name']['familyName'];
            } else {
                return $profile['entry'][0]['displayName'];
            }
        } else {
            return null;
        }
    }

    /**
     * Retourne le lien vcard du profil gravatar si il existe.
     *
     * @param string $email  comment
     * @param string $format comment
     *
     * @return string|null
     */
    public function vcard(string $email, string $format = 'php')
    {
        $profile = $this->_account($email, $format);
        if (null !== $profile && null !== $profile['entry'][0]['profileUrl']) {
            return str_replace($this->host, self::GRAVATAR_URL, $profile['entry'][0]['profileUrl'].'.vcf');
        } else {
            return null;
        }
    }

    /**
     * Retourne le qrcode du profil gravatar si il existe.
     *
     * @param string $email  comment
     * @param string $format comment
     *
     * @return string|null
     */
    public function qrCode(string $email, string $format = 'php')
    {
        $profile = $this->_account($email, $format);
        if (null !== $profile && null !== $profile['entry'][0]['profileUrl']) {
            return str_replace($this->host, self::GRAVATAR_URL, $profile['entry'][0]['profileUrl'].'.qr');
        } else {
            return null;
        }
    }

    /**
     * Retourne le profil gravatar en json si il existe.
     *
     * @param string $email  comment
     * @param string $format comment
     *
     * @return string|null
     */
    public function json(string $email, string $format = 'php')
    {
        $profile = $this->_account($email, $format);
        if (null !== $profile && null !== $profile['entry'][0]['profileUrl']) {
            return str_replace($this->host, self::GRAVATAR_URL, $profile['entry'][0]['profileUrl'].'.json');
        } else {
            return null;
        }
    }

    /**
     * Retourne le profil gravatar en xml si il existe.
     *
     * @param string $email  comment
     * @param string $format comment
     *
     * @return string|null
     */
    public function xml(string $email, string $format = 'php')
    {
        $profile = $this->_account($email, $format);
        if (null !== $profile && null !== $profile['entry'][0]['profileUrl']) {
            return str_replace($this->host, self::GRAVATAR_URL, $profile['entry'][0]['profileUrl'].'.xml');
        } else {
            return null;
        }
    }

    /**
     * Retourne le profil gravatar en tableau php si il existe.
     *
     * @param string $email  comment
     * @param string $format comment
     *
     * @return string|null
     */
    public function php(string $email, string $format = 'php')
    {
        $profile = $this->_account($email, $format);
        if (null !== $profile) {
            return $profile;
        } else {
            return null;
        }
    }
}
