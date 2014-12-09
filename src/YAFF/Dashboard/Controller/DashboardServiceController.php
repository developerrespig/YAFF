<?php
	namespace YAFF\Dashboard\Controller;
	
	use Silex\Application;
	use Symfony\Component\HttpFoundation\Request;
	
	class DashboardServiceController
	{
		private $app = null;
		
		public function __construct(Application $app)
		{
			$this->app = $app;
		}
		
		public function indexAction()
		{
			return $this->app['twig']->render('Dashboard/Views/index.html.twig');
		}
	}	
?>