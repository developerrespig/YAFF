<?php

namespace YAFF\FHEM\Service;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;

use YAFF\Database\Entity\FHEMConfiguration;

/**
 * Description of FHEMService
 *
 * @author Martin
 */

class FHEMService
{
    private $app = null;

    public function __construct(Application $app) {
        $this->app = $app;
    }

    private function getFHEMConfig() {
        $em = $this->app['orm.em'];
        $configs = $em->getRepository("\YAFF\Database\Entity\FHEMConfiguration")->findAll();

        if(count($configs) != 0) {
            $return = $configs[0];
        } else {
            $return = null;
        }

        return $return;
    }

    public function getUrl($command) {
        $config = $this->getFHEMConfig();
        if($config) {
            $url = "http://" . $config->getHost() . ":" . $config->getPort() . "/fhem?cmd=" . $command . "&XHR=1";
        } else {
            $url = null;
        }

        return $url;
    }

    /**
     * Creates simple Request to the given url
     *
     * @param String $url
     * @param Array $parameters
     * @return String mixed
     */
    public function createRequest($url, $parameters = null) {
        $curl = curl_init();
        if ($parameters == null) {
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $url,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_TIMEOUT => 400
            ));
        } else {
            curl_setopt_array($curl, $parameters);
        }
        $response = curl_exec($curl);

        if(curl_errno($curl)) {
            $statusCode = 500;
            $response = "Error: " . curl_error($curl);
        } else {
            $statusCode = 200;
        }

        curl_close($curl);

        return new Response(
            $response,
            $statusCode,
            ['Content-Type' => 'application/json']
        );
    }
}
?>