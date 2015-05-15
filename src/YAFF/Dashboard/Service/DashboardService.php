<?php

namespace YAFF\Dashboard\Service;

use Silex\Application;

use Symfony\Component\HttpFoundation\Request;

use YAFF\Database\Entity\GraphWidget;
use YAFF\Database\Entity\RoomWidget;
use YAFF\Database\Entity\Device;

/**
 * Description of DashboardService
 *
 * @author Martin Gypser
 */
class DashboardService
{

    private $em = null;

    public function __construct(Application $app) {
        $this->em = $app['orm.em'];
    }

    /**
     * Changes the indexes of the given widgets and persists the changes
     * @param type $widgetA widget A
     * @param type $widgetB widget B
     */
    private function changeIndexes($widgetA, $widgetB) {
        $tmp = $widgetA->getIdx();
        $widgetA->setIdx($widgetB->getIdx());
        $widgetB->setIdx($tmp);

        $this->em->persist($widgetA);
        $this->em->persist($widgetB);
        $this->em->flush();
    }

    /**
     * Read the form fields from creating or editing settings
     * @param Request $request
     * @param int $id
     * @return \YAFF\Database\Entity\Widget
     */
    public function getWidgetGraphFromForm(Request $request, $id = -1) {
        if ($id == -1) {
            $widget = new GraphWidget();
            $widgets = $this->em->getRepository("\YAFF\Database\Entity\GraphWidget")->findAll();
            $widgetsCount = sizeof($widgets);
            if( $widgetsCount > 0) {
                $widget->setIdx($widgets[$widgetsCount - 1]->getIdx() + 1);
            } else {
                $widget->setIdx(1);
            }
        } else {
            $widget = $this->em->getRepository("\YAFF\Database\Entity\GraphWidget")->find($id);
        }

        $widget->setTitle($request->get('title'));
        $widget->setDevice($request->get('device'));
        $widget->setReading($request->get('reading'));
        $widget->setInterval(intval($request->get('interval')));
        $widget->setType(1);

        return $widget;
    }

    /**
     * Create a new roomwidget from the given json information
     * @param String json
     * @return RoomWidget roomWidget
     */
    public function getWidgetRoomFromJSON($json)
    {
      $room = json_decode($json);

      $roomWidget = new RoomWidget();
      $roomWidget->setTitle($room->name);
      $roomWidget->setIdx(1);

      for ($i=0; $i < sizeof($room->devices); $i++) {
          $device = new Device();
          $device->setName($room->devices[$i]);
          $device->setRoom($roomWidget);
          $roomWidget->getDevices()->add($device);
      }

      return $roomWidget;
    }

    /**
     * Gets the widget with the given id from the database.
     * @param type $id
     * @return object widget
     */
    private function getWidgetWithId($id) {
      $widgetTypes = unserialize(WIDGETS);
      foreach ($widgetTypes as $widgetType) {
        $widget = $this->em->getRepository($widgetType['repository'])->findById($id);
        if(sizeof($widget) == 1) {
          return $widget[0];
        }
      }
      return null;
    }

    // TODO: Refactoring
    // TODO: get solution for findLeftWidget and findRightWidget
    /**
     * Moves the widget with the $id to the left
     * @param type $id
     * @return boolean
     */
    public function moveWidgetLeft($id) {
        $widget = $this->getWidgetWithId($id);
        if($widget != null) {
            $widgetLeft = $this->em->getRepository("\YAFF\Database\Entity\GraphWidget")->findLeftWidget($widget[0]->getIdx());

            if(sizeof($widgetLeft) >= 1) {
                $this->changeIndexes($widget[0], $widgetLeft[0]);
                return true;
            }
        }
        return false;
    }

    /**
     * Moves the widget with the $id to the right
     * @param type $id
     * @return boolean
     */
    public function moveWidgetRight($id) {
        $widget = $this->getWidgetWithId($id);
       if($widget != null) {
            $widgetRight = $this->em->getRepository("\YAFF\Database\Entity\GraphWidget")->findRightWidget($widget[0]->getIdx());

            if(sizeof($widgetRight) >= 1) {
                $this->changeIndexes($widget[0], $widgetRight[0]);
                return true;
            }
        }
        return false;
    }
}
