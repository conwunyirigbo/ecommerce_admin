<?php
function RandomString($count)
{
    /*$randstr = "";
    srand((double) microtime(TRUE) * 1000000);
    //our array add all letters and numbers if you wish
    $chars = array(
        'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'p',
        'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '1', '2', '3', '4', '5',
        '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K',
        'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

    for ($rand = 0; $rand <= $length; $rand++) {
        $random = rand(0, count($chars) - 1);
        $randstr .= $chars[$random];
    }
    return $randstr;*/
    $firstrand = rand(0, 9999);
    $firstcharsno = strlen($firstrand);
    $character_set_array = array();
    $character_set_array[] = array('count' => $count - $firstcharsno, 'characters' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz');
    //$character_set_array[] = array('count' => $count, 'characters' => '');
    $temp_array = array();
    foreach ($character_set_array as $character_set) {
        for ($i = 0; $i < $character_set['count']; $i++) {
            $temp_array[] = $character_set['characters'][rand(0, strlen($character_set['characters']) - 1)];
        }
    }
    shuffle($temp_array);
    return $firstrand . implode('', $temp_array);
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function SendMessage($title, $recipient, $fromname, $body)
{
    $sent = false;
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 0;

        $mail->isSMTP();
        $mail->Host = 'sima.com.ng';
        $mail->SMTPAuth = true;
        $mail->Username = 'noreply@sima.com.ng';
        $mail->Password = '#baah)-gHH(j';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('admin@sima.com.ng');
        $mail->FromName = $fromname;
        $mail->addAddress($recipient);
        $mail->AddReplyTo('admin@sima.com.ng', 'Greenstore');
        $mail->isHTML(true);

        $mail->Subject = $title;
        $mail->Body    = $body;
        $mail->AltBody =  $body;
        if ($mail->send()) {
            $sent = true;
        } else {
            $sent = false;
        }
    } catch (phpmailerException $e) {
        //echo $e->errorMessage();
    }
    return $sent;
}

function SendMessage0($title, $recipient, $fromname, $body, $con = "")
{
    $sent = false;
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host       = 'sima.com.ng';
        $mail->SMTPAuth   = true;
        $mail->Username = 'noreply@sima.com.ng';
        $mail->Password = '#gJwIaTPj226';
        $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        // $mail->SMTPOptions = array(
        //     'ssl' => array(
        //         'verify_peer' => false,
        //         'verify_peer_name' => false,
        //         'allow_self_signed' => true
        //     )
        // );

        //Recipients

        $mail->From = 'noreply@sima.com.ng';
        $mail->FromName = $fromname;
        $mail->addAddress($recipient, $recipient);
        $mail->AddReplyTo('noreply@sima.com.ng', 'Greenstore');
        $mail->isHTML(true);

        $mail->setFrom('noreply@sima.com.ng', 'Greenstore');
        $mail->addAddress($recipient, $recipient);     //Add a recipient
        $mail->addReplyTo('noreply@sima.com.ng', 'Greenstore');
        // $mail->do_debug = 0;

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $title;
        $mail->Body    = $body;
        $mail->AltBody = $body;

        if ($mail->send()) {
            $sent = true;
        } else {
            $sent = false;
        }
    } catch (phpmailerException $e) {
        echo $e->errorMessage();
    }
    return $sent;
}

function paystack($customername, $amountkobo, $email, $callbackurl, $reference)
{
    /*$curl = curl_init();
     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
      
     curl_setopt_array($curl, array(
     CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
     CURLOPT_RETURNTRANSFER => true,
     CURLOPT_CUSTOMREQUEST => "POST",
     CURLOPT_POSTFIELDS => json_encode([
     'amount'=>$amountkobo,
     'email'=>$email,
     'callback_url'=>$callbackurl
     ]),
     CURLOPT_HTTPHEADER => [
     "authorization: Bearer ".SECRET_KEY,
     "content-type: application/json",
     "cache-control: no-cache"
     ],
     ));
      
     $response = curl_exec($curl);
     $err = curl_error($curl);*/

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $body = array(
        "email" => $email,
        "amount" => $amountkobo,
        "currency" => 'NGN',
        "reference" => $reference,
        "callback_url" => $callbackurl,
        "metadata" => array(
            array(
                "display_name" => $customername,
                "variable_name" => $email,
                "value" => $email
            )
        )
    );
    //the amount in kobo. This value is actually NGN 300
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => -1, //Maximum number of redirects
        CURLOPT_TIMEOUT => 0, //Timeout for request
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($body),
        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer " . SECRET_KEY,
            "Content-Type: application/json",
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        // there was an error contacting the Paystack API
        die('Curl returned error: ' . $err);
    }

    $tranx = json_decode($response);
    if (!$tranx->status) {
        // there was an error from the API
        die('API returned error: ' . $tranx->message);
    }

    // store transaction reference so we can query in case user never comes back
    // perhaps due to network issue
    //save_last_transaction_reference($tranx->data->reference);

    // redirect to page so User can pay
    //header('Location: ' . $tranx->data->authorization_url);
    echo '<script>window.location="' . $tranx->data->authorization_url . '"</script>';
}

function flutterwave($customername, $amount, $email, $callbackurl, $reference)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $body = array(
        "amount" => $amount,
        "currency" => 'NGN',
        "tx_ref" => $reference,
        "redirect_url" => $callbackurl,
        "payment_options" => array(1, 2, 8),
        "customer" => array(
            "email" => $email,
            "name" => $customername
        ),
        "customizations" => array(
            "logo" => APP_URL . "app-assets/images/logo/logo-half.png"
        )
    );
    //the amount in kobo. This value is actually NGN 300
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.flutterwave.com/v3/payments",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => -1, //Maximum number of redirects
        CURLOPT_TIMEOUT => 0, //Timeout for request
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($body),
        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer " . FLUTTERWAVE_SECRET_KEY,
            "Content-Type: application/json",
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        // there was an error contacting the Paystack API
        die('Curl returned error: ' . $err);
    }

    $tranx = json_decode($response);
    if (!empty($tranx->status) && $tranx->status == "success") {
        echo '<script>window.location="' . $tranx->data->link . '"</script>';
    } else {
        die('API returned error: ' . $tranx->message);
    }
}

function SendMessageToQueue($title, $body, $recipient, $sender, \database $con)
{
    $sql = "insert into message (title, recipient,sender,body,date_created) values (:title,:rec,:sender,:body,:date)";
    $fields = array(
        ':title' => $title,
        ':rec' => $recipient,
        ':sender' => $sender,
        ':body' => $body,
        ':date' => date('d-m-Y h:i a')
    );
    $con->insert_query($sql, $fields);
}

function ProductAPICount()
{
    $count = 0;
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.eposnowhq.com/api/v4/Product/Stats",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => -1, //Maximum number of redirects
        CURLOPT_TIMEOUT => 0, //Timeout for request
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_HTTPHEADER => array(
            "Authorization: Basic " . EPOS_SECRET_KEY,
            "Content-Type: application/json",
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    $result = json_decode($response);
    $total_products =  !empty($result) ? $result->TotalProducts : 0;

    $count = $total_products / 200;

    $count = ceil($count);
    return $count;
}

function sendNotification($message)
{
    $content = array(
        "en" => $message
    );
    $fields = array(
        'app_id' => "1b382dce-f5b4-4c73-832e-587575946ab2",
        'included_segments' => array('All'),
        'contents' => $content
    );
    $fields = json_encode($fields);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic ZDA4MzIzMWItZGQ2OS00ZTQxLWE2ZDQtMTIxZjc4NzAxMDhh'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}
