<?php

namespace YAFF\Database\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Table(name="yaff_dashboard_widget_room_data")
 * @Entity(repositoryClass="YAFF\Database\Repository\WidgetRepository")
 */
class RoomWidget extends Widget {
  /**
   * @OneToMany(targetEntity="Device", mappedBy="room", cascade={"persist"})
   **/
  private $devices;

  public function __construct() {
    $this->devices = new ArrayCollection();
  }

  public function getDevices() {
    return $this->devices;
  }

  public function getType() {
        return 2;
  }
}
?>
