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
        if (isset($_POST['getcode'])) {
            $email = $_SESSION['user-email'];
            $sql = "SELECT * FROM `codes` WHERE `mail` = '$email' AND `type` = 'verify'";
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
                        $mail->Password   = 'lqlgqkdcyxeqijif';
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port       = 587;
                        // Recipients
                        $mail->setFrom('emergency.med.svc@gmail.com', 'NoReply - Emergency Medical Center');
                        $mail->addAddress($_SESSION['user-email'], $_SESSION['user-email']); // Email and name of recipient

                        // Content
                        $mail->isHTML(true); // Set email format to HTML
                        $mail->Subject = 'Email Verifcation';
                        $emailBody = file_get_contents($config['URL'] . '/emails/verify.html'); // Load the HTML template
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
                    } catch (Exception $e) {
                        echo $e;
                        // goto  SkipChecks;
                    }
                }
            } else {
                GenerateCode:
                $randomNumber = mt_rand(100000, 999999);
                $sql2 = "SELECT * FROM `codes` WHERE `mail`= '$email' AND `type`='verify' AND `code`= '$randomNumber'";
                $result2 = mysqli_query($connection, $sql2);
                $total2  = mysqli_num_rows($result2);
                if ($total2 == 1) {
                    goto GenerateCode;
                } else {
                    $sql3 = "INSERT INTO `codes`( `mail`, `type`, `code`) VALUES (
                        '$email', 'verify','$randomNumber')";
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
                            $mail->Password   = 'lqlgqkdcyxeqijif';
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                            $mail->Port       = 587;
                            // Recipients
                            $mail->setFrom('emergency.med.svc@gmail.com', 'NoReply - Emergency Medical Center');
                            $mail->addAddress($_SESSION['user-email'], $_SESSION['user-email']); // Email and name of recipient

                            // Content
                            $mail->isHTML(true); // Set email format to HTML
                            $mail->Subject = 'Email Verifcation';
                            $emailBody = file_get_contents($config['URL'] . '/emails/verify.html'); // Load the HTML template
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
                        } catch (Exception $e) {
                            // goto  SkipChecks;
                        }
                    }
                    // SkipChecks:
                    // header('location: '.$config['URL'].'/user/verify');
                    // exit();
                }
            }
        }
        if (isset($_POST['verify'])) {
            $email = $_SESSION['user-email'];
            $code = $_POST['VerificationCode'];
            $sql = "SELECT * FROM `codes` WHERE `mail` = '$email' AND `type` = 'verify' AND `code` = '$code'";
            $result = mysqli_query($connection, $sql);
            $total  = mysqli_num_rows($result);
            if ($total >= 1) {
                $user_id = $_SESSION['user-id'];
                $sql2 = "DELETE FROM `codes` WHERE `mail` = '$email' AND `type`='verify'";
                $sql3 = "UPDATE `users` SET `verified`='true' WHERE user_id = '$user_id'";
                $result2 = mysqli_query($connection, $sql2);
                $result3 = mysqli_query($connection, $sql3);
                if ($result3) {
                    $_SESSION['Verified'] = true;
                    header('location: ' . $config['URL']);
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href='<?php echo $config['URL'] ?>/assets/image/fav/fav.ico' type="image/x-icon">
    <link rel="shortcut icon" href='<?php echo $config['URL'] ?>/assets/image/fav/fav.ico' type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo $config['URL'] ?>/assets/css/global.css">
</head>

<?php
if ($config['STATIC_BACKGROUND']) {
?>

    <body style="background-color: <?php echo $config['THEME_COLOR'] ?>;">
    <?php
} else {
    ?>

        <body background="<?php echo $config['URL'] ?>/assets/image/pics/background.jpg">
        <?php
    }
        ?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark navbar-hover">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="<?php echo $config['URL'] ?>/assets/image/logo/logo8.png" alt="" width="30" height="24">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link navbar-hover" aria-current="page" href="<?php echo $config['URL'] ?>/index.php#home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link navbar-hover" aria-current="page" href="<?php echo $config['URL'] ?>/hospitals">Book Appointment</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link navbar-hover" aria-current="page" href="<?php echo $config['URL'] ?>/hospitals">Book Covid Test</a>
                        </li>
                        <?php
                        if (isset($_SESSION['isloggedin'])) {
                            if ($_SESSION['Verified']) {
                        ?>
                                <li class="nav-item">
                                    <a class="nav-link navbar-hover" aria-current="page" href="<?php echo $config['URL'] ?>/user/appointments">My Appointments</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link navbar-hover" aria-current="page" href="<?php echo $config['URL'] ?>/user/reports">My Results/Reports</a>
                                </li>
                        <?php
                            }
                        }
                        ?>
                    </ul>
                    <ul class="navbar-nav">
                        <?php
                        if (isset($_SESSION['isloggedin'])) {
                            if ($_SESSION['Verified']) {
                        ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo $config['URL'] ?>/user/settings"><button type="button" class="btn btn-outline-success">My Profile</button></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo $config['URL'] ?>/user/logout"><button type="button" class="btn btn-outline-danger">Logout</button></a>
                                </li>
                            <?php
                            } else {
                            ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo $config['URL'] ?>/user/logout"><button type="button" class="btn btn-outline-danger">Logout</button></a>
                                </li>
                            <?php
                            }
                        } else {
                            ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $config['URL'] ?>/user/login"><button type="button" class="btn btn-outline-success">Login</button></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $config['URL'] ?>/user/register"><button type="button" class="btn btn-outline-success">Reigster</button></a>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
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
        <br><br><br>
        <div class="container-fluid mt-4">
            <div class="card p-3 bg-light  mt-5">
                <div class="row row-cols-1 row-cols-md-3 pt-3 m-4 gx-5">
                    <div class="col">
                        <img src="<?php echo $config['URL'] ?>/assets/image/logo/logo8.png" class="rounded mx-auto d-block" alt="...">
                        <p>The best way to prevent and slow down transmission is be well informed about the COVID-19 virus, the disease it causes and how it spreads.</p>
                        <br>
                        <p>Protect yourself and others from infec- tion by washing your hands or using an</p>
                    </div>
                    <div class="col mt-3">
                        <div class="row">
                            <h1 class="text-center"><b>Services</b></h1>
                        </div>
                        <br>
                        <div class="row px-5">
                            <div class="row">
                                <div class="col">
                                    <h6><a href="<?php echo $config['URL'] ?>/index.php#home" class="text-dark remove-anchor-decoration">Home</a></h6>
                                    <h6><a href="<?php echo $config['URL'] ?>/index.php#about" class="text-dark remove-anchor-decoration">About</a></h6>
                                    <h6><a href="<?php echo $config['URL'] ?>/index.php#symptoms" class="text-dark remove-anchor-decoration">symptoms</a></h6>
                                    <h6><a href="<?php echo $config['URL'] ?>/index.php#protect" class="text-dark remove-anchor-decoration">How to Protect</a></h6>
                                    <h6><a href="<?php echo $config['URL'] ?>/index.php#faq" class="text-dark remove-anchor-decoration">Command Questions</a></h6>
                                    <h6><a href="<?php echo $config['URL'] ?>/index.php#experts" class="text-dark remove-anchor-decoration">See Experts</a></h6>
                                    <h6><a href="<?php echo $config['URL'] ?>/index.php#handwash" class="text-dark remove-anchor-decoration">How to wash hands</a></h6>
                                </div>
                                <div class="col">
                                    <h6><a href="<?php echo $config['URL'] ?>/hospitals" class="text-dark remove-anchor-decoration">Book Appointment</a></h6>
                                    <h6><a href="<?php echo $config['URL'] ?>/hospitals" class="text-dark remove-anchor-decoration">Book Covid Test</a></h6>
                                    <?php
                                    if (isset($_SESSION['isloggedin'])) {
                                        if ($_SESSION['Verified']) {
                                    ?>
                                            <h6><a href="<?php echo $config['URL'] ?>/user/appointments" class="text-dark remove-anchor-decoration">My Appointments</a></h6>
                                            <h6><a href="<?php echo $config['URL'] ?>/user/reports" class="text-dark remove-anchor-decoration">My Results/Reports</a></h6>
                                            <h6><a href="<?php echo $config['URL'] ?>/user/settings" class="text-dark remove-anchor-decoration">My Profile</a></h6>
                                        <?php
                                        } else {
                                        ?>
                                            <h6><a href="<?php echo $config['URL'] ?>/user/verify" class="text-dark remove-anchor-decoration">Verify</a></h6>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <h6><a href="<?php echo $config['URL'] ?>/user/login" class="text-dark remove-anchor-decoration">Login</a></h6>
                                        <h6><a href="<?php echo $config['URL'] ?>/user/register" class="text-dark remove-anchor-decoration">Register</a></h6>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col mt-3">
                        <h1><b>Contacts</b></h1>
                        <br>
                        <div class="row row-cols-2">
                            <div class="col-1">
                                <h4><i class="fas fa-map-marker-alt" style="color: #00aea5;"></i> </h4>
                            </div>
                            <div class="col-9">
                                <h5>Flat 20, Reynolds Neck, North Helenaville, FV77 8WS</h5>
                            </div>
                        </div>
                        <br>
                        <div class="row row-cols-2">
                            <div class="col-1">
                                <h4><i class="fas fa-microphone-alt" style="color: #00aea5;"></i> </h4>
                            </div>
                            <div class="col-9">
                                <h5>+2(305) 587-3407</h5>
                            </div>
                        </div>
                        <br>
                        <div class="row row-cols-2">
                            <div class="col-1">
                                <h4><i class="fas fa-envelope" style="color: #00aea5;"></i> </h4>
                            </div>
                            <div class="col-9">
                                <h5>info@example.com</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="<?php echo $config['URL'] ?>/assets/js/global.js"></script>
        </body>

</html>