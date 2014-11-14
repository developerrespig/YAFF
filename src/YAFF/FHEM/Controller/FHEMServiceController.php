<?php
    namespace YAFF\FHEM\Controller;

    use Silex\Application;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpKernel\HttpKernelInterface;
    use Symfony\Component\HttpFoundation\Response;

    class FHEMServiceController
    {
        private $app = null;
        private $service = null;

        public function __construct(Application $app)
        {
            $this->app = $app;
            $this->service = $app['FHEMService'];
        }

        public function getValuesAction($device)
        {
            $startTimestamp = date('Y-m-d_H:i:s', strtotime("-24 hours"));
            $endTimestamp = date('Y-m-d_H:i:s', time());
            $command = "get%20log_datenbank%20-%20webchart%20" . $startTimestamp . "%20" . $endTimestamp . "%20" . $device . "%20timerange%20TIMESTAMP%20temp_c";
            $url = $this->service->getUrl($command);
            if($url) {
                $response = $this->service->createRequest($url);
            } else {
                $response = new Response(
                    "Error - TODO",
                    500);
            }

            return $response;
        }

        public function getValueAction($device) {
            $command = "jsonlist2%20" . $device;
            $url = $this->service->getUrl($command);
            if($url) {
                $response = $this->service->createRequest($url);
            } else {
                $response = new Response(
                    "No Config found!",
                    500);
            }

            return $response;
        }
    }
?>