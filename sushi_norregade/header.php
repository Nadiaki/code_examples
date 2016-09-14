<?php
require_once("db.php");
?>
 <!doctype html>
<html class="no-js" lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sushi Nørregade</title>

    <link rel="stylesheet" href="css/foundation.css">
    <link rel="stylesheet" href="css/app.css">
    <link rel="stylesheet" href="css/slick.css">
    <link href='https://fonts.googleapis.com/css?family=Lato:400,300,700,700italic,900|Merriweather:400,700,900'
          rel='stylesheet' type='text/css'>
    <link rel="Shortcut Icon" href="img/favicon.ico" />

    <script src="js/vendor/jquery.js"></script>
    <script src="js/vendor/jquery.noty.packaged.min.js"></script>

</head>
<body>
<div class="off-canvas-wrapper">
    <div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>

        <!-- off-canvas title bar for 'small' screen -->
        <div class="title-bar navigation-bar" data-responsive-toggle="widemenu" data-toggle="offCanvasLeft" data-hide-for="large" data-nav-status="toggle">
            <div class="title-bar-left">
                <button class="menu-icon" type="button" data-open="offCanvasLeft"></button>

            </div>
        </div>

        <!-- off-canvas menu -->
        <div class="off-canvas position-left" id="offCanvasLeft" data-off-canvas data-toggle="offCanvasLeft">
            <ul class="vertical menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="#">Our story</a></li>
                <li><a href="#">Menu</a>
                    <ul class="nested vertical menu">
                        <li><a href="a-la-carte.php">A la carte</a></li>
                        <li><a href="all-you-can-eat.php">All you can eat</a></li>
                        <li><a href="#">Take-away</a></li>
                        <li><a href="#">Beverages</a></li>
                    </ul>
                </li>
                <li><a href="index.php#div-reservation">Reservation</a></li>
                <li><a href="#">Contact</a></li>
                <?php
                    if(isUserLoggedIn()){
                ?>
                        <li><a href="logout.php">Logout</a></li>
                        <li><a href="#">Back office</a>
                            <ul class="nested vertical menu">
                                <li><a href="kitchen_orders.php">Kitchen</a></li>
                                <li><a href="list_reservations.php">Reservations</a></li>
                                <li><a href="manage_stocks.php">Stock management</a></li>
                                <li><a href="waiter-mode.php">Waiter mode</a></li>
                            </ul>
                        </li>
                <?php
                    }
                    else{
                ?>
                        <li><a href="login.php">Login</a></li>
                <?php     
                    }
                ?>
            </ul>
        </div><!--off-canvas menu end-->


        <!-- "wider" top-bar menu for 'medium' and up -->
        <div id="widemenu" class="top-bar" data-nav-status="toggle">

            <div class="row">
                <div class="columns">

                    <ul class="dropdown menu" data-dropdown-menu>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="#">Our story</a></li>
                        <li class="has-submenu"><a href="#">Menu</a>
                            <ul class="menu submenu vertical" data-submenu>
                                <li><a href="a-la-carte.php">A la carte</a></li>
                                <li><a href="all-you-can-eat.php">All you can eat</a></li>
                                <li><a href="#">Take - away</a></li>
                                <li><a href="#">Beverages</a></li>
                            </ul>
                        </li>
                        <li><a href="index.php#div-reservation">Reservation</a></li>
                        <li><a href="#">Contact</a></li>
                        <?php
                            if(isUserLoggedIn()){
                        ?>
                                <li><a href="logout.php">Logout</a></li>
                                <li class="has-submenu"><a href="#">Back office</a>
                                    <ul class="menu submenu vertical" data-submenu>
                                        <li><a href="kitchen_orders.php">Kitchen</a></li>
                                        <li><a href="list_reservations.php">Reservations</a></li>
                                        <li><a href="manage_stocks.php">Stock management</a></li>
                                        <li><a href="waiter-mode.php">Waiter mode</a></li>
                                    </ul>
                                </li>
                        <?php
                            }
                            else{
                        ?>
                                <li><a href="login.php">Login</a></li>
                        <?php     
                            }
                        ?>
                    </ul>
                </div>
            </div>

            <!--global navigation-->


        </div>
        <!--content starts here -->
        <!-- original content goes in this container -->
        <div class="off-canvas-content" data-off-canvas-content>
