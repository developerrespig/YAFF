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
        
        public function createWidgetGraphAction() {
            $csrf = $this->app['csrf_protection'];
            $fhemService = $this->app['FHEMService'];
            $devices = $fhemService->getFHEMDevices();
            
            return $this->app['twig']->render('Dashboard/Views/create.widget.graph.html.twig', array(
                'devices' => $devices,
                'token' => $csrf->getCSRFTokenForForm()
            ));
        }
    }	
?>