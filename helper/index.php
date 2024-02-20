<?php
require '../vendor2/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

function excel_reader($files) {
    // Check if the file is uploaded properly
    if (is_uploaded_file($files['tmp_name'])) {
        $excelFile = $files['tmp_name'];
    } else {
        // Handle errors if the file is not uploaded properly
        return false;
    }

    $excelReader = IOFactory::createReaderForFile($excelFile);
    $excelObj = $excelReader->load($excelFile);
    
    $sheet = $excelObj->getActiveSheet();
    
    $highestRow = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();
    
    $highestColumnIndex = Coordinate::columnIndexFromString($highestColumn);
    
    $data = array();
    
    for ($row = 1; $row <= $highestRow; $row++) {
        $rowData = array();
        
        for ($col = 1; $col <= $highestColumnIndex; $col++) {
            $cellValue = $sheet->getCellByColumnAndRow($col, $row)->getValue();
            // Check if the cell contains a date formatted value
            if ($sheet->getCellByColumnAndRow($col, $row)->getStyle()->getNumberFormat()->getFormatCode() === 'd/m/yyyy') {
                $rowData[] = date('Y-m-d', strtotime($cellValue));
            } else {
                $rowData[] = $cellValue;
            }
        }
        
        $data[] = $rowData;
    }

    return $data;
}