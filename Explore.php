<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 2017-03-05
 * Time: 09:54 PM
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
                <li><a href="#" onclick="sendAJAXRequest('logout',handleLogoutResponse())">Log Out</a></li>
                <li><a href="#" >Feeds</a></li>
                <li><a href="#" >Profile</a></li>
                <li><a href="#" >Followers</a></li>
                <li><a href="#" >Following</a></li>
                <li><a href="#" >Settings</a></li>
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
                            <li><a href="Feeds.php">Feeds</a></li>
                            <li><a id="details"></a></li>
                            <li><a href="#" onclick="sendAJAXRequest('logout',handleLogoutResponse())" >Log Out</a></li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- MAIN SECTION -->
            <section class="main-feeds">
                <form>
                    <div class="feed-container">

                        <div class="Explore-feeds">

                        </div>

                    </div>


                </form>
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
<script>
    sendAJAXRequest('validate-session',handleServerValidation);
    sendAJAXRequest('fetch-user-details', handleFetchUserDetials);
    //sendAJAXRequest('fetch-users', handleFetchUsers);
</script>


</body>
</html>

