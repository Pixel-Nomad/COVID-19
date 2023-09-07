<?php
require('../../config.php');
require '../../vendor/phpmailer/Exception.php';
require '../../vendor/phpmailer/PHPMailer.php';
require '../../vendor/phpmailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
$alert = "";
$emailsection = true;
$codesection = false;
$resetsection = false;
if (!isset($_SESSION['isloggedin'])) {
    $connection = mysqli_connect($config['DB_URL'], $config['DB_USERNAME'], $config['DB_PASSWORD'], $config['DB_DATABASE']);
    if ($connection) {
        if (isset($_POST['checkemail'])){
            $email      = htmlentities($_POST['email']);
            $sql = "SELECT * FROM `users` WHERE `email`= '$email'";
            $result = mysqli_query($connection, $sql);
            $total  = mysqli_num_rows($result);
            if ($total >= 1) {
                $_SESSION['forget-email'] = $email;
                $sql = "SELECT * FROM `codes` WHERE `mail` = '$email' AND `type` = 'forget'";
                $result = mysqli_query($connection, $sql);
                $total  = mysqli_num_rows($result);
                if ($total >= 1) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $code = $row['code'];
                        $mail = new PHPMailer(true);
                        try {
                            $mail->isSMTP();
                            $mail->Host       = 'smtp.gmail.com';
                            $mail->SMTPAuth   = true;
                            $mail->Username   = 'emergency.med.svc@gmail.com';
                            $mail->Password   = 'kjovncbmradpqhvu';
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                            $mail->Port       = 587;
                            // Recipients
                            $mail->setFrom('emergency.med.svc@gmail.com', 'NoReply - Emergency Medical Center');
                            $mail->addAddress($_SESSION['forget-email'], $_SESSION['forget-email']); // Email and name of recipient

                            // Content
                            $mail->isHTML(true); // Set email format to HTML
                            $mail->Subject = 'Email Verifcation';
                            $emailBody = file_get_contents($config['URL'].'/emails/verify.html'); // Load the HTML template
                            $emailBody = str_replace('{VERIFICATION_CODE}', $code, $emailBody);
                            $emailBody = str_replace('{email}', substr($_SESSION['user-email'], 0, strpos($_SESSION['user-email'], "@")), $emailBody);
                            $mail->Body = $emailBody;

                            $mail->send();
                            $wrong = '<div class="row row-cols-1 row-cols-md-3">
                                <div class="col">
                                    <div class="alert alert-warning text-success" role="alert">
                                        Code Sended
                                    </div>
                                </div>
                            </div>';
                            goto SkipChecks;
                        } catch (Exception $e) {
                            goto  SkipChecks;
                        }
                    }
                } else {
                    GenerateCode:
                    $randomNumber = mt_rand(100000, 999999);
                    $sql2 = "SELECT * FROM `codes` WHERE `mail`= '$email' AND `type`='forget' AND `code`= '$randomNumber'";
                    $result2 = mysqli_query($connection, $sql2);
                    $total2  = mysqli_num_rows($result2);
                    if ($total2 >= 1) {
                        goto GenerateCode;
                    } else {
                        $sql3 = "INSERT INTO `codes`( `mail`, `type`, `code`) VALUES (
                            '$email', 'forget','$randomNumber')";
                        $query = mysqli_query($connection, $sql3);
                        if (!$query) {
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
                                $mail->Username   = 'emergency.med.svc@gmail.com';
                                $mail->Password   = 'kjovncbmradpqhvu';
                                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                                $mail->Port       = 587;
                                // Recipients
                                $mail->setFrom('emergency.med.svc@gmail.com', 'NoReply - Emergency Medical Center');
                                $mail->addAddress($_SESSION['forget-email'], $_SESSION['forget-email']); // Email and name of recipient

                                // Content
                                $mail->isHTML(true); // Set email format to HTML
                                $mail->Subject = 'Email Verifcation';
                                $emailBody = file_get_contents($config['URL'].'/emails/verify.html'); // Load the HTML template
                                $emailBody = str_replace('{VERIFICATION_CODE}', $randomNumber, $emailBody);
                                $emailBody = str_replace('{email}', substr($_SESSION['user-email'], 0, strpos($_SESSION['user-email'], "@")), $emailBody);
                                $mail->Body = $emailBody;

                                $mail->send();
                                $wrong = '<div class="row row-cols-1 row-cols-md-3">
                                    <div class="col">
                                        <div class="alert alert-warning text-success" role="alert">
                                            Code Sended
                                        </div>
                                    </div>
                                </div>';
                                goto SkipChecks;
                            } catch (Exception $e) {
                                goto  SkipChecks;
                            }
                        }
                    }
                    SkipChecks:
                    $emailsection = false;
                    $codesection = true;
                    $resetsection = false;
                }
            } else {
                $alert = '<div class="container mt-5">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Email address not found
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>';
            }
        }
        if (isset($_POST['checkcode'])){
            $email = $_SESSION['forget-email'];
            $code = $_POST['verificationcode'];
            $sql = "SELECT * FROM `codes` WHERE `mail` = '$email' AND `type` = 'forget' AND `code` = '$code'";
            $result = mysqli_query($connection, $sql);
            $total  = mysqli_num_rows($result);
            if ($total >= 1) {
                $sql2 = "DELETE FROM `codes` WHERE `mail` = '$email' AND `type`='forget'";
                $result2 = mysqli_query($connection,$sql2);
                if ($result2) {
                    $emailsection = false;
                    $codesection = false;
                    $resetsection = true;
                }
            } else {
                $alert = '<div class="row row-cols-1 row-cols-md-1">
                    <div class="col">
                        <div class="alert alert-danger text-center" role="alert">
                            Wrong Code Try Again
                        </div>
                    </div>
                </div>';
                $emailsection = false;
                $codesection = true;
                $resetsection = false;
            }
        }
        if (isset($_POST['resetpassword'])){
            $password   = $_POST['password'];
            $password2  = $_POST['password2'];
            if (strlen($password) >= 8) {
                $password   = htmlentities($_POST['password']);
                $password2   = htmlentities($_POST['password2']);
                $encrypt     = sha1($password);
                if ($password == $password2) {
                    $email   = $_SESSION['forget-email'];
                    $sql = "UPDATE `users` SET `password`='$encrypt' WHERE email = '$email'";
                    $result = mysqli_query($connection,$sql);
                    if ($result) {
                        session_unset();
                        session_destroy();
                        $emailsection = true;
                        $codesection = false;
                        $resetsection = false;
                        header('location: '.$config['URL'].'/user/login');
                        exit();
                    }
                } else {
                    $alert = '<div class="container mt-5">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Password Not Matched
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>';
                    $emailsection = false;
                    $codesection = false;
                    $resetsection = true;
                }
            } else {
                $alert = '<div class="container mt-5">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Password must be 8 characters long
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>';
                        $emailsection = false;
                    $codesection = false;
                    $resetsection = true;
            }
        }
    }
} else {
    if (!$_SESSION['Verified']) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            header('location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            header('location: ' . $config['URL']);
            exit();
        }
    } else {
        header('location: ' . $config['URL'] . '/user/verify');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <link rel="icon" href='<?php echo $config['URL'] ?>/assets/image/fav/fav.ico' type="image/x-icon">
    <link rel="shortcut icon" href='<?php echo $config['URL'] ?>/assets/image/fav/fav.ico' type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo $config['URL'] ?>/assets/css/global.css">
</head>

<?php
if ($config['STATIC_BACKGROUND']){
?>
<body style="background-color: <?php echo $config['THEME_COLOR'] ?>;">
<?php
} else {
?>
<body background="<?php echo $config['URL'] ?>/assets/image/pics/background.jpg">
<?php
}
?>
    <img src="<?php echo $config['URL'] ?>/assets/image/logo/logo9.png" class="rounded mx-auto d-block" alt="logo" onclick="redir('<?php echo $config['URL'] ?>')">
    <div class="container">
        <div class="row row-cols-1 row-cols-md-3 m-4">
            <div class="col">
                <?php // Waist column to aligh login section to center 
                ?>
                <br>
            </div>
            <div class="col align-self-center">
                <?php
                if ($emailsection) {
                    session_unset();
                    session_destroy();
                ?>
                    <div class="card addHover p-3 mb-5 bg-gradient rounded">
                        <div class="card-body">
                            <h5 class="card-title text-center mb-4">Forget Password</h5>
                            <form method="post">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" required name="email" id="floatingInput" placeholder="name@example.com">
                                    <label for="floatingInput">Email Address</label>
                                </div>
                                <?php echo $alert; ?>
                                <a href='<?php echo $config['URL'] ?>/user/login'>
                                    <p>Don't want to forget? goto login page!</p>
                                </a>
                                <div class="d-grid gap-2 col-6 mx-auto">
                                    <input type="submit" value="Forget" class="btn btn-success mt-3" name="checkemail">
                                </div>
                            </form>
                        </div>
                    </div>
                <?php
                }
                if ($codesection) {
                ?>
                    <div class="card addHover p-3 mb-5 bg-gradient rounded">
                        <div class="card-body">
                            <h5 class="card-title text-center mb-4">Forget Password</h5>
                            <form method="post">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" required name="verificationcode" id="floatingInput" placeholder="name@example.com">
                                    <label for="floatingInput">Enter Code</label>
                                </div>
                                <?php echo $alert; ?>
                                <div class="d-grid gap-2 col-6 mx-auto">
                                    <input type="submit" value="Submit" class="btn btn-success mt-3" name="checkcode">
                                </div>
                            </form>
                        </div>
                    </div>
                <?php
                }
                if ($resetsection) {
                ?>
                    <div class="card addHover p-3 mb-5 bg-gradient rounded">
                        <div class="card-body">
                            <h5 class="card-title text-center mb-4">Forget Password</h5>
                            <form method="post">
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" required name="password" id="floatingInput" placeholder="name@example.com">
                                    <label for="floatingInput">Enter New Password</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" required name="password2" id="floatingInput" placeholder="name@example.com">
                                    <label for="floatingInput">Re-Enter New Password</label>
                                </div>
                                <?php echo $alert; ?>
                                <div class="d-grid gap-2 col-6 mx-auto">
                                    <input type="submit" value="Reset" class="btn btn-success mt-3" name="resetpassword">
                                </div>
                            </form>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
            <div class="col">
                <?php // Waist column to aligh login section to center 
                ?>
                <br>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="<?php echo $config['URL'] ?>/assets/js/global.js"></script>
</body>

</html>