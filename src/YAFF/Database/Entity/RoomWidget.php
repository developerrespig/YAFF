<?php

namespace YAFF\Database\Entity;

/**
 * @Table(name="yaff_dashboard_widget_room_data")
 */
class RoomWidget extends Widget {
    function getType() {
        return 2;
    }
}
?>