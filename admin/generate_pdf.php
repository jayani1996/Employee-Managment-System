<?php

require ("../fpdf/fpdf.php");
include ("../dbconfig.php");
date_default_timezone_set('Asia/Colombo');
$con = new mysqli(DB_HOSTNAME,DB_USERNAME, DB_PASSWORD,DB_NAME);
//$db = new PDO('mysql:host=localhost;dbname=koggala','root','');

class myPDF extends FPDF
{
  function header()
  {
    $this->SetFont('Times','B',15);
    $this->Cell(12);

     //$this->Image('../fpdf/logo.png',15,10,15);

    $this->Cell(375,5,'Employee List',0,0,'C');
    $this->Ln();
    $this->SetFont('times','',13);
    $this->Cell(398,10,'Koggala Garments (pvt) Ltd',0,1,"C");
    $this->Ln(10);
    
  }
  function footer()
  {
    $this->SetY(-15);
    $this->SetFont('Arial','',11);
    $this->Cell(0,10,'Page'.$this->PageNo(),0,0,'C');
  }
  function headerTable()
  {
    $this->SetFont('Arial','B',10);
    $this->Cell(20,8,'EPF No',1,0,'C');
    $this->Cell(40,8,'Designation',1,0,'C');
     $this->Cell(70,8,'Name',1,0,'C');
    $this->Cell(70,8,'Address',1,0,'C');
    $this->Cell(27,8,'NIC',1,0,'C');
    $this->Cell(25,8,'Date of Birth',1,0,'C');
    $this->Cell(18,8,'Gender',1,0,'C');
    $this->Cell(25,8,'Mobile ',1,0,'C');
    $this->Cell(25,8,'Resident',1,0,'C');
    $this->Cell(25,8,'Date of Joined',1,0,'C');
    $this->Cell(35,8,'Division',1,0,'C');
    $this->Cell(25,8,'Team',1,0,'C');
   $this->Ln();
  }
 
}
$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('L','A3',0);
$pdf->headerTable();

$pdf->SetFont('Arial','',8);
$fontSize=10;
//if (isset($POST['submit'])) {
 
  $sqlSelect = "SELECT * FROM employee ORDER BY epf_no ASC";
  $query = mysqli_query($con,$sqlSelect);
 

  //Show Data in Table
  while ($data = mysqli_fetch_array($query)) 
  {
                
     $posId   = $data['position'];
     $devId   = $data['devision'];
     $teamId  = $data['team'];
     $address = $data['address'];
       
        
        //Wrapped cell width in "Address" colum
        $cellwidth2=70;
        //Normal one-line cell height
        $cellHeight2=8;

        if ($pdf->GetStringWidth($data['address']) < $cellwidth2) {
          $line=1;
        }else{
          $textLength=strlen($data['address']);
          $errMargin=10;
          $startChar=0;
          $maxChar=0;
          $textArray=array();
          $tmpString="";

          while($startChar < $textLength) {
            while ($pdf ->GetStringWidth($tmpString) < ($cellwidth2-$errMargin) && ($startChar+$maxChar) < $textLength) {
              $maxChar++;
              $tmpString=substr($data['address'],$startChar, $maxChar);
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


         /*==if ($pdf->GetStringWidth($data['ename']) < $cellwidth2) {
          $line=1;
        }else{
          $textLength=strlen($data['ename']);
          $errMargin=10;
          $startChar=0;
          $maxChar=0;
          $textArray=array();
          $tmpString="";

          while($startChar < $textLength) {
            while ($pdf ->GetStringWidth($tmpString) < ($cellwidth2-$errMargin) && ($startChar+$maxChar) < $textLength) {
              $maxChar++;
              $tmpString=substr($data['ename'],$startChar, $maxChar);
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
    ===*/


        //Write the Cell
        $pdf->Cell(20,($line * $cellHeight2),$data['epf_no'],1,0,'C');

         //Select Position Name
        if ($posId ==0) {
          $posNa = "";
          $pdf->SetFont('Arial','',10);
          $pdf->Cell(40,($line * $cellHeight2),$posNa,1,0,'L');
        }else{
          $posNa = "SELECT * FROM `position` WHERE `position_id` = $posId";
          $posQuery = mysqli_query($con, $posNa);
          while ($posRow = mysqli_fetch_assoc($posQuery)) 
          {
            $posNa = $posRow['position'];
            $pdf->SetFont('Times','',8);
            $pdf->Cell(40,($line * $cellHeight2),$posRow['position'],1,0,'L');
            
          }
        }

        // Srink Font Size Until It FIts The Cell Width 
        $cellwidth1 = 70;
        while ($pdf->GetStringWidth($data['ename'])>$cellwidth1) {
          $pdf->SetFont('Arial','',8);
        } 
        $pdf->Cell($cellwidth1,($line * $cellHeight2),$data['ename'],1,0,'L');
         //Reset Font Size to Standard
        $pdf->SetFont('Arial','',8);

       
        //Use MultiCell instead of Cell
        //but first, beacause MultiCell is always treated as line ending, need to 
        //manually set the xy position for the next cell to the next to it
        //the x and y position before writing the multicell
        $xPos=$pdf->GetX();
        $yPos=$pdf->GetY();
        $pdf->MultiCell(70,$cellHeight2,$data['address'],1);
        //Return the Position for next cell next to the multicell
        //and offset the x with multicell width
        $pdf->SetXY($xPos + $cellwidth2, $yPos);

        $pdf->Cell(27,($line * $cellHeight2),$data['nic'],1,0,'L');

        $pdf->Cell(25,($line * $cellHeight2),$data['dob'],1,0,'C');

        $pdf->Cell(18,($line * $cellHeight2),$data['gender'],1,0,'C');

        $pdf->Cell(25,($line * $cellHeight2),$data['tel_personal'],1,0,'C');

        $pdf->Cell(25,($line * $cellHeight2),$data['tel_home'],1,0,'C'); 

        $pdf->Cell(25,($line * $cellHeight2),$data['e_doj'],1,0,'C');

         //Select Divition Name.
        if($devId==0){
            $divNa   = "";
            $pdf->SetFont('Arial','',8);
            $pdf->Cell(35,($line * $cellHeight2),$divNa,1,0,'L');

        }else{
            $divNa         = "SELECT * FROM `devision` WHERE `dev_id` = $devId";
            $divQuery      = mysqli_query($con, $divNa);

            while ($divRow = mysqli_fetch_assoc($divQuery)) {
                $divNa   = $divRow['dev_name'];  
                $pdf->SetFont('Arial','',8);
                $pdf->Cell(35,($line * $cellHeight2),$divRow['dev_name'],1,0,'L');
            }
        }        
        
        // Select Team
        if ($teamId == 0) {
          $teamNa = "";
          $pdf->SetFont('Arial','',8);
          $pdf->Cell(25,($line * $cellHeight2),$teamNa,1,1,'L');

        }else{
          $teamNa = "SELECT * FROM `team` WHERE `team_id` = $teamId";
          $teamQuery = mysqli_query($con, $teamNa);

          while ($teamRow = mysqli_fetch_assoc($teamQuery)) {
            $teamNa = $teamRow['team_name'];
            $pdf->SetFont('Arial','',8);
            $pdf->Cell(25,($line * $cellHeight2),$teamRow['team_name'],1,1,'L');
          }
        }
        
    //}   
  }

$pdf->output();
?>