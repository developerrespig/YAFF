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
            'twig.path' => __DIR__ . '/../src/YAFF'
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
