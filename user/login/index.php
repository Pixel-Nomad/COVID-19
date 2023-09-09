<?php
require('../../config.php');
session_start();
$alert = "";
if (!isset($_SESSION['isloggedin'])) {
    session_unset();
    session_destroy();
    $connection = mysqli_connect($config['DB_URL'], $config['DB_USERNAME'], $config['DB_PASSWORD'], $config['DB_DATABASE']);
    if ($connection) {
        if (isset($_POST['login'])) {
            $email      = htmlentities($_POST['email']);
            $password   = $_POST['password'];
            if (strlen($password) >= 8) {
                $password   = htmlentities($_POST['password']);
                $encrypt     = sha1($password);
                $sql = "SELECT * FROM `users` WHERE `email`= '$email' AND `password`='$encrypt'";
                $result = mysqli_query($connection, $sql);

                $total  = mysqli_num_rows($result);
                if ($total >= 1) {
                    session_start();
                    while ($row = mysqli_fetch_assoc($result)) {
                        $_SESSION['user-id'] = $row['user_id'];
                        $_SESSION['user-fname'] = $row['fname'];
                        $_SESSION['user-lname'] = $row['lname'];
                        $_SESSION['user-email'] = $row['email'];
                        $_SESSION['user-contact'] = $row['contact'];
                        $_SESSION['user-role'] = $row['role'];
                        $_SESSION['user-address'] = $row['address'];
                        $_SESSION['user-city'] = $row['city'];
                        $_SESSION['user-state'] = $row['state'];
                        $_SESSION['user-postal'] = $row['postal'];
                        $_SESSION['user-country'] = $row['country'];
                        if ($row['verified'] == 'true') {
                            $_SESSION['Verified'] = true;
                        } else {
                            $_SESSION['Verified'] = false;
                        }
                    }
                    $_SESSION['user-email'] = $email;
                    $_SESSION['isloggedin'] = true;
                    if ($_SESSION['Verified']) {
                        header('location: ' . $config['URL']);
                    } else {
                        header('location: ' . $config['URL'] . '/user/verify');
                    }
                    exit();
                } else {
                    $alert = '<div class="container mt-5">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Email or Password is incorrect
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
        }
    }
} else {
    if (
        $_SESSION['Verified']) {
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
                        <a class="nav-link" aria-current="page" href="<?php echo $config['URL'] ?>/index.php#home">Home</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <?php
                    if (isset($_SESSION['isloggedin'])) {
                        if ($_SESSION['Verified']) {
                    ?>
                            <li class="nav-item">
                                <a class="nav-link" href="#">My Profile</a>
                            </li>
                        <?php
                        } else {
                        ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $config['URL'] ?>/user/verify"><button type="button" class="btn btn-outline-warning">Verify</button></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $config['URL'] ?>/user/logout"><button type="button" class="btn btn-outline-danger">Logout</button></a>
                            </li>
                        <?php
                        }
                    } else {
                        ?>
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
                        <h5 class="card-title text-center mb-4">Login</h5>
                        <form method="post">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" required name="email" id="floatingInput" placeholder="name@example.com">
                                <label for="floatingInput">Email Address</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" required name="password" id="floatingInput" placeholder="name@example.com">
                                <label for="floatingInput">Enter Password</label>
                            </div>
                            <?php echo $alert; ?>
                            <a href='<?php echo $config['URL'] ?>/user/forget'>
                                <p>Forget Password?.</p>
                            </a>
                            <a href='<?php echo $config['URL'] ?>/user/register'>
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