<?php
//  Author: Lionel Michael Jominin
//  URL: https://jknsabah.moh.gov.my/hbeaufort/
//  E-Mail: lionel.m@moh.gov.my

include("../../mainfile.php");
include(XOOPS_ROOT_PATH."/header.php");


$meta_keywords = "Konfigurasi Umum Sistem myHadir";
$meta_description = "Konfigurasi Umum Sistem myHadir";
$pagetitle = "Konfigurasi Umum - Sistem myHadir";

if(isset($xoTheme) && is_object($xoTheme)) {
    $xoTheme->addMeta( 'meta', 'keywords', $meta_keywords);
    $xoTheme->addMeta( 'meta', 'description', $meta_description);
} else {    // Compatibility for old Xoops versions
    $xoopsTpl->assign('xoops_meta_keywords', $meta_keywords);
    $xoopsTpl->assign('xoops_meta_description', $meta_description);
}
$xoopsTpl->assign('xoops_pagetitle', $pagetitle);
$xoopsUser->isAdmin() or redirect_header('index.php', 3, _NOPERM);
  function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>

<link rel="stylesheet" type="text/css" href="assets/css/style.css" />
<link rel="stylesheet" href="assets/js/jquery-ui.min.css" type="text/css" /> 
<script src="assets/js/jquery-1.9.1.js"></script>


<script type="text/javascript">
  var jQuery_1_9_1 =$.noConflict(true);
  </script> 

<noscript>
    <style type="text/css">
        .body {display:none;}
    </style>
</noscript>

  <div class='container-fluid'>
    <div class='row p-4'>
<?php

//check if the Edit link is clicked
if (isset($_GET['edit_konfigurasiumum']))  {

	

   	 
$result= $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_konfigurasiumum")." WHERE id='" .  $_GET['edit_konfigurasiumum'] . "'"); 
  if ($GLOBALS['xoopsDB']->getRowsNum($result) > 0) { 
  
while ($rows=$GLOBALS['xoopsDB']->fetchArray($result))
{
        $id = $rows['id'];
		   $namaagensi = $rows['namaagensi'];
		   $namasingkatan = $rows['namasingkatan'];
		   $urusetiagroupid=$rows['urusetiagroupid'];
$urusetiacpgroupid=$rows['urusetiacpgroupid'];
$admingroupid=$rows['admingroupid'];
$alamat1=$rows['alamat1'];
$alamat2=$rows['alamat2'];
$negeri=$rows['negeri'];
$notelefon=$rows['notelefon'];
$lamanweb=$rows['lamanweb'];
$emailrasmi=$rows['emailrasmi'];
$apppassword=$rows['apppassword'];

?><form id='umum' role='form' method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"><?php
      echo "<div class='mb-3'>
    <label class='form-label' for='namaagensi'><strong>Nama Agensi:</strong></label>";
echo "</th><td><input type='text' class='form-control' name='namaagensi' value='$namaagensi'/>";
 echo "</div>";
 
      echo "<div class='mb-3'>
    <label class='form-label' for='namasingkatan'><strong>Nama Singkatan:</strong></label>";
echo "</th><td><input type='text' class='form-control' name='namasingkatan' value='$namasingkatan'/>";
 echo "</div>";

      echo "<div class='mb-3'>
    <label class='form-label' for='alamat1'><strong>Alamat 1:</strong></label>";
echo "</th><td><input type='text' class='form-control' name='alamat1' value='$alamat1'/>";
 echo "</div>";

      echo "<div class='mb-3'>
    <label class='form-label' for='alamat2'><strong>Alamat 2:</strong></label>";
echo "</th><td><input type='text' class='form-control' name='alamat2' value='$alamat2'/>";
 echo "</div>";
 
      echo "<div class='mb-3'>
    <label class='form-label' for='negeri'><strong>Negeri:</strong></label>";
echo "</th><td><input type='text' class='form-control' name='negeri' value='$negeri'/>";
 echo "</div>";


      echo "<div class='mb-3'>
    <label class='form-label' for='notelefon'><strong>No Telefon:</strong></label>";
echo "</th><td><input type='text' class='form-control' name='notelefon' value='$notelefon'/>";
 echo "</div>";

      echo "<div class='mb-3'>
    <label class='form-label' for='lamanweb'><strong>Laman Web:</strong></label>";
echo "</th><td><input type='text' class='form-control' name='lamanweb' value='$lamanweb'/>";
 echo "</div>";

      echo "<div class='mb-3'>
    <label class='form-label' for='emailrasmi'><strong>Email Rasmi:</strong></label>";
echo "</th><td><input type='text' class='form-control' name='emailrasmi' value='$emailrasmi'/>";
 echo "</div>";

      echo "<div class='mb-3'>
    <label class='form-label' for='apppassword'><strong>App Password:</strong></label>";
echo "</th><td><input type='text' class='form-control' name='apppassword' value='$apppassword'/>";
 echo "</div>";

 echo "<div class='mb-3'>
    <label class='form-label' for='urusetiagroupid'><strong>Group ID Urusetia Program:</strong></label>";
echo "</th><td><input type='text' class='form-control' name='urusetiagroupid' value='$urusetiagroupid'/>";
 echo "</div>";
 
      echo "<div class='mb-3'>
    <label class='form-label' for='urusetiacpgroupid'><strong>Group ID Urusetia C&P:</strong></label>";
echo "</th><td><input type='text' class='form-control' name='urusetiacpgroupid' value='$urusetiacpgroupid'/>";
 echo "</div>";
 
       echo "<div class='mb-3'>
    <label class='form-label' for='admingroupid'><strong>Group ID Admin myHadir:</strong></label>";
echo "</th><td><input type='text' class='form-control' name='admingroupid' value='$admingroupid'/>";
 echo "</div>";
 
echo "<input type='hidden' name='id' value='$id'>";
  echo "<button type='submit' name='submit' class='btn btn-danger btn-sm m-2'>Simpan</button>";
	 
	
   echo "</form>";
  }
  }
else
{
echo "<div class='alert alert-danger'>There is no such record exist!</div>";
}
}



if (isset($_POST['submit']))  {
   
   $id=$_POST['id'];

$check= $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_konfigurasiumum")." WHERE id='".intval($id)."'"); 

  while($old=$GLOBALS['xoopsDB']->fetchArray($check)) {

if ($old['namaagensi'] != $_POST['namaagensi'] OR $old['namasingkatan'] != $_POST['namasingkatan'] OR $old['urusetiagroupid'] != $_POST['urusetiagroupid'] OR $old['urusetiacpgroupid'] != $_POST['urusetiacpgroupid']
)
{
	
$GLOBALS['xoopsDB']->query("UPDATE ".$GLOBALS['xoopsDB']->prefix("myhadir_konfigurasiumum")."
SET urusetiagroupid='" . test_input(($_POST['urusetiagroupid'])) . "',
urusetiacpgroupid='" . test_input(($_POST['urusetiacpgroupid'])) . "',
admingroupid='" . test_input(($_POST['admingroupid'])) . "',
namaagensi='" . test_input(($_POST['namaagensi'])) . "',
namasingkatan='" . test_input(($_POST['namasingkatan'])) . "',
alamat1='" . test_input(($_POST['alamat1'])) . "',
alamat2='" . test_input(($_POST['alamat2'])) . "',
negeri='" . test_input(($_POST['negeri'])) . "',
notelefon='" . test_input(($_POST['notelefon'])) . "',
lamanweb='" . test_input(($_POST['lamanweb'])) . "',
emailrasmi='" . test_input(($_POST['emelrasmi'])) . "',
apppassword='" . test_input(($_POST['apppassword'])) . "'
WHERE id='".intval($id)."'"); 

$GLOBALS['xoopsDB']->query("INSERT INTO ".$GLOBALS['xoopsDB']->prefix("myhadir_log")." (idprogram,tindakan,tahun,tarikh,uid) VALUES  ('','Kemaskini Konfigurasi Umum Sistem mysijil','-',CURRENT_TIMESTAMP,'$loggedinuid')");

redirect_header("konfigurasi-umum.php?id=$id", 2, 'Rekod Berjaya Dikemaskini'); 
   exit(); 

} 


else 
{

redirect_header("konfigurasiumum.php?id=$id", 2, 'Tiada perubahan dikesan'); 
    exit(); 

}
	}
   }
   










?>


	
	<?php

		$result = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_konfigurasiumum")."");

echo "<table class='table table-striped table-bordered'>";

$count = 1;

$row = $GLOBALS['xoopsDB']->fetchArray($result);

$id=$row['id']; 
echo "<tr><th>Nama Agensi</th><td>" . $row['namaagensi'] . "</td></tr>";
echo "<tr><th>Nama Singkatan</th><td>" . $row['namasingkatan'] . "</td></tr>";
echo "<tr><th>Alamat 1</th><td>" . $row['alamat1'] . "</td></tr>";
echo "<tr><th>Alamat 2</th><td>" . $row['alamat2'] . "</td></tr>";
echo "<tr><th>Negeri</th><td>" . $row['negeri'] . "</td></tr>";
echo "<tr><th>No Telefon`</th><td>" . $row['notelefon'] . "</td></tr>";
echo "<tr><th>Laman Web</th><td>" . $row['lamanweb'] . "</td></tr>";
echo "<tr><th>Email Rasmi</th><td>" . $row['emailrasmi'] . "</td></tr>";
echo "<tr><th>App Password<br><small>https://myaccount.google.com/apppasswords</small></th><td>" . $row['apppassword'] . "</td></tr>";
echo "<tr><th>Group ID admin</th><td>" . $row['admingroupid'] . "</td></tr>";
echo "<tr><th>Group ID Urusetia </th><td>" . $row['urusetiagroupid'] . "</td></tr>";
echo "<tr><th>Group ID Urusetia C&P</th><td>" . $row['urusetiacpgroupid'] . "</td></tr>";


global $xoopsUser;
if ( is_object($xoopsUser) )
{
    if ( $xoopsUser->isAdmin() )
    {
$id=$row['id']; 
      echo "<tr align='center'><td colspan=2><a class='btn btn-dark btn-sm' href='" . htmlspecialchars("$_SERVER[PHP_SELF]") . "?edit_konfigurasiumum=$id'><b>Kemaskini</b></a>  </td></tr>";


    }
}

echo "</table>";




?>
</div></div>
<noscript>Please enable Javascript in your browser</noscript></body>
</html>


<?php
include(XOOPS_ROOT_PATH."/footer.php");
?>