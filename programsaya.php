<?php
//  Author: Lionel Michael Jominin
//  URL: https://jknsabah.moh.gov.my/hbeaufort/
//  E-Mail: lionel.m@moh.gov.my
include("../../mainfile.php");
include(XOOPS_ROOT_PATH."/header.php");


$meta_keywords = "sistem,myHadir";
$meta_description = "Sistem Pengurusan Kehadiran Program";
$pagetitle = "Sistem myHadir";

if(isset($xoTheme) && is_object($xoTheme)) {
    $xoTheme->addMeta( 'meta', 'keywords', $meta_keywords);
    $xoTheme->addMeta( 'meta', 'description', $meta_description);
} else {    // Compatibility for old Xoops versions
    $xoopsTpl->assign('xoops_meta_keywords', $meta_keywords);
    $xoopsTpl->assign('xoops_meta_description', $meta_description);
}

$xoopsTpl->assign('xoops_pagetitle', $pagetitle);

//this will only work if your theme is using this smarty variables
$xoopsTpl->assign( 'xoops_showlblock', 1); //set to 0 to hide left blocks
$xoopsTpl->assign( 'xoops_showrblock', 1); //set to 0 to hide right blocks
$xoopsTpl->assign( 'xoops_showcblock', 1); //set to 0 to hide center blocks

?>

<link rel="stylesheet" type="text/css" href="assets/css/datatables.min.css"/>

<script src="assets/js/datatables.min.js"></script>



<script type="text/javascript">
  var jQuery =$.noConflict(true);
  </script> 
<script>
jQuery(document).ready(function() {
    jQuery('#standard5').DataTable({"language": {
       url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/ms.json',
    },});
} );
</script>


<div class='container-fluid'>
    <div class='row p-4'>



    
        
                            <?php
							$getkonfigurasi = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_konfigurasiumum")."");
$rowz = $GLOBALS['xoopsDB']->fetchArray($getkonfigurasi);
$namaagensi=$rowz['namaagensi'];
$namasingkatan=$rowz['namasingkatan'];

global $xoopsUser; 
//get current user id  
$loggedinuid = is_object($xoopsUser) ? $xoopsUser->getVar('uid') : 0;  
	//check permission
global $xoopsUser;  
$profile_handler =&xoops_getmodulehandler('profile','profile');
$uid = intval($_GET['uid']); //get uid from url
if ($uid <= 0) { 
 if (is_object($xoopsUser))  {//if member
        $profile = $profile_handler->get($xoopsUser->getVar('uid'));} //get uid for the connected member
        else {
             header('location: ' . XOOPS_URL); //back to homepage - redirect wherever you want
             exit();
             }
 }
else 
{

$profile = $profile_handler->get($uid);
}
$loggedinuser=$xoopsUser->getVar('uname');
$loggedinname=$xoopsUser->getVar('name');
$loggedinuid=$xoopsUser->getVar('uid');
	

							
                                $mykad  = $_POST['mykad'];
                                                                              
									 
$getnama = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_nama")." WHERE mykad= '$loggedinuser' ORDER by id DESC"); 
 $rowx = $GLOBALS['xoopsDB']->fetchArray($getnama);
 $namax=$rowx['nama'];
echo "<h2><span class='badge bg-danger'>Program</span></h2>";
 echo "<br><h5>$loggedinname</h5>";

$result = $GLOBALS['xoopsDB']->query("SELECT 
  n.*,
  concat(
    
    (SELECT count(*) FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_nama")." WHERE idprogram = n.idprogram), '/',
    (SELECT count(*) FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_nama")." WHERE idprogram = n.idprogram AND id < n.id) + 1
  ) nosijil 
FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_nama")." n INNER JOIN ".$GLOBALS['xoopsDB']->prefix("myhadir_program")." p
ON p.idprogram = n.idprogram WHERE n.mykad='$loggedinuser' ORDER BY id DESC");
			
			
			//$row = $GLOBALS['xoopsDB']->fetchArray($result);


                                    if ($GLOBALS['xoopsDB']->getRowsNum($result)== 0)
                                    {
                                        echo "<div class='alert alert-info m-2'><i class='fa fa-exclamation-circle'></i> Anda tidak mempunyai sebarang program. 
										Sila hubungi Urusetia program";
                                    echo "</div>";
                                    }
                                    else{
																

					$bil=1;
                                    echo "<div class='table-responsive'><table id='standard5' class='table table-striped table-hover'>
                                        <thead>
                                        <tr style='background-color: rgba(0, 0, 0, 0.05);'>
                                                                      
											<th>Nama Program</th>
											<th>Tarikh</th>
											<th>Kategori</th>
											<th>No Sijil</th>
											<th>E-Sijil</th>
                                        </tr>
                                        </thead>";
            
                                        echo "<tbody>";			
                   while($row = $GLOBALS['xoopsDB']->fetchArray($result))
{         
									$id=$row['id'];
                                    $nama=$row['nama'];
									 $mykad=$row['mykad'];
									$idprogram=$row['idprogram'];
									$idkategoripenerima=$row['idkategoripenerima']; 
									$kehadiran=$row['kehadiran'];
									$nosijil=$row['nosijil'];
	                               $idcpdcode=$row['idcpdcode'];	
	$cpdpoint=$row['cpdpoint'];
									$tempoh=$row['tempoh'];
                                        echo"<tr>";
                                  
                                        //echo "<td>$nama</td>";
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
				   $tahunprogram= date('Y', strtotime($tarikhmula));
				  
									    echo "<td>$namaprogram</td>";
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
}
										echo "<td>";
										$checkkategoripenerima = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_kategoripenerima")." WHERE idkategoripenerima='$idkategoripenerima'");
$rowkategoripenerima=$GLOBALS['xoopsDB']->fetchArray($checkkategoripenerima);
$kategoripenerima=$rowkategoripenerima['kategoripenerima'];
echo "$kategoripenerima";
										echo "</td>";
										echo "<td>myHadir/$namasingkatan/$idprogram/$tahunprogram/$nosijil</td>";
										echo "<td>";
										$checkfailtemplate = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_template")." WHERE idtemplate='$idtemplate'");
$row6 = $GLOBALS['xoopsDB']->fetchArray($checkfailtemplate);
$failtemplate=$row6['failtemplate'];
$tandatangan=$row6['tandatangan'];
										
if ($idkategoripenerima!=1)
{	
echo "<form role='form' id='print' action='$failtemplate?download_esijilpenghargaan&idpenghargaan=$id' target='_blank' method='post'>";

}
else
{	
echo "<form role='form' id='print' action='$failtemplate?download_esijilpenyertaan&idpenyertaan=$id' target='_blank' method='post'>";

}	

									
if (!empty($tempoh)){
echo "<input type=\"hidden\" name=\"tempoh\" value='$tempoh'>";
}

if ($kehadiran=='1')
{
if ($idkategoripenerima!=1)
{	
 //echo "<a href='$failtemplate?download_esijilpenghargaan&idpenghargaan=$id' target='_blank' class='btn btn-light btn-sm text-dark'><i class='fa fa-download' title='Muat Turun E-Sijil'></i></a>&nbsp;";
echo "<input type=\"hidden\" name=\"nosijil\" value='$nosijil'>";
echo "<input type=\"hidden\" name=\"tandatangan\" value='$tandatangan'>";
echo "<button type='submit' class='btn btn-light btn-sm text-dark'> <i class='fa fa-download' title='Muat Turun E-Sijil'></i> </button>&nbsp;";

}
else
{	
// echo "<a href='$failtemplate?download_esijilpenyertaan&idpenyertaan=$id' target='_blank' class='btn btn-dark btn-sm text-white'><i class='fa fa-download' title='Muat Turun E-Sijil'></i></a>&nbsp;";
echo "<input type=\"hidden\" name=\"nosijil\" value='$nosijil'>";
echo "<input type=\"hidden\" name=\"tandatangan\" value='$tandatangan'>";
echo "<button type='submit' class='btn btn-dark btn-sm text-white'> <i class='fa fa-download' title='Muat Turun E-Sijil'></i> </button>&nbsp;";
}	

}


echo "</form>";
										
										
										
										
										echo "</td>";

                                        echo  "</tr>";
										
										}	
										
                                        echo "</tbody>";
                                    
                                        echo "</table></div>"; 
                                    }

                            
                     
                        
                            ?>

							
							
					
                        </form>
       
		
	</div></div>	

<?php
include(XOOPS_ROOT_PATH."/footer.php");
?>
