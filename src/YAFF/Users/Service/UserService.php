<?php

namespace YAFF\Users\Service;

use Silex\Application;
use YAFF\Database\Entity\User;

use Symfony\Component\HttpFoundation\Request;

/**
 * Description of UserService
 *
 * @author Alex
 */
class UserService
{

    private $em = null;

    public function __construct(Application $app) {
        $this->em = $app['orm.em'];
    }

    /**
     * Read the form fields from creating or editing a user
     * @param Request $request
     * @param int $id
     * @return \YAFF\Database\Entity\User
     */
    public function getUserFromForm(Request $request, $id = 'new') {

        $user = null;

        if ($id === 'new') {
            $user = new User();
            $user->setUsername($request->get("username-" . $id));
        } else {
            $user = $this->em->getRepository("\YAFF\Database\Entity\User")->find($id);
        }

        $formPassword = $request->get("password-" . $id);
        if (!empty($formPassword)) {
            $user->setPassword((new \Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder())->encodePassword($request->get("password-" . $id), $user->getSalt()));
        }

        $role = $this->em->getRepository("\YAFF\Database\Entity\Role")->find($request->get("role-" . $id));
        $user->setRole($role);

        return $user;
    }

    /**
     * Delete the user from db
     * @param int $id
     * @return boolean
     */
    public function deleteUser($id)
    {
        $user = $this->em->getRepository("\YAFF\Database\Entity\User")->find($id);

        $this->em->remove($user);
        $this->em->flush();

        return true;
    }
}
