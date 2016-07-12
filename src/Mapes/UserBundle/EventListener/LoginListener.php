<?php

namespace Mapes\UserBundle\EventListener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpFoundation\Session\Session;

class LoginListener
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
       $security_token = $event->getAuthenticationToken();
        // Using the token and the container you can do anything you want
       $this->container->get('session')->set('pdw_check', 'true'); // ...

       //var_dump($_SESSION);
       //die();
    }
}
?>
