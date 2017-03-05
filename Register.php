<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 2017-02-15
 * Time: 01:46 PM
 */
?>

<!doctype html>
<html class="no-js" lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ViewMe</title>
    <link rel="stylesheet" href="css/foundation.css">
    <link rel="stylesheet" href="css/app.css">
    <link rel="shortcut icon" type="image/png" href="img/r1.jpg" />
</head>
<body>

<div class="off-canvas-wrapper">
    <div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>

        <!-- OFF CANVAS MOBILE MENU SECTION GOES TO THE LEFT-->
        <div class="off-canvas position-left" id="mobile-menu" data-off-canvas>
            <ul>
                <li><a href="Index.php" >Home</a></li>
                <li><a href="#" >About</a></li>
                <li><a href="Login.php" >Log In</a></li>
                <li><a href="#" >Contact</a></li>
            </ul>
        </div>

        <!-- All WEB CONTENTE GOES IN THIS SECTION -->
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
                        <h3 class="site-logo">ViewMe</h3>
                    </div>
                    <div class="top-bar-right">
                        <ul class="menu menu-desktop">
                            <li><a href="Index.php" >Home</a></li>
                            <li><a href="#" >About</a></li>
                            <li><a href="Login.php" >Log In</a></li>
                            <li><a href="#" >Contact</a></li>
                        </ul>
                    </div>
                </div>
            </nav>


            <!-- MAIN SECTION -->
            <section class="main-register">
                <form id="register-form">
                    <div class="register-wrapper">
                        <h3> Create an account</h3>
                        <hr width="80%">
                        <div class="form-input">

                            <div class="row">
                                <div class="small-12 columns">
                                    <div class="row">
                                        <div class="small-3 columns">
                                            <label for="name" class="right inline">Name</label>
                                        </div>
                                        <div class="small-9 columns">
                                            <input type="text" id="name">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="small-12 columns">
                                    <div class="row">
                                        <div class="small-3 columns">
                                            <label for="surname" class="right inline">Surname</label>
                                        </div>
                                        <div class="small-9 columns">
                                            <input type="text" id="surname">
                                        </div>
                                    </div>
                                </div>
                            </div>

                                <div class="row">
                                    <div class="small-12 columns">
                                        <div class="row">
                                            <div class="small-3 columns">
                                                <label for="username" class="right inline">Username</label>
                                            </div>
                                            <div class="small-9 columns">
                                                <input type="text" id="username">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <div class="row">
                                <div class="small-12 columns">
                                    <div class="row">
                                        <div class="small-3 columns">
                                            <label for="gender" class="right inline">Gender</label>
                                        </div>
                                        <div class="small-9 columns">
                                            <div class="select-wrap-reg">
                                            <select>
                                                <option value="1">Male</option>
                                                <option value="2">Female</option>
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="small-12 columns">
                                    <div class="row">
                                        <div class="small-3 columns">
                                            <label for="email" class="right inline">Email</label>
                                        </div>
                                        <div class="small-9 columns">
                                            <input type="text" id="email">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="small-12 columns">
                                    <div class="row">
                                        <div class="small-3 columns">
                                            <label for="contactDetails" class="right inline">Mobile Number</label>
                                        </div>
                                        <div class="small-9 columns">
                                            <input type="text" id="contactDetails">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="small-12 columns">
                                    <div class="row">
                                        <div class="small-3 columns">
                                            <label for="password" class="right inline">Password</label>
                                        </div>
                                        <div class="small-9 columns">
                                            <input type="password" id="password" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="small-12 columns">
                                    <div class="row">
                                        <div class="small-3 columns">
                                            <label for="password" class="right inline">Confirm Password</label>
                                        </div>
                                        <div class="small-9 columns">
                                            <input type="password" id="password" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <p align="center">
                                <a class="button">SIGN UP</a>
                                <hr width="75%">
                                <p>Already have an account? <a href="Login.php">Login</a> </p>
                            </p>

                        </div>
                    </div>
                    <form>
            </section>


            <!-- FOOTER SECTION -->
            <footer>
                <div class="wrap row small-up-1 medium-up-3">
                    <div class="column">
                        <h3>Contact Inforamtion</h3>
                        <hr>
                        <a href="#"><span>Phone: </span> (+27) 83 450 1574</a>
                        <a href="#"><span>Email: </span> nick@pigeon.co.za</a>
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


