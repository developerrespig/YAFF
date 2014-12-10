<?php

namespace YAFF\GeneralConfiguration\Service;

use Silex\Application;
use YAFF\Database\Entity\GeneralConfiguration;

use Symfony\Component\HttpFoundation\Request;

/**
 * Description of GeneralConfigurationService
 *
 * @author Martin Gypser
 */
class GeneralConfigurationService
{

    private $em = null;

    public function __construct(Application $app) {
        $this->em = $app['orm.em'];
    }

    /**
     * Read the form fields from creating or editing settings
     * @param Request $request
     * @param int $id
     * @return \YAFF\Database\Entity\GeneralConfiguration
     */
    public function getConfigFromForm(Request $request) {
        $config = $this->em->getRepository("\YAFF\Database\Entity\GeneralConfiguration")->find(1);
        if($config == null) {
            $config = new GeneralConfiguration();
            $config->setId(1);
        }
        $config->setColumns($request->get("columns"));
        $config->setRows($request->get("rows"));
        return $config;
    }
}
