<?php

namespace YAFF\Thermostats\Controller;

use Silex\Application;
use YAFF\Database\Entity\Widget;

use Symfony\Component\HttpFoundation\Request;

/**
 * Description of ThermostatsService
 *
 * @author Martin Gypser
 */
class ThermostatsServiceController
{
    private $app = null;

    /**
     * Constructor
     * @param Application $app the application
     */
    public function __construct(Application $app)
    {
            $this->app = $app;
    }

    public function indexAction()
    {
      $fhemService = $this->app['FHEMService'];
      $thermostats = $fhemService->getThermostats();

      return $this->app['twig']->render('Thermostats/Views/index.html.twig', array(
        'thermostats' => $thermostats
      ));
    }
}
