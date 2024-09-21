<?php
//  Author: Lionel Michael Jominin
//  URL: https://jknsabah.moh.gov.my/hbeaufort/
//  E-Mail: lionel.m@moh.gov.my


include("../../mainfile.php");
include(XOOPS_ROOT_PATH."/header.php");
$meta_keywords = "sistem,myHadir";
$meta_description = "Sistem Pengurusan Kehadiran Program";
$pagetitle = "Daftar Program - Sistem myHadir";

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


  function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
$monthsDaysEn = array('January','February','March','April','May','June','July','August','September','October','November','December'); //populate with all months/days you want translated
$monthsDaysMy = array('Januari','Februari','Mac','April','Mei','Jun','Julai','Ogos','September','Oktober','November','Disember'); //populate with all months/days you want translated


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
    jQuery('#standard').DataTable( {
    "bPaginate": true,
    "bLengthChange": true,
    "bFilter": true,
    "bInfo": true,
	"bSort": false,
    "pageLength": 10,
		"language": {
       url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/ms.json',
    },
    } );
	
} );
	</script>
<script type="text/javascript">
jQuery(document).ready(function() {
  jQuery(".idunit").select2({theme: "bootstrap-5"});
});
</script>


    <div class='container-fluid'>
    <div class='row p-4'>
<?php
$idprogram=$_POST['idprogram'];

	echo "<div class='alert alert-info m-2'>";


	$result2 = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_program")." WHERE idprogram= '".$idprogram."'"); 
			                   while($row = $GLOBALS['xoopsDB']->fetchArray($result2))
{        
			  $idprogram=$row['idprogram'];
			    $namaprogram=$row['namaprogram'];
			  $tarikhmula=$row['tarikhmula'];
				 $tarikhtamat=$row['tarikhtamat'];
				 	
				  $idtemplate=$row['idtemplate'];	
				  $idunit=$row['idunit'];
				  $idpenganjur=$row['idpenganjur'];
				   $idlokasi=$row['idlokasi'];
				    $cpd=$row['cpd'];
					 $cpdpoint=$row['cpdpoint'];
					 $tahunprogram= date('Y', strtotime($tarikhmula));
				  
									    echo "<h4>$namaprogram</h4>";
										echo "<strong>Tarikh dan Masa:</strong> <br /> ";
										$tarikh_mula=date('d F Y',strtotime($tarikhmula));
$tarikh_tamat=date('d F Y',strtotime($tarikhtamat));	
$translated_tarikhmula = str_ireplace($monthsDaysEn,$monthsDaysMy,$tarikh_mula);
$translated_tarikhtamat= str_ireplace($monthsDaysEn,$monthsDaysMy,$tarikh_tamat);

if($tarikhmula==$tarikhtamat)

echo "$translated_tarikhmula &nbsp;";	
else
echo "$translated_tarikhmula - $translated_tarikhtamat &nbsp;";
$checklokasi = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_lokasi")." WHERE idlokasi='$idlokasi'");
$rowlokasi=$GLOBALS['xoopsDB']->fetchArray($checklokasi);
$lokasi=$rowlokasi['lokasi'];

$checkpenganjur = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_penganjur")." WHERE idpenganjur='$idpenganjur'");
$rowpenganjur=$GLOBALS['xoopsDB']->fetchArray($checkpenganjur);
$penganjur=$rowpenganjur['penganjur'];
										echo "<br><strong>Lokasi:</strong> <br />$lokasi<br />";
										echo "<strong>Penganjur:</strong> <br />$penganjur<br />";
										
										
								
}
	
 $checkurusetia = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_aksesprogram")." WHERE idprogram='$idprogram'");
 $jumlahurusetia = $GLOBALS['xoopsDB']->getRowsNum($checkurusetia);
echo "<b>Urusetia:</b> <br>";	

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
	
echo "</div>";













	$idpprogram=$GLOBALS['xoopsDB']->escape($_POST['idprogram']);
	$nama=$GLOBALS['xoopsDB']->escape($_POST['nama']);
	$mykad=$GLOBALS['xoopsDB']->escape($_POST['mykad']);
	$email=$GLOBALS['xoopsDB']->escape($_POST['email']);
	$notel=$GLOBALS['xoopsDB']->escape($_POST['notel']);
	$idunit=$GLOBALS['xoopsDB']->escape($_POST['idunit']);
	

	$query="SELECT * from ".$GLOBALS['xoopsDB']->prefix("myhadir_program")." WHERE idprogram = '$id' " ;

	//echo $query;
	$result=$GLOBALS['xoopsDB']->query($query);
	while ($row =$GLOBALS['xoopsDB']->fetchArray($result)) 
	{
	$namaprogram=$row['namaprogram'];
		$tarikhmula=$row['tarikhmula'];
				$tarikhmula=$row['tarikhmula'];
		$tarikhtamat=$row['tarikhtamat'];
		$waktu=$row['waktu'];
		$anjuran=$row['anjuran'];
                $kuotapeserta=$row['kuotapeserta'];
		$tempat=$row['tempat'];
		$urusetia=$row['urusetia'];
		$cpd=$row['cpd'];
					$cpdpoint=$row['cpdpoint'];
	}	

$checkic="SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_kehadiran")." WHERE id = '$id' and mykad='$mykad'";
$result=$GLOBALS['xoopsDB']->query($checkic);
if($GLOBALS['xoopsDB']->getRowsNum($result)==0) { 
		$GLOBALS['xoopsDB']->query("INSERT INTO ".$GLOBALS['xoopsDB']->prefix("myhadir_kehadiran")." (nama,mykad,email,idkategorikehadiran,idprogram,kehadiran,idunit) 
VALUES  ('" . test_input($_POST['nama'])  . "','" . test_input($_POST['mykad'])  . "','" . test_input($_POST['email'])  . "','" . test_input($_POST['idkategorikehadiran'])  . "','" . test_input($_POST['idprogram'])  . "',
'" . test_input($_POST['kehadiran'])  . "','" . test_input($_POST['idunit'])  . "')");		
		$GLOBALS['xoopsDB']->query("INSERT INTO ".$GLOBALS['xoopsDB']->prefix("myhadir_log")." (idprogram,tindakan,tarikh,uid) VALUES  ('$idprogram','Daftar Program',CURRENT_TIMESTAMP,'')");
//redirect_header("peserta.php?id=$idprogram", 2, 'Kehadiran berjaya dihapuskan'); 
  // exit(); 
}
else
{
?>
	<script>
	self.location ="program.php";
			</script>
<?php }	


    echo "<div class='alert alert-primary'>
  <i class='fa fa-exclamation-circle'></i> Kehadiran $nama telah berjaya didaftarkan dalam program.
  
   Terima Kasih.
		</div>";
?>		
		<br><br><a href='program.php?id=<?php echo $idkehadiran; ?>' class='btn btn-primary btn-sm text-white'><i class='fa fa-arrow-left'></i> Kembali ke Program</a>
		


</div></div>




<?php
include(XOOPS_ROOT_PATH."/footer.php");
?>