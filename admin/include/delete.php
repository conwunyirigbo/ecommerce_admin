<?php
if(isset($_POST['delete']))
{
    switch ($_POST['delete'])
    {
        case 'deletemenugroup':
            $sql="delete from menugroup where Code=:code";
            $field=array(':code'=>$_POST['groupcode']);
            $r=$con->delete_query($sql,$field);
            if($r)
            {
                echo '<script>window.location="../admin/menu_group_list"</script>';
            }
            break;
        case 'deletemenuitem':
            $sql="delete from menuitem where Code=:code";
            $field=array(':code'=>$_POST['menucode']);
            $r=$con->delete_query($sql,$field);
            if($r)
            {
                echo '<script>window.location="../admin/menu_item_list"</script>';
            }
            break;
            
        case 'deleterole':
            $sql="select roleid from roleauth where roleid=:id";
            $field=array(':id'=>$_POST['roleid']);
            $q=$con->select_query($sql,$field);
            if(count($q)>0)
            {
                echo '<script>alert("Role already has some authorization rules set, hence cannot delete");</script>';
            }
            else 
            {
                $sql="select roleid from user_roles where roleid=:id";
                $field=array(':id'=>$_POST['roleid']);
                $q=$con->select_query($sql,$field);
                if(count($q)>0)
                {
                    echo '<script>alert("Role already attached to user, hence cannot delete");</script>';
                }
                else 
                {
                    $sql="delete from roles where id=:id";
                    $field=array(':id'=>$_POST['roleid']);
                    $q=$con->delete_query($sql,$field);
                    if($q)
                    {
                        echo '<script>window.location="../admin/role_list"</script>';
                    }
                }
            }
            
            break;
            
            
         
    }
}

if(isset($_POST['delete']))
{
    switch ($_POST['delete'])
    {
        case 'lawmakers':
            $sql = "delete from lawmakers where id=:id";
            $q=$con->delete_query($sql,array(':id'=>$_POST['lawmakerid']));
            if($q)
            {
                echo '<script>window.location="../admin/lawmakers_list"</script>';
            }
            break;
            
        case 'projects':
            $sql = "delete from projects where id=:id";
            $q=$con->delete_query($sql,array(':id'=>$_POST['projectid']));
            if($q)
            {
                echo '<script>window.location="../admin/project_list"</script>';
            }
            break;
            case 'deleteuser':
                $sql="delete from users where id=:id";
                $fields=array(':id'=>$_POST['userid']);
                if($con->delete_query($sql,$fields))
                {
                    echo '<script>window.location="../admin/users"</script>';
                }
                break;
    }
}
?>