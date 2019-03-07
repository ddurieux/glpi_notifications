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

define ("PLUGIN_NOTIFICATIONS_VERSION", "9.3+2.1");

include_once(GLPI_ROOT."/inc/includes.php");


/**
 * Init the hooks of Notifications
 *
 * @global array $PLUGIN_HOOKS
 * @global array $CFG_GLPI
 */
function plugin_init_notifications() {
   global $PLUGIN_HOOKS, $CFG_GLPI;

   $PLUGIN_HOOKS['csrf_compliant']['notifications'] = true;

   $Plugin = new Plugin();
   $moduleId = 0;

   $debug_mode = false;
   if (isset($_SESSION['glpi_use_mode'])) {
      $debug_mode = ($_SESSION['glpi_use_mode'] == Session::DEBUG_MODE);
   }

   if ($Plugin->isActivated('notifications')) { // check if plugin is active
      Plugin::registerClass('PluginNotificationsNotification');

      if (Session::haveRight('config', READ)) {
         $PLUGIN_HOOKS["menu_toadd"]['notifications']['config'] = 'PluginNotificationsNotification';
      }
      $PLUGIN_HOOKS['item_get_datas']['notifications'] =
               ['NotificationTargetTicket' => 'plugin_notifications_item_get_datas'];

   }
}



/**
 * Manage the version information of the plugin
 *
 * @return array
 */
function plugin_version_notifications() {
   return [
      'name'           => 'Notifications',
      'shortname'      => 'notifications',
      'version'        => PLUGIN_NOTIFICATIONS_VERSION,
      'license'        => 'AGPLv3+',
      'author'         => '<a href="mailto:david@durieux.family">David DURIEUX</a>
                        & <a href="mailto:dcs.glpi@dcsit-group.com">DCS company</a>',
      'homepage'       =>'https://github.com/ddurieux/glpi_notifications',
      'minGlpiVersion' => '9.3'
   ];
}



/**
 * Manage / check the prerequisites of the plugin
 *
 * @global object $DB
 * @return boolean
 */
function plugin_notifications_check_prerequisites() {

   return true;
}



/**
 * Check if the config is ok
 *
 * @return boolean
 */
function plugin_notifications_check_config() {
   return true;
}
