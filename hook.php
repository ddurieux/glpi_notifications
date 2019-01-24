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


/**
 * Manage the installation process
 *
 * @return boolean
 */
function plugin_notifications_install() {
   global $DB;

   if (!$DB->tableExists('glpi_plugin_notifications_notifications')) {
      $query = "CREATE TABLE `glpi_plugin_notifications_notifications` (
         `id` int(11) NOT NULL AUTO_INCREMENT,
         `name` varchar(255) DEFAULT NULL,
         `entities_id` int(11) NOT NULL DEFAULT '0',
         `is_recursive` tinyint(1) NOT NULL DEFAULT '1',
         `last_generation` datetime DEFAULT NULL,
         `options` text DEFAULT NULL,
         `itemtype` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
         `event` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
         `comment` text COLLATE utf8_unicode_ci,
         `date_mod` datetime DEFAULT NULL,
         `date_creation` datetime DEFAULT NULL,
         PRIMARY KEY (`id`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
      $DB->query($query);
   }
   return true;
}



/**
 * Manage the uninstallation of the plugin
 *
 * @return boolean
 */
function plugin_notifications_uninstall() {
   global $DB;

   $query = "DROP TABLE `glpi_plugin_notifications_notifications`";
   $DB->query($query);
   return true;
}
