<?php
require '../../Config/conect.php';
require '../../vendor/autoload.php';

use TCPDF;

class MYPDF extends TCPDF {
    public function Header() {
        $this->SetFont('helvetica', 'B', 14);
        $this->Cell(0, 10, 'Product List', 0, 1, 'C');
        $this->Ln(5);
    }
}

// Create new PDF document
$pdf = new MYPDF('L', 'mm', 'A4', true, 'UTF-8', false);

// Set document information
$pdf->SetCreator('POS System');
$pdf->SetAuthor('POS System');
$pdf->SetTitle('Product List');

// Set margins
$pdf->SetMargins(10, 20, 10);
$pdf->SetHeaderMargin(10);

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 10);

// Table headers
$headers = ['No.', 'Product Name', 'Category', 'Brand', 'Stock Date', 'Expired Date', 'Quantity', 'Unit Cost', 'Status', 'Unit'];
$widths = [10, 40, 25, 25, 25, 25, 20, 20, 20, 20];

// Colors for header
$pdf->SetFillColor(224, 224, 224);
$pdf->SetTextColor(0);
$pdf->SetFont('helvetica', 'B', 10);

// Print header
$x = $pdf->GetX();
$y = $pdf->GetY();
foreach ($headers as $index => $header) {
    $pdf->Cell($widths[$index], 10, $header, 1, 0, 'C', true);
}
$pdf->Ln();

// Reset text color and font
$pdf->SetTextColor(0);
$pdf->SetFont('helvetica', '', 9);

// Get the data
$sql = "SELECT 
    M.*,
    B.name AS brandName,
    C.name AS categoryname
    FROM `prdmaster` M
    INNER JOIN category C ON C.code=M.prdcategroy
    INNER JOIN brand B ON B.code=M.prdbrand";

$result = $con->query($sql);
$number = 1;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $status = ($row['isactive'] == 'A') ? 'Active' : 'Inactive';
        
        $data = [
            $number,
            $row['prdname'],
            $row['categoryname'],
            $row['brandName'],
            $row['stockdate'],
            $row['expdate'],
            $row['stockqty'],
            $row['unitcose'],
            $status,
            $row['unit']
        ];
        
        foreach ($data as $index => $value) {
            $pdf->Cell($widths[$index], 8, $value, 1, 0, 'C');
        }
        $pdf->Ln();
        $number++;
    }
}

// Close and output PDF document
$pdf->Output('ProductList.pdf', 'D');
