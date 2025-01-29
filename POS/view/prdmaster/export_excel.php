<?php
require '../../Config/conect.php';
require '../../vendor/autoload.php'; // You'll need to install PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Create new Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set the headers
$headers = ['No.', 'Product Name', 'Category', 'Brand', 'Stock Date', 'Expired Date', 'Quantity', 'Unit Cost', 'Status', 'Unit'];
$col = 'A';
foreach ($headers as $header) {
    $sheet->setCellValue($col . '1', $header);
    $sheet->getColumnDimension($col)->setAutoSize(true);
    $col++;
}

// Style the header row
$headerStyle = [
    'font' => ['bold' => true],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'E0E0E0']
    ]
];
$sheet->getStyle('A1:' . --$col . '1')->applyFromArray($headerStyle);

// Get the data
$sql = "SELECT 
    M.*,
    B.name AS brandName,
    C.name AS categoryname
    FROM `prdmaster` M
    INNER JOIN category C ON C.code=M.prdcategroy
    INNER JOIN brand B ON B.code=M.prdbrand";

$result = $con->query($sql);
$row_number = 2;
$number = 1;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $status = ($row['isactive'] == 'A') ? 'Active' : 'Inactive';
        
        $sheet->setCellValue('A' . $row_number, $number);
        $sheet->setCellValue('B' . $row_number, $row['prdname']);
        $sheet->setCellValue('C' . $row_number, $row['categoryname']);
        $sheet->setCellValue('D' . $row_number, $row['brandName']);
        $sheet->setCellValue('E' . $row_number, $row['stockdate']);
        $sheet->setCellValue('F' . $row_number, $row['expdate']);
        $sheet->setCellValue('G' . $row_number, $row['stockqty']);
        $sheet->setCellValue('H' . $row_number, $row['unitcose']);
        $sheet->setCellValue('I' . $row_number, $status);
        $sheet->setCellValue('J' . $row_number, $row['unit']);

        $row_number++;
        $number++;
    }
}

// Set the header for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="ProductList.xlsx"');
header('Cache-Control: max-age=0');

// Create Excel file
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
