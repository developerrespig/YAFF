<?php
    namespace YAFF\Dashboard\Controller;

    use Silex\Application;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;

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
            
            $em = $this->app['orm.em'];
            $widgets = $em->getRepository("\YAFF\Database\Entity\Widget")->findAll();

            return $this->app['twig']->render('Dashboard/Views/index.html.twig', array(
                'config' => $generalConfig,
                'widgets' => $widgets
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
            $response = new Response();
            $response->setStatusCode(500);
            if (($csrf->validateCSRFToken($request))) {
                $serviceDashboard = $this->app['DashboardService'];
                $widget = $serviceDashboard->getWidgetFromForm($request);
                $em = $this->app['orm.em'];
                $em->persist($widget);
                $em->flush();
                $this->app['session']->getFlashBag()->add('success', 'dashboard.widget.create.graph.successful');
                $response->setStatusCode(200);
            }
            
            return $response;
        }
        
        /**
         * Deletes the widget with the given id
         * @param type $id the widget id
         * @return Response
         */
        public function deleteWidgetAction($id) {
            $em = $this->app['orm.em'];
            $response = new Response();
            $widget = $em->getRepository("\YAFF\Database\Entity\Widget")->find($id);
            if($widget != null) {
                $em->remove($widget);
                $em->flush();
                $this->app['session']->getFlashBag()->add('success', 'dashboard.widget.delete.successful');
                $response->setStatusCode(200);
            } else {
                $this->app['session']->getFlashBag()->add('warning', 'dashboard.widget.delete.error.not.found');
                $response->setStatusCode(200);
            }
            return $response;
        }
    }	
?>