<?php
//  Author: Lionel Michael Jominin
//  URL: https://jknsabah.moh.gov.my/hbeaufort/
//  E-Mail: lionel.m@moh.gov.my


include("../../mainfile.php");
include(XOOPS_ROOT_PATH."/header.php");
$meta_keywords = "sistem,myHadir";
$meta_description = "Sistem Pengurusan Kehadiran Program";
$pagetitle = "Pengesahan Kehadiran - Sistem myHadir";

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





















	$resultpeserta = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_kehadiran")." where idprogram = '$idprogram'" );
    $jumlahpeserta = $GLOBALS['xoopsDB']->getRowsNum($resultpeserta);
$curdate=date("Y-m-d");
                                    if($tarikhmula < $curdate OR $jumlahpeserta > $kuotapeserta)
									{ 
									 ?>
			<script language="JavaScript">
				//alert("Permohonan Pendaftaran telah ditutup");
				//self.location ="program.php";
			</script>
									 <?php
									 }
									 

	$idprogram=$GLOBALS['xoopsDB']->escape($_POST['idprogram']);
	$nama=$GLOBALS['xoopsDB']->escape($_POST['nama']);
	$mykad=$GLOBALS['xoopsDB']->escape($_POST['mykad']);
	$email=$GLOBALS['xoopsDB']->escape($_POST['email']);
	$notel=$GLOBALS['xoopsDB']->escape($_POST['notel']);
	$idunit=$GLOBALS['xoopsDB']->escape($_POST['idunit']);
        
        
        if($mykad != 0){
        $idkehadiran=$GLOBALS['xoopsDB']->escape($_POST['id']);
        $mykad=$GLOBALS['xoopsDB']->escape($_POST['mykad']);
        
        //echo 
        $query="SELECT * from ".$GLOBALS['xoopsDB']->prefix("myhadir_kehadiran")." WHERE mykad = '$mykad' and idprogram = '$idprogram' " ;
	//echo $query;
	$result=$GLOBALS['xoopsDB']->query($query);
	$size = $GLOBALS['xoopsDB']->getRowsNum($result);
       
        if($size !=0)
	{ 
            echo "<div class='alert alert-danger'> <i class='fa fa-exclamation-circle'></i> Penama ini telah membuat pengesahan kehadiran untuk program ini.</div>";
        }
        else
        {
            //echo 'belum register';
        
	$query="SELECT * from ".$GLOBALS['xoopsDB']->prefix("myhadir_program")." WHERE idprogram = '$idprogram' " ;
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

  $checkpeserta = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_kehadiran")." where idprogram = '$idprogram`'" );
  $jumlahpeserta = $GLOBALS['xoopsDB']->getRowsNum($checkpeserta);
  $checkunit= $GLOBALS['xoopsDB']->query("SELECT * from ".$GLOBALS['xoopsDB']->prefix("myhadir_unit")." WHERE idunit = '$idunit'");
  $rowx =$GLOBALS['xoopsDB']->fetchArray($checkunit);
  $unit=$rowx['unit'];
?>  


 <p class="rounded alert alert-danger"><i class='fa fa-exclamation-circle'></i> Sila semak data dan tekan butang <b>Sahkan</b></p>

<table class='table table-striped table-hover table-border'>
 <form method="post" name="form" action="daftarkehadiran2.php">
 
		<tr>
                    <td colspan='2'>
						<h2><span class='badge bg-dark'><i class='fa fa-user' title='Daftar'></i> Pengesahan Kehadiran</span></h2>
					</td>
		</tr>
		
						<tr>
							<td><b>Nama Penuh</b></td>
							<td><input type="text" name="nama" class="form-control" value="<?php echo $nama;?>" readonly="" readonly autocomplete="off"></td>
						</tr>
						<tr>
							<td><b>No MyKad</b> </td>
							<td><input type="text" name="mykad" class="form-control" value="<?php echo $mykad;?>" readonly="" readonly autocomplete="off" required>
							</td>
						</tr>
						<tr>
							<td><b>Email</b> </td>
							<td><input type="email" name="email" class="form-control" value="<?php echo $email;?>" readonly="" readonly autocomplete="off">
							</td>
						</tr>
						<tr>
							<td><b>Unit</b></td>
							<td><input type="text" name="idunit" class="form-control" value="<?php echo "$unit"?>" readonly="" readonly autocomplete="off" ></td>
						</tr>
						<tr>
							<td><b>No.Tel/Ext</b></td>
							<td><input type="text" name="notel" class="form-control" value="<?php echo $notel;?>" readonly="" readonly autocomplete="off"> </td>
						</tr>
						
				
						<tr>
							<td colspan='2' align="center"><b><input type="submit" class='btn btn-primary btn-sm' name="cari" value="Sahkan">&nbsp;
						</tr>
						</table>
<input type="hidden" name="idunit" value="<?php echo $idunit;?>">
		<input type="hidden" name="idprogram" value="<?php echo $idprogram;?>">
		</form>
    
		<?php  } }?>

</div></div>

<?php
include(XOOPS_ROOT_PATH."/footer.php");
?>