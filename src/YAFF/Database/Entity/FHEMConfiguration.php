<?php
namespace YAFF\Database\Entity;

/**
 * @Table(name="fhem_configuration")
 * @Entity
 **/
class FHEMConfiguration
{
    /** 
     * @Id 
     * @Column(type="integer") 
     * @GeneratedValue 
     */
    private $id;

    /** 
     * @Column(type="string", length=255)
     */
    private $host;

    /** 
     * @Column(type="string", length=5)
     */
    private $port;

    /**
     * Konstruktor
     */
    public function __construct() {
        
    }

    public function getId()
    {
        return $this->id;
    }

    public function getHost() {
        return $this->host;
    }

    public function getPort() {
        return $this->port;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
    
    public function setHost($host) {
        $this->host = $host;
    }

    public function setPort($port) {
        $this->port = $port;
    }
}
