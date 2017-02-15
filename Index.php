<?php

/**
 * Created by Nicholas Rader.
 * Date: 2017-01-28
 * Time: 01:28 PM
 */
?>

<?php

/**
 * Created by Nicholas Rader.
 * Date: 2017-01-28
 * Time: 01:28 PM
 */
?>

<!doctype html>
<html class="no-js" lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VU-ME</title>
    <link rel="stylesheet" href="css/foundation.css">
    <link rel="stylesheet" href="css/app.css">
    <link rel="shortcut icon" type="image/png" href="img/r1.png" />
</head>
<body>

<div class="off-canvas-wrapper">
    <div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>

        <!-- OFF CANVAS MOBILE MENU SECTION GOES TO THE LEFT-->
        <div class="off-canvas position-left" id="mobile-menu" data-off-canvas>
            <ul>
                <li><a href="#" >Home</a></li>
                <li><a href="#" >About</a></li>
                <li><a href="Login.php" >Log In</a></li>
                <li><a href="#" >Contact</a></li>
            </ul>
        </div>

        <!-- All WEB CONTENT GOES IN THIS SECTION -->
        <div class="off-canvas-content" data-off-canvas-content>

            <!-- MOBILE NAVIGATION SECTION -->
            <div class="title-bar show-for-small-only">
                <div class="title-bar-left">
                    <button class="menu-icon" type="button" data-open="mobile-menu"></button>
                    <span class="title-bar-title">MENU</span>
                </div>
            </div>

            <!-- NAVIGATION SECTION -->
            <nav class="top-bar nav-desktop">
                <div class="wrap">
                    <div class="top-bar-left">
                        <h3 class="site-logo">VU-ME</h3>
                    </div>
                    <div class="top-bar-right">
                        <ul class="menu menu-desktop">
                            <li><a href="#" >Home</a></li>
                            <li><a href="#" >About</a></li>
                            <!--<li><a data-open="Login-modal">Log In</a></li> -->
                            <li><a href="Login.php" >Log In</a></li>
                            <li><a href="#" >Contact</a></li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- LOGIN MODAL SECTION -->
            <div class="small reveal" id="Login-modal" data-reveal>
                <h3 align="center">
                    <span class="line"></span>
                    <span class="text-center">Enter Your login Details</span>
                </h3>
                <br>
                <hr>
                <img src="img/Pigeon.png">
                <form>

                    <div class="form-input" align="center">
                        <input type="text" name="username" placeholder="Enter Username" >
                    </div>
                    <div class="form-input" align="center">
                        <input type="password" name="password" placeholder="Enter Password" >
                    </div>

                    <p align="center">
                        <a href="#" class="button">LOGIN</a>
                    <hr width="75%">
                    <a href="Register.html">Have'nt got an account yet?</a>
                    </p>
                </form>

                <button class="close-button" data-close aria-label="Close modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <!-- HERO SECTION -->
            <section class="hero">
                <div class="wrap">
                    <h1 align="center"> Welcome to ViewMe </h1>
                    <p align="center">Any bird of the family Columbidae, having a compact body and short legs, especially the larger species with square or rounded tails. In Poker Slang pigeon would mean a card, acquired in the draw, that greatly improves a hand or makes it a winner.</p>
                    <p align="center">
                        <a href="#" class="button">Learn More</a>
                        <a href="#" class="button success">Contact Us</a>
                    </p>
                </div>
            </section>

            <!-- MAIN SECTION -->
            <section class="main">
                <!-- small-up-1 means 1 row on small screen and medium-up-3 means 3 columns-->
                <!-- class = "wrap row small-up-1 medium-up-3"-->
                <div class="wrap row">
                    <div class="small-12 medium-4 column">
                        <h1 align="center"> Main Section</h1>
                        <p align="center"><img src="img/Pigeon.png" width="200" height="200"></p>
                        <p align="center">Any bird of the family Columbidae, having a compact body and short legs, especially the larger species with square or rounded tails. In Poker Slang pigeon would mean a card, acquired in the draw, that greatly improves a hand or makes it a winner.</p>
                        <p align="center">
                        </p>
                    </div>
                    <div class="small-12 medium-4 column">
                        <h1 align="center"> Second Section </h1>
                        <p align="center"><img src="img/Pigeon.png" width="200" height="200"></p>
                        <p align="center">Any bird of the family Columbidae, having a compact body and short legs, especially the larger species with square or rounded tails. In Poker Slang pigeon would mean a card, acquired in the draw, that greatly improves a hand or makes it a winner.</p>
                        <p align="center">
                        </p>
                    </div>
                    <div class="small-12 medium-4 column">
                        <h1 align="center"> Third Section </h1>
                        <p align="center"><img src="img/Pigeon.png" width="200" height="200"></p>
                        <p align="center">Any bird of the family Columbidae, having a compact body and short legs, especially the larger species with square or rounded tails. In Poker Slang pigeon would mean a card, acquired in the draw, that greatly improves a hand or makes it a winner.</p>
                        <p align="center">
                        </p>
                    </div>

                </div>
            </section>

            <!-- FOOTER SECTION -->
            <footer>
                <div class="wrap row small-up-1 medium-up-3">
                    <div class="column">
                        <h3>Contact Inforamtion</h3>
                        <hr>
                        <a href="#"><span>Phone: </span> (+27) 83 450 1574</a>
                        <a href="#"><span>Email: </span> nick@ViewME.co.za</a>
                        <a href="#"><span>Address: </span> 15 Wonder Where Street, Atlantico</a>
                    </div>
                    <div class="column">
                        <h3>How can we Help</h3>
                        <hr>
                        <a href="#">About Us</a>
                        <a href="#">Services</a>
                        <a href="#">Conteact Us</a>
                    </div>
                    <div class="column">
                        <h3>Socail Media</h3>
                        <hr>
                        <a href="#">Facebook</a>
                        <a href="#">Twitter</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</div>


<script src="js/vendor/jquery.js"></script>
<script src="js/vendor/what-input.js"></script>
<script src="js/vendor/foundation.js"></script>
<script src="js/app.js"></script>
</body>
</html>



