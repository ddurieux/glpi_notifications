<?php

include ("../../../inc/includes.php");

Html::header('Notifications', $_SERVER["PHP_SELF"], "admin",
             "", "notifications");


Search::show('PluginNotificationsNotification');

//$pnNotifications = new PluginNotificationsNotification();
//$pnNotifications->displayOptions();

Html::footer();
