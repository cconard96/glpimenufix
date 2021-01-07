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

define('PLUGIN_MENUFIX_VERSION', '1.0.1');
define('PLUGIN_MENUFIX_MIN_GLPI', '9.5.0');
define('PLUGIN_MENUFIX_MAX_GLPI', '9.6.0');

function plugin_init_menufix() {
   global $PLUGIN_HOOKS;

   $PLUGIN_HOOKS['csrf_compliant']['menufix'] = true;
   $PLUGIN_HOOKS['redefine_menus']['menufix'] = 'plugin_menufix_redefine_menus';
}

function plugin_version_menufix() {

   return [
      'name'    => 'Default Menu Link Fix',
      'version' => PLUGIN_MENUFIX_VERSION,
      'author'  => 'Curtis Conard',
      'license' => 'GPLv2',
      'homepage'=>'https://github.com/cconard96/glpimenufix',
      'requirements'   => [
         'glpi'   => [
            'min' => PLUGIN_MENUFIX_MIN_GLPI,
            'max' => PLUGIN_MENUFIX_MAX_GLPI
         ]
      ]
   ];
}

function plugin_menufix_check_prerequisites() {
   if (!method_exists('Plugin', 'checkGlpiVersion')) {
      $version = preg_replace('/^((\d+\.?)+).*$/', '$1', GLPI_VERSION);
      $matchMinGlpiReq = version_compare($version, PLUGIN_MENUFIX_MIN_GLPI, '>=');
      $matchMaxGlpiReq = version_compare($version, PLUGIN_MENUFIX_MAX_GLPI, '<');
      if (!$matchMinGlpiReq || !$matchMaxGlpiReq) {
         echo vsprintf(
            'This plugin requires GLPI >= %1$s and < %2$s.',
            [
               PLUGIN_MENUFIX_MIN_GLPI,
               PLUGIN_MENUFIX_MAX_GLPI,
            ]
         );
         return false;
      }
   }
   return true;
}

function plugin_menufix_check_config()
{
   return true;
}
