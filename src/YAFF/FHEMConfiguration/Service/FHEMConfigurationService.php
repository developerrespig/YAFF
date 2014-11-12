<?php

namespace YAFF\FHEMConfiguration\Service;

use Silex\Application;
use YAFF\Database\Entity\FHEMConfiguration;

use Symfony\Component\HttpFoundation\Request;

/**
 * Description of FHEMConfigurationService
 *
 * @author Alex
 */
class FHEMConfigurationService
{

    private $em = null;

    public function __construct(Application $app) {
        $this->em = $app['orm.em'];
    }

    /**
     * Read the form fields from creating or editing settings
     * @param Request $request
     * @param int $id
     * @return \YAFF\Database\Entity\FHEMConfiguration
     */
    public function getConfigFromForm(Request $request, $id) {
        // no config was saved until now
        if ($id === '0') {
            $config = new FHEMConfiguration();
            
        } else {
            $config = $this->em->getRepository("\YAFF\Database\Entity\FHEMConfiguration")->find($id);
        }

        $config->setHost($request->get("host-" . $id));
        $config->setPort($request->get("port-" . $id));

        return $config;
    }
}
