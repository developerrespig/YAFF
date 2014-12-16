<?php
    namespace YAFF\Dashboard\Controller;

    use Silex\Application;
    use Symfony\Component\HttpFoundation\Request;

    use YAFF\GeneralConfiguration\Service\GeneralConfigurationService;
    use YAFF\GeneralConfiguration\Service\FHEMService;
    use YAFF\GeneralConfiguration\Service\DashboardService;

    class DashboardServiceController
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

        /**
         * Renders the dashboard overview page
         * @return Response the response
         */
        public function indexAction()
        {
            $generalConfigService = $this->app['GeneralConfigurationService'];
            $generalConfig = $generalConfigService->getConfig();

            return $this->app['twig']->render('Dashboard/Views/index.html.twig', array(
                'config' => $generalConfig
            ));
        }
        
        /**
         * Handles the form request for the creation of a new Graph Widget
         * @return Response the form for a new Graph Widget
         */
        public function createWidgetGraphAction() {
            $csrf = $this->app['csrf_protection'];
            $fhemService = $this->app['FHEMService'];
            $devices = $fhemService->getFHEMDevices();
            
            return $this->app['twig']->render('Dashboard/Views/create.widget.graph.html.twig', array(
                'devices' => $devices,
                'token' => $csrf->getCSRFTokenForForm()
            ));
        }
        
        /**
         * Saves the in the form provided information for a new graph widget
         * @param Request $request
         */
        public function saveWidgetGraphAction(Request $request) {
            $csrf = $this->app['csrf_protection'];
            if (($csrf->validateCSRFToken($request))) {
                $serviceDashboard = $this->app['DashboardService'];
                $widget = $serviceDashboard->getWidgetFromForm($request);
                print_r($widget); exit;
                
                $em = $this->app['orm.em'];               
            }
            
            return new Response();
        }
    }	
?>