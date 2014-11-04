<?php
    $app->register(new Silex\Provider\UrlGeneratorServiceProvider());
	$app->register(new Silex\Provider\ServiceControllerServiceProvider());

	// Twig Service Provider
	$app->register(new Silex\Provider\TwigServiceProvider(), array(
		'twig.path' => __DIR__ . '/../src/YAFF'
	));
?>