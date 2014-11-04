<?php
    $app->register(new Silex\Provider\UrlGeneratorServiceProvider());    
    $app->register(new Silex\Provider\ServiceControllerServiceProvider());
    $app->register(new Silex\Provider\SecurityServiceProvider());
    $app->register(new Silex\Provider\RememberMeServiceProvider());
    $app->register(new Silex\Provider\SessionServiceProvider());

    // Twig Service Provider
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
            'twig.path' => __DIR__ . '/../src/YAFF'
    ));
?>