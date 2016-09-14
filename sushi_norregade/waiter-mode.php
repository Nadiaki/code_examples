<?php
    require_once("header.php");
    if(!empty($_POST["order-served"])){
        $orderId = $_POST["order_id"];
        setOrderStatus($orderId, "delivered");
    }

    if(isset($_POST["reserve-table-submit"])){
        $reservationSuccess = false;
        $dateReservation = new DateTime();
        $time_booking = $dateReservation->format('Y-m-d H:i:s');
        $id_table = calculateBookingTable($time_booking, $_POST["guest-number"]);
        if(!empty($id_table)){
            insertBooking("", "Waiter Reservation", "", $_POST["guest-number"], $time_booking, $id_table, "");
            $reservationSuccess = true;
        }
    }
?>

<!--waiter mode-->
<div id="div-waiter-mode">
    <!--selection screen-->
    <div id="div-waiter-select">
        <div class="row align-center text-center">
            <div class="small-12 medium-8 large-6 columns">
                <h2>WELCOME, <span class="salmon-text">USERNAME!</span></h2>

                <div class="selection-wrapper"><p>Please select action:</p>
                    <p><a href="#div-waiter-reserve" class="button expanded">RESERVE TABLE</a></p>
                    <p><a href="#div-waiter-ready" class="button expanded">READY TO SERVE</a></p>
                    <p><a href="" class="button expanded">ACTIVE ORDERS</a></p>
                    <p><a href="" class="button expanded">PLACE ORDER</a></p>
                </div>

            </div>
        </div>
    </div>

    <!--reserve table-->
    <div id="div-waiter-reserve">
        <div class="row align-center text-center">
            <div class="small-12 medium-8 large-6 columns">
                <h3>RESERVE <span class="salmon-text">TABLE</span></h3>

                <form action="waiter-mode.php#div-waiter-reserve" method="POST">
                    <div class="selection-wrapper"><p>Number of guests:</p>
                        <div class="row">
                            <div class="small-9 columns">
                                <div class="slider" data-slider data-initial-start="1" data-end="10">
                                    <span class="slider-handle"  data-slider-handle role="slider"
                                          aria-controls="guest-number"></span>
                                    <span class="slider-fill" data-slider-fill></span>
                                </div>
                            </div>
                            <div class="small-3 columns">
                                <input type="tel" id="guest-number" name="guest-number">
                            </div>
                        </div>
                        <p><button class="button expanded" name="reserve-table-submit" type="submit">RESERVE TABLE</button></p>

                        <?php 
                            if(isset($reservationSuccess)){
                        ?>
                                <div class="waiter-reservation-confirmation">
                                    <p class="bold"><?php echo $reservationSuccess === true ? "RESERVATION SUCCESSFUL!" : "Error, please try again!"; ?></p>
                                    <?php 
                                        if($reservationSuccess === true){
                                            $reservedUntil = new Datetime();
                                            $reservedUntil = $reservedUntil->add(new DateInterval("PT2H"))->format('Y-m-d H:i'); 
                                    ?>
                                            <p>Table number <?php echo $id_table; ?> is reserved for <?php echo $_POST["guest-number"]; ?>
                                                until <?php echo $reservedUntil; ?>.</p>
                                    <?php
                                        }
                                    ?>
                                </div>

                        <?php    
                            }
                        ?>
                    </div>
                </form>

            </div>
        </div>
    </div>
    
    <!--ready to serve-->
    <div id="div-waiter-ready">
        <div class="row align-center">
            <div class="small-12 medium-8 large-6 columns">
                <h3 class="text-center">READY TO <span class="salmon-text">SERVE</span></h3>
                <ul class="selection-wrapper">
                <?php
                    $ordersPrepared = getOrderStatus("prepared");
                    if(empty($ordersPrepared)){
                        echo "No orders are prepared and ready to be delivered";    
                    }
                    else{
                        foreach ($ordersPrepared as $orderPrepared) {
                ?>
                       <form method="POST" action="waiter-mode.php#div-waiter-ready">
                           <li>
                            <p>Order for table <?php echo $orderPrepared["id_table"]; ?>, completed and is ready to be served:</p>
                            <?php
                            $items = getOrderDetails($orderPrepared["id"]);
                            foreach ($items as $item) {
                            ?>
                                <span>Qty: <?php echo $item["quantity"]; ?> <?php echo $item["name_dk"]; ?></span><br/>
                            <?php    
                            }
                            ?>
                            <input type="hidden" name="order_id" value="<?php echo $orderPrepared["id"]; ?>">
                            <p><input type="submit" class="button expanded" name="order-served" value="MARK ORDER AS SERVED" /></p>
                            </li>     
                        </form>        
                        <?php
                            }
                    }
                ?>
                </ul>
            </div>
        </div>
    </div>

    <!--active orders-->
    <div id="div-waiter-active">

    </div>

    <!--calls-->
    <div id="div-waiter-calls">

    </div>


</div>

<script src="js/waiter.js"></script>

<!--TODO: We don't really need footer there, need to create alternative end of page for digital ordering system modes-->
<?php
    require_once("footer.php");
?>