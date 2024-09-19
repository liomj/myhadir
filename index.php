<?php
//  Author: Lionel Michael Jominin
//  URL: https://jknsabah.moh.gov.my/hbeaufort/
//  E-Mail: lionel.m@moh.gov.my


include("../../mainfile.php");
include(XOOPS_ROOT_PATH."/header.php");


$meta_keywords = "sistem,myHadir";
$meta_description = "Sistem Pengurusan Kehadiran Program";
$pagetitle = "Sistem myHadir";

if(isset($xoTheme) && is_object($xoTheme)) {
    $xoTheme->addMeta( 'meta', 'keywords', $meta_keywords);
    $xoTheme->addMeta( 'meta', 'description', $meta_description);
} else {    // Compatibility for old Xoops versions
    $xoopsTpl->assign('xoops_meta_keywords', $meta_keywords);
    $xoopsTpl->assign('xoops_meta_description', $meta_description);
}

$xoopsTpl->assign('xoops_pagetitle', $pagetitle);
//$xoopsUser->isAdmin() or redirect_header('index.php', 3, _NOPERM);
//this will only work if your theme is using this smarty variables
$xoopsTpl->assign( 'xoops_showlblock', 1); //set to 0 to hide left blocks
$xoopsTpl->assign( 'xoops_showrblock', 1); //set to 0 to hide right blocks
$xoopsTpl->assign( 'xoops_showcblock', 1); //set to 0 to hide center blocks
?>


<link rel="stylesheet" type="text/css" href="assets/css/datatables.min.css"/>

<script src="assets/js/datatables.min.js"></script>



<script type="text/javascript">
  var jQuery =$.noConflict(true);
  </script> 
<script>
jQuery(document).ready(function() {
    jQuery('#standard').DataTable({"language": {
       url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/ms.json',
    },});
} );
</script>


<div class="container">
<div class="row p-4">

<?php
$getkonfigurasi = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_konfigurasiumum")."");
$rowz = $GLOBALS['xoopsDB']->fetchArray($getkonfigurasi);
$namaagensi=$rowz['namaagensi'];
$namasingkatan=$rowz['namasingkatan'];

echo "<p class='alert alert-primary text-dark'><i class='fa fa-cube'></i> 
Sistem myHadir adalah sebuah Sistem Pengesahan Kehadiran Program Hospital Beaufort </p>";
 
 //redirect_header("programsaya.php"); 
?>

</div>
</div>

<?php
include(XOOPS_ROOT_PATH."/footer.php");
?>