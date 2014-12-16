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
     * Read the form fields from creating or editing settings
     * @param Request $request
     * @param int $id
     * @return \YAFF\Database\Entity\Widget
     */
    public function getWidgetFromForm(Request $request, $id = 0) {
        if ($id === '0') {
            $widget = new Widget();            
        } else {
            $widget = $this->em->getRepository("\YAFF\Database\Entity\Widget")->find($id);
        }

        $widget->setTitle($request->get('title'));
        $widget->setDevice($request->get('device'));
        $widget->setReading($request->get('reading'));
        $widget->setIntervall($request->get('intervall'));
        $widget->setType(1);

        return $widget;
    }
}
