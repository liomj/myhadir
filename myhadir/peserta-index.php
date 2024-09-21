<?php 

	require("connection.php");
	error_reporting(0);
	session_start();
?>

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
    $query="SELECT * FROM myhadir_program WHERE idprogram = '$idprogram'" ;
    //echo $query;EXIT;
    $result=$GLOBALS['xoopsDB']->query($query);
	if (!$result) { // add this check.
    trigger_error($GLOBALS['xoopsDB']->error()); 
}
if ($GLOBALS['xoopsDB']->getRowsNum($result)==0) {   
?>
	<script>
	self.location ="sijil-index.php";
			</script>
<?php }

    $row =$GLOBALS['xoopsDB']->fetchArray($result);
		$namaprogram=$row['namaprogram'];
		$anjuran=$row['anjuran'];
		$tarikhmula=$row['tarikhmula'];
		$tarikhtamat=$row['tarikhtamat'];
		$tarikh_mula=date('d M Y',strtotime($tarikhmula));
$tarikh_tamat=date('d M Y',strtotime($tarikhtamat));	
		$waktu=$row['waktu'];
                $kuotapeserta=$row['kuotapeserta'];
		$tempat=$row['tempat'];
		$urusetia=$row['urusetia'];
		$status=$row['status'];
$cpd=$row['cpd'];
					$cpdpoint=$row['cpdpoint'];	
				   $regdate=$row['regdate'];
				    $idunit=$row['idunit'];
					$catatan=$row['catatan'];
					$notelefon=$row['notelefon'];
					
$resultpeserta = $GLOBALS['xoopsDB']->query("SELECT * FROM myhadir_peserta where idprogram = '$idprogram'" );
    $jumlahpeserta = $GLOBALS['xoopsDB']->getRowsNum($resultpeserta);

?>
   
<main class="container">
  <div class="p-5 rounded bg-light">
    <h2><?php echo $row['namaprogram'];?></h2>
    <p class="lead"><?php echo $row['namaprogram'];?>
	
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
							<td><b>CPD Point</b></td>
							<td>: <?php if ($cpd!='' AND $cpdpoint!=''){echo "$cpd : $cpdpoint";} else {echo "N/A";} echo "</td>"; ?>
						</tr>
						<tr>
							<td><b>Nama Urusetia</b></td>
							<td>: <?php if ($urusetia!=''){echo $urusetia;} else {echo "N/A";} echo "</td>"?>
						</tr>
                                                <tr>
							<td><b>No Telefon/Ext</b></td>
							<td>: <?php if ($notelefon!=''){echo $notelefon;} else {echo "N/A";} echo "</td>"; ?>
						</tr>
						
                                                <tr>
							<td><b>Catatan</b></td>
							<td>: <?php if ($catatan!=''){echo $catatan;} else {echo "N/A";} echo "</td>"; ?>
						</tr>

						<tr>
							<td><b>Kuota Peserta</b></td>
							<td>: <?php echo $kuotapeserta;?></td>
						</tr>
						<tr>
							<td><b>Jumlah Peserta</b></td>
							<td>: <?php echo $jumlahpeserta;?></td>
						</tr>

						<?php
						echo "<tr>
							<td>";
							//echo "<b>Status</b>";
							
							echo "</td>
							<td>";
							
							//echo ": ";

							$curdate=date("Y-m-d");
							if($status=='Open')
                              {
                                 
                                    if($tarikhmula < $curdate OR $jumlahpeserta > $kuotapeserta)
									{ 
									 //echo "<span class='badge bg-danger'>Tutup</span>";
									 }
									 else
										 echo "&nbsp";
									 //echo "<a class='badge bg-primary text-white' href='daftarprogram.php?id=$idprogram'><i class='fa fa-plus-circle' title='Daftar'></i> Mohon</a>&nbsp;<span class='badge bg-success'>Buka</span>&nbsp;";
										  }
							  else
								  
									 { 
									// echo "<span class='label label-success'>Tutup</span>";
									 }


							echo "</td>
						</tr>"; ?>
					</table>
		
	</p>
  </div>
	
	
	

<br />
<?php
//echo $idkehadiran;exit;
    //$querysijil="SELECT * FROM myhadir_peserta WHERE idprogram = '$idprogram'" ;
	$querysijil="SELECT a.idpeserta,a.mykad,a.nama,a.regdate,a.kehadiran,a.idunit,b.idunit,b.namaunit FROM myhadir_peserta a,myhadir_unit b 
	WHERE idprogram = '$idprogram' AND a.idunit =  b.idunit ORDER BY a.idpeserta DESC";
    
    //echo $query;EXIT;
    $resultsijil=$GLOBALS['xoopsDB']->query($querysijil);

?>

<table id='peserta' class='table table-striped table-border'>

    <thead class='table-dark'>
<tr>
         <th><strong>Nama Peserta</strong></th>
		 <th><strong>Unit</strong></th>
		 <th><strong>Tarikh Daftar</strong></th>

           
</tr>
</thead><tbody>
<?php


		
			while ($row =$GLOBALS['xoopsDB']->fetchArray($resultsijil)) 
			{
				$tarikh=$row['regdate'];
    $tarikhx = date("d M Y D ", strtotime($tarikh));
                      ?>
                          <tr>
			 
			  <td><?php echo $row['nama'];?></td>
			 <td><?php echo $row['namaunit'];?></td>
			  <td><?php echo "$tarikhx";?></td>
			 
                         
                        </tr> 
                         	 	
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
    "displayLength": 2000,
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
  }, 5000); //5 second

</script>

<noscript><meta http-equiv="Refresh" content="0; url='error.php'" /></noscript></body>
</html>

<?php ?>
