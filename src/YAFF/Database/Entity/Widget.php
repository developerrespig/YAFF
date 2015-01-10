<?php

namespace YAFF\Database\Entity;

/**
 * @Table(name="yaff_dashboard_widgets")
 * @Entity(repositoryClass="YAFF\Database\Repository\WidgetRepository")
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
       private $interval;
	
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

        function getDevice() {
            return $this->device;
        }

        function getReading() {
            return $this->reading;
        }

        function getIdx() {
            return $this->idx;
        }        
        
        function getInterval() {
            return $this->interval;
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

        function setIdx($idx) {
            $this->idx = $idx;
        }

        function setInterval($interval) {
            $this->interval = $interval;
        }
}
?>