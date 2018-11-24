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

Html::header('Notifications', $_SERVER["PHP_SELF"], "config",
             "PluginNotificationsNotification", "notifications");


Search::show('PluginNotificationsNotification');

Html::footer();
