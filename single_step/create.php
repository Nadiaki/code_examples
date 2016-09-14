<!DOCTYPE html>

<html>
<head>
    <title>SINGLE STEP - tailor-made travels</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="main.css" rel="stylesheet" type="text/css" />
    <link rel="Shortcut Icon" href="images/favicon.ico" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="js/trip_selector.js"></script>

</head>

<body>
<!--NAV-->
    <nav>
        <a href="index.php"><img src="images/logo.png" alt="Single Step logo" id="nav_logo"/></a>
        <ul>
            <li><a href="index.php#discover">DISCOVER</a></li>
            <li><a href="explore.php">EXPLORE</a></li>
            <li><a href="create.php">CREATE</a></li>
            <li><a href="index.php#experience">EXPERIENCE</a></li>
            <li><a href="index.php#contact">CONTACT</a></li>
            <li><a href="login.php">LOG IN</a></li>
        </ul>
    </nav>

<!--END NAV-->


<!--CREATE-->
    <div id="create" class="vh_section">
        <h1>CREATE YOUR TRIP</h1>
        <div id="calculate_wrapper" class="center max_width">
	<div id="calculateTripForm" class="fifty left">
	    <form> <!--This form is does nothing. It has no method or action. -->
		<fieldset>
		<legend>Transport to Croatia:</legend>
		    <input type="checkbox"  value="1000" class="tripPrice">Airplane 1000kr<br/>
                        <input type="checkbox"  value="800" class="tripPrice">Train 800kr<br/>
			<input type="checkbox"  value="500" class="tripPrice">Bus 500kr<br/>
                        <input type="checkbox"  value="0" class="tripPrice">Your own car 0kr<br/>
                </fieldset>

                <fieldset>
		    <legend>Transport in Croatia:</legend>
			<input type="checkbox" value="1200" class="tripPrice">Rent a car (5 days) 1200kr<br/>
                        <input type="checkbox"  value="300" class="tripPrice">Train/bus 300kr<br/>
                        <input type="checkbox"  value="500" class="tripPrice">Boat 500kr<br/>
                        <input type="checkbox"  value="0" class="tripPrice">Your own car 0kr<br/>
                </fieldset>

                <fieldset>
		    <legend>Accommodation:</legend>
			<input type="checkbox" value="3000" class="tripPrice">Hotel 5 stars 3000kr<br/>
			<input type="checkbox"  value="2600" class="tripPrice">Hotel 4 stars 2600kr<br/>
			<input type="checkbox"  value="2000" class="tripPrice">Apartment 2000kr<br/>
			<input type="checkbox"  value="600" class="tripPrice">Hostel 600kr<br/>
	 	</fieldset>

                <fieldset>
		    <legend>Tours:</legend>
			<input type="checkbox" value="200" class="tripPrice">Bicycle tour 200kr<br/>
                        <input type="checkbox"  value="300" class="tripPrice">Wine cellar 300kr<br/>
			<input type="checkbox"  value="200" class="tripPrice">GOT tour 200kr<br/>
			<input type="checkbox"  value="100" class="tripPrice">City tour 100kr<br/>
			<input type="checkbox"  value="400" class="tripPrice">Sailing tour 400kr<br/>
			<input type="checkbox"  value="200" class="tripPrice">Local living 200kr<br/>
		</fieldset>

                <fieldset>
		    <legend>Single Step App Pack:</legend>
			<input type="checkbox" value="0" class="tripPrice">Basic 0kr<br/>
			<input type="checkbox"  value="50" class="tripPrice">Premium 50kr<br/>
		</fieldset>

                <fieldset>
		    <legend>Receive local offers during the trip for:</legend>
			<input type="checkbox" value="0" class="tripPrice">Restaurants<br/>
			<input type="checkbox"  value="0" class="tripPrice">Museums<br/>
			<input type="checkbox"  value="0" class="tripPrice">Shopping<br/>
			<input type="checkbox"  value="0" class="tripPrice">Additional tours<br/>
                        <hr/>
                        <p>Price:<span id = "total_trip_price"> 0kr </span></p>
                        <input type="submit" value="Reset"><input type="submit" value="Book Now!"><br/>

		</fieldset>

	    </form>
	</div>
        <div id="create_side" class="fifty left clearfix">
            <img src="images/gallery_boathouse.jpg" alt="House and boat" />
            <p>Praesent et neque a felis feugiat pharetra eget non ligula. Ut aliquam felis magna, in interdum enim lobortis a. Quisque aliquam urna vel nulla euismod suscipit. Vivamus nec scelerisque ligula, a dictum nisi. Vivamus bibendum vel metus vel dapibus. Duis in lacus nibh. Vivamus eget quam lorem. In semper auctor tincidunt. Nunc ullamcorper, nibh quis ornare volutpat, nisi sapien cursus tellus, et placerat urna purus nec diam. Integer a erat ullamcorper velit tincidunt rutrum.</p>
            <img src="images/gallery_sibenik.jpg" alt="Sibenik" />
            <p>Sed vitae lobortis elit, eget rhoncus augue. Fusce consequat, diam nec placerat suscipit, risus ante efficitur nunc, rutrum hendrerit nisl dui a sapien. Nulla lobortis, libero ac laoreet tempus, ligula mi venenatis sapien, nec lobortis augue felis ut neque. Etiam eros sapien, cursus ac varius quis, gravida blandit erat.</p>

        </div>
        </div>
    </div>
</body>
</html>
