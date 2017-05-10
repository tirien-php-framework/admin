<?php
Class Export
{
    public static function toXLSX( $data, $columns, $file_name = false )
    {
        if (!is_array($data)) {
            return null;
        }

        require_once('application/library/PHPExcel.php');

        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()
            ->setCreator("Admin")
            ->setLastModifiedBy("Admin")
            ->setTitle("Export");

        $objPHPExcel->setActiveSheetIndex(0);

        $objPHPExcel->getActiveSheet()->fromArray($columns);
        $objPHPExcel->getActiveSheet()->fromArray($data, null, 'A2');

        for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestDataColumn()); $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
        }

        $column_letters = array_keys($columns);

        foreach ($data as $row_key => $row) {
            $field_key = 0;

            foreach ($row as $value) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($column_letters[$field_key], $row_key+2, $value);
                $field_key++;
            }
        }

        if ($file_name === false) {
            $now = date("m_d_Y");
            $file_name = "export_{$now}.xlsx";    
        }

        $file_path = "public/uploads/".$file_name;
        $file_url = Path::urlBase("/uploads/".$file_name);

        //save file
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
        $objWriter->setOffice2003Compatibility(true);
        $objWriter->save($file_path);

        Router::go($file_url);

        exit;
    }

    public static function toXLScsv( $data, $columns, $file_name = false )
    {
        if (!is_array($data)) {
            return null;
        }

        if ($file_name === false) {
            $now = date("m_d_Y");
            $file_name = "export_{$now}.csv";    
        }

        header("Content-Disposition: attachment; filename='".$file_name."'");
        header("Content-Transfer-Encoding: binary");
        header("Pragma: no-cache");
        header("Expires: 0");

        ob_start();
        $df = fopen("php://output", 'w');
        fputcsv($df, $columns);

        foreach ($data as $row) {
          fputcsv($df, $row);
        }

        fclose($df);

        echo ob_get_clean();

        die();
    }    
}