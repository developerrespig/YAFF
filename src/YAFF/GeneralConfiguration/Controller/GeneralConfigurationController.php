<?php
namespace YAFF\GeneralConfiguration\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use YAFF\Database\Entity\GeneralConfiguration;

/**
 * Handles all general configuration requests
 *
 * @author Martin Gypser
 */

class GeneralConfigurationController
{
	private $app = null;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function indexAction()
    {
        $em = $this->app['orm.em'];
        $csrf = $this->app['csrf_protection'];
        $config = $em->getRepository("\YAFF\Database\Entity\GeneralConfiguration")->find(1);

        // no config was saved until now
        if($config == null) {
            $config = new GeneralConfiguration();
            $config->setcolumns(3);
            $config->setrows(2);
        }

    	return $this->app['twig']->render('GeneralConfiguration/Views/index.html.twig', array(
            "config" => $config,
            'token' => $csrf->getCSRFTokenForForm()
        ));
    }

    public function saveAction(Request $request) {
        $csrf = $this->app['csrf_protection'];
        if (($csrf->validateCSRFToken($request))) {
            $em = $this->app['orm.em'];
            $config = $this->app['GeneralConfigurationService']->getConfigFromForm($request);
            $em->persist($config);
            $em->flush();
            $this->app['session']->getFlashBag()->add('success', 'generalconfig.flash.save.success');
        }
        return new Response("", 200);
    }
}