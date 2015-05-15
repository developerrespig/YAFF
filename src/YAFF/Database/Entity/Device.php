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
}
?>
