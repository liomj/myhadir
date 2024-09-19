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
$idprogram=$_GET['id'];



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


	$resultpeserta = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_nama")." where idprogram = '$idprogram'" );
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
									 ?>
	
<table class='table table-striped table-hover table-border'>
 <form method="post" name="form" action="daftarkehadiran-sah.php">

	<tr>
                    <td colspan='2'>
					<h2><span class='badge bg-danger'><i class='fa fa-user' title='Daftar'></i> Daftar Kehadiran</span></h2>

					</td>
		</tr>

					
						<tr>
							<td><b>Nama Penuh </b></td>
							<td> <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama Penuh" autocomplete="off" required></td>
						</tr>
						<tr>
							<td><b>No myKad</b>  </td>
							<td> <input type="text" name="mykad" maxlength="12" class="form-control" placeholder="Masukkan tanpa sengkang" autocomplete="off" required> 
							</td>
						</tr>
							<tr>
							<td><b>Email</b>  </td>
							<td> <input type="email" name="email" maxlength="120" class="form-control" placeholder="Masukkan Email" autocomplete="off"> 
							</td>
						</tr>
					
						<tr>
							<td><b>Unit</b></td>
							<td> <div class="form-group">
							<select name='idunit' id='idunit' class='idunit form-select' required>
								<option value="">Sila Pilih</option>
									<?php
										$query6="SELECT DISTINCT * from ".$GLOBALS['xoopsDB']->prefix("myhadir_unit")." ORDER BY unit ASC" ;
										$result6=$GLOBALS['xoopsDB']->query($query6);	
									
										while ($row6 =$GLOBALS['xoopsDB']->fetchArray($result6)) 
										{
											echo "<option value='".$row6['idunit']."'>".$row6['unit']."</option>";
										}
                                                                                
                                                                               	?>
                                                                
                                                          
							</select>
                              </div>                              
							</td>
						</tr>
				        <tr>
							<td><b>No.Tel/Ext</b></td>
							<td> <input type="text" name="notel" class="form-control" placeholder="Masukkan No Extension atau No Telefon" autocomplete="off" required></td>
						</tr>
						<tr>
							<td colspan='2' align="center"><input type="submit" class='btn btn-primary btn-sm' name="cari" value="Daftar"> <input type="button" class='btn btn-secondary btn-sm' onclick="history.back()" value="Batal"></td>
						</tr>
		
		
		<input type="hidden" name="idprogram" value="<?php echo $idprogram;?>">
		</form>
</table>


</div></div>




<?php
include(XOOPS_ROOT_PATH."/footer.php");
?>