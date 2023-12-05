<?php
include('../include/connection.php');
switch($_GET['property'])
{
    case 'colours':
        $sql = "select id,name from colour where status=1";
        $q=$con->select_query($sql);
        foreach($q as $r)
        {
            echo '<option value="'.$r['id'].'">'.$r['name'].'</option>';
        }
        break;
        
    case 'brands':
        $sql = "select id,name from brand where status=1";
        $q=$con->select_query($sql);
        foreach($q as $r)
        {
            echo '<option value="'.$r['id'].'">'.$r['name'].'</option>';
        }
        break;
}
?>