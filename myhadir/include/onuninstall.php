<?php
function xoops_module_uninstall_myhadir()
{
//XOOPS GroupID Sistem myHadir
$GLOBALS['xoopsDB']->queryF("DELETE from ".$GLOBALS['xoopsDB']->prefix("groups")." WHERE groupid='41' OR groupid='42'");
$GLOBALS['xoopsDB']->queryF("DELETE from ".$GLOBALS['xoopsDB']->prefix("groups_users_link")." WHERE groupid='41' OR groupid='42'");

//Menu Sistem myHadir
$GLOBALS['xoopsDB']->queryF("DELETE from ".$GLOBALS['xoopsDB']->prefix("mymenus_menus")." WHERE id='904'");
$GLOBALS['xoopsDB']->queryF("DELETE from ".$GLOBALS['xoopsDB']->prefix("mymenus_menu")." WHERE mid='904'");

}
