<?php

namespace YAFF\FHEM\Service;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of FHEMService
 *
 * @author Martin
 */

class FHEMService
{
    private $em = null;

    public function __construct(Application $app) {
        $this->em = $app['orm.em'];
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
                CURLOPT_URL => $url
            ));
        } else {
            curl_setopt_array($curl, $parameters);
        }
        $response = curl_exec($curl);
        curl_close($curl);

        return new Response(
            $response,
            200,
            ['Content-Type' => 'application/json']
        );
    }
}
?>