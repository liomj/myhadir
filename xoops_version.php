<?php

if (!defined('XOOPS_ROOT_PATH')) {
	die('XOOPS root path not defined');
}
$modversion['dirname'] = basename(dirname(__FILE__));
$modversion['name'] = 'Sistem myHadir';
$modversion['version'] = '0.1';
$modversion['description'] = '';
$modversion['author'] = "Lionel Michael Jominin";
$modversion['credits'] = "https://jknsabah.moh.gov.my/hbeaufort/";
$modversion['help'] = "";
$modversion['license'] = "GPL see LICENSE";
$modversion['official'] = 0;
$modversion['image'] = "assets/images/logo.png";
$modversion['onInstall']= "include/oninstall.php";
$modversion['onUninstall']= "include/onuninstall.php";

// Mysql file
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
$modversion['tables'][1] = "myhadir_aksesprogram";
$modversion['tables'][2] = "myhadir_kategoripenerima";
$modversion['tables'][3] = "myhadir_konfigurasiumum";
$modversion['tables'][4] = "myhadir_log";
$modversion['tables'][5] = "myhadir_lokasi";
$modversion['tables'][6] = "myhadir_kehadiran";
$modversion['tables'][7] = "myhadir_penganjur";
$modversion['tables'][8] = "myhadir_program";
$modversion['tables'][9] = "myhadir_aksesadmin";
$modversion['tables'][10] = "myhadir_unit";

// Blocks
$modversion['blocks'][1]['file'] = "menu.php";
$modversion['blocks'][1]['name'] = "Menu myHadir";
$modversion['blocks'][1]['description'] = "";
$modversion['blocks'][1]['show_func'] = "myhadir_menu_show";
$modversion['blocks'][1]['template'] = 'menu_block.html';

// Menu
$modversion['hasMain'] = 1;
global $xoopsUser;
if (!empty($xoopsUser)) {
	//Insert menu here
}

global $xoopsModule;
if (is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $modversion['dirname']) {
    global $xoopsModuleConfig, $xoopsUser;
    $isAdmin = false;
    if (!empty($xoopsUser)) {
        $isAdmin = ($xoopsUser->isAdmin($xoopsModule->getVar('mid')));
    }
}

global $xoopsUser;
if ( is_object($xoopsUser) )
{
    if ( $xoopsUser->isAdmin() )
    {
		//Insert menu here
   }
}

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "index.php";
//$modversion['adminmenu'] = "admin/menu.php";
	
?>
