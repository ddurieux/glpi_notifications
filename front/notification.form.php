<?php

/**
 * Notifications plugins
 *
 * Copyright (C) 2017-2018 by the Notification plugin Development Team.
 *
 * https://github.com/ddurieux/glpi_notifications
 *
 * ------------------------------------------------------------------------
 *
 * LICENSE
 *
 * This file is part of Notifications plugin project.
 *
 * Notifications plugin is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Notifications plugin is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with Notifications plugin. If not, see <http://www.gnu.org/licenses/>.
 *
 * ------------------------------------------------------------------------
 *
 * This file is used to manage hooks
 *
 * ------------------------------------------------------------------------
 *
 * @package   Notifications plugin
 * @author    David Durieux
 * @copyright Copyright (c) 2017-2018 Notifications plugin team
 * @license   AGPL License 3.0 or (at your option) any later version
 *            http://www.gnu.org/licenses/agpl-3.0-standalone.html
 * @link      https://github.com/ddurieux/glpi_notifications
 *
 */

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


Html::header('Notifications', $_SERVER["PHP_SELF"], "config",
             "PluginNotificationsNotification", "notifications");


if (!isset($_GET["id"])) {
   $_GET["id"] = "";
}

$pnNotification->display(['id' => $_GET["id"]]);

Html::footer();
