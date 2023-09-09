<?php
require('../../../../config.php');
session_name('management_hospitals');
session_start();
$connection = mysqli_connect($config['DB_URL'], $config['DB_USERNAME'], $config['DB_PASSWORD'], $config['DB_DATABASE']);
if (isset($_SESSION['hospital-isloggedin'])) {
    if ($connection) {
        if (isset($_POST['removet'])){
            $id = $_POST['id'];
            $query = "DELETE FROM `available_test` WHERE `id` = $id";
            $result = mysqli_query($connection, $query);
            if ($result) {
                header('location: ' . $config['URL'] . '/management/hospitals/doctor/update/');
                exit();
            }
        }
        if (isset($_POST['removep'])){
            $id = $_POST['id'];
            $query = "DELETE FROM `available_vaccine` WHERE `id` = $id";
            $result = mysqli_query($connection, $query);
            if ($result) {
                header('location: ' . $config['URL'] . '/management/hospitals/doctor/update/');
                exit();
            }
        }
        if (isset($_POST['add'])){
            $name = $_POST['name'];
            $id = $_SESSION['hospital-hospital-id'];
            if ($_POST['type'] == 'Test') {
                $query = "INSERT INTO available_test (hospital_id,test_type) VALUES ($id,'$name')";
                $result = mysqli_query($connection, $query);
                if ($result) {
                    header('location: ' . $config['URL'] . '/management/hospitals/doctor/update/');
                    exit();
                }
            } elseif ($_POST['type'] == 'Vaccine'){
                $color = $_POST['colors'];
                $query = "INSERT INTO available_vaccine (hospital_id,vaccine_type,vaccine_color) VALUES ($id,'$name','$color')";
                $result = mysqli_query($connection, $query);
                if ($result) {
                    header('location: ' . $config['URL'] . '/management/hospitals/doctor/update/');
                    exit();
                }
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
                    <h4>Covid Test Vaccinations</h4>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-primary open-review-form" type="button">AddNew</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <span><i class="bi bi-table me-2"></i></span> Covid Test
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-striped data-table" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $id = $_SESSION['hospital-hospital-id'];
                                        $query = "SELECT * FROM available_test WHERE hospital_id = $id";
                                        $result = mysqli_query($connection, $query);
                                        $total  = mysqli_num_rows($result);
                                        if ($total >= 1) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '
                                    <tr>
                                        <td>' . $row['test_type'] . '</td>
                                        <td>
                                            <form method="post">
                                                <input type="text" class="d-none" value="' . $row['id'] . '" name="id">
                                                <input type="submit" value="remove" class="btn btn-danger" name="removet"> 
                                            </form>
                                        </td>
                                    </tr>
                                ';
                                            }
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Action</th>
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
                            <span><i class="bi bi-table me-2"></i></span> Vaccinations
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-striped data-table" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $id = $_SESSION['hospital-hospital-id'];
                                        $query = "SELECT * FROM available_vaccine WHERE hospital_id = $id";
                                        $result = mysqli_query($connection, $query);
                                        $total  = mysqli_num_rows($result);
                                        if ($total >= 1) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '
                                                    <tr>
                                                        <td>' . $row['vaccine_type'] . '</td>
                                                        <td>
                                                            <form method="post">
                                                                <input type="text" class="d-none" value="' . $row['id'] . '" name="id">
                                                                <input type="submit" value="remove" class="btn btn-danger" name="removep"> 
                                                            </form>
                                                        </td>
                                                    </tr>
                                                ';
                                            }
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="review-form-overlay" id="reviewFormOverlay">
            <div class="review-form">
                <button class="close-review-form" id="closeReviewForm"><i class="fas fa-times"></i></button>
                <h2 class="mb-4">Add new Test or Vaccine</h2>
                <form method="post">
                    <input type="text" class="d-none" id="plantId" name="plantId" value="">
                    <div class="mb-3">
                        <label for="rating" class="form-label">Type</label>
                        <select class="form-select" id="rating" required name="type">
                            <option value="" disabled selected>Select Type...</option>
                            <option value="Test">Test</option>
                            <option value="Vaccine">Vaccine</option>
                        </select>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" name="name" placeholder="name">
                        <label for="floatingInput">Name</label>
                    </div>
                    <div class="mb-3">
                        <label for="rating" class="form-label">Select vaccine color for dashboard...</label>
                        <select class="form-select" id="rating" name="colors">
                            <option value="custom">Default</option>
                            <option value="custom2">Default 2</option>
                            <option value="primary">Blue</option>
                            <option value="success">Green</option>
                            <option value="danger">Red</option>
                            <option value="warning">Yellow</option>
                            <option value="dark">Black</option>
                        </select>
                    </div>
                    
                    <input type="submit" class="btn btn-primary" value="Add" name="add"></input>
                </form>
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
    <script>
        const openReviewFormButtons = document.querySelectorAll(".open-review-form");

        // Add a click event listener to each button
        openReviewFormButtons.forEach(button => {
            button.addEventListener("click", function() {
                document.getElementById("reviewFormOverlay").style.display = "flex";
            });
        });

        document.getElementById("closeReviewForm").addEventListener("click", function() {
            document.getElementById("reviewFormOverlay").style.display = "none";
        });
    </script>
</body>

</html>