<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        StepX | Your Orders
    </title>
    <link rel="stylesheet" href="styles/mystyles.css">
    <link rel="icon" href="img/icon.png">
    <script src="js/global.js"></script>
    <style>
        .TableForOrders {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .TableForOrders th, .TableForOrders td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .TableForOrders th {
            background-color: #f2f2f2;
        }
    </style>
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
        <h2>Your Orders</h2>
        <table class="TableForOrders">
            <tr>
                <th>Order Id</th>
                <th>Order state</th>
            </tr>
            <?php
                // Database connection
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "stepx_database";
                $customer_name = "harmishtanna";

                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch orders
                $sql = "SELECT order_id, order_state FROM order_info WHERE customer_name = '$customer_name'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>", $row['order_id'],"</td>";
                        echo "<td>", $row["order_state"], "</td>";
                        echo "</tr>";
                }
            } else {
                echo "No Orders Found!";
            }
                
            ?>
            <?php $conn->close(); ?>
        </table>
    </div>
</body>
</html>