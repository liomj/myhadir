<?php
include("../../mainfile.php");
include(XOOPS_ROOT_PATH."/header.php");

//2.5.8
require_once XOOPS_ROOT_PATH . '/class/libraries/vendor/tcpdf/tcpdf.php';
// Creating the item object for the selected item
// Creating the item object for the selected item

$monthsDaysEn = array('January','February','March','April','May','June','July','August','September','October','November','December'); //populate with all months/days you want translated
$monthsDaysMy = array('Januari','Februari','Mac','April','Mei','Jun','Julai','Ogos','September','Oktober','November','Disember'); //populate with all months/days you want translated


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
    //Page header
    public function Header() {
        // get the current page break margin
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);
        // set bacground image
       // $img_file = K_PATH_IMAGES.'image_demo.jpg';
        //$this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
		//$this->SetAlpha(0.2);
// draw jpeg image
// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
	
        // restore auto-page-break status
		//$this->SetAlpha(1);
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $this->setPageMark();
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//$pdf->AddPage('L', 'A4');
 
// set margins
$pdf->setCellPaddings(0,0,0,0);
$pdf->SetMargins(0, 0, 0);
$pdf->SetLeftMargin(0);
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(0);
//$pdf->SetFooterMargin(0);

// remove default footer
$pdf->setPrintFooter(false);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 8); 
//The first parameter is meant to be an array of strings with identifiers as content that indicates which permissions should be removed from the PDF.

//print : disable the possibility to print the PDF from any PDF viewer.
//modify : prevent the modification of contents of the document by operations other than those controlled by 'fill-forms', 'extract' and 'assemble';
//copy : prevent the copy or otherwise extract text and graphics from the document;
//annot-forms : Add or modify text annotations, fill in interactive form fields, and, if 'modify' is also set, create or modify interactive form fields (including signature fields);
//fill-forms : Fill in existing interactive form fields (including signature fields), even if 'annot-forms' is not specified;
//extract : Extract text and graphics (in support of accessibility to users with disabilities or for other purposes);
//assemble : Assemble the document (insert, rotate, or delete pages and create bookmarks or thumbnail images), even if 'modify' is not set;
//print-high : Print the document to a representation from which a faithful digital copy of the PDF content could be generated. When this is not set, printing is limited to a low-level representation of the appearance, possibly of degraded quality.
//owner : (inverted logic - only for public-key) when set permits change of encryption and enables all other permissions.

$pdf->SetProtection(array('modify','copy','annot-forms','fill-forms','extract','assemble'));
// add a page
$pdf->AddPage();

// Print a text
//$html = '<span style="background-color:yellow;color:blue;">&nbsp;PAGE 1&nbsp;</span>
//<p stroke="0.2" fill="true" strokecolor="yellow" color="blue" style="font-family:helvetica;font-weight:bold;font-size:26pt;">You can set a full page background.</p>';
	$idprogram = $_GET['id']; 

		$query1="select * from ".$GLOBALS['xoopsDB']->prefix("myhadir_program")." WHERE idprogram = '$idprogram' " ;
		$result1=$GLOBALS['xoopsDB']->query($query1);
		while ($row1 =$GLOBALS['xoopsDB']->fetchArray($result1)) 
		{
			
	$namaprogram=$row1['namaprogram'];
							 $tarikhmula=$row1['tarikhmula'];
				 $tarikhtamat=$row1['tarikhtamat'];
				 $tarikh_mula=date('d M Y',strtotime($tarikhmula));
$tarikh_tamat=date('d M Y',strtotime($tarikhtamat));	
			$waktu=$row1['waktu'];
			$tempat=$row1['tempat'];
			$urusetia=$row1['urusetia'];
			$anjuran=$row1['anjuran'];
                       
                       
		}	
		
			
			$query="SELECT a.id,a.mykad,a.nama,a.kehadiran,a.email,a.idunit,b.idunit,b.unit 
			FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_kehadiran")." a,
			".$GLOBALS['xoopsDB']->prefix("myhadir_unit")." b WHERE idprogram = '$idprogram' AND a.idunit =  b.idunit ORDER BY a.nama ASC";
    
			$result=$GLOBALS['xoopsDB']->query($query);
            $size = $GLOBALS['xoopsDB']->getRowsNum($result);
			$unit = $ptj;


if($tarikhmula==$tarikhtamat)
{
$pdf->SetTitle('Senarai Peserta '.$namaprogram.'_'.$tarikh_mula.'');

}
else
{

$pdf->SetTitle('Senarai Peserta '.$namaprogram.'_'.$tarikh_mula.'-'.$tarikh_tamat.'');

}

					
$htmlb .= '<br><br><b>Senarai Peserta '.$namaprogram.'</b><br><b>Anjuran:</b> '.$anjuran.'';
$pdf->writeHTML($htmlb, true, false, true, false, 'C');



	
if($tarikhmula==$tarikhtamat)
{
					
$html2 .= ' <br><b>Tarikh :</b> '.$tarikh_mula.' | <b>Masa :</b>'.$waktu.'';
$pdf->writeHTML($html2, true, false, true, false, 'C');

}
else
{
$html2 .= ' <br><b>Tarikh :</b> '.$tarikh_mula.' - '.$tarikh_tamat.' | <b>Masa :</b>'.$waktu.'';
$pdf->writeHTML($html2, true, false, true, false, 'C');

}
$html3 .= ' <br><b>Tempat :</b> '.$tempat.' | <b>Jumlah Peserta :</b> '.$size.'';
$pdf->writeHTML($html3, true, false, true, false, 'C');

  $checkurusetia = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("myhadir_aksesprogram")." WHERE idprogram='$idprogram'");
 $jumlahurusetia = $GLOBALS['xoopsDB']->getRowsNum($checkurusetia);

 while($rowx=$GLOBALS['xoopsDB']->fetchArray($checkurusetia)) 
{
$urusetia_uid=$rowx['uid'];
$resulturusetia = $GLOBALS['xoopsDB']->query("SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("users")." WHERE uid='$urusetia_uid'");
 while($rows=$GLOBALS['xoopsDB']->fetchArray($resulturusetia)) 
{
	$urusetia=$rows['name'];
$html3x .= ' <br><b>Urusetia :</b> '.$urusetia.'';
$pdf->writeHTML($html3x, true, false, true, false, 'C');


}
}	

 
 



		
$html .= '<br><br>';


$html .= '&nbsp;&nbsp;&nbsp;&nbsp;<table border="1" cellpadding="1" width="100%">
<tr height="200px">
<td align="center" width="25"><b>Bil </b></td>
<td align="center" width="300"><b>Nama Peserta</b></td>
<td align="center" width="100"><b>No myKad</b></td>
<td align="center" width="100"><b>Email</b></td>
<td align="center" width="100"><b>Unit</b></td>
<td align="center" width="60"><b>T.T</b></td>
</tr>';
$x=0;
while($row = $GLOBALS['xoopsDB']->fetchArray($result))
{
	$x++;
	  $namapeserta = strtoupper($row['nama']);
    $mykad=$row['mykad'];
	$unit=$row['unit'];
	$email=$row['email'];
    $datereg = date("d-m-Y", strtotime($row['regdate']));
    
	
	$html .= '<tr style="line-height: 200%;">';
$html .= '<td align="center">'.$x.'</td>';

$html .='<td>&nbsp;'.$namapeserta.'</td>';

$html .= '<td align="center">'.$mykad.'</td>';
$html .= '<td align="center">'.$email.'</td>';
$html .= '<td align="center">'.$unit.'</td>';
$html .= '<td>&nbsp;&nbsp;</td>';

$html .= '</tr>';
}
$html .= '</table>';
$pdf->writeHTML($html, true, false, true, false, '');


// ---------------------------------------------------------


// reset pointer to the last page
$pdf->lastPage();
//Close and output PDF document
//$pdf->IncludeJS("print();");
//* I: send the file inline to the browser (default). The plug-in is used if available. The name given by name is used when one selects the &quot;Save as&quot; option on the link generating the PDF.
//* D: send to the browser and force a file download with the name given by name.
//* F: save to a local file with the name given by name.
//* S: return the document as a string. name is ignored.

if($tarikhmula==$tarikhtamat)
{
$pdf->Output('Kehadiran_'.$namaprogram.'_'.$tarikh_mula.'.pdf', 'D');
}
else
{
$pdf->Output('Kehadiran_'.$namaprogram.'_'.$tarikhmula.'_'.$tarikh_tamat.'.pdf', 'D');
}







exit();

//============================================================+
// END OF FILE
//============================================================+