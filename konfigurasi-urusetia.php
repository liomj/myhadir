<?php
//  Author: Lionel Michael Jominin
//  URL: https://jknsabah.moh.gov.my/hbeaufort/
//  E-Mail: lionel.m@moh.gov.my


include("../../mainfile.php");
include(XOOPS_ROOT_PATH."/header.php");

$meta_keywords = "Sistem myHadir";
$meta_description = "Sistem myHadir";
$pagetitle = "Konfigurasi Urusetia Program - Sistem myHadir";

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
$xoopsUser->isAdmin() or redirect_header('index.php', 3, _NOPERM);

  function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>

<link rel="stylesheet" type="text/css" href="assets/css/datatables.min.css"/>

<script src="assets/js/datatables.min.js"></script>


	<link href='assets/css/select2.min.css' rel='stylesheet' />
<link href='assets/css/select2-bootstrap-5-theme.min.css' rel='stylesheet' />
<script src='assets/js/select2.min.js'></script>

<script type="text/javascript">
  var jQuery =$.noConflict(true);
  </script> 
<script>
jQuery(document).ready(function() {
    jQuery('#standard').DataTable({
		 "ordering": false,
		"language": {
       url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/ms.json',
    },});
} );
</script>

<script type="text/javascript">
  var jQuery =$.noConflict(true);
  </script> 
<script type="text/javascript">
jQuery(document).ready(function() {
  jQuery(".uid").select2({theme: "bootstrap-5"});
  jQuery(".idprogram").select2({theme: "bootstrap-5"});
});
</script>


<script type="text/javascript">
jQuery(document).ready(function() {
 jQuery('.namamultiple').select2({theme: "bootstrap-5"});
});
</script>

 <style>.error{color:red;}
 .alert-info {
 color: #000000;}
 
 </style>




    <div class='container-fluid'>
    <div class='row p-4'>

<a name='permission'></a> &nbsp; <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?add_permission=1#permission"><button type="button" class="btn btn-dark btn-sm"><i class='fa fa-save'></i> Tambah Akses</button></a><br /><br />
<?php
echo "<div class='alert alert-primary'>";
echo "Sila pilih Urusetia Program yang dipilih";
echo "</div>";


$resulty = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_konfigurasiumum")."");
$rowy = $GLOBALS['xoopsDB']->fetchArray($resulty);
$groupid=$rowy['urusetiagroupid'];

?>



<?php  

global $xoopsUser; 

//get current user id  
$loggedinuid = is_object($xoopsUser) ? $xoopsUser->getVar('uid') : 0;  

 //if the Delete link is clicked
if (isset($_GET['del_permission']))  {

$GLOBALS['xoopsDB']->queryF("DELETE from ".$GLOBALS['xoopsDB']->prefix("myhadir_aksesprogram")." WHERE idprogram='" . $_GET['del_permission'] . "' AND uid='" . $_GET['uid'] . "'");
$GLOBALS['xoopsDB']->queryF("DELETE from ".$GLOBALS['xoopsDB']->prefix("groups_users_link")." WHERE groupid='" . $groupid . "' AND uid='" . $_GET['uid'] . "'");
$GLOBALS['xoopsDB']->queryF("INSERT INTO ".$GLOBALS['xoopsDB']->prefix("myhadir_log")." (idprogram,tindakan,tarikh,uid) VALUES  
('" . $_GET['del_permission'] . "','Hapus Urusetia Program',CURRENT_TIMESTAMP,'$loggedinuid')");

redirect_header("konfigurasi-urusetia.php", 2, 'Konfigurasi akses berjaya dihapuskan'); 
    exit(); 
	}
	
//if posted using add
if (isset($_POST['tambah_permission']))  {
	




   //not found
   
   $idprogram=$_POST['idprogram'];
   $getidprogram= $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_program")." WHERE idprogram='$idprogram'"); 
$row = $GLOBALS['xoopsDB']->fetchArray($getidprogram);
 
   foreach($_POST['uid'] as $key => $value):

    $uidx=test_input($_POST['uid'][$key]);
   $sql = "SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_aksesprogram")." WHERE uid='$uidx' AND idprogram='" . test_input($_POST['idprogram'])  . "'";
$result = $GLOBALS['xoopsDB']->query($sql);

 $numrows = $GLOBALS['xoopsDB']->getRowsNum($result);

  if($numrows >0){
   //found
 redirect_header("konfigurasi-urusetia.php", 2, 'Operation aborted. Please double check, user already have permission. Please try again');   
   
}else{
 
$GLOBALS['xoopsDB']->query("INSERT INTO ".$GLOBALS['xoopsDB']->prefix("myhadir_aksesprogram")." (uid,idprogram) VALUES  ('" . test_input($_POST['uid'][$key])  . "','" . test_input($_POST['idprogram'])  . "')");
$GLOBALS['xoopsDB']->query("INSERT INTO ".$GLOBALS['xoopsDB']->prefix("groups_users_link")." (groupid,uid) VALUES  ('".$groupid."','" . test_input($_POST['uid'][$key])  . "')");
}	
endforeach;
$idprogram=$_POST['idprogram'];
$GLOBALS['xoopsDB']->query("INSERT INTO ".$GLOBALS['xoopsDB']->prefix("myhadir_log")." (idprogram,tindakan,tarikh,uid) VALUES  
('$idprogram','Tambah Urusetia Program',CURRENT_TIMESTAMP,'$loggedinuid')");

redirect_header("konfigurasi-urusetia.php", 2, 'Permission Successfully added'); 
    exit(); 

	
	


}




// check if the Add link is clicked
if (isset($_GET['add_permission']))  {

//close the php to display the html form
echo "<div class='alert alert-info m-2'>";
?><form id='set1' role='form' method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"><?php

$result= $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("users")." WHERE level > 0 ORDER BY name ASC"); 

	echo "<div class='mb-3'>
    <label class='form-label' for='uid'>  Nama Staf :</label>
  			<select name='uid[]' id='uid' class='namamultiple uid form-control' multiple='multiple'>";
			
while($row = $GLOBALS['xoopsDB']->fetchArray($result))
{

$userid=$row['uid'];
$name=$row['name'];


      echo "<option value='$userid'>$name</option>";

 }      
 
 echo "</select> </div>";

 
 echo "<div class='mb-3'>
   <label class='form-label' for='idprogram'>  Nama Program:</label>
<select name='idprogram' id='idprogram' class='idprogram form-control'>
     <option value=''>Pilih Nama Program</option>";

  
 $result = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_program")." ORDER BY idprogram DESC");
 
 while($row = $GLOBALS['xoopsDB']->fetchArray($result))
{
$namaprogram=$row['namaprogram'];
$idprogram=$row['idprogram'];
  $tarikhmula=$row['tarikhmula'];
				 $tarikhtamat=$row['tarikhtamat'];
				 
				 	$tarikh_mula=date('d F Y',strtotime($tarikhmula));
$tarikh_tamat=date('d F Y',strtotime($tarikhtamat));	
$translated_tarikhmula = str_ireplace($monthsDaysEn,$monthsDaysMy,$tarikh_mula);
$translated_tarikhtamat= str_ireplace($monthsDaysEn,$monthsDaysMy,$tarikh_tamat);

if($tarikhmula==$tarikhtamat)
echo "<option value='$idprogram'>$namaprogram :: $translated_tarikhmula</option>";
else
echo "<option value='$idprogram'>$namaprogram :: $translated_tarikhmula -  $translated_tarikhtamat</option>";
}


echo "</select></div>";


echo "<button type='submit' name='tambah_permission' class='btn btn-danger btn-sm m-2'><i class='fa fa-save'></i> Tambah</button>";
	 
echo "</form>";
echo "</div>";
}  //closing the if statement



//check if posted using the update link
if (isset($_POST['kemaskini_permission']))  {

   $idprogram=$_POST['idprogram'];
   $getidprogram= $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_aksesprogram")." WHERE idprogram='$idprogram'"); 
$row = $GLOBALS['xoopsDB']->fetchArray($getidprogram);
   $uid=$row['uid'];
   
   
 $sql = "SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_aksesprogram")." WHERE uid='" . test_input($_POST['uid'])  . "' AND idprogram='" . test_input($_POST['idprogram'])  . "'";
$result = $GLOBALS['xoopsDB']->query($sql);

 $numrows = $GLOBALS['xoopsDB']->getRowsNum($result);

if($numrows >0){
   //found
 redirect_header("konfigurasi-urusetia.php", 2, 'User already have permision');   
   
}else{  
   

//run the query to update the data

$GLOBALS['xoopsDB']->query("UPDATE ".$GLOBALS['xoopsDB']->prefix("myhadir_aksesprogram")." SET uid='" . test_input($_POST['uid']) . "',idprogram='" . test_input($_POST['idprogram']) . "' WHERE id=" . $_POST['id']); 
$GLOBALS['xoopsDB']->query("UPDATE ".$GLOBALS['xoopsDB']->prefix("groups_users_link")." SET uid='" . test_input($_POST['uid']) . "' WHERE uid='" . $_POST['useridasal'] ."' AND groupid='" . $groupid . "'"); 
$idprogram=$_POST['idprogram'];
$GLOBALS['xoopsDB']->query("INSERT INTO ".$GLOBALS['xoopsDB']->prefix("myhadir_log")." (idprogram,tindakan,tarikh,uid) VALUES  
('$idprogram','Kemaskini Urusetia Program',CURRENT_TIMESTAMP,'$loggedinuid')");
redirect_header("konfigurasi-urusetia.php", 2, 'Konfigurasi akses berjaya dikemaskini'); 
    exit(); 
}
}
//check if the Edit link is clicked
if (isset($_GET['edit_permission']))  {


//run the query to get the data

  $result = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_aksesprogram")." where idprogram='" .  $_GET['edit_permission'] . "' AND uid='" .  $_GET['uid'] . "'");


// check if records were returned
if ($GLOBALS['xoopsDB']->getRowsNum($result) > 0) {

//display the form with the selected data
while($row = $GLOBALS['xoopsDB']->fetchArray($result))  
  { //do this while there's a record in the $result array
$senaraiuid=$row['uid'];
$senaraiidprogram=$row['idprogram'];


echo "<div class='alert alert-info m-2'>";
?><form id='set1' role='form' method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"><?php

$result= $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("users")." WHERE level > 0 ORDER BY name ASC"); 
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

   echo "<div class='mb-3'>
   <label class='form-label' for='idprogram'>  Pilih Program :</label>
<select name='idprogram' id='idprogram' class='idprogram form-control'>
     <option value=''>Pilih Program</option>";

  
 $result = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_program")." ORDER BY idprogram DESC");
 
 while($row = $GLOBALS['xoopsDB']->fetchArray($result))
{
$namaprogram_db=$row['namaprogram'];
$idprogram_db=$row['idprogram'];

$tarikhmula_db=$row['tarikhmula'];
$tarikhtamat_db=$row['tarikhtamat'];
				 
				 	$tarikh_mula=date('d F Y',strtotime($tarikhmula_db));
$tarikh_tamat=date('d F Y',strtotime($tarikhtamat_db));	
$translated_tarikhmula = str_ireplace($monthsDaysEn,$monthsDaysMy,$tarikh_mula);
$translated_tarikhtamat= str_ireplace($monthsDaysEn,$monthsDaysMy,$tarikh_tamat);


if($idprogram_db == $senaraiidprogram)
{
if($tarikhmula==$tarikhtamat)
echo "<option value='$idprogram_db' selected>$namaprogram_db :: $translated_tarikhmula</option>";
else
echo "<option value='$idprogram' selected>$namaprogram_db :: $translated_tarikhmula -  $translated_tarikhtamat</option>";
}











}


echo "</select></div>";
$idprogram == $senaraiidprogram;






echo "<input type='hidden' name='useridasal' value='$userid'>";	
echo "<button type='submit' name='kemaskini_permission' class='btn btn-danger btn-sm m-2'><i class='fa fa-save'></i> Kemaskini </button><br />";
	 
echo "</form>";
echo "</div>";




}  //close the while for every data


// once processing is complete
// free result set



} else {
	echo "<div class='alert alert-info m-2'>Tiada data</div>";

}


}




    
 //$result = $GLOBALS['xoopsDB']->query("SELECT u.id_unit,u.susunan_unit, u.nama_unit, s.id_unit,s.statistik_id,s.nama_statistik FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_unit")." AS u LEFT JOIN ".$GLOBALS['xoopsDB']->prefix("myhadir_senaraistatistik")." AS s ON u.id_unit = s.id_unit ORDER by u.susunan_unit ASC");
  $result = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_program")." ORDER BY idprogram DESC");
 echo "<table id='standard' class='table table-striped'><thead><tr>";
echo "<th>Program</th>";
echo "<th>Tarikh</th>";
echo "<th>Lokasi</th>";
echo "<th>Penganjur</th>";
echo "<th>Urusetia</th>";
echo "</tr></thead><tbody>";
$bil=1;
 while($row=$GLOBALS['xoopsDB']->fetchArray($result)) 
{
$idprogram=$row['idprogram'];

$namaprogram=$row['namaprogram'];
		  $tarikhmula=$row['tarikhmula'];
				 $tarikhtamat=$row['tarikhtamat'];
$idpenganjur=$row['idpenganjur'];

$idlokasi=$row['idlokasi'];
echo "<tr>";
echo "<td>$namaprogram<br>"; 

$checkpeserta = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_nama")." WHERE idprogram='$idprogram'");
$jumlahpeserta=$GLOBALS['xoopsDB']->getRowsNum($checkpeserta);
echo "<small><strong>Jumlah Peserta: </strong>$jumlahpeserta</small>";

echo "</td>";


echo "<td>";
$tarikh_mula=date('d F Y',strtotime($tarikhmula));
$tarikh_tamat=date('d F Y',strtotime($tarikhtamat));	
$translated_tarikhmula = str_ireplace($monthsDaysEn,$monthsDaysMy,$tarikh_mula);
$translated_tarikhtamat= str_ireplace($monthsDaysEn,$monthsDaysMy,$tarikh_tamat);

if($tarikhmula==$tarikhtamat)

echo "$translated_tarikhmula ";	
else
echo "$translated_tarikhmula - $translated_tarikhtamat ";
			
echo "</td>";
$checklokasi = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_lokasi")." WHERE idlokasi='$idlokasi'");
$rowlokasi=$GLOBALS['xoopsDB']->fetchArray($checklokasi);
$lokasi=$rowlokasi['lokasi'];

$checkpenganjur = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_penganjur")." WHERE idpenganjur='$idpenganjur'");
$rowpenganjur=$GLOBALS['xoopsDB']->fetchArray($checkpenganjur);
$penganjur=$rowpenganjur['penganjur'];

echo "<td>";	
echo "$lokasi";
echo "</td>";

echo "<td>";	
echo "$penganjur";
echo "</td>";
echo "<td>";
 $result7 = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_aksesprogram")." WHERE idprogram=$idprogram");
 while($row=$GLOBALS['xoopsDB']->fetchArray($result7)) 
 {
$uid=$row['uid'];

$recordid=$row['id'];
$result3 = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("users")." WHERE level > 0 AND uid='$uid' ORDER BY name ASC");
$row = $GLOBALS['xoopsDB']->fetchArray($result3);
$namastaf=$row['name'];
echo "$namastaf";
echo "<a href=\"" . htmlspecialchars("$_SERVER[PHP_SELF]") . "?del_permission=".$idprogram."&uid=".$uid."\"onclick=
      \"return confirm('Adakah anda pasti untuk hapus?')\"><button type='button' class='btn btn-danger btn-sm pull-right'> <i class='fa fa-trash' title='Hapus'></i></button></a> ";	
echo "<a href='" . htmlspecialchars("$_SERVER[PHP_SELF]") . "?edit_permission=".$idprogram."&uid=".$uid."'><button type='button' class='btn btn-success btn-sm pull-right'> <i class='fa fa-edit' title='Kemaskini'></i></button></a> "; 
echo "<hr />";
 }	  
echo "</td>";

echo "</tr>";


}



echo "</tbody></table>";
?>



</div></div>



<?php
include(XOOPS_ROOT_PATH."/footer.php");
?>