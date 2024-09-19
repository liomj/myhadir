<?php 
	require("connection.php");
	session_start();
	error_reporting(0);
	
   //ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
   
  function strip_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
  }
  
  //echo $_SESSION['status'];
  
	  if($_SESSION['status']!='2') {
?>
			<script language="JavaScript">
				alert("You dont have permission!!");
				self.location ="index.php";
			</script>
<?php
} ?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sistem myHadir Hospital Beaufort">
    <meta name="author" content="Hospital Beaufort Sabah">
    <meta name="generator" content="PHP">
    <title>Peserta - Sistem myHadir Hospital Beaufort</title>
	<link rel="icon" href="favicon.ico">
	


   <!-- Bootstrap core CSS --> 
<link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/navbar-top-fixed.css" rel="stylesheet">
 <!-- Custom styles for this template -->
 <link href="assets/custom.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="assets/lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  </head>
  <body> 
  <?php 

   require('menu.php'); ?>
   
	<?php
    $idprogram = $_GET['id'];
    $query="SELECT * FROM myhadir_program WHERE idprogram = '$idprogram' AND idunit = ".$_SESSION['idunit']." " ;
    //echo $query;EXIT;
    $result=$GLOBALS['xoopsDB']->query($query);
	
if ($GLOBALS['xoopsDB']->getRowsNum($result)==0)  {
       header('Location:program-anjuran.php');
}

	
    $row =$GLOBALS['xoopsDB']->fetchArray($result);
	$namaprogram=$row['namaprogram'];
		$namaprogram = preg_replace( "/<br>|\n|<br( ?)\/>/", " ", $namaprogram );
		$anjuran=$row['anjuran'];
		$anjuran = preg_replace( "/<br>|\n|<br( ?)\/>/", " ", $anjuran );
		$tarikhmula=$row['tarikhmula'];
		$tarikhtamat=$row['tarikhtamat'];
		$tarikh_mula=date('d M Y',strtotime($tarikhmula));
$tarikh_tamat=date('d M Y',strtotime($tarikhtamat));	
		$waktu=$row['waktu'];
                $kuota=$row['kuotapeserta'];
		$tempat=$row['tempat'];
		$urusetia=$row['urusetia'];
$cpd=$row['cpd'];
					$cpdpoint=$row['cpdpoint'];
					$status=$row['status'];
					$catatan=$row['catatan'];
					$notelefon=$row['notelefon'];
					$idtemplate=$row['idtemplate'];
                $kuotapeserta=$row['kuotapeserta'];
	

	$resultpeserta = $GLOBALS['xoopsDB']->query("SELECT * FROM myhadir_peserta WHERE idprogram = '$idprogram'");
                $jumlahpeserta = $GLOBALS['xoopsDB']->getRowsNum($resultpeserta);

?>
   
<main class="container">
	
	<?php
	//echo $_SESSION['status'];
$loggedinuid=$_SESSION['username'];
 //if the Delete link is clicked
if (isset($_GET['del_peserta']))  {
$GLOBALS['xoopsDB']->query("DELETE from myhadir_peserta WHERE idpeserta='" . $_GET['del_peserta'] . "'");
$GLOBALS['xoopsDB']->query("INSERT INTO myhadir_log (idprogram,tindakan,tarikh,uid) VALUES  
('$idprogram','Hapus Peserta',CURRENT_TIMESTAMP,'$loggedinuid')");
echo "<div class='container'>";
echo "<div id='alert' class='alert alert-primary m-3 d-none' role='alert'>Peserta berjaya dihapuskan</div>";
echo "</div>";
	}


//check if posted using the update link
if (isset($_POST['kemaskini_peserta']))  {

//run the query to update the data
$curdate=date("Y-m-d");
$updatepeserta=$GLOBALS['xoopsDB']->query("UPDATE myhadir_peserta SET nama='" . strip_input(($_POST['nama'])) . "',mykad='" . strip_input(($_POST['mykad'])) . "',email='" . strip_input(($_POST['email'])) . "',idunit='" . strip_input(($_POST['idunit'])) . "',notel='087-212333',regdate='$curdate' where idpeserta='" . $_POST['idpeserta']."'"); 
if (!$updatepeserta) { // add this check.
    trigger_error($GLOBALS['xoopsDB']->error()); 
}
$GLOBALS['xoopsDB']->query("INSERT INTO myhadir_log (idprogram,tindakan,tarikh,uid) VALUES  ('$idprogram','Kemaskini Peserta',CURRENT_TIMESTAMP,'$loggedinuid')");
echo "<div class='container'>";
echo "<div id='alert' class='alert alert-primary m-3 d-none' role='alert'>Rekod berjaya dikemaskini</div>";
echo "</div>";
}

//check if the Edit link is clicked
if (isset($_GET['edit_peserta']))  {

//run the query to get the data
  $result2 = $GLOBALS['xoopsDB']->query("SELECT * FROM myhadir_peserta where idpeserta='" .  $_GET['edit_peserta'] . "'" );
$numrows = $GLOBALS['xoopsDB']->getRowsNum($result2);
if (!$result2) { // add this check.
    trigger_error($GLOBALS['xoopsDB']->error()); 
}

// check if records were returned
if ($numrows > 0) {

//display the form with the selected data
 while($row=$GLOBALS['xoopsDB']->fetchArray($result2))  
  { //do this while there's a record in the $result array
		$idpeserta=$row['idpeserta'];
		$nama=$row['nama'];
		$mykad=$row['mykad'];
		$email=$row['email'];
		$notel=$row['notel'];
        $idunit=$row['idunit'];
		$regdate=$row['regdate'];
?>

<form id='set1' role='form' method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?id=<?php echo $idprogram ?>">
<input type="hidden" name="idpeserta" value="<?php echo $idpeserta;?>">
	<table class='table table-striped table-hover'>
		<thead class='table-dark'>
                    <th colspan='2'> <b>Kemaskini Info Peserta : <?php echo $namaprogram ?></b></th>
		</thead>
		
						<tr>
							<td><b>Nama Penuh</b></td>
							<td> <input type="text" name="nama" class='form-control' size="55" value="<?php echo $nama;?>"></td>
						</tr>
                         <tr>
							<td><b>No myKad</b></td>
							<td> <input type="text" name="mykad" class='form-control' maxlength="12" value="<?php echo $mykad;?>" required>
							<span class="badge rounded-pill bg-danger">** Untuk tujuan Muat Turun E-Sijil </span>&nbsp;<span class="badge rounded-pill bg-dark">** Untuk Unit atau Organisasi sila masukkan hanya -</span>
							</td>
						</tr>
							<tr>
							<td><b>Email</b></td>
							<td> <input type="email" name="email" class='form-control' maxlength="100" value="<?php echo $email;?>">
							<span class="badge rounded-pill bg-danger">** Untuk tujuan penghantaran e-Sijil </span>
							</td>
						</tr>
						<!--<tr>
							<td><b>No Telefon/Ext</b></td>
							<td> <input type="text" name="notel" class='form-control' size="22" value="<?php echo $notel;?>"></td>
						</tr>-->
						<tr>
							<td><b>Unit</b></td>
							<td> 
							<?php   $sqlunit = "SELECT * FROM myhadir_unit ORDER BY idunit ASC";
                                                                $resultunit = $GLOBALS['xoopsDB']->query($sqlunit);
                                                        ?>
                                                        <select name="idunit" id='idunit' class='idunit form-select'>
								
                                                                <?php while($rowunit = $GLOBALS['xoopsDB']->fetchArray($resultunit))
                                                                    { 
																if ($idunit==$rowunit['idunit']){
																?>
																 <option value="<?PHP echo $rowunit["idunit"];?>" selected><?PHP echo $rowunit["namaunit"];?></option>
																<?php } else { ?>
																
                                                                 <option value="<?PHP echo $rowunit["idunit"];?>"><?PHP echo $rowunit["namaunit"];?></option>
																	<?php }} ?>
						    </select></td>
						
						
                             </tr>
                                                

						<tr>
							<td align='center' colspan='2'><button type='submit' name='kemaskini_peserta' class='btn btn-danger btn-sm'><i class='fa fa-save'></i> Kemaskini</button><input class='btn btn-sm btn-secondary' type="reset" name="cari" value="Reset"></td>
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
if (isset($_POST['daftar_peserta']))  {
	$idprogram=$GLOBALS['xoopsDB']->escape($_POST['idprogram']);
	$namapeserta=$GLOBALS['xoopsDB']->escape($_POST['namapeserta']);
	$mykad=$GLOBALS['xoopsDB']->escape($_POST['mykad']);
	$email=$GLOBALS['xoopsDB']->escape($_POST['email']);
	$notel=$GLOBALS['xoopsDB']->escape($_POST['notel']);
	$idunit=$GLOBALS['xoopsDB']->escape($_POST['idunit']);

$checkic="SELECT * FROM myhadir_peserta WHERE idprogram = '$idprogram' and mykad='$mykad'";
$result=$GLOBALS['xoopsDB']->query($checkic);
if($GLOBALS['xoopsDB']->getRowsNum($result)==0) { 
		$query1 ="INSERT INTO `myhadir_peserta` (`idpeserta` , `idprogram` , `nama`, `mykad`,`email`, `idunit`, `notel`, `regdate`, `status`) "; 
		$query1 .="VALUES (NULL, '$idprogram', '$namapeserta', '$mykad','$email', '$idunit', '087-212333', '".date('Y-m-d')."', 'Mohon')";
		$masuk2=$GLOBALS['xoopsDB']->query($query1);
if (!$masuk2) { // add this check.
    trigger_error($GLOBALS['xoopsDB']->error()); 
}
$GLOBALS['xoopsDB']->query("INSERT INTO myhadir_log (idprogram,tindakan,tarikh,uid) VALUES  ('$idprogram','Daftar Peserta',CURRENT_TIMESTAMP,'$loggedinuid')");
echo "<div class='container'>";
echo "<div id='alert' class='alert alert-primary m-3 d-none' role='alert'>Rekod Peserta berjaya didaftar</div>";
echo "</div>";
}
}

// check if the Add link is clicked
if (isset($_GET['add_peserta']))  {

//close the php to display the html form

?><form id='set1' role='form' method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?id=<?php echo $idprogram ?>">
 <table class='table table-striped table-hover table-border'>


	
	<thead class='table-dark'>
                    <th colspan='2'> <b>Pendaftaran Peserta : <?php echo $namaprogram ?></b></th>
		</thead>

					
						<tr>
							<td><b>Nama Penuh </b></td>
							<td> <input type="text" name="namapeserta" class="form-control" placeholder="Masukkan Nama Penuh" required></td>
						</tr>
						<tr>
							<td><b>No myKad</b>  </td>
							<td> <input type="text" name="mykad" maxlength="12" class="form-control" placeholder="Masukkan tanpa sengkang" required> 
							<span class="badge rounded-pill bg-danger">** Untuk tujuan Muat Turun E-Sijil </span>&nbsp;<span class="badge rounded-pill bg-dark">** Untuk Unit atau Organisasi sila masukkan hanya -</span>
							</td>
						</tr>
					   <tr>
							<td><b>Email</b>  </td>
							<td> <input type="email" name="email" maxlength="100" class="form-control" placeholder="Masukkan Email"> 
							<span class="badge rounded-pill bg-danger">** Untuk tujuan Penghantaran E-Sijil ke Email</span>
							</td>
						</tr>
						<tr>
							<td><b>Unit</b></td>
							<td> <div class="form-group">
							<select name='idunit' id='idunit' class='idunit form-select' required>
								<option value="">Sila Pilih</option>
									<?php
										$query6="SELECT DISTINCT * from myhadir_unit ORDER BY namaunit ASC" ;
										$result6=$GLOBALS['xoopsDB']->query($query6);	
									
										while ($row6 =$GLOBALS['xoopsDB']->fetchArray($result6)) 
										{
											echo "<option value='".$row6['idunit']."'>".$row6['namaunit']."</option>";
										}
                                                                                
                                                                               	?>
                                                                
                                                          
							</select>
                              </div>                              
							</td>
						</tr>
				       <!-- <tr>
							<td><b>No.Tel/Ext</b></td>
							<td> <input type="text" name="notel" class="form-control" placeholder="Masukkan No Telefon" required></td>
						</tr>-->
						<tr>
							<td colspan='2' align="center"><button type='submit' name='daftar_peserta' class='btn btn-danger btn-sm'><i class='fa fa-save'></i> Daftar</button> <input type="button" class='btn btn-secondary btn-sm' onclick="history.back()" value="Batal"></td>
						</tr>
		
		
	<input type="hidden" name="idprogram" value="<?php echo $idprogram;?>">
</table>

<?php

echo "</form>";

}  //closing the if statement
$namaprogram=$row['namaprogram'];
$namaprogram = preg_replace( "/<br>|\n|<br( ?)\/>/", " ", $namaprogram );

?>


  <div class="p-5 rounded bg-light">
    <h2><?php echo $namaprogram;?></h2>
    <p class="lead">Senarai Peserta <?php echo $namaprogram;?>
	
					<table class='table'>
						<tr>
							<td><b>Tarikh</b></td>
							<td>: <?php 
							
							$tarikh_mula=date('d M Y',strtotime($tarikhmula));
$tarikh_tamat=date('d M Y',strtotime($tarikhtamat));	
if($tarikhmula==$tarikhtamat)

echo "$tarikh_mula <br><span class='badge bg-secondary'>$waktu </span>";	
else
echo "$tarikh_mula - $tarikh_tamat <br><span class='badge bg-secondary'>$waktu</span>";
							
							?></td>
						</tr>
						
                        
						
						<tr>
							<td><b>Tempat</b></td>
							<td>: <?php echo $tempat;?></td>
						</tr>
						<tr>
							<td><b>Anjuran</b></td>
							<td>: <?php echo $anjuran;?></td>
						</tr>
						<tr>
							<td><b>Urusetia</b></td>
							<td>: <?php echo $urusetia;?></td>
						</tr> 
						<tr>
							<td><b>Kuota Peserta</b></td>
							<td>: <?php echo $kuotapeserta;?></td>
						</tr>
						<tr>
							<td><b>Jumlah Peserta</b></td>
							<td>: <?php echo $jumlahpeserta;?></td>
						</tr>
					<tr>
							<td><b>CPD Point</b></td>
							<td>: <?php if ($cpd!='' AND $cpdpoint!=''){echo "$cpd : $cpdpoint";} else {echo "N/A";} echo "</td>"; ?>
						</tr>
												<tr>
							<td><b>Nama Urusetia</b></td>
							<td>: <?php if ($urusetia!=''){echo $urusetia;} else {echo "N/A";} echo "</td>"?>
						</tr>
                                               <!-- <tr>
							<td><b>No Telefon/Ext</b></td>
							<td>: <?php if ($notelefon!=''){echo $notelefon;} else {echo "N/A";} echo "</td>"; ?>
						</tr>-->
						
                                                <tr>
							<td><b>Catatan</b></td>
							<td>: <?php if ($catatan!=''){echo $catatan;} else {echo "N/A";} echo "</td>"; ?>
						</tr>
<?php
	$checktemplate="SELECT * from myhadir_template WHERE idtemplate='$idtemplate'" ;
										$resulttemplate=$GLOBALS['xoopsDB']->query($checktemplate);	
										$rowtemplate = $GLOBALS['xoopsDB']->fetchArray($resulttemplate);
										$namatemplate=$rowtemplate['namatemplate'];

                      echo "<tr>
							<td><b>Template Sijil</b></td>
							<td>: $namatemplate</td>
						</tr>";


						echo "<tr>
							<td><b>Status</b></td>
							<td>: ";

							$curdate=date("Y-m-d");
							if($status=='Open')
                              {
                                 
                                    if($tarikhmula < $curdate OR $jumlahpeserta > $kuotapeserta)
									{ 
									 echo "<span class='badge bg-danger'>Tutup</span>";
									 }
									 else
									 echo "<span class='badge bg-success'>Buka</span>&nbsp;";
										  }
							  else
								  
									 { 
									 echo "<span class='label label-success'>Tutup</span>";
									 }


							echo "</td>
						</tr>"; ?>

					</table>
		
	 <a class='btn btn-secondary btn-sm text-white' target="_blank" href="cetak-peserta.php?id=<?php echo $row['idprogram'];?>"><i class='fa fa-print'></i> Cetak Senarai Peserta</a> 
 <?php
 echo "<a href='" . htmlspecialchars("$_SERVER[PHP_SELF]") . "?id=$idprogram&add_peserta=1' class='btn btn-primary btn-sm text-white'><i class='fa fa-plus'></i> Daftar Peserta</a>"; ?>
	</p>
  </div>
<?php

	$querysijil="SELECT a.idpeserta,a.mykad,a.email,a.nama,a.kehadiran,a.idunit,b.idunit,b.namaunit FROM myhadir_peserta a,myhadir_unit b 
	WHERE idprogram = '$idprogram' AND a.idunit =  b.idunit ORDER BY a.idpeserta DESC";
    $resultsijil=$GLOBALS['xoopsDB']->query($querysijil);

?>
<table id='peserta' class='table table-striped table-border'>

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
			  <td><?php echo $row['namaunit'];?></td>
			  
                          <td>
						  
						  <?php
						  
						   echo "<a href='" . htmlspecialchars("$_SERVER[PHP_SELF]") . "?id=$idprogram&edit_peserta=" . $row['idpeserta'] . "'><button type='button' class='btn btn-success btn-sm'> <i class='fa fa-pencil-square' title='Kemaskini'></i></button></a>"; 							  
							  echo "<a href=\"" . htmlspecialchars("$_SERVER[PHP_SELF]") . "?id=$idprogram&del_peserta=".$row['idpeserta']."\"onclick=
      \"return confirm('Adakah anda pasti untuk hapus?')\"> <button type='button' class='btn btn-danger btn-sm'> <i class='fa fa-trash' title='Hapus'></i></button></a></a> ";	
	 ?>
						  
                          </td></tr> 
                         	 	
                        <?php
				
			}
                        ?>

                  </table>
		  
           
</form>
  
  
</main>


  <?php require('footer.php'); ?>



    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>
	     <!-- Bootstrap core JavaScript -->
	<link rel="stylesheet" type="text/css" href="assets/lib/datatables/datatables.min.css"/>
	<script src="assets/lib/jquery/jquery.min.js"></script>
	<script src="assets/lib/validate/js/jquery.validate.js" type="text/javascript"></script>
    <script src="assets/lib/validate/js/jquery.form.js" type="text/javascript"></script>
	
	<script src="assets/lib/datatables/datatables.min.js"></script>
  
	<script>
	jQuery(document).ready(function() {
    jQuery('#peserta').DataTable( {
    "displayLength": 1000,
	"ordering": false,
    "bPaginate": true,
    "bLengthChange": false,
    "bFilter": true,
    "bInfo": true,
   
    } );
} );
	</script>
			<script>
//bootstrap alert
  $('#alert').removeClass('d-none');
  
  setTimeout(() => {
    $('.alert').alert('close');
  }, 8000); //3 seconds

</script>
<link href="assets/lib/select2/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="assets/lib/select2/select2-bootstrap-5-theme.min.css" /><script src="assets/lib/select2/select2.min.js"></script>

<script type="text/javascript">
  var jQuery =$.noConflict(true);
  </script> 
<script type="text/javascript">
jQuery(document).ready(function() {
  jQuery(".idunit").select2( { theme: 'bootstrap-5',width:'100%'} );
});
</script>
	


  <noscript><meta http-equiv="Refresh" content="0; url='error.php'" /></noscript></body>
</html>

<?php ?>
