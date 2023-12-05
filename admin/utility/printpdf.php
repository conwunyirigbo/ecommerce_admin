<?php 
use \mikehaertl\wkhtmlto\Pdf;
$pdf = new Pdf('../templates/print.php');
if (!$pdf->saveAs('/path/to/page.pdf')) {
    $error = $pdf->getError();
    echo $error;
}
?>