<?php
  define ('WIDGETS', serialize (array(
          array (
              'name' => 'Graph Widget',
              'jsFunc' => 'yaff.dashboard.modalCreateWidgetGraph',
              'translation' => 'dashboard.widgets.graph.name',
              'repository' => '\YAFF\Database\Entity\GraphWidget'
          ),
          array (
              'name' => 'Room Widget',
              'jsFunc' => 'yaff.dashboard.modalCreateWidgetRoom',
              'translation' => 'dashboard.widgets.room.name',
              'repository' => '\YAFF\Database\Entity\RoomWidget'
          )
  )));
?>
