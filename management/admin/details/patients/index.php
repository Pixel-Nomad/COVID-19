<?php
require('../../../../config.php');
session_start();
$connection = mysqli_connect($config['DB_URL'], $config['DB_USERNAME'], $config['DB_PASSWORD'], $config['DB_DATABASE']);
if (isset($_SESSION['isloggedin'])) {
    if ($_SESSION['user-role'] != 'user') {
        if (isset($_POST['submit']) && isset($_POST['options'])) {
            $id = $_POST['old-userid'];
            $role = $_POST['options'];
            $sql = "UPDATE `users` SET `role` = '$role' WHERE `user_id` = $id";
            $result = mysqli_query($connection, $sql);
            if ($result) {
                header('location: ' . $config['URL'] . '/management/admin/details/patients');
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
    <title>Admin Dashboard</title>
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
            <a class="navbar-brand me-auto ms-lg-0 ms-3 text-uppercase fw-bold">Admin Dashboard</a>
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
                            <li><a class="dropdown-item" href="<?php echo $config['URL'] ?>/">Main Site</a></li>
                            <li><a class="dropdown-item" href='<?php echo $config['URL'] ?>/user/logout/'>Logout</a></li>
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
                        <a href="<?php echo $config['URL'] ?>/management/admin/" class="nav-link px-3">
                            <span class="me-2"><i class="bi bi-speedometer2"></i></span>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="my-4">
                        <hr class="dropdown-divider bg-light" />
                    </li>
                    <li>
                        <div class="text-muted small fw-bold text-uppercase px-3 mb-3">
                            Admin Work
                        </div>
                    </li>
                    <li>
                        <a href="<?php echo $config['URL'] ?>/management/admin/details/bookings/" class="nav-link px-3">
                            <span class="me-2"><i class="bi bi-book-fill"></i></span>
                            <span>See All Bookings</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link px-3 active">
                            <span class="me-2"><i class="bi bi-book-fill"></i></span>
                            <span>See All Patients</span>
                        </a>
                    </li>
                    <li class="my-4">
                        <hr class="dropdown-divider bg-light" />
                    </li>
                    <li>
                        <div class="text-muted small fw-bold text-uppercase px-3 mb-3">
                            User Role
                        </div>
                    </li>
                    <li>
                        <div class="nav-link px-3">
                            <span class="me-2"></span>
                            <span><?php echo $_SESSION['user-role']; ?></span>
                        </div>
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
                    <h4>All Patient Details</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <span><i class="bi bi-table me-2"></i></span> User Management
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-striped data-table2" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Contact</th>
                                            <th>Address</th>
                                            <th>City</th>
                                            <th>State</th>
                                            <th>Postal</th>
                                            <th>Country</th>
                                            <th>Verified</th>
                                            <th>Role</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM `users`";
                                        $result = mysqli_query($connection, $sql);
                                        $total  = mysqli_num_rows($result);
                                        if ($total >= 1) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<tr>
                                                        <td>' . $row['user_id'] . '</td>
                                                        <td>' . $row['fname'] . '</td>
                                                        <td>' . $row['lname'] . '</td>
                                                        <td>' . $row['email'] . '</td>
                                                        <td>' . $row['contact'] . '</td>
                                                        <td>' . $row['address'] . '</td>
                                                        <td>' . $row['city'] . '</td>
                                                        <td>' . $row['state'] . '</td>
                                                        <td>' . $row['postal'] . '</td>
                                                        <td>' . $row['country'] . '</td>
                                                        <td>' . $row['verified'] . '</td>
                                                        <td>' . $row['role'] . '</td>';
                                                if ($_SESSION['user-role'] == 'master') {
                                                    if ($_SESSION['user-id'] != $row['user_id']){
                                                        echo '<td><button class="btn btn-danger open-review-form"  
                                                            data-user-id=' . $row['user_id'] . '
                                                            data-user-role="' . $row['role'] . '">Update Status</button></td>';
                                                    } else {
                                                        echo '<td>Not Allowed To Modify Self Role</td>';
                                                    }
                                                    
                                                } else {
                                                    echo '<td>No Access</td>';
                                                }

                                                echo '</tr>';
                                            }
                                        }
                                        ?>


                                    </tbody>
                                    <tfoot>
                                        <th>#</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                        <th>Address</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Postal</th>
                                        <th>Country</th>
                                        <th>Verified</th>
                                        <th>Role</th>
                                        <th>Actions</th>
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
                <h2 class="mb-4">Update</h2>
                <form method="post">
                    <label for="reviewText" class="form-label">Category ID</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="options" id="user" value="user" checked>
                        <label class="form-check-label" for="user">
                            user
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="options" id="admin" value="admin" checked>
                        <label class="form-check-label" for="admin">
                            admin
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="options" id="master" value="master" checked>
                        <label class="form-check-label" for="master">
                            master
                        </label>
                    </div>
                    <input type="number" class="d-none" id="old-userid" name="old-userid" value="">
                    <br>
                    <input type="submit" class="btn btn-primary" value="Update" name="submit"></input>
                    <br>
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
        function replaceSpacesWithHyphens(inputString) {
            return inputString.replace(/\s/g, '-');
        }
        const openReviewFormButtons = document.querySelectorAll(".open-review-form");

        // Add a click event listener to each button
        openReviewFormButtons.forEach(button => {
            button.addEventListener("click", function() {
                const id = button.getAttribute("data-user-id");
                const role = button.getAttribute("data-user-role");
                openReviewForm(id, role);
            });
        });

        // Function to open the review form with a predefined plant_id
        function openReviewForm(id, role) {
            document.getElementById("old-userid").value = id;
            document.getElementById(replaceSpacesWithHyphens(role)).checked = true;
            document.getElementById("reviewFormOverlay").style.display = "flex";
        }

        document.getElementById("closeReviewForm").addEventListener("click", function() {
            document.getElementById("reviewFormOverlay").style.display = "none";
        });
    </script>
</body>

</html>