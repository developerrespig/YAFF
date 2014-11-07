<?php

$app['security.firewalls'] = array(
    'login' => array(
        'pattern' => '^/login$'
    ),
    'application' => array(
        'pattern' => '^.*$',
        'form' => array('login_path' => '/login', 'check_path' => 'login_check'),
        'logout' => array('logout_path' => '/logout'),
        'users' => $app->share(function () use ($app) {
                return new YAFF\Database\Repository\UserRepository($app['orm.em'], new Doctrine\ORM\Mapping\ClassMetadata("YAFF\Database\Entity\User"));
            }),
        'remember_me' => array(
            'key' => 'fs64hfskG70Jhgdas$/fPadfsM',
        ),
    )
);
