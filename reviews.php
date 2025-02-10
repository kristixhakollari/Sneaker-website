<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>StepX</title>
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
            <h1>Reviews</h1>
            <p class="StoreInformation">
        	Reviews from our beloved customers. <br> We will bring you the best available sneakers at one place.
            </p>
            <u1 class="ListForMainCategory">
                <table>
                    <tr class="CategoryRow">
                        <td class="CategoryImg"><img src="img/lucas.jpg" alt="Lucas Image"></td>
                        <td class="CategoryIntro">
                            <li><h2>Lucas Trenner</h2></li>
                            <li><h5>The best online sneaker buying experience possible.</h5></li>
                        </td>
                    </tr>
                    <tr class="CategoryRow"> 
                        <td class="CategoryImg"><img src="img/florencia.jpg" alt="Florencia Image"></td>
                        <td class="CategoryIntro">
                            <li><h2>Florencia Galahard</h2></li>
                            <li><h5>Never saw better prices for Nike originals.</h5></li>
                        </td>
                    </tr>
                    <tr class="CategoryRow">
                        <td class="CategoryImg"><img src="img/amber.jpg" alt="Amber Image"></td>
                        <td class="CategoryIntro">
                            <li><h2>Amber Shane</h2></li>
                            <li><h5>Very fast order shipping. I love it.</h5></li>
                        </td>
                    </tr>
                </table>
            </u1>
            <h2>Leave a Review:</h2>
            <form action="reviews.php" method="POST">
                <label for="name">Your Name:</label><br>
                <input type="text" id="name" name="name" placeholder="Enter your name" required><br>

                <label for="review">Review:</label><br>
                <textarea id="review" name="review" rows="4" cols="50" placeholder="Write your review here..." required></textarea><br>

                <input type="submit" value="Submit Review">
            </form>

            <?php
            // Handle the form submission
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Get user input from the form
                $name = htmlspecialchars($_POST['name']);
                $review = htmlspecialchars($_POST['review']);
                
                // Prepare the text to be written to the file
                $reviewText = "Name: $name\nReview: $review\n\n";

                // Specify the file to store the reviews
                $file = 'reviews.txt';

                // Append the review to the file
                file_put_contents($file, $reviewText, FILE_APPEND);
            }
            ?>
        </div>
    </body>
</html>