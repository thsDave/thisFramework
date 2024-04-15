<?php
require_once '../main.php';

// Incluir la librería PhpSpreadsheet
require 'vendor/autoload.php';

// Crear una instancia de la clase Spreadsheet
$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

// Configurar las propiedades del documento
$spreadsheet->getProperties()
    ->setCreator($_SESSION[USER_SESSION]['email'])
    ->setTitle(LANG['report_doc_title_users']);

// Crear una hoja de cálculo activa
$sheet = $spreadsheet->getActiveSheet();

// Agregar encabezados de columna
$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('B1', LANG['field_email']);
$sheet->setCellValue('C1', LANG['field_lang']);
$sheet->setCellValue('D1', LANG['field_status']);

// Obtenemos los datos

$user = $model->user_list();

$no = 1;

// Agregar datos a la hoja de cálculo

foreach ($user['id'] as $i => $value) {
    $data[] = [ $no, $user['email'][$i], $user['language'][$i], $user['status'][$i] ];
    $no++;
}

// Iniciar desde la segunda fila
$row = 2;

// Iterar sobre los datos y agregarlos a la hoja de cálculo
foreach ($data as $rowData) {
    $column = 'A';
    foreach ($rowData as $cellData) {
        $sheet->setCellValue($column . $row, $cellData);
        $column++;
    }
    $row++;
}

// Especificar el tipo de archivo y el nombre del archivo
$filename = LANG['report_name_doc_users'].date("dmY-His").'.xlsx';

// Configurar el objeto de escritura
$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

// Guardar el archivo en el servidor

//$writer->save($filename);

// Descargar el archivo generado
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'. $filename .'"');
header('Cache-Control: max-age=0');

$writer->save('php://output');