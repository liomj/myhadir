<?php
//  Author: Lionel Michael Jominin
//  URL: https://jknsabah.moh.gov.my/hbeaufort/
//  E-Mail: lionel.m@moh.gov.my


include("../../mainfile.php");
include(XOOPS_ROOT_PATH."/header.php");
$meta_keywords = "Sistem myHadir";
$meta_description = "Sistem myHadir";
$pagetitle = "Konfigurasi Unit - Sistem myHadir";

if(isset($xoTheme) && is_object($xoTheme)) {
    $xoTheme->addMeta( 'meta', 'keywords', $meta_keywords);
    $xoTheme->addMeta( 'meta', 'description', $meta_description);
} else {    // Compatibility for old Xoops versions
    $xoopsTpl->assign('xoops_meta_keywords', $meta_keywords);
    $xoopsTpl->assign('xoops_meta_description', $meta_description);
}

$xoopsTpl->assign('xoops_pagetitle', $pagetitle);
//$xoopsUser->isAdmin() or redirect_header('index.php', 3, _NOPERM);

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
    jQuery('#unit').DataTable({"language": {
       url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/ms.json',
    },});
} );
</script>


<noscript>

</noscript>

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


<div class="container-fluid">
<div class="row p-4">


<div class='p-3'>  <a href="?add_unit=1" class='btn btn-dark btn-sm'><i class='fa fa-save'></i> Tambah Rekod Unit</a></div> 

<?php  
global $xoopsUser; 

//get current user id  
$loggedinuid = is_object($xoopsUser) ? $xoopsUser->getVar('uid') : 0;  


 //if the Delete link is clicked
if (isset($_GET['del_unit']))  {

$GLOBALS['xoopsDB']->queryF("DELETE from ".$GLOBALS['xoopsDB']->prefix("myhadir_unit")." WHERE idunit='" . $_GET['del_unit'] . "'");
$GLOBALS['xoopsDB']->queryF("INSERT INTO ".$GLOBALS['xoopsDB']->prefix("myhadir_log")." (idprogram,tindakan,tarikh,uid,jenis) VALUES  
('0','Hapus Unit',CURRENT_TIMESTAMP,'$loggedinuid','1')");
redirect_header("konfigurasi-unit.php", 2, 'Rekod Berjaya Dihapuskan'); 
    exit(); 
	}
	
//if posted using add
if (isset($_POST['tambah_unit']))  {


$GLOBALS['xoopsDB']->query("INSERT INTO ".$GLOBALS['xoopsDB']->prefix("myhadir_unit")." (unit) VALUES  ('" . test_input(($_POST['unit']))  . "')");
$GLOBALS['xoopsDB']->query("INSERT INTO ".$GLOBALS['xoopsDB']->prefix("myhadir_log")." (idprogram,tindakan,tarikh,uid,jenis) VALUES  
('0','Tambah Unit',CURRENT_TIMESTAMP,'$loggedinuid','1')");

redirect_header("konfigurasi-unit.php", 2, 'Rekod Berjaya Ditambah'); 
    exit(); 


}




// check if the Add link is clicked
if (isset($_GET['add_unit']))  {

//close the php to display the html form

?><form id='set1' role='form' method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"><?php
 echo "<div class='mb-3'>";
echo "<label class='form-label' for='unit'> Nama Unit :</label>
<input class='form-control' type=\"text\" name=\"unit\" placeholder='Masukkan Nama Unit' />";
echo "</div>";


echo "<button type='submit' name='tambah_unit' class='btn btn-danger btn-sm m-2'><i class='fa fa-save'></i> Tambah</button>";
	 
echo "</form>";

}  //closing the if statement



//check if posted using the update link
if (isset($_POST['kemaskini_unit']))  {

//run the query to update the data

$GLOBALS['xoopsDB']->query("UPDATE ".$GLOBALS['xoopsDB']->prefix("myhadir_unit")." SET unit='" . test_input(($_POST['unit'])) . "' where idunit=" . $_POST['idunit']); 
$GLOBALS['xoopsDB']->query("INSERT INTO ".$GLOBALS['xoopsDB']->prefix("myhadir_log")." (idprogram,tindakan,tarikh,uid,jenis) VALUES  
('0','Kemaskini Unit',CURRENT_TIMESTAMP,'$loggedinuid','1')");

redirect_header("konfigurasi-unit.php", 2, 'Rekod Berjaya Dikemaskinikan'); 
    exit(); 
}

//check if the Edit link is clicked
if (isset($_GET['edit_unit']))  {

//run the query to get the data

  $result2 = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_unit")." where idunit='" .  $_GET['edit_unit'] . "'" );
$numrows = $GLOBALS['xoopsDB']->getRowsNum($result2);

// check if records were returned
if ($numrows > 0) {

//display the form with the selected data
 while($row=$GLOBALS['xoopsDB']->fetchArray($result2))  
  { //do this while there's a record in the $result array

?><form id='set1' role='form' method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"><?php
echo "<input type=\"hidden\" name=\"idunit\" value= " . $row['idunit']. ">";
 echo "<div class='mb-3'>";
echo "<label class='form-label' for='unit'> Masukkan Nama Unit :</label>";
echo "<input class='form-control' type=\"text\" name=\"unit\" value='" . $row['unit'] . "'>";
echo "</div>";



echo "<button type='submit' name='kemaskini_unit' class='btn btn-danger btn-sm m-2'><i class='fa fa-save'></i> Kemaskini </button>";
echo "</form>";
}  //close the while for every data


// once processing is complete
// free result set



} else {
	echo "<div class='alert alert-info m-2'>Tiada data</div>";

}

}

//if not searching then display all data

  $result = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_unit")." ORDER BY idunit ASC");


// check if records were returned
if ($GLOBALS['xoopsDB']->getRowsNum($result) > 0)  {

echo "<br /><table id='unit' class='table table-striped table-hover'>
<thead>

<th>Unit</th>
<th>Tindakan</th>
</thead>";


$count =1 ;
//display all data and pass the data per record to the array $row
while($row=$GLOBALS['xoopsDB']->fetchArray($result)) 
  {

 
  echo '<tr>'; 
echo "<td>" . $row['unit'] . "</td>";
echo "<td><a href='" . htmlspecialchars("$_SERVER[PHP_SELF]") . "?edit_unit=" . $row['idunit'] . "'><button type='button' class='btn btn-success btn-sm'> <i class='fa fa-edit' title='Kemaskini'></i></button></a>"; 
echo "<a href=\"" . htmlspecialchars("$_SERVER[PHP_SELF]") . "?del_unit=".$row['idunit']."\"onclick=
      \"return confirm('Adakah anda pasti untuk hapus?')\"><button type='button' class='btn btn-danger btn-sm m-2'> <i class='fa fa-trash' title='Hapus'></i></button></a> ";	
echo  "</td>";
echo "</tr>";

  
 }

 // once processing is complete
// free result set

echo "</table>";

}
 else
 
 {
 echo "<div class='alert alert-info m-2'>Tiada data</div>";
 
 }
 
 
 
 
 
 
 
 
?>


</div></div><noscript>Please enable Javascript in your browser</noscript>


<?php
}else{
   //not found
  redirect_header("".XOOPS_URL."/modules/mysijil/programsaya.php", 2, _NOPERM); 
}
include(XOOPS_ROOT_PATH."/footer.php");
?>