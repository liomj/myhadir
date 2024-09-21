<?php
//  Author: Lionel Michael Jominin
//  URL: https://jknsabah.moh.gov.my/hbeaufort/
//  E-Mail: lionel.m@moh.gov.my


include("../../mainfile.php");
include(XOOPS_ROOT_PATH."/header.php");


$meta_keywords = "sistem,myHadir";
$meta_description = "Sistem Pengurusan Kehadiran Program";
$pagetitle = "Senarai Program - Sistem myHadir";

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
$monthsDaysEn = array('January','February','March','April','May','June','July','August','September','October','November','December'); //populate with all months/days you want translated
$monthsDaysMy = array('Januari','Februari','Mac','April','Mei','Jun','Julai','Ogos','September','Oktober','November','Disember'); //populate with all months/days you want translated


?>




<link rel="stylesheet" type="text/css" href="assets/css/datatables.min.css"/>

<script src="assets/js/datatables.min.js"></script>



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


    <div class='container-fluid'>
    <div class='row p-4'>
<?php
//if not searching then display all data

  $result = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_program")." ORDER BY idprogram DESC");


// check if records were returned
if ($GLOBALS['xoopsDB']->getRowsNum($result) > 0)  {
			  
echo "<table id='standard' class='table table-striped'>
<thead><tr>

<th>Nama Program</th>
<th>Tarikh</th>
<th>Lokasi</th>
<th>Penganjur</th>
<th>Tindakan</th>
</tr></thead><tbody>";


$count =1 ;
//display all data and pass the data per record to the array $row
while($row = $GLOBALS['xoopsDB']->fetchArray($result))
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


 
  echo '<tr>'; 
 // echo "<td>";
//echo $count++;
//echo "</td>";
echo "<td>" . $row['namaprogram'] . "</td>";
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

echo "<a href='".XOOPS_URL."\modules\myhadir\daftarkehadiran.php?id=$idprogram'><button type='button' class='btn btn-danger btn-sm'> Daftar Kehadiran</button></a> "; 

echo "</td>";

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
include(XOOPS_ROOT_PATH."/footer.php");
?>