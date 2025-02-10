<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        StepX | Cart
    </title>
    <link rel="stylesheet" href="styles/mystyles.css">
    <link rel="icon" href="img/icon.png">
    <!--<script src="js/global.js"></script>-->
    <?php session_start(); ?>
    <script>
        // Function to load cart from localStorage and display it
        function loadCart() {
            const cartTableBody = document.querySelector(".TableForCart table tbody");
            const totalPriceElement = document.getElementById("totalPrice");
            const deliveryCostElement = document.getElementById("deliveryCost");
            const zipCodeInput = document.getElementById("zipCode");
            let cart = JSON.parse(localStorage.getItem("cart")) || [];
            let total = 0;
            let totalWeight = 0;
            let deliveryCost = 0;

            // Clear existing rows
            cartTableBody.innerHTML = "";

            // Populate the table with cart data
            cart.forEach((product, index) => {
                const subtotal = product.price * product.quantity;
                total += subtotal;
                totalWeight += product.weight * product.quantity; // Add weight for delivery calculation

                // Add a new row for each product
                cartTableBody.innerHTML += `
                    <tr id="row${index}">
                        <td class="CatalogImg">
                            <img src="${product.image}" alt="${product.name}" style="width: 60px;">
                        </td>
                        <td>${product.name} (Size: ${product.size})</td>
                        <td>
                            <button onclick="changeQuantity(${index}, -1)">-</button>
                            <input type="number" id="qty-${index}" value="${product.quantity}" min="1" disabled>
                            <button onclick="changeQuantity(${index}, 1)">+</button>
                        </td>
                        <td>$${product.price.toFixed(2)}</td>
                        <td id="subtotal-${index}" class="subtotal">$${subtotal.toFixed(2)}</td>
                        <td>
                            <button onclick="removeItem(${index})">
                                <img src="img/delete-button.svg.svg" class="trash-icon">
                            </button>
                        </td>
                    </tr>
                `;
            });

            // Calculate delivery cost based on weight and location (ZIP Code)
            if (zipCodeInput.value) {
                // Example delivery cost based on weight
                if (totalWeight < 5) {
                    deliveryCost = 5; // for lighter carts
                } else if (totalWeight < 10) {
                    deliveryCost = 10; // for medium carts
                } else {
                    deliveryCost = 15; // for heavier carts
                }

                // Discount/free shipping for orders over a certain amount (e.g., $100)
                if (total >= 100) {
                    deliveryCost = 0; // Free delivery
                }
            }

            // Update the displayed total price and delivery cost
            totalPriceElement.textContent = `Total: $${total.toFixed(2)}`;
            deliveryCostElement.textContent = `Delivery: $${deliveryCost.toFixed(2)}`;
        }

        // Function to change product quantity
        function changeQuantity(index, delta) {
            let cart = JSON.parse(localStorage.getItem("cart")) || [];
            if (cart[index]) {
                cart[index].quantity += delta;
                if (cart[index].quantity <= 0) cart[index].quantity = 1; // Prevent quantity < 1
            }
            localStorage.setItem("cart", JSON.stringify(cart));
            loadCart(); // Reload the cart
        }

        // Function to remove an item from the cart
        function removeItem(index) {
            let cart = JSON.parse(localStorage.getItem("cart")) || [];
            cart.splice(index, 1); // Remove item at the specified index
            localStorage.setItem("cart", JSON.stringify(cart));
            loadCart(); // Reload the cart
        }

        // Load cart when the page loads
        window.onload = loadCart;

    </script>
</head>

<body class="CartBody">
    <div class="BackgroundImage"></div> <!-- Background image container -->
    <div class="Navigation" id="navbar">
        <h1><a href="index.php">StepX</a></h1>
        <nav class="ClassForNav">
            <?php include "nav.php"; ?>
        </nav>
    </div>

    <div class="BoxForContents" id="box">
        <h1>Proceed to checkout?</h1>
        <div class="TableForCart">
            <form action="cart.php" method="post">
            <table>
                <tbody>
                    <!-- Cart items will be dynamically generated here -->
                </tbody>
            </table>
            <p id="totalPrice">Total: $110.00</p>
            <?php
            $discountLabel = "";
            if (!isset($_SESSION['isLoggedin'])) {
                // do nothing, no discount
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    echo "<script>window.location.href = 'checkout.php';</script>";
                }
            } else {
                // Check if user is logged in
                if ($_SESSION['isLoggedin'] === true) {
                    // Database connection
                    $servername = "localhost";
                    $user = "root";
                    $password = "";
                    $dbname = "stepx_database";

                    $conn = new mysqli($servername, $user, $password, $dbname);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $username = $_SESSION['username'];
                    if ($_SERVER["REQUEST_METHOD"] == "POST"){
                        $conn->query("UPDATE customer_info SET order_no = order_no + 1 WHERE customer_name = '$username';");
                        $conn->query("INSERT INTO `order_info` (`customer_name`, `order_state`) VALUES ('$username', 'new');");
                        echo '<script>alert(\'your order sent successfully\');</script>';
                    }


                    // Basic query to check credentials
                    $sql = "SELECT order_no FROM customer_info WHERE customer_name = '$username'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        if ($row['order_no'] == 10) {
                            $discountLabel = '<p style="color: Green">You get 10% discount when you checkout</p>';
                        } else if ($row['order_no'] == 20) {
                            $discountLabel = '<p style="color: Green">You get 20% discount when you checkout</p>';
                    }
                } else {
                    // do nothing, no discount
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        echo "<script>window.location.href = 'checkout.php';</script>";
                    }
                }
                echo $discountLabel;
            }
        }
            ?>
            <!-- Delivery cost section -->
            <div>
                <label for="zipCode">Enter ZIP Code:</label>
                <input type="text" id="zipCode" placeholder="ZIP Code">
                <p id="deliveryCost">Delivery: $10.00</p>
            </div>

            <button class="inputButton" type="submit" id="checkout">Checkout</button>
            </form>
        </div>
    </div>
    <?php $conn->close(); ?>
</body>

</html>