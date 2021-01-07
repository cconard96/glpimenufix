<?php
/*
 -------------------------------------------------------------------------
 GLPI Menu Fix Plugin
 Copyright (C) 2020-2021 by Curtis Conard
 https://github.com/cconard96/glpimenufix
 -------------------------------------------------------------------------
 LICENSE
 This file is part of GLPI Menu Fix Plugin.
 GLPI Menu Fix Plugin is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.
 GLPI Menu Fix Plugin is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.
 You should have received a copy of the GNU General Public License
 along with GLPI Menu Fix Plugin. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */

function plugin_menufix_install()
{
   return true;
}

function plugin_menufix_uninstall()
{
   return true;
}

function plugin_menufix_redefine_menus($menu)
{
   if (empty($menu)) {
      return $menu;
   }
   // Revert Assets default menu option
   if (strpos($menu['assets']['default'], 'dashboard_assets') !== false) {
      $menu['assets']['default'] = Computer::getSearchURL(false);
      // Add Assistance dashboard link only if the user has rights
      if (\Glpi\Dashboard\Dashboard::canView()) {
         $menu['assets']['content'][strtolower(\Glpi\Dashboard\Dashboard::class)] = [
            'title' => 'Dashboard',
            'icon' => 'fas fa-tachometer-alt',
            'page' => '/front/dashboard_assets.php',
            'links' => ['search' => '/front/dashboard_assets.php']
         ];
      }
   }

   if (strpos($menu['helpdesk']['default'], 'dashboard_helpdesk') !== false) {
      // Revert Assistance default menu option
      $menu['helpdesk']['default'] = Ticket::getSearchURL(false);
      // Add Assistance dashboard link only if the user has rights
      if (\Glpi\Dashboard\Dashboard::canView()) {
         $menu['helpdesk']['content'][strtolower(\Glpi\Dashboard\Dashboard::class)] = [
            'title' => 'Dashboard',
            'icon' => 'fas fa-tachometer-alt',
            'page' => '/front/dashboard_helpdesk.php',
            'links' => ['search' => '/front/dashboard_helpdesk.php']
         ];
      }
   }
   return $menu;
}