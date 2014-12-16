<?php

namespace YAFF\Database\Entity;

/**
 * @Table(name="yaff_dashboard_widgets")
 * @Entity
 */
class Widget {
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
        * @Column(type="string", length=255)
        */
       private $device;
       
       /** 
        * @Column(type="string", length=255)
        */
       private $reading;
       
       /** 
        * Describes the type of the widget
        * 1 - Graph
        * @Column(type="integer")
        */
       private $type;
       
       /** 
        * @Column(type="integer")
        */
       private $intervall;
	
	/**
	 * @Column(type="integer")
	 */
	private $index;
        
        function getId() {
            return $this->id;
        }

        function getTitle() {
            return $this->title;
        }

        function getDevice() {
            return $this->device;
        }

        function getReading() {
            return $this->reading;
        }

        function getIndex() {
            return $this->index;
        }        
        
        function getIntervall() {
            return $this->intervall;
        }
        
        function getType() {
            return $this->type;
        }

        function setType($type) {
            $this->type = $type;
        }

        function setTitle($title) {
            $this->title = $title;
        }

        function setDevice($device) {
            $this->device = $device;
        }

        function setReading($reading) {
            $this->reading = $reading;
        }

        function setIndex($index) {
            $this->index = $index;
        }

        function setIntervall($intervall) {
            $this->intervall = $intervall;
        }
}
?>