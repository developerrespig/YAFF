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

    /**
     * Gets the FHEM configuration
     * @return type
     */
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

    /**
     * Creates the request URL for the given command
     * @param type $command
     * @return type
     */
    public function getUrl($command) {
        $config = $this->getFHEMConfig();
        if($config) {
            $url = "http://" . $config->getHost() . ":" . $config->getPort() . "/fhem?cmd=" . urlencode($command) . "&XHR=1";
        } else {
            $url = null;
        }

        return $url;
    }

    /**
     * Creates simple Request to the given url and returns the response as json
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

    /**
     * Fetches all information which the command jsonlist2 from FHEM provides
     * @return Object the device list
     */
    public function getFHEMJsonList() {
        $url = $this->getUrl("jsonlist2");
        $response = $this->createRequest($url);
        if($response->getStatusCode() == 200) {
            $jsonlist = $response->getContent();
            $jsonArray = json_decode($jsonlist)->{'Results'};
        }
        return $jsonArray;
    }

    /**
     * Creates an array of alle FHEM devices which may be accessed through their name
     * @return array the FHEM devices as an array
     */
    public function getFHEMDevices() {
        $devices = array();
        $jsonArray = $this->getFHEMJsonList();
        for($i = 0; $i < count($jsonArray); $i++) {
            $devices[$jsonArray[$i]->{'Name'}] = $jsonArray[$i];
        }
        return $devices;
    }

    /**
     * Gets the information for a single device from Fhem
     * @param String $deviceName
     * @return String json
     */
    public function getDevice($deviceName)
    {
      $command = "jsonlist2 " . $deviceName;
      $url = $this->getUrl($command);
      $response = $this->createRequest($url);
      return $response->getContent();
    }

    /**
     * Gets the actual state for the given device
     * @param String deviceName
     * @return String state
     */
    public function getDeviceStatus($deviceName)
    {
      $device = json_decode($this->getDevice($deviceName))->{'Results'};
      return $device[0]->Internals->STATE;
    }

    /**
     * Toggles the state of the provided Switch
     * @param String $switchName
     * @return boolean
     */
    public function toggleSwitch($switchName) {
      $onOrOff = 'off';
      if ($this->getDeviceStatus($switchName) == 'off') {
        $onOrOff = 'on';
      }

      $commando = "set " . $switchName . " " . $onOrOff;
      $url = $this->getUrl($commando);
      $response = $this->createRequest($url);
      if($response->getStatusCode() == 200) {
          return true;
      } else {
          return false;
      }
    }

    // TODO: Refactoring
    /**
     * Gets all rooms with the appropriate devices from Fhem
     * @return array the rooms
     */
    public function getRooms() {
        $devices = $this->getFHEMDevices();
        $rooms = array();
        foreach($devices as $device) {
            if(isset($device->Attributes)) {
                if(isset($device->Attributes->room)) {
                    $roomName = $device->Attributes->room;
                    if (isset($device->Attributes->subType)) {
                      $deviceType = $device->Attributes->subType;

                      switch ($deviceType) {
                        case 'powerMeter':
                          $deviceName = $device->Internals->channel_01;
                          break;

                        case 'thermostat':
                          $deviceName = $device->Internals->channel_04;
                          break;

                        default:
                          $deviceName = $device->Name;
                          break;
                      }
                      if(isset($rooms[$roomName])) {
                          $roomDevices = $rooms[$roomName]['devices'];
                          array_push($roomDevices, array(
                            'name' => $deviceName,
                            'type' => $deviceType
                          ));
                          $rooms[$roomName]['devices'] = $roomDevices;
                      } else {
                          $room = array();
                          $room['name'] = $roomName;
                          $roomDevices = array();
                          array_push($roomDevices, array(
                            'name' => $deviceName,
                            'type' => $deviceType
                          ));
                          $room['devices'] = $roomDevices;
                          $rooms[$roomName] = $room;
                      }
                    }
                }
            }
        }

        return $rooms;
    }
}
?>
