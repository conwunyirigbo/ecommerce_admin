<?php
session_start();
$menu = "login";
$group = "login";
$title = "Login";
include('header.php');

require_once 'vendor/autoload.php';
$fb = new \Facebook\Facebook([
    'app_id'      => '598989440822177',
    'app_secret'     => 'b7bbf4bf91da310155b44bfa8b05b27a',
    'default_graph_version'  => 'v2.10'
]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email', 'public_profile']; // Optional permissions
$loginUrl = $helper->getLoginUrl(APP_URL . '/facebook_callback.php', $permissions);
?>

<style>
.bottom_header
{
    display: none;
}
</style>


<!-- START MAIN CONTENT -->
<div class="main_content">

    <!-- START LOGIN SECTION -->
    <div class="login_register_wrap section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-md-10">
                    <div class="login_wrap">
                        <div class="padding_eight_all bg-white">
                            <div class="heading_s1">
                                <h3>Login</h3>
                            </div>
                            <form method="post" action="login">
                                <div class="form-group">
                                    <?php
                                    if (isset($_GET['error'])) {
                                        echo $_SESSION['error_msg'];
                                    }
                                    ?>
                                    <?php //$user->register("admin", "greenstoree@123", "greenstoree@123", "", 1, SUPER_ADMIN_USER_KEY, "Admin", "Admin");
                                    include('utility/logincode.php') ?>
                                </div>
                                <div class="form-group">
                                    <input type="text" required="" class="form-control" name="username" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" required="" type="password" name="password" placeholder="Password">
                                </div>
                                <div class="login_footer form-group">
                                    <div class="chek-form">
                                        <div class="custome-checkbox">
                                            <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox1" value="">
                                            <label class="form-check-label" for="exampleCheckbox1"><span>Remember me</span></label>
                                        </div>
                                    </div>
                                    <a href="forgot-password">Forgot password?</a>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="login" class="btn btn-fill-out btn-block" name="login">Log in</button>
                                </div>
                            </form>

                            <div>
                                <form method="post" action="login" class="login100-form p-l-55 p-r-55">
                                    <div class="container-login100-form-btn" style="margin-top: 20px;">
                                        <a href="<?php echo $loginUrl ?>" class="btn btn-facebook btn-block">
                                            <i class="ion-social-facebook"></i>
                                            Login with Facebook
                                        </a>
                                    </div>
                                </form>
                            </div>
                            <div class="different_login">
                                <span> or</span>
                            </div>

                            <?php
                            if (isset($_SESSION['redirect'])) {
                            ?>
                                <!-- <div>
                                    <form method="post" action="login" class="login100-form p-l-55 p-r-55">
                                        <div class="container-login100-form-btn" style="margin-top: 20px;">
                                            <button type="submit" name="no_login" class="btn btn-fill-out btn-block" style="background: #000" formnovalidate>
                                                Continue without Login
                                            </button>
                                        </div>
                                    </form>
                                </div> -->
                            <?php
                            }
                            ?>

                            <div class="form-note text-center">Don't Have an Account? <a href="sign-up">Sign up now</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END LOGIN SECTION -->

    <?php
    include('footer.php');
    ?>