<?php
namespace YAFF\GeneralConfiguration\Controller;

use Silex\Application;

/**
 * Handles all general configuration requests
 *
 * @author Martin Gypser
 */

class GeneralConfigurationController
{
	private $app = null;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function indexAction()
    {    
    	return $this->app['twig']->render('GeneralConfiguration/Views/index.html.twig');
    }
}