<?php

namespace YAFF\Base\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PartyServiceController {

    private $app = null;

    /**
     * Constructor
     * @param Application $app the application
     */
    public function __construct(Application $app) {
        $this->app = $app;
    }

    /**
     * Renders the modal for the party mode setup
     * @return Response the response
     */
    public function modalAction() {
        return $this->app['twig']->render('Base/Views/partymode.modal.html.twig');
    }

    /**
     * Sends configuration to Fhem and starts the party mode     
     * Just works with homematic thermostats for now
     */
    public function startPartyModeAction(Request $request) {
        $fhemService = $this->app['FHEMService'];
        $devices = $fhemService->getFHEMDevices();
        $response = new Response();
        $response->setStatusCode(200);
        foreach ($devices as $device) {
            if (array_key_exists('subType', $device->Attributes) && $device->Attributes->subType == "thermostat") {
                $channel = $device->Internals->channel_04;
                $ret = $fhemService->setPartyMode($channel, $request->get('start'), $request->get('end'));
                if (!$ret) {
                    $response->setStatusCode(500);
                }
            }
        }
        if($response->getStatusCode() === 200) {
            $this->app['session']->getFlashBag()->add('success', "partymode.start.successful");
        } else {
            $this->app['session']->getFlashBag()->add('danger', "partymode.start.error");
        }
        
        return $response;
    }

}
