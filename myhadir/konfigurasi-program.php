<?php
//  Author: Lionel Michael Jominin
//  URL: https://jknsabah.moh.gov.my/hbeaufort/
//  E-Mail: lionel.m@moh.gov.my


include("../../mainfile.php");
include(XOOPS_ROOT_PATH."/header.php");


$meta_keywords = "sistem,myHadir";
$meta_description = "Sistem Pengurusan Kehadiran Program";
$pagetitle = "Konfigurasi Program - Sistem myHadir";

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
	<link href='assets/css/select2.min.css' rel='stylesheet' />
<link href='assets/css/select2-bootstrap-5-theme.min.css' rel='stylesheet' />
<script src='assets/js/select2.min.js'></script>



<script type="text/javascript">
  var jQuery =$.noConflict(true);
  </script> 

<script>
jQuery(document).ready(function() {
    jQuery('#standard5').DataTable({"language": {
       url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/ms.json',
    },
	 "displayLength": 10,
	 "ordering": false,
	});
} );
</script>


<script type="text/javascript">
jQuery(document).ready(function() {
  jQuery(".uid").select2({theme: "bootstrap-5"});
});
</script>



<script type="text/javascript">
jQuery(document).ready(function() {
  jQuery(".idlokasi").select2({theme: "bootstrap-5"});
   jQuery(".idpenganjur").select2({theme: "bootstrap-5"});
});
</script>

<script type="text/javascript">
jQuery(document).ready(function() {
 jQuery('.namamultiple').select2({theme: "bootstrap-5"});
});
</script>



<?php
global $xoopsUser;  
$myuid = $xoopsUser->getVar('uid');

$sql = "SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_aksesadmin")." WHERE uid='$myuid'";
$result = $GLOBALS['xoopsDB']->query($sql);

while($row = $GLOBALS['xoopsDB']->fetchArray($result))
{
$uid=$row['uid'];
}
//1 : Web admin
//2 : Registered User
//3 : Visitor
//4 : Custom Group
	
 $numrows = $GLOBALS['xoopsDB']->getRowsNum($result);
//$in_group = is_object($xoopsUser) && in_array(2, $xoopsUser->getGroups()); 

if($numrows > 0){
	
	?>


   <div class='container-fluid'>
    <div class='row p-4'>

<div class='p-2'>  <a class="btn btn-dark btn-sm" role="button" href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?add_program=1#program"><i class='fa fa-save'></i> Tambah Rekod Program</a></div>

<?php  
  function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


$getkonfigurasi = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_konfigurasiumum")."");
$rowz = $GLOBALS['xoopsDB']->fetchArray($getkonfigurasi);
$namaagensi=$rowz['namaagensi'];
$namasingkatan=$rowz['namasingkatan'];
$groupid=$rowz['urusetiagroupid'];


global $xoopsUser; 

//get current user id  
$loggedinuid = is_object($xoopsUser) ? $xoopsUser->getVar('uid') : 0;  

 //if the Delete link is clicked
if (isset($_GET['del_program']))  {

$GLOBALS['xoopsDB']->queryF("DELETE from ".$GLOBALS['xoopsDB']->prefix("myhadir_program")." WHERE idprogram='" . $_GET['del_program'] . "'");
$GLOBALS['xoopsDB']->queryF("DELETE from ".$GLOBALS['xoopsDB']->prefix("myhadir_kehadiran")." WHERE idprogram='" . $_GET['del_program'] . "'");
$GLOBALS['xoopsDB']->queryF("DELETE from ".$GLOBALS['xoopsDB']->prefix("myhadir_aksesprogram")." WHERE idprogram='" . $_GET['del_program'] . "'");
$GLOBALS['xoopsDB']->queryF("INSERT INTO ".$GLOBALS['xoopsDB']->prefix("myhadir_log")." (idprogram,tindakan,tarikh,uid) VALUES  
('" . $_GET['del_program'] . "','Hapus Program',CURRENT_TIMESTAMP,'$loggedinuid')");
redirect_header("konfigurasi-program.php", 2, 'Rekod Program Berjaya Dihapuskan'); 
    exit(); 
	}
	
//if posted using klon
if (isset($_POST['klon_program']))  {

$GLOBALS['xoopsDB']->query("INSERT INTO ".$GLOBALS['xoopsDB']->prefix("myhadir_program")." (
namaprogram,tarikhmula,tarikhtamat,idlokasi,idpenganjur) VALUES  
('" . $GLOBALS['xoopsDB']->escape($_POST['namaprogram'])  . "',
'" . test_input($_POST['tarikhmula'])  . "',
'" . test_input($_POST['tarikhtamat'])  . "',
'" . test_input($_POST['idlokasi'])  . "',
'" . test_input($_POST['idpenganjur'])  . "')");

$lastid = $GLOBALS['xoopsDB']->getInsertId();


$idprogram=$lastid;
   $getidprogram= $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_program")." WHERE idprogram='$idprogram'"); 
$row = $GLOBALS['xoopsDB']->fetchArray($getidprogram);
 
   foreach($_POST['uid'] as $key => $value):

    $uidx=test_input($_POST['uid'][$key]);
   $sql = "SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_aksesprogram")." WHERE uid='$uidx' AND idprogram='$idprogram'";
$result = $GLOBALS['xoopsDB']->query($sql);

 $numrows = $GLOBALS['xoopsDB']->getRowsNum($result);

  if($numrows >0){
   //found
 redirect_header("konfigurasi-program.php", 2, 'Operation aborted. Please double check, user already have permission. Please try again');   
   
}else{
 $newurusetiaid=test_input($_POST['uid'][$key]);
 $checkurusetia=$GLOBALS['xoopsDB']->query("SELECT * 
FROM ".$GLOBALS['xoopsDB']->prefix("groups_users_link")." WHERE uid='$newurusetiaid' AND groupid='$groupid'");
   	
$memangurusetia = $GLOBALS['xoopsDB']->getRowsNum($checkurusetia);
  
$GLOBALS['xoopsDB']->query("INSERT INTO ".$GLOBALS['xoopsDB']->prefix("myhadir_aksesprogram")." (uid,idprogram) VALUES  ('" . test_input($_POST['uid'][$key])  . "','$idprogram')");
if ($memangurusetia=='0')
 {$GLOBALS['xoopsDB']->query("INSERT INTO ".$GLOBALS['xoopsDB']->prefix("groups_users_link")." (groupid,uid) VALUES  ('".$groupid."','" . test_input($_POST['uid'][$key])  . "')");
 }

}	
endforeach;

$GLOBALS['xoopsDB']->query("INSERT INTO ".$GLOBALS['xoopsDB']->prefix("myhadir_log")." (idprogram,tindakan,tarikh,uid) VALUES  
('$lastid','Tambah Program',CURRENT_TIMESTAMP,'$loggedinuid')");


redirect_header("konfigurasi-program.php", 2, 'Rekod Program Berjaya Ditambah'); 
    exit(); 


}


// check if the Add link is clicked
if (isset($_GET['clone_program']))  {



//close the php to display the html form
//run the query to get the data

$result = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_program")." where idprogram='" .  $_GET['clone_program'] . "'" );


// check if records were returned
if ($GLOBALS['xoopsDB']->getRowsNum($result) > 0) {

//display the form with the selected data
while($row = $GLOBALS['xoopsDB']->fetchArray($result))  {
	
$namaprogram=$row['namaprogram'];	
$idprogram=$row['idprogram'];
$tahunprogram= date('Y', strtotime($tarikhmula));
$tarikhmula=$row['tarikhmula'];
$tarikhtamat=$row['tarikhtamat'];
$idlokasi=$row['idlokasi'];
$idpenganjur=$row['idpenganjur'];

//check urusetia
 
 $resultx2 = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_aksesprogram")." WHERE idprogram='$idprogram'");
while($rowx=$GLOBALS['xoopsDB']->fetchArray($resultx2)) 
{
$urusetia_id[]=$rowx['uid'];
$allurusetia_id=implode(",",$urusetia_id);
}
//endcheck urusetia				   
				   
?><form id='set1' role='form' method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"><?php
 echo "<div class='mb-3'>";
echo "<label class='form-label' for='namaprogram'> <strong>Nama Program :</strong></label>
<input class='form-control' type=\"text\" name=\"namaprogram\" value='$namaprogram Copy' placeholder='Masukkan Nama Program'/>";
echo "<span class='badge bg-danger'>Sila Tambah "; 
echo htmlspecialchars('<br />');
echo " selepas Nama Program </span>";
echo "</div>";

 echo "<div class='mb-3'>";
echo "<label for='tarikhmula'> <strong>Tarikh Mula :</strong></label>
<input class='form-control' type='date' name='tarikhmula' min='01/01/2022' max='31/12/2050' value='$tarikhmula' required>";
echo "</div>";

 echo "<div class='mb-3'>";
echo "<label for='tarikhtamat'> <strong>Tarikh Tamat :</strong></label>
<input class='form-control' type='date' name='tarikhtamat' min='01/01/2022' max='31/12/2050' value='$tarikhtamat' required>";
echo "</div>";	


echo "<div class='mb-3'>
    <label class='form-label' for='idlokasi'> <strong>Lokasi :</strong></label>";
echo "<select name='idlokasi' id='lokasi' class='idlokasi form-control'>
      <option value=''>Lokasi</option>";
	  
   
 $resultx = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_lokasi")." ORDER BY lokasi ASC");
 
 while($row2=$GLOBALS['xoopsDB']->fetchArray($resultx)) 
{
$idlokasidb=$row2['idlokasi'];	
$lokasidb=$row2['lokasi'];

if($idlokasidb == $idlokasi) {
echo "<option value='$idlokasidb' selected>$lokasidb</option>";	
}
else
{
echo "<option value='$idlokasidb'>$lokasidb</option>";
}
}

echo "</select></div>";

echo "<div class='mb-3'>
    <label class='form-label' for='idpenganjur'> <strong>Penganjur :</strong></label>";
echo "<select name='idpenganjur' id='penganjur' class='idpenganjur form-control'>
      <option value=''>Penganjur</option>";
	  
   
 $resultx = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_penganjur")." ORDER BY penganjur ASC");
 
 while($row2=$GLOBALS['xoopsDB']->fetchArray($resultx)) 
{
$idpenganjurdb=$row2['idpenganjur'];	
$penganjurdb=$row2['penganjur'];

if($idpenganjurdb == $idpenganjur) {
echo "<option value='$idpenganjurdb' selected>$penganjurdb</option>";	
}
else
{
echo "<option value='$idpenganjurdb'>$penganjurdb</option>";
}
}

echo "</select></div>";


$result= $GLOBALS['xoopsDB']->query("SELECT users.uid,users.name,akses.uid,users.level
FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_aksesprogram")." AS akses INNER JOIN ".$GLOBALS['xoopsDB']->prefix("users")." as users ON akses.uid=users.uid AND idprogram='$idprogram'"); 

//echo $allurusetia_id;
	echo "<div class='mb-3'>
    <label class='form-label' for='uid'>  <strong>Urusetia Program :</strong></label>";
	
	
echo "<select name='uid[]' id='uid' class='namamultiple uid form-control' multiple='multiple'>";
			
while($row = $GLOBALS['xoopsDB']->fetchArray($result))
{
$userid_db=$row['uid'];
$name_db=$row['name'];

echo "<option value='$userid_db' selected>$name_db</option>";
 }   
 $resultz= $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("users")." WHERE level > 0 AND uid NOT IN ($allurusetia_id) ORDER BY name ASC"); 
while($rowz = $GLOBALS['xoopsDB']->fetchArray($resultz))
{
	$uid=$rowz['uid'];
$name=$rowz['name'];
 echo "<option value='$uid'>$name</option>";
}
 echo "</select> </div>";

echo "<button type='submit' name='klon_program' class='btn btn-danger btn-sm m-2'>Klon Program</button>";
	 
echo "</form>";
}
}
}  //closing the if statement



	
	
	
//if posted using add
if (isset($_POST['tambah_program']))  {


$GLOBALS['xoopsDB']->query("INSERT INTO ".$GLOBALS['xoopsDB']->prefix("myhadir_program")." (
namaprogram,tarikhmula,tarikhtamat,idlokasi,idpenganjur) VALUES  
('" . $GLOBALS['xoopsDB']->escape($_POST['namaprogram'])  . "',
'" . test_input($_POST['tarikhmula'])  . "',
'" . test_input($_POST['tarikhtamat'])  . "',
'" . test_input($_POST['idlokasi'])  . "',
'" . test_input($_POST['idpenganjur'])  . "')");

$lastid = $GLOBALS['xoopsDB']->getInsertId();


$idprogram=$lastid;
   $getidprogram= $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_program")." WHERE idprogram='$idprogram'"); 
$row = $GLOBALS['xoopsDB']->fetchArray($getidprogram);
 
   foreach($_POST['uid'] as $key => $value):

    $uidx=test_input($_POST['uid'][$key]);
   $sql = "SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_aksesprogram")." WHERE uid='$uidx' AND idprogram='$idprogram'";
$result = $GLOBALS['xoopsDB']->query($sql);

 $numrows = $GLOBALS['xoopsDB']->getRowsNum($result);

  if($numrows >0){
   //found
 redirect_header("konfigurasi-program.php", 2, 'Operation aborted. Please double check, user already have permission. Please try again');   
   
}else{
	 $newurusetiaid=test_input($_POST['uid'][$key]);
 $checkurusetia=$GLOBALS['xoopsDB']->query("SELECT * 
FROM ".$GLOBALS['xoopsDB']->prefix("groups_users_link")." WHERE uid='$newurusetiaid' AND groupid='$groupid'");
   	
$memangurusetia = $GLOBALS['xoopsDB']->getRowsNum($checkurusetia);
 	
 
$GLOBALS['xoopsDB']->query("INSERT INTO ".$GLOBALS['xoopsDB']->prefix("myhadir_aksesprogram")." (uid,idprogram) VALUES  ('" . test_input($_POST['uid'][$key])  . "','$idprogram')");
 if ($memangurusetia=='0')
 {$GLOBALS['xoopsDB']->query("INSERT INTO ".$GLOBALS['xoopsDB']->prefix("groups_users_link")." (groupid,uid) VALUES  ('".$groupid."','" . test_input($_POST['uid'][$key])  . "')");
}}	
endforeach;
$idprogram=$_POST['idprogram'];
$GLOBALS['xoopsDB']->query("INSERT INTO ".$GLOBALS['xoopsDB']->prefix("myhadir_log")." (idprogram,tindakan,tarikh,uid) VALUES  
('$lastid','Tambah Program',CURRENT_TIMESTAMP,'$loggedinuid')");



//redirect_header("konfigurasi-program.php", 2, 'Rekod Program Berjaya Ditambah'); 
exit(); 


}




// check if the Add link is clicked
if (isset($_GET['add_program']))  {

//close the php to display the html form

?><form id='set1' role='form' method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"><?php
 echo "<div class='mb-3'>";
echo "<label class='form-label' for='namaprogram'> <strong>Nama Program :</strong></label>
<input class='form-control' type=\"text\" name=\"namaprogram\" placeholder='Masukkan Nama Program'/>";
echo "<span class='badge bg-danger'>Sila Tambah "; 
echo htmlspecialchars('<br />');
echo " selepas Nama Program </span>";
echo "</div>";

 echo "<div class='mb-3'>";
echo "<label for='tarikhmula'> <strong>Tarikh Mula :</strong></label>
<input class='form-control' type='date' name='tarikhmula' min='01/01/2022' max='31/12/2050' placeholder='Masukkan Tarikh Mula Program' required>";
echo "</div>";

 echo "<div class='mb-3'>";
echo "<label for='tarikhtamat'> <strong>Tarikh Tamat :</strong></label>
<input class='form-control' type='date' name='tarikhtamat' min='01/01/2022' max='31/12/2050' placeholder='Masukkan Tarikh Tamat Program' required>";
echo "</div>";	

echo "<div class='mb-3'>
    <label class='form-label' for='idlokasi'> <strong><b>Lokasi</b>:</strong></label>";
							echo "<div class='mb-3'>
							<select name='idlokasi' id='idlokasi' class='idlokasi form-select' required>
								<option value=''><b>Lokasi</b></option>";
									
										$result6=$GLOBALS['xoopsDB']->query("SELECT * from ".$GLOBALS['xoopsDB']->prefix("myhadir_lokasi")." ORDER BY lokasi ASC");
										
									
										while ($row6 = $GLOBALS['xoopsDB']->fetchArray($result6))
										{
											echo "<option value=".$row6['idlokasi'].">".$row6['lokasi']."</option>";
										}
                                                                                
                                                                                                                                             
							echo "</select>
                              </div>";      
							  
							  
echo "<div class='mb-3'>
    <label class='form-label' for='penganjur'> <strong><b>Penganjur</b>:</strong></label>";
							echo "<div class='mb-3'>
							<select name='idpenganjur' id='idpenganjur' class='idpenganjur form-select' required>
								<option value=''><b>Penganjur</b></option>";
									
										$result6=$GLOBALS['xoopsDB']->query("SELECT * from ".$GLOBALS['xoopsDB']->prefix("myhadir_penganjur")." ORDER BY penganjur ASC");
										
									
										while ($row6 = $GLOBALS['xoopsDB']->fetchArray($result6))
										{
											echo "<option value=".$row6['idpenganjur'].">".$row6['penganjur']."</option>";
										}
                                                                                
                                                                                                                                             
							echo "</select>
                              </div>";      

                         
				
$result= $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("users")." WHERE level > 0 ORDER BY name ASC"); 

	echo "<div class='mb-3'>
    <label class='form-label' for='uid'> <strong> Urusetia Program :</strong></label>
  			<select name='uid[]' id='uid' class='namamultiple uid form-control' multiple='multiple'>";
			
while($row = $GLOBALS['xoopsDB']->fetchArray($result))
{

$userid=$row['uid'];
$name=$row['name'];


      echo "<option value='$userid'>$name</option>";

 }      
 
 echo "</select> </div>";
 
echo "<button type='submit' name='tambah_program' class='btn btn-danger btn-sm m-2'><i class='fa fa-save'></i> Tambah</button>";
	 
echo "</form>";

}  //closing the if statement



//check if posted using the update link
if (isset($_POST['kemaskini_program']))  {

//run the query to update the data

$GLOBALS['xoopsDB']->query("UPDATE ".$GLOBALS['xoopsDB']->prefix("myhadir_program")." 
SET namaprogram='" . $GLOBALS['xoopsDB']->escape($_POST['namaprogram']) . "',
tarikhmula='" . test_input($_POST['tarikhmula']) . "',
tarikhtamat='" . test_input($_POST['tarikhtamat']) . "',

idlokasi='" . test_input($_POST['idlokasi']) . "',
idpenganjur='" . test_input($_POST['idpenganjur']) . "'
where idprogram=" . $_POST['idprogram']); 
$idprogram=$_POST['idprogram'];

   $getidprogram= $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_program")." WHERE idprogram='$idprogram'"); 
$row = $GLOBALS['xoopsDB']->fetchArray($getidprogram);

 $GLOBALS['xoopsDB']->queryF("DELETE from ".$GLOBALS['xoopsDB']->prefix("myhadir_aksesprogram")." WHERE idprogram='$idprogram'");
 
   foreach($_POST['uid'] as $key => $value):

    $uidx=test_input($_POST['uid'][$key]);

   $sql = "SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_aksesprogram")." WHERE uid='$uidx' AND idprogram='$idprogram'";
$result = $GLOBALS['xoopsDB']->query($sql);

 $numrows = $GLOBALS['xoopsDB']->getRowsNum($result);

  if($numrows >0){
   //found
 redirect_header("konfigurasi-program.php#$idprogram", 2, 'Sila semak semula, urusetia ditelah mempunyai akses');   
   
}else{
	
	 $newurusetiaid=test_input($_POST['uid'][$key]);
 $checkurusetia=$GLOBALS['xoopsDB']->query("SELECT * 
FROM ".$GLOBALS['xoopsDB']->prefix("groups_users_link")." WHERE uid='$newurusetiaid' AND groupid='$groupid'");
   	
$memangurusetia = $GLOBALS['xoopsDB']->getRowsNum($checkurusetia);

 
$GLOBALS['xoopsDB']->query("INSERT INTO ".$GLOBALS['xoopsDB']->prefix("myhadir_aksesprogram")." (uid,idprogram) VALUES  ('" . test_input($_POST['uid'][$key])  . "','$idprogram')");

 if ($memangurusetia=='0')
 { 
$GLOBALS['xoopsDB']->query("INSERT INTO ".$GLOBALS['xoopsDB']->prefix("groups_users_link")." (groupid,uid) VALUES  ('".$groupid."','" . test_input($_POST['uid'][$key])  . "')");
}
}	

endforeach;
$idprogram=$_POST['idprogram'];
$GLOBALS['xoopsDB']->query("INSERT INTO ".$GLOBALS['xoopsDB']->prefix("myhadir_log")." (idprogram,tindakan,tarikh,uid) VALUES  
('$idprogram','Kemaskini Program;',CURRENT_TIMESTAMP,'$loggedinuid')");


redirect_header("konfigurasi-program.php#$idprogram", 2, 'Rekod Program Berjaya Dikemaskinikan'); 
    exit(); 
}

//check if the Edit link is clicked
if (isset($_GET['edit_program']))  {

//run the query to get the data

  $result = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_program")." where idprogram='" .  $_GET['edit_program'] . "'" );


// check if records were returned
if ($GLOBALS['xoopsDB']->getRowsNum($result) > 0) {

//display the form with the selected data
while($row = $GLOBALS['xoopsDB']->fetchArray($result))  
  { //do this while there's a record in the $result array
$idprogram=$row['idprogram'];
$tahunprogram= date('Y', strtotime($tarikhmula));
$tarikhmula=$row['tarikhmula'];
$tarikhtamat=$row['tarikhtamat'];

$idlokasi=$row['idlokasi'];
$idpenganjur=$row['idpenganjur'];

				
//check urusetia
 
 $resultx2 = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_aksesprogram")." WHERE idprogram='$idprogram'");
while($rowx=$GLOBALS['xoopsDB']->fetchArray($resultx2)) 
{
$urusetia_id[]=$rowx['uid'];
$allurusetia_id=implode(",",$urusetia_id);
}
//endcheck urusetia


?><form id='set1' role='form' method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"><?php
echo "<input type=\"hidden\" name=\"idprogram\" value= " . $row['idprogram']. ">";
 
$namaprogram=$row['namaprogram'];
 echo "<div class='mb-3'>";
echo "<label class='form-label' for='namaprogram'> <strong>Nama Program :</strong></label>
<input class='form-control' type=\"text\" name=\"namaprogram\" value='". htmlspecialchars($namaprogram, ENT_QUOTES) ."' placeholder='Masukkan Nama Program'/>";
echo "<span class='badge bg-danger'><i class='fa fa-star'></i> Tambah "; 
echo htmlspecialchars('<br />');
echo " dalam Nama Program untuk baris baru jika nama program terlalu panjang</span>";
echo "</div>";

 echo "<div class='mb-3'>";
echo "<label for='tarikhmula'> <strong>Tarikh Mula :</strong></label>
<input class='form-control' type='date' name='tarikhmula' min='01/01/2022' max='31/12/2050' value='$tarikhmula' required>";
echo "</div>";

 echo "<div class='mb-3'>";
echo "<label for='tarikhtamat'> <strong>Tarikh Tamat :</strong></label>
<input class='form-control' type='date' name='tarikhtamat' min='01/01/2022' max='31/12/2050' value='$tarikhmula' required>";
echo "</div>";	


echo "<div class='mb-3'>
    <label class='form-label' for='idlokasi'> <strong>Lokasi :</strong></label>";
echo "<select name='idlokasi' id='lokasi' class='idlokasi form-control'>
      <option value=''>Lokasi</option>";
	  
   
 $resultx = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_lokasi")." ORDER BY lokasi ASC");
 
 while($row2=$GLOBALS['xoopsDB']->fetchArray($resultx)) 
{
$idlokasidb=$row2['idlokasi'];	
$lokasidb=$row2['lokasi'];

if($idlokasidb == $idlokasi) {
echo "<option value='$idlokasidb' selected>$lokasidb</option>";	
}
else
{
echo "<option value='$idlokasidb'>$lokasidb</option>";
}
}

echo "</select></div>";

echo "<div class='mb-3'>
    <label class='form-label' for='idpenganjur'> <strong>Penganjur :</strong></label>";
echo "<select name='idpenganjur' id='penganjur' class='idpenganjur form-control'>
      <option value=''>Penganjur</option>";
	  
   
 $resultx = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_penganjur")." ORDER BY penganjur ASC");
 
 while($row2=$GLOBALS['xoopsDB']->fetchArray($resultx)) 
{
$idpenganjurdb=$row2['idpenganjur'];	
$penganjurdb=$row2['penganjur'];

if($idpenganjurdb == $idpenganjur) {
echo "<option value='$idpenganjurdb' selected>$penganjurdb</option>";	
}
else
{
echo "<option value='$idpenganjurdb'>$penganjurdb</option>";
}
}

echo "</select></div>";


 

$result= $GLOBALS['xoopsDB']->query("SELECT users.uid,users.name,akses.uid,users.level
FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_aksesprogram")." AS akses INNER JOIN ".$GLOBALS['xoopsDB']->prefix("users")." as users ON akses.uid=users.uid AND idprogram='$idprogram'"); 
$adaurusetia = $GLOBALS['xoopsDB']->getRowsNum($result);

//echo $allurusetia_id;

if ($adaurusetia > 0){
	echo "<div class='mb-3'>
    <label class='form-label' for='uid'>  <strong>Urusetia Program :</strong></label>";
	
	
echo "<select name='uid[]' id='uid' class='namamultiple uid form-control' multiple='multiple'>";
			
while($row = $GLOBALS['xoopsDB']->fetchArray($result))
{
$userid_db=$row['uid'];
$name_db=$row['name'];

echo "<option value='$userid_db' selected>$name_db</option>";
 }   
 $resultz= $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("users")." WHERE level > 0 AND uid NOT IN ($allurusetia_id) ORDER BY name ASC"); 
while($rowz = $GLOBALS['xoopsDB']->fetchArray($resultz))
{
	$uid=$rowz['uid'];
$name=$rowz['name'];
 echo "<option value='$uid'>$name</option>";
}
 echo "</select> </div>";
}

else
	
	{$result= $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("users")." WHERE level > 0 ORDER BY name ASC"); 

	echo "<div class='mb-3'>
    <label class='form-label' for='uid'>  <strong>Urusetia Program :</strong></label>
  			<select name='uid[]' id='uid' class='namamultiple uid form-control' multiple='multiple'>";
			
while($row = $GLOBALS['xoopsDB']->fetchArray($result))
{

$userid=$row['uid'];
$name=$row['name'];


      echo "<option value='$userid'>$name</option>";

 }      
 
 echo "</select> </div>";}
 
 

echo "<button type='submit' name='kemaskini_program' class='btn btn-danger btn-sm m-2'><i class='fa fa-save'></i> Kemaskini </button>";
echo "</form>";
}  //close the while for every data


// once processing is complete
// free result set



} else {
	echo "<div class='alert alert-info m-2'>Tiada data</div>";

}

}




//if not searching then display all data

  $result = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_program")." ORDER BY idprogram DESC");


// check if records were returned
if ($GLOBALS['xoopsDB']->getRowsNum($result) > 0)  {

echo "<br /><table id='standard5' class='table table-striped'>
<thead>
<tr>
<th>Nama Program</th>
<th>Tarikh</th>
<th>Lokasi</th>
<th>Penganjur</th>
<th>Tindakan</th>
</tr></thead><tbody>";


//display all data and pass the data per record to the array $row
while($row = $GLOBALS['xoopsDB']->fetchArray($result))
  {
 $idprogram=$row['idprogram'];
			    $namaprogram=$row['namaprogram'];
				   $tarikhmula=$row['tarikhmula'];
				 $tarikhtamat=$row['tarikhtamat'];	
				  $idpenganjur=$row['idpenganjur'];
				   $idlokasi=$row['idlokasi'];
				  $tahunprogram= date('Y', strtotime($tarikhmula));
 
  echo '<tr>'; 

echo "<td><a id='$idprogram' name='$idprogram'></a>
" . $row['namaprogram'] . "";

$checksijil = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_kehadiran")." WHERE idprogram=" . $row['idprogram'] . "");
$jumlahsijil=$GLOBALS['xoopsDB']->getRowsNum($checksijil);
echo "<br /><br /><small><b>No Sijil:</b> myHadir/$namasingkatan/" . $row['idprogram'] . "/" . $tahunprogram . "/" . $jumlahsijil . "/";


if ($jumlahsijil > 0)
{echo "1-$jumlahsijil";}

echo "<br /><b>Jumlah Sijil:</b> $jumlahsijil</small>";

 $checkurusetia = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_aksesprogram")." WHERE idprogram='$idprogram'");
 $jumlahurusetia = $GLOBALS['xoopsDB']->getRowsNum($checkurusetia);
echo "<small><br /><b>Urusetia:</b> <br>";	

if ($jumlahurusetia==0)
{
	echo "<span style='color:red'>Belum Ditetapkan</span>"; 
}
 while($rowx=$GLOBALS['xoopsDB']->fetchArray($checkurusetia)) 
{
$urusetia_uid=$rowx['uid'];
$resulturusetia = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("users")." WHERE uid='$urusetia_uid'");
 while($rows=$GLOBALS['xoopsDB']->fetchArray($resulturusetia)) 
{
 $urusetia=$rows['name'];
echo "$urusetia,";	
}
}	
 

echo "</small></td>";



echo "<td>";

 
$tarikh_mula=date('d F Y',strtotime($tarikhmula));
$tarikh_tamat=date('d F Y',strtotime($tarikhtamat));	
$translated_tarikhmula = str_ireplace($monthsDaysEn,$monthsDaysMy,$tarikh_mula);
$translated_tarikhtamat= str_ireplace($monthsDaysEn,$monthsDaysMy,$tarikh_tamat);

if($tarikhmula==$tarikhtamat)

echo "<small>$translated_tarikhmula </small>";	
else
echo "<small>$translated_tarikhmula - $translated_tarikhtamat </small>";
echo "</td>";

echo "<td>";

$checklokasi = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_lokasi")." WHERE idlokasi='$idlokasi'");
$rowlokasi=$GLOBALS['xoopsDB']->fetchArray($checklokasi);
$lokasidb=$rowlokasi['lokasi'];
echo "$lokasidb";

echo "</td>";


echo "<td>";

$checkpenganjur = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_penganjur")." WHERE idpenganjur='$idpenganjur'");
$rowpenganjur=$GLOBALS['xoopsDB']->fetchArray($checkpenganjur);
$penganjurdb=$rowpenganjur['penganjur'];
echo "$penganjurdb";


echo "</td>";
echo "<td>";
	
	
	echo "<a href='" . htmlspecialchars("$_SERVER[PHP_SELF]") . "?clone_program=" . $row['idprogram'] . "#program'><span class='badge bg-light text-dark'> <i class='fa fa-edit'></i> Klon</span></a> "; 
echo "<a href='" . htmlspecialchars("$_SERVER[PHP_SELF]") . "?edit_program=" . $row['idprogram'] . "#program'><span class='badge bg-info'> <i class='fa fa-edit'></i> Kemaskini</span></a> "; 
echo "<a href=\"" . htmlspecialchars("$_SERVER[PHP_SELF]") . "?del_program=".$row['idprogram']."\"onclick=
      \"return confirm('Adakah anda pasti untuk hapus? Semua Sijil dibawah program ini akan turut dihapuskan ')\"><span class='badge bg-danger'><i class='fa fa-trash'></i> Hapus</span></a> ";	

	




 
echo "<a href='".XOOPS_URL."\modules\myhadir\info-penerima.php?id=".$idprogram."'><span class='badge bg-dark'>
<i class='fa fa-star'></i> Penerima Sijil</span></a>";
echo "<a href='".XOOPS_URL."\modules\myhadir\kehadiran.php?id=".$idprogram."'><span class='badge bg-light text-dark'>
<i class='fa fa-user-circle'></i> Kehadiran</span></a>";


	  echo  "</td>";
echo "</tr>";

  
 }

 // once processing is complete
// free result set

echo "</tbody></table>";

}
 else
 
 {
 echo "<div class='alert alert-info m-2'>Tiada data</div>";
 
 }
 
 
 
?>


</div></div>




<?php
}else{
   //not found
  redirect_header("".XOOPS_URL."/modules/myhadir/programsaya.php", 2, _NOPERM); 
}

include(XOOPS_ROOT_PATH."/footer.php");
?>