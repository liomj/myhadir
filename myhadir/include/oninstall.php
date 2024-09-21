<?php
function xoops_module_install_myhadir()
{

$GLOBALS['xoopsDB']->query("INSERT INTO ".$GLOBALS['xoopsDB']->prefix("groups")." (groupid, name, description, group_type) VALUES  
(41, 'myHadir - Admin Sistem', '', ''),(42, 'myHadir - Urusetia Program', '', '')");

$GLOBALS['xoopsDB']->query("INSERT INTO ".$GLOBALS['xoopsDB']->prefix("mymenus_menus")." (`id`, `title`) VALUES  
(904, 'Menu Sistem myHadir')");

$GLOBALS['xoopsDB']->query("INSERT INTO ".$GLOBALS['xoopsDB']->prefix("mymenus_menu")." (`id`, `pid`, `mid`, `title`, `alt_title`, `visible`, `link`, `weight`, `target`, `groups`, `hooks`, `image`, `css`) VALUES  

(903, 0, 904, 'Senarai Program', '', 1, 'modules/myhadir/program.php', 4, '_self', 'a:2:{i:0;s:1:\"1\";i:1;s:1:\"2\";}', 'a:0:{}', 'fa fa-coffee', ''),
(901, 0, 904, 'Konfigurasi Sistem', '', 1, '', 6, '_self', 'a:2:{i:0;s:1:\"1\";i:1;s:2:\"41\";}', 'a:0:{}', 'fa fa-cog', ''),
(928, 0, 904, 'Muka Depan', '', 1, '', 2, '_self', 'a:2:{i:0;s:1:\"1\";i:1;s:1:\"2\";}', 'a:0:{}', 'fa fa-home', ''),
(927, 901, 904, 'Program', '', 1, 'modules/myhadir/konfigurasi-program.php', 4, '_self', 'a:2:{i:0;s:1:\"1\";i:1;s:2:\"41\";}', 'a:0:{}', '', ''),
(925, 901, 904, 'Urusetia Program', '', 1, 'modules/myhadir/konfigurasi-urusetia.php', 3, '_self', 'a:2:{i:0;s:1:\"1\";i:1;s:2:\"41\";}', 'a:0:{}', '', ''),
(924, 905, 904, 'Urusetia Program', '', 1, 'modules/myhadir/urusetia-program.php', 9, '_self', 'a:1:{i:0;s:2:\"17\";}', 'a:0:{}', '', ''),
(922, 0, 904, 'Sistem myHadir', 'Header', 1, 'modules/myhadir/index.php', 1, '_self', 'a:2:{i:0;s:1:\"1\";i:1;s:1:\"2\";}', 'a:0:{}', '', ''),
(921, 901, 904, 'Lokasi', '', 1, 'modules/myhadir/konfigurasi-lokasi.php', 5, '_self', 'a:2:{i:0;s:1:\"1\";i:1;s:2:\"41\";}', 'a:0:{}', '', ''),
(920, 901, 904, 'Penganjur', '', 1, 'modules/myhadir/konfigurasi-penganjur.php', 8, '_self', 'a:2:{i:0;s:1:\"1\";i:1;s:2:\"41\";}', 'a:0:{}', '', ''),
(919, 0, 904, 'Audit Trail', '', 1, 'modules/myhadir/log.php', 13, '_self', 'a:2:{i:0;s:1:\"1\";i:1;s:2:\"41\";}', 'a:0:{}', 'fa fa-history', ''),
(916, 901, 904, 'Umum', '', 1, 'modules/myhadir/konfigurasi-umum.php', 1, '_self', 'a:2:{i:0;s:1:\"1\";i:1;s:2:\"41\";}', 'a:0:{}', '', ''),
(915, 0, 904, 'Urusetia Program', '', 1, 'modules/myhadir/urusetia-program.php', 5, '_self', 'a:1:{i:0;s:2:\"42\";}', 'a:0:{}', '', ''),
(8105, 901, 904, 'Organisasi', '', 1, 'modules/myhadir/konfigurasi-organisasi.php', 7, '_self', 'a:2:{i:0;s:1:\"1\";i:1;s:2:\"41\";}', 'a:0:{}', '', ''),
(912, 904, 904, 'Program', '', 1, 'modules/myhadir/getsijil.php', 16, '_self', 'a:2:{i:0;s:1:\"1\";i:1;s:1:\"2\";}', 'a:0:{}', '', ''),
(913, 905, 904, 'Urusetia C&P', '', 1, 'modules/myhadir/urusetia-cp.php', 14, '_self', 'a:1:{i:0;s:2:\"32\";}', 'a:0:{}', '', ''),
(911, 904, 904, 'C & P', '', 1, 'modules/myhadir/getsijilcp.php', 17, '_self', 'a:2:{i:0;s:1:\"1\";i:1;s:1:\"2\";}', 'a:0:{}', '', ''),
(902, 0, 904, 'Program Saya', '', 1, 'modules/myhadir/programsaya.php', 3, '_self', 'a:2:{i:0;s:1:\"1\";i:1;s:1:\"2\";}', 'a:0:{}', 'fa fa-certificate', ''),
(900, 901, 904, 'Admin Sistem', '', 1, 'modules/myhadir/konfigurasi-admin.php', 2, '_self', 'a:2:{i:0;s:1:\"1\";i:1;s:2:\"41\";}', 'a:0:{}', '', ''),
(996, 901, 904, 'Unit', '', 1, 'modules/myhadir/konfigurasi-unit.php', 6, '_self', 'a:2:{i:0;s:1:\"1\";i:1;s:2:\"41\";}', 'a:0:{}', '', ''),
(933, 932, 904, 'Program', '', 1, 'modules/myhadir/laporan-program.php', 19, '_self', 'a:2:{i:0;s:1:\"2\";i:1;s:1:\"3\";}', 'a:0:{}', '', '')


");


}
