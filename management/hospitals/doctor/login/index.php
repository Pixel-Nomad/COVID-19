<?php
require('../../../../config.php');
session_name('management_hospitals');
session_start();
$alert = "";
$options = "";
if (!isset($_SESSION['isloggedin'])) {
    session_unset();
    session_destroy();
    $connection = mysqli_connect($config['DB_URL'], $config['DB_USERNAME'], $config['DB_PASSWORD'], $config['DB_DATABASE']);
    if ($connection) {
        $query = "SELECT * FROM hospitals";
        $result = mysqli_query($connection, $query);
        $total  = mysqli_num_rows($result);
        if ($total >= 1) {
            while ($row = mysqli_fetch_assoc($result)) {
                $options .= '<option value="'.$row['hospital_id'].'">'.$row['hospital_name'].'</option>';
            }
        }
        if (isset($_POST['login'])) {
            if (isset($_POST['hospital'])) {
                if ($_POST['hospital'] != '') {
                    $hospitalid = $_POST['hospital'];
                    $email      = htmlentities($_POST['email']);
                    $password   = $_POST['password'];
                    if (strlen($password) >= 8) {
                        $password   = htmlentities($_POST['password']);
                        $encrypt     = sha1($password);
                        $sql = "SELECT * FROM `hospital_users` WHERE `email`= '$email' AND `password`='$encrypt' AND `hospital_id` = $hospitalid AND `approved` = 'true'";
                        $result = mysqli_query($connection, $sql);
                        $total  = mysqli_num_rows($result);
                        if ($total >= 1) {
                            session_start();
                            while ($row = mysqli_fetch_assoc($result)) {
                                $id = $row['hospital_id'];
                                $query2 = "SELECT * FROM hospitals WHERE hospital_id = $id";
                                $result2 = mysqli_query($connection, $query2);
                                $total2  = mysqli_num_rows($result2);
                                if ($total2 == 1) {
                                    while ($row2 = mysqli_fetch_assoc($result2)) {
                                        $_SESSION['hospital-hospital-name'] = $row2['hospital_name'];
                                    }
                                }
                                $_SESSION['hospital-user-id'] = $row['user_id'];
                                $_SESSION['hospital-hospital-id'] = $row['hospital_id'];
                                $_SESSION['hospital-name'] = $row['name'];
                                $_SESSION['hospital-email'] = $row['email'];
                                if ($row['approved'] == 'true') {
                                    $_SESSION['hospital-approved'] = true;
                                } else {
                                    $_SESSION['hospital-approved'] = false;
                                }
                                $_SESSION['hospital-isloggedin'] = true;
                                header('location: ' . $config['URL'].'/management/hospitals/doctor');
                                exit();
                            }
                        } else {
                            $alert = '<div class="container mt-5">
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        Email or Password is incorrect or you are not approved
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                </div>';
                        }
                    } else {
                        $alert = '<div class="container mt-5">
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        Password must be 8 characters long
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                </div>';
                    }
                } else {
                    $alert = '<div class="container mt-5">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Please Select Hospital
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>';
                }
            } else {
                $alert = '<div class="container mt-5">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Please Select Hospital
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>';
            }
        }
    }
} else {
    if (
        $_SESSION['Verified']
    ) {
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
    <title>Login</title>
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
        <br><br>
        <div class="container mt-4">
            <div class="row row-cols-1 row-cols-md-3">
                <div class="col">
                    <?php // Waist column to aligh login section to center 
                    ?>
                    <br>
                </div>
                <div class="col align-self-center">
                    <div class="card addHover p-3 mb-5 bg-gradient rounded">
                        <img src="<?php echo $config['URL'] ?>/assets/image/logo/logo7.png" class="rounded mx-auto d-block" alt="logo" onclick="redir('<?php echo $config['URL'] ?>')">
                        <div class="card-body">
                            <h5 class="card-title text-center mb-4">Hospital Login</h5>
                            <form method="post">
                                <div class="form-floating mb-3">
                                    <select class="form-select" name="hospital" id="floatingHospital">
                                        <option value="" disabled selected>Select Hospital</option>
                                        <?php
                                            echo $options;
                                        ?>
                                    </select>
                                    <label for="floatingHospital">Hospital</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" required name="email" id="floatingInput" placeholder="name@example.com">
                                    <label for="floatingInput">Email Address</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" required name="password" id="floatingInput" placeholder="name@example.com">
                                    <label for="floatingInput">Enter Password</label>
                                </div>
                                <?php echo $alert; ?>
                                <a href='<?php echo $config['URL'] ?>/management/hospitals/doctor/register/'>
                                    <p>Don't have an account? Get one now.</p>
                                </a>
                                <div class="d-grid gap-2 col-6 mx-auto">
                                    <input type="submit" value="Login" class="btn btn-success mt-3" name="login">
                                </div>
                            </form>
                        </div>
                    </div>
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