<?php
    require('config.php');
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget</title>
    <link rel="icon" href='<?php echo $config['URL'] ?>/assets/image/fav/fav.ico' type="image/x-icon">
    <link rel="shortcut icon" href='<?php echo $config['URL'] ?>/assets/image/fav/fav.ico' type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo $config['URL'] ?>/assets/css/global.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="https://getbootstrap.com/docs/5.0/assets/brand/bootstrap-logo.svg" alt="" width="30" height="24">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active " aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  " aria-current="page" href="#">Search</a>
                    </li>
                    <?php
                        if (isset($_SESSION['isloggedin'])) {
                            if ($_SESSION['Verified']) {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link  " aria-current="page" href="#">Request</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  " aria-current="page" href="#">Report</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  " aria-current="page" href="#">Appointment</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  " aria-current="page" href="#">View Results</a>
                    </li>
                    <?php
                        } }
                    ?>
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
                        <a class="nav-link" href="#">Verify</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Logout</a>
                    </li>
                    <?php
                            }
                        } else {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Register</a>
                    </li>
                    <?php
                        }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="<?php echo $config['URL'] ?>/assets/js/global.js"></script>
</body>

</html>