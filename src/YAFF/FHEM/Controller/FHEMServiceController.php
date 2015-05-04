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

        public function getValuesAction($device, $type, $seconds)
        {
            $startTimestamp = date('Y-m-d_H:i:s', strtotime("-" . $seconds . " seconds"));
            $endTimestamp = date('Y-m-d_H:i:s', time());
            $command = "get log_datenbank - webchart " . $startTimestamp . " " . $endTimestamp . " " . $device . " timerange TIMESTAMP " . $type;
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

        public function getDeviceAction($device) {
            $command = "jsonlist2 " . $device;
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