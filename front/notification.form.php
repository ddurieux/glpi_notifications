<?php

include ("../../../inc/includes.php");

$pnNotification = new PluginNotificationsNotification();

if (isset($_POST["add"])) {
   $pnNotification->check(-1, CREATE, $_POST);
   $options = [];
   foreach ($_POST as $name=>$value) {
      if (strstr($name, 'opt_')) {
         $options[$name] = $value;
      }
   }
   $_POST['options'] = exportArrayToDB($options);
   $pnNotification->add($_POST);
   Html::back();
} else if (isset($_POST["update"])) {
   $pnNotification->check(-1, UPDATE, $_POST);
   $options = [];
   foreach ($_POST as $name=>$value) {
      if (strstr($name, 'opt_')) {
         $options[$name] = $value;
      }
   }
   $_POST['options'] = exportArrayToDB($options);
   $pnNotification->update($_POST);
   Html::back();
}


Html::header('Notifications', $_SERVER["PHP_SELF"], "admin",
             "", "notifications");


if (!isset($_GET["id"])) {
   $_GET["id"] = "";
}

$pnNotification->display(['id' => $_GET["id"]]);


Html::footer();

?>
