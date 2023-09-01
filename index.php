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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous" />
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
        <h1 class="text-center fs-1 m-4"><b>Coronavirus Disease (COVID-19)</b></h1>
        <h1 class="text-center fs-1 m-4"><b>Outbreak Situation</b></h1>
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
    <hr class="divider " />
    <div class="container mt-4 ">
        <br>
        <div class="row row-cols-1 row-cols-md-2 mt-4">
            <div class="col">
                <div class="container m-4">
                    <h1 class="fs-1"><b>What Are The Main Symptoms?</b></h1>
                    <br>
                    <p>The COVID-19 virus affects different people in different ways.COVID-19 is a respiratory disease and most infected people will develop mild to moderate symptoms and recover without requiring special treatment. People who have underlying medical conditions and those over 60 years old have a higher risk of developing severe disease and death.</p>
                    <br>
                    <div class="row row-cols-1 row-cols-md-2">
                        <div class="col">
                            <h6>Common Symptoms Include:</h6>
                            <br>
                            <ul>
                                <li>Fever</li>
                                <li>Tiredness</li>
                                <li>Dry Cough</li>
                            </ul>
                        </div>
                        <div class="col">
                            <h6>Other Symptoms Include:</h6>
                            <br>
                            <ul>
                                <li>Shortness of Breath</li>
                                <li>Aches and Pains</li>
                                <li>Sore Throat</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <img src="<?php echo $config['URL'] ?>/assets/image/pics/symptoms-1.png" class="rounded img-fluid mx-auto d-block" alt="...">
            </div>
        </div>
    </div>
    <div class="container mt-4">
        <h1 class="text-center fs-1 mt-4"><b>Take Steps To Protect</b></h1>
        <h1 class="text-center fs-1 "><b>Yourself</b></h1>
        <div class="container m-4">
            <div class="row row-cols-1 row-cols-md-3">
                <div class="col">
                    <div class="card addHover p-3 mb-5 bg-gradient rounded">
                        <img src="<?php echo $config['URL'] ?>/assets/image/pics/protect-1.png" class="rounded mx-auto d-block" alt="Painting" />
                        <div class="card-body">
                            <h5 class="card-title text-center">Wear A Face Mask</h5>
                            <p class="card-text text-center">Coronavirus disease (COVID-19) is an infectious disease caused by a newly discovered coronavirus.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card addHover p-3 mb-5 bg-gradient rounded">
                        <img src="<?php echo $config['URL'] ?>/assets/image/pics/protect-2.png" class="rounded mx-auto d-block" alt="Painting" />
                        <div class="card-body">
                            <h5 class="card-title text-center">Wash Your Hands</h5>
                            <p class="card-text text-center">Coronavirus disease (COVID-19) is an infectious disease caused by a newly discovered coronavirus.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card addHover p-3 mb-5 bg-gradient rounded">
                        <img src="<?php echo $config['URL'] ?>/assets/image/pics/protect-3.png" class="rounded mx-auto d-block" alt="Painting" />
                        <div class="card-body">
                            <h5 class="card-title text-center">Avoid Close Contact</h5>
                            <p class="card-text text-center">Coronavirus disease (COVID-19) is an infectious disease caused by a newly discovered coronavirus.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <hr class="divider " />
    <div class="container mt-4 ">
        <div class="row row-cols-1 row-cols-md-2 mt-4">
            <div class="col">
                <div class="container m-4">
                    <h1 class="fs-1"><b>Common Question & Answer</b></h1>
                    <br>
                    <p>WHO is continuously monitoring and responding to this outbreak. This Q&A will be updated as more is known about COVID-19, how it spreads and how it is affecting people worldwide. For more information, check back regularly on WHO’s coronavirus pages. https://www.who.int/emergencies/diseases- es/novel-coronavirus-2019</p>
                    <br>
                    <button class="btn btn-dark rounded fs-3 ">Have A Question?</button>
                </div>
            </div>
            <div class="col">
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                <b> What is Novel Coronavirus?</b>
                            </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">Coronaviruses are a large family of viruses which may cause illness in animals or humans. In humans, several coronaviruses are known to cause respiratory infections ranging from the common cold to more severe diseases such as MERS and SARS.</div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                <b>What are The Symptoms of COVID-19?</b>
                            </button>
                        </h2>
                        <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">Coronaviruses are a large family of viruses which may cause illness in animals or humans. In humans, several coronaviruses are known to cause respiratory infections ranging from the common cold to more severe diseases such as MERS and SARS.</div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                <b> How does COVID-19 Spread?</b>
                            </button>
                        </h2>
                        <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">Coronaviruses are a large family of viruses which may cause illness in animals or humans. In humans, several coronaviruses are known to cause respiratory infections ranging from the common cold to more severe diseases such as MERS and SARS.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr class="divider " />
    <div class="container mt-4">
        <h1 class="fs-1 text-center"><b>More Than 100k Died in</b></h1>
        <h1 class="fs-1 text-center"><b>Covid-19</b></h1>
        <br>
        <img src="<?php echo $config['URL'] ?>/assets/image/pics/map.png" class="img-fluid" alt="...">
    </div>
    <hr class="divider " />
    <div class="container mt-4">
        <br>
        <div class="row row-cols-1 row-cols-md-2">
            <div class="col">
                <h1 class="fs-1 ps-5"><b>Meet Our Experts</b></h1>
            </div>
            <div class="col">
                <p>WHO is continuously monitoring and responding to this outbreak. This Q&A will be updated as more is known about COVID-19, how it spreads and how it is affecting people worldwide. For more information, check back regularly on WHO’s coronavirus pages.</p>
            </div>
        </div>
        <div class="container m-4">
            <div class="row row-cols-1 row-cols-md-3">
                <div class="col">
                    <div class="card addHover p-3 mb-5 bg-gradient rounded">
                        <img src="<?php echo $config['URL'] ?>/assets/image/pics/team-1.png" class="rounded mx-auto d-block" alt="Painting" />
                        <div class="card-body">
                            <h5 class="card-title text-center"><b>Dr. Dorothy Nickell</b></h5>
                            <p class="card-text text-center">Corona Specialist</p>
                            <p class="text-center m-4">Coronavirus disease (COVID-19) is an infectious disease caused</p>
                            <h4 class="text-center"><i class="fa fa-phone" style="color: #00aea5;"></i> +1 (123) 456-7890</h4>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card addHover p-3 mb-5 bg-gradient rounded">
                        <img src="<?php echo $config['URL'] ?>/assets/image/pics/team-2.png" class="rounded mx-auto d-block" alt="Painting" />
                        <div class="card-body">
                            <h5 class="card-title text-center"><b>Dr. Peter Thomas</b></h5>
                            <p class="card-text text-center">Corona Specialist</p>
                            <p class="text-center m-4">Coronavirus disease (COVID-19) is an infectious disease caused</p>
                            <h4 class="text-center"><i class="fa fa-phone" style="color: #00aea5;"></i> +1 (123) 456-7890</h4>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card addHover p-3 mb-5 bg-gradient rounded">
                        <img src="<?php echo $config['URL'] ?>/assets/image/pics/team-3.png" class="rounded mx-auto d-block" alt="Painting" />
                        <div class="card-body">
                            <h5 class="card-title text-center"><b>Dr. Elizabeth Nelson</b></h5>
                            <p class="card-text text-center">Corona Specialist</p>
                            <p class="text-center m-4">Coronavirus disease (COVID-19) is an infectious disease caused</p>
                            <h4 class="text-center"><i class="fa fa-phone" style="color: #00aea5;"></i> +1 (123) 456-7890</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr class="divider " />
    <div class="container-fluid mt-4 bg-dark">
        <div class="container m-4">
            <br>
            <br>
            <br>
            <h1 class="fs-1 text-center text-light mt-4"><b>How to Wash Your Hand</b></h1>
            <h1 class="fs-1 text-center text-light"><b>Properly</b></h1>
            <br>
            <div class="row row-cols-1 row-cols-md-6 ps-5">
                <div class="col">
                    <img src="<?php echo $config['URL'] ?>/assets/image/pics/hadnwash-1.png" class="rounded mx-auto d-block" alt="...">
                    <br>
                    <h6 class="text-center text-light">Apply Soap on Hand</h6>
                </div>
                <div class="col">
                    <img src="<?php echo $config['URL'] ?>/assets/image/pics/hadnwash-2.png" class="rounded mx-auto d-block" alt="...">
                    <br>
                    <h6 class="text-center text-light">Palm to Palm</h6>
                </div>
                <div class="col">
                    <img src="<?php echo $config['URL'] ?>/assets/image/pics/hadnwash-3.png" class="rounded mx-auto d-block" alt="...">
                    <br>
                    <h6 class="text-center text-light">Between Fingers</h6>
                </div>
                <div class="col">
                    <img src="<?php echo $config['URL'] ?>/assets/image/pics/hadnwash-4.png" class="rounded mx-auto d-block" alt="...">
                    <br>
                    <h6 class="text-center text-light">Back of The Hands</h6>
                </div>
                <div class="col">
                    <img src="<?php echo $config['URL'] ?>/assets/image/pics/hadnwash-5.png" class="rounded mx-auto d-block" alt="...">
                    <br>
                    <h6 class="text-center text-light">Clean with Water</h6>
                </div>
                <div class="col">
                    <img src="<?php echo $config['URL'] ?>/assets/image/pics/hadnwash-6.png" class="rounded mx-auto d-block" alt="...">
                    <br>
                    <h6 class="text-center text-light">Use Towel to Dry</h6>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="<?php echo $config['URL'] ?>/assets/js/global.js"></script>
</body>

</html>