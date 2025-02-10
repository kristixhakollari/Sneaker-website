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
<?php session_destroy(); ?>
    <body class="loginBody">
        <div class="BackgroundImage"></div> <!-- Background image container -->
        <div class="Navigation" id="navbar">
            <h1><a href="index.php">StepX</a></h1>
            <nav class="ClassForNav">
			    <?php include "nav.php"; ?>
		    </nav>
        </div>

        <div class="BoxForContents" id="box">
            <h1>About Us</h1>
            <p class="StoreInformation">
        	The Store is still under construction! <br> We will bring to you the best available sneakers to one place.
            </p>
            <u1 class="ListForMainCategory">
                <table>
                    <tr class="CategoryRow">
                        <td class="CategoryImg"><img src="img/black.jpeg" alt="Black Image"></td>
                        <td class="CategoryIntro">
                            <li><h2>Harmish Tanna</h2></li>
                          
                            
                        </td>
                    </tr>
                    <tr class="CategoryRow"> 
                        <td  class="CategoryImg"><img src="img/red.jpeg" alt="Red Image"></td>
                        <td class="CategoryIntro">
                            <li><h2>Adil Ahmed</h2></li>
                            
                            
                        </td>
                    </tr>
                    <tr class="CategoryRow">
                        <td class="CategoryImg"><img src="img/goldyellow.jpeg" alt="Gold Image"></td>
                        <td class="CategoryIntro">
                            <li><h2>Kristi Xhakollari</h2></li>
                            
                            
                        </td>
                    </tr>
                </table>
            </u1>
        </div>
    </body>
</html>