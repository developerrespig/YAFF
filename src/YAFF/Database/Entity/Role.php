<?php
namespace YAFF\Database\Entity;

use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * @Entity
 * @Table(name="roles")
 */
class Role implements RoleInterface, \Serializable
{
    /**
     * @Column(name="id", type="integer")
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Column(name="name", type="string", length=30)
     */
    private $name;

    /**
     * @Column(name="role", type="string", length=20, unique=true)
     */
    private $role;

    /**
     * @OneToMany(targetEntity="User", mappedBy="role")
     */
    private $users;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getUsers()
    {
        return $this->users;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setUsers($users)
    {
        $this->users = $users;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->name,
            $this->role
        ));
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->name,
            $this->role
            ) = unserialize($serialized);
    }

    /**
     * Add users
     *
     * @param \YAFF\Database\Entity\User $users
     * @return Role
     */
    public function addUser(\YAFF\Database\Entity\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \YAFF\Database\Entity\User $users
     */
    public function removeUser(\YAFF\Database\Entity\User $users)
    {
        $this->users->removeElement($users);
    }
}
