<?php
session_start();
date_default_timezone_set('Asia/Colombo');
require ("../fpdf/fpdf.php");
include ("../dbconfig.php");
$con = new mysqli(DB_HOSTNAME,DB_USERNAME, DB_PASSWORD,DB_NAME);


class myPDF extends FPDF
{
 function header()
 {
    $this->SetFont('Times','B',13);
    $this->Cell(12);
    //$this->Cell(50,5,'Name',0,0,'C');
    //$this->Cell(5,5,'(epf_no)',0,1,'C');
    //$this->Cell(250,5,'',0,1,'C');
 }
  function footer()
  {
    $this->SetY(-15);
    $this->SetFont('Arial','',8);
    $this->Cell(0,10,'Page'.$this->PageNo(),0,0,'C');
 
  }

}

$pdf=new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('','A4',0);
//$pdf->headerTable();
$pdf->SetFont('Arial','',12); 
$pdf->Ln();
$w = 100;
$h = 21;


if ($_GET['emp_id']) {
	$emp_id = $_GET['emp_id'];
	$sqlSelect = "SELECT * FROM employee WHERE emp_id = '$emp_id'";
	$sqlQuery = mysqli_query($con, $sqlSelect);

while ($data = mysqli_fetch_array($sqlQuery)) 
{   
    $emp_id  = $data['emp_id'];
    $epf_no  = $data['epf_no'];
    $ename  = $data['ename'];
    $posId  = $data['position'];
    $ename  = $data['ename'];
    $address  = $data['address'];
    $dob  = $data['dob'];
    $gender  = $data['gender'];
    $tel_personal  = $data['tel_personal'];
    $tel_home  = $data['tel_home'];
    $nic  = $data['nic'];
    $devId  = $data['devision'];
    $teamId = $data['team'];
    //$eduId  = $data['minimum_edu'];

    if ($data['ephoto'] == "noimage.png") {
        $img = "../images/employee/noimage/".$data['ephoto'];
    }else{
        $img = "../images/employee/".$data['ephoto'];
    }

    //Educational Details
    $eduId         = $data['minimum_edu'];
    $sports        = $data['sports'];
    $extra_edu     = $data['extra_edu'];
    //Experience
    $e_doj         = $data['e_doj'];
    $other_company = $data['other_company']; 
    $occupation    = $data['occupation']; 
    $etimep        = $data['etime_period']; 
    $remarks       = $data['remarks'];
    $religion      = $data['religion'];
    $civilstatus   = $data['civilstatus'];
    $catogory      = $data['catogaroy'];


    $time_period   = $etimep." (years) ";

    $date1 = $data['e_doj'];
    $date2 = date("Y/m/d");

    $diff = abs(strtotime($date2) - strtotime($date1));

    $years  = floor($diff / (365*60*60*24));
    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
    $days   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
    $serPeriod  = $years." (Years) ,".$months." (Months) ,".$days." (Days) ";
}




// Page Heading
$pdf->SetFont('Times','B',15);
$pdf->Cell(150,10,$ename. ' ('.$epf_no.')',0,1,'C');

//Make a dummy empty cell as a verticaly spacer
$pdf->Cell(120,5,'',0,1);//End of the Line

// Employee Image
$pdf->Image($img,150,12,40,40);
$pdf->Cell(100,30,'',0,1);



$pdf->SetFont('Arial','B',11);
$pdf->Cell(63,10,"1. EPF No :",0,0);
$pdf->SetFont('Arial','',11);
$pdf->Cell(130,10,$epf_no,0,1);

$pdf->SetFont('Arial','B',11);
$pdf->Cell(63,10,"2. Designation :",0,0);
$pdf->SetFont('Arial','',11);
// Select Position
if ($posId == 0) {
    $posNa = "";
   $pdf->Cell(130,12,$posNa,0,1);
}else{
    $posNa = "SELECT * FROM `position` WHERE `position_id` = $posId";
    $posQuery = mysqli_query($con, $posNa);
    while ($posRow = mysqli_fetch_assoc($posQuery)) {
        $posNa = $posRow['position'];
        $pdf->SetFont('Arial','',11);
        $pdf->Cell(130,12,$posNa,0,1);
    }
}

//Merge ename cell
$cellwidth1 =130;
$cellHeight1 =6;

if ($pdf->GetStringWidth($ename) < $cellwidth1) {
          $line=1;
        }else{
          $textLength=strlen($ename);
          $errMargin=10;
          $startChar=0;
          $maxChar=0;
          $textArray=array();
          $tmpString="";

          while($startChar < $textLength) {
            while ($pdf ->GetStringWidth($tmpString) < ($cellwidth1-$errMargin) && ($startChar+$maxChar) < $textLength) {
              $maxChar++;
              $tmpString=substr($ename,$startChar, $maxChar);
            }
            $startChar=$startChar+$maxChar;
            //Then add it into the array so we know how many line are needed
            array_push($textArray,$tmpString);
            //Reset maxChar and tmpString
            $maxChar=0;
            $tmpString='';
          }
          //Get Number of Line
          $line=count($textArray);
        }

        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(63,( $line * $cellHeight1),"3. Name :",0,0);
        $pdf->SetFont('Arial','',11);
        //Use MultiCell instead of Cell
        //but first, beacause MultiCell is always treated as line ending, need to 
        //manually set the xy position for the next cell to the next to it
        //the x and y position before writing the multicell
        $xPos=$pdf->GetX();
        $yPos=$pdf->GetY();
        $pdf->MultiCell(130,$cellHeight1,$ename,0,1);
        //Return the Position for next cell next to the multicell
        //and offset the x with multicell width
        $pdf->SetXY($xPos + $cellwidth1, $yPos);
       
         $pdf->Cell(130,($line * $cellHeight1),'',0,1);//Empty Line Space
        $pdf->Cell(130,5,'',0,1);


        //Merge Address Cell
        $cellwidth2 =130;
        $cellHeight2 =6;

        if ($pdf->GetStringWidth($address) < $cellwidth2) {
          $line=1;
        }else{
          $textLength=strlen($address);
          $errMargin=10;
          $startChar=0;
          $maxChar=0;
          $textArray=array();
          $tmpString="";

          while($startChar < $textLength) {
            while ($pdf ->GetStringWidth($tmpString) < ($cellwidth2-$errMargin) && ($startChar+$maxChar) < $textLength) {
              $maxChar++;
              $tmpString=substr($address,$startChar, $maxChar);
            }
            $startChar=$startChar+$maxChar;
            //Then add it into the array so we know how many line are needed
            array_push($textArray,$tmpString);
            //Reset maxChar and tmpString
            $maxChar=0;
            $tmpString='';
          }
          //Get Number of Line
          $line=count($textArray);
        }

        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(63,($line * $cellHeight2),"4. Address :",0,0);
        $pdf->SetFont('Arial','',11);
        //Use MultiCell instead of Cell
        //but first, beacause MultiCell is always treated as line ending, need to 
        //manually set the xy position for the next cell to the next to it
        //the x and y position before writing the multicell
        $xPos=$pdf->GetX();
        $yPos=$pdf->GetY();
        $pdf->MultiCell(130,$cellHeight2,$address,0,1);
        //Return the Position for next cell next to the multicell
        //and offset the x with multicell width
        $pdf->SetXY($xPos + $cellwidth2, $yPos);
      
        $pdf->Cell(130,($line * $cellHeight2),'',0,1);//Empty Line Space
        $pdf->Cell(130,5,'',0,1);


$pdf->SetFont('Arial','B',11);
$pdf->Cell(63,10,"5. Date Of Birth :",0,0);
$pdf->SetFont('Arial','',11);
$pdf->Cell(130,10,$dob,0,1);

$pdf->SetFont('Arial','B',11);
$pdf->Cell(63,10,"6. Gender :",0,0);
$pdf->SetFont('Arial','',11);
$pdf->Cell(130,10,$gender,0,1);

$pdf->SetFont('Arial','B',11);
$pdf->Cell(63,10,"7. Mobile Contac :",0,0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(130,10,$tel_personal,0,1);

$pdf->SetFont('Arial','B',11);
$pdf->Cell(63,10,"8. Resident Contact :",0,0);
$pdf->SetFont('Arial','',11);
$pdf->Cell(130,10,$tel_home,0,1);

$pdf->SetFont('Arial','B',11);
$pdf->Cell(63,10,"9. NIC :",0,0);
$pdf->SetFont('Arial','',11);
$pdf->Cell(130,10,$nic,0,1);

$pdf->SetFont('Arial','B',11);
$pdf->Cell(63,10,"10. Religion :",0,0);
$pdf->SetFont('Arial','',11);
$pdf->Cell(130,10,$religion,0,1);

$pdf->SetFont('Arial','B',11);
$pdf->Cell(63,10,"11. Civil Status :",0,0);
$pdf->SetFont('Arial','',11);
$pdf->Cell(130,10,$civilstatus,0,1);

$pdf->SetFont('Arial','B',11);
$pdf->Cell(63,10,"12. Catogory :",0,0);
$pdf->SetFont('Arial','',11);
$pdf->Cell(130,10,$catogory,0,1);

$pdf->SetFont('Arial','B',11);
$pdf->Cell(63,10,"13. Division :",0,0);
//Select Division Name
if($devId==0){
    $divNa   = "";
    $pdf->SetFont('Arial','',11);
    $pdf->Cell(130,10,$divNa,0,1,'L');
}else{
    $divNa = "SELECT * FROM `devision` WHERE `dev_id` = $devId";
    $divQuery = mysqli_query($con, $divNa);

    while ($divRow = mysqli_fetch_assoc($divQuery)) {
        $divNa   = $divRow['dev_name'];  
        $pdf->SetFont('Arial','',11);
        $pdf->Cell(130,10,$divRow['dev_name'],0,1,'L');
    }
}

$pdf->SetFont('Arial','B',11);
$pdf->Cell(63,10,"14. Team :",0,0);
// Select Team
if($teamId==0) {
    $teamNa = "";
    $pdf->SetFont('Arial','',11);
    $pdf->Cell(130,10,$teamNa,0,1,'L');
}else{
    $teamNa = "SELECT * FROM `team` WHERE `team_id` = $teamId";
    $teamQuery = mysqli_query($con, $teamNa);

    while ($teamRow = mysqli_fetch_assoc($teamQuery)) {
    $teamNa = $teamRow['team_name'];
    $pdf->SetFont('Arial','',11);
    $pdf->Cell(130,10,$teamRow['team_name'],0,1,'L');
    }
}
  
$pdf->SetFont('Arial','B',11);
$pdf->Cell(63,12,"15. Education Qualification :",0,0);  
 //Select Education Qualification.
if($eduId==0){
     $eduNa   = "";
    $pdf->SetFont('Arial','',11);
    $pdf->Cell(130,12,$eduNa,0,1,'L');
}else{
    $eduSQL = "SELECT * FROM `education` WHERE `edu_id` = $eduId";
    $eduQuery = mysqli_query($con, $eduSQL);
    while ($eduRow = mysqli_fetch_assoc($eduQuery)) {
        $eduNa   = $eduRow['edu_level'];
        $pdf->SetFont('Arial','',11);
        $pdf->Cell(130,12,$eduRow['edu_level'],0,1,'L');
    }
}


    //Merge Other Qualification Cell
        $cellwidth3 =130;
        $cellHeight3 =6;

        if ($pdf->GetStringWidth($extra_edu) < $cellwidth3) {
          $line=1;
        }else{
          $textLength=strlen($extra_edu);
          $errMargin=10;
          $startChar=0;
          $maxChar=0;
          $textArray=array();
          $tmpString="";

          while($startChar < $textLength) {
            while ($pdf ->GetStringWidth($tmpString) < ($cellwidth3-$errMargin) && ($startChar+$maxChar) < $textLength) {
              $maxChar++;
              $tmpString=substr($extra_edu,$startChar, $maxChar);
            }
            $startChar=$startChar+$maxChar;
            //Then add it into the array so we know how many line are needed
            array_push($textArray,$tmpString);
            //Reset maxChar and tmpString
            $maxChar=0;
            $tmpString='';
          }
          //Get Number of Line
          $line=count($textArray);
        }

        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(63,($line * $cellHeight3),"16. Other Qualifications :",0,0);
        $pdf->SetFont('Arial','',11);
       
        $xPos=$pdf->GetX();
        $yPos=$pdf->GetY();
        $pdf->MultiCell(130,$cellHeight3,$extra_edu,0,1);
        //Return the Position for next cell next to the multicell
        //and offset the x with multicell width
        $pdf->SetXY($xPos + $cellwidth3, $yPos);
      
        $pdf->Cell(130,($line * $cellHeight3),'',0,1);//Empty Line Space
        $pdf->Cell(130,7,'',0,1);
 

  //Merge Sports Cell
        $cellwidth4 =130;
        $cellHeight4 =6;

        if ($pdf->GetStringWidth($sports) < $cellwidth4) {
          $line=1;
        }else{
          $textLength=strlen($sports);
          $errMargin=10;
          $startChar=0;
          $maxChar=0;
          $textArray=array();
          $tmpString="";

          while($startChar < $textLength) {
            while ($pdf ->GetStringWidth($tmpString) < ($cellwidth4-$errMargin) && ($startChar+$maxChar) < $textLength) {
              $maxChar++;
              $tmpString=substr($sports,$startChar, $maxChar);
            }
            $startChar=$startChar+$maxChar;
            //Then add it into the array so we know how many line are needed
            array_push($textArray,$tmpString);
            //Reset maxChar and tmpString
            $maxChar=0;
            $tmpString='';
          }
          //Get Number of Line
          $line=count($textArray);
        }

        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(63,($line * $cellHeight4),"17. Extra Curricular Activities :",0,0);
        $pdf->SetFont('Arial','',11);
       
        $xPos=$pdf->GetX();
        $yPos=$pdf->GetY();
        $pdf->MultiCell(130,$cellHeight4,$sports,0,1);
        //Return the Position for next cell next to the multicell
        //and offset the x with multicell width
        $pdf->SetXY($xPos + $cellwidth4, $yPos);
      
        $pdf->Cell(130,($line * $cellHeight4),'',0,1);//Empty Line Space
        $pdf->Cell(130,7,'',0,1);

$pdf->SetFont('Arial','B',11);
$pdf->Cell(63,10,"18. Date of Join :",0,0);
$pdf->SetFont('Arial','',11);
$pdf->Cell(130,10,$e_doj,0,1,'L');

$pdf->SetFont('Arial','B',12);
$pdf->Cell(63,12,"19. Service Period (This Firm) :",0,0);
$pdf->SetFont('Arial','',11);
$pdf->Cell(130,12,$serPeriod,0,1,'L');


    //Merge Privious Company name Cell
        $cellwidth5 =130;
        $cellHeight5 =6;

        if ($pdf->GetStringWidth($other_company) < $cellwidth5) {
          $line=1;
        }else{
          $textLength=strlen($other_company);
          $errMargin=10;
          $startChar=0;
          $maxChar=0;
          $textArray=array();
          $tmpString="";

          while($startChar < $textLength) {
            while ($pdf ->GetStringWidth($tmpString) < ($cellwidth5-$errMargin) && ($startChar+$maxChar) < $textLength) {
              $maxChar++;
              $tmpString=substr($other_company,$startChar, $maxChar);
            }
            $startChar=$startChar+$maxChar;
            //Then add it into the array so we know how many line are needed
            array_push($textArray,$tmpString);
            //Reset maxChar and tmpString
            $maxChar=0;
            $tmpString='';
          }
          //Get Number of Line
          $line=count($textArray);
        }

        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(63,($line * $cellHeight5),"20. Privious Employeement :",0,0);
        $pdf->SetFont('Arial','',11);
       
        $xPos=$pdf->GetX();
        $yPos=$pdf->GetY();
        $pdf->MultiCell(130,$cellHeight5,$other_company,0,1);
        //Return the Position for next cell next to the multicell
        //and offset the x with multicell width
        $pdf->SetXY($xPos + $cellwidth5, $yPos);
      
        $pdf->Cell(130,($line * $cellHeight5),'',0,1);//Empty Line Space
        $pdf->Cell(130,7,'',0,1);


    //Merge Privious Occupation Cell
        $cellwidth6 =130;
        $cellHeight6 =6;

        if ($pdf->GetStringWidth($occupation) < $cellwidth6) {
          $line=1;
        }else{
          $textLength=strlen($occupation);
          $errMargin=10;
          $startChar=0;
          $maxChar=0;
          $textArray=array();
          $tmpString="";

          while($startChar < $textLength) {
            while ($pdf ->GetStringWidth($tmpString) < ($cellwidth6-$errMargin) && ($startChar+$maxChar) < $textLength) {
              $maxChar++;
              $tmpString=substr($occupation,$startChar, $maxChar);
            }
            $startChar=$startChar+$maxChar;
            //Then add it into the array so we know how many line are needed
            array_push($textArray,$tmpString);
            //Reset maxChar and tmpString
            $maxChar=0;
            $tmpString='';
          }
          //Get Number of Line
          $line=count($textArray);
        }

        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(63,($line * $cellHeight6),"21. Occupation : ",0,0);
        $pdf->SetFont('Arial','',11);
       
        $xPos=$pdf->GetX();
        $yPos=$pdf->GetY();
        $pdf->MultiCell(130,$cellHeight6,$occupation,0,1);
        //Return the Position for next cell next to the multicell
        //and offset the x with multicell width
        $pdf->SetXY($xPos + $cellwidth6, $yPos);
      
        $pdf->Cell(130,($line * $cellHeight6),'',0,1);//Empty Line Space
        $pdf->Cell(130,7,'',0,1);


    //Merge Privious Time Perioed Cell
        $cellwidth7 =130;
        $cellHeight7 =6;

        if ($pdf->GetStringWidth($time_period) < $cellwidth7) {
          $line=1;
        }else{
          $textLength=strlen($time_period);
          $errMargin=10;
          $startChar=0;
          $maxChar=0;
          $textArray=array();
          $tmpString="";

          while($startChar < $textLength) {
            while ($pdf ->GetStringWidth($tmpString) < ($cellwidth7-$errMargin) && ($startChar+$maxChar) < $textLength) {
              $maxChar++;
              $tmpString=substr($time_period,$startChar, $maxChar);
            }
            $startChar=$startChar+$maxChar;
            //Then add it into the array so we know how many line are needed
            array_push($textArray,$tmpString);
            //Reset maxChar and tmpString
            $maxChar=0;
            $tmpString='';
          }
          //Get Number of Line
          $line=count($textArray);
        }

        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(63,($line * $cellHeight7),"22. Service Period : ",0,0);
        $pdf->SetFont('Arial','',11);
       
        $xPos=$pdf->GetX();
        $yPos=$pdf->GetY();
        $pdf->MultiCell(130,$cellHeight7,$time_period,0,1);
        //Return the Position for next cell next to the multicell
        //and offset the x with multicell width
        $pdf->SetXY($xPos + $cellwidth7, $yPos);
      
        $pdf->Cell(130,($line * $cellHeight7),'',0,1);//Empty Line Space
        $pdf->Cell(130,7,'',0,1);


    //Merge Leader Ship Skill Cell
       /* $cellwidth8 =130;
        $cellHeight8 =6;

        if ($pdf->GetStringWidth($leadership) < $cellwidth8) {
          $line=1;
        }else{
          $textLength=strlen($leadership);
          $errMargin=10;
          $startChar=0;
          $maxChar=0;
          $textArray=array();
          $tmpString="";

          while($startChar < $textLength) {
            while ($pdf ->GetStringWidth($tmpString) < ($cellwidth8-$errMargin) && ($startChar+$maxChar) < $textLength) {
              $maxChar++;
              $tmpString=substr($leadership,$startChar, $maxChar);
            }
            $startChar=$startChar+$maxChar;
            //Then add it into the array so we know how many line are needed
            array_push($textArray,$tmpString);
            //Reset maxChar and tmpString
            $maxChar=0;
            $tmpString='';
          }
          //Get Number of Line
          $line=count($textArray);
        }

        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(63,($line * $cellHeight8),"20. Leadership Skills : ",0,0);
        $pdf->SetFont('Arial','',12);
       
        $xPos=$pdf->GetX();
        $yPos=$pdf->GetY();
        $pdf->MultiCell(130,$cellHeight8,$leadership,0,1);
        //Return the Position for next cell next to the multicell
        //and offset the x with multicell width
        $pdf->SetXY($xPos + $cellwidth8, $yPos);
      
        $pdf->Cell(130,($line * $cellHeight8),'',0,1);//Empty Line Space
        $pdf->Cell(130,7,'',0,1);
*/

    //Merge Remarks Cell
        $cellwidth9 =130;
        $cellHeight9 =6;

        if ($pdf->GetStringWidth($remarks) < $cellwidth9) {
          $line=1;
        }else{
          $textLength=strlen($remarks);
          $errMargin=10;
          $startChar=0;
          $maxChar=0;
          $textArray=array();
          $tmpString="";

          while($startChar < $textLength) {
            while ($pdf ->GetStringWidth($tmpString) < ($cellwidth7-$errMargin) && ($startChar+$maxChar) < $textLength) {
              $maxChar++;
              $tmpString=substr($remarks,$startChar, $maxChar);
            }
            $startChar=$startChar+$maxChar;
            //Then add it into the array so we know how many line are needed
            array_push($textArray,$tmpString);
            //Reset maxChar and tmpString
            $maxChar=0;
            $tmpString='';
          }
          //Get Number of Line
          $line=count($textArray);
        }

        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(63,($line * $cellHeight9),"23. Remarks : ",0,0);
        $pdf->SetFont('Arial','',11);
       
        $xPos=$pdf->GetX();
        $yPos=$pdf->GetY();
        $pdf->MultiCell(130,$cellHeight9,$remarks,0,1);
        //Return the Position for next cell next to the multicell
        //and offset the x with multicell width
        $pdf->SetXY($xPos + $cellwidth9, $yPos);
      
        $pdf->Cell(130,($line * $cellHeight9),'',0,1);//Empty Line Space
        $pdf->Cell(130,7,'',0,1);


$pdf->SetFont('Arial','B',11);
//$pdf->Cell(50,8,"Image",1,0);
//$pdf->Image($img,20,20,20);

//Make a dummy empty cell as a verticaly spacer
$pdf->Cell(130,20,'',0,1);//End of the Line

// SKILL TABLE
if($posId =="2" OR $posId =="3" OR $posId =="4" OR $posId =="5") {

$sqlSelect1 = "SELECT * FROM `skill` WHERE `emp_id` = '$emp_id'";
$sqlQuery1 = mysqli_query($con, $sqlSelect1);

while ($rowData = mysqli_fetch_assoc($sqlQuery1)) 
{
    if ($rowData['over_lock'] == "1") {
            $over_lock = "../images/ico/supper.png";
    }elseif ($rowData['over_lock'] == "2") {
            $over_lock = "../images/ico/skill.png";
    }elseif ($rowData['over_lock'] == "3") {
            $over_lock = "../images/ico/poor.png";
    }else{
            $over_lock = "../images/ico/noneSkill.png";
    }

    if ($rowData['flat_lock'] == "1") {
            $flat_lock = "../images/ico/supper.png";
    }elseif ($rowData['flat_lock'] == "2") {
            $flat_lock = "../images/ico/skill.png";
    }elseif ($rowData['flat_lock'] == "3") {
            $flat_lock = "../images/ico/poor.png";
    }else{
            $flat_lock = "../images/ico/noneSkill.png";
    }

    if ($rowData['single_needle'] == "1") {
            $single_needle = "../images/ico/supper.png";
    }elseif ($rowData['single_needle'] == "2") {
            $single_needle = "../images/ico/skill.png";
    }elseif ($rowData['single_needle'] == "3") {
            $single_needle = "../images/ico/poor.png";
    }else{
            $single_needle = "../images/ico/noneSkill.png";
    }

    if ($rowData['double_needle'] == "1") {
            $double_needle = "../images/ico/supper.png";
    }elseif ($rowData['double_needle'] == "2") {
            $double_needle = "../images/ico/skill.png";
    }elseif ($rowData['double_needle'] == "3") {
            $double_needle = "../images/ico/poor.png";
    }else{
            $double_needle = "../images/ico/noneSkill.png";
    }

    if ($rowData['bar_tack'] == "1") {
            $bar_tack = "../images/ico/supper.png";
    }elseif ($rowData['bar_tack'] == "2") {
            $bar_tack = "../images/ico/skill.png";
    }elseif ($rowData['bar_tack'] == "3") {
            $bar_tack = "../images/ico/poor.png";
    }else{
            $bar_tack = "../images/ico/noneSkill.png";
    }

    if ($rowData['button_hole'] == "1") {
            $button_hole = "../images/ico/supper.png";
    }elseif ($rowData['button_hole'] == "2") {
            $button_hole = "../images/ico/skill.png";
    }elseif ($rowData['button_hole'] == "3") {
            $button_hole = "../images/ico/poor.png";
    }else{
            $button_hole = "../images/ico/noneSkill.png";
    }

    if ($rowData['button_attach'] == "1") {
            $button_attach = "../images/ico/supper.png";
    }elseif ($rowData['button_attach'] == "2") {
            $button_attach = "../images/ico/skill.png";
    }elseif ($rowData['button_attach'] == "3") {
            $button_attach = "../images/ico/poor.png";
    }else{
            $button_attach = "../images/ico/noneSkill.png";
    }

     if ($rowData['picot'] == "1") {
            $picot = "../images/ico/supper.png";
    }elseif ($rowData['picot'] == "2") {
            $picot = "../images/ico/skill.png";
    }elseif ($rowData['picot'] == "3") {
            $picot = "../images/ico/poor.png";
    }else{
            $picot = "../images/ico/noneSkill.png";
    }


}

$pdf->SetFont('Arial','B',8);

$pdf->Cell(10,12,'',0,0);
$pdf->Cell(15,5,"Super  :",0,0); 
$pdf->Cell(10,5,$pdf->Image("../images/ico/supper.png", $pdf->GetX(), $pdf->GetY(),4,4),0,0,'');

$pdf->Cell(2,6,'',0,0);
$pdf->Cell(15,5,"Skill    :",0,0);
$pdf->Cell(10,5, $pdf->Image("../images/ico/skill.png", $pdf->GetX(5), $pdf->GetY(5),4),0,0,'');

$pdf->Cell(2,6,'',0,0);
$pdf->Cell(15,5,"Poor   :",0,0);
$pdf->Cell(10,5, $pdf->Image("../images/ico/poor.png", $pdf->GetX(5), $pdf->GetY(5),4),0,1,'');

//Make a dummy empty cell as a verticaly spacer
$pdf->Cell(100,3,'',0,1);//End of the Line

$pdf->SetFont('Arial','B',12);

$pdf->Cell(50,10,"Machine Type",1,0,'C');
$pdf->Cell(50,10,"Skill",1,1,'');

$pdf->Cell(50,10,'Over Lock',1,0);
$pdf->Cell(50,10,$pdf->Image($over_lock, $pdf->GetX(10), $pdf->GetY(),6,6,""),1,1);

$pdf->Cell(50,10,'Flat Lock',1,0);
$pdf->Cell(50,10, $pdf->Image($flat_lock, $pdf->GetX(20), $pdf->GetY(20),6,6),1,1,"");

$pdf->Cell(50,10,'Single Needle',1,0);
$pdf->Cell(50,10, $pdf->Image($single_needle, $pdf->GetX(), $pdf->GetY(),6,6),1,1,"");

$pdf->Cell(50,10,'Double Needle',1,0);
$pdf->Cell(50,10, $pdf->Image($double_needle, $pdf->GetX(), $pdf->GetY(),6,6),1,1,"");  

$pdf->Cell(50,10,'Bar Tack',1,0);
$pdf->Cell(50,10, $pdf->Image($bar_tack, $pdf->GetX(), $pdf->GetY(),6,6),1,1,'');

$pdf->Cell(50,10,'Button Hole',1,0);
$pdf->Cell(50,10, $pdf->Image($button_hole, $pdf->GetX(), $pdf->GetY(),6,6),1,1,'');

$pdf->Cell(50,10,'Button Attach',1,0);
$pdf->Cell(50,10, $pdf->Image($button_attach, $pdf->GetX(), $pdf->GetY(),6,6),1,1,'');

$pdf->Cell(50,10,'Picot',1,0);
$pdf->Cell(50,10, $pdf->Image($picot, $pdf->GetX(), $pdf->GetY(),6,6),1,1,'');

}

}

$pdf->output();

?>