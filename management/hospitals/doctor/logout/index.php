<?php
    require ('../../../../config.php'); 
    session_name('management_hospitals');
    session_start();
    if (isset($_SESSION['hospital-isloggedin'])){
        session_unset();
        session_destroy();
        header('location: '. $config['URL'].'/management/hospitals/doctor/login/');
        exit();
    } else {
        header('location: '. $config['URL'].'/management/hospitals/doctor/login/');
        exit();
    }
?>