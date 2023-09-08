<?php
require('../../config.php');
session_start();
$data = '';
$data2 = '';
$alert = '';
if (isset($_SESSION['isloggedin'])) {
    if ($_SESSION['Verified']) {
        $connection = mysqli_connect($config['DB_URL'], $config['DB_USERNAME'], $config['DB_PASSWORD'], $config['DB_DATABASE']);
        if ($connection) {
            $user_id = $_SESSION['user-id'];
            $query = "SELECT * FROM appointments INNER JOIN hospitals ON appointments.hospital_id = hospitals.hospital_id WHERE appointments.user_id = $user_id";
            $result = mysqli_query($connection, $query);
            $total  = mysqli_num_rows($result);
            if ($total >= 1) {
                $query2 = "SELECT hospital_name FROM hospitals INNER JOIN";
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['status'] == 'pending' || $row['status'] == 'cancelled' || $row['status'] == 'visited') {
                        $data .= '<tr>
                            <td>' . $row['hospital_name'] . '</td>
                            <td>' . $row['type'] . '</td>
                            <td>' . $row['status'] . '</td>
                            <td>';
                        if ($row['status'] == 'pending') {
                            $data .= '<form method="post">
                                        <div class="d-grid gap-2">
                                            <input type="text" class="d-none" name="id" value="' . $row['appointment_id'] . '">
                                            <input type="submit" value="Cancel" class="btn btn-outline-danger" name="Cancel">
                                        </div>
                                    </form>';
                        } else {
                            $data .= '<form method="post">
                                        <div class="d-grid gap-2">
                                            <input type="text" class="d-none" name="id" value="' . $row['appointment_id'] . '">
                                            <input type="submit" disabled value="Cancel" class="btn btn-outline-dark" name="Cancel">
                                        </div>
                                    </form>';
                        }
                        $data .= '</td>
                        </tr>';
                    } elseif ($row['status'] == 'confirmed') {
                        $data2 .= '<tr>
                            <td>' . $row['hospital_name'] . '</td>
                            <td>' . $row['appointment_time'] . '</td>
                            <td>' . $row['type'] . '</td>
                            <td>' . $row['status'] . '</td>
                        </tr>';
                    }
                }
            }
            if (isset($_POST['Cancel'])) {
                $id = $_POST['id'];
                $query = "UPDATE appointments SET `status`='cancelled' WHERE appointment_id = $id";
                $result = mysqli_query($connection, $query);
                if ($result) {
                    header('location: ' . $config['URL'].'/user/appointments');
                    exit();
                }
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
    <title>My Appointments</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href='<?php echo $config['URL'] ?>/assets/image/fav/fav.ico' type="image/x-icon">
    <link rel="shortcut icon" href='<?php echo $config['URL'] ?>/assets/image/fav/fav.ico' type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous" />
    <link rel="stylesheet" href="<?php echo $config['URL'] ?>/assets/css/global.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="<?php echo $config['URL'] ?>/vendor/data_tables/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="<?php echo $config['URL'] ?>/assets/css/dash.css">
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
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top navbar-hover">
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
                            <a class="nav-link active" aria-current="page">Booking</a>
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
            <?php
            echo $alert;
            ?>
        </div>
        <?php
        if ($alert == ' ') {
        ?>
            <br class="d-none d-md-block">
            <br class="d-none d-md-block">
            <br class="d-none d-md-block">
        <?php
        }
        ?>

        <div class="container mt-5">
            <div class="card ms-3 me-3">
                <div class="card-header">
                    <span><i class="bi bi-table me-2"></i></span> My Approved Appointments
                </div>
                <div class="card-body">
                    <div class="table-responsive ">
                        <table id="example" class="table  table-striped data-table2" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Hospital Name</th>
                                    <th>Timing</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                echo $data2;
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Hospital Name</th>
                                    <th>Timing</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mt-5">
            <div class="card ms-3 me-3">
                <div class="card-header">
                    <span><i class="bi bi-table me-2"></i></span> My Pending / Canclled Appointments
                </div>
                <div class="card-body">
                    <div class="table-responsive ">
                        <table id="example" class="table  table-striped data-table2" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Hospital Name</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                echo $data;
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Hospital Name</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>



        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
        <script src="<?php echo $config['URL'] ?>/vendor/jquery/jquery-3.5.1.js"></script>
        <script src="<?php echo $config['URL'] ?>/vendor/data_tables/jquery.dataTables.min.js"></script>
        <script src="<?php echo $config['URL'] ?>/vendor/data_tables/dataTables.bootstrap5.min.js"></script>
        <script src="<?php echo $config['URL'] ?>/assets/js/global.js"></script>
        <script src="<?php echo $config['URL'] ?>/assets/js/dash.js"></script>
        </body>

</html>