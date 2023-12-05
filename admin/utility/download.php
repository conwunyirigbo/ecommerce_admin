<?php
session_start();
include('../include/connection.php');
include('../include/app_config.php');
include('../lib/app_stat.php');
set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
include '../classes/PHPExcel/IOFactory.php';

if(isset($_GET['download']))
{
    switch ($_GET['download'])
    {
        case 'users':
                $objPHPExcel = new \PHPExcel();
                // Set properties
                $objPHPExcel->getProperties()->setCreator("JCMR")
                ->setLastModifiedBy("JCMR")
                ->setTitle("JCMR End Users")
                ->setSubject("JCMR End Users")
                ->setDescription("JCMR End Users, Generated by JCMR.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("JCMR End Users");
                $objPHPExcel->getActiveSheet()->setTitle('JCMR End Users');
                
                
                $objPHPExcel->getActiveSheet()->setCellValue('A2', 'S/N');
                $objPHPExcel->getActiveSheet()->setCellValue('B2', 'Email');
                $objPHPExcel->getActiveSheet()->setCellValue('C2', 'Full Name');
                $objPHPExcel->getActiveSheet()->setCellValue('D2', 'Status');
                $objPHPExcel->getActiveSheet()->setCellValue('E2', 'Date Created');
                
                 
                $filter = array();
                $sql="select * from users";

                $fields[':user'] = USER_KEY;
                $conditions[] = "role = :user";
                
                if(isset($_GET['searchkey']) && $_GET['searchkey'] !="") {
                    $conditions[] = "(firstname LIKE :searchkey OR lastname LIKE :searchkey OR email LIKE :searchkey)";
                    $keyword = '%'.$_GET['searchkey'].'%';
                    $fields[':searchkey'] = $keyword;
                }
                if (count($conditions) > 0) {
                    $sql .= " WHERE " . implode(' AND ', $conditions);
                }
                $sql .= " order by email";
                
                $q=$con->select_query($sql,$fields);
                $sn=1;
                $i = 3;
                foreach($q as $r)
                {
                
                    $issue_padded_id = str_pad($r['id'],4,"0",STR_PAD_LEFT);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i, $sn);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i, $r['email']);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i, $r['firstname'].' '.$r['lastname']);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i, strip_tags(GetStatus($r['is_active'])));
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i, $r['date_created']);
                
                    $i++;
                    $sn++;
                }
                $filtertext = "";
                $header_title = strtoupper('End Users');
                if(!empty($filter))
                {
                    $filtertext = implode(' > ', $filter);
                    $header_title = strtoupper('End Users ('.$filtertext.')');
                }
                $objPHPExcel->getActiveSheet()->setCellValue('A1',$header_title);
                $objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
                $header = 'A1:E1';
                $sheet = $objPHPExcel->getSheet(0);
                $sheet->getStyle($header)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('e1e1e1');
                $style = array(
                    'font' => array('bold' => true),
                    'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
                );
                $sheet->getStyle('A1:E1')->applyFromArray($style);
                
                $header = 'A2:E2';
                $sheet = $objPHPExcel->getSheet(0);
                $sheet->getStyle($header)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('119fff');
                $style = array(
                    'font' => array('bold' => true),
                    'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
                );
                $sheet->getStyle($header)->applyFromArray($style);
                for ($col = ord('a1'); $col <= ord('e1'); $col++)
                {
                $sheet->getColumnDimension(chr($col))->setAutoSize(true);
                }
                $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                
                // If you want to output e.g. a PDF file, simply do:
                //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
                //header('Content-type: application/vnd.ms-excel');
                $filename = '../jcmr_end_users_report.xlsx';
                $objWriter->save($filename);
                echo $filename;
                break;
    }
}