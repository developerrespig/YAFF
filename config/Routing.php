<?php
    $app['yaff.overview'] = $app->share(function () use ($app) {
            return new YAFF\Overview\Controller\OverviewServiceController($app);
    });
	
    $app->get('/', "yaff.overview:indexAction")
        ->bind('yaff.overview');
    
    /**
     * Login
     */
    $app['user.login'] = $app->share(function () use ($app) {
        return new YAFF\Login\Controller\LoginServiceController($app);
    });
    
    $app->get('/login', "user.login:indexAction");
 