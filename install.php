<?php

include ("../../inc/includes.php");

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

$tmp_1 = array();

$tmp_1['header'] = '<div style="font-family: Helvetica;">
  <table style="border-collapse: collapse;width: 950px; border-top-left-radius: 6px;border-top-right-radius: 6px;background-color: #1B2F62;color: white;height: 80px;">
    <tr style="height: 25px">
      <td style="width:160px" rowspan="2">
        <img alt="GLPi" title="Glpi" width="100" height="55" src="https://raw.githubusercontent.com/glpi-project/glpi/master/pics/fd_logo.png"/>
      </td>
      <td style="width:400px;height: 30px;font-size: 24px;" rowspan="2">
        <b>##ticket.shortentity##</b>
      </td>
      <td style="font-size: 12px;height: ">
        ##lang.ticket.authors##:
      </td>
    </tr>
    <tr style="height: 55px">
      <td style="font-size: 18px;">
        ##ticket.authors##
      </td>
    </tr>
  </table>';

$tmp_1['event'] = '<table style="border-collapse: collapse;width: 950px;background-color: #1b2f62;">
    <tr style="height: 40px">
      <td style="width: 90px;background-color: #1B2F62;"></td>
      <td style="background-color: #[[replacebgcolor]];text-align: center;font-size: 18px;color: white;border-top-left-radius: 6px;">
        <b>##ticket.action##</b>
      </td>
    </tr>
  </table>';

$tmp_1['ticket_head'] = '<div style="background-color: #f8f7f3;width: 949px;border-right: 1px solid #ccc;border-collapse: collapse;">
    <table style="border-collapse: collapse;width: 950px;height: 100px;">
      <tr>
        <td style="width: 90px;background-color: #1B2F62;">
          <img src="https://raw.githubusercontent.com/ddurieux/glpi_notifications/master/pics/helpdesk.png" alt="helpdesk">
        </td>
        <td style="vertical-align: top;width: 20px;"></td>
        <td style="vertical-align: top;width: 816px;">';

$tmp_1['lastfollowup'] = '
##FOREACH LAST followups##
          <table style="border-collapse: collapse;width: 816px;height: 120px;">
            <tr>
              <td style="height: 15px;"></td>
            </tr>
            <tr style="height: 30px;font-size: 16px;">
              <th style="background-color: #5bc0de;color: #fff;width: 816px;">Voici le nouveau suivi</th>
            </tr>
            <tr>
              <td style="background-color: #eaeaea;">
                <table>
                  <tr>
                    <td colspan="2"><b>Par</b> <i>##followup.author##</i> <b>le</b> <i>##followup.date##</i></td>
                  </tr>
                  <tr>
                    <td style="height: 8px;" colspan="2"></td>
                  </tr>
                  <tr>
                    <td colspan="2">##followup.description##</td>
                  </tr>
                  <tr>
                    <td style="height: 15px;" colspan="2"></td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td style="height: 15px;"></td>
            </tr>
          </table>
##ENDFOREACHfollowups##';

$tmp_1['lasttask'] = '
##FOREACH LAST tasks##
          <table style="border-collapse: collapse;width: 816px;height: 120px;">
            <tr>
              <td style="height: 15px;"></td>
            </tr>
            <tr style="height: 30px;font-size: 16px;">
              <th style="background-color: #5bc0de;color: #fff;width: 816px;">Voici la nouvelle tâche</th>
            </tr>
            <tr>
              <td style="background-color: #eaeaea;">
                <table>
                  <tr>
                    <td colspan="2"><b>Par</b> <i>##task.author##</i> <b>le</b> <i>##task.date##</i></td>
                  </tr>
                  <tr>
                    <td><b>##lang.task.time##</b></td>
                    <td>##task.time##</td>
                  </tr>
                  <tr>
                    <td><b>##lang.task.category##</b></td>
                    <td>##task.category##</td>
                  </tr>
                  <tr>
                    <td style="height: 8px;" colspan="2"></td>
                  </tr>
                  <tr>
                    <td colspan="2">##task.description##</td>
                  </tr>
                  <tr>
                    <td style="height: 15px;" colspan="2"></td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td style="height: 15px;"></td>
            </tr>
          </table>
##ENDFOREACHtasks##';

$tmp_1['ticket_info'] = '
          <table style="border-collapse: collapse;width: 816px;height: 100px;">
            <tr style="height: 30px;font-size: 16px;">
              <th colspan="4" style="background-color: #5bc0de;color: #fff;width: 816px;">Informations du ticket</th>
            </tr>
            <tr style="height: 20px;">
              <td colspan="4" style="background-color: #eaeaea;"></td>
            </tr>
            <tr>
              <td style="width: 408px;background-color: #eaeaea;" colspan="2">
               <b>##lang.ticket.assigntousers##:</b> ##ticket.assigntousers##
              </td>
              <td style="width: 408px;background-color: #eaeaea;" colspan="2">
               <b>##lang.ticket.assigntogroups##:</b> ##ticket.assigntogroups##
              </td>
            </tr>
            <tr style="height: 20px;">
              <td colspan="4" style="background-color: #eaeaea;"></td>
            </tr>
            <tr>
              <td style="background-color: #eaeaea;" colspan="4">
               <table style="border-collapse: collapse;width: 816px;">
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
               </table>
              </td>
            </tr>
            <tr>
              <td style="width: 150px;background-color: #eaeaea;">
                <b>##lang.ticket.status##</b>
              </td>
              <td style="width: 258px;background-color: #eaeaea;">
                 ##ticket.status##
              </td>
              <td style="width: 150px;background-color: #eaeaea;">
                <b>##lang.ticket.category##</b>
              </td>
              <td style="width: 258px;background-color: #eaeaea;">
                ##ticket.category##
              </td>
            </tr>
            <tr>
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
              </td>
              <td style="width: 150px;background-color: #eaeaea;">
                <b>##lang.ticket.location##</b>
              </td>
              <td style="width: 258px;background-color: #eaeaea;">
                ##ticket.location##
              </td>
            </tr>
            <tr style="height: 8px;">
              <td colspan="4" style="background-color: #eaeaea;"></td>
            </tr>
             <tr>
               <td style="width: 150px;background-color: #eaeaea;">
                 <b>##lang.ticket.creationdate##</b>
               </td>
               <td style="background-color: #eaeaea;" colspan="3">
                 ##ticket.creationdate##
               </td>
            </tr>
            <tr style="height: 8px;">
              <td colspan="4" style="background-color: #eaeaea;"></td>
            </tr>
            <tr>
               <td style="width: 150px;background-color: #eaeaea;">
                 <b>##lang.ticket.title##</b>
               </td>
               <td style="width: 666px;background-color: #eaeaea;" colspan="3">
                 ##ticket.title##
               </td>
             </tr>
            <tr style="height: 140px;">
              <td style="width: 150px;vertical-align: top;background-color: #eaeaea;">
                <b>##lang.ticket.description##</b>
              </td>
              <td style="vertical-align: top;background-color: #eaeaea;" colspan="3">
                 ##ticket.description##
              </td>
            </tr>

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
              <td style="width: 408px;background-color: #eaeaea;" colspan="2"></td>
            </tr>
          </table>
          <br/>
          ';

$tmp_1['followups+tasks'] = '
          <table style="border-collapse: collapse;width: 816px;height: 120px;">
            <tr>
              <td style="height: 20px;"></td>
            </tr>
            <tr>
              <td style="width: 816px;">
                <table style="width: 816px;">
                  <tr style="height: 30px;font-size: 16px;">
                    <th style="background-color: #5bc0de;color: #fff;width: 408px;">##lang.ticket.numberoffollowups##: ##ticket.numberoffollowups##</th>
                    <th style="background-color: #5bc0de;color: #fff;width: 408px;">##lang.ticket.numberoftasks##: ##ticket.numberoftasks##</th>
                  </tr>
                  <tr>
                    <td>
                      <table>
##FOREACHfollowups##
                        <tr>
                          <td style="background-color: #eaeaea;width: 408px;">
                            <table>
                              <tr>
                                <td colspan="2"><b>Par</b> <i>##followup.author##</i> <b>le</b> <i>##followup.date##</i></td>
                              </tr>
                              <tr>
                                <td style="height: 8px;" colspan="2"></td>
                              </tr>
                              <tr>
                                <td colspan="2">##followup.description##</td>
                              </tr>
                              <tr>
                                <td style="height: 15px;" colspan="2"></td>
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
                    <td>
                      <table>
##FOREACHtasks##
                        <tr>
                          <td style="background-color: #eaeaea;width: 408px;">
                            <table>
                              <tr>
                                <td colspan="2"><b>Par</b> <i>##task.author##</i> <b>le</b> <i>##task.date##</i></td>
                              </tr>
                              <tr>
                                <td><b>##lang.task.time##</b></td>
                                <td>##task.time##</td>
                              </tr>
                              <tr>
                                <td><b>##lang.task.category##</b></td>
                                <td>##task.category##</td>
                              </tr>
                              <tr>
                                <td style="height: 8px;" colspan="2"></td>
                              </tr>
                              <tr>
                                <td colspan="2">##task.description##</td>
                              </tr>
                              <tr>
                                <td style="height: 15px;" colspan="2"></td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <td style="height: 15px;"></td>
                        </tr>
##ENDFOREACHtasks##
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
';

$tmp_1['glpi_link'] = '
          <table style="border-collapse: collapse;width: 816px;height: 120px;">
            <tr>
              <td style="text-align: center;">
               See this ticket directly in <a href="##ticket.url##" target="_blank">Glpi</a>
              </td>
            </tr>
          </table>
        </td>
        <td style="vertical-align: top;width: 20px;"></td>
      </tr>
    </table>';

// Add followups...

$tmp_1['footer'] = '  </div>
  <div style="background-color: #f8f8f8;width: 948px;border-left: 1px solid #ccc;border-right: 1px solid #ccc;border-bottom: 1px solid #ccc;border-bottom-left-radius: 6px;border-bottom-right-radius: 6px;border-collapse: collapse;">
    <br/>
    <hr style="width: 928px;display: block;height: 1px;border: 0;border-top: 1px solid #0e7099;"/>
    <div style="padding-left: 10px;display: block;font-size: 11px;color: #0e7099;height: 30px;">
      This email was generated by Glpi - Designed by David Durieux
    </div>
  </div>
</div>';

$nt = new NotificationTemplate();
$ntt = new NotificationTemplateTranslation();

foreach ($events as $event => $color) {

   // search if notif exist
   $notiftpl = current($nt->find("`name`='tpl_1_".$event."'"));
   if (isset($notiftpl['id'])) {
      $nt_id = $notiftpl['id'];
   } else {
      $input = [
          'name' => 'tpl_1_'.$event,
          'itemtype' => 'Ticket'
      ];
      $nt_id = $nt->add($input);
   }

   $html = $tmp_1['header'].$tmp_1['event'].$tmp_1['ticket_head'];

   // Manage to add last followup
   if (in_array($event, ['add_followup', 'update_followup'])) {
      $html .= $tmp_1['lastfollowup'];
   }

   // Manage to add last task
   if (in_array($event, ['add_task', 'update_task'])) {
      $html .= $tmp_1['lasttask'];
   }

   $html .= $tmp_1['ticket_info'];

   // manage to add followups and tasks
   if (in_array($event, ['new', 'rejectsolution', 'validation', 'add_followup',
       'update_followup', 'add_task', 'update_task'])) {
      $html .= $tmp_1['followups+tasks'];
   }

   $html .= $tmp_1['glpi_link'].$tmp_1['footer'];

   // Prepare email notif
   $input = [
       'notificationtemplates_id' => $nt_id,
       'subject'      => '##ticket.action## ##ticket.title##',
       'content_text' => '',
       'content_html' => str_replace('[[replacebgcolor]]', $color, $html)
   ];
   $notiftpltrans = current($ntt->find("`notificationtemplates_id`='".$nt_id."'"));
   if (isset($notiftpltrans['id'])) {
      $input['id'] = $notiftpltrans['id'];
      $ntt->update($input);
   } else {
      $ntt->add($input);
   }

}
