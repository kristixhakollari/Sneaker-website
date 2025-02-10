<!-- Hidden when widht > 480px -->
<div class="ListForNav">
	<img src="img/icon.png" style="display: none;" onload="checkDarkMode()"> <!--Dummy image load-->
	<select id="navSelect" onchange="navigateToPage()">
		<option value="" hidden style="text-align: right;">Goto</option>
		<?php
		    session_start();

			// Check if user is logged in
			if ($_SESSION['isLoggedin'] === true) {
				$option = '<option value="logout.php">Logout</option>';
			} else {
				$option = '<option value="login.php">Login</option>';
			}

			echo $option;
		?>
		<option value="categories.php">Categories</option>
		<option value="about.php">About Us</option>
		<option value="reviews.php">Reviews</option>
		<option value="cart.php">Cart</option>
	</select>
</div>

<!-- Hidden when width < 490px -->
<table class="TableForNav">
	<tr>
	<?php 
		if(!isset($_SESSION['isLoggedin'])){
			$option = '<td><a href="login.php">Login</a></td>';
		} else {
			// Check if user is logged in
			if ($_SESSION['isLoggedin'] === true) {
				$option = '<td><a href="logout.php">Logout</a></td>';
			} else {
				$option = '<td><a href="login.php">Login</a></td>';
			}
		}	

			echo $option;
		?>
		<td><a href="categories.php">Categories</a></td>
		<td><a href="about.php">About Us</a></td>
		<td><a href="reviews.php">Reviews</a></td>
		<td><a href="cart.php">Cart</a></td>
		<td><button onclick="DarkMode()" class="inputButton ToggleDarkModeButton">🌗</button></td>
	</tr>
	<tr>
		<form action="search.php" method="GET" style="display: inline-block;">
    		<input type="text" name="query" placeholder="Search products..." required>
    		<button type="submit">🔍</button>
		</form>
	</tr>
</table>