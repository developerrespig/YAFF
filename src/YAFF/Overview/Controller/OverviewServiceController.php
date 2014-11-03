<?php
	namespace YAFF\Overview\Controller;
	
	use Silex\Application;
	use Symfony\Component\HttpFoundation\Request;
	
	class OverviewServiceController
	{
		private $app = null;
		
		public function __construct(Application $app)
		{
			$this->app = $app;
		}
		
		public function indexAction()
		{
			return $this->app['twig']->render('Overview/Views/index.html.twig');
		}
	}	
?>