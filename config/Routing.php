<?php
	$app['yaff.overview'] = $app->share(function () use ($app) {
		return new YAFF\Overview\Controller\OverviewServiceController($app);
	});
	
	$app->get('/', "yaff.overview:indexAction")
    ->bind('yaff.overview');
?>