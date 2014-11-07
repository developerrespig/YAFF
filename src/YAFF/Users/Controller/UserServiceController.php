<?php

namespace YAFF\Users\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

use YAFF\Database\Entity\User;
use YAFF\Users\Service\UserService;

/**
 * Controler to manage users
 */
class UserServiceController
{
    private $app = null;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Overview page for user management
     * Displays all users in a table
     * @return type
     */
    public function indexAction()
    {
        $em = $this->app['orm.em'];
        $users = $em->getRepository("\YAFF\Database\Entity\User")->findAll();

        return $this->app['twig']->render('Users/Views/index.html.twig', array(
            "users" => $users
        ));
    }

    /**
     * Displays the form to create a new user
     * @return type
     */
    public function newUserAction()
    {
        $em = $this->app['orm.em'];
        $csrf = $this->app['csrf_protection'];
        $roles = $em->getRepository("\YAFF\Database\Entity\Role")->findAll();

        return $this->app['twig']->render('Users/Views/user_form_create.html.twig', array(
            'roles' => $roles,
            'user' => new User(),
            'token' => $csrf->getCSRFTokenForForm()
        ));
    }

    /**
     * Save and create a new user
     * @param Request $request
     * @return type
     */
    public function createUserAction(Request $request)
    {
        $csrf = $this->app['csrf_protection'];
        $error = false;
        if (($csrf->validateCSRFToken($request))) {
            $userem = $this->app['orm.em']->getRepository("\YAFF\Database\Entity\User");
            /* @var $user \YAFF\Database\Entity\User */
            $user = $this->app['UserService']->getUserFromForm($request, "new");

            // check username
            if (!$userem->isUsernameAvailable($user->getUsername())) {
                $this->app['session']->getFlashBag()->add('warning', 'user.flash.username.na');
                $error = true;
            } else if (strlen($user->getUsername()) == 0 || strlen($user->getPassword()) == 0) {
                // check for mandatory fields
                $error = true;
                $this->app['session']->getFlashBag()->add('warning', 'flash.mandatory');
            } else {
                $em = $this->app['orm.em'];
                $em->persist($user);
                $em->flush();

                // add succes message
                $this->app['session']->getFlashBag()->add('success', 'user.flash.create.success');
            }
        }

        return $this->app['twig']->render('Users/Views/user_feedback.html.twig', array(
            "error" => $error
        ));
    }

    /**
     * Displays the form to edit a user
     * @param Request $request
     * @param int $id
     * @return type+
     */
    public function editUserAction(Request $request, $id)
    {
        $em = $this->app['orm.em'];
        $csrf = $this->app['csrf_protection'];
        $roles = $em->getRepository("\YAFF\Database\Entity\Role")->findAll();
        $user = $em->getRepository("\YAFF\Database\Entity\User")->find($id);

        return $this->app['twig']->render('Users/Views/user_form_edit.html.twig', array(
            'roles' => $roles,
            'user' => $user,
            'token' => $csrf->getCSRFTokenForForm()
        ));
    }
    
    /**
     * Save changes to a user
     * @param Request $request
     * @param int $id
     * @return type
     */
    public function updateUserAction(Request $request, $id)
    {
        $csrf = $this->app['csrf_protection'];
        $error = false;
        if (($csrf->validateCSRFToken($request))) {
            $userem = $this->app['orm.em']->getRepository("\YAFF\Database\Entity\User");

            $user = $this->app['UserService']->getUserFromForm($request, $id);

            $em = $this->app['orm.em'];
            $em->persist($user);
            $em->flush();

            // add succes message
            $this->app['session']->getFlashBag()->add('success', 'user.flash.edit.success');

        }

        return $this->app['twig']->render('Users/Views/user_feedback.html.twig', array(
            "error" => $error
        ));
    }

    /**
     * Delets a user (post) or displays the form to ask for deletion (get)
     * @param Request $request
     * @param int $id
     * @return string
     */
    public function deleteUserAction(Request $request, $id)
    {
        $csrf = $this->app['csrf_protection'];

        if ($request->getMethod() == 'POST') {
            if (($csrf->validateCSRFToken($request, true))) {
                $user = $this->app['UserService']->deleteUser($id);
                $this->app['session']->getFlashBag()->add('success', 'user.flash.delete.success');
            }
            return 'ok';
        } else {
            // initial get load (ask for deleting)
            return $this->app['twig']->render('Users/Views/user_form_delete.html.twig', array(
                "id" => $id,
                'token' => $csrf->getCSRFTokenForForm()
            ));
        }

    }
}