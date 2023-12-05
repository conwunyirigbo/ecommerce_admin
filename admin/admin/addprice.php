<?php
session_start();
include('../include/connection.php');
$end = $_GET['count'];
$end++;
$text = '<tr>
                 <td>'.$end.'</td>
                                                                        <td>
                                                                            <select class="form-control" name="pricecolour'.$end.'">
                                                                                <option value="">--Color--</option>';
                                                                                
                                                                                    $sql = "select id,name from colour where status=1";
                                                                                    $q=$con->select_query($sql);
                                                                                    foreach($q as $r)
                                                                                    {
                                                                                        $selected = "";
                                                                                        if(isset($_GET['id']) && $_GET['id'] != "")
                                                                                        {
                                                                                            $sql = "select id from product_prices where productid=:post AND colourid=:id";
                                                                                            $a = $con->select_query($sql,array(':post'=>$_GET['id'],':id'=>$r['id']));
                                                                                            if(count($a) > 0)
                                                                                                $selected = "selected";
                                                                                        }
                                                                                        $text .='<option value="'.$r['id'].'" '.$selected.'>'.$r['name'].'</option>';
                                                                                    }
                                                                               
                                                                            $text .='</select>
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" class="form-control" name="productprice'.$end.'" placeholder="Price"/>
                                                                        </td>
                                                                    </tr>';
                                                                    
                                                                    echo json_encode(array('text'=>$text, 'count'=>$end));
                                                                    ?>