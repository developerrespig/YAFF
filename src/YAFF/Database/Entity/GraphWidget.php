<?php

namespace YAFF\Database\Entity;

/**
 * @Table(name="yaff_dashboard_widgets_graph_data")
 * @Entity(repositoryClass="YAFF\Database\Repository\GraphWidgetRepository")
 */
class GraphWidget extends Widget{
   
   /** 
    * @Column(type="string", length=255)
    */
   private $device;
   
   /** 
    * @Column(type="string", length=255)
    */
   private $reading;
   
   /** 
    * @Column(type="integer")
    */
   private $interval;

    function getDevice() {
        return $this->device;
    }

    function getReading() {
        return $this->reading;
    }
    
    function getInterval() {
        return $this->interval;
    }

    function setDevice($device) {
        $this->device = $device;
    }

    function setReading($reading) {
        $this->reading = $reading;
    }

    function setInterval($interval) {
        $this->interval = $interval;
    }
    
    function getType() {
        return 1;
    }
}
?>