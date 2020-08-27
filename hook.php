<?php

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
   // Revert Assets default menu option
   $menu['assets']['default'] = Computer::getSearchURL(false);
   // Add Assistance dashboard link only if the user has rights
   if (\Glpi\Dashboard\Dashboard::canView()) {
      $menu['assets']['content'][strtolower(\Glpi\Dashboard\Dashboard::class)] = [
         'title'  => 'Dashboard',
         'icon'   => 'fas fa-tachometer-alt',
         'page'   => '/front/dashboard_assets.php',
         'links'   => ['search' => '/front/dashboard_assets.php']
      ];
   }
   // Revert Assistance default menu option
   $menu['helpdesk']['default'] = Ticket::getSearchURL(false);
   // Add Assistance dashboard link only if the user has rights
   if (\Glpi\Dashboard\Dashboard::canView()) {
      $menu['helpdesk']['content'][strtolower(\Glpi\Dashboard\Dashboard::class)] = [
         'title'  => 'Dashboard',
         'icon'   => 'fas fa-tachometer-alt',
         'page'   => '/front/dashboard_helpdesk.php',
         'links'   => ['search' => '/front/dashboard_helpdesk.php']
      ];
   }
   return $menu;
}