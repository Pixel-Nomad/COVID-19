<?php
require('../../config.php');
require '../../vendor/phpmailer/Exception.php';
require '../../vendor/phpmailer/PHPMailer.php';
require '../../vendor/phpmailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
$alert = "";
$wrong = "";
if (isset($_SESSION['isloggedin'])) {
    if (!$_SESSION['Verified']) {
        $connection = mysqli_connect($config['DB_URL'], $config['DB_USERNAME'], $config['DB_PASSWORD'], $config['DB_DATABASE']);
        if (isset($_POST['getcode'])){
            $email = $_SESSION['user-email'];
            $sql = "SELECT * FROM `codes` WHERE `mail` = '$email' AND `type` = 'verify'";
            $result = mysqli_query($connection, $sql);
            $total  = mysqli_num_rows($result);
            if ($total >= 1) {
                while ($row = mysqli_fetch_assoc($result)){
                    $code = $row['code'];
                    $mail = new PHPMailer(true);
                        try {
                            $mail->isSMTP();
                            $mail->Host       = 'smtp.gmail.com';
                            $mail->SMTPAuth   = true;
                            $mail->Username   = 'mr.tgamer247797704@gmail.com'; 
                            $mail->Password   = 'seasiuyldxhdnahs';
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                            $mail->Port       = 587;
                            // Recipients
                            $mail->setFrom('mr.tgamer247797704@gmail.com', 'NoReply - Verification Code');
                            $mail->addAddress($_SESSION['user-email'], $_SESSION['user-email']); // Email and name of recipient
                            
                            // Content
                            $mail->isHTML(true); // Set email format to HTML
                            $mail->Subject = 'Verification Code Request';
                            $mail->Body    = 'This is Your Code:'.$code;

                            $mail->send();
                            $wrong = '<div class="row row-cols-1 row-cols-md-3">
                                <div class="col">
                                    <div class="alert alert-warning text-success" role="alert">
                                        Code Sended
                                    </div>
                                </div>
                            </div>';
                        } catch (Exception $e) {
                            goto  SkipChecks;
                        }
                }
            } else {
                GenerateCode:
                $randomNumber = mt_rand(10000000, 99999999);
                $sql2 = "SELECT * FROM `codes` WHERE `mail`= '$email' AND `type`='verify' AND `code`= '$randomNumber'";
                $result2 = mysqli_query($connection,$sql2);
                $total2  = mysqli_num_rows($result2);
                if ($total2 == 1) {
                    goto GenerateCode;
                } else {
                    $sql3 = "INSERT INTO `codes`( `mail`, `type`, `code`) VALUES (
                        '$email', 'verify','$randomNumber')";
                    echo $sql3;
                    $query = mysqli_query($connection, $sql3);
                    if (!$query){ 
                        $wrong = '<div class="row row-cols-1 row-cols-md-3">
                            <div class="col">
                                <div class="alert alert-danger text-center" role="alert">
                                    Failed To Get Code Try Again
                                </div>
                            </div>
                        </div>';
                    } else {
                        $mail = new PHPMailer(true);
                        try {
                            $mail->isSMTP();
                            $mail->Host       = 'smtp.gmail.com';
                            $mail->SMTPAuth   = true;
                            $mail->Username   = 'mr.tgamer247797704@gmail.com'; 
                            $mail->Password   = 'seasiuyldxhdnahs';
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                            $mail->Port       = 587;
                            // Recipients
                            $mail->setFrom('mr.tgamer247797704@gmail.com', 'NoReply - Verification Code');
                            $mail->addAddress($_SESSION['user-email'], $_SESSION['user-email']); // Email and name of recipient
                            
                            // Content
                            $mail->isHTML(true); // Set email format to HTML
                            $mail->Subject = 'Verification Code Request';
                            $mail->Body    = 'This is Your Code:'.$randomNumber;

                            $mail->send();
                            $wrong = '<div class="row row-cols-1 row-cols-md-3">
                                <div class="col">
                                    <div class="alert alert-warning text-success" role="alert">
                                        Code Sended
                                    </div>
                                </div>
                            </div>';
                        } catch (Exception $e) {
                            goto  SkipChecks;
                        }
                    }
                    SkipChecks:
                    header('location: '.$config['URL'].'/user/verify');
                    exit();
                }
            }
        }
        if (isset($_POST['verify'])){
            $email = $_SESSION['user-email'];
            $code = $_POST['VerificationCode'];
            $sql = "SELECT * FROM `codes` WHERE `mail` = '$email' AND `type` = 'verify' AND `code` = '$code'";
            $result = mysqli_query($connection, $sql);
            $total  = mysqli_num_rows($result);
            if ($total >= 1) {
                $user_id = $_SESSION['user-id'];
                $sql2 = "DELETE FROM `codes` WHERE `mail` = '$email' AND `type`='verify'";
                $sql3 = "UPDATE `users` SET `verified`='true' WHERE user_id = '$user_id'";
                $result2 = mysqli_query($connection,$sql2);
                $result3 = mysqli_query($connection,$sql3);
                if ($result3) {
                    $_SESSION['Verified'] = true;
                    header('location: '.$config['URL']);
                    exit();
                }
            } else {
                $wrong = '<div class="row row-cols-1 row-cols-md-3">
                    <div class="col">
                        <div class="alert alert-danger text-center" role="alert">
                            Wrong Code Try Again
                        </div>
                    </div>
                </div>';
            }
        }
    } else {
        if (isset($_SERVER['HTTP_REFERER'])) {
            header('location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            header('location: ' . $config['URL']);
            exit();
        }
    }
} else {
    if (isset($_SERVER['HTTP_REFERER'])) {
        header('location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        header('location: ' . $config['URL']);
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify</title>
    <link rel="icon" href='<?php echo $config['URL'] ?>/assets/image/fav/fav.ico' type="image/x-icon">
    <link rel="shortcut icon" href='<?php echo $config['URL'] ?>/assets/image/fav/fav.ico' type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo $config['URL'] ?>/assets/css/global.css">
</head>

<body style="background-color: <?php echo $config['THEME_COLOR'] ?>;">
    <br>
    <br>
    <br>
    <div class="container">
        <div class="alert alert-warning" role="alert">
            <h4 class="alert-heading">Verify!</h4>
            <p>Please verify your email address before proceeding to any page. It is necessary to ensure everything is secured for you.</p>
            <hr>
            <p class="mb-0">
            <form method="post">
                <input type="submit" name="getcode" class="remove-submit-button text-primary" value="Get Verification code!">
            </form>
            </p>
        </div>
        <br>
        <br>
        <br>
        <form method="post">
            <div class="input-group mb-3">
                <div class="form-floating">
                    <input type="number" class="form-control" required name="VerificationCode" id="floatingInput" placeholder="name@example.com">
                    <label for="floatingInput">Enter Verification Code</label>
                </div>
                <input type="submit" class="btn btn-primary" id="button-addon2" value="Verify" name="verify">
            </div>
        </form>
        <?php
            echo $wrong
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="<?php echo $config['URL'] ?>/assets/js/global.js"></script>
</body>

</html>