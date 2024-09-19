<?php
//  Author: Lionel Michael Jominin
//  E-Mail: lionel.m@moh.gov.my


include("../../mainfile.php");
include(XOOPS_ROOT_PATH."/header.php");

$meta_keywords = "Konfigurasi Admin Sistem myHadir";
$meta_description = "Konfigurasi Admin Sistem myHadir";
$pagetitle = "Konfigurasi Admin Sistem myHadir";

if(isset($xoTheme) && is_object($xoTheme)) {
    $xoTheme->addMeta( 'meta', 'keywords', $meta_keywords);
    $xoTheme->addMeta( 'meta', 'description', $meta_description);
} else {    // Compatibility for old Xoops versions
    $xoopsTpl->assign('xoops_meta_keywords', $meta_keywords);
    $xoopsTpl->assign('xoops_meta_description', $meta_description);
}

$xoopsTpl->assign('xoops_pagetitle', $pagetitle);
$xoopsUser->isAdmin() or redirect_header('index.php', 3, _NOPERM);
//this will only work if your theme is using this smarty variables
$xoopsTpl->assign( 'xoops_showlblock', 1); //set to 0 to hide left blocks
$xoopsTpl->assign( 'xoops_showrblock', 1); //set to 0 to hide right blocks
$xoopsTpl->assign( 'xoops_showcblock', 1); //set to 0 to hide center blocks

  function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>




<link rel="stylesheet" type="text/css" href="assets/css/datatables.min.css"/>
<script src="assets/js/jquery-1.9.1.js"></script>
<script src="assets/js/datatables.min.js"></script>


	<link href='assets/css/select2.min.css' rel='stylesheet' />
<link href='assets/css/select2-bootstrap-5-theme.min.css' rel='stylesheet' />
<script src='assets/js/select2.min.js'></script>
<script type="text/javascript">
  var jQuery_1_9_1 =$.noConflict(true);
  </script> 
<script type="text/javascript">
jQuery_1_9_1(document).ready(function() {
  jQuery_1_9_1(".uid").select2({theme: "bootstrap-5"});
});
</script>

<script>
jQuery_1_9_1(document).ready(function() {
    jQuery_1_9_1('#standard').DataTable( {
	 "displayLength": 20,
	 	"language": {
       url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/ms.json',
    }
	}
	
	
	)
} );
</script>

<noscript>
    <style type="text/css">
        .body {display:none;}
    </style>
</noscript>

    <div class='container-fluid'>
    <div class='row p-4'>




<?php 

?>

<a name='permission'></a> &nbsp; <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?add_permission=1#permission"><button type="button" class="btn btn-dark btn-sm pull-right">Tambah Akses</button></a><br /><br />
<?php
echo "<div class='container-fluid'>";
echo "<div class='alert alert-primary'>";
echo "<i class='fa fa-cube'></i> Sila pilih Staf yang bertugas sebagai <b>Admin</b> Sistem myHadir";
echo "</div>";echo "</div>";


$result = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_konfigurasiumum")."");
$row = $GLOBALS['xoopsDB']->fetchArray($result);
$groupid=$row['admingroupid'];


?>



<?php  
 //if the Delete link is clicked
if (isset($_GET['del_permission']))  {

$GLOBALS['xoopsDB']->queryF("DELETE from ".$GLOBALS['xoopsDB']->prefix("myhadir_aksesadmin")." WHERE id='" . $_GET['del_permission'] . "'");

$GLOBALS['xoopsDB']->queryF("DELETE from ".$GLOBALS['xoopsDB']->prefix("groups_users_link")." WHERE groupid='" . $groupid . "' AND uid='" . $_GET['uid'] . "'");
redirect_header("konfigurasi-admin.php", 2, 'Akses berjaya dihapuskan'); 
    exit(); 
	}
	
//if posted using add
if (isset($_POST['tambah_permission']))  {
	
$sql = "SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_aksesadmin")." WHERE uid='" . test_input(trim($_POST['uid']))  . "'";
$result = $GLOBALS['xoopsDB']->query($sql);

 $numrows = $GLOBALS['xoopsDB']->getRowsNum($result);


if($numrows >0){
   //found
 redirect_header("konfigurasiadmin.php", 2, 'User already have permision to view all report');   
   
}else{
   //not found
 
$GLOBALS['xoopsDB']->query("INSERT INTO ".$GLOBALS['xoopsDB']->prefix("myhadir_aksesadmin")." (uid) VALUES  ('" . test_input(trim($_POST['uid']))  . "')");

$GLOBALS['xoopsDB']->query("INSERT INTO ".$GLOBALS['xoopsDB']->prefix("groups_users_link")." (groupid,uid) VALUES  ('".$groupid."','" . test_input(trim($_POST['uid']))  . "')");
redirect_header("konfigurasi-admin.php", 2, 'Akses berjaya ditambah'); 
    exit(); 

	
}	
	
	



}




// check if the Add link is clicked
if (isset($_GET['add_permission']))  {

//close the php to display the html form
echo "<div class='alert alert-info m-2'>";
?><form id='set1' role='form' method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"><?php

$result= $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("users")." WHERE level > 0 ORDER BY name ASC") or die(mysql_error()); 

	echo "<div class='mb-3'>
    <label class='form-label' for='uid'>  Nama Staf :</label>
  			<select name='uid' id='uid' class='uid form-control'>
			<option value=''>Pilih Staf</option>";
while($row = $GLOBALS['xoopsDB']->fetchArray($result))
{

$userid=$row['uid'];
$name=$row['name'];


      echo "<option value='$userid'>$name</option>";

 }      
 
 echo "</select> </div>";

echo "<button type='submit' name='tambah_permission' class='btn btn-danger btn-sm m-2'><i class='fa fa-save'></i> Tambah</button>";
	 
echo "</form>";
echo "</div>";
}  //closing the if statement



//check if posted using the update link
if (isset($_POST['kemaskini_permission']))  {
 $sql = "SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_aksesadmin")." WHERE uid='" . test_input(trim($_POST['uid']))  . "'";
$result = $GLOBALS['xoopsDB']->query($sql);

 $numrows = $GLOBALS['xoopsDB']->getRowsNum($result);
 if($numrows >0){
   //found
 redirect_header("konfigurasi-admin.php", 2, 'User already have permision to view all unit');   
   
}else{ 
//run the query to update the data

$GLOBALS['xoopsDB']->query("UPDATE ".$GLOBALS['xoopsDB']->prefix("myhadir_aksesadmin")." SET uid='" . test_input(trim($_POST['uid'])) . "' where id=" . $_POST['id']); 
$GLOBALS['xoopsDB']->query("UPDATE ".$GLOBALS['xoopsDB']->prefix("groups_users_link")." SET uid='" . $GLOBALS['xoopsDB']->test_input(trim($_POST['uid'])) . "' WHERE uid='" . $_POST['useridasal'] ."' AND groupid='" . $groupid . "'"); 
redirect_header("konfigurasi-admin.php", 2, 'Akses berjaya dikemaskini'); 
    exit(); 
}}

//check if the Edit link is clicked
if (isset($_GET['edit_permission']))  {


//run the query to get the data

  $result = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_aksesadmin")." where id='" .  $_GET['edit_permission'] . "'" );


// check if records were returned
if ($GLOBALS['xoopsDB']->getRowsNum($result) > 0) {

//display the form with the selected data
while($row = $GLOBALS['xoopsDB']->fetchArray($result))  
  { //do this while there's a record in the $result array
$senaraiuid=$row['uid'];



echo "<div class='alert alert-info m-2'>";
?><form id='set1' role='form' method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"><?php

$result= $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("users")." WHERE level > 0 ORDER BY name ASC") or die(mysql_error()); 
echo "<input type=\"hidden\" name=\"id\" value= " . $row['id']. ">";

	echo "<div class='mb-3'>
    <label class='form-label' for='uid'>  Nama Staf :</label>
  			<select name='uid' id='uid' class='uid form-control'>
			<option value=''>Pilih Staf</option>";
while($row = $GLOBALS['xoopsDB']->fetchArray($result))
{

$userid=$row['uid'];
$name=$row['name'];


if($userid == $senaraiuid) {
echo "<option value='$userid' selected>$name</option>";
}
else
{

echo "<option value='$userid'>$name</option>";
}
}    
 
 echo "</select> </div>";
$userid = $senaraiuid;

echo "<input type='hidden' name='useridasal' value='$userid'>";	
echo "<button type='submit' name='kemaskini_permission' class='btn btn-danger btn-sm m-2'><i class='fa fa-save'></i> Kemaskini </button>";
	 
echo "</form>";
echo "</div>";


}  //close the while for every data


} else {
	echo "<div class='alert alert-info m-2'>Tiada data</div>";

}


}





echo "<br /><br /><table id='standard' class='table table-striped table-hover'>
<thead><tr>
<th>Akses Pengguna</th>
<th>Tindakan</th>
</tr></thead>
  <tbody>";

  
  $result2 = $GLOBALS['xoopsDB']->query("SELECT s.*, u.* FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_aksesadmin")." AS s LEFT JOIN ".$GLOBALS['xoopsDB']->prefix("users")." AS u ON s.uid=u.uid ORDER BY u.name ASC");  

while($row = $GLOBALS['xoopsDB']->fetchArray($result2))
{

$uid=$row['uid'];
$recordid=$row['id'];
$result = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("users")." WHERE level > 0 AND uid='$uid'");
$row = $GLOBALS['xoopsDB']->fetchArray($result);
$namastaf=$row['name'];


echo "<td>";
echo $namastaf;
echo "</td>";
echo "<td>";
echo "<a href='" . htmlspecialchars("$_SERVER[PHP_SELF]") . "?edit_permission=".$recordid."&uid=".$uid."'><button type='button' class='btn btn-success btn-sm'> <i class='fa fa-edit' title='Kemaskini'></i></button></a>"; 
echo "<a href=\"" . htmlspecialchars("$_SERVER[PHP_SELF]") . "?del_permission=".$recordid."&uid=".$uid."\"onclick=
      \"return confirm('Adakah anda pasti untuk hapus?')\"><button type='button' class='btn btn-danger btn-sm m-2'> <i class='fa fa-trash' title='Hapus'></i></button></a>";	
echo "</td></tr>";



}

echo "</tbody></table>";
 
 
 echo "</div></div>";
?>







<?php
include(XOOPS_ROOT_PATH."/footer.php");
?>