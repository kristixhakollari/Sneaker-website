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
            <h2>Our Catalog</h2>
            <table>
                <?php
                $json = file_get_contents('json/products.json');
                $products = json_decode($json, true);
    
                foreach ($products as $product) {
                    echo '
                        <tr>
                            <td class="CatalogImg"><button onclick="window.location.href=\'products.php?pid='.$product["pid"].'\'"><img src="'.$product["img_path_1"].'"></button></td>
                            <td class="CatalogInfo">'.$product["name"].'</td>
                            <td class="CatalogAddto"><button onclick="addToCollection(this)">+ Add</button></td>
                        </tr>
                    ';
                }
                ?>
            </table>
        </div>
        <div class="BoxForContents Collection" id="CatalogClass" hidden>
            <h2>
                Your Collection
            </h2>
            <table id="CatalogCollection">
            </table>
            <h3>Number of Products selected: <label id="CollectionCounter">0</label></h3>
        </div>
    </body>
</html>