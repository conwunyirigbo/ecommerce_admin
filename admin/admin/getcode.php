<?php
$code = "";
    if(isset($_GET['code']))
    {
        $code = strip_tags(strtolower($_GET['code']));
        $code = str_replace(' ', '-', $code);
        $code = str_replace(',', '', $code);
        $code = str_replace('\'', '', $code);
        $code = str_replace('&', '', $code);
        $code = str_replace('(', '', $code);
        $code = str_replace(')', '', $code);
        $code = str_replace('.', '', $code);
        $code = str_replace('/', '-', $code);
        $code = str_replace('+', '', $code);
        $code = str_replace('*', '', $code);
        $code = str_replace('#', '', $code);
        $code = str_replace(':', '', $code);
        $code = str_replace(';', '', $code);
        $code = iconv('UTF-8', 'UTF-8//IGNORE', $code);
        if(strlen($code) > 100)
        {
            $code = substr($code, 0, 99);
        }
    }
    echo $code;
?>