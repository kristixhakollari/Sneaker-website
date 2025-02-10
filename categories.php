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

    <body class="CategoryBody">
        <div class="BackgroundImage"></div> <!-- Background image container -->
        <div class="Navigation" id="navbar">
            <h1><a href="index.php">StepX</a></h1>
            <nav class="ClassForNav">
			    <?php include "nav.php"; ?>
		    </nav>
        </div>

        <div class="BoxForContents" id="box">
            <h1>Categories</h1>
            <ul class="ListForMainCategory">
                <table>
                    <?php
                        $categories = json_decode(file_get_contents('json/categories.json'), true);
                        foreach ($categories as $category) {
                            echo '
                                <tr class="CategoryRow">
                                    <td class="CategoryImg"><img src="'.$category['img'].'" alt="'.$category['name'].' Image"></td>
                                    <td class="CategoryIntro">
                                        <li><h2>'.$category['name'].'</h2></li>
                                        <ul class="ListForSubCategory">
                                            <li><a href="'.$category['product1_link'].'">'.$category['product1'].'</a></li>
                                            <li><a href="'.$category['product2_link'].'">'.$category['product2'].'</a></li>
                                            <li><a href="'.$category['product3_link'].'">'.$category['product3'].'</a></li>
                                        </ul>
                                    </td>
                                </tr>
                            ';
                        }
                    ?>
                </table>
            </ul>
        </div>
    </body>
</html>