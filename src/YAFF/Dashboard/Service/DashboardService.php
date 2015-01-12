<?php

namespace YAFF\Dashboard\Service;

use Silex\Application;
use YAFF\Database\Entity\Widget;

use Symfony\Component\HttpFoundation\Request;

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
    public function getWidgetFromForm(Request $request, $id = -1) {
        if ($id == -1) {
            $widget = new Widget();
            $widgets = $this->em->getRepository("\YAFF\Database\Entity\Widget")->findAll();
            $widgetsCount = sizeof($widgets);
            if( $widgetsCount > 0) {
                $widget->setIdx($widgets[$widgetsCount - 1]->getIdx() + 1);
            } else {                
                $widget->setIdx(1);
            }
        } else {
            $widget = $this->em->getRepository("\YAFF\Database\Entity\Widget")->find($id);
        }

        $widget->setTitle($request->get('title'));
        $widget->setDevice($request->get('device'));
        $widget->setReading($request->get('reading'));
        $widget->setInterval(intval($request->get('interval')));
        $widget->setType(1);

        return $widget;
    }
    
    /**
     * Moves the widget with the $id to the left
     * @param type $id
     * @return boolean
     */
    public function moveWidgetLeft($id) {
        $widget = $this->em->getRepository("\YAFF\Database\Entity\Widget")->findById($id);
        if(sizeof($widget) >= 1) {
            $widgetLeft = $this->em->getRepository("\YAFF\Database\Entity\Widget")->findLeftWidget($widget[0]->getIdx());
            
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
        $widget = $this->em->getRepository("\YAFF\Database\Entity\Widget")->findById($id);
       if(sizeof($widget) >= 1) {
            $widgetRight = $this->em->getRepository("\YAFF\Database\Entity\Widget")->findRightWidget($widget[0]->getIdx());
            
            if(sizeof($widgetRight) >= 1) {
                $this->changeIndexes($widget[0], $widgetRight[0]); 
                return true;
            }
        }
        return false;    
    }
}
