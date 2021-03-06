<?php
    $app->register(new Silex\Provider\UrlGeneratorServiceProvider());    
    $app->register(new Silex\Provider\ServiceControllerServiceProvider());
    $app->register(new Silex\Provider\SecurityServiceProvider());
    $app->register(new Silex\Provider\RememberMeServiceProvider());
    $app->register(new Silex\Provider\SessionServiceProvider());
    $app->register(new Silex\Provider\TranslationServiceProvider(), array(
        'locale_fallbacks' => array('de'),
        'locale' => 'de',
    ));

    // Twig Service Provider
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
            'twig.path' => __DIR__ . '/../src/YAFF',
            'twig.options' => array(
                'cache'       => __DIR__ . '/../cache/templates', // the place to cache to
                'auto_reload' => true //reload template when changes are detected
            )
    ));
    
    // own Service providers
    $app['csrf_protection'] = $app->share(function ($app) {
        return new YAFF\Base\Utility\CSRFProtectionService($app);
    });
    $app['UserService'] = $app->share(function ($app) {
        return new YAFF\Users\Service\UserService($app);
    });
    $app['FHEMConfigurationService'] = $app->share(function ($app) {
        return new YAFF\FHEMConfiguration\Service\FHEMConfigurationService($app);
    });
    $app['GeneralConfigurationService'] = $app->share(function ($app) {
        return new YAFF\GeneralConfiguration\Service\GeneralConfigurationService($app);
    });
    $app['FHEMService'] = $app->share(function ($app) {
        return new YAFF\FHEM\Service\FHEMService($app);
    });
    $app['DashboardService'] = $app->share(function ($app) {
        return new YAFF\Dashboard\Service\DashboardService($app);
    });

