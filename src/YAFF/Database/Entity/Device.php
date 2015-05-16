<?php

namespace YAFF\Database\Entity;

/**
 * @Table(name="yaff_dashboard_widget_room_devices")
 * @Entity
 */
class Device {
  /**
   * @Id
   * @Column(type="integer")
   * @GeneratedValue
   */
  private $id;

  /**
   * @Column(type="string", length=255)
   */
   private $name;

   /**
    * @Column(type="string", length=255)
    */
   private $deviceType;

  /**
   * @ManyToOne(targetEntity="RoomWidget", inversedBy="devices")
   */
    private $room;

    public function setRoom($room)
    {
      $this->room = $room;
    }

    public function getName()
    {
      return $this->name;
    }

    public function setName($name)
    {
      $this->name = $name;
    }

    public function getDeviceType()
    {
      return $this->deviceType;
    }

    public function setDeviceType($deviceType)
    {
      $this->deviceType = $deviceType;
    }
}
?>
