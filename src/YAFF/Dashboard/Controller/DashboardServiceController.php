<?php
    namespace YAFF\Dashboard\Controller;

    use Silex\Application;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;

    use YAFF\GeneralConfiguration\Service\GeneralConfigurationService;
    use YAFF\GeneralConfiguration\Service\FHEMService;
    use YAFF\GeneralConfiguration\Service\DashboardService;
    
    use YAFF\Database\Entity\Widget;

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
         * Handles the form request for the creation of a new Widet.
         * @return Response the form for a new Widget
         */
        public function showFormWidgetCreateAction() {
            $widgets = unserialize(WIDGETS);
            
            return $this->app['twig']->render('Dashboard/Views/form.widget.create.html.twig', array(
                'widgets' => $widgets
            ));
        }

        /**
        * Handles the form request for the creation of a new Graph Widget
        * @return Response the form for a new Graph Widget
        */
        public function showFormWidgetGraphAction($id = -1) {
            $csrf = $this->app['csrf_protection'];
            $fhemService = $this->app['FHEMService'];
            $devices = $fhemService->getFHEMDevices();
            
            $widget = null;
            if($id > -1) {
                $em = $this->app['orm.em'];
                $widget = $em->getRepository("\YAFF\Database\Entity\Widget")->findById($id);                
            }
            
            return $this->app['twig']->render('Dashboard/Views/form.widget.graph.html.twig', array(
                'devices' => $devices,
                'widget' => $widget[0],
                'token' => $csrf->getCSRFTokenForForm()
            ));
        }
        
        /**
         * Saves the in the form provided information for a new graph widget
         * @param Request $request
         */
        public function saveWidgetGraphAction(Request $request, $id) {
            $csrf = $this->app['csrf_protection'];
            $response = new Response();
            $response->setStatusCode(500);
            if (($csrf->validateCSRFToken($request))) {
                if($id == -1) {
                    $message = 'dashboard.widget.create.graph.successful';
                } else {
                    $message = 'dashboard.widget.edit.graph.successful';
                }                        
                $serviceDashboard = $this->app['DashboardService'];
                $widget = $serviceDashboard->getWidgetFromForm($request, $id);
                $em = $this->app['orm.em'];
                $em->persist($widget);
                $em->flush();                
                $this->app['session']->getFlashBag()->add('success', $message);
                $response->setStatusCode(200);
            }
            
            return $response;
        }
        
        /**
        * Handles the form request for the creation of a new Room Widget
        * @return Response the form for a new Room Widget
        */
        public function showFormWidgetRoomAction($id = -1) {
            $csrf = $this->app['csrf_protection'];
            $fhemService = $this->app['FHEMService'];
            $rooms = $fhemService->getRooms();
            
            return $this->app['twig']->render('Dashboard/Views/form.widget.room.html.twig', array(
                'rooms' => $rooms,
                'token' => $csrf->getCSRFTokenForForm()
            ));
        }
        
        /**
         * Deletes the widget with the given id
         * @param type $id the widget id
         * @return Response
         */
        public function deleteWidgetAction($id) {
            $em = $this->app['orm.em'];
            $response = new Response();
            $response->setStatusCode(500);
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
        
        /**
         * Moves the widget with the given $id in the given $direction
         * @param type $id the widget id
         * @param type $direction the direction 'left' or 'right'
         * @return Response
         */
        public function moveWidgetAction($id, $direction) {
            $serviceDashboard = $this->app['DashboardService'];
            $response = new Response();
            $ret = false;
            
            if($direction == 'right') {
                echo 'moving right';
                $ret = $serviceDashboard->moveWidgetRight($id);
            }
            
            if($direction == 'left') {                
                $ret = $serviceDashboard->moveWidgetLeft($id);
            }
            
            if($ret) {
                $response->setStatusCode(200);
            } else {
                $this->app['session']->getFlashBag()->add('danger', 'dashboard.widget.move.error');
                $response->setStatusCode(500);
            }
            
            return $response;
        }
    }	
?>