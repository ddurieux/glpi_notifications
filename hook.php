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

   // add option followup_task_display (9.3+2.0)
   $iterator = $DB->request([
      'FROM'   => 'glpi_plugin_notifications_notifications'
   ]);
   while ($data = $iterator->next()) {
      if (!strstr($data['options'], 'followup_task_display')) {
         // add it
         $options = str_replace("}", ',"opt_followup_task_display":"separate"}', $data['options']);
         $DB->update(
               'glpi_plugin_notifications_notifications',
               ['options' => $options],
               ['WHERE' => ['id' => $data['id']]]);
      }
      if (!strstr($data['options'], 'subject')) {
         $options = str_replace("}", ',"opt_subject":"##ticket.shortentity## - ##ticket.action## : ##ticket.title##"}', $data['options']);
         $DB->update(
               'glpi_plugin_notifications_notifications',
               ['options' => $options],
               ['WHERE' => ['id' => $data['id']]]);
      }
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

/**
 * Fill tags with data from database
 */
function plugin_notifications_item_get_datas(NotificationTarget $item) {

   $item->data['activitymessages'] = [];

   $restrict = ['tickets_id' => $item->obj->getField('id')];
   $restrict_noprivate  = $restrict;
   $restrict_noprivate['is_private'] = 0;

   // for followup and tasks, we compare followups / tasks got by the core and compare total with get here (only public and all)
   // for that we use  $item->data['followups'] and $item->data['tasks']
   $followups_in_data = count($item->data['followups']);
   $tasks_in_data = count($item->data['tasks']);

   // Get followups
   $followups = getAllDatasFromTable('glpi_ticketfollowups', $restrict, false);
   $followups_noprivate = getAllDatasFromTable('glpi_ticketfollowups', $restrict_noprivate, false);

   $allfollowups = [];
   if (count($followups_noprivate) == $followups_in_data) {
      $allfollowups = $followups_noprivate;
   } else if (count($followups) == $followups_in_data) {
      $allfollowups = $followups;
   } else {
      $allfollowups = $followups_noprivate;
   }

   foreach ($allfollowups as $followup) {
      $tmp = [
         '##activitymessage.type##'        => 'followup',
         '##activitymessage.isprivate##'   => Dropdown::getYesNo($followup['is_private']),
         '##activitymessage.author##'      => Html::clean(getUserName($followup['users_id'])),
         '##activitymessage.requesttype##' => Dropdown::getDropdownName('glpi_requesttypes', $followup['requesttypes_id']),
         '##activitymessage.date##'        => Html::convDateTime($followup['date']),
         '##activitymessage.description##' => Html::clean($followup['content']),
         '##activitymessage.category##'    => '',
         '##task.time##'                   => ''
      ];
      $item->data['activitymessages'][strtotime($followup['date'])] = $tmp;
   }

   // get tasks
   $tasks = getAllDatasFromTable('glpi_tickettasks', $restrict, false);
   $tasks_noprivate = getAllDatasFromTable('glpi_tickettasks', $restrict_noprivate, false);
   $alltasks = [];
   if (count($tasks_noprivate) == $tasks_in_data) {
      $alltasks = $tasks_noprivate;
   } else if (count($tasks) == $tasks_in_data) {
      $alltasks = $tasks;
   } else {
      $alltasks = $tasks_noprivate;
   }

   foreach ($alltasks as $task) {
      $tmp = [
         '##activitymessage.type##'        => 'task',
         '##activitymessage.isprivate##'   => Dropdown::getYesNo($task['is_private']),
         '##activitymessage.author##'      => Html::clean(getUserName($task['users_id'])),
         '##activitymessage.requesttype##' => '',
         '##activitymessage.date##'        => Html::convDateTime($task['date']),
         '##activitymessage.description##' => Html::clean($task['content']),
         '##activitymessage.category##'    => Dropdown::getDropdownName('glpi_taskcategories', $task['taskcategories_id']),
         '##task.time##'                   => Html::timestampToString($task['actiontime'], false)
      ];
      $item->data['activitymessages'][strtotime($task['date'])] = $tmp;
   }
   krsort($item->data['activitymessages']);
   $item->data['##ticket.numberofactivitymessages##'] = count($item->data['activitymessages']);
}
