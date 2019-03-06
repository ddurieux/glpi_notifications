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

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access directly to this file");
}

class PluginNotificationsNotification extends CommonDBTM {

   static $rightname = 'config';


   /**
    * Name of the type
    *
    * @param $nb  integer  number of item in the type (default 0)
   **/
   static function getTypeName($nb = 0) {
      return __('Notifications generation', 'notifications');
   }



   function showForm($ID, $options = []) {
      global $CFG_GLPI, $DB;

      $this->initForm($ID, $options);
      $this->showFormHeader($options);

      echo "<tr class='tab_bg_1'>";

      $rand = mt_rand();

      echo "<tr class='tab_bg_1'>";
      echo "<td><label for='textfield_name$rand'>".sprintf(__('%1$s%2$s'), __('Name'), $this->fields['name']) .
           "</label></td>";
      echo "<td>";
      $objectName = autoName($this->fields["name"], "name", false,
                             $this->getType(), $this->fields["entities_id"]);
      Html::autocompletionTextField(
         $this,
         'name',
         [
            'value'     => $objectName,
            'rand'      => $rand
         ]
      );
      echo "</td>";

      echo "<td>" . NotificationEvent::getTypeName(1) . "</td>";
      echo "<td><span id='show_events'>";
      NotificationEvent::dropdownEvents('Ticket',
                                        ['value'=>$this->fields['event'],
                                         'display_emptychoice' => false]);
      echo "</span></td>";
      echo "</tr>\n";

      echo "<tr class='tab_bg_1'>";
      echo "<td><label for='comment'>".__('Comments')."</label></td>";
      echo "<td class='middle'>";

      echo "<textarea cols='45' rows='3' id='comment' name='comment' >".
           $this->fields["comment"];
      echo "</textarea></td>";
      echo "<td></td>";
      echo "<td></td>";
      echo "</tr>";

      $this->displayOptions();

      $this->showFormButtons($options);

      return true;
   }



   /**
    * @see CommonDBTM::getSpecificMassiveActions()
    **/
   function getSpecificMassiveActions($checkitem = null) {

      $isadmin = static::canUpdate();
      $actions = parent::getSpecificMassiveActions($checkitem);

      if ($isadmin) {
         $actions['PluginNotificationsNotification'.MassiveAction::CLASS_ACTION_SEPARATOR.'generate'] = __('Generate the notification template');
      }

      return $actions;
   }



   static function processMassiveActionsForOneItemtype(MassiveAction $ma, CommonDBTM $item,
                                                       array $ids) {

      if ($ma->getAction() == 'generate') {
         foreach ($ids as $id) {
            if ($item->generateNotification($id)) {
               $ma->itemDone($item->getType(), $id, MassiveAction::ACTION_OK);
            } else {
               $ma->itemDone($item->getType(), $id, MassiveAction::ACTION_KO);
               $ma->addMessage($item->getErrorMessage(ERROR_ON_ACTION, $id));
            }
         }
      }
      parent::processMassiveActionsForOneItemtype($ma, $item, $ids);
   }



   function getOptions() {
      return [
          'subject' => [
              'name' => __('Subject'),
              'type' => 'string'
          ],
          'left_image' => [
              'name'    => __('image Helpdesk à gauche'),
              'type'    => 'select',
              'allowed' => ['None' => 'none', 'M' => 'M', 'XL' => 'XL'],
              'default' => 'M'
          ],
          'entity' => [
              'name' => __('Entity'),
              'type' => 'boolean'
          ],
          'title' => [
              'name' => __('title'),
              'type' => 'boolean'
          ],
          'opening_date' => [
              'name' => __('opening date'),
              'type' => 'boolean'
          ],
          'due_date' => [
              'name' => __('Due date'),
              'type' => 'boolean'
          ],
          'description' => [
              'name' => __('description'),
              'type' => 'boolean'
          ],
          'category' => [
              'name' => __('Category'),
              'type' => 'boolean'
          ],
          'urgency' => [
              'name' => __('Urgency'),
              'type' => 'boolean'
          ],
          'impact' => [
              'name' => __('Impact'),
              'type' => 'boolean'
          ],
          'priority' => [
              'name' => __('Priority'),
              'type' => 'boolean'
          ],
          'associated_items' => [
              'name' => __('Associated items'),
              'type' => 'boolean'
          ],
          'location' => [
              'name' => __('Location'),
              'type' => 'boolean'
          ],
          'request_person' => [
              'name' => __('Requester person'),
              'type' => 'boolean'
          ],
          'request_group' => [
              'name' => __('Requester group'),
              'type' => 'boolean'
          ],
          'observer_person' => [
              'name' => __('Observer person'),
              'type' => 'boolean'
          ],
          'observer_group' => [
              'name' => __('observer group'),
              'type' => 'boolean'
          ],
          'tech_person' => [
              'name' => __('Tech person'),
              'type' => 'boolean'
          ],
          'tech_group' => [
              'name' => __('Tech group'),
              'type' => 'boolean'
          ],
          'supplier' => [
              'name' => __('Supplier'),
              'type' => 'boolean'
          ],
          'type' => [
              'name' => __('Type'),
              'type' => 'boolean'
          ],
          'status' => [
              'name' => __('Status'),
              'type' => 'boolean'
          ],
          'followups' => [
              'name' => __('Followups'),
              'type' => 'boolean'
          ],
          'followups_author' => [
              'name' => __('Followup author'),
              'type' => 'boolean'
          ],
          'tasks' => [
              'name' => __('Tasks'),
              'type' => 'boolean'
          ],
          'tasks_author' => [
              'name' => __('Task author'),
              'type' => 'boolean'
          ],
          'tasks_time' => [
              'name' => __('Task time'),
              'type' => 'boolean'
          ],
          'tasks_category' => [
              'name' => __('Task category'),
              'type' => 'boolean'
          ],
          'url_link' => [
              'name' => __('URL link to GLPI'),
              'type' => 'boolean'
          ],
          'solution' => [
              'name' => _n('Solution', 'Solutions', 1),
              'type' => 'boolean'
          ],
          'footer_text' => [
              'name' => __('Footer text', 'notification'),
              'type' => 'text'
          ],
          'followup_task_display' => [
              'name'    => __('Display followups and tasks'),
              'type'    => 'select',
              'allowed' => ['separate' => __('separate', 'notifications'),
                            'unified'  => __('unified', 'notifications')],
              'default' => 'unified'
          ]
      ];
   }


   function displayOptions() {
      global $CFG_GLPI;

      $options = $this->getOptions();

      echo "<tr class='tab_bg_1'>";
      echo "<th colspan='4'>";
      echo __('Options list');
      echo "</th>";
      echo "</tr>";
      $db_options = importArrayFromDB($this->fields['options']);
      foreach ($options as $name=>$data) {
         if ($data['type'] == 'boolean' and !isset($db_options['opt_'.$name])) {
            $db_options['opt_'.$name] = 1;
         }
      }

      $i = 0;
      foreach ($options as $name=>$data) {
         if ($i == 0) {
            echo "<tr class='tab_bg_1'>";
         }
         echo "<td>";
         echo $data['name'];
         echo "</td>";
         echo "<td>";
         if ($data['type'] == 'boolean') {
            Dropdown::showYesNo('opt_'.$name, $db_options['opt_'.$name]);
         } else if ($data['type'] == 'select') {
            if (!isset($db_options['opt_'.$name])) {
               $db_options['opt_'.$name] = $data['default'];
            }
            Dropdown::showFromArray('opt_'.$name, $data['allowed'],
                    ['value' => $db_options['opt_'.$name]]);
         } else if ($data['type'] == 'string') {
            if ($name == 'subject'
                  AND !isset($db_options['opt_'.$name])) {
               $db_options['opt_'.$name] = '##ticket.shortentity## - ##ticket.action## : ##ticket.title##';
            }
            if ($name == 'subject') {
               $rand = mt_rand();
               Ajax::createIframeModalWindow("tags".$rand,
                                             $CFG_GLPI['root_doc']."/front/notification.tags.php?sub_type=".
                                                'Ticket');
               echo "<a class='vsubmit' href='#' onClick=\"".Html::jsGetElementbyID("tags".$rand).".dialog('open'); return false;\">".__('Show list of available tags')."</a><br/>";
            }
            echo Html::input('opt_'.$name, [
               'value' => $db_options['opt_'.$name],
               'size'  => 45
               ]);
         } else if ($data['type'] == 'text') {
            if ($name == 'footer_text'
                  AND !isset($db_options['opt_'.$name])) {
               $db_options['opt_'.$name] = 'This email was generated by Glpi - Designed by David Durieux - HC';
            }

            Html::textarea(['name' => 'opt_'.$name,
               'value' => $db_options['opt_'.$name],
               'cols' => 50,
               'rows' => 2]);
         }
         echo "</td>";
         $i++;
         if ($i > 1) {
            echo "</tr>";
            $i = 0;
         }
      }
      if ($i > 0) {
         echo "<td colspan='2'>";
         echo "</td>";
         echo "</tr>";
      }
   }


   function notification_blue($type, $options) {
      global $CFG_GLPI;

      $blocks = [];

      $blocks[] = '<div style="font-family: Helvetica;">
  <table style="border-collapse: collapse;width: 950px; border-top-left-radius: 6px;border-top-right-radius: 6px;background-color: #1B2F62;color: #ffffff;height: 80px;">
    <tr style="height: 25px">
      <td style="width:160px" rowspan="2">
        <img alt="GLPi" title="Glpi" width="100" height="55" src="'.$CFG_GLPI["url_base"].'/pics/fd_logo.png" />
      </td>
      <td style="width:350px;height: 30px;font-size: 24px;color: #ffffff;" rowspan="2">';

      if ($options['entity']) {
         $blocks[] = "<b>##ticket.shortentity##</b>\n";
      }
      $blocks[] = '      </td>';

      if ($options['request_person']) {
         $blocks[] = '<td style="font-size: 12px;color: #ffffff;">
            ##lang.author.name##:
         </td>';
      }
      if ($options['observer_person']) {
         $blocks[] = '<td style="font-size: 12px;color: #ffffff;">
            ##lang.ticket.observerusers##:
         </td>';
      }

      $blocks[] = '</tr>
    <tr style="height: 55px;color: #ffffff;">';
      if ($options['request_person']) {
         $blocks[] = '
      <td style="font-size: 18px;color: #ffffff;">
        ##ticket.authors##
      </td>';
      }
      if ($options['observer_person']) {
         $blocks[] = '
      <td style="font-size: 18px;color: #ffffff;">
        ##ticket.observerusers##
      </td>';
      }

      $blocks[] = '</tr>';
      $blocks[] = "  </table>\n";
      $blocks[] = '<table style="border-collapse: collapse;width: 950px;background-color: #1b2f62;">
    <tr style="height: 40px">
      <td style="width: 119px;background-color: #1B2F62;"></td>
      <td style="background-color: #[[replacebgcolor]];text-align: center;font-size: 18px;color: #fff;border-top-left-radius: 6px;">
        <b>##ticket.action##</b>
      </td>
    </tr>
  </table>';

      $blocks[] = '<div style="background-color: #f8f7f3;width: 949px;border-right: 1px solid #ccc;border-collapse: collapse;">
    <table style="border-collapse: collapse;width: 950px;height: 100px;">
      <tr>
        <td style="width: 120px;background-color: #1B2F62;vertical-align: top;">';

      if ($options['left_image'] == 'M' or $options['left_image'] == 'XL') {
         $image_name = "helpdesk";
         if ($CFG_GLPI['language'] == 'fr_FR') {
            $image_name = "assistance_informatique";
         }

         $blocks[] = '<img src="https://raw.githubusercontent.com/ddurieux/glpi_notifications/master/pics/'.$image_name.'_'.$options['left_image'].'.png" alt="helpdesk"/>';
      }
      $blocks[] = '</td>
        <td style="vertical-align: top;width: 20px;"></td>
        <td style="vertical-align: top;width: 786px;">';

      if ($type == 'add_followup') {
         $blocks[] = '
##FOREACH LAST followups##
          <table style="border-collapse: collapse;width: 786px;height: 120px;">
            <tr>
              <td style="height: 15px;"></td>
            </tr>
            <tr style="height: 30px;font-size: 16px;">
              <th style="background-color: #5bc0de;color: #fff;width: 786px;">Le dernier suivi ajouté</th>
            </tr>
            <tr>
              <td style="background-color: #eaeaea;">
                <table>
                  <tr>
                    <td colspan="2">';
         if ($options['followups_author']) {
            $blocks[] = '<b>'.__('By').'</b> <i>##followup.author##</i> <b>le</b> <i>##followup.date##</i></td>';
         } else {
            $blocks[] = '<b>Le</b> <i>##followup.date##</i></td>';
         }
         $blocks[] = '
                  </tr>
                  <tr>
                    <td colspan="2" style="height: 8px;"></td>
                  </tr>
                  <tr>
                    <td colspan="2">##followup.description##</td>
                  </tr>
                  <tr>
                    <td colspan="2" style="height: 15px;"></td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td style="height: 15px;"></td>
            </tr>
          </table>
##ENDFOREACHfollowups##';
      }
      if ($type == 'add_task') {
         $blocks[] = '##FOREACH LAST tasks##
          <table style="border-collapse: collapse;width: 786px;height: 120px;">
            <tr>
              <td style="height: 15px;"></td>
            </tr>
            <tr style="height: 30px;font-size: 16px;">
              <th style="background-color: #5bc0de;color: #fff;width: 786px;">La dernière tâche ajoutée</th>
            </tr>
            <tr>
              <td style="background-color: #eaeaea;">
                <table>
                  <tr>';
         if ($options['tasks_author']) {
            $blocks[] = '<td colspan="2"><b>'.__('By').'</b> <i>##task.author##</i> <b>le</b> <i>##task.date##</i></td>';
         } else {
            $blocks[] = '<td colspan="2"><b>Le</b> <i>##task.date##</i></td>';
         }
         $blocks[] = '</tr>';
         if ($options['tasks_time']) {
            $blocks[] = '<tr>
                    <td><b>##lang.task.time##</b></td>
                    <td>##task.time##</td>
                  </tr>';
         }
         if ($options['tasks_category']) {
            $blocks[] = '<tr>
                    <td><b>##lang.task.category##</b></td>
                    <td>##task.category##</td>
                  </tr>';
         }
         $blocks[] = '
                  <tr>
                    <td colspan="2" style="height: 8px;"></td>
                  </tr>
                  <tr>
                    <td colspan="2">##task.description##</td>
                  </tr>
                  <tr>
                    <td colspan="2" style="height: 15px;"></td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td style="height: 15px;"></td>
            </tr>
          </table>
##ENDFOREACHtasks##';
      }

      $blocks[] = '<br/>
          <table style="border-collapse: collapse;width: 786px;height: 100px;">
            <tr style="height: 30px;font-size: 16px;">
              <th colspan="4" style="background-color: #5bc0de;color: #fff;width: 786px;">Informations du ticket ##ticket.id##</th>
            </tr>
            <tr style="height: 20px;">
              <td colspan="4" style="background-color: #eaeaea;"></td>
            </tr>
            <tr>
              <td colspan="2" style="width: 393px;background-color: #eaeaea;">';
      if ($options['tech_person']) {
         $blocks[] = '
               <b>##lang.ticket.assigntousers##:</b> ##ticket.assigntousers##';
      }
      $blocks[] = '
              </td>
              <td colspan="2" style="width: 393px;background-color: #eaeaea;">';
      if ($options['tech_group']) {
         $blocks[] = '
               <b>##lang.ticket.assigntogroups##:</b> ##ticket.assigntogroups##';
      }
      $blocks[] = '
              </td>
            </tr>

            <tr style="height: 20px;">
              <td colspan="4" style="background-color: #eaeaea;"></td>
            </tr>
            <tr>
              <td colspan="4" style="background-color: #eaeaea;">';

      if ($options['type']) {
         $blocks[] = '<table style="border-collapse: collapse;width: 786px;">
                 <tr>
                   <td style="width: 283px;background-color: #eaeaea;">
                     <hr style="display: block;width: 330px;height: 2px;border: 0;border-top: 2px solid #ccc;margin: 10;padding: 10;"/>
                   </td>
                   <td style="width: 250px;text-align: center;background-color: #eaeaea;">
                     <b>##lang.ticket.type##</b>
                     ##ticket.type##
                   </td>
                   <td style="width: 283px;background-color: #eaeaea;">
                     <hr style="display: block;width: 330px;height: 2px;border: 0;border-top: 2px solid #ccc;margin: 10;padding: 10;"/>
                   </td>
                 </tr>
               </table>';
      }
      $blocks[] = '
              </td>
            </tr>
            <tr>';
      if ($options['status']) {
         $blocks[] = '<td style="width: 150px;background-color: #eaeaea;">
                <b>##lang.ticket.status##</b>
              </td>
              <td style="width: 258px;background-color: #eaeaea;">
                 ##ticket.status##
              </td>';
      } else {
         $blocks[] = '<td style="width: 150px;background-color: #eaeaea;"></td>
              <td style="width: 258px;background-color: #eaeaea;"></td>';
      }
      if ($options['category']) {
         $blocks[] = '<td style="width: 150px;background-color: #eaeaea;">
                <b>##lang.ticket.category##</b>
              </td>
              <td style="width: 258px;background-color: #eaeaea;">
                ##ticket.category##
              </td>';
      } else {
         $blocks[] = '<td style="width: 150px;background-color: #eaeaea;"></td>
              <td style="width: 258px;background-color: #eaeaea;"></td>';
      }
      $blocks[] = '</tr>
            <tr>';
      if ($options['priority']) {
         $blocks[] = '
              <td style="width: 150px;background-color: #eaeaea;">
                <b>##lang.ticket.priority## ##ticket.priority##</b>
              </td>
              <td style="width: 258px;background-color: #eaeaea;">
                ##IFticket.priority=Très basse##
                <span style="color:#01ca02;">&#9733;</span>
                ##ENDIFticket.priority##
                ##IFticket.priority=Basse##
                <span style="color:#c9f30b;">&#9733;</span>
                <span style="color:#c9f30b;">&#9733;</span>
                ##ENDIFticket.priority##
                ##IFticket.priority=Moyenne##
                <span style="color:#ffcc00;">&#9733;</span>
                <span style="color:#ffcc00;">&#9733;</span>
                <span style="color:#ffcc00;">&#9733;</span>
                ##ENDIFticket.priority##
                ##IFticket.priority=Haute##
                <span style="color:#ff8500;">&#9733;</span>
                <span style="color:#ff8500;">&#9733;</span>
                <span style="color:#ff8500;">&#9733;</span>
                <span style="color:#ff8500;">&#9733;</span>
                ##ENDIFticket.priority##
                ##IFticket.priority=Très haute##
                <span style="color:#ff4000;">&#9733;</span>
                <span style="color:#ff4000;">&#9733;</span>
                <span style="color:#ff4000;">&#9733;</span>
                <span style="color:#ff4000;">&#9733;</span>
                <span style="color:#ff4000;">&#9733;</span>
                ##ENDIFticket.priority##
                ##IFticket.priority=Majeure##
                <span style="color:#f10b0b;">&#9733;</span>
                <span style="color:#f10b0b;">&#9733;</span>
                <span style="color:#f10b0b;">&#9733;</span>
                <span style="color:#f10b0b;">&#9733;</span>
                <span style="color:#f10b0b;">&#9733;</span>
                <span style="color:#f10b0b;">&#9733;</span>
                ##ENDIFticket.priority##
              </td>';
      } else {
         $blocks[] = '<td style="width: 150px;background-color: #eaeaea;">
              </td>
              <td style="width: 258px;background-color: #eaeaea;">
              </td>';
      }
      if ($options['location']) {
         $blocks[] = '<td style="width: 150px;background-color: #eaeaea;">
                <b>##lang.ticket.location##</b>
              </td>
              <td style="width: 258px;background-color: #eaeaea;">
                ##ticket.location##
              </td>';
      } else {
         $blocks[] = '<td style="width: 150px;background-color: #eaeaea;">
              </td>
              <td style="width: 258px;background-color: #eaeaea;">
              </td>';
      }
      $blocks[] = '
            </tr>
            <tr style="height: 8px;">
              <td colspan="4" style="background-color: #eaeaea;"></td>
            </tr>
             <tr>
               <td style="width: 150px;background-color: #eaeaea;">
                 <b>##lang.ticket.creationdate##</b>
               </td>
               <td style="background-color: #eaeaea;">
                 ##ticket.creationdate##
               </td>';
      if ($options['due_date']) {
         $blocks[] = '<td style="background-color: #eaeaea;">
               <b>##lang.ticket.duedate##</b>
            </td>
            <td style="background-color: #eaeaea;">
               ##ticket.duedate##
            </td>';
      } else {
         $blocks[] = '<td style="background-color: #eaeaea;"></td>
                 <td style="background-color: #eaeaea;"></td>';
      }
      $blocks[] = '    </tr>
            <tr style="height: 8px;">
              <td colspan="4" style="background-color: #eaeaea;"></td>
            </tr>';
      if ($options['title']) {
            $blocks[] = '<tr>
               <td style="width: 150px;background-color: #eaeaea;">
                 <b>##lang.ticket.title##</b>
               </td>
               <td colspan="3" style="width: 666px;background-color: #eaeaea;">
                 ##ticket.title##
               </td>
             </tr>';
      }
      if ($options['description']) {
         // we use ##lang.followup.description## because better translation than ##lang.ticket.description##
         $blocks[] = '
            <tr style="height: 140px;">
              <td style="width: 150px;vertical-align: top;background-color: #eaeaea;">
                <b>##lang.followup.description##</b>
              </td>
              <td colspan="3" style="vertical-align: top;background-color: #eaeaea;">
                 ##ticket.description##
              </td>
            </tr>';
      }
      if ($options['solution']) {
         $blocks[] = '
            <tr style="height: 140px;">
              <td style="width: 150px;vertical-align: top;background-color: #eaeaea;">
              ##IFticket.storestatus=5##
                <b>##lang.ticket.solution.description##</b>
              ##ENDIFticket.storestatus##
              </td>
              <td colspan="3" style="vertical-align: top;background-color: #eaeaea;">
              ##IFticket.storestatus=5##
                 ##ticket.solution.description##
              ##ENDIFticket.storestatus##
              </td>
            </tr>';
      }
      if ($options['associated_items']) {
         $options[] = '
            <tr>
              <td style="width: 150px;background-color: #eaeaea;">
                <b>##lang.ticket.item.name##</b>
              </td>
              <td style="width: 258px;background-color: #eaeaea;">
                ##FOREACHitems##
                  ##IFticket.itemtype##
                    ##ticket.itemtype## - ##ticket.item.name##
                    ##IFticket.item.model## ##lang.ticket.item.model## : ##ticket.item.model## ##ENDIFticket.item.model##
                    ##IFticket.item.serial## ##lang.ticket.item.serial## : ##ticket.item.serial## ##ENDIFticket.item.serial##
                    ##IFticket.item.otherserial## ##lang.ticket.item.otherserial## : ##ticket.item.otherserial## ##ENDIFticket.item.otherserial##
                  ##ENDIFticket.itemtype##
                ##ENDFOREACHitems##
              </td>
              <td colspan="2" style="width: 393px;background-color: #eaeaea;"></td>
            </tr>';
      }
      $blocks[] = '
          </table>
          <br/>
          ';
      if ($options['followups'] or $options['tasks']) {
         $size = 816;
         if ($options['followup_task_display'] == 'separate') {
            if ($options['followups'] and $options['tasks']) {
               $size = 408;
            }
            $blocks[] = '
            <table style="border-collapse: collapse;width: 786px;height: 120px;">
              <tr>
                <td style="height: 20px;"></td>
              </tr>
              <tr>
                <td style="width: 786px;">
                  <table style="width: 786px;">
                    <tr style="height: 30px;font-size: 16px;">';
            if ($options['followups']) {
               $blocks[] = '<th style="background-color: #5bc0de;color: #fff;width: '.$size.'px;">##lang.ticket.numberoffollowups##: ##ticket.numberoffollowups##</th>';
            }
            if ($options['tasks']) {
               $blocks[] = '<th style="background-color: #5bc0de;color: #fff;width: '.$size.'px;">##lang.ticket.numberoftasks##: ##ticket.numberoftasks##</th>';
            }
            $blocks[] = '
                    </tr>
                    <tr>
                      ';
            if ($options['followups']) {
               $blocks[] = '<td style="vertical-align: top;">
                        <table>
##FOREACHfollowups##
                           <tr>
                             <td style="background-color: #eaeaea;width: '.$size.'px;">
                               <table>
                                 <tr>
                                   <td colspan="2">';
               if ($options['followups_author']) {
                  $blocks[] = '<b>'.__('By').'</b> <i>##followup.author##</i> <b>le</b> <i>##followup.date##</i></td>';
               } else {
                  $blocks[] = '<b>Le</b> <i>##followup.date##</i></td>';
               }
               $blocks[] = '
                                 </tr>
                                 <tr>
                                   <td colspan="2" style="height: 8px;"></td>
                                 </tr>
                                 <tr>
                                   <td colspan="2">##followup.description##</td>
                                 </tr>
                                 <tr>
                                   <td colspan="2" style="height: 15px;"></td>
                                 </tr>
                               </table>
                             </td>
                           </tr>
                           <tr>
                             <td style="height: 15px;"></td>
                           </tr>

##ENDFOREACHfollowups##
                        </table>
                      </td>
                        ';
            }
            if ($options['tasks']) {
               $blocks[] = '
                      <td style="vertical-align: top;">
                        <table>
##FOREACHtasks##
                           <tr>
                             <td style="background-color: #eaeaea;width: '.$size.'px;">
                               <table>
                                 <tr>';
               if ($options['tasks_author']) {
                  $blocks[] = '<td colspan="2"><b>'.__('By').'</b> <i>##task.author##</i> <b>le</b> <i>##task.date##</i></td>';
               } else {
                  $blocks[] = '<td colspan="2"><b>Le</b> <i>##task.date##</i></td>';
               }
               $blocks[] = '
                                 </tr>';
               if ($options['tasks_time']) {
                  $blocks[] = '<tr>
                          <td><b>##lang.task.time##</b></td>
                          <td>##task.time##</td>
                        </tr>';
               } else {
                  $blocks[] = '<tr>
                          <td colspan="2"></td>
                        </tr>';
               }
               if ($options['tasks_category']) {
                  $blocks[] = '<tr>
                          <td><b>##lang.task.category##</b></td>
                          <td>##task.category##</td>
                        </tr>';
               } else {
                  $blocks[] = '<tr>
                          <td colspan="2"></td>
                        </tr>';
               }
               $blocks[] = '
                                 <tr>
                                   <td colspan="2" style="height: 8px;"></td>
                                 </tr>
                                 <tr>
                                   <td colspan="2">##task.description##</td>
                                 </tr>
                                 <tr>
                                   <td colspan="2" style="height: 15px;"></td>
                                 </tr>
                               </table>
                             </td>
                           </tr>
                           <tr>
                             <td style="height: 8px;"></td>
                           </tr>
##ENDFOREACHtasks##
                        </table>
                      </td>';
            }
            $blocks[] = '
                    </tr>
                  </table>
                </td>
              </tr>
            </table>';
         } else if ($options['followup_task_display'] == 'unified') {
            $blocks[] = '
            <table style="border-collapse: collapse;width: 786px;height: 120px;">
              <tr>
                <td style="height: 20px;"></td>
              </tr>
              <tr>
                <td style="width: 786px;">
                  <table style="width: 786px;">
                    <tr style="height: 30px;font-size: 16px;">';
            $blocks[] = '<th style="background-color: #5bc0de;color: #fff;width: '.$size.'px;">Activity, number of messages: ##ticket.numberofactivitymessages##</th>';
            $blocks[] = '
                    </tr>
                    <tr>
                      ';
            $blocks[] = '<td style="vertical-align: top;">
                        <table>
##FOREACHactivitymessages##
                           <tr>
                             <td style="width: '.$size.'px;">
                               <table style="background-color: #eaeaea;width: '.$size.'px;height: 90px;">
                                 <tr>
                                 <tr>
                                   <td rowspan="6" style="background-repeat: no-repeat;
                                   background-image: ##IFactivitymessage.type=followup##url('.$CFG_GLPI["url_base"].'/pics/timeline/followup.png)##ENDIFactivitymessage.type####IFactivitymessage.type=task##url('.$CFG_GLPI["url_base"].'/pics/timeline/task.png)##ENDIFactivitymessage.type##;
                                   background-color: ##IFactivitymessage.type=followup## #E0E0E0 ##ENDIFactivitymessage.type## ##IFactivitymessage.type=task## #FEDA90 ##ENDIFactivitymessage.type##;
                                   width: 80px;">
                                   </td>
                                   <td colspan="2">';
            if ($options['followups_author']) {
               $blocks[] = '<b>'.__('By').'</b> <i>##activitymessage.author##</i> <b>le</b> <i>##activitymessage.date##</i></td>';
            } else {
               $blocks[] = '<b>Le</b> <i>##activitymessage.date##</i></td>';
            }
            $blocks[] = '
                                 </tr>';
            if ($options['tasks_time']) {
               $blocks[] = '<tr>
                          <td style="width: 150px;">##IFtask.time##<b>##lang.task.time##</b>##ENDIFtask.time##</td>
                          <td>##IFtask.time## ##task.time## ##ENDIFtask.time##</td>
                        </tr>';
            }
            if ($options['tasks_category']) {
               $blocks[] = '<tr>
                          <td style="width: 150px;">##IFactivitymessage.category##<b>##lang.task.category##</b>##ENDIFactivitymessage.category##</td>
                          <td>##IFactivitymessage.category## ##activitymessage.category## ##ENDIFactivitymessage.category##</td>
                        </tr>';
            }
            $blocks[] = '
                                 <tr>
                                   <td colspan="2" style="height: 4px;"></td>
                                 </tr>
                                 <tr>
                                   <td colspan="2">##activitymessage.description##</td>
                                 </tr>
                                 <tr>
                                   <td colspan="2" style="height: 7px;"></td>
                                 </tr>
                               </table>
                             </td>
                           </tr>
                           <tr>
                             <td style="height: 15px;"></td>
                           </tr>
##ENDFOREACHactivitymessages##
                        </table>
                      </td>
                        ';
            $blocks[] = '
                    </tr>
                  </table>
                </td>
              </tr>
            </table>';
         }
      }
      if ($options['url_link']) {
         $blocks[] = '<table style="border-collapse: collapse;width: 786px;height: 100px;">
            <tr style="height: 30px;font-size: 16px;">
              <th colspan="4" style="background-color: #5bc0de;color: #fff;width: 786px;">Plus d informations sur ce ticket</th>
            </tr>
            <tr>
              <td colspan="4" style="width: 393px;background-color: #eaeaea;text-align: center;">
               <a href="##ticket.url##" target="_blank">Visualiser ce ticket dans GLPI</a>
              </td>
            </tr>
          </table>
          <br/>
          <br/>
        </td>
        <td style="vertical-align: top;width: 20px;"></td>
      </tr>
   </table>';

         if (!empty($options['footer_text'])) {
            $blocks[] = '<table style="border-collapse: collapse;width: 950px; border-bottom-left-radius: 6px;border-bottom-right-radius: 6px;background-color: #1B2F62;color: #ffffff;height: 80px;">
    <tr style="height: 25px">
      <td style="width:160px" rowspan="2">
      </td>
      <td style="width:778px;height: 30px;font-size: 14px;color: #ffffff;">
         <i>This email was generated by Glpi - Designed by David Durieux</i>
      </td>
      <td style="font-size: 12px;height: ">
      </td>
    </tr>
  </table>';
         }
      }
      $blocks[] = '</div>
</div>';

      return implode("\n", $blocks);
   }


   function generateNotification($id) {

      $nt = new NotificationTemplate();
      $ntt = new NotificationTemplateTranslation();

      $this->getFromDB($id);

      $events = [
          'new'               => 'd9534f', // red
          'update'            => 'f0ad4e', // orange/warning
          'solved'            => '5cb85c', // green/success
          'rejectsolution'    => 'd9534f',
          'validation'        => 'd9534f',
          'validation_answer' => '5bc0de',
          'add_followup'      => '5bc0de', // blue/info
          'update_followup'   => 'f0ad4e',
          'delete_followup'   => '000000',
          'add_task'          => '5bc0de',
          'update_task'       => 'f0ad4e',
          'delete_task'       => '000000',
          'closed'            => '5cb85c',
          'delete'            => '000000'
      ];

      $color = $events[$this->fields['event']];
      $opt_options = importArrayFromDB($this->fields['options']);
      $options = [];
      foreach ($opt_options as $name=>$data) {
         $options[str_replace("opt_", "", $name)] = $data;
      }

      $html = $this->notification_blue($this->fields['event'], $options);

      // search if notif exist
      $notiftpl = current($nt->find("`name`='".$this->fields['name']."'"));
      if (isset($notiftpl['id'])) {
         $nt_id = $notiftpl['id'];
      } else {
         $input = [
             'name' => $this->fields['name'],
             'itemtype' => 'Ticket'
         ];
         $nt_id = $nt->add($input);
      }
      if (!$nt_id) {
         return false;
      }
      // Prepare email notif
      $input = [
          'notificationtemplates_id' => $nt_id,
          'subject'      => $options['subject'],
          'content_text' => '',
          'content_html' => str_replace('[[replacebgcolor]]', $color, $html)
      ];
      $notiftpltrans = current($ntt->find("`notificationtemplates_id`='".$nt_id."'"));
      if (isset($notiftpltrans['id'])) {
         $input['id'] = $notiftpltrans['id'];
         $ntts_id = $ntt->update($input);
      } else {
         $ntts_id = $ntt->add($input);
      }
      if (!$ntts_id) {
         return false;
      }
      $input = [
          'id' => $id,
          'last_generation' => $_SESSION["glpi_currenttime"]
      ];
      if ($this->update($input)) {
         return true;
      } else {
         return false;
      }
   }


   static function getMenuContent() {

      if (!Session::haveRight('config', READ)) {
         return;
      }

      $menu = [];
      $menu['title'] = self::getMenuName();
      $menu['page']  = "/plugins/notifications/front/notification.php";

      $itemtypes = ['PluginNotificationsNotification' => 'notifications'];

      foreach ($itemtypes as $itemtype => $option) {
         $menu['options'][$option]['title']           = $itemtype::getTypeName(2);
         $menu['options'][$option]['page']            = $itemtype::getSearchURL(false);
         $menu['options'][$option]['links']['search'] = $itemtype::getSearchURL(false);
         if ($itemtype::canCreate()) {
            $menu['options'][$option]['links']['add'] = $itemtype::getFormURL(false);
         }

      }
      return $menu;
   }
}
