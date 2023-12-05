<?php
if (isset($_POST['resetpassword'])) {
    $sql = "select email,id from users where email=:email";
    $q = $con->select_query($sql, array(':email' => $_POST['email']));
    if (count($q) > 0) {
        foreach ($q as $r) {
            $id = $r['id'];
        }
        $key = RandomString(12) . $id;
        $body = "<p>You recently requested for a password reset on your Greenstore Acount. Click on the link below to reset password</p>";
        $body .= '<a href="' . APP_URL . 'resetpassword?key=' . $key . '" style="display: inline-block; color: #fff; text-decoration:none; text-align: center; background-color: #0053a6; padding: 8px;">Reset Password</a>';
        $body .= "<p>If you did not request for password reset, please ignore this message.</p>";
        $sent = SendMessage("Password Reset", $_POST['email'], "Greenstore", $body, $con);
        if ($sent) {
            $con->update_query("update users set reset_key=:key where email=:email", array(':key' => $key, ':email' => $_POST['email']));
            echo '<div class="alert alert-success">Password reset link has been sent to your email. Check spam folder if mail is not in inbox.</div>';
        }
    } else {
        echo '<div class="alert alert-danger">Email address does not exist.</div>';
    }
}

if (isset($_POST['resetkey'])) {
    if ($_POST['repeatpassword'] == $_POST['newpassword']) {
        $email = "";
        $sql = "select email from users where reset_key=:key";
        $q = $con->select_query($sql, array(':key' => $_POST['resetkey']));
        if (count($q) > 0) {
            foreach ($q as $r) {
                $email = $r['email'];
            }
            $reset = $user->ResetPassword($_POST['newpassword'], $email, $con);
            if ($reset) {
                $con->update_query("update users set reset_key='' where reset_key=:key", array(':key' => $_POST['resetkey']));
                echo '<div class="alert alert-success">Password reset successful. <a href="login">Login</a></div>';
            }
        } else {
            echo '<div class="alert alert-danger">Invalid reset key</div>';
        }
    }
}
