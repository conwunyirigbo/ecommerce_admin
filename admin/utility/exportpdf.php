<?php session_start();
require_once("../dompdf/dompdf_config.inc.php");
include('../include/app_config.php');
$html =
  '<html>
  <body>
  	<style>
    h1,h2,h3,h4,h5
    {
        font-family:\'Helvetica\'";
    }
	table
	{
	font-family:\'Helvetica\'";
	line-height: 15px;
	text-align: left;
	min-width:600px;
    border:1px solid #eee;
	width: 100%;
	}
    .tablesession
	{
	font-family:\'Helvetica\'";
	line-height: 24px;
	
	text-align: left;
	min-width:730px;
    margin-bottom:20px;
	
	}
    tbody:before, tbody:after
    {
        display:none;
    }
    thead:before, thead:after
    {
        display:none;
    }
    .report-table{margin-left:20px;}
        .report-table tr:nth-child(odd) {background: #eee}
        .report-table tr:nth-child(even) {background: #FFF}
         tr:nth-child(odd) {border: #eee}
         tr:nth-child(even) {border: #eee}
		td, th
		{
          border:1px solid #eee;
    font-size:11px;
		  padding: 5px 5px 0px 5px;
		  width:auto; height:auto; 
		  line-height: 20px;
		  text-align: left;
		  vertical-align: top;
		} 
		@font-face {
          font-family: \'Open Sans\';
          font-style: normal;
          src: url(http://themes.googleusercontent.com/static/fonts/opensans/v8/cJZKeOuBrn4kERxqtaUH3aCWcynf_cDxXwCLxiixG1c.ttf) format(\'truetype\');
        }
        
        h2
        {
            text-transform:uppercase;
            text-align:center;
        }
		
		
	h5
	{
		display:block;
		padding-bottom:20px;
		border-bottom:1px solid #ccc;
		font-family:\'Calibri\'";
		color:#FF9900;
		
		
	}
</style>
    <center><img src="'.APP_URL.'assets/images/logo.png" style="width: 200px"/></center>'
    .$_SESSION['report'].'
</body></html>';

	
$filename = $_SESSION['filename'].".pdf";

$dompdf = new DOMPDF();
$dompdf->set_paper('letter', 'landscape');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream($filename);
?>
