<?php

define('PLUGIN_MENUFIX_VERSION', '2.1.0');
define('PLUGIN_MENUFIX_MIN_GLPI', '9.5.0');
define('PLUGIN_MENUFIX_MAX_GLPI', '9.6.0');

function plugin_init_menufix() {
   global $PLUGIN_HOOKS;

   $PLUGIN_HOOKS['csrf_compliant']['menufix'] = true;

   $_SESSION['glpimenu']['assets']['default'] = Computer::getSearchURL();
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
