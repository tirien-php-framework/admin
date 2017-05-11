<?php
Class Export
{
    public static function toXLSX( $data, $file_name = null, $column_override = array() )
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

        $data = self::parseData($data, $column_override);

        $objPHPExcel->getActiveSheet()->fromArray($data, null);

        for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestDataColumn()); $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
        }

        if (empty($file_name)) {
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

    public static function toXLScsv( $data, $file_name = null, $column_override = array() )
    {
        if (!is_array($data)) {
            return null;
        }

        $data = self::parseData($data, $column_override);

        if (empty($file_name)) {
            $now = date("m_d_Y");
            $file_name = "export_{$now}.csv";    
        }

        header("Content-Disposition: attachment; filename='".$file_name."'");
        header("Content-Transfer-Encoding: binary");
        header("Pragma: no-cache");
        header("Expires: 0");

        ob_start();
        $df = fopen("php://output", 'w');

        foreach ($data as $row) {
          fputcsv($df, $row);
        }

        fclose($df);

        echo ob_get_clean();

        die();
    }

    private static function parseData($data, $column_override){
        $columns = array();

        foreach($data as $row_key => &$row){ 
            $row_keys = array_keys($row);
            $row_columns = array_combine($row_keys, $row_keys);
            $columns = array_merge($columns, $row_columns);
        }

        foreach($data as $row_key => &$row){ 
            $new_row = array();
            foreach ($columns as $column) {
                $new_row[$column] = empty($row[$column]) ? null : $row[$column]; 
            }
            $row = $new_row;
        }

        $columns = array_merge($columns, $column_override);

        array_unshift($data, $columns);

        return $data;
    }
}