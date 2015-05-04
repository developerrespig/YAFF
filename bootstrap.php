<?php
    $app = new Silex\Application();

    require_once 'config/ServiceProvider.php';
    require_once 'config/Routing.php';
    require_once 'config/Database.php';
    require_once 'config/Security.php';
    require_once 'config/Translation.php';
    require_once 'config/Widgets.php';
