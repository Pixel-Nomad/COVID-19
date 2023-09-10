<?php
require('../../../config.php');
session_name('management_hospitals');
session_start();
$connection = mysqli_connect($config['DB_URL'], $config['DB_USERNAME'], $config['DB_PASSWORD'], $config['DB_DATABASE']);
if (isset($_SESSION['hospital-isloggedin'])) {
    if ($connection) {
        if (isset($_POST['update'])) {
            $id = $_POST['id'];
            $quantity = $_POST['quantity'];
            $query = "UPDATE available_vaccine SET vaccine_quantity = $quantity WHERE id = $id";
            $result = mysqli_query($connection, $query);
            if ($result) {
                header('location: ' . $config['URL'] . '/management/hospitals/doctor/');
                exit();
            }
        }
    }
} else {
    if (isset($_SERVER['HTTP_REFERER'])) {
        header('location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        header('location: ' . $config['URL'] . '/management/hospitals/doctor/login/');
        exit();
    }
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $query = "SELECT * FROM users WHERE user_id = $user_id";
    $result = mysqli_query($connection, $query);
    $total  = mysqli_num_rows($result);
    if ($total > 1 || $total < 1) {
        header('location: ' . $config['URL'] . '/management/hospitals/appointments');
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php
        echo $_SESSION['hospital-hospital-name'] . ' | Dashboard';
        ?>
    </title>
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

<body>
    <!-- top navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-custom2 fixed-top">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="offcanvasExample">
                <span class="navbar-toggler-icon" data-bs-target="#sidebar"></span>
            </button>
            <a class="navbar-brand me-auto ms-lg-0 ms-3 text-uppercase fw-bold" href="#"><?php
                                                                                            echo $_SESSION['hospital-hospital-name'] . ' | Dashboard';
                                                                                            ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNavBar" aria-controls="topNavBar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="topNavBar">
                <ul class="navbar-nav d-flex ms-auto my-3 my-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle ms-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-fill"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?php echo $config['URL'] ?>/management/hospitals/doctor/delete/">Delete Account</a></li>
                            <li><a class="dropdown-item" href='<?php echo $config['URL'] ?>/management/hospitals/doctor/logout/'>Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- top navigation bar -->
    <!-- offcanvas -->
    <div class="offcanvas offcanvas-start sidebar-nav bg-custom2" tabindex="-1" id="sidebar">
        <div class="offcanvas-body p-0">
            <nav class="navbar-dark">
                <ul class="navbar-nav">
                    <li>
                        <div class="text-muted small fw-bold text-uppercase px-3">
                            CORE
                        </div>
                    </li>
                    <li>
                        <a href="#" class="nav-link px-3 active">
                            <span class="me-2"><i class="bi bi-speedometer2"></i></span>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="my-4">
                        <hr class="dropdown-divider bg-light" />
                    </li>
                    <li>
                        <div class="text-muted small fw-bold text-uppercase px-3 mb-3">
                            Interface
                        </div>
                    </li>
                    <li>
                        <a class="nav-link px-3 sidebar-link" data-bs-toggle="collapse" href="#layouts">
                            <span class="me-2"><i class="bi bi-layout-split"></i></span>
                            <span>Layouts</span>
                            <span class="ms-auto">
                                <span class="right-icon">
                                    <i class="bi bi-chevron-down"></i>
                                </span>
                            </span>
                        </a>
                        <div class="collapse" id="layouts">
                            <ul class="navbar-nav ps-3">
                                <li>
                                    <a href="#" class="nav-link px-3">
                                        <span class="me-2"><i class="bi bi-speedometer2"></i></span>
                                        <span>Dashboard</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="#" class="nav-link px-3">
                            <span class="me-2"><i class="bi bi-book-fill"></i></span>
                            <span>Pages</span>
                        </a>
                    </li>
                    <li class="my-4">
                        <hr class="dropdown-divider bg-light" />
                    </li>
                    <li>
                        <div class="text-muted small fw-bold text-uppercase px-3 mb-3">
                            Addons
                        </div>
                    </li>
                    <li>
                        <a href="#" class="nav-link px-3">
                            <span class="me-2"><i class="bi bi-graph-up"></i></span>
                            <span>Charts</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link px-3">
                            <span class="me-2"><i class="bi bi-table"></i></span>
                            <span>Tables</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <!-- offcanvas -->
    <main class="mt-5 pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    if (isset($_GET['id'])) {
                        $user_id = $_GET['id'];
                        $query = "SELECT * FROM users WHERE user_id = $user_id";
                        $result = mysqli_query($connection, $query);
                        $total  = mysqli_num_rows($result);
                        if ($total == 1) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<h4>Patient Details of ' . $row['fname'] . ' ' . $row['lname'] . ' || Email: ' . $row['email'] . '</h4>';
                            }
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <span><i class="bi bi-table me-2"></i></span> All Appointments
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-striped data-table2" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Hospital Name</th>
                                            <th>Timing</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $query = "SELECT * FROM appointments INNER JOIN hospitals ON appointments.hospital_id = hospitals.hospital_id WHERE appointments.user_id = $user_id";
                                            $result = mysqli_query($connection, $query);
                                            $total  = mysqli_num_rows($result);
                                            if ($total >= 1) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    if ($row['status'] == 'approved' || $row['status'] == 'visited' || $row['status'] == 'not visited') {
                                                        echo '
                                                        <tr>
                                                            <td>'.$row['appointment_id'].'</td>
                                                            <td>'.$row['hospital_name'].'</td>
                                                            <td>'.$row['appointment_time'].'</td>
                                                            <td>'.$row['type'].'</td>
                                                            <td>'.$row['status'].'</td>
                                                        </tr>
                                                        ';
                                                    }
                                                }
                                            }
                                        ?>
                                        
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
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
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <span><i class="bi bi-table me-2"></i></span> All Covid Test
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-striped data-table2" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>Hospital Name</th>
                                            <th>Timing</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $query = "SELECT * FROM reports INNER JOIN hospitals ON reports.hospital_id = hospitals.hospital_id WHERE reports.user_id = $user_id";
                                            $result = mysqli_query($connection, $query);
                                            $total  = mysqli_num_rows($result);
                                            if ($total >= 1) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    if ($row['type'] == 'test') {
                                                        if ($row['hospital_id'] == $_SESSION['hospital-hospital-id']){
                                                            echo '
                                                            <tr>
                                                                <td>'.$row['hospital_name'].'</td>
                                                                <td>'.$row['report_timing'].'</td>
                                                                <td>'.$row['test_type'].'</td>
                                                                <td>'.$row['test_result'].'</td>
                                                                <td>
                                                                    
                                                                    <form method="post">
                                                                        <div class="d-grid gap-2">
                                                                            <input type="text" class="d-none" name="id" value="' . $row['report_id'] . '">
                                                                            <input type="submit" value="Delete" class="btn btn-outline-danger" name="deletetest">
                                                                        </div>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                            ';
                                                        } else {
                                                            echo '
                                                            <tr>
                                                                <td>'.$row['hospital_name'].'</td>
                                                                <td>'.$row['report_timing'].'</td>
                                                                <td>'.$row['test_type'].'</td>
                                                                <td>'.$row['test_result'].'</td>
                                                                <td>Access Forbidden</td>
                                                            </tr>
                                                            ';
                                                        }
                                                    }
                                                }
                                            }
                                        ?>
                                        
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Hospital Name</th>
                                            <th>Timing</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <span><i class="bi bi-table me-2"></i></span> All Vaccination Taken
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-striped data-table2" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>Hospital Name</th>
                                            <th>Timing</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $query = "SELECT * FROM reports INNER JOIN hospitals ON reports.hospital_id = hospitals.hospital_id WHERE reports.user_id = $user_id";
                                            $result = mysqli_query($connection, $query);
                                            $total  = mysqli_num_rows($result);
                                            if ($total >= 1) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    if ($row['type'] == 'vaccine') {
                                                        if ($row['hospital_id'] == $_SESSION['hospital-hospital-id']){
                                                            echo '
                                                            <tr>
                                                                <td>'.$row['hospital_name'].'</td>
                                                                <td>'.(($row['report_timing']!=NULL) ? $row['report_timing'] : 'Not Taken').'</td>
                                                                <td>'.$row['vaccine_type'].'</td>
                                                                <td>'.$row['vaccine_status'].'</td>
                                                                <td>
                                                                    
                                                                    <form method="post">
                                                                        <div class="d-grid gap-2">
                                                                            <input type="text" class="d-none" name="id" value="' . $row['report_id'] . '">
                                                                            <input type="submit" value="Delete" class="btn btn-outline-danger" name="deletetest">
                                                                        </div>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                            ';
                                                        } else {
                                                            echo '
                                                            <tr>
                                                                <td>'.$row['hospital_name'].'</td>
                                                                <td>'.(($row['report_timing']!=NULL) ? $row['report_timing'] : 'Not Taken').'</td>
                                                                <td>'.$row['vaccine_type'].'</td>
                                                                <td>'.$row['vaccine_status'].'</td>
                                                                <td>Access Forbidden</td>
                                                            </tr>
                                                            ';
                                                        }
                                                    }
                                                }
                                            }
                                        ?>
                                        
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Hospital Name</th>
                                            <th>Timing</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
    <script src="<?php echo $config['URL'] ?>/vendor/jquery/jquery-3.5.1.js"></script>
    <script src="<?php echo $config['URL'] ?>/vendor/data_tables/jquery.dataTables.min.js"></script>
    <script src="<?php echo $config['URL'] ?>/vendor/data_tables/dataTables.bootstrap5.min.js"></script>
    <script src="<?php echo $config['URL'] ?>/assets/js/global.js"></script>
    <script src="<?php echo $config['URL'] ?>/assets/js/dash.js"></script>
</body>

</html>