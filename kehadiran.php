<?php
//  Author: Lionel Michael Jominin
//  URL: https://jknsabah.moh.gov.my/hbeaufort/
//  E-Mail: lionel.m@moh.gov.my


include("../../mainfile.php");
include(XOOPS_ROOT_PATH."/header.php");
$meta_keywords = "sistem,myHadir";
$meta_description = "Sistem Pengurusan Kehadiran Program";
$pagetitle = "Peserta Program - Sistem myHadir";

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
global $xoopsUser; 

//get current user id  
$loggedinuid = is_object($xoopsUser) ? $xoopsUser->getVar('uid') : 0;  


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

echo "<div> <a class='btn btn-secondary btn-sm  text-white' target='_blank' href='cetak-kehadiran.php?id=$idprogram'><i class='fa fa-print'></i> Cetak Kehadiran</a>&nbsp;";
 
 echo "<a href='" . htmlspecialchars("$_SERVER[PHP_SELF]") . "?id=$idprogram&add_kehadiran=1' class='btn btn-primary btn-sm text-white'><i class='fa fa-plus'></i> 
 Daftar Peserta</a></div><br><br>"; 
 
 
	
	$resultkehadiran = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_kehadiran")." WHERE idprogram = '$idprogram'");
                $jumlahkehadiran = $GLOBALS['xoopsDB']->getRowsNum($resultkehadiran);


?>
 	
	<?php
	if (isset($_GET['del_kehadiran']))  {
$GLOBALS['xoopsDB']->queryF("DELETE from ".$GLOBALS['xoopsDB']->prefix("myhadir_kehadiran")." WHERE id='" . $_GET['del_kehadiran'] . "'");
$GLOBALS['xoopsDB']->queryF("INSERT INTO ".$GLOBALS['xoopsDB']->prefix("myhadir_log")." (tindakan,tarikh,uid) VALUES  
('Hapus Peserta',CURRENT_TIMESTAMP,'$loggedinuid')");
//redirect_header("kehadiran.php?id=$idprogram", 2, 'Kehadiran berjaya dihapuskan'); 
   //exit(); 
	}


//check if posted using the update link
if (isset($_POST['kemaskini_kehadiran']))  {

//run the query to update the data
$curdate=date("Y-m-d");
$updatekehadiran=$GLOBALS['xoopsDB']->query("UPDATE ".$GLOBALS['xoopsDB']->prefix("myhadir_kehadiran")." SET 
nama='" . test_input(($_POST['nama'])) . "',
mykad='" . test_input(($_POST['mykad'])) . "',
email='" . test_input(($_POST['email'])) . "',
idunit='" . test_input(($_POST['idunit'])) . "'

where id='" . $_POST['id']."'"); 

if (!$updatekehadiran) { // add this check.
   trigger_error($GLOBALS['xoopsDB']->error()); 
}
$GLOBALS['xoopsDB']->query("INSERT INTO ".$GLOBALS['xoopsDB']->prefix("myhadir_log")." (idprogram,tindakan,tarikh,uid) VALUES  ('$idprogram','Kemaskini Peserta',CURRENT_TIMESTAMP,'$loggedinuid')");

//redirect_header("kehadiran.php?id='$idprogram'", 2, 'Rekod kehadiran berjaya dikemaskini'); 
  //  exit(); 
}

//check if the Edit link is clicked
if (isset($_GET['edit_kehadiran']))  {

//run the query to get the data
  $result2 = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_kehadiran")." where id='" .  $_GET['edit_kehadiran'] . "'" );
$numrows = $GLOBALS['xoopsDB']->getRowsNum($result2);
if (!$result2) { // add this check.
   trigger_error($GLOBALS['xoopsDB']->error()); 
}

// check if records were returned
if ($numrows > 0) {

//display the form with the selected data
 while($row=$GLOBALS['xoopsDB']->fetchArray($result2))  
  { //do this while there's a record in the $result array
		$idkehadiran=$row['id'];
		$nama=$row['nama'];
		$mykad=$row['mykad'];
		$email=$row['email'];
		$notel=$row['notel'];
        $idunit=$row['idunit'];
		$regdate=$row['regdate'];
?>

<form id='set1' role='form' method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?id=<?php echo $idprogram ?>">
<input type="hidden" name="id" value="<?php echo $idkehadiran;?>">
	<table class='table table-striped table-hover'>
		<thead class='table-dark'>
                    <th colspan='2'> <b>Kemaskini Info Peserta : <?php echo $namaprogram ?></b></th>
		</thead>
						<tr>
							<td><b>Nama Penuh</b></td>
							<td> <input type="text" name="nama" class='form-control' size="55" value="<?php echo $nama;?>"></td>
						</tr>
                         <tr>
							<td><b>No MyKad</b></td>
							<td> <input type="text" name="mykad" class='form-control' maxlength="12" value="<?php echo $mykad;?>" required>
							</td>
						</tr>
						<tr>
							<td><b>Email</b></td>
							<td> <input type="email" name="email" class='form-control' maxlength="100" value="<?php echo $email;?>">
							</td>
						</tr>
						<!--<tr>
							<td><b>No Telefon/Ext</b></td>
							<td> <input type="text" name="notel" class='form-control' size="22" value="<?php echo $notel;?>"></td>
						</tr>-->
						<tr>
							<td><b>Unit</b></td>
							<td> 
							<?php   $sqlunit = "SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_unit")." ORDER BY idunit ASC";
                                                                $resultunit = $GLOBALS['xoopsDB']->query($sqlunit);
                                                        ?>
                                                        <select name="idunit" id='idunit' class='idunit form-select'>
								
                                                                <?php while($rowunit = $GLOBALS['xoopsDB']->fetchArray($resultunit))
                                                                    { 
																if ($idunit==$rowunit['idunit']){
																?>
																 <option value="<?PHP echo $rowunit["idunit"];?>" selected><?PHP echo $rowunit["unit"];?></option>
																<?php } else { ?>
																
                                                                 <option value="<?PHP echo $rowunit["idunit"];?>"><?PHP echo $rowunit["unit"];?></option>
																	<?php }} ?>
						    </select></td>
						
						
                             </tr>
                                                

						<tr>
							<td align='center' colspan='2'><button type='submit' name='kemaskini_kehadiran' class='btn btn-danger btn-sm'><i class='fa fa-save'></i> Kemaskini</button> <input class='btn btn-sm btn-secondary' type="reset" name="cari" value="Reset"></td>
						</tr>
		</table></form>	
<?php
}  //close the while for every data


// once processing is complete
// free result set



} else {
	echo "<div class='alert alert-info'>Rekod ID tersebut tidak wujud</div>";
	


}

}


	
//if posted using add
if (isset($_POST['daftar_kehadiran']))  {
	$idprogram=$GLOBALS['xoopsDB']->escape($_POST['idprogram']);
	$namakehadiran=$GLOBALS['xoopsDB']->escape($_POST['namakehadiran']);
	$mykad=$GLOBALS['xoopsDB']->escape($_POST['mykad']);
	$email=$GLOBALS['xoopsDB']->escape($_POST['email']);
	//$notel=$GLOBALS['xoopsDB']->escape($_POST['notel']);
	$notel='087-212333';
	$idunit=$GLOBALS['xoopsDB']->escape($_POST['idunit']);
$checkic="SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_kehadiran")." WHERE idprogram = '$idprogram' and mykad='$mykad'";
$result=$GLOBALS['xoopsDB']->query($checkic);
if($GLOBALS['xoopsDB']->getRowsNum($result)==0) { 

$query1 ="INSERT INTO `".$GLOBALS['xoopsDB']->prefix("myhadir_kehadiran")."` (`id` , `idprogram` , `nama`, `mykad`,`email`,`idunit`) "; 
$query1 .="VALUES (NULL, '$idprogram', '$namakehadiran', '$mykad','$email', '$idunit')";
$masuk2=$GLOBALS['xoopsDB']->query($query1);
		//echo PHP_EOL . $query1 . PHP_EOL;
       // exit;	
if (!$masuk2) { // add this check.
   trigger_error($GLOBALS['xoopsDB']->error()); 
}
$GLOBALS['xoopsDB']->query("INSERT INTO ".$GLOBALS['xoopsDB']->prefix("myhadir_log")." (tindakan,tarikh,uid) VALUES  ('Daftar Peserta',CURRENT_TIMESTAMP,'$loggedinuid')");

//redirect_header("kehadiran.php?id='$idprogram'", 2, 'Kehadiran telah berjaya didaftarkan'); 
//exit(); 
}
}

// check if the Add link is clicked
if (isset($_GET['add_kehadiran']))  {

//close the php to display the html form

?><form id='set1' role='form' method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?id=<?php echo $idprogram ?>">
 <table class='table table-striped table-hover table-border'>

<thead class='table-dark'>
                    <th colspan='2'> <b>Pendaftaran Peserta : <?php echo $namaprogram ?></b></th>
		</thead>

					
						<tr>
							<td><b>Nama Penuh </b></td>
							<td> <input type="text" name="namakehadiran" class="form-control" placeholder="Masukkan Nama Penuh" required></td>
						</tr>
						<tr>
							<td><b>No myKad</b>  </td>
							<td> <input type="text" name="mykad" maxlength="12" class="form-control" placeholder="Masukkan tanpa sengkang" required> 
							</td>
						</tr>
						<tr>
							<td><b>Email</b>  </td>
							<td> <input type="email" name="email" maxlength="100" class="form-control" placeholder="Masukkan Email"> 
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
				        <!--<tr>
							<td><b>No.Tel/Ext</b></td>
							<td> <input type="text" name="notel" class="form-control" placeholder="Masukkan No Telefon" required></td>
						</tr>-->
						<tr>
							<td colspan='2' align="center"><button type='submit' name='daftar_kehadiran' class='btn btn-danger btn-sm'><i class='fa fa-save'></i> Daftar</button> <input type="button" class='btn btn-secondary btn-sm' onclick="history.back()" value="Batal"></td>
						</tr>
		
		
	<input type="hidden" name="idprogram" value="<?php echo $idprogram;?>">
</table>

<?php

echo "</form>";

}  //closing the if statement
?>
  


<?php
	$querysijil="SELECT a.id,a.idprogram,a.mykad,a.nama,a.email,a.kehadiran,a.idunit,b.idunit,b.unit FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_kehadiran")." a,
	".$GLOBALS['xoopsDB']->prefix("myhadir_unit")." b 
	WHERE idprogram = '$idprogram' AND a.idunit =  b.idunit ORDER BY a.id DESC";
    //echo $query;EXIT;
    $resultsijil=$GLOBALS['xoopsDB']->query($querysijil);

?>
<table id='standard' class='table table-striped table-border'>

    <thead class='table-dark'>
<tr>
         <th><strong>Nama Penuh Peserta</strong></th>
		 <th><strong>No MyKad</strong></th>
		 <th><strong>Email</strong></th>
		 <th><strong>Unit</strong></th>
         <th><strong>Tindakan</strong></th>
           
</tr>
</thead><tbody>
<?php


		
			while ($row =$GLOBALS['xoopsDB']->fetchArray($resultsijil)) 
			{
                      ?>
                          <tr>
			 
			  <td><?php echo $row['nama'];?></td>
			  <td><?php echo $row['mykad'];?></td>
			   <td><?php 
			   if ($row['email']!='')
			   echo $row['email'];
			   else
			   echo "N/A";
			   ?></td>
			  
			  <td><?php echo $row['unit'];?></td>
			  
                          <td>
						  
						  <?php
	echo "<a href='" . htmlspecialchars("$_SERVER[PHP_SELF]") . "?id=$idprogram&edit_kehadiran=" . $row['id'] . "'><button type='button' class='btn btn-success btn-sm'> <i class='fa fa-edit' title='Kemaskini'></i></button></a>"; 							  
							  echo "<a href=\"" . htmlspecialchars("$_SERVER[PHP_SELF]") . "?id=$idprogram&del_kehadiran=".$row['id']."\"onclick=
      \"return confirm('Adakah anda pasti untuk hapus?')\"> <button type='button' class='btn btn-danger btn-sm'> <i class='fa fa-trash' title='Hapus'></i></button></a></a> ";	
	 ?>
						  
                          </td></tr> 
                         	 	
                        <?php
				
			}
                        ?>

                  </table>
		  
           
</form>
  
  




</div></div>




<?php
include(XOOPS_ROOT_PATH."/footer.php");
?>