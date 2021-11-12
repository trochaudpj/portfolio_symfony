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

namespace App\Service;

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

use App\Repository\SocialRepository;

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
class SocialService
{
    /**
     * Variable $this->_socialRepo.
     *
     * @var SocialRepository
     */
    private $_socialRepo;

    /**
     * Void __construct().
     *
     * @param SocialRepository $socialRepository comment
     */
    public function __construct(SocialRepository $socialRepository)
    {
        $this->_socialRepo = $socialRepository;
    }

    /**
     * Undocumented function.
     */
    public function link()
    {
        return $this->_socialRepo->findBySocial();
    }
}
