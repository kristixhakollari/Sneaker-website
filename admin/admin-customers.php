<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        StepX | Admin
    </title>
    <link rel="stylesheet" href="../styles/mystyles.css">
    <link rel="icon" href="../img/icon.png">
    <script src="../js/global.js"></script>
    <style>
        .TableForOrders {
            width: 70%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .TableForOrders th,
        .TableForOrders td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .TableForOrders th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body class="admin-customers">
    <div class="BackgroundImage"></div> <!-- Background image container -->
    <div class="Navigation" id="navbar">
        <h1><a href="../index.php">StepX</a></h1>
        <nav class="ClassForNav">
            <table class="TableForNav">
                <tr>
                    <td><a href="../logout.php">Logout</a></td>
                    <td><a href="admin-orders.php">Orders</a></td>
                </tr>
            </table>
        </nav>
    </div>

    <?php
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "stepx_database";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    // Check for the POST
    if (isset($_POST['blockBtn']) || isset($_POST['unblockBtn'])) {
        $customer_name = $_POST['customer_name'];

        // Check which button was pressed
        $blocked_status = isset($_POST['blockBtn']) ? 1 : 0;

        // Update the blocked status in the database
        $sql = "UPDATE customer_info SET blocked_status = ? WHERE customer_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $blocked_status, $customer_name);

        if ($stmt->execute()) {
            $status = $blocked_status ? 'blocked' : 'unblocked';
            echo "<script>alert('Customer $customer_name has been $status successfully.');</script>";
        } else {
            echo "<script>alert('Failed to update customer status.');</script>";
        }

        $stmt->close();
    }
    ?>

    <div class="BoxForContents" id="box">
        <h2>Customer Management</h2>
        <table class="TableForOrders" style="width:100%!important">
            <tr>
                <th>Customer Name</th>
                <th>Password</th>
                <th>isBlocked?</th>
                <th>Block/Unblock?</th>
                <th>Order Count</th>
                <th>isAdmin?</th>
            </tr>
            <?php
            // Fetch customers
            $sql = "SELECT * FROM customer_info";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['customer_name']}</td>";
                    echo "<td>{$row['password']}</td>";

                    // Check blocked status
                    if ($row["blocked_status"] == 0) {
                        echo "<td>No</td>";
                        echo "<td>
                            <form action='admin-customers.php' method='POST' style='display:inline;'>
                                <input type='hidden' name='customer_name' value='{$row['customer_name']}'>
                                <button type='submit' name='blockBtn' class='inputButton'>Block</button>
                            </form>
                          </td>";
                    } else {
                        echo "<td>Yes</td>";
                        echo "<td>
                            <form action='admin-customers.php' method='POST' style='display:inline;'>
                                <input type='hidden' name='customer_name' value='{$row['customer_name']}'>
                                <button type='submit' name='unblockBtn' class='inputButton'>Unblock</button>
                            </form>
                          </td>";
                    }

                    echo "<td>{$row['order_no']}</td>";

                    // Check admin status
                    echo $row["isAdmin"] == 0 ? "<td>No</td>" : "<td>Yes</td>";

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No Customers Found!</td></tr>";
            }
            ?>
        </table>
    </div>

    <?php $conn->close(); ?>
</body>

</html>