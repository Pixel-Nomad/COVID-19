<?php
require('config.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="icon" href='<?php echo $config['URL'] ?>/assets/image/fav/fav.ico' type="image/x-icon">
    <link rel="shortcut icon" href='<?php echo $config['URL'] ?>/assets/image/fav/fav.ico' type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo $config['URL'] ?>/assets/css/global.css">
</head>

<body style="background-color: #e4fffe;">
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
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="<?php echo $config['URL'] ?>/assets/image/slider/slider 3.png" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Stay Home</h5>
                    <p>Stay At Home, Keep You And Your Family Safe!</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="<?php echo $config['URL'] ?>/assets/image/slider/slider 2.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                </div>
            </div>
            <div class="carousel-item">
                <img src="<?php echo $config['URL'] ?>/assets/image/slider/slider1.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Stay Home</h5>
                    <p>Stay At Home, Keep You And Your Family Safe!</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <hr class="divider " />
    <div class="container mt-4 ">
        <h1 class="text-center fs-1 m-4">Coronavirus Disease (COVID-19)</h1>
        <h1 class="text-center fs-1 m-4">Outbreak Situation</h1>
        <div class="row row-cols-1 row-cols-md-2">
            <div class="col">
                <img src="<?php echo $config['URL'] ?>/assets/image/pics/pic1.png" class="rounded img-fluid mx-auto d-block" alt="...">
            </div>
            <div class="col">
                <div class="container m-4">
                    <ul class="nav nav-pills mb-3  nav-fill" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active fs-4" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Overview</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fs-4" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Treatment</button>
                        </li>

                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <br>
                            <p>
                            Coronavirus disease (COVID-19) is an infectious disease caused by a newly discovered coronavirus.
                            </p>
                            <br>
                            <p>Most people infected with the COVID-19 virus will experience mild to moderate respiratory illness and recover without requiring special treatment. Older people, and those with underlying medical problems like cardiovascular disease, diabetes, chronic respiratory disease, and cancer are more likely to develop serious illness.</p>
                            <br>
                            <ul>
                                <li>Avoid touching your face.</li>
                                <li>Cover your mouth and nose when coughing.</li>
                                <li>Stay home if you feel unwell.</li>
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <br>
                            <p>
                            Coronavirus disease (COVID-19) is an infectious disease caused by a newly discovered coronavirus.
                            </p>
                            <br>
                            <p>Most people infected with the COVID-19 virus will experience mild to moderate respiratory illness and recover without requiring special treatment. Older people, and those with underlying medical problems like cardiovascular disease, diabetes, chronic respiratory disease, and cancer are more likely to develop serious illness.</p>
                            <br>
                            <ul>
                                <li>Avoid touching your face.</li>
                                <li>Cover your mouth and nose when coughing.</li>
                                <li>Stay home if you feel unwell.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
                </div>
    </div>
    <hr class="divider " />
    <div class="container card p-3 bg-light shadow-static mt-5">
            <div class="row row-cols-1 row-cols-md-3">
                <div class="col">
                    <div class="position-relative">
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <img src="<?php echo $config['URL'] ?>/assets/image/pics/virus1.png" class="rounded img-fluid mx-auto d-block" alt="...">
                        </div>
                    </div>
                    <h1 class="text-center mt-5">1531188</h1>
                    <p class="text-center mt-2">Active Cases</p>
                </div>
                <div class="col">
                    <div class="position-relative">
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <img src="<?php echo $config['URL'] ?>/assets/image/pics/Virus2.png" class="rounded img-fluid mx-auto d-block" alt="...">
                        </div>
                    </div>
                    <h1 class="text-center mt-5">337276</h1>
                    <p class="text-center mt-2">Recovered Cases</p>
                </div>
                <div class="col">
                    <div class="position-relative">
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <img src="<?php echo $config['URL'] ?>/assets/image/pics/virus3.png" class="rounded img-fluid mx-auto d-block" alt="...">
                        </div>
                    </div>
                    <h1 class="text-center mt-5">89575</h1>
                    <p class="text-center mt-2">Total Deaths</p>
                </div>
            </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="<?php echo $config['URL'] ?>/assets/js/global.js"></script>
</body>

</html>