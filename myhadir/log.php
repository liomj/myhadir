<?php
//  Author: Lionel Michael Jominin
//  URL: https://jknsabah.moh.gov.my/hbeaufort/
//  E-Mail: lionel.m@moh.gov.my

include("../../mainfile.php");
include(XOOPS_ROOT_PATH."/header.php");


$meta_keywords = "Sistem myHadir";
$meta_description = "Sistem myHadir";
$pagetitle = "Audit Trail - Sistem myHadir";

if(isset($xoTheme) && is_object($xoTheme)) {
    $xoTheme->addMeta( 'meta', 'keywords', $meta_keywords);
    $xoTheme->addMeta( 'meta', 'description', $meta_description);
} else {    // Compatibility for old Xoops versions
    $xoopsTpl->assign('xoops_meta_keywords', $meta_keywords);
    $xoopsTpl->assign('xoops_meta_description', $meta_description);
}

$xoopsTpl->assign('xoops_pagetitle', $pagetitle);

//this will only work if your theme is using this smarty variables
$xoopsTpl->assign( 'xoops_showlblock', 0); //set to 0 to hide left blocks
$xoopsTpl->assign( 'xoops_showrblock', 0); //set to 0 to hide right blocks
$xoopsTpl->assign( 'xoops_showcblock', 1); //set to 0 to hide center blocks
//$xoopsUser->isAdmin() or redirect_header('index.php', 3, _NOPERM);
global $xoopsUser; 
//get current user id  
$loggedinuid = is_object($xoopsUser) ? $xoopsUser->getVar('uid') : 0;  
?>

<link rel="stylesheet" type="text/css" href="assets/js/dataTables.css" />

<script src="assets/js/datatables.js"> </script>

<script type="text/javascript">
  var jQuery =$.noConflict(true);
  </script> 
<script>
jQuery(document).ready(function() {
    jQuery('#log').DataTable( {
		"displayLength": 20,
		"ordering":false;
			"language": {
       url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/ms.json',
    }
    } );
} );
</script>



<div class="container-fluid">
<div class="row p-4">


<?php

if (isset($_GET['del_alllog']))  {

$GLOBALS['xoopsDB']->queryF("DELETE from ".$GLOBALS['xoopsDB']->prefix("myhadir_log")."");
$GLOBALS['xoopsDB']->queryF("INSERT INTO ".$GLOBALS['xoopsDB']->prefix("myhadir_log")." (idprogram,tindakan,tarikh,uid) VALUES  
('0','Hapus Semua Log',CURRENT_TIMESTAMP,'$loggedinuid')");
redirect_header(htmlspecialchars($_SERVER["PHP_SELF"]), 2, 'Rekod Berjaya Dihapuskan'); 
   exit(); 
	}

?>

	
<?php 
	echo "<a href=\"" . htmlspecialchars("$_SERVER[PHP_SELF]") . "?del_alllog=".$row['id']."\"onclick=
      \"return confirm('Adakah anda pasti untuk hapus? Semua log akan dihapuskan')\"><button type='button' class='btn btn-danger btn-sm m-2'> <i class='fa fa-trash' title='Hapus'></i> Hapus Log</button></a> ";	
?>

<table id="log" class="table table-striped table-bordered" cellspacing="0">

    <thead>
        <tr>
       
			<th>Tarikh</th>
			<th>Tindakan</th>
			<th>Nama Staf</th>
        </tr>
    </thead>
	    <tfoot>
        <tr>
           
			<th>Tarikh</th>
			<th>Tindakan</th>
			<th>Nama Staf</th>
			
        </tr>
    </tfoot>
    <tbody>
	
	<?php
	$result= $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_log")." ORDER BY id DESC"); 
	

	
	
		while($row = $GLOBALS['xoopsDB']->fetchArray($result))
{
        echo "<tr>";
	
	$tarikh=$row['tarikh'];
	$idprogram=$row['idprogram'];
	$tindakan=$row['tindakan'];
	$uid=$row['uid'];
	$jenis=$row['jenis'];
    $newDate = date("d M Y D h:i a", strtotime($tarikh));
	
		echo "<td>$newDate</td>";
	
if ($jenis==1 OR $jenis==0) 
{	
			$check= $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_program")." WHERE idprogram='$idprogram'"); 
if (!$check) { 
    trigger_error($GLOBALS['xoopsDB']->error()); 
}
$row5 = $GLOBALS['xoopsDB']->fetchArray($check);
$namaprogram=$row5['namaprogram'];
}
elseif($jenis==2) {
			$check= $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_cp")." WHERE idcp='$idprogram'"); 
if (!$check) { 
    trigger_error($GLOBALS['xoopsDB']->error()); 
}
$row5 = $GLOBALS['xoopsDB']->fetchArray($check);
$namaprogram=$row5['tempoh'];	
	
}
		
		echo "<td>";

		echo "$tindakan&nbsp;";
if ($jenis==1 OR $jenis==0) 
{
echo "$namaprogram";
}
elseif($jenis==2)	
{
echo "$namaprogram";
}
echo "</td>";
	
			
		
	
		
		$checkname= $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("users")." WHERE uid='$uid'"); 
		if (!$checkname) { 
    trigger_error($GLOBALS['xoopsDB']->error()); 
}
		$row = $GLOBALS['xoopsDB']->fetchArray($checkname);
		$name=$row['name'];
		echo "<td>$name</td>";

        echo "</tr>";
}		
		
		
     ?>
    </tbody>
</table>

</div></div>
</div></div>

<br />
<?php  
 
 

 
?>

<?php
include(XOOPS_ROOT_PATH."/footer.php");
?>