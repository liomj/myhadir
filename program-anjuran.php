<?php 
	require("connection.php");
	session_start();
	error_reporting(0);
	
	$monthsDaysEn = array('January','February','March','April','May','June','July','August','September','October','November','December'); //populate with all months/days you want translated
$monthsDaysMy = array('Januari','Februari','Mac','April','Mei','Jun','Julai','Ogos','September','Oktober','November','Disember'); //populate with all months/days you want translated

	
//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
  	  if($_SESSION['status']!='2') {
?>
			<script language="JavaScript">
				alert("You dont have permission!!");
				self.location ="index.php";
			</script>
<?php
} 

$query="SELECT * FROM myhadir_unit WHERE idunit = ".$_SESSION['idunit']." " ;
    $result=$GLOBALS['xoopsDB']->query($query);
    $row =$GLOBALS['xoopsDB']->fetchArray($result);
	$queryunit="SELECT * FROM myhadir_program WHERE idunit = ".$_SESSION['idunit']." " ;
    $result2=$GLOBALS['xoopsDB']->query($queryunit);
	$jumlahkursusunit = $GLOBALS['xoopsDB']->getRowsNum($result2);
	
	
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sistem myHadir Hospital Beaufort">
    <meta name="author" content="Hospital Beaufort Sabah">
    <meta name="generator" content="PHP">
    <title>Senarai Program - Sistem myHadir Hospital Beaufort</title>
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
   
    <?php require('menu.php'); ?>
	
   
<main class="container">
  <div class="p-5 rounded bg-light">
    <h2>Senarai Program <?php echo $row['namaunit']?></h2>
    <p class="lead">Senarai program yang didaftarkan dalam Sistem myHadir Hospital Beaufort oleh <span style='text-transform:uppercase'><b><?php echo $row['namaunit']?></b></span> </p>
			  
			  	 <form method="post" name="form" action="laporan-unit-all.php">
			  <?php  
	  $idunit=$_SESSION['idunit'] ?>
			
			  <input type="hidden" name='idunit' value="<?php echo $idunit?>">
			 <br><a href="?add_sijil=1" class='btn btn-primary btn-sm text-white'><i class='fa fa-plus'></i> Daftar Rekod Program</a>
			 <?php if($jumlahkursusunit!='') { ?>
			 <button type='submit' class='btn btn-danger btn-sm' target='blank'><i class='fa fa-print'></i> Cetak Laporan Unit</button>
			 <?php } ?>
				</form>
			  
  </div>
</main>

<main class="container">
<?php
$loggedinuid=$_SESSION['username'];

if (isset($_GET['set_open']))  {
$GLOBALS['xoopsDB']->query("UPDATE `myhadir_program` SET `status` = 'Open' WHERE idprogram='" . $_GET['set_open'] . "'");
$GLOBALS['xoopsDB']->query("INSERT INTO myhadir_log (idprogram,tindakan,tarikh,uid) VALUES  
('$idprogram','Buka pendaftaran program',CURRENT_TIMESTAMP,'$loggedinuid')");
echo "<div class='container'>";
echo "<div id='alert' class='alert alert-primary m-3 d-none' role='alert'>Program berjaya dibuka</div>";
echo "</div>";
	}

if (isset($_GET['set_close']))  {
$GLOBALS['xoopsDB']->query("UPDATE `myhadir_program` SET `status` = 'Closed' WHERE idprogram='" . $_GET['set_close'] . "'");
$GLOBALS['xoopsDB']->query("INSERT INTO myhadir_log (idprogram,tindakan,tarikh,uid) VALUES  
('$idprogram','Tutup pendaftaran program',CURRENT_TIMESTAMP,'$loggedinuid')");
echo "<div class='container'>";
echo "<div id='alert' class='alert alert-primary m-3 d-none' role='alert'>Program berjaya ditutup</div>";
echo "</div>";
	}


 //if the Delete link is clicked
if (isset($_GET['del_sijil']))  {
$GLOBALS['xoopsDB']->query("DELETE from myhadir_program WHERE idprogram='" . $_GET['del_sijil'] . "' AND idunit = ".$_SESSION['idunit']." ");
$GLOBALS['xoopsDB']->query("DELETE from myhadir_peserta WHERE idprogram='" . $_GET['del_sijil'] . "'");
$GLOBALS['xoopsDB']->query("INSERT INTO myhadir_log (idprogram,tindakan,tarikh,uid) VALUES  
('$idprogram','Hapus Program',CURRENT_TIMESTAMP,'$loggedinuid')");
echo "<div class='container'>";
echo "<div id='alert' class='alert alert-primary m-3 d-none' role='alert'>Program berjaya dihapuskan</div>";
echo "</div>";
	}


//check if posted using the update link
if (isset($_POST['kemaskini_sijil']))  {

//run the query to update the data
$idprogram=$GLOBALS['xoopsDB']->escape($_POST['idprogram']);
            $namaprogram=$GLOBALS['xoopsDB']->escape($_POST['namaprogram']);
            $tarikhmula=$GLOBALS['xoopsDB']->escape($_POST['tarikhmula']);
            $tarikhtamat=$GLOBALS['xoopsDB']->escape($_POST['tarikhtamat']);
            $waktu=$GLOBALS['xoopsDB']->escape($_POST['waktu']);
            $kuotapeserta=$GLOBALS['xoopsDB']->escape($_POST['kuotapeserta']);
            $tempat=$GLOBALS['xoopsDB']->escape($_POST['tempat']);
            $catatan=$GLOBALS['xoopsDB']->escape($_POST['catatan']);
            $anjuran=$GLOBALS['xoopsDB']->escape($_POST['anjuran']);
            $urusetia=$GLOBALS['xoopsDB']->escape($_POST['urusetia']);
            $notel=$GLOBALS['xoopsDB']->escape($_POST['notel']);
            $cpd=$GLOBALS['xoopsDB']->escape($_POST['cpd']);
            $cpdpoint=$GLOBALS['xoopsDB']->escape($_POST['cpdpoint']);
			$idtemplate=$GLOBALS['xoopsDB']->escape($_POST['idtemplate']);
        
    		$GLOBALS['xoopsDB']->query("UPDATE myhadir_program SET namaprogram='$namaprogram', 
					tarikhmula = '$tarikhmula',
					tarikhtamat = '$tarikhtamat',
					kuotapeserta = '$kuotapeserta', 
					waktu = '$waktu', 
					tempat = '$tempat',
					anjuran = '$anjuran',
					urusetia = '$urusetia',
					catatan = '$catatan',
                                        notelefon = '$notel',
                                        cpd = '$cpd',
                                        cpdpoint = '$cpdpoint',
										idtemplate = '$idtemplate'
					WHERE idprogram = '$idprogram' AND idunit = ".$_SESSION['idunit']." ");
$GLOBALS['xoopsDB']->query("INSERT INTO myhadir_log (idprogram,tindakan,tarikh,uid) VALUES  ('Kemaskini Program',CURRENT_TIMESTAMP,'$loggedinuid')");
echo "<div class='container'>";
echo "<div id='alert' class='alert alert-primary m-3 d-none' role='alert'>Rekod Program berjaya dikemaskini</div>";
echo "</div>";
}

//check if the Edit link is clicked
if (isset($_GET['edit_sijil']))  {

//run the query to get the data
  $result2 = $GLOBALS['xoopsDB']->query("SELECT * FROM myhadir_program where idprogram='" .  $_GET['edit_sijil'] . "' AND idunit = ".$_SESSION['idunit']." " );
$numrows = $GLOBALS['xoopsDB']->getRowsNum($result2);
if (!$result2) { // add this check.
    trigger_error($GLOBALS['xoopsDB']->error()); 
}

// check if records were returned
if ($numrows > 0) {

//display the form with the selected data
 while($row=$GLOBALS['xoopsDB']->fetchArray($result2))  
  { //do this while there's a record in the $result array

		$namaprogram=$row['namaprogram'];
		$tarikhmula=$row['tarikhmula'];
		$tarikhtamat=$row['tarikhtamat'];
		$waktu=$row['waktu'];
                $kuotapeserta=$row['kuotapeserta'];
		$tempat=$row['tempat'];
                $catatan=$row['catatan'];
                $anjuran=$row['anjuran'];
                $urusetia=$row['urusetia'];
                $notel=$row['notelefon'];
                $cpd=$row['cpd'];
                $cpdpoint=$row['cpdpoint'];
				$idtemplate=$row['idtemplate'];
				
?><form id='set1' role='form' method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"><?php
echo "<input type=\"hidden\" name=\"idprogram\" value= " . $row['idprogram']. ">";
?> <table class='table table-striped'>
	<thead class='table-dark'><tr>
	  <th colspan='2'>
		<strong>Pengemaskinian Maklumat Program</strong>
		 </th></tr></thead>
						<tr>
							<td><b>Nama Program</b></td>
							<td> <input class='form-control' type="text" name="namaprogram" placeholder="Masukkan Nama Program" value="<?php echo $namaprogram;?>" required>
							** <small>Taip <?php echo htmlspecialchars('<br>');?> untuk membuat baris baru sekiranya terlalu panjang. <br/>Contoh Unit Kualiti <?php echo htmlspecialchars('<br>');?> & Jabatan Kecemasan & Trauma
							<br>Pastikan tiada space dihujung teks.
							</small></td>
							
						</tr>
						<tr>
							<td><b>Tarikh Mula</b></td>
                                                        <td> <input class='form-control' type="date" name="tarikhmula" min="01/01/2022" max="31/12/2050" value="<?php echo $tarikhmula;?>" required></td>
						</tr>
                                                <tr>
							<td><b>Tarikh Tamat</b></td>
                                                        <td> <input class='form-control' type="date" name="tarikhtamat" min="01/01/2022" max="31/12/2050" value="<?php echo $tarikhtamat;?>" required></td>
						</tr>
                                                <tr>
							<td><b>Kuota Peserta</b></td>
							<td> <input class='form-control' type="text" name="kuotapeserta" placeholder="Masukkan Jumlah Kuota Peserta yang boleh mendaftar" value="<?php echo $kuotapeserta;?>" required></td>
						</tr>
						<tr>
							<td><b>Masa</b></td>
							<?php $sqlwaktu = "SELECT * FROM myhadir_waktu ORDER BY idwaktu ASC";
                                                        $resultwaktu = $GLOBALS['xoopsDB']->query($sqlwaktu);
                                                        ?>
                                                   
							<td> 
                                                                <select name="waktu" id="waktu" class='form-select'>
																<option value="">Sila Pilih</option>
                                                                <?php while($row = $GLOBALS['xoopsDB']->fetchArray($resultwaktu))
                                                                { 
															if ($waktu==$row["waktu"]){
															?>
															
															    <option selected="selected" value="<?PHP echo $row["waktu"];?>"><?PHP echo $row["waktu"];?></option>
															<?php } else { ?>
																
																<option value="<?PHP echo $row["waktu"];?>"><?PHP echo $row["waktu"];?></option>
																
																
															<?php } } ?>
						    </select></td>
						
						<tr>
							<td><b>Tempat</b></td>
							<td>
                                                        <input class='form-control' type="text" name="tempat" placeholder="Masukkan Lokasi Program" value="<?php echo $tempat;?>" required>

                                                            
                                                    </td>
                                                <tr>
							<td><b>Anjuran</b></td>
                                                        <td> <input class='form-control' type="text" name="anjuran" value="<?php echo $anjuran;?>" required>
														
														** <small>Taip <?php echo htmlspecialchars('<br>');?> untuk membuat baris baru sekiranya terlalu panjang. </small></td>
						</tr>        
						<tr>
							<td><b>Nama Urusetia</b></td>
							<td> <input class='form-control' type="text" name="urusetia" placeholder="Masukkan Nama Urusetia" value="<?php echo $urusetia;?>" required></td>
						</tr>
                                                <tr>
							<td><b>No Telefon/Ext</b></td>
							<td> <input class='form-control' type="text" name="notel" placeholder="Masukkan No Tel atau Ext yang boleh dihubungi" value="<?php echo $notel;?>" required></td>
						</tr>
                                                <tr>
							<td><b>Catatan</b></td>
                                                        <td> <textarea name="catatan" class='form-control' placeholder="Catatan"><?php echo $catatan;?></textarea></td>
						</tr>
                                                <tr>
							<td><b>Kod CPD</b></td>
                                                        <?php $sqlcpd = "SELECT * FROM myhadir_cpd ORDER BY cpdid ASC";
                                                        $resultcpd = $GLOBALS['xoopsDB']->query($sqlcpd);
                                                        ?>
                                                   
							<td> 
                                                                <select name="cpd" id="cpd" class='form-select'>
																<option value="">N/A</option>
                                                                <?php while($row = $GLOBALS['xoopsDB']->fetchArray($resultcpd))
                                                                { 
															if ($cpd==$row["cpdcode"]){
															?>
															
															    <option selected="selected" value="<?php echo $row["cpdcode"];?>"><?php echo $row["cpdcode"];?>-<?php echo $row["cpdname"];?></option>
															<?php } else { ?>
																
																<option value="<?php echo $row["cpdcode"];?>"><?php echo $row["cpdcode"];?>-<?php echo $row["cpdname"];?></option>
																
																
															<?php } } ?>
                                                        </select></td>
						</tr>
                                                <tr>
							<td><b>CPD Point</b></td>
							<td> <input class='form-control' type="number" name="cpdpoint" placeholder="Masukkan CPD Point" value="<?php echo $cpdpoint;?>"></td>
						</tr>
						
						          <tr>
							<td><b>Template Sijil</b></td>
                                                        <?php $sqltemplate = "SELECT * FROM myhadir_template ORDER BY idtemplate ASC";
                                                        $resulttemplate = $GLOBALS['xoopsDB']->query($sqltemplate);
                                                        ?>
                                                   
							<td> 
                                                                <select name="idtemplate" id="idtemplate" class='form-select' required>
																
                                                                <?php while($row = $GLOBALS['xoopsDB']->fetchArray($resulttemplate))
                                                                { 
															if ($idtemplate==$row["idtemplate"]){
															?>
															
															    <option selected="selected" value="<?php echo $row["idtemplate"];?>"><?php echo $row["namatemplate"];?></option>
															<?php } else { ?>
																
																<option value="<?php echo $row["idtemplate"];?>"><?php echo $row["namatemplate"];?></option>
																
																
															<?php } } ?>
                                                        </select></td>
						</tr>
                                                
		
						<tr>
							<td colspan=2 align="center"><button class='btn btn-primary btn-sm' type="submit" name='kemaskini_sijil'><i class="fa fa-save"></i> Kemaskini</button></td>
						</tr>
		</table>	
<?php echo "</form>";
}  //close the while for every data


// once processing is complete
// free result set



} else {
	echo "<div class='alert alert-info'>Rekod ID tersebut tidak wujud</div>";

}

}


	
//if posted using add
if (isset($_POST['daftar_sijil']))  {
		$namaprogram=$GLOBALS['xoopsDB']->escape($_POST['namaprogram']);
	$tarikh_mula=$GLOBALS['xoopsDB']->escape($_POST['tarikhmula']);
        $tarikh_tamat=$GLOBALS['xoopsDB']->escape($_POST['tarikhtamat']);
        $kuotapeserta=$GLOBALS['xoopsDB']->escape($_POST['kuotapeserta']);
	$waktu=$GLOBALS['xoopsDB']->escape($_POST['waktu']);
	$tempat=$GLOBALS['xoopsDB']->escape($_POST['tempat']);
        $anjuran=$GLOBALS['xoopsDB']->escape($_POST['anjuran']);
	$urusetia=$GLOBALS['xoopsDB']->escape($_POST['urusetia']);
        $notel=$GLOBALS['xoopsDB']->escape($_POST['notel']);
        $catatan=$GLOBALS['xoopsDB']->escape($_POST['catatan']);
        $cpd=$GLOBALS['xoopsDB']->escape($_POST['cpd']);
        $cpdpoint=$GLOBALS['xoopsDB']->escape($_POST['cpdpoint']);
				$idtemplate=$GLOBALS['xoopsDB']->escape($_POST['idtemplate']);
		
		$query1 ="INSERT INTO `myhadir_program` (`idprogram` , `namaprogram`, `tarikhmula`, `tarikhtamat`,`kuotapeserta`, `waktu`, `tempat`, `anjuran`, `urusetia`,  `status`, `regdate`, `idunit`, `catatan`, `notelefon`, `cpd`, `cpdpoint`,`idtemplate`) "; 
		$query1 .="VALUES (NULL, '$namaprogram', '$tarikh_mula', '$tarikh_tamat','$kuotapeserta', '$waktu', '$tempat', '$anjuran', '$urusetia',  'Open', '".date('Y-m-d')."','".$_SESSION['idunit']."', '$catatan', '$notel', '$cpd', '$cpdpoint','$idtemplate')";
		//echo $query1;
		$masuk2=$GLOBALS['xoopsDB']->query($query1);
if (!$masuk2) { // add this check.
    trigger_error($GLOBALS['xoopsDB']->error()); 
}
$GLOBALS['xoopsDB']->query("INSERT INTO myhadir_log (idprogram,tindakan,tarikh,uid) VALUES  ('$idprogram','Daftar Program',CURRENT_TIMESTAMP,'$loggedinuid')");
echo "<div class='container'>";
echo "<div id='alert' class='alert alert-primary m-3 d-none' role='alert'>Rekod Program berjaya didaftar</div>";
echo "</div>";
}

// check if the Add link is clicked
if (isset($_GET['add_sijil']))  {

//close the php to display the html form

?><form id='set1' role='form' method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

	<table class='table table-striped table-hover'>
		<thead class='table-primary'><tr>
	  <th colspan='2'>
		<strong>Pendaftaran Program Baru</strong>
		 </th></tr></thead>
						<tr>
							<td><b>Nama Program</b></td>
							<td> <input class='form-control' type="text" name="namaprogram" placeholder="Masukkan Nama Program" required>
							** <small>Taip <?php echo htmlspecialchars('<br>');?> untuk membuat baris baru sekiranya terlalu panjang. <br/>Contoh Unit Kualiti <?php echo htmlspecialchars('<br>');?> & Jabatan Kecemasan & Trauma</small>
							
							
							</td>
						
						</tr>
						<tr>
							<td><b>Tarikh Mula</b></td>
                                                        <td> <input class='form-control' type="date" name="tarikhmula" min="01/01/2022" max="31/12/2050" required></td>
						</tr>
                                                <tr>
							<td><b>Tarikh Tamat</b></td>
                                                        <td> <input class='form-control' type="date" name="tarikhtamat" min="01/01/2022" max="31/12/2050" required></td>
						</tr>
                                                <tr>
							<td><b>Kuota Peserta</b></td>
							<td> <input class='form-control' type="text" name="kuotapeserta" placeholder="Masukkan Jumlah Kuota Peserta yang boleh mendaftar" required></td>
						</tr>
						<tr>
							
							<td><b>Masa</b></td>
							<?php $sqlwaktu = "SELECT * FROM myhadir_waktu ORDER BY idwaktu ASC";
                                                        $resultwaktu = $GLOBALS['xoopsDB']->query($sqlwaktu);
                                                        ?>
                                                   
							<td> 
                                                                <select name="waktu" id="waktu" class='form-select'>
																<option value="">Sila Pilih</option>
                                                                <?php while($row = $GLOBALS['xoopsDB']->fetchArray($resultwaktu))
                                                                { ?>
															
															    <option value="<?php echo $row["waktu"];?>"><?php echo $row["waktu"];?></option>
															
																
																
															<?php } ?>
						    </select></td>
                                                </tr>
						
						<tr>
							<td><b>Tempat</b></td>
							<td>
                                                        <input class='form-control' type="text" name="tempat" placeholder="Lokasi Program" required>

                                                            
                                                </td>
                                                </tr>
                                                <tr>
							<td><b>Anjuran</b></td>
							<td> <input class='form-control' type="text" name="anjuran" placeholder="Cth Jawatankuasa Budaya Korporat Hospital Beaufort" required>
							** <small>Taip <?php echo htmlspecialchars('<br>');?> untuk membuat baris baru sekiranya terlalu panjang. </small></td>
						</tr>        
						<tr>
							<td><b>Nama Urusetia</b></td>
							<td> <input class='form-control' type="text" name="urusetia" placeholder="Nama Urusetia Program" required></td>
						</tr>
                                                <tr>
							<td><b>No Telefon/Ext</b></td>
							<td> <input class='form-control' type="text" name="notel" placeholder="Masukkan No Tel atau Extension Urusetia yang boleh dihubungi" required></td>
						</tr>
                                                <tr>
							<td><b>Catatan</b></td>
                                                        <td> <textarea name="catatan" class='form-control' placeholder="Catatan"></textarea></td>
						</tr>
                                                <tr>
							<td><b>Kod CPD</b></td>
                                                        <?php $sqlcpd = "SELECT * FROM myhadir_cpd ORDER BY cpdid ASC";
                                                        $resultcpd = $GLOBALS['xoopsDB']->query($sqlcpd);
                                                        ?>
                                                   
                                                        <td>
                                                                <selectclass='form-select' name="cpd" id="cpd">
                                                                <option value="" selected="selected">Sila Pilih</option>
																<option value="">N/A</option>
                                                                <?php while($row = $GLOBALS['xoopsDB']->fetchArray($resultcpd))
                                                                { ?>
                                                                <option value="<?php echo $row["cpdcode"];?>"><?php echo $row["cpdcode"];?>-<?php echo $row["cpdname"];?></option>
                                                                <?php } ?>
                                                        </select></td>
						</tr>
                                                <tr>
							<td><b>CPD Point</b></td>
                                                        <td> <input class='form-control' type="text" name="cpdpoint" placeholder="Masukkan CPD Point"></td>
						</tr>
                                                
                    	         <tr>
							<td><b>Template Sijil</b></td>
                                                        <?php $sqltemplate = "SELECT * FROM myhadir_template ORDER BY idtemplate ASC";
                                                        $resulttemplate = $GLOBALS['xoopsDB']->query($sqltemplate);
                                                        ?>
                                                   
                                                        <td>
                                                                <selectclass='form-select' name="idtemplate" id="idtemplate" required>
                                                                <option value="" selected="selected">Sila Pilih Template</option>
															
                                                                <?php while($row = $GLOBALS['xoopsDB']->fetchArray($resulttemplate))
                                                                { ?>
                                                                <option value="<?php echo $row["idtemplate"];?>"><?php echo $row["namatemplate"];?></option>
                                                                <?php } ?>
                                                        </select></td>
						</tr>
		 
		 
						<tr>
							<td align="center" colspan='2'><button type="submit" name="daftar_sijil" class='btn btn-primary btn-sm'><i class="fa fa-save"></i> Daftar</button> 
							<!--<input type="button" class='btn btn-secondary btn-sm' onclick="history.back()" value="Batal">-->
							</td>
						</tr>
		</table>	

<?php
	 
echo "</form>";

}  //closing the if statement
























//if not searching then display all data

  //$result = $GLOBALS['xoopsDB']->query("SELECT * FROM myhadir_program WHERE status='Closed' OR tarikh < curdate() ORDER BY tarikhmula DESC");
  $result = $GLOBALS['xoopsDB']->query("SELECT * FROM myhadir_program WHERE idunit = ".$_SESSION['idunit']." ORDER BY tarikhmula DESC");


// check if records were returned
if ($GLOBALS['xoopsDB']->getRowsNum($result) > 0)  {

echo "<br /><table id='sijil' class='table table-striped table-bordered table-hover'>
<thead class='table-dark'>
<tr>
<th>Nama Program</th>
<th class='text-center'>Tarikh Program</th>
<th class='text-center'>Lokasi</th>
<th class='text-center'>Peserta</th>
<th class='text-center'>Tindakan</th>
</tr></thead><tbody>";


$count =1 ;
//display all data and pass the data per record to the array $row
while($row = $GLOBALS['xoopsDB']->fetchArray($result))
  {
 $idprogram=$row['idprogram'];
			    $namaprogram=$row['namaprogram'];
				$namaprogram = preg_replace( "/<br>|\n|<br( ?)\/>/", " ", $namaprogram );
				 $tarikhmula=$row['tarikhmula'];
				 $tarikhtamat=$row['tarikhtamat'];
				 	$waktu=$row['waktu'];
				  $kuotapeserta=$row['kuotapeserta'];				 
				  $anjuran=$row['anjuran'];
				   $tempat=$row['tempat'];
				   $urusetia=$row['urusetia'];
				   $status=$row['status'];
				   $regdate=$row['regdate'];
				    $idunit=$row['idunit'];
					$catatan=$row['catatan'];
					$notelefon=$row['notelefon'];
					$cpd=$row['cpd'];
					$cpdpoint=$row['cpdpoint'];
					$idtemplate=$row['idtemplate'];
					
			
				$resultpeserta = $GLOBALS['xoopsDB']->query("SELECT * FROM myhadir_peserta WHERE idprogram = '$idprogram'");
                $jumlahpeserta = $GLOBALS['xoopsDB']->getRowsNum($resultpeserta);

echo '<tr>'; 
echo "<td><a id='$idprogram' name='$idprogram'></a>";
//echo "<a href='#' class='namaprogram' data-bs-toggle='modal' data-bs-target='#programinfo$idprogram'>$namaprogram</a>";
echo "<a href='peserta-anjuran.php?id=$idprogram' class='namaprogram''>$namaprogram</a>";

$curdate=date("Y-m-d");
if($status=='Open')
                              {
                                 
                                    if($tarikhmula < $curdate OR $jumlahpeserta > $kuotapeserta)
									{ 
									 echo "<span class='badge bg-danger pull-right'>Tutup</span>";
									 }
									 else
									 echo "&nbsp;<a class='badge bg-primary text-white pull-right' href='peserta-anjuran.php?id=$idprogram'><i class='fa fa-plus-circle' title='Daftar'></i> Daftar</a>&nbsp;<span class='badge bg-success pull-right'>Buka</span>&nbsp;";
							  }
							  else
								  
									 { 
									 echo "<span class='badge bg-danger pull-right'>Tutup</span>";
									 }

if( $row['status'] == 'Open'){
	//echo "<a href='" . htmlspecialchars("$_SERVER[PHP_SELF]") . "?set_close=" . $row['idprogram'] . "' onClick='return confirm('Anda ingin tutup program ini?')'> <span class='badge bg-success pull-right'>Buka</span></a>";
							  												
							}else{
	//echo "<a href='" . htmlspecialchars("$_SERVER[PHP_SELF]") . "?set_open=" . $row['idprogram'] . "' onClick='return confirm('Anda ingin buka program ini?')'> <span class='badge bg-danger pull-right'>Buka</span></a>";
							}
							
echo "</td>";


echo "<td class='text-center'>";
$tarikh_mula=date('d F Y',strtotime($tarikhmula));
$tarikh_tamat=date('d F Y',strtotime($tarikhtamat));	
$translated_tarikhmula = str_ireplace($monthsDaysEn,$monthsDaysMy,$tarikh_mula);
$translated_tarikhtamat= str_ireplace($monthsDaysEn,$monthsDaysMy,$tarikh_tamat);
if($tarikhmula==$tarikhtamat)

echo "<small>$translated_tarikhmula <br><span class='badge bg-secondary'>$waktu </span></small>";	
else
echo "<small>$translated_tarikhmula - $translated_tarikhtamat <br><span class='badge bg-secondary'>$waktu</span></small>";
echo "</td>";
echo "<td class='text-center'>$tempat</td>";
echo "<td class='text-center'><small>$jumlahpeserta/$kuotapeserta</small></td>";
echo "<td class='text-center'>";

							  //echo "<button type='button' class='text-center badge bg-info' data-bs-toggle='modal' data-bs-target='#programinfo$idprogram'><i class='fa fa-search' title='Info Program'></i></button>";
	
							  echo "&nbsp;<a href='" . htmlspecialchars("$_SERVER[PHP_SELF]") . "?edit_sijil=" . $row['idprogram'] . "'><span class='badge bg-info'> <i class='fa fa-edit'></i> Kemaskini</span>"; 							  
							  //echo "<a href=\"" . htmlspecialchars("$_SERVER[PHP_SELF]") . "?del_sijil=".$row['idprogram']."\"onclick=
    //  \"return confirm('Adakah anda pasti untuk hapus?')\"> <span class='badge bg-danger'><i class='fa fa-trash'></i> Hapus</span></a> ";	
	  ?>

 <a href="peserta-anjuran.php?id=<?php echo $row['idprogram'];?>"><span class='badge bg-danger'><i class='fa fa-user'></i> Peserta</span></a>
                                                        <a href="kehadiran-anjuran.php?id=<?php echo $row['idprogram'];?>"><span class='badge bg-dark'><i class='fa fa-star'></i> Kehadiran</span></a>
                                                        <a href="sijil-penyertaan-anjuran.php?id=<?php echo $row['idprogram'];?>"><span class='badge bg-dark'><i class='fa fa-download'></i> eSijil Penyertaan</span></a>
                                                        <a href="sijil-penghargaan-anjuran.php?id=<?php echo $row['idprogram'];?>"><span class='badge bg-dark'><i class='fa fa-download'></i> eSijil Penghargaan</span></a>


<?php






//start modal
echo "<div class='modal' id='programinfo$idprogram'>
  <div class='modal-dialog'>
    <div class='modal-content'>
	
     
      <!-- Modal Header -->
      <div class='modal-header'>
        <h4 class='modal-title'>$idprogram</h4>
        <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
      </div>

      <div class='modal-body'>";
 
	   echo "<h2>$namaprogram</h2>
					<table class='table table-hover table-striped'>
						<tr>
							<td><b>Tarikh</b></td>
							<td>: "; 
						
							if($tarikhmula==$tarikhtamat)

				echo "$tarikh_mula";else echo "$tarikh_mula - $tarikh_tamat ";
						
							echo "</td>
						</tr>
						<tr>
							<td><b>Masa</b></td>
							<td>: ";if ($waktu!=''){echo $waktu;} else {echo "N/A";} echo "</td>
						</tr>
                                                <tr>
							<td><b>Kuota Peserta</b></td>
							<td>: ";if ($kuotapeserta!=''){echo $kuotapeserta;} else {echo "N/A";} echo "</td>
						</tr>
						<tr>
							<td><b>Jumlah Memohon</b></td>
							<td>: "; 
							if ($jumlahpeserta!=''){echo $jumlahpeserta;
							 echo "&nbsp;<a class='badge bg-secondary' href='peserta-anjuran.php?id=$idprogram'><i class='fa fa-search' title='Peserta'></i> Senarai Peserta</a>&nbsp;";
							
							
							} else {echo "N/A";}
							
							echo "</td>
						</tr>
						<tr>
							<td><b>Tempat</b></td>
							<td>: ";if ($tempat!=''){echo $tempat;} else {echo "N/A";} echo "</td>
						</tr>
                                                <tr>
							<td><b>Anjuran</b></td>
							<td>: ";if ($anjuran!=''){echo $anjuran;} else {echo "N/A";} echo "</td>
						</tr>
						<tr>
							<td><b>CPD Point</b></td>
							<td>: ";if ($cpd!='' AND $cpdpoint!=''){echo "$cpd : $cpdpoint";} else {echo "N/A";} echo "</td>
						</tr>
						<tr>
							<td><b>Nama Urusetia</b></td>
							<td>: ";if ($urusetia!=''){echo $urusetia;} else {echo "N/A";} echo "</td>
						</tr>
                                                <tr>
							<td><b>No Telefon/Ext</b></td>
							<td>: ";if ($notelefon!=''){echo $notelefon;} else {echo "N/A";} echo "</td>
						</tr>
						
                                                <tr>
							<td width='150'><b>Catatan</b></td>
							<td>: "; if ($catatan!=''){echo $catatan;} else {echo "N/A";} echo "</td>
						</tr>
						<tr>
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
									 echo "<a class='badge bg-primary text-white' href='daftarprogram.php?id=$idprogram'><i class='fa fa-plus-circle' title='Daftar'></i> Mohon</a>&nbsp;<span class='badge bg-success'>Buka</span>&nbsp;";
										  }
							  else
								  
									 { 
									 echo "<span class='label label-success'>Tutup</span>";
									 }


							echo "</td>
						</tr>
					</table>";
	
      echo "</div>
   <div class='modal-footer'>
        <button type='button' class='btn btn-danger' data-bs-dismiss='modal'>Close</button>
      </div>

    </div>
  </div>
</div>";	   












































echo  "</td>";
echo "</tr>";


}
 // once processing is complete
// free result set

echo "</tbody></table>";

}
 else
 
 {
 echo "Tiada Rekod Dijumpai";
 }
 

?>




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
    jQuery('#sijil').DataTable( {
    "displayLength": 5,
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
  }, 3000); //3 seconds

</script>
 
  <noscript><meta http-equiv="Refresh" content="0; url='error.php'" /></noscript></body>
</html>

<?php ?>
