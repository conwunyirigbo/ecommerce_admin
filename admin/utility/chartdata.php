<?php
include '../include/connection.php';
include('../include/app_config.php');
date_default_timezone_set('Africa/Lagos');

$today = date('d-m-Y');
//get previous 10 days
$views_data_pair = array();
$download_data_pair = array();

switch($_GET['span'])
{
    case 'days':
        
        for($i = 1; $i<=10; $i++)
        {    
            $ith_day = strtotime('-'.$i.' day', strtotime(date('d-m-Y')));
            $ith_day = date('d-m-Y', $ith_day);
            
            //views data
            $no_of_views_on_ith_day = 0;
            $sql = "select views from view_date where date_created=:date";
            $q = $con->select_query($sql,array(':date'=>$ith_day));
            foreach($q as $r)
            {
                $no_of_views_on_ith_day = $r['views'];
            }
            
            $views_data_pair[] = array('day'=>date('M d', strtotime($ith_day)), 'views'=>$no_of_views_on_ith_day);
            
            
            //download data
            $no_of_downloads_on_ith_day = 0;
            $sql = "select download_count from download_date where date_created=:date";
            $q = $con->select_query($sql,array(':date'=>$ith_day));
            foreach($q as $r)
            {
                $no_of_downloads_on_ith_day = $r['download_count'];
            }
            
            $download_data_pair[] = array('day'=>date('M d', strtotime($ith_day)), 'download_count'=>$no_of_downloads_on_ith_day);
        }
        break;
        
    case 'months':
        for($i = 1; $i<=12; $i++) //12 months
        {
            //views data
            $no_of_views_on_ith_month = 0;
            $sql = "select views from view_date where month=:month AND year=:year";
            $q = $con->select_query($sql,array(':month'=>$i,':year'=>date('Y')));
            foreach($q as $r)
            {
                $no_of_views_on_ith_month += $r['views'];
            }
        
            $monthName = date('M', mktime(0, 0, 0, $i, 10));
            
            $views_data_pair[] = array('day'=>$monthName.' '.date('Y'), 'views'=>$no_of_views_on_ith_month);
            
            
            //download data
            $no_of_downloads_on_ith_month = 0;
            $sql = "select download_count from download_date where month=:month AND year=:year";
            $q = $con->select_query($sql,array(':month'=>$i,':year'=>date('Y')));
            foreach($q as $r)
            {
                $no_of_downloads_on_ith_month += $r['download_count'];
            }
        
            $download_data_pair[] = array('day'=>$monthName.' '.date('Y'), 'download_count'=>$no_of_downloads_on_ith_month);
        }
        break;
        
    case 'years':
        $thisyear = date('Y');
        for($i = 0; $i<=9; $i++) //12 months
        {
            //views data
            $no_of_views_on_ith_year = 0;
            $sql = "select views from view_date where year=:year";
            $q = $con->select_query($sql,array(':year'=>$thisyear - $i));
            foreach($q as $r)
            {
                $no_of_views_on_ith_year += $r['views'];
            }
        
            $views_data_pair[] = array('day'=>$thisyear - $i, 'views'=>$no_of_views_on_ith_year);
        
        
            //download data
            $no_of_downloads_on_ith_year = 0;
            $sql = "select download_count from download_date where year=:year";
            $q = $con->select_query($sql,array(':year'=>$thisyear - $i));
            foreach($q as $r)
            {
                $no_of_downloads_on_ith_year += $r['download_count'];
            }
        
            $download_data_pair[] = array('day'=>$thisyear - $i, 'download_count'=>$no_of_downloads_on_ith_year);
        }
        break;
}

echo json_encode(array("view_data"=>$views_data_pair, 'download_data'=>$download_data_pair));
?>