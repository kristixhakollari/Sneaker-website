<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results | StepX</title>
    <link rel="stylesheet" href="styles/ProductStyles.css">
    <link rel="stylesheet" href="styles/mystyles.css">
    <link rel="icon" href="img/icon.png">
    <script src="js/global.js"></script>
</head>
<body class="ProductBody">
    <div class="BackgroundImage"></div>
    <div class="Navigation" id="navbar">
        <h1><a href="index.php" class="homeLink">StepX</a></h1>
        <nav class="ClassForNav">
            <?php include "nav.php"; ?>
        </nav>
    </div>

    <div class="BoxForContents" id="box">
        <?php
        if (isset($_GET['query'])) {
            $search_query = strtolower($_GET['query']);
            $json = file_get_contents('json/products.json');
            $products = json_decode($json, true);

            $search_results = array_filter($products, function($product) use ($search_query) {
                return 
                    stripos(strtolower($product['name']), $search_query) !== false ||
                    stripos(strtolower($product['description']), $search_query) !== false ||
                    stripos(strtolower($product['category']), $search_query) !== false;
            });

            if (!empty($search_results)) {
                echo '<h2>Search Results for "' . htmlspecialchars($_GET['query']) . '"</h2>';
                echo '<table>';

                foreach ($search_results as $product) {
                    echo '
                        <tr class="CatalogRow" onclick="window.location.href=\'products.php?pid='.$product["pid"].'\'">
                            <td class="CatalogImg"><button onclick="window.location.href=\'products.php?pid='.$product["pid"].'\'"><img src="'.$product["img_path_1"].'"></button></td>
                            <td class="CatalogInfo"><span>'.$product["name"].' ('. $product["category"] .')</span></td>
                        </tr>
                    ';
                }

                echo '</table>';
            } else {
                echo '<h3>No products found matching "' . htmlspecialchars($_GET['query']) . '"</h3>';
            }
        } else {
            echo '<h3>Please enter a search term</h3>';
        }
        ?>
    </div>
</body>
</html>