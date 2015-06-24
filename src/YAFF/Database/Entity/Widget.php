<?php

namespace YAFF\Database\Entity;

/**
 * @Table(name="yaff_dashboard_widgets")
 * @Entity
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="type", type="integer")
 * @DiscriminatorMap({"0" = "Widget", "1" = "GraphWidget", "2" = "RoomWidget"})
 */
class Widget
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
   private $title;

	/**
	 * @Column(type="integer")
	 */
	private $idx;
    
    function getId() {
        return $this->id;
    }

    function getTitle() {
        return $this->title;
    }
    
    function setTitle($title) {
        $this->title = $title;
    }

    function getIdx() {
        return $this->idx;
    }
    
    function setIdx($idx) {
        $this->idx = $idx;
    }

    function setType($type) {
        $this->type = $type;
    }
}
?>