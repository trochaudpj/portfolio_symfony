<?php

/**
 * STARTER-KIT-SYMFONY
 * PHP version 7.
 *
 * @category App\EventListener
 *
 * @author   FERRERO Franck <ferrerofranck@yahoo.fr>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 *
 * @see     https://github.com/madbrain67/STARTER-KIT-SYMFONY
 */

namespace App\EventListener;

/*
 * STARTER-KIT-SYMFONY
 * PHP version 7.
 *
 * @category App\EventListener
 *
 * @author   FERRERO Franck <ferrerofranck@yahoo.fr>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 *
 * @see     https://github.com/madbrain67/STARTER-KIT-SYMFONY
 */

use App\Repository\UserRepository;
use Symfony\Component\Security\Http\Event\LogoutEvent;

/**
 * STARTER-KIT-SYMFONY
 * PHP version 7.
 *
 * @category App\EventListener
 *
 * @author   FERRERO Franck <ferrerofranck@yahoo.fr>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 *
 * @see     https://github.com/madbrain67/STARTER-KIT-SYMFONY
 */
class LogoutListener
{
    /**
     * Variable $this->_userRepository.
     *
     * @var UserRepository
     */
    private $_userRepository;

    /**
     * Void __construct.
     *
     * @param UserRepository $userRepository comment
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->_userRepository = $userRepository;
    }

    /**
     * Supprime le token de l'utilisateur et le time_session
     * de l'utilisateur qui se déconnecte
     * et la ligne de la table sessions.
     *
     * @param LogoutEvent $event comment
     *
     * @return void
     */
    public function __invoke(LogoutEvent $event)
    {
        // Delete token et session life table user
        if ('anon.' !== $event->getToken()->getUser()) {
            $this->_userRepository->logoutUser(
                $event->getToken()->getUser()
            );
        }

        // Delete la session en cours
        $event->getRequest()->getSession()->invalidate();
    }
}
