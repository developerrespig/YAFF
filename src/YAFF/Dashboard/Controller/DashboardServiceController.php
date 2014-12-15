<?php
    namespace YAFF\Dashboard\Controller;

    use Silex\Application;
    use Symfony\Component\HttpFoundation\Request;

    use YAFF\GeneralConfiguration\Service\GeneralConfigurationService;

    class DashboardServiceController
    {
            private $app = null;

            public function __construct(Application $app)
            {
                    $this->app = $app;
            }

            public function indexAction()
            {
                $generalConfigService = $this->app['GeneralConfigurationService'];
                $generalConfig = $generalConfigService->getConfig();

                return $this->app['twig']->render('Dashboard/Views/index.html.twig', array(
                    'config' => $generalConfig
                ));
            }
    }	
?>