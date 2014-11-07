<?php
namespace YAFF\Database\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Table(name="users",uniqueConstraints={@UniqueConstraint(name="u_username", columns={"username"})})
 * @Entity(repositoryClass="YAFF\Database\Repository\UserRepository")
 **/
class User implements UserInterface, \Serializable
{
    /** 
     * @Id 
     * @Column(type="integer") 
     * @GeneratedValue 
     */
    private $id;

    /** 
     * @Column(type="string", length=45)
     */
    private $username;

    /** 
     * @Column(type="string", length=200)
     */
    private $password;

    /**
     * @ManyToOne(targetEntity="Role", inversedBy="users")
     */
    private $role;

    /**
     * @var string
     *
     * @Column(name="salt", type="string", length=40, nullable=false)
     */
    private $salt;

    /**
     * Konstruktor
     */
    public function __construct()
    {
        $this->salt = md5(uniqid(null, true));
    }

    public function getId()
    {
        return $this->id;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    public function getRole()
    {

        return $this->role->getName();
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    // Interface methods
    public function getRoles()
    {
        return array($this->role->getRole());
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function eraseCredentials()
    {
    }

    // Serialize interface
    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            ) = unserialize($serialized);
    }
}
