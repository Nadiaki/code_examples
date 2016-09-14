<?php
include("header.php");
$bookings = getBookings(new DateTime());
?>

<div id="div-reservation" class="rice-light">
    <div class="row align-center selection-wrapper">
        <div class="small-12 medium-10 columns">

			<?php
			foreach ($bookings as $booking) {
			?>
				<div>
					<p>
						Name: <?php echo $booking["name"]." Time: ".$booking["time_booking"]." Guests: "
							.$booking["number_guests"]." Table: ".$booking["id_table"]; ?>
					</p>
					<p>
						<?php echo $booking["observations"]; ?>
					</p>
				</div>

			<?php
			}
			?>	

		</div>
	</div>
</div>
<?php
include("footer.php");