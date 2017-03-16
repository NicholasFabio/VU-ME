<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 2017-02-22
 * Time: 09:16 PM
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


    <style>
        .right ul{
            list-style:none;
        }
        .right ul li{
            margin:5px 5px;
        }
        .right ul li input{
            padding: 4px;
        }
        .right-email{
            float:left;
        }

        .right-pass{
            float:left;
        }
        .btn{
            margin: 25px 1px;
            padding:0px;
            border:none;
            background:#8fc400;
            color:white;
            border: 1px solid rgb(40, 77, 39);
            padding: 2px 3px;
        }

        .right-btn{
            line-height: 6;}

        .white{
            color:white;
        }


        #login >#logout li {
            list-style: none;

        }

        #login >#logout li a {
            color: #fff;
            font-weight: bolder;
            text-decoration: none;
        }


        .center{
            width:600px;
            margin:0px auto;
        }

        .posts{
            width:600px;
            height:auto;
        }

        .create-posts{
            width: 90%;
            background: #FFF none repeat scroll 0% 0%;
            border-radius: 2px;
            border: 1px solid #E1E0E0;
            margin-bottom:10px;
        }

        .c-header{
            width:100%;
            height:auto;
            padding-top:5px;
        }

        .c-h-inner{
            width:95%;
            height:25px;
            margin:0px 15px;
            border-bottom:1px solid #E5E5E5;
            font-size:12px;
            font-weight:bold;
        }

        .c-h-inner ul{
            list-style:none;
            margin-top:2px;
        }

        .c-h-inner ul li{
            display:inline;
            border-right: 1px solid #E9E3E3;
            padding-right:10px;
        }
        .c-h-inner  ul li a{
            color: rgb(59, 89, 152);
            text-decoration: none;
        }
        .c-h-inner ul li a:hover{
            text-decoration:underline;
        }

        .c-h-inner ul li img{
            margin: -2px 3px;
        }
        .c-body{
            width:100%;
            height:auto;
            border-bottom:1px solid #E5E5E5;
            overflow: auto;
        }
        #body-bottom{
            border-top: 1px solid #8fc400;
            margin: 10px;
            display: none;
        }
        #body-bottom img{
            margin: 10px;
            height: 95px;
            width: 95px;
        }
        .iconw-margin{
            margin: -2px 4px;
        }
        .iconp-margin{
            margin: -3px 1px;
        }
        .body-left{
            width:62px;
            height:auto;
            float:left;
            margin-left:15px;
        }


        .img-box {
            width:50px;
            height:50px;
            margin: 10px 0px;
            border: 1px solid #F5F1F1;
        }

        .img-box img{
            width:100%;
            height:100%;
        }

        .body-right{
            width:
        }

        .text-type{
            width: 400px;
            height: auto;
            resize: none;
            margin: 23px 0px;
            font-size: 14px;
            color: #959698;
            border:none;
            overflow:hidden;
        }

        .c-footer{
            overflow:auto;
        }
        .right-box{
            float:right;
        }

        .right-box ul {
            list-style:none;

        }

        .right-box ul li{
            display:inline;
        }
        .btn1{
            width: 88px;
            border:1px solid #ccc ;
            background: white none repeat scroll 0% 0%;
            font-weight: bolder;
            color: rgb(87, 87, 87);
            border-radius: 2px;
            margin: 10px 0px;
            height: 25px;
            font-size:12px;
        }

        .btn1:active{
            bordeR:1px solid rgb(71, 100, 159);
        }


        .btn2{
            background: rgb(71, 100, 159) none repeat scroll 0% 0%;
            color: white;
            font-weight: bolder;
            font-size: 12px;
            margin: 0px 7px;
            width: 65px;
            height: 25px;
            border: 1px solid rgb(204, 204, 204);
            border-radius: 4px;
        }

        .btn2:active{
            border:2px solid rgba(71, 100, 159, 0.55);
        }

        .btn2:hoveR{
            cursor:pointer;
        }

        .btn1:hoveR{
            cursor:pointer;
        }

    </style>


</head>
<body>

<div class="off-canvas-wrapper">
    <div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>

        <!-- OFF CANVAS MOBILE MENU SECTION GOES TO THE LEFT-->
        <div class="off-canvas position-left" id="mobile-menu" data-off-canvas>
            <ul>
                <li><a href="#" onclick="sendAJAXRequest('logout',handleLogoutResponse())">Log Out</a></li>
                <li><a href="#" >Explore</a></li>
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
                            <li><a href="Explore.php"><img src="img/V-logo2.png" width="45" height="45" alt="Explore"></a></li>
                            <li><a href="UserProfile.php" id="details"></a></li>
                            <li><a href="#" onclick="sendAJAXRequest('logout',handleLogoutResponse)" >Log Out</a></li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- MAIN SECTION -->


            <section class ="main-posts">



                <div class="Locate" style="padding: 5px">
                    <button class="button success" onclick="getLocation()">Fetch Location</button>

                    <p id="location"></p>

                </div>
                <div class="wrapper">
                    <!--content -->
                    <div class="content">
                        <!--left-content-->
                        <div class="center">
                            <div class="posts">
                                <div class="create-posts">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <div class="c-header">
                                            <div class="c-h-inner">
                                                <ul>
                                                    <li style="border-right:none;"><a href="#"><img src="img/vn.png" width="20" height="20">Add Voice Log</a></li>
                                                    <li><input type="file"  onchange="readURL(this);" style="display:none;" name="post_image" id="uploadFile"></li>
                                                    <li><img src="img/cam.png" width="20" height="20"><a href="#" id="uploadTrigger" name="post_image">Add Photos/Video</a></li>
                                                    <li style="border: none;"><a href="#"> <img src="img/album.png" width="25" height="25">Create Photo Album</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="c-body">
                                            <div class="body-left">
                                                <div class="img-box">
                                                    <img src="">

                                                </div>
                                            </div>
                                            <div class="body-right">
                                                <textarea class="text-type" name="status" placeholder="What's on your mind?"></textarea>
                                            </div>
                                            <div id="body-bottom">
                                                <img src="#"  id="preview"/>
                                            </div>
                                        </div>
                                        <div class="c-footer">
                                            <div class="right-box">
                                                <ul>
                                                   <!-- <li><button class="btn1"><img class="iconw-margin" src="img/iconw.png">Public<img class="iconp-margin" src="img/iconp.png"></button></li>
                                                   --> <li><input type="submit" name="submit" value="Post" class="btn2"/></li>
                                                </ul>
                                            </div>

                                        </div>
                                </div>
                            </div>

                        </div>
                        </form>

                    </div>



                </div>

            </section>

            <section class="main-feeds">
                <form>
                <div class="feed-container">
                    <h3>Feed's</h3>
                        <hr>
                        <div class="feeds">
                            <p id="feeds-table">

                            </p>
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





<script type="text/javascript">
    //Image Preview Function
    $("#uploadTrigger").click(function(){
        $("#uploadFile").click();
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#body-bottom').show();
                $('#preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

</script>
<script src="js/vendor/jquery.js"></script>
<script src="js/vendor/what-input.js"></script>
<script src="js/vendor/foundation.js"></script>
<script src="js/app.js"></script>

<script>
    sendAJAXRequest('validate-session',handleServerValidation);
    sendAJAXRequest('fetch-user-details', handleFetchUserDetials);
    sendAJAXRequest('fetch-following-posts', handleFetchFollowingPosts);
</script>


</body>
</html>



