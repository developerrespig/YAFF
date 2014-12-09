<?php

use Symfony\Component\Translation\Loader\XliffFileLoader;

$app['translator'] = $app->share($app->extend('translator', function ($translator, $app) {
    $translator->addLoader('yaml', new XliffFileLoader());

    $translator->addResource('xliff', __DIR__ . '/../src/YAFF/Login/Translations/de.xlf', 'de');
    $translator->addResource('xliff', __DIR__ . '/../src/YAFF/Base/Translations/de.xlf', 'de');
    $translator->addResource('xliff', __DIR__ . '/../src/YAFF/Dashboard/Translations/de.xlf', 'de');
    $translator->addResource('xliff', __DIR__ . '/../src/YAFF/Users/Translations/de.xlf', 'de');
    $translator->addResource('xliff', __DIR__ . '/../src/YAFF/FHEMConfiguration/Translations/de.xlf', 'de');
    $translator->addResource('xliff', __DIR__ . '/../src/YAFF/GeneralConfiguration/Translations/de.xlf', 'de');

    return $translator;
}));

