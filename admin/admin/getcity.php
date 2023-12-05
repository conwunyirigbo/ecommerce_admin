<?php
include('../include/connection.php');
?>

<select class="sizefull s-text7 p-l-22 p-r-22" multiple name="cityid<?php echo $_GET['i']?>[]" id="cityid<?php echo $_GET['i']?>">
<?php 
if(isset($_GET['stateid']))
{
    echo '<option value="1" selected>All Cities</option>';
    $sql = "select id,name from city where stateid=:id AND status=1";
    $q=$con->select_query($sql,array(':id'=>$_GET['stateid']));
    foreach($q as $r)
    {
        $selected = "";
        if(isset($_GET['id']) && $_GET['id'] != "")
        {
            $sql = "select id from delivery_fee where cityid=:city AND stateid=:state AND id=:id";
            $a = $con->select_query($sql,array(':id'=>$_GET['id'],':state'=>$_GET['stateid'],':city'=>$r['id']));
            if(count($a) > 0)
                $selected = "selected";
        }
        echo '<option value="'.$r['id'].'" '.$selected.'>'.$r['name'].'</option>';
    }
}
?>
</select>