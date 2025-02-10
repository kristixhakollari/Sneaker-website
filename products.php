<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        StepX
    </title>
    <link rel="stylesheet" href="styles/ProductStyles.css">
    <link rel="stylesheet" href="styles/mystyles.css">
    <link rel="icon" href="img/icon.png">
    <script src="js/global.js"></script>
</head>

<body class="ProductBody">
    <div class="BackgroundImage"></div> <!-- Background image container -->
    <div class="Navigation" id="navbar">
        <h1><a href="index.php" class="homeLink">StepX</a></h1>
        <nav class="ClassForNav">
			    <?php include "nav.php"; ?>
		</nav>
    </div>

    <div class="BoxForContents" id="box">
        <?php
        $label = "";

        // Check if user is logged in
        if (!isset($_SESSION['isLoggedin'])){
            $label = "<label>Please Login First, Go to login page</label>";
        }
        if (isset($_SESSION['isLoggedin']) && $_SESSION['isLoggedin'] === false) {
            $label = "<label>Please Login First</label>";
        }

        // Get filter and sort values from the URL (if any)
        $category_filter = isset($_GET["category"]) ? $_GET["category"] : "";
        $brand_filter = isset($_GET["brand"]) ? $_GET["brand"] : "";
        $sort_order = isset($_GET["sort"]) ? $_GET["sort"] : "asc";  // Default sorting: ascending

        $json = file_get_contents('json/products.json');
        $products = json_decode($json, true);

        // Filter by brand if selected
        if ($brand_filter) {
            $products = array_filter($products, function ($product) use ($brand_filter) {
                return strtolower($product["category"]) === strtolower($brand_filter);
            });
        }

        // Sorting by price
        usort($products, function ($a, $b) use ($sort_order) {
            if ($sort_order === "asc") {
                return $a['price'] - $b['price'];
            } else {
                return $b['price'] - $a['price'];
            }
        });

        // Display the filters and sorting options
        echo '
        <div class="filter-sort-options">
            <form method="get" action="">
                <label for="brand">Filter by Brand: </label>
                <select name="brand" id="brand">
                    <option value="">All Brands</option>
                    <option value="nike" ' . ($brand_filter == "nike" ? "selected" : "") . '>Nike</option>
                    <option value="adidas" ' . ($brand_filter == "adidas" ? "selected" : "") . '>Adidas</option>
                    <option value="puma" ' . ($brand_filter == "puma" ? "selected" : "") . '>Puma</option>
                </select>

                <label for="sort">Sort by Price: </label>
                <select name="sort" id="sort">
                    <option value="asc" ' . ($sort_order == "asc" ? "selected" : "") . '>Price: Low to High</option>
                    <option value="desc" ' . ($sort_order == "desc" ? "selected" : "") . '>Price: High to Low</option>
                </select>

                <button type="submit">Apply</button>
            </form>
        </div>
        ';

        if (isset($_GET["pid"])) {
            // variables
            $product_id = $_GET["pid"];
            $product_data = null;
            $json = file_get_contents('json/products.json');

            // converting json to array
            $products = json_decode($json, true);

            foreach ($products as $product) {
                // searcbh the required product
                if ($product["pid"] == $product_id) {
                    $product_data = $product;
                    break;
                }
            }

            

            if ($product_data) {
                // Show product on html if product found!
                echo '
                        <h2>' . $product_data['name'] . '</h2>
                        <table class="ProductTable">
                            <tr>
                                <td class="ProductImg">
                                    <div id="productSlider">
                                        <div id="sliderWrapper">
                                            <img src="' . $product_data['img_path_1'] . '" alt="' . $product_data['name'] . ' 1">
                                            <img src="' . $product_data['img_path_2'] . '" alt="' . $product_data['name'] . ' 2">
                                        </div>
                                        <button id="prevBtn" onclick="scrollPrevImg()">❮</button>
                                        <button id="nextBtn" onclick="scrollNextImg()">❯</button>
                                    </div>
                                </td>

                                <td class="ProductInfo">' . $product_data['description'] . '<br>
                                    <form action="#" class="ProductForm">
                                        <table>
                                            <tr>
                                                <td>Quantity</td>
                                                <td>:<input type="number" value="1" min="1" max="5" step="1" required><br></td>
                                            </tr>
                                            <tr>
                                                <td>Size[EU] </td>
                                                <td>:
                                                    <select name="size" id="size" onchange="document.getElementById(\'AddToCartButton\').removeAttribute(\'disabled\');" required>
                                                        <option value="none" selected hidden>Select Size</option>
                                                        <option value="38">38</option>
                                                        <option value="39">39</option>
                                                        <option value="40">40</option>
                                                        <option value="41">41</option>
                                                        <option value="42">42</option>
                                                        <option value="43">43</option>
                                                        <option value="44">44</option>
                                                        <option value="45">45</option>
                                                        <option value="46">46</option>
                                                        <option value="47">47</option>
                                                        <option value="48">48</option>
                                                        <option value="49">49</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Price wihout taxes</td>
                                                <td>:<input 
                                                        type="text" 
                                                        placeholder=" Euro(€)" 
                                                        id="priceWOTax" 
                                                        value="' . $product_data['price'] . ' €" 
                                                        disabled></td>
                                            </tr>
                                            <tr>
                                                <td>Price with Taxes</td>
                                                <td>:<label id="product_price"></label></td>
                                            </tr>
                                            <tr>
                                                <td>Currency</td>
                                                <td>:
                                                    <select id="currencySelect" onchange="convertCurrency()">
                                                        <option value="EUR" selected>Euro (€)</option>
                                                        <option value="USD">US Dollar ($)</option>
                                                        <option value="GBP">British Pound (£)</option>
                                                        <option value="INR">Indian Rupee (₹)</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Converted Price</td>
                                                <td>:<label id="convertedPrice">--</label></td>
                                            </tr>
                                        </table>
                                        ', $label, '
                                        <button type="submit" id="AddToCartButton" onclick="addToCart(
                                                     \'' . addslashes($product_data['pid']) . '\',
                                                     \'' . addslashes($product_data['name']). '\',
                                                     \''. addslashes($product_data['price']). '\',
                                                     \''. addslashes($product_data['img_path_1']). '\')" 
                                                     disabled >Add to Cart</button>
                                        <script>
                                            getTotalPrice(document.getElementById("priceWOTax").value);
                                        </script>
                                    </form>
                                </td>
                            </tr>
                        </table>
                    ';
            } else {
                echo "<h3>Product Not Found! <br> Please <a href='categories.php' class='loginLink'>Go Back</a> to select a product.</h3>";
            }
        } else {
            // pid attribute missing!
            $products = json_decode(file_get_contents('json/products.json'), true);
            echo '
                <h2>Our Catalog</h2>
                <table>
            ';

            foreach ($products as $product) {
                // display all the products
                    echo '
                        <tr class="CatalogRow" onclick="window.location.href=\'products.php?pid='.$product["pid"].'\'">
                            <td class="CatalogImg"><button onclick="window.location.href=\'products.php?pid='.$product["pid"].'\'"><img src="'.$product["img_path_1"].'"></button></td>
                            <td class="CatalogInfo"><span>'.$product["name"].'</td>
                        </tr>
                    ';
                }

                echo '
                </table>
            ';
            }
        ?>
    </div>

    <script>
    // Function to add product to the cart
    function addToCart(productId, productName, productPrice, productImage) {
        const size = document.getElementById("size").value;
        const quantity = document.querySelector("input[type='number']").value;

        if (size === "none") {
            alert("Please select a size before adding to the cart!");
            return;
        }

        // Create product object
        const product = {
            id: productId,
            name: productName,
            price: parseFloat(productPrice),
            size: size,
            quantity: parseInt(quantity),
            image: productImage
        };

        // Retrieve cart from localStorage or initialize it
        let cart = JSON.parse(localStorage.getItem("cart")) || [];

        // Check if the product is already in the cart
        const existingProductIndex = cart.findIndex(
            (item) => item.id === productId && item.size === size
        );

        if (existingProductIndex > -1) {
            // If the product already exists, increase its quantity
            cart[existingProductIndex].quantity += parseInt(quantity);
        } else {
            // Add the product to the cart
            cart.push(product);
        }

        // Save cart back to localStorage
        localStorage.setItem("cart", JSON.stringify(cart));
        
    }
</script>

</body>

</html>