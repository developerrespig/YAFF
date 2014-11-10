<?php
    namespace YAFF\FHEM\Controller;

    use Silex\Application;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpKernel\HttpKernelInterface;

    class FHEMServiceController
    {
        private $app = null;

        public function __construct(Application $app)
        {
            $this->app = $app;
        }

        public function getValuesAction($device)
        {
            $url = "http://141.56.131.26:8083/fhem?cmd=get%20log_datenbank%20-%20webchart%202014-11-04_00:00:00%202014-11-05_00:00:00%20" . $device . "%20timerange%20TIMESTAMP%20temp_c&XHR=1";

            $response = $this->app['FHEMService']->createRequest($url);

            return "Test" . $response;
        }
    }
?>