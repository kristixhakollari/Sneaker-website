<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            StepX
        </title>
        <link rel="stylesheet" href="styles/mystyles.css">
        <link rel="icon" href="img/icon.png">
        <script src="js/global.js"></script>
    </head>

    <body class="LogoutBody">
        <div class="BackgroundImage"></div> <!-- Background image container -->
        <div class="Navigation" id="navbar">
            <h1><a href="index.php">StepX</a></h1>
            <nav class="ClassForNav">
			    <?php include "nav.php"; ?>
		    </nav>
        </div>

        <div class="BoxForContents" id="box">
        <?php
            // Check if user is logged in
            $Label = "";
            if (isset($_SESSION['isLoggedin']) || $_SESSION['isLoggedin'] === true) {
                $_SESSION['isLoggedin'] = false;
            } else {
                $Label = '<label>You were already Logged out!</label>';
            }

            echo $Label;
            ?>
            <h1>You are Successfully Logged Out!</h1>
            <h3>Want to Login again? <a href="login.php" class="loginLink">Click here</a></h3>
        </div>
    </body>
</html>