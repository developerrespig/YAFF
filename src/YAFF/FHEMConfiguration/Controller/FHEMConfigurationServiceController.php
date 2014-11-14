<?php

namespace YAFF\FHEMConfiguration\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

use YAFF\Database\Entity\FHEMConfiguration;

/**
 * Controler to manage fhem specific settings
 */
class FHEMConfigurationServiceController
{
    private $app = null;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Overview page for fhem config
     * Displays all settings in a table
     * @return type
     */
    public function indexAction()
    {
        $em = $this->app['orm.em'];
        $configs = $em->getRepository("\YAFF\Database\Entity\FHEMConfiguration")->findAll();
        
        // no config was saved until now
        if(count($configs) == 0) {
            $config = new FHEMConfiguration();
            $config->setId(0);
        } else {
            $config = $configs[0];
        }

        return $this->app['twig']->render('FHEMConfiguration/Views/index.html.twig', array(
            "config" => $config
        ));
    }

    /**
     * Displays the form to edit settings
     * @param Request $request
     * @param int $id
     * @return type
     */
    public function editConfigAction(Request $request, $id)
    {
        $em = $this->app['orm.em'];
        $csrf = $this->app['csrf_protection'];
        // no config saved until now
        if($id === '0') {
            $config = new FHEMConfiguration();
            $config->setId(0);
        } else {
            $config = $em->getRepository("\YAFF\Database\Entity\FHEMConfiguration")->find($id);
        }

        return $this->app['twig']->render('FHEMConfiguration/Views/config_form_edit.html.twig', array(
            'config' => $config,
            'token' => $csrf->getCSRFTokenForForm()
        ));
    }
    
    /**
     * Save changes
     * @param Request $request
     * @param int $id
     * @return type
     */
    public function updateConfigAction(Request $request, $id)
    {
        $csrf = $this->app['csrf_protection'];
        $error = false;
        if (($csrf->validateCSRFToken($request))) {
            $em = $this->app['orm.em'];

            $config = $this->app['FHEMConfigurationService']->getConfigFromForm($request, $id);
            // check for mandatory fields
            if(strlen($config->getHost()) == 0 || strlen($config->getPort()) == 0) {
                $error = true;
                $this->app['session']->getFlashBag()->add('warning', 'flash.mandatory');
            } else if(!preg_match('/^\d+$/',$config->getPort())){ // check for valid port (only numbers are allowed)
                $error = true;
                $this->app['session']->getFlashBag()->add('warning', 'fhemconfig.flash.invalid.port');
            } else {
                // save
                $em->persist($config);
                $em->flush();
                // add success message
                $this->app['session']->getFlashBag()->add('success', 'fhemconfig.flash.edit.success');
            }
        }

        return $this->app['twig']->render('FHEMConfiguration/Views/config_feedback.html.twig', array(
            "error" => $error
        ));
    }
}