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

    <body class="loginBody">
        <div class="BackgroundImage"></div> <!-- Background image container -->
        <div class="Navigation" id="navbar">
            <h1><a href="index.php">StepX</a></h1>
            <nav class="ClassForNav">
			    <?php include "nav.php"; ?>
		    </nav>
        </div>

        <div class="BoxForContents" id="box">
            <h2>Your Information</h2>
            <div class="TableForLogin">
                <form action="#" method="get">
                    <table>
                        <tr>
                            <td class="Labels">Username: </td>
                            <td><input type="text" placeholder="Username" value="example@example.com" class="inputBox" required></td>
                        </tr>
                        <tr>
                            <td class="Labels">Password: </td>
                            <td><input type="password" placeholder="Password" value="Password123" class="inputBox" required></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><button type="submit" class="inputButton">Update</button>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </body>
</html>