<?php

namespace YAFF\Login\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class LoginServiceController
{
    private $app = null;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function indexAction(Request $request)
    {
        return $this->app['twig']->render('Login/views/login.twig', array(
                'error' => $this->app['security.last_error']($request),
                'last_username' => $this->app['session']->get('_security.last_username')
            )
        );
    }
}