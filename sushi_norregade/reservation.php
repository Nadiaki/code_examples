<?php
require_once("db.php");

if(isset($_POST["reserve-table-submit"])){
    $reservationSuccess = false;
    $dateBooking = DateTime::createFromFormat("Y-m-d G:i", $_POST["date"]." ".$_POST["time"]);
    $time_booking = $dateBooking->format('Y-m-d H:i:s');

    $id_table = calculateBookingTable($time_booking, $_POST["number_guests"]);
    if(!empty($id_table)){
        insertBooking($_POST["email"], $_POST["name"], $_POST["phone"], $_POST["number_guests"], $time_booking, $id_table, $_POST["observations"]);
        $reservationSuccess = true;
    }
}

include("header.php");
?>

<div id="div-reservation" class="rice-light">
    <div class="row align-center">
        <div class="small-12 medium-8 large-6 columns">
            <?php 
            if(!empty($reservationSuccess)){
            ?>   
                <div data-alert class="callout success align-center text-center">
                  <p>Your reservation has been processed successfully!</p>
                  <p>A table for <?php echo $_POST["number_guests"]; ?> has been reserved for you on <?php echo $dateBooking->format("d-m-Y H:i"); ?></p>
                </div>
            <?php 
            }
            else{
            ?>
                <div data-alert class="callout alert align-center text-center">
                  <p>There seems to have been a problem booking your reservation</p>
                  <p>Please try again or contact us by phone at +45 33 12 70 70</p>
                </div>
            <?php    
            }
            ?>   
        </div>
    </div>
</div>

<!--footer-->
<?php
include("footer.php");
?>
