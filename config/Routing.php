<?php
    // Overview
	$app['yaff.overview'] = $app->share(function () use ($app) {
		return new YAFF\Overview\Controller\OverviewServiceController($app);
	});
	
	$app->get('/', "yaff.overview:indexAction")
    ->bind('yaff.overview');

    // FHEM Service
    $app['yaff.fhem.service'] = $app->share(function () use ($app) {
        return new YAFF\FHEM\Controller\FHEMServiceController($app);
    });

    $app->get('/fhem/get/values/{device}', "yaff.fhem.service:getValuesAction")
    ->bind('yaff.fhem.getValues');
?>