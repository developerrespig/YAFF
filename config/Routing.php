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
    
    /**
     * User Managment
     */
    $app['user.management'] = $app->share(function () use ($app) {
        return new YAFF\Users\Controller\UserServiceController($app);
    });
    
    $app->get('/users/', "user.management:indexAction")
        ->bind('users.overview');
    $app->get('/users/new', "user.management:newUserAction")
        ->bind("users.new.user");
    $app->post('/users/create', "user.management:createUserAction")
        ->bind('users.create.user');
    $app->get('/users/{id}/edit', "user.management:editUserAction")
        ->value('id', '0')
        ->bind('users.edit.user');
    $app->post('/users/{id}/update', "user.management:updateUserAction")
        ->bind('users.update.user');
    $app->get('/users/{id}/delete', "user.management:deleteUserAction")
        ->bind('users.delete.user');
    $app->post('/users/{id}/delete', "user.management:deleteUserAction")
        ->bind('users.dodelete.user');
    
    /**
     * FHEM Configuration
     */
    $app['fhemconfig.management'] = $app->share(function () use ($app) {
        return new YAFF\FHEMConfiguration\Controller\FHEMConfigurationServiceController($app);
    });
    
    $app->get('/fhemconfig/', "fhemconfig.management:indexAction")
        ->bind('fhemconfig.overview');
    $app->get('/fhemconfig/{id}/edit', "fhemconfig.management:editConfigAction")
        ->value('id', '0')
        ->bind('fhemconfig.edit.config');
    $app->post('/fhemconfig/{id}/update', "fhemconfig.management:updateConfigAction")
        ->bind('fhemconfig.update.config');
 
    /**
     * FHEM Service
     */
    $app['yaff.fhem.service'] = $app->share(function () use ($app) {
        return new YAFF\FHEM\Controller\FHEMServiceController($app);
    });

    $app->get('/fhem/get/values/{device}', "yaff.fhem.service:getValuesAction")
    ->bind('yaff.fhem.getValues');
?>
