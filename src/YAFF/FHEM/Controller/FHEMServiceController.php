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

            // Get cURL resource
            $curl = curl_init();
            // Set some options - we are passing in a useragent too here
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $url,
                CURLOPT_USERAGENT => 'Codular Sample cURL Request'
            ));
            // Send the request & save response to $resp
            $response = curl_exec($curl);
            // Close request to clear up some resources
            curl_close($curl);

            return "Test" . $response;
        }
    }
?>