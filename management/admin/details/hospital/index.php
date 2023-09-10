<?php
    require('../../../../config.php');
    session_start();
    $connection = mysqli_connect($config['DB_URL'], $config['DB_USERNAME'], $config['DB_PASSWORD'], $config['DB_DATABASE']);
    if (isset($_SESSION['isloggedin'])) {
        if ($_SESSION['user-role'] != 'user') {
            if (isset($_POST['approve'])){
                $id = $_POST['id'];
                $query = "UPDATE hospital_users SET approved = 'true' WHERE user_id = $id";
                $result = mysqli_query($connection, $query);
                if ($result) {
                    $user_id = $_GET['id'];
                    $name = $_GET['name'];
                    header('location: ' . $config['URL'] . '/management/admin/details/hospital/?id=' . $user_id.'&name='.$name);
                    exit();
                }
            }
            if (isset($_POST['delete'])){
                $id = $_POST['id'];
                $query = "DELETE FROM hospital_users WHERE user_id = $id";
                $result = mysqli_query($connection, $query);
                if ($result) {
                    $user_id = $_GET['id'];
                    $name = $_GET['name'];
                    header('location: ' . $config['URL'] . '/management/admin/details/hospital/?id=' . $user_id.'&name='.$name);
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

    if (isset($_GET['id'])) {
        $user_id = $_GET['id'];
        $query = "SELECT * FROM hospitals WHERE hospital_id = $user_id";
        $result = mysqli_query($connection, $query);
        $total  = mysqli_num_rows($result);
        if ($total > 1 || $total < 1) {
            header('location: ' . $config['URL'] . '/management/admin');
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
            <a class="navbar-brand me-auto ms-lg-0 ms-3 text-uppercase fw-bold" >Admin Dashboard</a>
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
                        <a href="<?php echo $config['URL'] ?>/management/admin/details/patients/" class="nav-link px-3">
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
                    <h4>Available vaccine at <?php echo $_GET['name'];?></h4>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-4 row-cols-xl-6">
                <?php
                $id = $_GET['id'];
                $query = "SELECT * FROM available_vaccine WHERE hospital_id = $id";
                $result = mysqli_query($connection, $query);
                $total  = mysqli_num_rows($result);
                if ($total >= 1) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '
                        <div class="col-md-3 mb-3">
                            <div class="card bg-' . $row['vaccine_color'] . ' text-white h-100">
                                <div class="contianer px-3 pt-4">
                                    <h5>' . $row['vaccine_type'] . '</h5>
                                    <h6 class="text-end">Current Quantity ( <strong>' . $row['vaccine_quantity'] . '</strong> )</h6>
                                </div>
                            </div>
                        </div>
                        ';
                    }
                }
                ?>
                
            </div>
            <div class="row">
          <div class="col-md-12 mb-3">
            <div class="card">
              <div class="card-header">
                <span><i class="bi bi-table me-2"></i></span>All Doctor Details At <?php echo $_GET['name'];?>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table
                    id="example"
                    class="table table-striped data-table2"
                    style="width: 100%"
                  >
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>name</th>
                        <th>email</th>
                        <th>Approved</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $id = $_GET['id'];
                        $query = "SELECT * FROM hospital_users WHERE hospital_id = $id";
                        $result = mysqli_query($connection, $query);
                        $total  = mysqli_num_rows($result);
                        if ($total >= 1) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '
                                <tr>
                                    <td>'.$row['user_id'].'</td>
                                    <td>'.$row['name'].'</td>
                                    <td>'.$row['email'].'</td>
                                    <td>'.$row['approved'].'</td>
                                    <td>';
                                if ($row['approved'] != 'true'){
                                    echo '<form method="post">
                                            <div class="d-grid gap-2">
                                                <input type="text" class="d-none" name="id" value="' . $row['user_id'] . '">
                                                <input type="submit" value="Approve" class="btn btn-outline-primary" name="approve">
                                            </div>
                                        </form>';
                                }
                                echo '<form method="post">
                                        <div class="d-grid gap-2">
                                            <input type="text" class="d-none" name="id" value="' . $row['user_id'] . '">
                                            <input type="submit" value="Delete User" class="btn btn-outline-danger" name="delete">
                                        </div>
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
                        <th>#</th>
                        <th>name</th>
                        <th>email</th>
                        <th>Approved</th>
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