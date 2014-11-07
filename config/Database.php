<?php
use Doctrine\Common\Cache\ApcCache;
use Doctrine\Common\Cache\ArrayCache;

use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Silex\Provider\DoctrineServiceProvider;

$app->register(new DoctrineServiceProvider, array(
    'db.options' => array(
        'driver' => 'pdo_sqlite',
        'path' => __DIR__.'/app.db'
    ),
));

$app->register(new DoctrineOrmServiceProvider, array(
    'db.orm.proxies_dir'       => __DIR__ . '../cache/doctrine/proxy',
    'db.orm.proxies_namespace' => 'DoctrineProxy',
    'db.orm.cache'             => !$app['debug'] && extension_loaded('apc') ? new ApcCache() : new ArrayCache(),
    'db.orm.auto_generate_proxies' => false,
    'orm.em.options' => array(
        'mappings' => array(
            // Using actual filesystem paths
            array(
                'type' => 'annotation',
                'namespace' => 'YAFF\Database\Entity',
                'path' => __DIR__.'/../src/YAFF/Database/Entity',
            )
        ),
    ),
));