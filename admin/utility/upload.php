<?php
set_include_path(get_include_path() . PATH_SEPARATOR . 'classes/');
include '../classes/PHPExcel/IOFactory.php';

if(isset($_POST['upload']))
{
    switch ($_POST['upload'])
    {
        case 'lawmakers':
            if(!empty($_FILES['excelfile']['tmp_name']))
            {
                $inputFileName = $_FILES['excelfile']['tmp_name'];
                try 
                { 
                    $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
                } 
                catch(Exception $e) 
                { 
                    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage()); 
                } 
                
                $allDataInSheet = $objPHPExcel->getSheet(0)->toArray(null,true,true,true); 
                $arrayCount = count($allDataInSheet);
                $lawmakers = array();
                
                $isInserted=0;
                $error_row = array();
                for($i=2; $i<=$arrayCount; $i++)
                {
                    $error = 0;
                        
                    $district = 0;
                    $const = 0;
                    
                    if($_POST['type'] == SENATOR)
                    {
                        $sql = "select id from districts where name=:name";
                        $q=$con->select_query($sql,array(':name'=>$allDataInSheet[$i]["B"]));
                        foreach($q as $r)
                        {
                            $district = $r['id'];
                        }
                    }
                    else if($_POST['type'] == HOUSE_OF_REPS)
                    {
                        $sql = "select id from constituency where name=:name";
                        $q=$con->select_query($sql,array(':name'=>$allDataInSheet[$i]["B"]));
                        foreach($q as $r)
                        {
                            $const = $r['id'];
                        }
                    }
                    $party = "";
                    $sql = "select id from party where name=:name OR abbrev=:name";
                    $q=$con->select_query($sql,array(':name'=>$allDataInSheet[$i]["E"]));
                    foreach($q as $r)
                    {
                        $party = $r['id'];
                    }
                    $sql = "insert into lawmakers (fullname,const_id,district_id,appointment_year,appointment_enddate,type,party,bio,date_created)
                        values (:fname,:const,:district,:apyear,:apenddate,:type,:party,:bio,:date)";
                    $fields = array(
                        ':fname'=>$allDataInSheet[$i]["A"],
                        ':const'=>$const,
                        ':district'=>$district,
                        ':apyear'=>$allDataInSheet[$i]["C"],
                        ':apenddate'=>$allDataInSheet[$i]["D"],
                        ':type'=>$_POST['type'],
                        ':party'=>$party,
                        ':bio'=>$allDataInSheet[$i]["F"],
                        ':date'=>date('d-m-Y')
                    );
                    $q=$con->insert_query($sql,$fields);
                    if($q)
                    {
                        $isInserted += 1;
                    }
                }  
                if($_POST['type'] == SENATOR)
                {
                    $text = "senators";
                }
                else if($_POST['type'] == HOUSE_OF_REPS) 
                {
                    $text = "reps";
                }
                    if($isInserted > 0)
                    {
                        echo '<div class="alert bg-success" role="alert">
        					<svg class="glyph stroked checkmark"><use xlink:href="#stroked-checkmark"></use></svg> '.$isInserted.' '.$text.' uploaded successfully. <a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a>
        				</div>';
                    }
                
            }
            break;
            
        case 'projects':
            if(!empty($_FILES['excelfile']['tmp_name']))
            {
                    $inputFileName = $_FILES['excelfile']['tmp_name'];
                    try 
                    { 
                        $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
                    } 
                    catch(Exception $e) 
                    { 
                        die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage()); 
                    } 
                    //$objPHPExcel->setActiveSheetIndex(0);
                    $isInserted=0;
                    $allSheets = $objPHPExcel->getAllSheets();
                    foreach($allSheets as $sheet)
                    {
                        $allDataInSheet = $sheet->toArray(null,true,true,true); 
                        $arrayCount = count($allDataInSheet);
                        
                        $error_row = array();
                        for($i=2; $i<=$arrayCount; $i++)
                        {
                            $error = 0;
    
                            $lawmakerid = "";
                            $lgaid = "";
                            $type= "";
                            $sql = "select id,type from lawmakers where fullname=:name";
                            $q=$con->select_query($sql,array(':name'=>$allDataInSheet[$i]["H"]));
                            foreach($q as $r)
                            {
                                $lawmakerid = $r['id'];
                                $type = $r['type'];
                            }
                            if(count($q) == 0)
                            {
                                $sql = "insert into lawmakers (fullname) values (:name)";
                                $con->insert_query($sql,array(':name'=>ucwords(strtolower($allDataInSheet[$i]["H"]))));
                                $lawmakerid = $con->lastID;
                                $type = "";
                            }
                            
                            //state
                            $stateid = "";
                            $sql = "select id from state where name=:name";
                            $q=$con->select_query($sql,array(':name'=>$allDataInSheet[$i]["B"]));
                            foreach($q as $r)
                            {
                                $stateid = $r['id'];
                            }
                            
                            //lga
                            $lgaid="";
                            if(isset($allDataInSheet[$i]["K"]))
                            {
                                $sql = "select id from localgovt where name=:name";
                                $q=$con->select_query($sql,array(':name'=>$allDataInSheet[$i]["K"]));
                                foreach($q as $r)
                                {
                                    $lgaid = $r['id'];
                                }
                            }
                            
                            //ministry
                            $ministryid = "";
                            $sql = "select id from mda where name=:name";
                            $q=$con->select_query($sql,array(':name'=>$allDataInSheet[$i]["E"]));
                            foreach($q as $r)
                            {
                                $ministryid = $r['id'];
                            }
                            if(count($q) == 0)
                            {
                                $sql = "insert into mda (name,type) values (:name,:type)";
                                $con->insert_query($sql,array(':name'=>$allDataInSheet[$i]["E"],':type'=>2));
                                $ministryid = $con->lastID;
                            }
                            
                            //agency
                            $agencyid = "";
                            $sql = "select id from mda where name=:name";
                            $q=$con->select_query($sql,array(':name'=>$allDataInSheet[$i]["D"]));
                            foreach($q as $r)
                            {
                                $agencyid = $r['id'];
                            }
                            if(count($q) == 0)
                            {
                                $sql = "insert into mda (name,type) values (:name,:type)";
                                $con->insert_query($sql,array(':name'=>$allDataInSheet[$i]["D"],':type'=>1));
                                $agencyid = $con->lastID;
                            }
                            
                            //project category
                            $categoryid = "";
                            if(isset($allDataInSheet[$i]["M"]))
                            {
                                $sql = "select id from projectcategory where name=:name";
                                $q=$con->select_query($sql,array(':name'=>$allDataInSheet[$i]["M"]));
                                foreach($q as $r)
                                {
                                    $categoryid = $r['id'];
                                }
                                if(count($q) == 0)
                                {
                                    $sql = "insert into mda (name) values (:name)";
                                    $con->insert_query($sql,array(':name'=>$allDataInSheet[$i]["M"]));
                                    $categoryid = $con->lastID;
                                }
                            }
                            
                            //contractor
                            $contractorid = "";
                            if(isset($allDataInSheet[$i]["L"]))
                            {
                                $sql = "select id from contractors where name=:name";
                                $q=$con->select_query($sql,array(':name'=>$allDataInSheet[$i]["L"]));
                                foreach($q as $r)
                                {
                                    $contractorid = $r['id'];
                                }
                                if(count($q) == 0)
                                {
                                    $sql = "insert into contractors (name,address,state_id) values (:name,:addr,:state)";
                                    $con->insert_query($sql, array(':name'=>$allDataInSheet[$i]["L"],':addr'=>"",':state'=>0));
                                    $contractorid = $con->lastID;
                                }
                            }
                            
                            //status
                            $status = "";
                            if(strcasecmp($allDataInSheet[$i]["C"], "completed") == 0)
                            {
                                $status = 1;
                            }
                            else if(strcasecmp($allDataInSheet[$i]["C"], "ongoing") == 0 || strcasecmp($allDataInSheet[$i]["C"], "on-going") == 0)
                            {
                                $status = 0;
                            }
                            else if(strcasecmp($allDataInSheet[$i]["C"], "abandoned") == 0)
                            {
                                $status = 2;
                            }
                            else if(strcasecmp($allDataInSheet[$i]["C"], "new") == 0)
                            {
                                $status = 3;
                            }
                            
                            $fiscalyear = "";
                            if(isset($allDataInSheet[$i]["I"]))
                            {
                                $fiscalyear = $allDataInSheet[$i]["I"];
                            }
                            
                            $location = "";
                            if(isset($allDataInSheet[$i]["J"]))
                            {
                                $location = $allDataInSheet[$i]["J"];
                            }
                            
                            $sql = "insert into projects (title,location,lga_id,state_id,lawmaker_id,amount_appr,amount_funded,ministry_id,year,status,type,date_created,projectcategory_id,agency_id,contractor_id)
                                values (:title,:loc,:lga,:state,:lawmaker,:appr,:fund,:min,:year,:status,:type,:date,:cat,:agency,:contr)";
                            $fields = array(
                                ':title'=>ucwords(strtolower($allDataInSheet[$i]["A"])),
                                ':loc'=>$location,
                                ':lga'=>$lgaid,
                                ':state'=>$stateid,
                                ':lawmaker'=>$lawmakerid,
                                ':appr'=>$allDataInSheet[$i]["F"],
                                ':fund'=>$allDataInSheet[$i]["G"],
                                ':min'=>$ministryid,
                                ':year'=>$fiscalyear,
                                ':status'=>$status,
                                ':type'=>$type,
                                ':date'=>date('d-m-Y'),
                                ':cat'=>$categoryid,
                                ':agency'=>$agencyid,
                                ':contr'=>$contractorid
                            );
                            $q=$con->insert_query($sql,$fields);
                            if($q)
                            {
                                $isInserted += 1;
                            }
                        } 
                    } 
                    
                        if($isInserted > 0)
                        {
                            echo '<div class="alert bg-success" role="alert">
            					<svg class="glyph stroked checkmark"><use xlink:href="#stroked-checkmark"></use></svg> '.$isInserted.' projects uploaded successfully. <a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a>
            				</div>';
                        }
                    
                }
            break;
            
        
    }
}
?>