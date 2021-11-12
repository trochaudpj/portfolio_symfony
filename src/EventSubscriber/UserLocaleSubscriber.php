<?php

namespace App\EventSubscriber;

use App\Repository\UserRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class UserLocaleSubscriber implements EventSubscriberInterface
{
    /**
     * Variable $this->defaultLocale.
     *
     * @var string
     */
    private $defaultLocale;

    /**
     * Variable $this->userRepository.
     *
     * @var UserRepository
     */
    private $userRepository;

    /**
     * Void __construct().
     *
     * @param string $defaultLocale comment
     */
    public function __construct(string $defaultLocale, UserRepository $userRepository)
    {
        $this->defaultLocale = $defaultLocale;
        $this->userRepository = $userRepository;
    }

    /**
     * Stocke les paramètres régionaux de l'utilisateur dans la session après la connexion.
     * Cela peut être utilisé par le LocaleSubscriber par la suite.
     *
     * @param InteractiveLoginEvent $event comment
     */
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $user = $this->userRepository->find(
            $event->getAuthenticationToken()->getUser()
        );
        $request = $event->getRequest();

        // essaye de voir si les paramètres régionaux ont été définis comme paramètre de routage _locale
        if ($locale = $request->attributes->get('_locale')) {
            $request->getSession()->set('_locale', $locale);
        } else {
            // A paramètrer sur un customer a partir de son pays getLocale() ou getCountry() ou getPays()
            // $user->getCustomer()->getPays();
            // getLocale(), getCountry(), getPays() = fr, en, it ......
            if (null !== $user->getLocale() && null !== $user->getTimezone()) {
                $request->setLocale($request->getSession()->get('_locale', $user->getLocale()));
                $request->getSession()->set('_locale', $user->getLocale());
                $request->getSession()->set('timezone', $user->getTimezone());
            } else {
                // si aucune locale explicite n'a été définie sur cette demande, on utilise la session et la langue par défaut
                $request->setLocale($request->getSession()->get('_locale', $this->defaultLocale));
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            'security.interactive_login' => 'onSecurityInteractiveLogin',
        ];
    }
}
